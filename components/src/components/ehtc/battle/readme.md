# ehtc-battle-select



<!-- Auto Generated Below -->


## Properties

| Property   | Attribute  | Description | Type            | Default     |
| ---------- | ---------- | ----------- | --------------- | ----------- |
| `battle`   | --         |             | `BattleSummary` | `undefined` |
| `category` | `category` |             | `string`        | `undefined` |
| `disabled` | `disabled` |             | `boolean`       | `undefined` |
| `domain`   | `domain`   |             | `string`        | `undefined` |
| `name`     | `name`     |             | `string`        | `undefined` |
| `readonly` | `readonly` |             | `boolean`       | `undefined` |
| `value`    | `value`    |             | `string`        | `undefined` |


## Events

| Event          | Description | Type                         |
| -------------- | ----------- | ---------------------------- |
| `battleSelect` |             | `CustomEvent<BattleSummary>` |


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
