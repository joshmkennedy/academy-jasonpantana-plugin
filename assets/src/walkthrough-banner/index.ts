import "./walkthrough-banner.css";
import Cookie from "js-cookie";

window.addEventListener("DOMContentLoaded", initBanner)

// This is a long lived cookie that will be used to to know if the user has already dismissed
// but hasnt watched the video yet. If they have this but not the DONW_SHOW_BANNER cookie
// then we will show the banner and if they dismiss it we will set the DONT_SHOW_BANNER permmanently
// by setting it in their user meta.
const USER_HAS_DISMISSED_BEFORE = "walkthrough-banner-temp-dismissed--flag";
const DONT_SHOW_BANNER = "walkthrough-banner-temp-dismissed";

function initBanner() {
  const banner = document.querySelector(".walkthrough-banner__banner");
  if (!banner) return;
  if (Cookie.get(DONT_SHOW_BANNER)) {
    // SHouldnt get here 
    // we should be not rendering it server side if this is true
    // but jsut in case
    banner.remove();
    return;
  }

  const popup = document.querySelector<HTMLDialogElement>("#walkthrough-banner__popup");
  if (!popup) return;

  const close = banner.querySelector<HTMLButtonElement>(".walkthrough-banner__close");
  if (!close) return;
  close.addEventListener("click", () => {
    if (Cookie.get(USER_HAS_DISMISSED_BEFORE)) {
      Cookie.set(DONT_SHOW_BANNER, 'true', { expires: 365 });
      userPermDismiss();
    } else {
      Cookie.set(USER_HAS_DISMISSED_BEFORE, 'true', { expires: 365 });
      // temporary set cookie to not show banner
      Cookie.set(DONT_SHOW_BANNER, 'true', { expires: 2 });
    }

    banner.remove();
  });

  const popupCloseButton = popup.querySelector<HTMLButtonElement>(".walkthrough-popup__close");
  if (!popupCloseButton) return;
  popupCloseButton.addEventListener("click", () => {
    popup.close();
  });

  const openBtn = banner.querySelector<HTMLButtonElement>(".walkthrough-banner__cta");
  if (!openBtn) return;
  openBtn.addEventListener("click", () => {
    // TODO: set user preferences to have seen it
    popup.showModal();
    banner.remove();
    userPermDismiss();
  });

}



function userPermDismiss() {
  if (!window.AIM.ajaxUrl) {
    console.log("[AIM] no ajax url");
  };
  fetch(`${window.AIM.ajaxUrl}?action=dissmiss_walkthrough_banner_perm`, {
    method: "POST",
  })
}
window.addEventListener('DOMContentLoaded', function () {
  if (window.showFBanner !== true) return;
  if (Cookie.get('dismissed_fb_group')) return;
  function banner() {
    const banner = document.createElement('div');
    banner.classList.add('jp-fb-banner');
    banner.innerHTML = `
            <div class="jp-fb-banner__inner">
                <div class="flex-row">
                    <div>
                        <p>Join the Ai Marketing Academy exclusive Facebook Group: AiM Lounge</p>
                    </div>
                    <div>
                      <a href="https://www.facebook.com/share/g/177Rt9UsfB/" target="_blank">JOIN</a>
                      <button id="close-fb-banner">Dismiss</button>
                    </div>
                </div>
            </div>
        `
    return banner;
  }
  const header = document.querySelector('[data-section="kadence_customizer_header_main"]')
  if (!header) return;
  const _b = banner() as HTMLDivElement
  header.insertAdjacentElement('beforebegin', _b)
  function dismiss() {
    document.querySelector('.jp-fb-banner')?.classList.add('hide')
    // add cookie for 2 yrs
    Cookie.set('dismissed_fb_group', 'true', { expires: 100000 })
  }
  _b.addEventListener('click', (e) => {
    const el = e.target as HTMLElement
    if (el.tagName === 'A') return
    el.querySelector('a')?.click()
  })
  const closeButton = document.getElementById('close-fb-banner')
  const link = document.querySelector('.jp-fb-banner a')




  if (!closeButton) return;
  closeButton.addEventListener('click', (e) => {
    e.stopPropagation()
    dismiss()
  });

  if (!link) return;
  link.addEventListener('click', dismiss);

});

