import Vimeo from "@vimeo/player";
export default class GeneralSkipToClip {
  private loaded = false;
  private vimeoId: string | undefined;
  private player: Vimeo | undefined;

  public startTime: number | undefined;
  public endTime: number | undefined;

  constructor() {
  }
  shouldUse() {
    const params = new URLSearchParams(window.location.search);
    if (!params.has("skip-to-clip-video")) return false;
    console.log("Checking if we should use the skip to clip plugin");
    const vimeoId = params.get("skip-to-clip-video");
    const iframe = document.querySelector<HTMLIFrameElement>(`iframe[src*='${vimeoId}']`);
    if (!iframe) return false;
    return true; // its safe to now assume we can do all we need to and will assert that things that can be null are now not able to be undefined or null
  }

  init() {
    console.log("Starting the skip to clip plugin");
    this.vimeoId = new URLSearchParams(window.location.search).get("skip-to-clip-video")?.toString();
    this.loadPlayer(this.vimeoId!);
  }

  loadPlayer(id: string) {
    if (!this.player) {
      const video = document.querySelector<HTMLIFrameElement>(`iframe[src*='${id}']`)!;
      this.player = new Vimeo(video)
        this.player!.on("loaded", () => {
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
    const params = new URLSearchParams(window.location.search);
    const startParamKey = params.has("start") ? "start" : "ts";
    const secondsToSkip = parseInt(params.get(startParamKey) ?? "0");
    if (!secondsToSkip) return;
    this.player!.setCurrentTime(secondsToSkip);
  }
}

/* TODO:
//

  const params = new URLSearchParams(window.location.search);
  if (!params.has("skip-to-clip-video")) return;
  const videoId = params.get("skip-to-clip-video");
  if (!videoId) return;
  const video = document.querySelector<HTMLIFrameElement>(`iframe[src*='${videoId}']`);
  if (!video) return;
  const player = new Vimeo(video);
  player.on("loaded",()=>{
    const secondsToSkip = parseInt(params.get("ts") ?? "");
    if (!secondsToSkip) return;
    player.setCurrentTime(secondsToSkip);
  });
  */
