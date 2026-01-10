import "./main-navigation.css"
function initializePromptStudioButton() {
    const button = document.querySelector(".header-button-wrap[data-state=uninitialized]:has(.prompt-studio-link)");

    if (!button) {
      console.log("no button found");
      return;
    }

    const menu = button.closest(".site-header-section")?.querySelector(".menu");
    if (!menu) return;

    menu.insertAdjacentElement("beforebegin", button);
    button.setAttribute("data-state", "initialized");

    const mobileMenu = document.querySelector("#mobile-drawer .mobile-drawer-content");
    if (!mobileMenu) {
      return;
    }
    const mobileProfileLink = mobileMenu.querySelector(`[data-section="kadence_customizer_mobile_html"]`);
    if (!mobileProfileLink) {
      return;
    }
    const mobileButton = button.cloneNode(true)
    mobileProfileLink.insertAdjacentElement("beforebegin", mobileButton as HTMLElement);
}

window.addEventListener("DOMContentLoaded", () => {
    initializePromptStudioButton();
});
