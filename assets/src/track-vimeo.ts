import { loadVimeoPlugins } from "./vimeo-plugins/vimeo-plugin";

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
  const VimeoPlugins = loadVimeoPlugins();
  for (const pluginConfig of VimeoPlugins) {
    const configs = Object.entries(pluginConfig);
    if(configs.length === 0) continue;
    const [pluginName, plugin] = configs[0];
    if(plugin.shouldUse?.()){
      console.log(`Using ${pluginName} plugin`);
      plugin.init();
      break;
    }
  }
});
