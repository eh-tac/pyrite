import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { ViewportSetting } from "../../../model/XW";
import { XWViewportSettingController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xw-viewport-setting",
  styleUrl: "viewport-setting.scss",
  shadow: false
})
export class XWViewportSettingComponent {
  @Element() public el: HTMLElement;
  @Prop() public viewportsetting: ViewportSetting;

  private controller: XWViewportSettingController;

  public componentWillLoad(): void {
    this.controller = new XWViewportSettingController(this.viewportsetting);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Top')} />
        <Field {...this.controller.getProps('Left')} />
        <Field {...this.controller.getProps('Bottom')} />
        <Field {...this.controller.getProps('Right')} />
        <Field {...this.controller.getProps('Visible')} />
      </Host>
    )
  }
}
  