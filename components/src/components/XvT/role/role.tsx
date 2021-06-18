import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Role } from "../../../model/XvT";
import { XvTRoleController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-role",
  styleUrl: "role.scss",
  shadow: false
})
export class XvTRoleComponent {
  @Element() public el: HTMLElement;
  @Prop() public role: Role;

  private controller: XvTRoleController;

  public componentWillLoad(): void {
    this.controller = new XvTRoleController(this.role);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Team')} />
        <Field {...this.controller.getProps('Designation')} />
      </Host>
    )
  }
}
  