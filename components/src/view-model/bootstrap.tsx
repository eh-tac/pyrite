import { JSX, h } from "@stencil/core";

export function tabPanes(
  tabs: [string, JSX.Element][],
  activeTab: string,
  tabClick: (select: string) => void
): JSX.Element {
  return (
    <div class="pyrite-tab-pane">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        {tabs.map(tab => {
          const name = tab[0];
          const low = name.toLowerCase();
          const on = low === activeTab;

          return (
            <li class="nav-item">
              <a
                class={`nav-link border-0 ${on ? "active" : ""}`}
                id={`${low}-tab`}
                data-toggle="tab"
                href={`#${low}`}
                role="tab"
                aria-controls={low}
                aria-selected="true"
                onClick={tabClick.bind(null, low)}
              >
                {name}
              </a>
            </li>
          );
        })}
      </ul>
      <div class="tab-content">
        {tabs.map(tab => {
          const name = tab[0];
          const content = tab[1];
          const low = name.toLowerCase();
          const on = low === activeTab;

          return (
            <div
              class={`tab-pane fade ${on ? "show active" : ""}`}
              id={low}
              role="tabpanel"
              aria-labelledby={`${low}-tab`}
            >
              {content}
            </div>
          );
        })}
      </div>
    </div>
  );
}
