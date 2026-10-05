import js from '@eslint/js';
import unicorn from 'eslint-plugin-unicorn';
import globals from 'globals';
import tsPlugin from '@typescript-eslint/eslint-plugin';
import tsParser from '@typescript-eslint/parser';
import stencil from '@stencil/eslint-plugin';

export default [
  {
    ignores: ['**/dist/**', '**/node_modules/**', '**/*.d.ts', 'packages/ehtc-api/src/generated/**']
  },
  js.configs.recommended,
  {
    files: ['packages/**/*.{ts,tsx}'],
    ...unicorn.configs['flat/recommended'],
    languageOptions: {
      parser: tsParser,
      parserOptions: {
        ecmaVersion: 'latest',
        sourceType: 'module'
      },
      globals: {
        ...globals.node,
        ...globals.jest
      }
    },
    plugins: {
      '@typescript-eslint': tsPlugin,
      unicorn
    },
    rules: {
      ...tsPlugin.configs.recommended.rules,
      ...unicorn.configs['flat/recommended'].rules,
      '@typescript-eslint/consistent-type-imports': 'error',
      'sort-imports': ['error', { ignoreDeclarationSort: true }],
      'unicorn/filename-case': 'off',
      'unicorn/import-style': 'off',
      'unicorn/name-replacements': 'off',
      'unicorn/no-null': 'off',
      'unicorn/number-literal-case': 'off',
      'unicorn/numeric-separators-style': 'off',
      'unicorn/prefer-module': 'off',
      'unicorn/consistent-compound-words': 'off',
      'unicorn/no-useless-template-literals': 'off',
      'no-useless-assignment': 'off',
      'unicorn/consistent-class-member-order': [
        2,
        {
          order: [
            'static-field',
            'static-block',
            'static-method',
            'public-field',
            'private-field',
            'constructor',
            'public-method',
            'private-method'
          ]
        }
      ],
      'unicorn/max-nested-calls': ['error', { max: 5 }],
      'unicorn/operator-assignment': 'off',
      'unicorn/no-for-each': 'warn',
      'unicorn/no-array-sort': 'warn',
      'unicorn/no-array-reduce': 'off',
      'unicorn/require-array-sort-compare': 'warn',
      'unicorn/prefer-code-point': 'warn',
      'unicorn/prefer-spread': 'off',
      'unicorn/no-computed-property-existence-check': 'warn',
      'unicorn/no-declaration-before-early-exit': 'off'
    }
  },
  {
    files: ['packages/components/**/*.{ts,tsx}'],
    rules: Object.fromEntries(Object.keys(unicorn.rules).map((rule) => [`unicorn/${rule}`, 'off']))
  },
  {
    files: ['packages/components/src/**/*.{ts,tsx}'],
    languageOptions: {
      parserOptions: {
        project: './packages/components/tsconfig.json',
        tsconfigRootDir: import.meta.dirname
      }
    },
    plugins: stencil.configs.flat.recommended.plugins,
    rules: stencil.configs.flat.recommended.rules
  },
  {
    files: ['packages/codegen/**/*.ts'],
    rules: {
      '@typescript-eslint/no-explicit-any': 'off',
      '@typescript-eslint/no-unused-vars': 'off',
      'no-useless-escape': 'off'
    }
  },
  {
    files: ['packages/core/**/*.ts'],
    rules: {
      '@typescript-eslint/no-explicit-any': 'off'
    }
  }
];
