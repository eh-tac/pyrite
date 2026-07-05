import * as fs from "fs";
import { Mission as TIEMission } from "../TIE";
import { FileHeader, Mission as XvTMission } from "../XvT";
import { Mission as XWAMission } from "../XWA";

export const loadMission = (path: string): TIEMission | XvTMission | XWAMission => {
  const buffer = fs.readFileSync(path);
  if (isXvTMission(buffer)) {
    return new XvTMission(buffer);
  }
};

export const isXvTMission = (hex: ArrayBuffer): boolean => {
  try {
    const testHeader = new FileHeader(hex);
    return testHeader.PlatformID === 12;
  } catch (e) {}
  return false;
};
