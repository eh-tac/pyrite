import js from '@eslint/js';
import unicorn from 'eslint-plugin-unicorn';
import globals from 'globals';
import simpleImportSort from 'eslint-plugin-simple-import-sort';
import tsPlugin from '@typescript-eslint/eslint-plugin';
import tsParser from '@typescript-eslint/parser';
import stencil from '@stencil/eslint-plugin';
import { setSyntheticTrailingComments } from 'typescript';

export default [
  {
    ignores: ['**/dist/**', '**/node_modules/**', '**/*.d.ts']
  },
  js.configs.recommended,
  {
    files: ['packages/**/*.ts'],
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
      unicorn,
      'simple-import-sort': simpleImportSort
    },
    rules: {
      ...tsPlugin.configs.recommended.rules,
      ...unicorn.configs['flat/recommended'].rules,
      '@typescript-eslint/consistent-type-imports': 'error',
      'simple-import-sort/exports': 'error',
      'simple-import-sort/imports': 'error',
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
      'unicorn/no-array-reduce': 'warn',
      'unicorn/require-array-sort-compare': 'warn',
      'unicorn/prefer-code-point': 'warn',
      'unicorn/prefer-spread': 'off',
      'unicorn/no-computed-property-existence-check': 'warn'
    }
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
  // {
  // FFS many things are still incompatible with eslint 10
  //   files: ['packages/components/**/*.ts', 'packages/components/**/*.tsx'],
  //   ...stencil.configs.flat.recommended
  // }
];
