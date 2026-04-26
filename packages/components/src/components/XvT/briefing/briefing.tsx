import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Briefing } from "../../../model/XvT";
import { XvTBriefingController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-briefing",
  styleUrl: "briefing.scss",
  shadow: false
})
export class XvTBriefingComponent {
  @Element() public el: HTMLElement;
  @Prop() public briefing: Briefing;

  private controller: XvTBriefingController;

  public componentWillLoad(): void {
    this.controller = new XvTBriefingController(this.briefing);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('RunningTime')} />
        <Field {...this.controller.getProps('Unknown1')} />
        <Field {...this.controller.getProps('StartEvents')} />
        <Field {...this.controller.getProps('EventsLength')} />
        <Field {...this.controller.getProps('Events')} />
        <Field {...this.controller.getProps('Tags')} />
        <Field {...this.controller.getProps('Strings')} />
      </Host>
    )
  }
}
  