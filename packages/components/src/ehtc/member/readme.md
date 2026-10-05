# ehtc-member-select



<!-- Auto Generated Below -->


## Properties

| Property   | Attribute  | Description | Type                                          | Default       |
| ---------- | ---------- | ----------- | --------------------------------------------- | ------------- |
| `disabled` | `disabled` |             | `boolean`                                     | `false`       |
| `domain`   | `domain`   |             | `string`                                      | `''`          |
| `filter`   | `filter`   |             | `string`                                      | `''`          |
| `mode`     | `mode`     |             | `"character" \| "member" \| "member-aliases"` | `'character'` |
| `name`     | `name`     |             | `string`                                      | `''`          |
| `readonly` | `readonly` |             | `boolean`                                     | `false`       |
| `status`   | `status`   |             | `"active" \| "all"`                           | `'active'`    |
| `value`    | `value`    |             | `string`                                      | `''`          |


## Events

| Event          | Description | Type                                                                                                                                                                                                                            |
| -------------- | ----------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `memberSelect` |             | `CustomEvent<{ PIN: number; characterId: number; label: string; description: string; profile: string; subgroupLabel: string; subgroupName: string; } \| { PIN: number; label: string; description: string; profile: string; }>` |


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
