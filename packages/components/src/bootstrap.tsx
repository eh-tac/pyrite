import type { JSX } from '@stencil/core/jsx-runtime';

export function tabPanes(tabs: [string, JSX.Element][], activeTab: string, tabClick: (select: string) => void) {
  return (
    <div class="pyrite-tab-pane">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        {tabs.map(tab => {
          const name = tab[0];
          const low = name.toLowerCase();
          const isOn = low === activeTab;

          return (
            <li class="nav-item">
              <a
                class={`nav-link border-0 ${isOn ? 'active' : ''}`}
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
          const isOn = low === activeTab;

          return (
            <div
              class={`tab-pane fade ${isOn ? 'show active' : ''}`}
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
