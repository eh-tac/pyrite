import { describeXwaMission } from './index';

describe('describeXwaMission', () => {
  it('imports @pyrite/core through the workspace package name', () => {
    expect(describeXwaMission('Bacta Escort')).toBe('XWA: Bacta Escort');
  });
});