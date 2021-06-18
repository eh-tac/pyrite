import { PyriteGenerator } from "../generator";
import { PropObject, Prop, PropByte, PropChar, PropShort, PropSByte, PropInt, PropStr } from "../prop";
import { Struct } from "../struct";

describe("generator test", () => {
  describe("props", () => {
    let gen: PyriteGenerator;

    const getProp = (line: string) => {
      return gen.parseProp(line.trim().split(/\s+/));
    };

    const expectProp = (prop: Prop, offset: string, name: string, isArray: boolean, pv: boolean): void => {
      expect(prop.offset).toBe(offset, "Offset check failed");
      expect(prop.name).toBe(name, "Name check failed");
      expect(prop.isArray).toBe(isArray, "isArray check failed");
      expect(prop.previousValueOffset).toBe(pv, "prevVal check failed");
    };

    beforeEach(() => {
      gen = new PyriteGenerator("TIE", "", "");
    });

    it("basic prop object", () => {
      const prop = getProp("0x000 FileHeader FileHeader");

      expectProp(prop, "0x000", "FileHeader", false, false);

      expect(prop instanceof PropObject).toBeTrue();
      expect((prop as PropObject).structName).toBe("FileHeader");
    });

    it("simple length array prop object", () => {
      const prop = getProp("PV GlobalGoal[3] GlobalGoals");

      expectProp(prop, "PV", "GlobalGoals", true, true);
      expect(prop.arrayLengthValue).toBe(3);
      expect(prop instanceof PropObject).toBeTrue();
      expect((prop as PropObject).structName).toBe("GlobalGoal");
    });

    it("expression length array prop object", () => {
      const prop = getProp("PV FlightGroup[FileHeader-NumFGs] FlightGroups");
      expectProp(prop, "PV", "FlightGroups", true, true);
      expect(prop.arrayLengthExpression).toBe("FileHeader-NumFGs");
      expect(prop.getFunctionStubs().length).toBe(0);
      expect(prop instanceof PropObject).toBeTrue();
      expect((prop as PropObject).structName).toBe("FlightGroup");
    });

    it("reserved byte", () => {
      const prop = getProp("PV BYTE End Reserved(0xFF)");

      expectProp(prop, "PV", "End", false, true);
      expect(prop instanceof PropByte).toBeTrue();
      expect(prop.reservedValue).toBe(255);
    });

    it("enum", () => {
      const prop = getProp("0x00A	BYTE	BriefingOfficers (enum)");

      expectProp(prop, "0x00A", "BriefingOfficers", false, false);
      expect(prop instanceof PropByte).toBeTrue();
      expect(prop.isEnum).toBeTrue();
      expect(prop.enumName).toBe("BriefingOfficers");
    });

    it("simple type and array length", () => {
      const prop = getProp("0x018	CHAR<64>[6]	EndOfMissionMessages");

      expectProp(prop, "0x018", "EndOfMissionMessages", true, false);
      expect(prop instanceof PropChar).toBe(true);
      expect(prop.baseSize).toBe(64);
      expect(prop.arrayLengthValue).toBe(6);
      expect(prop.size).toBe(64 * 6);
    });

    it("type length expression", () => {
      const prop = getProp("0x2	CHAR<QuestionLength()> Question");

      expectProp(prop, "0x2", "Question", false, false);
      expect(prop instanceof PropChar).toBeTrue();
      expect(prop.typeLengthExpression).toBe("QuestionLength()");
      expect(prop.getFunctionStubs().length).toBe(1);
      expect(prop.getFunctionStubs()[0]).toBe("QuestionLength()");
    });

    it("comment", () => {
      const prop = getProp("0x03B	BYTE	Reserved1 Reserved(0)			Unknown1 in TFW");

      expectProp(prop, "0x03B", "Reserved1", false, false);
      expect(prop instanceof PropByte).toBeTrue();
      expect(prop.comment).toBe("Unknown1 in TFW");
    });

    it("array length expression", () => {
      const prop = getProp("0x4	SHORT[VariableCount()]	Variables");

      expectProp(prop, "0x4", "Variables", true, false);
      expect(prop instanceof PropShort).toBeTrue();
      expect(prop.arrayLengthExpression).toBe("VariableCount()");
      expect(prop.getFunctionStubs().length).toBe(1);
      expect(prop.getFunctionStubs()[0]).toBe("VariableCount()");
    });

    it("sbyte", () => {
      const prop = getProp("0x0A6	SBYTE	BonusGoalPoints");

      expectProp(prop, "0x0A6", "BonusGoalPoints", false, false);
      expect(prop instanceof PropSByte).toBeTrue();
    });

    it("int", () => {
      const prop = getProp("0x006	INT	EventsLength Number of shorts used for events.");

      expectProp(prop, "0x006", "EventsLength", false, false);
      expect(prop instanceof PropInt).toBeTrue();
      expect(prop.comment).toBe("Number of shorts used for events.");
    });

    it("string", () => {
      const prop = getProp("0x48	STR<12>	EditorNote");

      expectProp(prop, "0x48", "EditorNote", false, false);
      expect(prop instanceof PropStr).toBe(true, "Not a string");
      expect(prop.baseSize).toBe(12);
    });

    it("big comment", () => {
      const prop = getProp(
        "0x00A	Event[0] Events Set to 0 and impossible to generate in the same way, needs custom implementation"
      );

      expectProp(prop, "0x00A", "Events", true, false);
      expect(prop instanceof PropObject).toBeTrue();
      expect((prop as PropObject).structName).toBe("Event");
    });
  });

  describe("structs", () => {
    it("correctly processes a simple struct", () => {
      const structData = `struct Mission (size 0)
      {
        0x000 FileHeader FileHeader
        PV FlightGroup[FileHeader-NumFGs] FlightGroups
        PV Message[FileHeader-NumMessages] Messages
        PV GlobalGoal[3] GlobalGoals
        PV Briefing Briefing
        PV PreMissionQuestions[10] PreMissionQuestions
        PV PostMissionQuestions[10] PostMissionQuestions
        PV BYTE	End Reserved(0xFF)
      }`;
      const generator = new PyriteGenerator("TIE", structData, "");
      const missStruct = generator.structs["Mission"] as Struct;
      expect(missStruct).toBeDefined();
      const missProps = missStruct.getProps();
      expect(missProps.length).toBe(8);
      expect(missProps[0].name).toBe("FileHeader");
    });

    it("does muliples", () => {
      const structData = `struct Mission (size 0)
      {
        0x000 FileHeader FileHeader
        PV FlightGroup[FileHeader-NumFGs] FlightGroups
        PV Message[FileHeader-NumMessages] Messages
        PV GlobalGoal[3] GlobalGoals
        PV Briefing Briefing
        PV PreMissionQuestions[10] PreMissionQuestions
        PV PostMissionQuestions[10] PostMissionQuestions
        PV BYTE	End Reserved(0xFF)
      }
      
      struct FileHeader (size 0x1CA)
      {
        0x000	SHORT	PlatformID (-1)
        0x002	SHORT	NumFGs
        0x004	SHORT	NumMessages
        0x006	SHORT	NumGGs Reserved(3)		might be # of GlobalGoals
        0x008	BYTE	Unknown1
        0x009	BOOL	Unknown2
        0x00A	BYTE	BriefingOfficers (enum)
        0x00D	BOOL	CapturedOnEject
        0x018	CHAR<64>[6]	EndOfMissionMessages
        0x19A	CHAR<12>[4]	OtherIffNames
      }`;

      const gen = new PyriteGenerator("TIE", structData, "");
      const mission = gen.structs["Mission"];
      expect(mission).toBeDefined();
      expect(mission.getProps().length).toBe(8);

      const fileheader = gen.structs["FileHeader"];
      expect(fileheader).toBeDefined();
      expect(fileheader.getProps().length).toBe(10);
    });
  });

  describe("constants", () => {
    it("does basics", () => {
      const constData = `Beam
    00	None
    01	Tractor Beam
    02	Jamming Beam
    
    GroupAI
    00	Rookie (None)
    01	Novice
    02	Veteran
    03	Officer
    04	Ace
    05	Top Ace (Invincible)`;
      const gen = new PyriteGenerator("TIE", "", constData);
      const beam = gen.constants["Beam"];
      expect(beam).toBeDefined();
      expect(beam.name).toBe("Beam");
      expect(beam.values.length).toBe(3);
      expect(beam.values[0][0]).toBe(0);
      expect(beam.values[2][1]).toBe("Jamming Beam");

      const fgAI = gen.constants["GroupAI"];
      expect(fgAI).toBeDefined();
      expect(fgAI.name).toBe("GroupAI");
      expect(fgAI.values.length).toBe(6);
    });
  });
});
