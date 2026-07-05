import * as fs from 'node:fs';
import * as nodePath from 'node:path';

import type { Constants } from './constants';
import type { PyriteGenerator } from './generator';
import type { Struct } from './struct';

export abstract class PyriteWriter {
  protected language: string = 'TypeScript';
  protected platformDir: string = 'tmp';

  constructor(
    public rootDir: string,
    public generator: PyriteGenerator,
    public shouldOverwriteIfExists = false
  ) {}

  public get label(): string {
    return `${this.language}Writer for ${this.buildPath('PLT')}`;
  }

  public buildPath(path: string): string {
    return `${this.rootDir}/${path.replace('PLT', () => this.platformDir)}`;
  }

  public write(): this {
    this.writeConstants(Object.values(this.generator.constants));
    const structs = Object.values(this.generator.structs);
    for (const struct of structs) {
      this.writeStruct(struct);
    }

    return this;
  }

  public abstract writeConstants(constants: Constants[]): void;

  public writeStruct(struct: Struct): void {
    for (const prop of struct.getProps()) {
      prop.prepare(this.generator.structs);
    }
    this.writeBaseModel(struct);
    this.writeImplModel(struct);
  }

  public abstract writeBaseModel(struct: Struct): void;

  public abstract writeImplModel(struct: Struct): void;

  public writeFile(path: string, contents: string, shouldOverwriteIfExists: boolean = true) {
    path = this.buildPath(path);

    const dir = nodePath.dirname(path);
    if (!fs.existsSync(dir)) {
      fs.mkdirSync(dir, { recursive: true });
    }
    if (fs.existsSync(path) && !shouldOverwriteIfExists) {
      return;
    }

    fs.writeFileSync(path, contents, {});
  }

  public copyFile(path: string): void {
    const from = nodePath.join(__dirname, path);
    if (fs.existsSync(from)) {
      this.writeFile(path, fs.readFileSync(from, { encoding: 'utf8' }));
    }
  }

  protected baseClass(className: string): string {
    return `${className}Base`;
  }

  protected filename(className: string): string {
    return className.toLowerCase();
  }
}
