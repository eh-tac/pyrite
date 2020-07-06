import { Struct } from "./struct";
import * as fs from "fs";
import * as nodePath from "path";
import { PyriteGenerator } from "./generator";
import { Constants } from "./constants";

export abstract class PyriteWriter {
  constructor(public rootDir: string, public generator: PyriteGenerator) {}

  public buildPath(path: string): string {
    return `${this.rootDir}/${path.replace("PLT", this.generator.platform)}`;
  }

  public write(): this {
    this.writeConstants(Object.values(this.generator.constants));
    const structs = Object.values(this.generator.structs);
    structs.forEach((s: Struct) => {
      this.writeStruct(s);
    });

    return this;
  }

  public abstract writeConstants(constants: Constants[]): void;

  public writeStruct(struct: Struct): void {
    this.writeBaseModel(struct);
    this.writeImplModel(struct);
  }

  public abstract writeBaseModel(struct: Struct): void;

  public abstract writeImplModel(struct: Struct): void;

  public writeFile(path: string, contents: string) {
    path = this.buildPath(path);
    console.log("writing to ", path);

    const dir = nodePath.dirname(path);
    if (!fs.existsSync(dir)) {
      fs.mkdirSync(dir, { recursive: true });
    }

    fs.writeFileSync(path, contents, {});
  }

  protected baseClass(className: string): string {
    return `${className}Base`;
  }

  protected filename(className: string): string {
    return className.toLowerCase();
  }
}

export function camelToKebab(camel: string): string {
  const c = camel.length;
  camel += "?";
  const upper = camel.toUpperCase();
  const lower = camel.toLowerCase();

  let kebab = lower[0];
  for (let i = 1; i < c; i++) {
    const l = i - 1; // last index
    const n = i + 1; // next index

    const wasUp = upper[l] === camel[l];
    const wasLo = lower[l] === camel[l];
    const nowUp = upper[i] === camel[i];
    const nxtLo = lower[n] === camel[n] && camel[n] !== "?";

    if (wasLo && nowUp) {
      kebab += "-";
    } else if (wasUp && nowUp && nxtLo) {
      kebab += "-";
    }
    kebab += lower[i];
  }

  return kebab;
}
