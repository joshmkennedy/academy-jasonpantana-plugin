import "./base.css";

document.addEventListener("DOMContentLoaded", jpRegistrationForm);

const FORM_ID = "learndash_registerform";
const INPUT_SELECTOR = ".ld-form__field";

function jpRegistrationForm() {
  const form = document.getElementById(FORM_ID) as HTMLFormElement;
  if (!form) return;
  adjustFields(form);
}

function adjustFields(form: HTMLFormElement) {
  form.querySelectorAll<HTMLElement>(INPUT_SELECTOR).forEach((field) => {
    switch (field.getAttribute("name")) {
      case "user_login": {
        hideField(field);
        linkFieldValue(
          form.querySelector("input[name='user_email']") as HTMLInputElement,
          field as HTMLInputElement,
					[
						(str)=>str.replaceAll("+", "-"),
						(str)=>str.replaceAll(".", "-"),
						(str)=>encodeURIComponent(str),
					]
        );
        break;
      }

      case "user_email": {
        setAutocomplete(field, "email");
        break;
      }

      case "first_name": {
        setAutocomplete(field, "given-name");
        moveAfter(field, form.querySelector("input[name='user_login']"));
        break;
      }

      case "last_name": {
        setAutocomplete(field, "family-name");
        moveAfter(field, form.querySelector("input[name='first_name']"));
        break;
      }

      case "phone": {
        setAutocomplete(field, "tel");
        moveAfter(field, form.querySelector("input[name='user_email']"));
        break;
      }

      case "password": {
        setAutocomplete(field, "new-password");
      }
    }
  });
}

function linkFieldValue(
  field: HTMLInputElement,
  referenceField: HTMLInputElement,
  filters?: ((str: string) => string)[],
) {
  if (!field || !referenceField) return;
  field.addEventListener("input", () => {
    referenceField.value = filters ? filters.reduce((acc, fn) => fn(acc), field.value) : field.value;
  });
}

function setAutocomplete(field: HTMLElement, type: string) {
  field.setAttribute("autocomplete", type);
}

function hideField(field: HTMLElement) {
  field
    .closest<HTMLElement>(".ld-form__field-outer-wrapper")
    ?.style.setProperty("display", "none");
}

// this function assumes the learndash form markup
function moveAfter(moveElement: Element, referenceInputEl: Element | null) {
  if (!moveElement || !referenceInputEl) return false;

  const referenceEl = referenceInputEl.closest(".ld-form__field-outer-wrapper");
  if (!referenceEl) return false;

  const moveEl = moveElement.closest(".ld-form__field-outer-wrapper");
  if (!moveEl) return false;

  referenceEl.after(moveEl);
  return true;
}
