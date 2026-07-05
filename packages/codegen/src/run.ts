import * as fs from 'fs';
import { PyriteGenerator } from './generator';
import { TypeScriptWriter } from './typescript/typescript-writer';
import { PHPWriter } from './php/php-writer';
import path from 'path';

const repoRoot = path.resolve(import.meta.dirname, '..', '..', '..');
const phpLibPath = path.join(repoRoot, 'lib');
const packages = path.join(repoRoot, 'packages');

function mg(plt: string): PyriteGenerator {
  return new PyriteGenerator(
    plt,
    fs.readFileSync(path.join(repoRoot, 'schema', plt, `structs.txt`), { encoding: 'utf8' }),
    fs.readFileSync(path.join(repoRoot, 'schema', plt, `const.txt`), { encoding: 'utf8' })
  );
}

// make generators
const [tieG, xwG, xvtG, xwaG, lfdG, puzG] = [
  mg('TIE'),
  mg('XW'),
  mg('XvT'),
  mg('XWA'),
  mg('LFD'),
  mg('Puz')
];

// make writers
[
  new TypeScriptWriter(packages, tieG),
  new PHPWriter(phpLibPath, tieG),
  new TypeScriptWriter(packages, xwG),
  new PHPWriter(phpLibPath, xwG),
  new TypeScriptWriter(packages, xvtG),
  new PHPWriter(phpLibPath, xvtG),
  new TypeScriptWriter(packages, xwaG),
  new PHPWriter(phpLibPath, xwaG),
  new TypeScriptWriter(packages, lfdG),
  new PHPWriter(phpLibPath, lfdG)
].forEach((writer) => writer.write());
