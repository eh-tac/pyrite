# AGENTS.md

## Project overview

Pyrite is a set of PHP and TypeScript libraries and web components for reading and displaying LucasArts X-Wing series game files. The PHP library lives in `lib/` and is exposed through the `Pyrite\` namespace. The older TypeScript implementation currently lives in `components/src/`, while newer package work is being moved into `packages/`; unless a task says otherwise, keep component-facing TypeScript changes in `components/src/`.

## Repository layout

- `lib/` - PHP library code, PSR-4 autoloaded as `Pyrite\`.
- `components/src/model/` - TypeScript model/parsing code used by the web components.
- `components/src/components/` - Stencil web components.
- `components/src/view-model/` - View/controller classes consumed by components.
- `fixtures/` - Binary and XML sample files used by tests.
- `tests/` - PHPUnit tests for the PHP library.
- `packages/` - Ongoing TypeScript package restructure; do not move existing component code here unless requested.

## Tooling notes

This workspace may be opened through a Windows UNC path. Some tools reject UNC paths or accidentally run Windows binaries from WSL. Prefer running commands inside the explicit WSL distro and project path:

```sh
wsl -d Ubuntu-22.04 -e bash -lc 'cd /home/tom/tiecorps/vendor/eh-tac/pyrite && <command>'
```

For Node commands in WSL, ensure the Linux nvm Node binary is first on `PATH`:

```sh
export PATH=/home/tom/.nvm/versions/node/v22.22.3/bin:$PATH
```

Useful validation commands:

```sh
./vendor/bin/phpunit --configuration phpunit.xml
npm --prefix components test -- --runTestsByPath src/model/XWVM/pilot-file.spec.ts
npm --prefix components run build
```

The Stencil build may generate untracked component `readme.md` files for components without existing docs. Do not keep those generated files unless the task explicitly asks for documentation output.

## PHP library consumption from another project

The PHP library is intended to be consumed through Composer/PSR-4 autoloading. Classes are under the `Pyrite\` namespace, for example:

```php
use Pyrite\XWVM\PilotFile;

$pilot = PilotFile::load('/path/to/LockeTestB.vmpilot');
$battle = $pilot->getBattle('XWVMTC2');
$completeBattles = $pilot->listCompleteBattles();
```

If using this repository locally from another project, configure it as a Composer path repository or otherwise make Composer autoload `Pyrite\\` from this repo's `lib/` directory.

## Current XWVM pilot parsing work

XWVM pilot files are XML `.vmpilot` files rather than binary pilot blobs. The implementation added:

- `lib/XWVM/PilotFile.php` for PHP parsing and XML validity checks.
- `components/src/model/XWVM/pilot-file.ts` for TypeScript parsing.
- `components/src/view-model/pilot-file/xwvm-controller.tsx` plus `.vmpilot` wiring in the generic pilot-file component.
- PHPUnit and Jest coverage for the XWVM fixtures in `fixtures/xwvm/`.

XWVM mission names such as `XWVMTC2M1` are parsed into battle code `XWVMTC2` and mission number `1`. Named mission records with a score but without `Complete="true"` are included with `completed: false`; unnamed placeholder records are ignored. Both PHP and TypeScript models expose `listCompleteBattles()` and `getBattle(code)` helpers.
