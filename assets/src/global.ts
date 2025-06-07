import "tippy.js/dist/tippy.css";
import tippy from "tippy.js";

window.addEventListener("DOMContentLoaded", () => {
  initTippyTooltips();
});


//--- tippy tool tips
function initTippyTooltips() {
  tippy("[data-tippy-content]", {
    allowHTML: true,
    arrow: true,
    placement: "top",
    duration: 200,
  });
}
