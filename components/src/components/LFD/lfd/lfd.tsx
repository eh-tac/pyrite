import { Component, Prop, Host, State, h, JSX, Element, Method } from "@stencil/core";
import { LFD, Rmap } from "../../../model/LFD";
import { LFDController } from "../../../controllers/LFD";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-lfd",
  styleUrl: "lfd.scss",
  shadow: false
})
export class LFDComponent {
  @Element() public el: HTMLElement;
  @Prop() public file: string;
  @State() public lfd: LFD;

  private controller: LFDController;

  @Method()
  public loadArrayBuffer(value: ArrayBuffer): Promise<void> {
    this.lfd = LFD.load(value);
    this.controller = new LFDController(this.lfd);
    return Promise.resolve();
  }

  public componentWillLoad(): void {
    if (!this.file) {
      return;
    }
    fetch(this.file)
      .then((res: Response) => res.arrayBuffer())
      .then((value: ArrayBuffer) => {
        this.loadArrayBuffer(value);
      });
  }

  public render(): JSX.Element {
    if (!this.lfd) {
      return <p>Loading...!!</p>;
    }
    let comp = <Field {...this.controller.getProps("Header")} />;
    if (this.lfd instanceof Rmap) {
      comp = <pyrite-lfd-rmap rmap={this.lfd} />;
    }
    return <Host>{comp}</Host>;
  }
}
