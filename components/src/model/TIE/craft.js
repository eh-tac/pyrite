import { Constants } from "./constants";
const values = [
    0,
    600,
    400,
    800,
    800,
    400,
    600,
    600,
    1000,
    1600,
    400,
    400,
    1000,
    400,
    320,
    480,
    800,
    800,
    1600,
    2400,
    2400,
    600,
    960,
    1200,
    200,
    240,
    800,
    800,
    800,
    800,
    600,
    1200,
    1200,
    1600,
    1200,
    1600,
    2400,
    2000,
    2000,
    2200,
    1600,
    2000,
    4400,
    4000,
    4000,
    4400,
    4000,
    4000,
    5000,
    6000,
    5000,
    5600,
    5000,
    8000,
    4000,
    800,
    800,
    800,
    800,
    800,
    5200,
    5200,
    5200,
    5200,
    5200,
    5200,
    5200,
    5200,
    5200,
    5200,
    50,
    50,
    50,
    50,
    50,
    50,
    50,
    50,
    50,
    50,
    50,
    50,
    50,
    50,
    50,
    50,
    0,
    0
]; //'Planet']
const missiles = [
    0,
    0,
    0,
    0,
    0,
    4,
    6,
    8,
    8,
    8,
    0,
    0,
    80,
    0,
    0,
    0,
    16
];
export class Craft {
    constructor(typeID) {
        this.typeID = typeID;
    }
    get pointValue() {
        return values[this.typeID];
    }
    get label() {
        return Constants.CRAFTTYPE[this.typeID];
    }
    get isFighter() {
        return this.typeID < 25;
    }
    get isStarship() {
        switch (this.label) {
            //TODO decide on the canonical source of names
            case "Corellian Corvette":
            case "Modified Corvette":
            case "Nebulon B Frigate":
            case "Modified Frigate":
            case "C-3 Passenger Liner":
            case "Carrack Cruiser":
            case "Strike Cruiser":
            case "Escort Carrier":
            case "Dreadnaught":
            case "Calamari Cruiser":
            case "Lt Calamari Cruiser":
            case "Interdictor Cruiser":
            case "Victory-class Star Destroyer":
            case "Victory Star Destroyer":
            case "Star Destroyer":
            case "Super Star Destroyer":
                return true;
        }
        return false;
    }
    get missileCount() {
        return missiles[this.typeID];
    }
}
