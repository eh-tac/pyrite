import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { OpCode } from "../../../model/LFD";
import { LFDOpCodeController } from "../../../controllers/LFD";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-lfd-op-code",
  styleUrl: "op-code.scss",
  shadow: false
})
export class LFDOpCodeComponent {
  @Element() public el: HTMLElement;
  @Prop() public opcode: OpCode;

  private controller: LFDOpCodeController;

  public componentWillLoad(): void {
    this.controller = new LFDOpCodeController(this.opcode);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Value')} />
        <Field {...this.controller.getProps('ColorIndex')} />
      </Host>
    )
  }
}
  