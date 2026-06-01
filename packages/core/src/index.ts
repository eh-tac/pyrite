export type PyriteGame = 'tie' | 'xvt' | 'xwa' | 'xw';

export const createMissionLabel = (game: PyriteGame, missionName: string): string =>
  `${game.toUpperCase()}: ${missionName}`;

export * from './byteable';
export * from './hex';
export * from './pyrite-base';
