import { Component, Prop } from '@stencil/core';
import type { JSX } from '@stencil/core/jsx-runtime';

@Component({
  tag: 'material-icon',
  shadow: true,
})
export class MaterialIcon {
  @Prop() name: string = 'star';

  public render(): JSX.Element {
    return <span class="material-symbols-outlined">{this.name}</span>;
  }
}
