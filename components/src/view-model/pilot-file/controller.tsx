import { JSX, h } from "@stencil/core";
import { Battle } from "../../model/ehtc";

export abstract class PilotFileController {
  public tabs: [string, JSX.Element][] = [];
  constructor(public filepath: string) {}

  public get filename(): string {
    if (this.filepath) {
      return this.filepath.split("/").pop();
    }
    return "";
  }

  public abstract renderTabs(battleData: Battle): [string, JSX.Element][];

  protected renderItem(key: string, value: string | number, subtitle?: string, className?: string): JSX.Element {
    const vClass = className && className.includes("text-") ? className : "text-info";
    return (
      <li class={`list-group-item kv data d-flex justify-content-between ${className || ""}`}>
        <h6 class="my-0">{key}</h6>
        <div class="d-flex flex-column">
          <span class={vClass}>{value}</span>
          {subtitle && <small class="text-light text-right">{subtitle}</small>}
        </div>
      </li>
    );
  }

  protected percentage(missionScore: number, highScore: number): string {
    return `${Math.round((missionScore / highScore) * 10000) / 100} %`;
  }
}
