import { camelCase, startCase } from 'lodash-es';

import type { Constants } from '../constants';
import type { PyriteGenerator } from '../generator';
import { PropInt } from '../prop';
import type { Struct } from '../struct';
import { PyriteWriter } from '../writer';
import { PHPPropWriter } from './php-prop-writer';

export class PHPWriter extends PyriteWriter {
  public constructor(
    rootDir: string,
    generator: PyriteGenerator,
    public namespace: string = 'Pyrite',
    public shouldOverwriteIfExists = false
  ) {
    super(rootDir, generator, shouldOverwriteIfExists);
    this.language = 'PHP';
    this.platformDir = this.generator.platform;
  }

  public writeConstants(constants: Constants[]): void {
    const lines = [
      `<?php
namespace ${this.namespace}\\${this.generator.platform};

class Constants
{`
    ];

    for (const constant of constants) {
      lines.push(`    public static array \$${constant.name.toUpperCase()} = [`);
      for (const [value, label] of constant.values) {
        lines.push(`        ${value} => "${label}",`);
      }
      lines.push(`    ];\n`);

      const seen = {};
      for (const [value, label] of constant.values) {
        let cleanLabel = this.getEnumName(label).toUpperCase();
        if (seen[cleanLabel]) {
          seen[cleanLabel]++;
          cleanLabel = `${cleanLabel}${seen[cleanLabel]}`;
        } else {
          seen[cleanLabel] = 1;
        }

        lines.push(`    public static \$${constant.name.toUpperCase()}_${cleanLabel} = ${value};`);
      }
      lines.push(``);
    }

    lines.push('}');
    this.writeFile('PLT/Constants.php', lines.join('\n'));
  }

  public writeBaseModel(struct: Struct): void {
    const baseName = this.baseClass(struct.name);
    const plt = this.generator.platform;

    const props = struct.getProps().map((p) => new PHPPropWriter(p));
    const enums = props.filter((p: PHPPropWriter) => p.prop.isEnum);
    let lengthProp = new PHPPropWriter(new PropInt('', `${struct.name}Length`, 'INT'));
    if (!struct.isVariableLength) {
      lengthProp.prop.name = lengthProp.prop.name.toUpperCase();
      lengthProp.prop.reservedValue = struct.size;
    }

    const content = `<?php

namespace ${this.namespace}\\${plt}\\Base;

${this.getBaseClassImports(props)}

abstract class ${baseName} extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    ${lengthProp.propertyDeclaration}
    ${props.map((p: PHPPropWriter): string => p.propertyDeclaration).join('\n    ')}
    ${this.getBaseConstructor(struct, lengthProp)}
    ${this.baseJSON(props)}
    ${this.baseHexString(props)}
    ${enums.map((p: PHPPropWriter): string => p.enumLookupFunction).join('\n')}
    ${struct.functionStubs.map((f: string): string => this.abstractFunction(f)).join('\n')}
    public function getLength(): int
    {
        return ${lengthProp.prop.isStatic ? 'self::' : '$this->'}${lengthProp.prop.name};
    }
}`;
    this.writeFile(`PLT/Base/${this.filename(baseName)}`, content);
  }

  public writeImplModel(struct: Struct): void {
    const baseClass = this.baseClass(struct.name);
    const plt = this.generator.platform;

    let content = `<?php
namespace ${this.namespace}\\${plt};

use Pyrite\\PyriteModel;
    
class ${struct.name} extends Base\\${baseClass}
{

    public static function fromHex(string $hex, ?PyriteModel $TIE = null): ${struct.name} {
      return (new ${struct.name}($hex, $TIE))->loadHex();
    }

    public function __toString(): string 
    {
      return '';
    }

    ${struct.functionStubs.map((f: string): string => this.functionStub(f)).join('\n  ')}
}
`;

    const file = this.filename(struct.name);
    this.writeFile(`PLT/${file}`, content, this.shouldOverwriteIfExists);
  }

  protected getBaseConstructor(struct: Struct, lengthProp: PHPPropWriter): string {
    const props = struct.getProps().map((p) => new PHPPropWriter(p));

    return `
    public function __construct(string $hex = null, ?PyriteModel $TIE = null)
    {
        parent::__construct($hex, $TIE);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex(): static
    {
        $hex = $this->hex;
        $offset = 0;

        ${props.map((p: PHPPropWriter) => p.getLoadHexInitializer()).join('\n        ')}
        ${struct.isVariableLength ? `$this->${lengthProp.prop.name} = $offset;` : ''}

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }`;
  }

  protected getBaseClassImports(props: PHPPropWriter[]): string {
    const imports: string[] = ['Byteable', 'HexDecoder', 'HexEncoder', 'PyriteBase', 'PyriteModel'];

    const usedClassImports = [];
    let isUseConstants: boolean = false;
    props.forEach((p: PHPPropWriter): void => {
      usedClassImports.push(...p.classImports);
      isUseConstants ||= !!p.prop.enumName;
    });
    const plt = this.generator.platform;

    if (isUseConstants) {
      imports.push(String.raw`${plt}\Constants`);
    }
    [...new Set(usedClassImports)].forEach((c: string) => {
      imports.push(`${plt}\\${c}`);
    });

    return imports
      .sort()
      .map((i) => `use Pyrite\\${i};`)
      .join('\n');
  }

  protected baseJSON(props: PHPPropWriter[]): string {
    const nonStatics = props.filter((p) => !p.prop.isStatic);
    return `
    public function __debugInfo(): array
    {
        return [
            ${nonStatics.map((p: PHPPropWriter) => `"${p.prop.name}" => $this->${p.labelExpr}`).join(',\n            ')}
        ];
    }`;
  }

  protected baseHexString(props: PHPPropWriter[]): string {
    return `
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        ${props.map((p: PHPPropWriter) => p.getOutputHex()).join('\n        ')}

        return $hex;
    }`;
  }

  protected abstractFunction(name: string): string {
    return `protected abstract function ${name.replace('()', '')}();`;
  }

  protected functionStub(name: string): string {
    return `protected function ${name.replace('()', '')}(): int 
    {
      return 0;
    }`;
  }

  protected filename(className: string): string {
    return `${startCase(className).replaceAll(' ', '')}.php`;
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
