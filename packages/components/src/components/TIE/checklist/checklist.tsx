import { Component, Prop, State, h, Host, JSX, Element } from "@stencil/core";
import { LFD, Rmap, Voic } from "../../../model/LFD";
import { Mission } from "../../../model/TIE";

type Tab = "messages";

@Component({
  tag: "pyrite-tie-checklist",
  styleUrl: "checklist.scss",
  shadow: false
})
export class TIEChecklistComponent {
  @Element() public el: HTMLElement;
  @Prop() public missionUrl: string;
  @Prop() public lfdUrl: string;

  @State() protected tie: Mission;
  @State() protected vocLFD: Rmap;
  @State() protected selectedTab: Tab;
  @State() protected code = "1M1";

  public componentWillLoad(): void {
    this.loadMission();
    this.loadLFD();
  }

  public loadMission(): void {
    if (!this.missionUrl) {
      return;
    }
    fetch(this.missionUrl)
      .then((res: Response) => res.arrayBuffer())
      .then((value: ArrayBuffer) => {
        this.tie = new Mission(value);
        console.log("loaded tie", this.tie);
      });
  }

  public loadLFD(): void {
    if (!this.lfdUrl) {
      return;
    }
    fetch(this.lfdUrl)
      .then((res: Response) => res.arrayBuffer())
      .then((value: ArrayBuffer) => {
        this.vocLFD = LFD.load(value);
        console.log("loaded lfd", this.vocLFD);
      });
  }

  private selectTab(tab: Tab): void {
    this.selectedTab = tab;
  }

  public renderVoc(id: string): JSX.Element {
    if (!this.vocLFD) {
      return "";
    }

    const key = this.code.toLowerCase() + id;
    const voic = this.vocLFD.RawData.find((l: Voic) => l.Header.Name.toLowerCase() === key);
    if (voic) {
      return (
        <a download={`${voic.Header.Name}.voc`} href={voic.base64()}>
          Download
        </a>
      );
    }
  }

  private renderText(text: string): JSX.Element[] {
    let out: JSX.Element[] = [];
    let current: string = "";
    for (let i = 0; i < text.length; i++) {
      const code = text.charCodeAt(i);
      if (code === 2 || code === 91) {
        // open special; current gets added as normal.
        out.push(<span class="normal">{current}</span>);
        current = "";
      } else if (code === 1 || code === 93) {
        // end special section; current is added as special.
        out.push(<span class="highlight">{current}</span>);
        current = "";
      } else {
        // normal, append to current string
        current = `${current}${text[i]}`;
      }
    }
    out.push(<span class="normal">{current}</span>);
    return out;
  }

  public renderMessages(): JSX.Element {
    return (
      <table class="table is-striped tietext">
        <tbody>
          <tr class="is-selected">
            <th colSpan={3}>Briefing</th>
          </tr>
          {this.tie.Briefing.Captions.map((cap, i) => (
            <tr>
              <td>
                {this.code}I{i + 1}
              </td>
              <td>{this.renderText(cap)}</td>
              <td>{this.renderVoc(`I${i + 1}`)}</td>
            </tr>
          ))}
          <tr class="is-selected">
            <th colSpan={3}>Questions</th>
          </tr>
          {this.tie.officerBriefing.map((ob, i) => (
            <tr>
              <td>
                {this.code}OB{i + 1}
              </td>
              <td>{this.renderText(ob.Answer)}</td>
              <td>{this.renderVoc(`OB${i + 1}`)}</td>
            </tr>
          ))}
          {this.tie.secretBriefing.map((pb, i) => (
            <tr>
              <td>
                {this.code}PB{i + 1}
              </td>
              <td>{this.renderText(pb.Answer)}</td>
              <td>{this.renderVoc(`PB${i + 1}`)}</td>
            </tr>
          ))}
          <tr class="is-selected">
            <th colSpan={3}>In-Flight Messages</th>
          </tr>
          {this.tie.Messages.map((message, i) => (
            <tr>
              <td>
                {this.code.toLowerCase()}r{i + 1}
              </td>
              <td>{message.DisplayText}</td>
              <td>{this.renderVoc(`r${i + 1}`)}</td>
            </tr>
          ))}
          <tr class="is-selected">
            <th colSpan={3}>End of Mission Messages</th>
          </tr>
          <tr>
            <td>{this.code.toLowerCase()}w1</td>
            <td>{this.tie.FileHeader.PrimaryCompleteMessage}</td>
            <td>{this.renderVoc(`w1`)}</td>
          </tr>
          <tr>
            <td>{this.code.toLowerCase()}w2</td>
            <td>{this.tie.FileHeader.SecondaryCompleteMessage}</td>
            <td>{this.renderVoc(`w2`)}</td>
          </tr>
          <tr>
            <td>{this.code.toLowerCase()}l1</td>
            <td>{this.tie.FileHeader.PrimaryFailMessage}</td>
            <td>{this.renderVoc(`l1`)}</td>
          </tr>
          <tr class="is-selected">
            <th colSpan={3}>Debriefings</th>
          </tr>
          {this.tie.officerDebriefing.map((od, i) => (
            <tr>
              <td>
                {this.code}OD{i + 1}
              </td>
              <td>{this.renderText(od.Answer)}</td>
              <td>{this.renderVoc(`OD${i + 1}`)}</td>
            </tr>
          ))}
          {this.tie.secretDebriefing.map((pd, i) => (
            <tr>
              <td>
                {this.code}PD{i + 1}
              </td>
              <td>{this.renderText(pd.Answer)}</td>
              <td>{this.renderVoc(`PD${i + 1}`)}</td>
            </tr>
          ))}
          {this.tie.officerFailBriefing.map((oh, i) => (
            <tr>
              <td>
                {this.code}OH{i + 1}
              </td>
              <td>{this.renderText(oh.Answer)}</td>
              <td>{this.renderVoc(`OH${i + 1}`)}</td>
            </tr>
          ))}
          {this.tie.secretFailBriefing.map((ph, i) => (
            <tr>
              <td>
                {this.code}PH{i + 1}
              </td>
              <td>{this.renderText(ph.Answer)}</td>
              <td>{this.renderVoc(`PH${i + 1}`)}</td>
            </tr>
          ))}
        </tbody>
      </table>
    );
  }

  public render(): JSX.Element {
    if (!this.tie) {
      return <p>Loading...</p>;
    }
    return (
      <div>
        <h2 class="has-text-centered">Pyrite TIE Checklist </h2>
        <hr />
        <div class="tabs">
          <ul>
            <li class={`${this.selectedTab === "messages" && "is-active"}`}>
              <a onClick={this.selectTab.bind(this, "messages")}>Messages</a>
            </li>
          </ul>
        </div>
        <div class="tab-contents" data-tab={this.selectedTab}>
          <div class={`tab-content ${this.selectedTab === "messages" && "show"}`}>{this.renderMessages()}</div>
        </div>
      </div>
    );
  }
}
