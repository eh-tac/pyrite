import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Briefing } from "../../../model/TIE";
import { TIEBriefingController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "xpyrite-tie-briefing",
  styleUrl: "briefing.scss",
  shadow: false
})
export class TIEBriefingComponent {
  @Element() public el: HTMLElement;
  @Prop() public briefing: Briefing;

  private controller: TIEBriefingController;

  public componentWillLoad(): void {
    this.controller = new TIEBriefingController(this.briefing);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('RunningTime')} />
        <Field {...this.controller.getProps('Unknown')} />
        <Field {...this.controller.getProps('StartLength')} />
        <Field {...this.controller.getProps('EventsLength')} />
        <Field {...this.controller.getProps('Events')} />
        <Field {...this.controller.getProps('Tags')} />
        <Field {...this.controller.getProps('Strings')} />
      </Host>
    )
  }
}
  