#!/usr/bin/env node

// copilot generated script to take the c struct definitions from the file from rando and convert them to the struct meta file used in pyrite

const fs = require("fs");
const path = require("path");

type Field = {
  rawType: string;
  name: string;
  arrayDims: number[];
};

type StructDef = {
  name: string;
  fields: Field[];
};

const TYPE_SIZE: Record<string, number> = {
  int: 4,
  "unsigned int": 4,
  DWORD: 4,
  DPID: 4,
  WORD: 2,
  short: 2,
  BYTE: 1,
  __int8: 1,
  char: 1,
  BOOL: 1
};

function usage(): never {
  console.error("Usage: node convert-wip-to-structs.ts [inputPath] [outputPath]");
  process.exit(1);
}

function parseStructs(source: string): StructDef[] {
  const clean = source.replace(/\/\*[\s\S]*?\*\//g, "").replace(/\/\/.*$/gm, "");
  const structs: StructDef[] = [];
  const structRegex = /struct\s+([A-Za-z_]\w*)\s*\{([\s\S]*?)\}\s*;?/g;

  let match: RegExpExecArray | null;
  while ((match = structRegex.exec(clean)) !== null) {
    const [, name, body] = match;
    const fields: Field[] = [];

    const lines = body
      .split("\n")
      .map(line => line.trim())
      .filter(line => line.length > 0);

    for (const line of lines) {
      if (!line.endsWith(";")) {
        continue;
      }

      const withoutSemicolon = line.slice(0, -1).trim();
      const fieldMatch = /^(.*?)\s+([A-Za-z_]\w*)((?:\s*\[[^\]]+\])*)$/.exec(withoutSemicolon);
      if (!fieldMatch) {
        throw new Error(`Unable to parse field line in ${name}: ${line}`);
      }

      const rawType = fieldMatch[1].trim();
      const fieldName = fieldMatch[2].trim();
      const arrayPart = fieldMatch[3] ?? "";

      const dims: number[] = [];
      const dimRegex = /\[\s*([^\]]+?)\s*\]/g;
      let dimMatch: RegExpExecArray | null;
      while ((dimMatch = dimRegex.exec(arrayPart)) !== null) {
        const value = Number.parseInt(dimMatch[1], 10);
        if (!Number.isFinite(value) || value <= 0) {
          throw new Error(`Invalid array size '${dimMatch[1]}' in ${name}.${fieldName}`);
        }
        dims.push(value);
      }

      fields.push({
        rawType,
        name: fieldName,
        arrayDims: dims
      });
    }

    structs.push({ name, fields });
  }

  return structs;
}

function product(values: number[]): number {
  return values.reduce((acc, current) => acc * current, 1);
}

function normalizeDisplayType(rawType: string, dims: number[]): string {
  if (rawType === "char" && dims.length > 0) {
    const [first, ...rest] = dims;
    if (rest.length === 0) {
      return `CHAR<${first}>`;
    }
    return `CHAR<${first}>[${rest.join("][")}]`;
  }

  const map: Record<string, string> = {
    int: "INT",
    "unsigned int": "INT",
    DWORD: "INT",
    DPID: "INT",
    WORD: "SHORT",
    short: "SHORT",
    BYTE: "BYTE",
    __int8: "BYTE",
    BOOL: "BOOL"
  };

  return map[rawType] ?? rawType;
}

function formatHex(value: number): string {
  const hex = value.toString(16).toUpperCase();
  return `0x${hex.padStart(4, "0")}`;
}

function buildSizeResolver(structs: StructDef[]): (typeName: string) => number {
  const structByName = new Map(structs.map(entry => [entry.name, entry]));
  const memo = new Map<string, number>();
  const visiting = new Set<string>();

  function resolve(typeName: string): number {
    if (TYPE_SIZE[typeName] !== undefined) {
      return TYPE_SIZE[typeName];
    }

    if (memo.has(typeName)) {
      return memo.get(typeName)!;
    }

    const structDef = structByName.get(typeName);
    if (!structDef) {
      throw new Error(`Unknown type '${typeName}'`);
    }

    if (visiting.has(typeName)) {
      throw new Error(`Cyclic struct dependency detected for '${typeName}'`);
    }

    visiting.add(typeName);
    let total = 0;
    for (const field of structDef.fields) {
      const baseSize = resolve(field.rawType);
      total += baseSize * product(field.arrayDims);
    }
    visiting.delete(typeName);

    memo.set(typeName, total);
    return total;
  }

  return resolve;
}

function renderStructs(structs: StructDef[]): string {
  const resolveSize = buildSizeResolver(structs);
  const lines: string[] = [];

  for (const structDef of structs) {
    const structSize = resolveSize(structDef.name);
    lines.push(`struct ${structDef.name} (size ${formatHex(structSize)})`);
    lines.push("{");

    let offset = 0;
    for (const field of structDef.fields) {
      const baseSize = resolveSize(field.rawType);
      const count = product(field.arrayDims);
      const displayType = normalizeDisplayType(field.rawType, field.arrayDims);

      const suffix =
        field.rawType === "char" && field.arrayDims.length > 0
          ? ""
          : field.arrayDims.length > 0
          ? `[${field.arrayDims.join("][")}]`
          : "";

      lines.push(`  ${formatHex(offset)} ${displayType}${suffix} ${field.name}`);
      offset += baseSize * count;
    }

    lines.push("}");
    lines.push("");
  }

  return lines.join("\n").trimEnd() + "\n";
}

function main(): void {
  const inputArg = process.argv[2] ?? "wip.txt";
  const outputArg = process.argv[3];

  if (inputArg === "-h" || inputArg === "--help") {
    usage();
  }

  const inputPath = path.resolve(process.cwd(), inputArg);
  if (!fs.existsSync(inputPath)) {
    throw new Error(`Input file not found: ${inputPath}`);
  }

  const source = fs.readFileSync(inputPath, "utf8");
  const structs = parseStructs(source);
  if (structs.length === 0) {
    throw new Error(`No structs found in: ${inputPath}`);
  }

  const output = renderStructs(structs);

  if (!outputArg) {
    process.stdout.write(output);
    return;
  }

  const outputPath = path.resolve(process.cwd(), outputArg);
  fs.writeFileSync(outputPath, output, "utf8");
  process.stderr.write(`Wrote ${outputPath}\n`);
}

main();
