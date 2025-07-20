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
  const secondsToSkip = parseInt(params.get("ts") ?? "");
  if (!secondsToSkip) return;
  player.setCurrentTime(secondsToSkip);
});



const grammar =
  "#JSGF V1.0; grammar colors; public <color> = Start | start | stop | Stop | go | record ;";
const recognition = new SpeechRecognition();
const speechRecognitionList = new SpeechGrammarList();
speechRecognitionList.addFromString(grammar, 1);
recognition.grammars = speechRecognitionList;
recognition.continuous = false;
recognition.lang = "en-US";
recognition.interimResults = true;
recognition.maxAlternatives = 1;

const diagnostic = document.querySelector(".output");
const bg = document.querySelector("body");
document.addEventListener("DOMContentLoaded", () => {
  document.body.onclick = () => {
    recognition.start();
    console.log("Ready to receive a color command.");
  };
  let canRun = true;

  recognition.onresult = (event) => {
    const color = event.results[0][0].transcript;
  };
  recognition.onend = () => {
    if (canRun) {
      recognition.start();
    }
  };
  recognition.onerror = (event) => {
    canRun = false;
    console.log("Error: " + event.error);
    recognition.abort()
    navigator.permissions.query({ name: "microphone" }).then((result) => {
      console.log(result);
    })
  };

});
