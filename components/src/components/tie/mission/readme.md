# pyrite-tie-mission



<!-- Auto Generated Below -->


## Properties

| Property | Attribute | Description | Type     | Default     |
| -------- | --------- | ----------- | -------- | ----------- |
| `file`   | `file`    |             | `string` | `undefined` |


## Dependencies

### Depends on

- [pyrite-tie-flightgroups](../flightgroup)
- [pyrite-tie-messages](../message)

### Graph
```mermaid
graph TD;
  pyrite-tie-mission --> pyrite-tie-flightgroups
  pyrite-tie-mission --> pyrite-tie-messages
  pyrite-tie-flightgroups --> pyrite-tie-flightgroup
  pyrite-tie-messages --> pyrite-tie-message
  style pyrite-tie-mission fill:#f9f,stroke:#333,stroke-width:4px
```

----------------------------------------------

*Built with [StencilJS](https://stenciljs.com/)*
