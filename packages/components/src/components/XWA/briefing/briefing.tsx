import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Briefing } from "../../../model/XWA";
import { XWABriefingController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-briefing",
  styleUrl: "briefing.scss",
  shadow: false
})
export class XWABriefingComponent {
  @Element() public el: HTMLElement;
  @Prop() public briefing: Briefing;

  private controller: XWABriefingController;

  public componentWillLoad(): void {
    this.controller = new XWABriefingController(this.briefing);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('RunningTime')} />
        <Field {...this.controller.getProps('Unknown1')} />
        <Field {...this.controller.getProps('StartLength')} />
        <Field {...this.controller.getProps('EventsLength')} />
        <Field {...this.controller.getProps('Unnamed')} />
        <Field {...this.controller.getProps('ShowToTeams')} />
      </Host>
    )
  }
}
  