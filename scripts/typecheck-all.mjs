import { spawnSync } from 'node:child_process';
import { createRequire } from 'node:module';

const require = createRequire(import.meta.url);
const tscPath = require.resolve('typescript/bin/tsc');

const projectConfigs = [
  //   'components/tsconfig.json',
  //   'components/tsconfig.commonjs.json',
  'packages/codegen/tsconfig.json',
  'packages/components/tsconfig.json',
  'packages/core/tsconfig.json',
  'packages/lfd/tsconfig.json',
  'packages/tie/tsconfig.json',
  'packages/xvt/tsconfig.json',
  'packages/xwa/tsconfig.json',
  'packages/xw/tsconfig.json',
  'packages/xw/src/tests/tsconfig.json'
];

const failedProjects = [];

for (const configPath of projectConfigs) {
  console.log(`\n== Type-checking ${configPath} ==`);

  const result = spawnSync(
    process.execPath,
    [tscPath, '--project', configPath, '--noEmit', '--pretty', 'false'],
    {
      cwd: process.cwd(),
      stdio: 'inherit'
    }
  );

  if (result.status !== 0) {
    failedProjects.push(configPath);
  }
}

if (failedProjects.length > 0) {
  console.error('\nTypeScript compile check failed for:');
  for (const configPath of failedProjects) {
    console.error(`- ${configPath}`);
  }
  process.exit(1);
}

console.log('\nAll TypeScript projects compiled successfully.');
