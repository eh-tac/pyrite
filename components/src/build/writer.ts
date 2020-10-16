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
    struct.getProps().forEach(p => p.prepare(this.generator.structs));
    this.writeBaseModel(struct);
    this.writeImplModel(struct);
  }

  public abstract writeBaseModel(struct: Struct): void;

  public abstract writeImplModel(struct: Struct): void;

  public writeFile(path: string, contents: string, overwriteIfExists: boolean = true) {
    path = this.buildPath(path);

    const dir = nodePath.dirname(path);
    if (!fs.existsSync(dir)) {
      fs.mkdirSync(dir, { recursive: true });
    }
    if (fs.existsSync(path) && !overwriteIfExists) {
      return;
    }
    console.log("writing to", path);

    fs.writeFileSync(path, contents, {});
  }

  public copyFile(path: string): void {
    const from = nodePath.join(__dirname, path);
    if (fs.existsSync(from)) {
      this.writeFile(path, fs.readFileSync(from, { encoding: "UTF8" }));
    }
  }

  protected baseClass(className: string): string {
    return `${className}Base`;
  }

  protected filename(className: string): string {
    return className.toLowerCase();
  }
}
