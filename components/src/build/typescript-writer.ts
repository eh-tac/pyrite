import { PyriteWriter, camelToKebab } from "./writer";
import { Constants } from "./constants";
import { Struct } from "./struct";
import { Prop, PropInt } from "./prop";

export class TypeScriptWriter extends PyriteWriter {
  public write(): this {
    super.write();

    const modelIndex: string[] = [];
    const contrIndex: string[] = [];
    Object.values(this.generator.structs).forEach((s: Struct) => {
      const kebab = camelToKebab(s.name);
      modelIndex.push(`export { ${s.name} } from "./${kebab}";`);
      contrIndex.push(`export { ${this.generator.platform}${s.name}Controller } from "./${kebab}";`);
    });

    this.writeFile("model/PLT/index.ts", modelIndex.join("\n"));
    this.writeFile("controllers/PLT/index.ts", contrIndex.join("\n"));

    return this;
  }

  public writeConstants(constants: Constants[]): void {
    const lines = [`export class Constants {`];
    for (const constant of constants) {
      lines.push(`  public static ${constant.name.toUpperCase()} = {`);
      for (const [value, label] of constant.values) {
        lines.push(`    ${value}: "${label}",`);
      }
      lines.push(`  };\n`);
    }

    lines.push("}");
    this.writeFile("model/PLT/constants.ts", lines.join("\n"));
  }

  public writeStruct(struct: Struct): void {
    super.writeStruct(struct);
    this.writeComponent(struct);
    this.writeController(struct);
  }

  public writeBaseModel(struct: Struct): void {
    const file = this.filename(struct.name);
    const lines: string[] = [];

    // set up length property
    let lengthProp = new PropInt("", `${struct.name}Length`, "INT");
    if (!struct.isVariableLength) {
      lengthProp.name = lengthProp.name.toUpperCase();
      lengthProp.reservedValue = struct.size;
    }
    lines.push(this.initProp(lengthProp));

    lines.push(...struct.getProps().map((p: Prop): string => this.initProp(p)));

    lines.push(this.getBaseConstructor(struct));

    const enums = struct.getProps().filter((p: Prop) => p.isEnum);
    lines.push(...enums.map((p: Prop): string => this.enumLookup(p)));

    lines.push(...struct.functionStubs.map((f: string): string => this.abstractFunction(f)));

    // foreach prop , declare
    // add length prop
    // do contructor
    // do debug output
    // do function stubs
    // do output function

    const start = `import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class ${struct.name}Base extends PyriteBase implements Byteable {`;

    lines.unshift(start);
    lines.push("}\n");
    this.writeFile(`model/PLT/base/${file}`, lines.join("\n"));
  }

  public writeImplModel(struct: Struct): void {
    const baseClass = this.baseClass(struct.name);
    const baseFile = camelToKebab(baseClass);

    const content = `import { ${baseClass} } from "./base/${baseFile}";
    
    export class ${struct.name} extends ${baseClass} {
      constructor(hex: ArrayBuffer, tie?: Mission) {
        super(hex, tie);
      }

      public beforeConstruct(): void {}

      // TODO abstract stubs?
    }
    `;

    const file = this.filename(struct.name);
    this.writeFile(`model/PLT/${file}`, content);
  }

  public writeController(struct: Struct): void {
    const contents: string = `import { ${struct.name} } from "../../model/${this.generator.platform}";

export class ${this.controllerName(struct)} {
  public static fields: any[] = [];

  constructor(public model: ${struct.name}){}

  public render(field: string){}
}`;

    const file = this.filename(struct.name);
    this.writeFile(`controllers/${this.generator.platform}/${file}.ts`, contents);
  }

  public writeComponent(struct: Struct): void {
    const kebab = camelToKebab(struct.name);

    const scssFile = `${kebab}.scss`;
    this.writeFile(`components/PLT/${kebab}/${scssFile}`, "");

    const plt = this.generator.platform;
    const tag = `pyrite-${plt}-${kebab}`;
    const lName = struct.name.toLowerCase();
    const cName = this.controllerName(struct);

    const contents: string = `import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { ${struct.name} } from "../../../model/${plt}";
import { ${cName} } from "../../../controllers/${plt}";

@Component({
  tag: "${tag}",
  styleUrl: "${scssFile}",
  shadow: false
})
export class ${plt}${struct.name}Component {
  @Element() public el: HTMLElement;
  @Prop() public ${lName}: ${struct.name};

  private controller: ${this.controllerName(struct)};

  public componentWillLoad(): void {
    this.controller = new ${this.controllerName(struct)}(this.${lName});
  }

  public render(): JSX.Element {
    return (
      <Host>
      ${this.renderFields(struct.getProps())}        
      </Host>
    )
  }
}
  `;
    const file = this.filename(struct.name);
    this.writeFile(`components/PLT/${kebab}/${file}x`, contents);
  }

  protected getBaseConstructor(struct: Struct): string {
    return `
  constructor(hex: ArrayBuffer, tie?: any){
    super(hex, tie);
  }`;
  }

  protected initProp(prop: Prop): string {
    let type = this.tsType(prop);
    if (prop.isArray) {
      type = `${type}[]`;
    }

    let p = `${prop.name}: ${type}`;
    if (prop.isStatic) {
      p = `static ${p} = ${prop.reservedValue}`;
    }
    p = `  public ${p};`;
    if (prop.comment) {
      p = `${p} //${prop.comment}`;
    }
    return p;
  }

  protected propExpr(prop: Prop): string {
    return `this.${prop.name}`;
  }

  protected enumLookup(prop: Prop): string {
    const enumName = prop.enumName.toUpperCase();
    const index = this.propExpr(prop);

    return `
  public get ${prop.name}Label(): string {
    return Constants.${enumName}[${index}] || "Unknown";
  }`;
  }

  protected abstractFunction(name: string): string {
    return `  
  protected abstract ${name}();
`;
  }

  protected filename(className: string): string {
    return `${camelToKebab(className)}.ts`;
  }

  private controllerName(struct: Struct): string {
    return `${this.generator.platform}${struct.name}Controller`;
  }

  private renderFields(props: Prop[]): string {
    return props
      .map((p: Prop): string => {
        return `{this.controller.render("${p.name}")}`;
      })
      .join("\n      ");
  }

  private tsType(prop: Prop): string {
    if (["SHORT", "INT", "BYTE", "SBYTE"].includes(prop.type)) {
      return "number";
    } else if ("BOOL" === prop.type) {
      return "boolean";
    } else if (["STR", "CHAR"].includes(prop.type)) {
      return "string";
    }
    return prop.type;
  }
}
