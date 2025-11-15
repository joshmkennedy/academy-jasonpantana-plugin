/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/base.css":
/*!*****************************!*\
  !*** ./assets/src/base.css ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!*****************************************!*\
  !*** ./assets/src/registration-form.ts ***!
  \*****************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _base_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./base.css */ "./assets/src/base.css");

document.addEventListener("DOMContentLoaded", jpRegistrationForm);
const FORM_ID = "learndash_registerform";
const INPUT_SELECTOR = ".ld-form__field";
function jpRegistrationForm() {
  const form = document.getElementById(FORM_ID);
  if (!form) return;
  adjustFields(form);
}
function adjustFields(form) {
  form.querySelectorAll(INPUT_SELECTOR).forEach(field => {
    switch (field.getAttribute("name")) {
      case "user_login":
        {
          hideField(field);
          linkFieldValue(form.querySelector("input[name='user_email']"), field, [str => str.replaceAll("+", "-"), str => str.replaceAll(".", "-")]);
          break;
        }
      case "user_email":
        {
          setAutocomplete(field, "email");
          break;
        }
      case "first_name":
        {
          setAutocomplete(field, "given-name");
          moveAfter(field, form.querySelector("input[name='user_login']"));
          break;
        }
      case "last_name":
        {
          setAutocomplete(field, "family-name");
          moveAfter(field, form.querySelector("input[name='first_name']"));
          break;
        }
      case "phone":
        {
          setAutocomplete(field, "tel tel-area-code mobile-tel phone");
          field.setAttribute("inputmode", "tel");
          moveAfter(field, form.querySelector("input[name='user_email']"));
          break;
        }
      case "password":
        {
          setAutocomplete(field, "new-password");
        }
    }
  });
}
function linkFieldValue(field, referenceField, filters) {
  if (!field || !referenceField) return;
  field.addEventListener("input", () => {
    referenceField.value = filters ? filters.reduce((acc, fn) => fn(acc), field.value) : field.value;
  });
}
function setAutocomplete(field, type) {
  field.setAttribute("autocomplete", type);
}
function hideField(field) {
  field.closest(".ld-form__field-outer-wrapper")?.style.setProperty("display", "none");
}
// this function assumes the learndash form markup
function moveAfter(moveElement, referenceInputEl) {
  if (!moveElement || !referenceInputEl) return false;
  const referenceEl = referenceInputEl.closest(".ld-form__field-outer-wrapper");
  if (!referenceEl) return false;
  const moveEl = moveElement.closest(".ld-form__field-outer-wrapper");
  if (!moveEl) return false;
  referenceEl.after(moveEl);
  return true;
}
})();

/******/ })()
;
//# sourceMappingURL=registration-form.js.map