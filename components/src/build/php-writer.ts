import { PyriteWriter } from "./writer";
import { Constants } from "./constants";

export class PHPWriter extends PyriteWriter {
  public writeConstants(constants: Constants[]): void {
    const lines = [
      `<?php
namespace Pyrite\\${this.generator.platform};

export class Constants {`
    ];

    for (const constant of constants) {
      lines.push(`  public static \$${constant.name.toUpperCase()} = [`);
      for (const [value, label] of constant.values) {
        lines.push(`    ${value} => "${label}",`);
      }
      lines.push(`  ];\n`);
    }

    lines.push("}");
    this.writeFile("Constants.php", lines.join("\n"));
  }

  public writeBaseModel(): void {}

  public writeImplModel(): void {}
}
