import { Component, h, JSX, Method, Prop, State, Watch } from "@stencil/core";
import { Mission } from "../../../model/TIE/mission";
import { PreMissionQuestions } from "../../../model/TIE/pre-mission-questions";

type DisplayMode = "Officer" | "Secret" | "Table";

@Component({
  tag: "pyrite-frown",
  styleUrl: "frown.scss",
  shadow: true
})
export class PreMissionQuestionsComponent {
  @Prop() public mission: Mission;
  @Prop() public showButtons: boolean = true;

  @State() private officer: PreMissionQuestions[];
  @State() private secret: PreMissionQuestions[];
  @State() private displayMode: "Officer" | "Secret" | "Table" = "Table";
  @State() private selected: PreMissionQuestions;

  private modes: DisplayMode[] = [];

  public componentWillLoad(): void {
    this.init();
  }

  @Watch("mission")
  public init(): void {
    if (this.mission) {
      this.officer = this.mission.officerBriefing;
      this.secret = this.mission.secretBriefing;
      this.modes = ["Officer"];
      if (this.secret && this.secret.length) {
        this.modes.push("Secret");
      }
      this.modes.push("Table");
    }
  }

  public render(): JSX.Element {
    return (
      <div class="wrapper">
        <div class="btn-group" role="group" aria-label="Pre Mission Question Mode Selector">
          {this.showButtons &&
            this.modes.map(mode => (
              <button type="button" class="btn btn-info" onClick={this.modeSelect.bind(this, mode)}>
                {mode}
              </button>
            ))}
        </div>
        {this.renderMode()}
      </div>
    );
  }

  @Method()
  public async modeSelect(mode: "Officer" | "Secret" | "Table"): Promise<void> {
    this.displayMode = mode;
    this.selected = undefined;
  }

  private renderText(text: string): JSX.Element[] {
    let out: JSX.Element[] = [];
    let current: string = "";
    for (let i = 0; i < text.length; i++) {
      const code = text.charCodeAt(i);
      if (code === 2) {
        // open special; current gets added as normal.
        out.push(<span class="normal">{current}</span>);
        current = "";
      } else if (code === 1) {
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

  private renderMode(): JSX.Element {
    let questions = this.officer || [];
    switch (this.displayMode) {
      case "Table":
        questions = questions.concat(this.secret || []);
        return (
          <table class="table table-striped table-dark table-bordered">
            <thead class="thead-light">
              <tr>
                <th>Type</th>
                <th>Question</th>
                <th>Answer</th>
              </tr>
            </thead>
            <tbody>
              {questions.map(question => (
                <tr>
                  <td class="type">{question.Type}</td>
                  <td class="question">{question.Question}</td>
                  <td class="answer">{question.Answer}</td>
                </tr>
              ))}
            </tbody>
          </table>
        );
      case "Secret":
        questions = this.secret;
      case "Officer":
        return (
          <div class={`image-wrapper tietext ${this.displayMode}`}>
            <div class="answer">{this.renderText(this.selected ? this.selected.Answer : "")}</div>
            <div class="questions">
              <ul>
                {questions.map((question: PreMissionQuestions) => {
                  return <li onClick={this.selectQuestion.bind(this, question)}>{question.Question}</li>;
                })}
                <li onClick={this.selectQuestion.bind(this, undefined)}>That is enough for now, sir.</li>
              </ul>
            </div>
          </div>
        );
    }
  }

  private selectQuestion(question: PreMissionQuestions): void {
    this.selected = question;
  }
}
