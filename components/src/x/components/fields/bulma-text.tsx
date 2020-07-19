import { BulmaColour, FieldAttr, BulmaSizes, sizes } from "./bulma-helpers";
import { FunctionalComponent, h } from "@stencil/core";

interface Attr extends BulmaColour, FieldAttr, BulmaSizes {
  placeholder?: string;
}

export const BulmaText: FunctionalComponent<Attr> = (props: Attr) => {
  return (
    <input
      class={{
        input: true,
        ...sizes(props)
      }}
      placeholder={props.placeholder}
      value={props.value}
    />
  );
};
