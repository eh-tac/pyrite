import { Struct } from "./struct";
import {
  Prop,
  PropShort,
  PropByte,
  PropBool,
  PropInt,
  PropSByte,
  PropStr,
  PropObject,
  PropType,
  PropChar,
  PropAny,
  PropUShort
} from "./prop";
import { Constants } from "./constants";

export class PyriteGenerator {
  public structs: { [key: string]: Struct } = {};
  public constants: { [key: string]: Constants } = {};

  public constructor(public platform: string, structData: string, constData: string) {
    this.parseStructs(structData.split("\n"));
    this.parseConsts(constData.split("\n"));
  }

  /**
   * Parse the structs text file line by line. Each line is either
   *
   * struct Mission (size 0)                            ... a struct start / header
   * {                                                  ... open paren (skip)
   *     0x000 FileHeader FileHeader                    ... a property line
   *     PV FlightGroup[FileHeader-NumFGs] FlightGroups ... another, more complicated property line
   *     ...etc...
   * }                                                  ... close paren (finish current struct)
   *                                                    ... an empty line (skip)
   * @param lines
   */
  public parseStructs(lines: string[]): void {
    let currentStruct: Struct;
    let currentProp: Prop;
    for (const l of lines) {
      const line = l.trim();
      const bits = line.split(/\s+/);
      if (line === "{" || line === "") {
        continue; // skip
      } else if (!currentStruct) {
        // has data and no current struct - this must be the header line
        // 'struct', name, '(size', 0x123)
        const [, heading, , hexSize] = bits;
        if (!hexSize) {
          console.warn(`Bad line ${l}`);
        }
        currentStruct = new Struct(heading, hexSize.replace(")", ""));
        this.structs[heading] = currentStruct;
      } else if (line === "}") {
        currentStruct = undefined; // end of struct, get ready for the next
        currentProp = undefined;
      } else {
        currentProp = this.parseProp(bits);
        currentStruct.addProp(currentProp);
      }
    }
  }

  public parseProp(bits: string[]): Prop {
    if (bits.length === 2) {
      bits.push("Unnamed");
    }

    const [offset, typeStr, name] = bits;
    const rest = bits.slice(3).join(" ");

    let prop: Prop = new Prop(offset, name, "prop");

    const match = typeStr.match(/(?<type>\w*)(?:\<(?<typeLen>[\w-\(\)]*)\>)?(?:\[(?<arrayLen>[\w-\(\)]*)\])?/);
    const type = match.groups["type"] as PropType;

    if (type === "SHORT") {
      prop = new PropShort(offset, name, type);
    } else if (type === "USHORT") {
      prop = new PropUShort(offset, name, type);
    } else if (type === "BOOL") {
      prop = new PropBool(offset, name, type);
    } else if (type === "BYTE") {
      prop = new PropByte(offset, name, type);
    } else if (type === "SBYTE") {
      prop = new PropSByte(offset, name, type);
    } else if (type === "INT") {
      prop = new PropInt(offset, name, type);
    } else if (type === "STR") {
      prop = new PropStr(offset, name, type);
    } else if (type === "CHAR") {
      prop = new PropChar(offset, name, type);
    } else if (type === "any") {
      prop = new PropAny(offset, name, type);
    } else if (type) {
      prop = new PropObject(offset, name, type);
      (prop as PropObject).structName = type;
    } else {
      console.warn("very confused by", bits);
    }
    return prop
      .handleTypeLength(match.groups["typeLen"])
      .handleArrayLength(match.groups["arrayLen"])
      .handleRest(rest);
  }

  /**
   * Parse constants, a series of lines like:
   * Beam             ... title
   * 00	None          ... (hex)value label
   * 01	Tractor Beam
   * 02	Jamming Beam
   *
   * @param lines
   */
  public parseConsts(lines: string[]): void {
    let currentConst: Constants;
    for (const l of lines) {
      const line = l.trim();
      if (!line) {
        currentConst = undefined;
      } else if (!currentConst) {
        currentConst = new Constants(line);
        this.constants[line] = currentConst;
      } else {
        const bits = line.split(/\s+/);
        const value = bits[0];
        const label = bits.slice(1).join(" ");
        currentConst.add(value, label);
      }
    }
  }
}
