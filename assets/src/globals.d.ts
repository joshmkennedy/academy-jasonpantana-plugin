export {};
declare global {
  interface Window {
    AIM: {
      ajaxUrl: string;
      [key: string]: any; // optional, if `AIM` has other unknown properties
    };
  }
}

