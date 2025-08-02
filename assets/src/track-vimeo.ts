import Vimeo from "@vimeo/player";

window.addEventListener("DOMContentLoaded", () => {

  document.querySelectorAll("iframe[src*='vimeo.com']").forEach((iframe) => {
    const src = iframe.getAttribute("src");
    if (!src) return;
    const url = new URL(src);
    url.searchParams.delete("dnt");
    iframe.setAttribute("src", url.toString());
  });

});

// PROTOTYPE VIMEO SKIP TO CLIP
window.addEventListener("DOMContentLoaded", () => {
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
});
