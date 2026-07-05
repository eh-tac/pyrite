export interface FieldAttr {
  value: any;
  onChange: (e: Event) => void;
}

export interface BulmaColour {
  "is-primary"?: boolean;
  "is-info"?: boolean;
  "is-success"?: boolean;
  "is-warning"?: boolean;
  "is-danger"?: boolean;
}

export interface BulmaSizes {
  isSmall?: boolean;
  isMedium?: boolean;
  isLarge?: boolean;
}

export const sizes = (props: BulmaSizes): object => {
  return { "is-small": props.isSmall, "is-medium": props.isMedium, "is-large": props.isLarge };
};
