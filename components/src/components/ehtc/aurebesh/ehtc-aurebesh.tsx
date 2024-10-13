import { JSX, Component, Prop, h, Element, State, Method, Event, EventEmitter } from "@stencil/core";

interface Code {
  x: number;
  y: number;
  char: string;
}

@Component({
  tag: "ehtc-aurebesh",
  styleUrl: "ehtc-aurebesh.scss",
  shadow: true
})
export class AurebeshComponent {
  @Element() el: HTMLElement;

  @State() selectedKey: string;
  @State() editBuffer: Code[] = [];

  public componentDidLoad(): void {
    this.initDropZone();
    this.initCanvas();
    this.initKeyboard();
  }

  private initDropZone(): void {
    const dropzone = this.el.shadowRoot.querySelector("div.dropzone");
    dropzone.addEventListener("drop", (e: DragEvent) => {
      //   console.log("dropzone", this, e, e.dataTransfer, e.dataTransfer.files[0]);
      e.preventDefault();
      dropzone.classList.remove("over");
      this.loadFile(e.dataTransfer.files[0]);
    });
    dropzone.addEventListener("dragover", e => {
      //   console.log("dragover", this, e);
      e.preventDefault();
      dropzone.classList.add("over");
    });
  }

  private snapY(y: number): number {
    const closeMatch = this.editBuffer.find(b => Math.abs(b.y - y) < 10);
    if (closeMatch) {
      return closeMatch.y;
    }
    return Math.round(y);
  }

  private initCanvas(): void {
    const canvas = this.el.shadowRoot.querySelector("canvas") as HTMLCanvasElement;
    const cxt = canvas.getContext("2d");
    canvas.addEventListener("click", (event: MouseEvent) => {
      //   console.log("canvas click", e, canva, e.);
      const rect = canvas.getBoundingClientRect();
      const x = event.clientX - rect.left;
      const y = this.snapY(event.clientY - rect.top);
      //   console.log("x: " + x + " y: " + y);

      if (this.selectedKey) {
        const char = this.selectedKey.toUpperCase();
        cxt.fillStyle = "black";
        cxt.fillRect(x - 12, y - 12, 24, 24);
        cxt.fillStyle = "green";
        cxt.font = "24px monospaced";
        cxt.fillText(char, x - 8, y + 8);
        // console.log("drew", this.selectedKey, "at", x, y);
        this.editBuffer = this.editBuffer.slice(0);
        this.editBuffer.push({ x, y, char });
      }
    });
  }

  private initKeyboard(): void {
    const controls = this.el.shadowRoot.querySelector("div.controls");
    controls.addEventListener(
      "click",
      e => {
        let target = e.target as HTMLElement;
        if (target.tagName === "SPAN") {
          target = target.parentElement;
        }
        if (target.tagName === "BUTTON") {
          const letter = target.attributes.getNamedItem("data-letter");
          console.log("button click", this, e.target, letter);
          this.selectedKey = letter.value;
        }
      },
      {}
    );
  }

  private loadFile(file: File): void {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
      const image = new Image();
      image.src = reader.result as string;
      image.onload = () => {
        const canvas = this.el.shadowRoot.querySelector("canvas");
        canvas.width = image.width;
        canvas.height = image.height;
        const context = canvas.getContext("2d");
        // context.filter = "blur(10px)";
        context.drawImage(image, 0, 0);
      };
    };
  }

  public render(): JSX.Element {
    return (
      <div>
        {this.renderHeader()}
        {this.renderMain()}
        {this.renderFooter()}
      </div>
    );
  }

  private renderHeader(): JSX.Element {
    return (
      <div class="header">
        <h1>Aurebesh Decoder</h1>
        {this.renderControls()}
        <p>Select a letter to place it on the image below</p>
      </div>
    );
  }

  private renderControls(): JSX.Element {
    return (
      <div class="controls">
        <div class="keyboard">
          {"0123456789".split("").map(l => (
            <button data-letter={l} class={{ selected: l === this.selectedKey }}>
              {l}
              <span class="translation">{l}</span>
            </button>
          ))}
        </div>
        <div class="keyboard">
          {"abcdefghijklmnopqrstuvwxyz".split("").map(l => (
            <button data-letter={l} class={{ selected: l === this.selectedKey }}>
              {l}
              <span class="translation">{l}</span>
            </button>
          ))}
        </div>
      </div>
    );
  }

  private renderMain(): JSX.Element {
    return (
      <div class="main dropzone">
        <p>Drag and drop an image here</p>
        <canvas></canvas>
      </div>
    );
  }

  private renderFooter(): JSX.Element {
    const arr: string[] = [];
    const chars = this.editBuffer.slice(0);
    chars.sort((a, b) => {
      if (a.y === b.y) {
        return a.x - b.x;
      }
      return a.y - b.y;
    });
    console.log(chars);
    let lastY = 0;
    let lastX = 0;
    let curr = "";
    for (let i = 0; i < chars.length; i++) {
      const code = chars[i];
      if (code.y !== lastY) {
        if (curr) {
          arr.push(curr);
        }
        curr = "";
        lastY = code.y;
        lastX = 0;
      }

      curr += "".padEnd(Math.floor((code.x - lastX) / 30), " ");
      curr += code.char;
      lastX = code.x;
    }
    if (curr) {
      arr.push(curr);
    }

    const text = arr.join("\n");
    console.log("render text", this.editBuffer, chars, arr, text);
    return (
      <div class="footer">
        <textarea>{text}</textarea>
      </div>
    );
  }
}
