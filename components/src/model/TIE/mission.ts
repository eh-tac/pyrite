import { FlightGroup } from "./flight-group";
import { MissionBase } from "./base/mission-base";
import { PreMissionQuestions, QuestionType } from "./pre-mission-questions";
import { PostMissionQuestions } from "./post-mission-questions";
import { QuestionCondition } from "./constants";

export enum Difficulty {
  Easy = "Easy",
  Medium = "Medium",
  Hard = "Hard"
}

const HARD_PTS = 7750;
const MED_PTS = 5250;
const EASY_PTS = 2750;

export class Mission extends MissionBase {
  public valid = false;

  public constructor(x: ArrayBuffer) {
    super(x);
  }

  public get officerBriefing(): PreMissionQuestions[] {
    return this.PreMissionQuestions.slice(0, 4)
      .filter(q => q.Length)
      .map(q => {
        q.Type = QuestionType.Officer;
        return q;
      });
  }

  public get secretBriefing(): PreMissionQuestions[] {
    return this.PreMissionQuestions.slice(5, 9)
      .filter(q => q.Length)
      .map(q => {
        q.Type = QuestionType.Secret;
        return q;
      });
  }

  public get officerDebriefing(): PostMissionQuestions[] {
    return this.PostMissionQuestions.slice(0, 4).filter(
      q => q.Length && q.QuestionCondition === QuestionCondition.successful
    );
  }

  public get secretDebriefing(): PostMissionQuestions[] {
    return this.PostMissionQuestions.slice(5, 9).filter(
      q => q.Length && q.QuestionCondition === QuestionCondition.successful
    );
  }

  public get officerFailBriefing(): PostMissionQuestions[] {
    return this.PostMissionQuestions.slice(0, 4).filter(
      q => q.Length && q.QuestionCondition === QuestionCondition.failed
    );
  }

  public get secretFailBriefing(): PostMissionQuestions[] {
    return this.PostMissionQuestions.slice(5, 9).filter(
      q => q.Length && q.QuestionCondition === QuestionCondition.failed
    );
  }

  public getIFF(iff: number) {
    let IFFs = ["Rebel", "Imperial"];
    IFFs = IFFs.concat(this.FileHeader.OtherIffNames);

    let IFFName = IFFs[iff] && IFFs[iff].trim() ? IFFs[iff] : `Unknown IFF ${iff}`;

    if (!isNaN(parseInt(IFFName[0], 10))) {
      IFFName = `${IFFName.substr(1)} (hostile)`;
    }

    return IFFName;
  }

  public getFlightGroup(fg: number): FlightGroup {
    return this.FlightGroups[fg];
  }

  public getGlobalGroup(gg: number): FlightGroup[] {
    return this.FlightGroups.filter(fg => fg.GlobalGroup === gg);
  }

  public goalPoints(diff: Difficulty): number {
    if (diff == Difficulty.Hard) {
      return HARD_PTS;
    } else if (diff === Difficulty.Medium) {
      return MED_PTS;
    }
    return EASY_PTS;
  }

  public getPlayerCraft(diff: Difficulty): FlightGroup {
    return this.FlightGroups.find((fg: FlightGroup) => {
      return fg.PlayerCraft && fg.isInDifficulty(diff);
    });
  }

  protected beforeConstruct() {
    this.TIE = this;
  }
}
