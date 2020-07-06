import { Config } from "@stencil/core";
import { sass } from "@stencil/sass";

export const config: Config = {
  namespace: "pyrite",
  outputTargets: [
    {
      type: "dist"
    },
    {
      type: "docs-readme"
    },
    {
      type: "www",
      serviceWorker: null // disable service workers
    }
  ],
  globalScript: "src/global/app.ts",
  globalStyle: "src/assets/bulma.css",
  plugins: [sass()]
};
