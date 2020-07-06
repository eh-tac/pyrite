export class BattleSummary {
    constructor(URL, code, nr, name, ratingAvg, missions) {
        this.URL = URL;
        this.code = code;
        this.nr = nr;
        this.name = name;
        this.ratingAvg = ratingAvg;
        this.missions = missions;
    }
    get route() {
        const [plt, sub, nr] = this.code.replace(" ", "-").split("-");
        return `/battles/${plt}/${sub}/${nr}`;
    }
    static clone(from) {
        return new BattleSummary(from.URL, from.code, from.nr, from.name, from.ratingAvg, from.missions);
    }
}
