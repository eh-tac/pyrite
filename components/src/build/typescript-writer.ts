import { PyriteWriter } from "./writer";
import { Constants } from "./constants";
import { Struct } from "./struct";
import { PropInt } from "./prop";
import * as lodash from "lodash";
import { TypeScriptPropWriter } from "./typescript-prop-writer";

export class TypeScriptWriter extends PyriteWriter {
  public write(): this {
    super.write();

    const modelIndex: string[] = [`export { Constants } from './constants';`];
    const contrIndex: string[] = [];
    const plt = this.generator.platform;
    Object.values(this.generator.structs).forEach((s: Struct) => {
      const kebab = lodash.kebabCase(s.name);
      modelIndex.push(`export { ${s.name} } from "./${kebab}";`);
      contrIndex.push(`export { ${plt}${s.name.replace(plt, "")}Controller } from "./${kebab}";`);
    });

    this.writeFile("model/PLT/index.ts", modelIndex.join("\n"));
    this.writeFile("controllers/PLT/index.ts", contrIndex.join("\n"));
    this.copyFile("byteable.ts");
    this.copyFile("pyrite-base.ts");
    this.copyFile("hex.ts");
    this.copyFile("controller-base.ts");

    return this;
  }

  public writeConstants(constants: Constants[]): void {
    const lines = [`export class Constants {`];
    const enums: string[] = [];

    for (const constant of constants) {
      lines.push(`  public static ${constant.name.toUpperCase()} = {`);
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
      enums.push("}\n");
    }

    lines.push("}\n");
    lines.push(...enums);
    this.writeFile("model/PLT/constants.ts", lines.join("\n"));
  }

  public writeStruct(struct: Struct): void {
    super.writeStruct(struct);
    const props = struct.getProps().map(p => new TypeScriptPropWriter(p));
    this.writeComponent(struct, props);
    this.writeController(struct, props);
  }

  public writeBaseModel(struct: Struct): void {
    const baseName = this.baseClass(struct.name);

    const props = struct.getProps().map(p => new TypeScriptPropWriter(p));
    const enums = props.filter((p: TypeScriptPropWriter) => p.prop.isEnum);
    let lengthProp = new TypeScriptPropWriter(new PropInt("", `${struct.name}Length`, "INT"));
    if (!struct.isVariableLength) {
      lengthProp.prop.name = lengthProp.prop.name.toUpperCase();
      lengthProp.prop.reservedValue = struct.size;
    }

    const content = `${this.getBaseClassImports(props)}
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class ${baseName} extends PyriteBase implements Byteable {
  ${lengthProp.propertyDeclaration}
  ${props.map((p: TypeScriptPropWriter): string => p.propertyDeclaration).join("\n  ")}
  ${this.getBaseConstructor(struct, lengthProp)}
  ${this.baseJSON(props)}
  ${this.baseHexString(props)}
  ${enums.map((p: TypeScriptPropWriter): string => p.enumLookupFunction).join("\n")}
  ${struct.functionStubs.map((f: string): string => this.abstractFunction(f)).join("\n")}
  public getLength(): number {
    return this.${lengthProp.prop.name};
  }
}`;
    this.writeFile(`model/PLT/base/${this.filename(baseName)}`, content);
  }

  public writeImplModel(struct: Struct): void {
    const baseClass = this.baseClass(struct.name);
    const baseFile = lodash.kebabCase(baseClass);

    let content = `import { ${baseClass} } from "./base/${baseFile}";
    
export class ${struct.name} extends ${baseClass} {

  public beforeConstruct(): void {}

  public toString(): string {
    return '';
  }

  ${struct.functionStubs.map((f: string): string => this.functionStub(f)).join("\n  ")}
}
`;

    const file = this.filename(struct.name);
    this.writeFile(`model/PLT/${file}`, content, false);
  }

  public writeController(struct: Struct, props: TypeScriptPropWriter[]): void {
    const fields: object = {};
    props.forEach((p: TypeScriptPropWriter) => {
      fields[p.prop.name] = p.getFieldProps(this.generator.constants, this.generator.platform);
    });

    const contents: string = `import { ControllerBase } from "../../controller-base";
import { ${struct.name} } from "../../model/${this.generator.platform}";

export class ${this.controllerName(struct)} extends ControllerBase {
  public readonly fields: object = ${JSON.stringify(fields)};

  constructor(public model: ${struct.name}){
    super(model);
  }
}`;

    this.writeFile(`controllers/PLT/${this.filename(struct.name)}`, contents);
  }

  public writeComponent(struct: Struct, props: TypeScriptPropWriter[]): void {
    const kebab = lodash.kebabCase(struct.name);

    const scssFile = `${kebab}.scss`;
    this.writeFile(`components/PLT/${kebab}/${scssFile}`, "", false);

    const plt = this.generator.platform;
    const tag = `pyrite-${plt}-${kebab.replace(plt, "")}`.toLowerCase();
    const lName = struct.name.toLowerCase();
    const cName = this.controllerName(struct);

    const compName = `${plt}${struct.name.replace(plt, "")}Component`;

    const contents: string = `import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { ${struct.name} } from "../../../model/${plt}";
import { ${cName} } from "../../../controllers/${plt}";
import { Field } from "../../fields/field";

@Component({
  tag: "${tag}",
  styleUrl: "${scssFile}",
  shadow: false
})
export class ${compName} {
  @Element() public el: HTMLElement;
  @Prop() public ${lName}: ${struct.name};

  private controller: ${cName};

  public componentWillLoad(): void {
    this.controller = new ${cName}(this.${lName});
  }

  public render(): JSX.Element {
    return (
      <Host>
        ${props
          .map((p: TypeScriptPropWriter) => `<Field {...this.controller.getProps('${p.prop.name}')} />`)
          .join("\n        ")}
      </Host>
    )
  }
}
  `;
    const file = this.filename(struct.name);
    this.writeFile(`components/PLT/${kebab}/${file}x`, contents, false);
  }

  protected getBaseClassImports(props: TypeScriptPropWriter[]): string {
    const importLines: [string[], string][] = [
      [["Byteable"], "../../../byteable"],
      [["IMission", "PyriteBase"], "../../../pyrite-base"]
    ];

    const usedHexImports = [];
    const usedClassImports = [];
    let useConstants: boolean = false;
    props.forEach((p: TypeScriptPropWriter): void => {
      usedHexImports.push(...p.hexImports);
      usedClassImports.push(...p.classImports);
      useConstants = useConstants || !!p.prop.enumName;
    });

    if (useConstants) {
      importLines.push([["Constants"], "../constants"]);
    }

    const hex = Array.from(new Set(usedHexImports));
    importLines.push([hex, "../../../hex"]);

    const classes = Array.from(new Set(usedClassImports));
    classes.forEach((c: string) => {
      importLines.push([[c], `../${lodash.kebabCase(c)}`]);
    });

    return importLines
      .sort()
      .map(([imports, path]): string => `import { ${imports.sort().join(", ")} } from "${path}";`)
      .join("\n");
  }

  protected getBaseConstructor(struct: Struct, lengthProp: TypeScriptPropWriter): string {
    const props = struct.getProps().map(p => new TypeScriptPropWriter(p));

    return `
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    ${props.map((p: TypeScriptPropWriter) => p.getConstructorInit()).join("\n    ")}
    ${struct.isVariableLength ? `this.${lengthProp.prop.name} = offset;` : ""}
  }`;
  }

  protected baseJSON(props: TypeScriptPropWriter[]): string {
    const nonStatics = props.filter(p => !p.prop.isStatic);
    return `
  public toJSON(): object {
    return {
      ${nonStatics.map((p: TypeScriptPropWriter) => `${p.prop.name}: this.${p.labelExpr}`).join(",\n      ")}
    };
  }`;
  }

  protected baseHexString(props: TypeScriptPropWriter[]): string {
    return `
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    ${props.map((p: TypeScriptPropWriter) => p.getOutputHex()).join("\n    ")}

    return hex;
  }`;
  }

  protected abstractFunction(name: string): string {
    return `protected abstract ${name.replace("()", "")}();`;
  }

  protected functionStub(name: string): string {
    return `protected ${name.replace("()", "")}(): number {
    return 0;
  }`;
  }

  protected filename(className: string): string {
    return `${lodash.kebabCase(className)}.ts`;
  }

  private controllerName(struct: Struct): string {
    const plt = this.generator.platform;
    return `${plt}${struct.name.replace(plt, "")}Controller`;
  }

  private getEnumName(label: string): string {
    let clean = label
      .replace("%", "Percent")
      .replace("&", "n")
      .replace(/[^\w\s]/g, "");
    if (!isNaN(parseInt(clean[0], 10))) {
      clean = `n${clean}`;
    }
    return lodash.camelCase(clean);
  }
}
