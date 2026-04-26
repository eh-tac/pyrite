import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { PilotFile } from "../../../model/XW";
import { XWPilotFileController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xw-pilot-file",
  styleUrl: "pilot-file.scss",
  shadow: false
})
export class XWPilotFileComponent {
  @Element() public el: HTMLElement;
  @Prop() public pilotfile: PilotFile;

  private controller: XWPilotFileController;

  public componentWillLoad(): void {
    this.controller = new XWPilotFileController(this.pilotfile);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("PlatformID")} />
        <Field {...this.controller.getProps("PilotStatus")} />
        <Field {...this.controller.getProps("PilotRank")} />
        <Field {...this.controller.getProps("TotalTODScore")} />
        <Field {...this.controller.getProps("RookieNumber")} />
        <Field {...this.controller.getProps("TODMedals")} />
        <Field {...this.controller.getProps("KalidorCrescent")} />
        <Field {...this.controller.getProps("MazeScore")} />
        <Field {...this.controller.getProps("MazeLevel")} />
        <Field {...this.controller.getProps("XWingHistoricalScore")} />
        <Field {...this.controller.getProps("YWingHistoricalScore")} />
        <Field {...this.controller.getProps("AWingHistoricalScore")} />
        <Field {...this.controller.getProps("BWingHistoricalScore")} />
        <Field {...this.controller.getProps("BonusHistoricalScore")} />
        <Field {...this.controller.getProps("XWingHistoricalComplete")} />
        <Field {...this.controller.getProps("YWingHistoricalComplete")} />
        <Field {...this.controller.getProps("AWingHistoricalComplete")} />
        <Field {...this.controller.getProps("BWingHistoricalComplete")} />
        <Field {...this.controller.getProps("BonusHistoricalComplete")} />
        <Field {...this.controller.getProps("TourStatus")} />
        <Field {...this.controller.getProps("TourOperationsComplete")} />
        <Field {...this.controller.getProps("Tour1Scores")} />
        <Field {...this.controller.getProps("Tour2Scores")} />
        <Field {...this.controller.getProps("Tour3Scores")} />
        <Field {...this.controller.getProps("Tour4Scores")} />
        <Field {...this.controller.getProps("Tour5Scores")} />
        <Field {...this.controller.getProps("SurfaceVictories")} />
        <Field {...this.controller.getProps("TODKills")} />
        <Field {...this.controller.getProps("TODCaptures")} />
        <Field {...this.controller.getProps("LasersFired")} />
        <Field {...this.controller.getProps("LaserCraftHits")} />
        <Field {...this.controller.getProps("LaserGroundHits")} />
        <Field {...this.controller.getProps("MissilesFired")} />
        <Field {...this.controller.getProps("MissileCraftHits")} />
        <Field {...this.controller.getProps("MissileGroundHits")} />
        <Field {...this.controller.getProps("CraftLost")} />
      </Host>
    );
  }
}
