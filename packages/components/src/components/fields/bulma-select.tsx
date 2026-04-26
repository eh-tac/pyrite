import { FunctionalComponent, h } from "@stencil/core";
import { BulmaColour, FieldAttr, BulmaSizes, sizes } from "./bulma-helpers";

interface Attr extends BulmaColour, FieldAttr, BulmaSizes {
  value: number;
  options: { [key: number]: string };
  isMultiple?: boolean;
  isRounded?: boolean;
}

export const BulmaSelect: FunctionalComponent<Attr> = (props: Attr) => {
  const options: [number, string][] = Object.entries(props.options).map(([value, label]) => [parseInt(value), label]);
  return (
    <div
      class={{
        select: true,
        "is-multiple": props.isMultiple,
        "is-rounded": props.isRounded,
        ...sizes(props)
      }}
    >
      <select multiple={props.isMultiple} onChange={props.onChange}>
        {options.map(([value, label]) => (
          <option value={value} selected={value === props.value}>
            {label}
          </option>
        ))}
      </select>
    </div>
  );
};
