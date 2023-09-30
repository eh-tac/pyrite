import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Briefing } from "../../../model/XW";
import { XWBriefingController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xw-briefing",
  styleUrl: "briefing.scss",
  shadow: false
})
export class XWBriefingComponent {
  @Element() public el: HTMLElement;
  @Prop() public briefing: Briefing;

  private controller: XWBriefingController;

  public componentWillLoad(): void {
    this.controller = new XWBriefingController(this.briefing);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('BriefingHeader')} />
        <Field {...this.controller.getProps('Coordinates')} />
        <Field {...this.controller.getProps('IconSet')} />
        <Field {...this.controller.getProps('WindowSettingsCount')} />
        <Field {...this.controller.getProps('Viewports')} />
        <Field {...this.controller.getProps('PageCount')} />
        <Field {...this.controller.getProps('Pages')} />
        <Field {...this.controller.getProps('MissionHeader')} />
        <Field {...this.controller.getProps('IconExtraData')} />
        <Field {...this.controller.getProps('Tags')} />
        <Field {...this.controller.getProps('Strings')} />
      </Host>
    )
  }
}
  