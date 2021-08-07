import { Component, h, JSX, Prop, State, Element, Method, Watch } from "@stencil/core";
import { tabPanes } from "../../view-model/bootstrap";
import { PilotFileController } from "../../view-model/pilot-file/controller";
import { TFRController } from "../../view-model/pilot-file/tfr-controller";
import { XvTPltController } from "../../view-model/pilot-file/xvt-controller";
import { Battle } from "../../model/ehtc";
import { XWAPltController } from "../../view-model/pilot-file/xwa-controller";
import { PilotFile as XWingPilot } from "../../model/XW";
import { PilotFile as TIEPilot } from "../../model/TIE";
import { PilotFile as XvTPilot } from "../../model/XvT";
import { PilotFile as XWAPilot } from "../../model/XWA";
import { XWController } from "../../view-model/pilot-file/xw-controller";

@Component({
  tag: "pyrite-pilot-file",
  styleUrls: ["../../assets/superhero.css", "../../global/material-icons.scss", "pilot-file.scss"],
  shadow: true
})
export class PilotViewer {
  @Element() private el: HTMLElement;
  @Prop() public file: string;
  @Prop() public bsf: string = "";
  @Prop() public allowUpload: boolean = false;

  @State()
  protected controller: PilotFileController;
  @State() protected battleData?: Battle;
  @State() protected activeTab: string = "summary";

  public componentWillLoad(): void {
    if (this.file) {
      fetch(this.file)
        .then((res: Response) => res.arrayBuffer())
        .then((value: ArrayBuffer) => {
          this.controller = this.controllerFromFile(this.file, value);
        });
    }
    this.fetchBSF();
  }

  @Watch("bsf")
  private fetchBSF(): void {
    if (this.bsf) {
      fetch(this.bsf)
        .then((res: Response) => res.json())
        .then((value: object) => {
          this.battleData = Battle.fromJSON(value as Battle);
          this.activeTab = "bsf";
        });
    }
  }

  @Method()
  public async useFileInput(file: File): Promise<void> {
    const fr = new FileReader();
    fr.onloadend = () => {
      this.controller = this.controllerFromFile(file.name, fr.result as ArrayBuffer);
    };
    fr.readAsArrayBuffer(file);
    return Promise.resolve();
  }

  public render(): JSX.Element {
    let title: JSX.Element = "Pyrite Pilot File Viewer";
    let content: JSX.Element = <p class="text-center my-3">Select a file to view</p>;

    if (this.controller) {
      title = this.controller.filename;
      content = tabPanes(this.controller.renderTabs(this.battleData), this.activeTab, this.tabSelect.bind(this));
    }

    return (
      <div class="component bg-dark">
        <nav class="navbar navbar-light bg-light">
          <a class="navbar-brand" href="#">
            {title}
          </a>
          {this.allowUpload && (
            <button type="button" class="btn btn-sm ml-1 btn-secondary" onClick={this.getFile.bind(this)}>
              Upload
            </button>
          )}
        </nav>
        <div class="container card">{content}</div>
        {this.allowUpload && (
          <input type="file" id="pltUpload" value="" onChange={this.fileChange.bind(this)} class="testhide" />
        )}
      </div>
    );
  }

  private tabSelect(tabName: string): void {
    this.activeTab = tabName;
  }

  private getFile(): void {
    this.el.shadowRoot.getElementById("pltUpload").click();
  }

  private fileChange(event: any): void {
    const input = event.target as HTMLInputElement;
    if (input.files) {
      const file = input.files[0];
      this.useFileInput(file);
    } else {
      // do nothing
    }
  }

  private controllerFromFile(filepath: string, file: ArrayBuffer): PilotFileController {
    const ext = filepath
      .toLowerCase()
      .split(".")
      .pop();
    if (ext === "tfr") {
      return new TFRController(filepath, new TIEPilot(file));
    } else if (ext === "plt") {
      if (file.byteLength === 1705 || file.byteLength === 3410) {
        // x-wing
        return new XWController(filepath, new XWingPilot(file));
      } else if (file.byteLength > 200000) {
        return new XvTPltController(filepath, new XvTPilot(file));
      } else if (file.byteLength === 152076) {
        return new XWAPltController(filepath, new XWAPilot(file));
      }
    }
    console.error(filepath, file);
    throw new Error(`Unknown pilot file: Unrecognised file format: ${filepath}`);
  }
}
