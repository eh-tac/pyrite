# Emperor's Hammer API client

This package generates a typed, read-only Fetch client from the bundled
`openapi.yaml` specification using Hey API. The default base URL is
`https://api.emperorshammer.org`.

From the repository root:

```sh
npm install --ignore-scripts
npm run generate --workspace @pyrite/ehtc-api
npm run build --workspace @pyrite/ehtc-api
```

The generator writes `src/generated/`. Do not edit those files by hand. To update
the API surface, replace `openapi.yaml` with the latest spec and regenerate.

```ts
import { client, getMemberByPin } from '@pyrite/ehtc-api';

client.setConfig({ baseUrl: 'https://tc.emperorshammer.org/api' });

const { data, error } = await getMemberByPin({ path: { pin: 12345 } });
```

The generated endpoint functions accept a `client` option for per-request client
instances created with `createClient()`. Errors are returned in the `error` field
unless the request is configured to throw.
