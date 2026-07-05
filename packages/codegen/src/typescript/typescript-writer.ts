import { spawnSync } from 'node:child_process';

import { camelCase, kebabCase } from 'lodash-es';

import type { Constants } from '../constants';
import type { PyriteGenerator } from '../generator';
import { PropInt } from '../prop';
import type { Struct } from '../struct';
import { PyriteWriter } from '../writer';
import { TypeScriptPropWriter as PropWriter } from './typescript-prop-writer';

export class TypeScriptWriter extends PyriteWriter {
  constructor(
    public rootDir: string,
    public generator: PyriteGenerator,
    public shouldOverwriteIfExists = false
  ) {
    super(rootDir, generator, shouldOverwriteIfExists);
    this.language = 'TypeScript';
    this.platformDir = this.generator.platform.toLowerCase();
  }

  public write(): this {
    super.write();

    const modelIndex: string[] = [`export { Constants } from './constants';`];
    Object.values(this.generator.structs).forEach((s: Struct) => {
      const kebab = kebabCase(s.name);
      modelIndex.push(`export { ${s.name} } from "./${kebab}";`);
    });

    this.writeFile('PLT/src/index.ts', modelIndex.join('\n'));

    spawnSync('npm', ['run', 'format:write'], { cwd: this.buildPath('PLT') });

    return this;
  }

  public writeConstants(constants: Constants[]): void {
    const lines = [`export class Constants {`];
    const enums: string[] = [];

    for (const constant of constants) {
      lines.push(
        `  public static ${constant.name.toUpperCase()}: Record<${constant.name}, string>  = {`
      );
      enums.push(`export enum ${constant.name} {`);
      let used = new Set<string>();
      for (const [value, label] of constant.values) {
        lines.push(`    ${value}: "${label}",`);

        let eName = this.getEnumName(label);
        if (used.has(eName)) {
          eName = `// duplicate ${eName}`;
        } else {
          used.add(eName);
        }
        enums.push(`  ${eName} = ${value},`);
      }
      lines.push(`  };\n`);
      enums.push('}\n');
    }

    lines.push('}\n', ...enums);
    this.writeFile('PLT/src/constants.ts', lines.join('\n'));
  }

  public writeBaseModel(struct: Struct): void {
    const baseName = this.baseClass(struct.name);

    const props = struct.getProps().map((p) => new PropWriter(p));
    const enums = props.filter((p: PropWriter) => p.prop.isEnum);
    let lengthProp = new PropWriter(new PropInt('', `${struct.name}Length`, 'INT'));
    if (!struct.isVariableLength) {
      lengthProp.prop.name = lengthProp.prop.name.toUpperCase();
      lengthProp.prop.reservedValue = struct.size;
    }

    const content = `${this.getBaseClassImports(props)}
export abstract class ${baseName} extends PyriteBase implements Byteable {
  ${lengthProp.propertyDeclaration}
  ${props.map((p: PropWriter): string => p.propertyDeclaration).join('\n  ')}
  ${this.getBaseConstructor(struct, lengthProp)}
  ${this.baseJSON(props)}
  ${this.baseHexOutput(props)}
  ${enums.map((p: PropWriter): string => p.enumLookupFunction).join('\n')}
  ${struct.functionStubs.map((f: string): string => this.abstractFunction(f)).join('\n  ')}
  public getLength(): number {
    return this.${lengthProp.prop.name};
  }
}`;
    this.writeFile(`PLT/src/base/${this.filename(baseName)}`, content);
  }

  public writeImplModel(struct: Struct): void {
    const baseClass = this.baseClass(struct.name);
    const baseFile = kebabCase(baseClass);

    let content = `import { ${baseClass} } from "./base/${baseFile}";
    
export class ${struct.name} extends ${baseClass} {

  public beforeConstruct(): void {}

  public toString(): string {
    return '';
  }

  ${struct.functionStubs.map((f: string): string => this.functionStub(f)).join('\n  ')}
}
`;

    const file = this.filename(struct.name);
    this.writeFile(`PLT/src/${file}`, content, false);
  }

  protected getBaseClassImports(props: PropWriter[]): string {
    const importLines: [string[], string][] = [
      [['Byteable', 'IMission', 'PyriteBase'], '@pyrite/core']
    ];

    const usedHexImports: string[] = [];
    const usedClassImports: string[] = [];
    const usedConstants: Set<string> = new Set<string>();
    props.forEach((p: PropWriter): void => {
      usedHexImports.push(...p.hexImports);
      usedClassImports.push(...p.classImports);
      if (p.prop.enumName) {
        usedConstants.add(p.prop.enumName);
      }
    });

    if (usedConstants.size > 0) {
      importLines.push([['Constants', ...usedConstants], '../constants']);
    }

    const hex = [...new Set(usedHexImports)];
    importLines.push([hex, '@pyrite/core']);

    const classes = [...new Set(usedClassImports)];
    classes.forEach((c: string) => {
      importLines.push([[c], `../${kebabCase(c)}`]);
    });

    return importLines
      .sort()
      .map(([imports, path]): string => `import { ${imports.sort().join(', ')} } from "${path}";`)
      .join('\n');
  }

  protected getBaseConstructor(struct: Struct, lengthProp: PropWriter): string {
    const props = struct.getProps().map((p) => new PropWriter(p));

    // in the constructor we also need to get the offset for the final length prop,
    // so we also check if its not fixed length to catch when the last property is dynamic
    const needsOffset = props.some((p) => p.needsOffset || !p.prop.isFixedLength);

    return `
  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    ${needsOffset ? 'let offset = 0;' : ''}    

    ${props.map((p: PropWriter) => p.getConstructorInit()).join('\n    ')}
    ${struct.isVariableLength ? `this.${lengthProp.prop.name} = ${needsOffset ? 'offset;' : '0; // implement in child class'};` : ''}
  }`;
  }

  protected baseJSON(props: PropWriter[]): string {
    const nonStatics = props.filter((p) => !p.prop.isStatic);
    return `
  public toJSON(): Record<string, unknown> | string {
    return {
      ${nonStatics.map((p: PropWriter) => `${p.prop.name}: this.${p.toJSONExpr}`).join(',\n      ')},
    };
  }`;
  }

  protected baseHexOutput(props: PropWriter[]): string {
    const needsOffset = props.some((p) => p.needsOffset);

    return `
  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    ${needsOffset ? 'let offset = 0;' : ''}

    ${props.map((p: PropWriter) => p.getOutputHex()).join('\n    ')}

    return hex;
  }`;
  }

  protected abstractFunction(name: string): string {
    return `protected abstract ${name.replace('()', '')}(): number;`;
  }

  protected functionStub(name: string): string {
    return `protected ${name.replace('()', '')}(): number {
    return 0;
  }`;
  }

  protected filename(className: string): string {
    return `${kebabCase(className)}.ts`;
  }

  private getEnumName(label: string): string {
    let clean = label
      .replace('%', 'Percent')
      .replace('&', 'n')
      .replaceAll(/[^\w\s]/g, '');
    if (!Number.isNaN(Number(clean[0]))) {
      clean = `n${clean}`;
    }
    return camelCase(clean);
  }
}
