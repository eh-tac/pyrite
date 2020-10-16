import { ControllerBase } from "../../controller-base";
import { FileHeader } from "../../model/Puz";

export class PuzFileHeaderController extends ControllerBase {
  public readonly fields: object = {"FileChecksum":{"name":"FileChecksum","type":"SHORT"},"Descriptor":{"name":"Descriptor","type":"CHAR"},"BaseChecksum":{"name":"BaseChecksum","type":"SHORT"},"MaskedChecksums":{"name":"MaskedChecksums","type":"SHORT"},"Version":{"name":"Version","type":"CHAR"},"Unused":{"name":"Unused","type":"SHORT"},"Unknown":{"name":"Unknown","type":"SHORT"},"Reserved":{"name":"Reserved","type":"CHAR"},"Width":{"name":"Width","type":"BYTE"},"Height":{"name":"Height","type":"BYTE"},"NumClues":{"name":"NumClues","type":"SHORT"},"Bitmask1":{"name":"Bitmask1","type":"SHORT"},"Bitmask2":{"name":"Bitmask2","type":"SHORT"}};

  constructor(public model: FileHeader){
    super(model);
  }
}