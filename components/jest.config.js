/** @type {import('jest').Config} */
module.exports = {
  roots: ["<rootDir>/src"],
  testEnvironment: "node",
  testMatch: ["**/*.spec.ts"],
  transform: {
    "^.+\\.(t|j)sx?$": [
      "@swc/jest",
      {
        jsc: {
          target: "es2017",
          parser: {
            syntax: "typescript",
            tsx: false,
            decorators: true
          }
        },
        module: {
          type: "commonjs"
        }
      }
    ]
  }
};
