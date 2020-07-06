import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { FileHeader } from "../../../model/TIE";
import { TIEFileHeaderController } from "../../../controllers/TIE";

@Component({
  tag: "pyrite-TIE-file-header",
  styleUrl: "file-header.scss",
  shadow: false
})
export class TIEFileHeaderComponent {
  @Element() public el: HTMLElement;
  @Prop() public fileheader: FileHeader;

  private controller: TIEFileHeaderController;

  public componentWillLoad(): void {
    this.controller = new TIEFileHeaderController(this.fileheader);
  }

  public render(): JSX.Element {
    return (
      <Host>
      {this.controller.render("PlatformID")}
      {this.controller.render("NumFGs")}
      {this.controller.render("NumMessages")}
      {this.controller.render("NumGGs")}
      {this.controller.render("Unknown1")}
      {this.controller.render("Unknown2")}
      {this.controller.render("BriefingOfficers")}
      {this.controller.render("CapturedOnEject")}
      {this.controller.render("EndOfMissionMessages")}
      {this.controller.render("OtherIffNames")}        
      </Host>
    )
  }
}
  