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
export declare function shootInfo(hit: number, fired: number): string;
export declare function percent(hit: number, fired: number): string;
