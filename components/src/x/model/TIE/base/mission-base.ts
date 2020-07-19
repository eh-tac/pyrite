import { Briefing } from "../briefing";
import { Byteable } from "../../../byteable";
import { FileHeader } from "../file-header";
import { FlightGroup } from "../flight-group";
import { GlobalGoal } from "../global-goal";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Message } from "../message";
import { PostMissionQuestions } from "../post-mission-questions";
import { PreMissionQuestions } from "../pre-mission-questions";
import { getByte, writeByte, writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class MissionBase extends PyriteBase implements Byteable {
  public MissionLength: number;
  public FileHeader: FileHeader;
  public FlightGroups: FlightGroup[];
  public Messages: Message[];
  public GlobalGoals: GlobalGoal[];
  public Briefing: Briefing;
  public PreMissionQuestions: PreMissionQuestions[];
  public PostMissionQuestions: PostMissionQuestions[];
  public readonly End: number = 255;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.FileHeader = new FileHeader(hex.slice(0x000), this.TIE);
    this.FlightGroups = [];
    offset = offset;
    for (let i = 0; i < this.FileHeader.NumFGs; i++) {
      const t = new FlightGroup(hex.slice(offset), this.TIE);
      this.FlightGroups.push(t);
      offset += t.getLength();
    }
    this.Messages = [];
    offset = offset;
    for (let i = 0; i < this.FileHeader.NumMessages; i++) {
      const t = new Message(hex.slice(offset), this.TIE);
      this.Messages.push(t);
      offset += t.getLength();
    }
    this.GlobalGoals = [];
    offset = offset;
    for (let i = 0; i < 3; i++) {
      const t = new GlobalGoal(hex.slice(offset), this.TIE);
      this.GlobalGoals.push(t);
      offset += t.getLength();
    }
    this.Briefing = new Briefing(hex.slice(offset), this.TIE);
    this.PreMissionQuestions = [];
    offset = offset;
    for (let i = 0; i < 10; i++) {
      const t = new PreMissionQuestions(hex.slice(offset), this.TIE);
      this.PreMissionQuestions.push(t);
      offset += t.getLength();
    }
    this.PostMissionQuestions = [];
    offset = offset;
    for (let i = 0; i < 10; i++) {
      const t = new PostMissionQuestions(hex.slice(offset), this.TIE);
      this.PostMissionQuestions.push(t);
      offset += t.getLength();
    }
    // static prop End
    this.MissionLength = offset;
  }
  
  public toJSON(): object {
    return {
      FileHeader: this.FileHeader,
      FlightGroups: this.FlightGroups,
      Messages: this.Messages,
      GlobalGoals: this.GlobalGoals,
      Briefing: this.Briefing,
      PreMissionQuestions: this.PreMissionQuestions,
      PostMissionQuestions: this.PostMissionQuestions
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.FileHeader, 0x000);
    offset = offset;
    for (let i = 0; i < this.FileHeader.NumFGs; i++) {
      const t = this.FlightGroups[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < this.FileHeader.NumMessages; i++) {
      const t = this.Messages[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < 3; i++) {
      const t = this.GlobalGoals[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeObject(hex, this.Briefing, offset);
    offset = offset;
    for (let i = 0; i < 10; i++) {
      const t = this.PreMissionQuestions[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < 10; i++) {
      const t = this.PostMissionQuestions[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeByte(hex, 255, offset);

    return hex;
  }
  
  
  public getLength(): number {
    return this.MissionLength;
  }
}