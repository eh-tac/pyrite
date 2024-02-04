import { Config } from "@stencil/core";
import { sass } from "@stencil/sass";

export const config: Config = {
  namespace: "pyrite",
  outputTargets: [
    {
      type: "www",
      dir: "../../../../pages/js/pyrite",
      serviceWorker: null // disable service workers
    },
    {
      type: "dist",
      dir: "/mnt/c/Users/pickl/projects/ehbl/src/assets/pyrite"
    }
  ],
  globalScript: "src/global/app.ts",
  globalStyle: "src/assets/bulmatc.css",
  plugins: [sass()],
  hashFileNames: false
};
