window.addEventListener("DOMContentLoaded", () => {

  document.querySelectorAll("iframe[src*='vimeo.com']").forEach((iframe) => {
    const src = iframe.getAttribute("src");
    if (!src) return;
    const url = new URL(src);
    url.searchParams.delete("dnt");
    iframe.setAttribute("src", url.toString());
  });

});
