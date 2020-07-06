import { Event } from "../../model/TIE";

export class TIEEventController {
  public static fields: any[] = [];

  constructor(public model: Event){}

  public render(field: string){}
}