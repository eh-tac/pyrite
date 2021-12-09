export const ehtcAPI = (url: string): Promise<any> => {
  const store = document.querySelector("ehtc-api-store") as HTMLEhtcApiStoreElement;
  if (store) {
    return store.apiFetch(url);
  } else {
    return fetch(url).then(r => r.json());
  }
};
