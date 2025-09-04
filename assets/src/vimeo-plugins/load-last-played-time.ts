import Vimeo from "@vimeo/player";
export default class LoadLastPlayedTime {
  private loaded = false;
  private vimeoId: string | undefined;
  private player: Vimeo | undefined;

  public startTime: number | undefined;
  public endTime: number | undefined;

  constructor() {
  }
  shouldUse() {
    const iframe = document.querySelector<HTMLIFrameElement>(`iframe[src*='vimeo']`);
    if (!iframe) return false;
    return true; // its safe to now assume we can do all we need to and will assert that things that can be null are now not able to be undefined or null
  }

  init() {
    this.vimeoId = new URLSearchParams(window.location.search).get("skip-to-clip-video")?.toString();
    this.loadPlayer();
  }

  loadPlayer() {
    if (!this.player) {
      const video = document.querySelector<HTMLIFrameElement>(`iframe[src*='vimeo']`)!;
      this.player = new Vimeo(video)
        this.player!.on("loaded", (data) => {
          this.vimeoId = data.id.toString();
          this.loaded = true;
          this.startPlugin()
        });
    } else {
      return this.player;
    }
  }

  startPlugin() {
    if (!this.loaded) {
      throw new Error("Vimeo Plugin has not been properly loaded, need to call loadPlayer before startPlugin");
    }
    this.player!.getVideoId().then((id) => {
      const lastStartTime = localStorage.getItem(id.toString());
      if (lastStartTime) {
        this.player!.setCurrentTime(parseInt(lastStartTime));
      }
    });
    this.player!.on("pause", (data)=>{
      localStorage.setItem(this.vimeoId!, data.seconds.toString());
    })
  }
}
