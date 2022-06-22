import { PyriteWriter } from "./writer";
import { Constants } from "./constants";
import { Struct } from "./struct";
import { PropInt } from "./prop";
import { PHPPropWriter } from "./php-prop-writer";
import * as lodash from "lodash";
import { PyriteGenerator } from "./generator";

export class PHPWriter extends PyriteWriter {
  public constructor(rootDir: string, generator: PyriteGenerator, public namespace: string = "Pyrite") {
    super(rootDir, generator);
  }
  public write(): this {
    super.write();

    // this.copyFile("byteable.ts");
    // this.copyFile("pyrite-base.ts");
    // this.copyFile("hex.ts");
    // this.copyFile("controller-base.ts");

    return this;
  }

  public writeConstants(constants: Constants[]): void {
    const lines = [
      `<?php
namespace ${this.namespace}\\${this.generator.platform};

class Constants
{`
    ];

    for (const constant of constants) {
      lines.push(`    public static \$${constant.name.toUpperCase()} = [`);
      for (const [value, label] of constant.values) {
        lines.push(`        ${value} => "${label}",`);
      }
      lines.push(`    ];\n`);
    }

    lines.push("}");
    this.writeFile("PLT/Constants.php", lines.join("\n"));
  }

  public writeBaseModel(struct: Struct): void {
    const baseName = this.baseClass(struct.name);
    const plt = this.generator.platform;

    const props = struct.getProps().map(p => new PHPPropWriter(p));
    const enums = props.filter((p: PHPPropWriter) => p.prop.isEnum);
    let lengthProp = new PHPPropWriter(new PropInt("", `${struct.name}Length`, "INT"));
    if (!struct.isVariableLength) {
      lengthProp.prop.name = lengthProp.prop.name.toUpperCase();
      lengthProp.prop.reservedValue = struct.size;
    }

    const content = `<?php

namespace ${this.namespace}\\${plt}\\Base;

${this.getBaseClassImports(props)}

abstract class ${baseName} extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    ${lengthProp.propertyDeclaration}
    ${props.map((p: PHPPropWriter): string => p.propertyDeclaration).join("\n    ")}
    ${this.getBaseConstructor(struct, lengthProp)}
    ${this.baseJSON(props)}
    ${this.baseHexString(props)}
    ${enums.map((p: PHPPropWriter): string => p.enumLookupFunction).join("\n")}
    ${struct.functionStubs.map((f: string): string => this.abstractFunction(f)).join("\n")}
    public function getLength()
    {
        return ${lengthProp.prop.isStatic ? "self::" : "$this->"}${lengthProp.prop.name};
    }
}`;
    this.writeFile(`PLT/Base/${this.filename(baseName)}`, content);
  }

  public writeImplModel(struct: Struct): void {
    const baseClass = this.baseClass(struct.name);
    const plt = this.generator.platform;

    let content = `<?php
namespace ${this.namespace}\\${plt};
    
class ${struct.name} extends Base\\${baseClass}
{

    public static function fromHex($hex, $tie = null) {
      return (new ${struct.name}($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    ${struct.functionStubs.map((f: string): string => this.functionStub(f)).join("\n  ")}
}
`;

    const file = this.filename(struct.name);
    this.writeFile(`PLT/${file}`, content, false);
  }

  protected getBaseConstructor(struct: Struct, lengthProp: PHPPropWriter): string {
    const props = struct.getProps().map(p => new PHPPropWriter(p));

    return `
    public function __construct($hex = null, $tie = null)
    {
        parent::__construct($hex, $tie);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex()
    {
        $hex = $this->hex;
        $offset = 0;

        ${props.map((p: PHPPropWriter) => p.getConstructorInit()).join("\n        ")}
        ${struct.isVariableLength ? `$this->${lengthProp.prop.name} = $offset;` : ""}
        return $this;
    }`;
  }

  protected getBaseClassImports(props: PHPPropWriter[]): string {
    const imports: string[] = ["Byteable", "HexDecoder", "HexEncoder", "PyriteBase"];

    const usedClassImports = [];
    let useConstants: boolean = false;
    props.forEach((p: PHPPropWriter): void => {
      usedClassImports.push(...p.classImports);
      useConstants = useConstants || !!p.prop.enumName;
    });
    const plt = this.generator.platform;

    if (useConstants) {
      imports.push(`${plt}\\Constants`);
    }
    Array.from(new Set(usedClassImports)).forEach((c: string) => {
      imports.push(`${plt}\\${c}`);
    });

    return imports
      .sort()
      .map(i => `use Pyrite\\${i};`)
      .join("\n");
  }

  protected baseJSON(props: PHPPropWriter[]): string {
    const nonStatics = props.filter(p => !p.prop.isStatic);
    return `
    public function __debugInfo()
    {
        return [
            ${nonStatics.map((p: PHPPropWriter) => `"${p.prop.name}" => $this->${p.labelExpr}`).join(",\n            ")}
        ];
    }`;
  }

  protected baseHexString(props: PHPPropWriter[]): string {
    return `
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        ${props.map((p: PHPPropWriter) => p.getOutputHex()).join("\n        ")}

        return $hex;
    }`;
  }

  protected abstractFunction(name: string): string {
    return `protected abstract function ${name.replace("()", "")}();`;
  }

  protected functionStub(name: string): string {
    return `protected function ${name.replace("()", "")}() 
    {
      return 0;
    }`;
  }

  protected filename(className: string): string {
    return `${lodash
      .startCase(className)
      .split(" ")
      .join("")}.php`;
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
