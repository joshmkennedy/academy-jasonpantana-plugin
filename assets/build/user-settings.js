/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/user-settings/styles.css":
/*!*********************************************!*\
  !*** ./assets/src/user-settings/styles.css ***!
  \*********************************************/
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
/*!*******************************************!*\
  !*** ./assets/src/user-settings/index.ts ***!
  \*******************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _styles_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./styles.css */ "./assets/src/user-settings/styles.css");

window.addEventListener("DOMContentLoaded", function () {
  const allDuhDamnButtons = document.querySelectorAll("[data-action='unsubscribe']");
  allDuhDamnButtons.forEach(button => {
    button.addEventListener("click", async function (e) {
      e.preventDefault();
      const listId = button.dataset.listId;
      if (!listId) {
        return;
      }
      await unsubscribe(listId);
    });
  });
});
async function unsubscribe(listId) {
  const res = await fetch(`/wp-json/vts/v1/learning-path/opt-out-user?cliplist_id=${listId}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      // @ts-ignore you mom is not defined
      "X-WP-Nonce": window.vtsPublic.nonce
    }
  });
  const data = await res.json();
  if (data.status === "success") {
    console.log("success");
    window.location.href = "/profile";
  } else {
    console.error("😭😭😭😭😭😭.");
  }
}
})();

/******/ })()
;
//# sourceMappingURL=user-settings.js.map