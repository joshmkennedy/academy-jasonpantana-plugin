import "./index.css";
import Cookie from "js-cookie";
import submitToSheet from "../utils/google-sheets"

// RUNS THE WIDGET
document.addEventListener("DOMContentLoaded", init);

const COOKIE_NAME = "signed_up_for_free_lessons";

function init() {
  const modal = document.querySelector<HTMLDialogElement>(".free-lesson-signup__popup");

  if (Cookie.get(COOKIE_NAME) && modal) {

    modal?.remove();
  }

  if(!modal) return;

  const form = modal?.querySelector<HTMLFormElement>("#free-lesson-signup__form");
  if (!form){
    console.log("no form");
    return;
  }

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(form);
    submitToSheet({
      email: formData.get("email")?.toString() ?? "",
      firstName: formData.get("first_name")?.toString() ?? "",
      lastName: formData.get("last_name")?.toString() ?? "",
      url: window.location.href,
    });
    Cookie.set(COOKIE_NAME, "true", { expires: 365 });
    modal?.remove();
  });

  modal.showModal();
}

