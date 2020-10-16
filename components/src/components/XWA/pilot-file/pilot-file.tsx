import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PilotFile } from "../../../model/XWA";
import { XWAPilotFileController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-pilot-file",
  styleUrl: "pilot-file.scss",
  shadow: false
})
export class XWAPilotFileComponent {
  @Element() public el: HTMLElement;
  @Prop() public pilotfile: PilotFile;

  private controller: XWAPilotFileController;

  public componentWillLoad(): void {
    this.controller = new XWAPilotFileController(this.pilotfile);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Name')} />
        <Field {...this.controller.getProps('TotalScore')} />
        <Field {...this.controller.getProps('TourOfDutyScore')} />
        <Field {...this.controller.getProps('AzzameenScore')} />
        <Field {...this.controller.getProps('SimulatorScore')} />
        <Field {...this.controller.getProps('TourOfDutyKills')} />
        <Field {...this.controller.getProps('AzzameenKills')} />
        <Field {...this.controller.getProps('SimulatorKills')} />
        <Field {...this.controller.getProps('TourOfDutyPartials')} />
        <Field {...this.controller.getProps('AzzameenPartials')} />
        <Field {...this.controller.getProps('SimulatorPartials')} />
        <Field {...this.controller.getProps('LasersHit')} />
        <Field {...this.controller.getProps('LasersFired')} />
        <Field {...this.controller.getProps('WarheadsHit')} />
        <Field {...this.controller.getProps('WarheadsFired')} />
        <Field {...this.controller.getProps('CraftLosses')} />
        <Field {...this.controller.getProps('MissionData')} />
        <Field {...this.controller.getProps('CurrentRank')} />
        <Field {...this.controller.getProps('CurrentMedal')} />
        <Field {...this.controller.getProps('BonusTen')} />
      </Host>
    )
  }
}
  