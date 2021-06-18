export interface Rating {
  total: number;
  label: string;
  image?: string;
}
export class PilotSummary {
  constructor(public PIN: number, public label: string, public profile: string, public description: string) {}
}

export class SimplePilot extends PilotSummary {
  constructor(
    PIN: number,
    label: string,
    profile: string,
    public email: string,
    public rank: string,
    public rankImage: string,
    public name: string,
    public position: string,
    public IDLine: string
  ) {
    super(PIN, label, profile, IDLine);
  }
}

export class Pilot extends SimplePilot {
  constructor(
    PIN: number,
    label: string,
    profile: string,
    email: string,
    rank: string,
    rankImage: string,
    name: string,
    position: string,
    IDLine: string,
    public medalLine: string,
    public IWATSLine: string,
    public FCHG: Rating,
    public CR: Rating,
    public PvE: Rating,
    public battles: number,
    public missions: number,
    public secondary: SimplePilot
  ) {
    super(PIN, label, profile, email, rank, rankImage, name, position, IDLine);
  }
}

export class CharacterSummary {
  constructor(
    public PIN: number,
    public characterId: number,
    public label: string,
    public description: string,
    public profile: string,
    public subgroupLabel: string,
    public subgroupName: string
  ) {}
}
