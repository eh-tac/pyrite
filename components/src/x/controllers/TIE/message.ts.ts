import { Message } from "../../model/TIE";

export class TIEMessageController {
  public static fields: any[] = [];

  constructor(public model: Message){}

  public render(field: string){}
}