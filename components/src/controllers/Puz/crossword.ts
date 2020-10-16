import { ControllerBase } from "../../controller-base";
import { Crossword } from "../../model/Puz";

export class PuzCrosswordController extends ControllerBase {
  public readonly fields: object = {"FileHeader":{"name":"FileHeader","type":"FileHeader","componentTag":"pyrite-puz-file-header","componentProp":"file-header"},"SolutionGrid":{"name":"SolutionGrid","type":"CHAR"},"ProgressGrid":{"name":"ProgressGrid","type":"CHAR"},"Title":{"name":"Title","type":"STR"},"Author":{"name":"Author","type":"STR"},"Copyright":{"name":"Copyright","type":"STR"},"Clues":{"name":"Clues","type":"STR"}};

  constructor(public model: Crossword){
    super(model);
  }
}