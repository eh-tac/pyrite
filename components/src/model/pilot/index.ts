export { TFR, TrainingSummary } from "./tfr";
export { XvTPlt } from "./xvt";

export interface PilotData {
  LaserLabel: string;
  WarheadLabel: string;
}

export interface BattleSummary {
  completed: boolean;
  status: string;
  missions: MissionScore[];
}

export interface KillSummary {
  craftLabel: string;
  kills: number;
}

export interface MissionScore {
  completed: boolean;
  score: number;
  secret?: boolean;
  bonus?: boolean;
}
