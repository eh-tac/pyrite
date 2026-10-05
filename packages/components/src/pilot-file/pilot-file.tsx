import { PilotFile as TIEPilot } from '@pyrite/tie';
import { PL2FileRecord as BoPPilot, PilotFile as XvTPilot } from '@pyrite/xvt';
import { PilotFile as XWingPilot } from '@pyrite/xw';
import { PilotFile as XWAPilot } from '@pyrite/xwa';
import { PilotFile as XWVMPilot } from '@pyrite/xwvm';
import { Component, Element, Method, Prop, State, Watch } from '@stencil/core';

import { tabPanes } from '../bootstrap';
import { BoPPltController } from './controller/bop-controller';
import type { PilotFileController } from './controller/controller';
import { TFRController } from './controller/tfr-controller';
import { XvTPltController } from './controller/xvt-controller';
import { XWController } from './controller/xw-controller';
import { XWAPltController } from './controller/xwa-controller';
import { XWVMController } from './controller/xwvm-controller';
import { BattleDetail } from '@pyrite/ehtc-api';

@Component({
  tag: 'pyrite-pilot-file',
  styleUrl: '../../assets/superhero.css',
  shadow: true,
})
export class PilotViewer {
  @Element()
  private el!: HTMLPyritePilotFileElement;
  @Prop()
  public file!: string;
  @Prop() public bsf: string = '';
  @Prop() public allowUpload: boolean = false;

  @State()
  protected controller!: PilotFileController;
  @State() protected battleData?: BattleDetail;
  @State() protected activeTab: string = 'summary';

  public componentWillLoad(): void {
    if (this.file) {
      fetch(this.file)
        .then((res: Response) => {
          if (res.status === 200) {
            return res.arrayBuffer();
          }
          throw new Error('Invalid response while loading pilot file');
        })
        .then((value: ArrayBuffer) => {
          this.controller = this.controllerFromFile(this.file, value);
        });
    }
    this.fetchBSF();
  }

  @Watch('bsf')
  private fetchBSF(): void {
    if (this.bsf) {
      fetch(this.bsf)
        .then((res: Response) => res.json())
        .then((value: object) => {
          this.battleData = value as BattleDetail;
          this.activeTab = 'bsf';
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
    return;
  }

  public render() {
    let title = 'Pyrite Pilot File Viewer';
    let content = <p class="text-center my-3">Select a file to view</p>;

    if (this.controller) {
      title = this.controller.filename;
      content = tabPanes(this.controller.renderTabs(this.battleData), this.activeTab, this.tabSelect.bind(this));
    } else if (!this.allowUpload && this.file) {
      content = <p class="text-center my-3 text-warning">Unable to load file {this.file}</p>;
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
    this.el.shadowRoot!.querySelector<HTMLInputElement>(':scope input#pltUpload')!.click();
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
    const ext = filepath.toLowerCase().split('.').pop();
    switch (ext) {
      case 'tfr': {
        return new TFRController(filepath, new TIEPilot(file));
      }
      case 'plt': {
        if (file.byteLength === 1705 || file.byteLength === 1706 || file.byteLength === 3410) {
          // x-wing
          return new XWController(filepath, new XWingPilot(file));
        }
        if (file.byteLength === 152076) {
          return new XWAPltController(filepath, new XWAPilot(file));
        }
        return new XvTPltController(filepath, new XvTPilot(file));
      }
      case 'pl2': {
        return new BoPPltController(filepath, new BoPPilot(file));
      }
      case 'vmpilot': {
        return new XWVMController(filepath, new XWVMPilot(file));
      }
      // No default
    }
    console.error(filepath, file);
    throw new Error(`Unknown pilot file: Unrecognised file format: ${filepath}, length ${file.byteLength}`);
  }
}
