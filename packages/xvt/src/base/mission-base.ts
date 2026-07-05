import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getString, writeObject, writeString } from '@pyrite/core';

import { Briefing } from '../briefing';
import { FileHeader } from '../file-header';
import { FlightGroup } from '../flight-group';
import { GlobalGoal } from '../global-goal';
import { Message } from '../message';
import { Team } from '../team';
export abstract class MissionBase extends PyriteBase implements Byteable {
  public MissionLength: number;
  public FileHeader: FileHeader;
  public FlightGroups: FlightGroup[];
  public Messages: Message[];
  public GlobalGoals: GlobalGoal[];
  public Teams: Team[];
  public Briefing: Briefing[];
  public FGGoalStrings: string[];
  public GlobalGoalStrings: string[];
  public MissionDescription: string;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.FileHeader = new FileHeader([...hex], this.TIE);
    this.FlightGroups = [];
    offset = 0x0a4;
    for (let i = 0; i < this.FileHeader.NumFGs; i++) {
      const t = new FlightGroup(hex.slice(offset), this.TIE);
      this.FlightGroups.push(t);
      offset += t.getLength();
    }
    this.Messages = [];
    for (let i = 0; i < this.FileHeader.NumMessages; i++) {
      const t = new Message(hex.slice(offset), this.TIE);
      this.Messages.push(t);
      offset += t.getLength();
    }
    this.GlobalGoals = [];
    for (let i = 0; i < 10; i++) {
      const t = new GlobalGoal(hex.slice(offset), this.TIE);
      this.GlobalGoals.push(t);
      offset += t.getLength();
    }
    this.Teams = [];
    for (let i = 0; i < 10; i++) {
      const t = new Team(hex.slice(offset), this.TIE);
      this.Teams.push(t);
      offset += t.getLength();
    }
    this.Briefing = [];
    for (let i = 0; i < 8; i++) {
      const t = new Briefing(hex.slice(offset), this.TIE);
      this.Briefing.push(t);
      offset += t.getLength();
    }
    this.FGGoalStrings = [];
    for (let i = 0; i < this.FGGoalStringCount(); i++) {
      const t = getString(hex, offset, 64);
      this.FGGoalStrings.push(t);
      offset += 64;
    }
    this.GlobalGoalStrings = [];
    for (let i = 0; i < 360; i++) {
      const t = getString(hex, offset, 64);
      this.GlobalGoalStrings.push(t);
      offset += 64;
    }
    this.MissionDescription = getString(hex, offset, 1024);
    offset += 1024;
    this.MissionLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      FileHeader: this.FileHeader.toJSON(),
      FlightGroups: this.FlightGroups.map((t) => t.toJSON()),
      Messages: this.Messages.map((t) => t.toJSON()),
      GlobalGoals: this.GlobalGoals.map((t) => t.toJSON()),
      Teams: this.Teams.map((t) => t.toJSON()),
      Briefing: this.Briefing.map((t) => t.toJSON()),
      FGGoalStrings: this.FGGoalStrings,
      GlobalGoalStrings: this.GlobalGoalStrings,
      MissionDescription: this.MissionDescription
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeObject(hex, this.FileHeader, 0x000);
    offset = 0x0a4;
    for (let i = 0; i < this.FlightGroups.length; i++) {
      const t = this.FlightGroups[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.Messages.length; i++) {
      const t = this.Messages[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.GlobalGoals.length; i++) {
      const t = this.GlobalGoals[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.Teams.length; i++) {
      const t = this.Teams[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.Briefing.length; i++) {
      const t = this.Briefing[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.FGGoalStrings.length; i++) {
      const t = this.FGGoalStrings[i];
      writeString(hex, t, offset, 64);
      offset += 64;
    }
    for (let i = 0; i < this.GlobalGoalStrings.length; i++) {
      const t = this.GlobalGoalStrings[i];
      writeString(hex, t, offset, 64);
      offset += 64;
    }
    writeString(hex, this.MissionDescription, offset, 1024);
    offset += 1024;

    return hex;
  }

  protected abstract FGGoalStringCount(): number;
  public getLength(): number {
    return this.MissionLength;
  }
}
