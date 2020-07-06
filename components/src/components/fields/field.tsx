import { JSX, h, FunctionalComponent } from "@stencil/core";
import { IFielder, DataType } from "../../model/pyrite-base";
import { BulmaSelect } from "./bulma-select";
import { BulmaText } from "./bulma-text";

interface FieldAttr {
  fielder: IFielder;
  name: string;
  label?: string;
}

export const Field: FunctionalComponent<FieldAttr> = (props: FieldAttr) => {
  const fieldProps = props.fielder.field(props.name);
  if (!fieldProps) {
    console.error("Unable to load field props", props.name, " from ", props.fielder, props);
    return "";
  }
  const label = props.label || props.name;

  let field = <input class="input is-small" type="text" value={fieldProps && fieldProps.value} />;
  if (fieldProps.type === DataType.SELECT) {
    field = (
      <BulmaSelect
        options={fieldProps.options}
        isSmall={true}
        value={fieldProps.value}
        onChange={(e: Event) => {
          props.fielder[props.name] = parseInt((e.target as HTMLSelectElement).value);
        }}
      />
    );
  } else if (fieldProps.type === DataType.char) {
    field = (
      <BulmaText
        placeholder={label}
        isSmall={true}
        value={fieldProps.value}
        onChange={(e: Event) => {
          props.fielder[props.name] = (e.target as HTMLInputElement).value;
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
