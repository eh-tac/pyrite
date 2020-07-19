import { JSX, h, FunctionalComponent } from "@stencil/core";
import { BulmaSelect } from "./bulma-select";
import { BulmaText } from "./bulma-text";
import { FieldAttr } from "../../controller-base";

export const Field: FunctionalComponent<FieldAttr> = (props: FieldAttr) => {
  const label = props.label || props.name;

  let field = <input class="input is-small" type="text" value={props && props.value} />;
  if (props.type === "select") {
    field = (
      <BulmaSelect
        options={props.options}
        isSmall={true}
        value={props.value}
        onChange={(e: Event) => {
          props.model[props.name] = parseInt((e.target as HTMLSelectElement).value);
        }}
      />
    );
  } else if (props.type === "CHAR") {
    field = (
      <BulmaText
        placeholder={label}
        isSmall={true}
        value={props.value}
        onChange={(e: Event) => {
          props.model[props.name] = (e.target as HTMLInputElement).value;
        }}
      />
    );
  }

  return (
    <div class="field is-horizontal">
      <div class="field-label is-small">
        <label class="label">{label}</label>
      </div>
      <div class="field-body">
        <div class="field">
          <div class="control">{field}</div>
        </div>
      </div>
    </div>
  );
};
