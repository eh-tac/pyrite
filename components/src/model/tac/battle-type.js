export class BattleType {
    constructor(URL, code, platform, subgroup, count) {
        this.URL = URL;
        this.code = code;
        this.platform = platform;
        this.subgroup = subgroup;
        this.count = count;
    }
    get route() {
        const [plt, sub] = this.code.split("-");
        return `/battles/${plt}/${sub}`;
    }
    static clone(from) {
        return new BattleType(from.URL, from.code, from.platform, from.subgroup, from.count);
    }
}
