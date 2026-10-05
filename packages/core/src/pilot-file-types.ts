export type Accuracy = `${string} / ${string}`;
export type Percent = `${number} %`;

export function accuracy(hit: number, fired: number): Accuracy {
  return `${hit.toLocaleString()} / ${fired.toLocaleString()}`;
}

export function percent(hit: number, fired: number): Percent {
  const per = fired ? Math.floor((hit / fired) * 100) : 0;
  return `${per} %`;
}

export interface PilotData {
  LaserLabel: string;
  WarheadLabel: string;
}

export interface BattleSummary<T extends MissionScore = MissionScore> {
  hasData: boolean;
  completed: boolean;
  status: string;
  missions: T[];
}

export interface TrainingSummary {
  craftLabel: string;
  scoreLabel: string;
  trainingLevel: number;
  trainingScore: number;
  missions: MissionScore[];
}

export interface KillSummary {
  craftLabel: string;
  kills: number;
}

export interface MissionScore {
  hasData: boolean;
  completed: boolean;
  score: number;
  secret?: boolean;
  bonus?: boolean;
}
