# ehtc-api-select



<!-- Auto Generated Below -->


## Properties

| Property             | Attribute             | Description | Type                   | Default     |
| -------------------- | --------------------- | ----------- | ---------------------- | ----------- |
| `displayDescription` | `display-description` |             | `"none" \| "subtitle"` | `undefined` |
| `displayId`          | `display-id`          |             | `"left" \| "right"`    | `undefined` |
| `domain`             | `domain`              |             | `string`               | `undefined` |
| `item`               | --                    |             | `ApiSummary`           | `undefined` |
| `name`               | `name`                |             | `string`               | `undefined` |
| `url`                | `url`                 |             | `string`               | `undefined` |
| `value`              | `value`               |             | `string`               | `undefined` |


## Events

| Event       | Description | Type                      |
| ----------- | ----------- | ------------------------- |
| `apiSelect` |             | `CustomEvent<ApiSummary>` |


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
