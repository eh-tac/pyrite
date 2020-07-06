import { FileHeaderBase } from "./base/file-header-base";
    
    export class FileHeader extends FileHeaderBase {
      constructor(hex: ArrayBuffer, tie?: Mission) {
        super(hex, tie);
      }

      public beforeConstruct(): void {}

      // TODO abstract stubs?
    }
    