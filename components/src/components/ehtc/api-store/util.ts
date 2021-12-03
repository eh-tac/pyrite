export const ehtcAPI = (url: string): Promise<any> => {
  const store = document.querySelector("ehtc-api-store") as HTMLEhtcApiStoreElement;
  if (store) {
    console.log("found store!");
    return store.apiFetch(url);
  } else {
    console.log("no store");
    return fetch(url).then(r => r.json());
  }
};
