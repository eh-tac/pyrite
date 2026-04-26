import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTConnectedPlayerData } from "../../../model/XvT";
import { XvTPLTConnectedPlayerDataController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-connected-player-data",
  styleUrl: "plt-connected-player-data.scss",
  shadow: false
})
export class XvTPLTConnectedPlayerDataComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltconnectedplayerdata: PLTConnectedPlayerData;

  private controller: XvTPLTConnectedPlayerDataController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTConnectedPlayerDataController(this.pltconnectedplayerdata);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('pilotLongNameUnused')} />
        <Field {...this.controller.getProps('pilotShortName')} />
        <Field {...this.controller.getProps('fgIndex')} />
        <Field {...this.controller.getProps('DPPlayerID')} />
        <Field {...this.controller.getProps('pilotRank')} />
        <Field {...this.controller.getProps('playerScore')} />
        <Field {...this.controller.getProps('fullKills')} />
        <Field {...this.controller.getProps('sharedKills')} />
        <Field {...this.controller.getProps('unusedInspections')} />
        <Field {...this.controller.getProps('assistKills')} />
        <Field {...this.controller.getProps('losses')} />
        <Field {...this.controller.getProps('craftType')} />
        <Field {...this.controller.getProps('optionalCraftIndex')} />
        <Field {...this.controller.getProps('optionalWarhead')} />
        <Field {...this.controller.getProps('optionalBeam')} />
        <Field {...this.controller.getProps('optionalCountermeasure')} />
        <Field {...this.controller.getProps('hasDisconnectedFromHostUNK')} />
      </Host>
    )
  }
}
  