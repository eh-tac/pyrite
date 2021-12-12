# ehtc-member-select



<!-- Auto Generated Below -->


## Properties

| Property | Attribute | Description | Type                     | Default       |
| -------- | --------- | ----------- | ------------------------ | ------------- |
| `domain` | `domain`  |             | `string`                 | `undefined`   |
| `filter` | `filter`  |             | `string`                 | `""`          |
| `mode`   | `mode`    |             | `"character" \| "pilot"` | `"character"` |
| `name`   | `name`    |             | `string`                 | `undefined`   |
| `status` | `status`  |             | `"active" \| "all"`      | `"active"`    |
| `value`  | `value`   |             | `string`                 | `undefined`   |


## Events

| Event          | Description | Type                                            |
| -------------- | ----------- | ----------------------------------------------- |
| `memberSelect` |             | `CustomEvent<CharacterSummary \| PilotSummary>` |


## Methods

### `search(query: string) => Promise<void>`



#### Returns

Type: `Promise<void>`



### `setValue(val: string | number) => Promise<void>`



#### Returns

Type: `Promise<void>`




----------------------------------------------

*Built with [StencilJS](https://stenciljs.com/)*
