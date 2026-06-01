const path = require('node:path');

const createPackageJestConfig = (packageName) => ({
  displayName: packageName,
  rootDir: path.resolve(__dirname, 'packages', packageName),
  testEnvironment: 'node',
  moduleFileExtensions: ['ts', 'js', 'json'],
  testMatch: ['<rootDir>/src/**/*.test.ts'],
  transform: {
    '^.+\\.ts$': [
      '@swc/jest',
      {
        jsc: {
          target: 'es2022',
          parser: {
            syntax: 'typescript'
          }
        }
      }
    ]
  },
  moduleNameMapper: {
    '^@pyrite/(.+)$': '<rootDir>/../$1/src/index.ts'
  }
});

module.exports = createPackageJestConfig;
