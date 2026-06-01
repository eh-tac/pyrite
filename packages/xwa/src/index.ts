import { createMissionLabel } from '@pyrite/core';

export const describeXwaMission = (missionName: string): string =>
  createMissionLabel('xwa', missionName);
