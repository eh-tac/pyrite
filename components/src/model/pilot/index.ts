export interface PilotData {
  LaserLabel: string;
  WarheadLabel: string;
}

export interface BattleSummary {
  completed: boolean;
  status: string;
  missions: MissionScore[];
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
  completed: boolean;
  score: number;
  secret?: boolean;
  bonus?: boolean;
}

export function shootInfo(hit: number, fired: number): string {
  return `${hit} / ${fired}`;
}

export function percent(hit: number, fired: number): string {
  const per = fired ? Math.floor((hit / fired) * 100) : 0;
  return `${per} %`;
}
