import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PilotFile } from "../../../model/XvT";
import { XvTPilotFileController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-pilot-file",
  styleUrl: "pilot-file.scss",
  shadow: false
})
export class XvTPilotFileComponent {
  @Element() public el: HTMLElement;
  @Prop() public pilotfile: PilotFile;

  private controller: XvTPilotFileController;

  public componentWillLoad(): void {
    this.controller = new XvTPilotFileController(this.pilotfile);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Name')} />
        <Field {...this.controller.getProps('TotalScore')} />
        <Field {...this.controller.getProps('Kills')} />
        <Field {...this.controller.getProps('LasersHit')} />
        <Field {...this.controller.getProps('LasersTotal')} />
        <Field {...this.controller.getProps('WarheadsHit')} />
        <Field {...this.controller.getProps('WarheadsTotal')} />
        <Field {...this.controller.getProps('CraftLosses')} />
        <Field {...this.controller.getProps('PilotRating')} />
        <Field {...this.controller.getProps('RatingLabel')} />
        <Field {...this.controller.getProps('RebelStats')} />
        <Field {...this.controller.getProps('ImperialStats')} />
      </Host>
    )
  }
}
  