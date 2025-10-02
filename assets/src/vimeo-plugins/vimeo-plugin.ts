import GeneralSkipToClip from "./aim-clip-player.ts";
import LoadLastPlayedTime from "./load-last-played-time.ts";
export interface VimeoPluginInterface {
  shouldUse: () => boolean;
  init: () => void;
}

declare global {
  interface Window {
    aimVimeoPluginData: {
      [key: string]: any;
    }
    aimVimeoPlugins: {
      [key: string]: VimeoPluginInterface;
    }[];
  }
}

export function loadVimeoPlugins() {
  if (window && !window.hasOwnProperty("aimVimeoPlugins")) {
    window.aimVimeoPlugins = [];
  }
  const plugins = window.aimVimeoPlugins;
  // add default skipToClipPlugin
  if (plugins.length === 0) {
    plugins.push({"skipToClip": new GeneralSkipToClip()});
  }

  if (!plugins.hasOwnProperty("loadLastPlayedTime")) {
    plugins.push({loadLastPlayedTime: new LoadLastPlayedTime()});
  }
  return plugins;
}
