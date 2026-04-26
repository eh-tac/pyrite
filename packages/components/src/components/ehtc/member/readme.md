# ehtc-member-select



<!-- Auto Generated Below -->


## Properties

| Property   | Attribute  | Description | Type                                          | Default       |
| ---------- | ---------- | ----------- | --------------------------------------------- | ------------- |
| `disabled` | `disabled` |             | `boolean`                                     | `undefined`   |
| `domain`   | `domain`   |             | `string`                                      | `undefined`   |
| `filter`   | `filter`   |             | `string`                                      | `""`          |
| `mode`     | `mode`     |             | `"character" \| "member" \| "member-aliases"` | `"character"` |
| `name`     | `name`     |             | `string`                                      | `undefined`   |
| `readonly` | `readonly` |             | `boolean`                                     | `undefined`   |
| `status`   | `status`   |             | `"active" \| "all"`                           | `"active"`    |
| `value`    | `value`    |             | `string`                                      | `undefined`   |


## Events

| Event          | Description | Type                                            |
| -------------- | ----------- | ----------------------------------------------- |
| `memberSelect` |             | `CustomEvent<CharacterSummary \| PilotSummary>` |


## Methods

### `search(query: string) => Promise<void>`



#### Parameters

| Name    | Type     | Description |
| ------- | -------- | ----------- |
| `query` | `string` |             |

#### Returns

Type: `Promise<void>`



### `setValue(val: string | number) => Promise<void>`



#### Parameters

| Name  | Type               | Description |
| ----- | ------------------ | ----------- |
| `val` | `string \| number` |             |

#### Returns

Type: `Promise<void>`




----------------------------------------------

*Built with [StencilJS](https://stenciljs.com/)*
