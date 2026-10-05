export const ehtcAPI = (url: string): Promise<any> => {
  const store = document.querySelector("ehtc-api-store") as HTMLEhtcApiStoreElement;
  return store ? store.apiFetch(url) : fetch(url).then((r) => r.json());
};
