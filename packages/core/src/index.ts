export type PyriteGame = 'tie' | 'xvt' | 'xwa' | 'xw';

export const createMissionLabel = (game: PyriteGame, missionName: string): string =>
  `${game.toUpperCase()}: ${missionName}`;
