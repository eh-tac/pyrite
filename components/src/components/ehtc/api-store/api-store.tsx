import { JSX, Component, Prop, h, Element, State, Method, Event, EventEmitter } from "@stencil/core";

@Component({
  tag: "ehtc-api-store",
  shadow: true
})
export class ApiSelectComponent {
  @Element() el: HTMLElement;

  @Prop() domain: string = "";
  @Prop() cachePrefix: string = "pyrite";

  private etagCache: { [key: string]: string };
  private responseCache: { [key: string]: any };

  private requestQueue: [string, (value: any) => void][] = [];
  private verifiedUrls: Set<string> = new Set<string>();
  private processing = false;

  private get cacheKey(): string {
    return `${this.cachePrefix}-api-cache`;
  }

  @Method()
  public apiFetch(url: string): Promise<any> {
    // a component has requested an API endpoint.
    if (this.verifiedUrls.has(url)) {
      // we've seen this before. return the cached item
      return Promise.resolve(this.responseCache[url]);
    }
    // need to fetch this, or already being fetched.
    return new Promise((resolve, _reject) => {
      this.requestQueue.push([url, resolve]);
      this.processQueue();
    });
  }

  private processQueue(): void {
    if (this.processing) {
      return;
    }

    this.processing = true;
    if (this.requestQueue.length) {
      const [nextUrl, nextPromiseResolve] = this.requestQueue.shift();
      if (this.verifiedUrls.has(nextUrl)) {
        // we've seen this before. return the cached item
        nextPromiseResolve(this.responseCache[nextUrl]);
        this.processing = false;
        this.processQueue();
      } else {
        const headers = {};
        if (this.etagCache[nextUrl] && this.responseCache[nextUrl]) {
          headers["If-None-Match"] = this.etagCache[nextUrl];
        }
        let responseTag = "";

        fetch(nextUrl, { headers })
          .then((r: Response) => {
            if (r.status === 304) {
              // we have cached data and the server agreed with the etag we sent, so use the cached data
              return Promise.resolve(this.responseCache[nextUrl]);
            } else {
              responseTag = r.headers.get("ETag");
              return r.json();
            }
          })
          .then(d => {
            // whether from the cache or API response, we have the right data for this endpoint
            this.verifiedUrls.add(nextUrl);
            // this is new data to us, so save it
            if (responseTag) {
              this.etagCache[nextUrl] = responseTag;
              this.responseCache[nextUrl] = d;
              this.saveCache();
            }
            nextPromiseResolve(d);
            return Promise.resolve(d);
          })
          .then(d => {
            this.processing = false;
            this.processQueue();
          });
      }
    }
  }

  public componentWillLoad(): void {
    this.loadCache();
  }

  private loadCache(): void {
    this.etagCache = {};
    this.responseCache = {};
    const ls = localStorage.getItem(this.cacheKey);
    if (ls) {
      const data = JSON.parse(ls);
      this.etagCache = data.etag || {};
      this.responseCache = data.response || {};
    }
  }

  private saveCache(): void {
    const data = JSON.stringify({
      etag: this.etagCache,
      response: this.responseCache
    });
    localStorage.setItem(this.cacheKey, data);
  }
}
