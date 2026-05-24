import { Component, Element, h, JSX, Method, Prop, State, Watch } from "@stencil/core";
import { PL2CampaignProgressState, PL2CampaignState, PL2FileRecord } from "../../../model/XvT";

type FactionCampaignState = {
  label: string;
  state?: PL2CampaignState;
};

@Component({
  tag: "pyrite-xvt-pl-2-file-editor",
  styleUrl: "../../../assets/superhero.css",
  shadow: false,
})
export class XvTPL2FileEditorComponent {
  @Element() public el: HTMLElement;
  @Prop() public file?: string;

  @State() private pl2?: PL2FileRecord;
  @State() private filename = "pilot.pl2";
  @State() private revision = 0;

  public componentWillLoad(): void {
    this.loadRemoteFile();
  }

  @Watch("file")
  protected loadRemoteFile(): void {
    if (!this.file) {
      return;
    }

    fetch(this.file)
      .then((res: Response) => {
        if (res.status !== 200) {
          throw new Error(`Unable to load PL2 file from ${this.file}`);
        }
        return res.arrayBuffer();
      })
      .then((value: ArrayBuffer) => {
        this.useArrayBuffer(this.getFilename(this.file!), value);
      })
      .catch((error: Error) => {
        console.error(error);
      });
  }

  @Method()
  public async useFileInput(file: File): Promise<void> {
    const fr = new FileReader();
    fr.onloadend = () => {
      this.useArrayBuffer(file.name, fr.result as ArrayBuffer);
    };
    fr.readAsArrayBuffer(file);
    return Promise.resolve();
  }

  public render(): JSX.Element {
    const states = this.getEditableStates();

    return (
      <div class="component bg-dark">
        <nav class="navbar navbar-light bg-light">
          <a class="navbar-brand" href="#">
            {this.filename || "PL2 Editor"}
          </a>
          <div class="d-flex">
            <button type="button" class="btn btn-sm ml-1 btn-secondary" onClick={this.getFile.bind(this)}>
              Upload
            </button>
            <button
              type="button"
              class="btn btn-sm ml-1 btn-primary"
              disabled={!this.pl2}
              onClick={this.saveFile.bind(this)}
            >
              Save
            </button>
          </div>
        </nav>
        <div class="container card p-3">
          {!this.pl2 && <p class="text-center my-3">Upload a `.pl2` file to edit campaign state values.</p>}
          {this.pl2 && (
            <div>
              <ul class="list-group mb-3">
                <li class="list-group-item heading">Pilot Information</li>
                {this.renderInfoRow("Filename", this.filename)}
                {this.renderInfoRow("Pilot Name", this.pl2.PilotName)}
                {this.renderInfoRow("Current Total Score", this.pl2.totalScore.exercise.toLocaleString())}
              </ul>
              {states.map((entry: FactionCampaignState, idx: number) => this.renderFactionState(entry, idx))}
            </div>
          )}
        </div>
        <input type="file" accept=".pl2" id="pl2Upload" onChange={this.fileChange.bind(this)} class="testhide" />
      </div>
    );
  }

  private useArrayBuffer(filename: string, value: ArrayBuffer): void {
    this.filename = filename;
    this.pl2 = new PL2FileRecord(value);
    this.revision += 1;
  }

  private getEditableStates(): FactionCampaignState[] {
    if (!this.pl2) {
      return [];
    }

    return [
      { label: "Imperial", state: this.pl2.spCampaignState[0] },
      { label: "Rebel", state: this.pl2.spCampaignState[1] },
    ];
  }

  private renderFactionState(entry: FactionCampaignState, idx: number): JSX.Element {
    const state = entry.state;
    if (!state) {
      return (
        <div class="mb-4">
          <h5>{entry.label} Campaign State</h5>
          <p class="text-warning">No campaign state found at slot {idx}.</p>
        </div>
      );
    }

    return (
      <div class="mb-4">
        <h5>{entry.label} Campaign State</h5>
        <div class="row">
          <div class="col-md-6">{this.renderStateFields(state)}</div>
          <div class="col-md-6">{this.renderSaveStateFields(state.saveState)}</div>
        </div>
      </div>
    );
  }

  private renderStateFields(state: PL2CampaignState): JSX.Element {
    return (
      <div>
        {this.renderNumberField("Config Random Seed", state.ConfigRandomSeed, (value: number) => {
          state.ConfigRandomSeed = value;
        })}
        {this.renderNumberField("Is In Progress", state.IsInProgressUNK, (value: number) => {
          state.IsInProgressUNK = value;
        })}
        {this.renderNumberField("Randomize Level", state.ConfigGameRandomizeLevel, (value: number) => {
          state.ConfigGameRandomizeLevel = value;
        })}
        {this.renderNumberField("Unknown 2", state.unknown2, (value: number) => {
          state.unknown2 = value;
        })}
      </div>
    );
  }

  private renderSaveStateFields(state: PL2CampaignProgressState): JSX.Element {
    return (
      <div>
        {this.renderNumberField("Unknown 1", state.unknown1, (value: number) => {
          state.unknown1 = value;
        })}
        {this.renderNumberField("Current Mission Number", state.CurrentMissionNumber, (value: number) => {
          state.CurrentMissionNumber = value;
        })}
        {this.renderNumberField("Total Mission Count", state.totalMissionCount, (value: number) => {
          state.totalMissionCount = value;
        })}
        {this.renderNumberField("Current Mission Complete", state.CurrentMissionComplete, (value: number) => {
          state.CurrentMissionComplete = value;
        })}
        {this.renderNumberField("Player Count", state.PlayerCount, (value: number) => {
          state.PlayerCount = value;
        })}
        {this.renderNumberField("Total Score", state.totalScore, (value: number) => {
          state.totalScore = value;
        })}
      </div>
    );
  }

  private renderNumberField(label: string, value: number, update: (value: number) => void): JSX.Element {
    return (
      <div class="form-group">
        <label>{label}</label>
        <input
          class="form-control"
          type="number"
          value={value}
          onInput={(event: Event) => {
            const input = event.target as HTMLInputElement;
            const nextValue = parseInt(input.value, 10);
            update(Number.isNaN(nextValue) ? 0 : nextValue);
            this.revision += 1;
          }}
        />
      </div>
    );
  }

  private renderInfoRow(label: string, value: string): JSX.Element {
    return (
      <li class="list-group-item kv d-flex justify-content-between">
        <h6 class="my-0">{label}</h6>
        <span class="text-info">{value}</span>
      </li>
    );
  }

  private getFile(): void {
    (this.el.querySelector("#pl2Upload") as HTMLInputElement).click();
  }

  private fileChange(event: Event): void {
    const input = event.target as HTMLInputElement;
    if (!input.files || input.files.length === 0) {
      return;
    }
    this.useFileInput(input.files[0]);
    input.value = "";
  }

  private saveFile(): void {
    if (!this.pl2) {
      return;
    }

    const blob = new Blob([this.pl2.toHexBuffer()], { type: "application/octet-stream" });
    const href = URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.href = href;
    link.download = this.filename || "pilot.pl2";
    link.click();
    URL.revokeObjectURL(href);
  }

  private getFilename(path: string): string {
    return path.split("/").pop() || "pilot.pl2";
  }
}