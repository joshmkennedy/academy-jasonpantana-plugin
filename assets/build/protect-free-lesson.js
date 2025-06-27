/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/protect-free-lesson/index.css":
/*!**************************************************!*\
  !*** ./assets/src/protect-free-lesson/index.css ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/src/utils/google-sheets.ts":
/*!*******************************************!*\
  !*** ./assets/src/utils/google-sheets.ts ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ submitToSheet)
/* harmony export */ });
const CONFIG = {
  SHEET_ENDPOINT: 'https://script.google.com/macros/s/AKfycbwsFi5jd_JExJvGy9gf0CrC7emsQFfniRv_TvjBRig83fgs36IBsBIauY4Ak8h3zGGS/exec'
};
function submitToSheet(data) {
  console.log(data);
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = CONFIG.SHEET_ENDPOINT;
  form.target = 'hidden_iframe' + Date.now();
  form.style.display = 'none';
  const firstName = document.createElement('input');
  firstName.type = 'text';
  firstName.name = 'first_name';
  firstName.value = data.firstName;
  const lastName = document.createElement('input');
  lastName.type = 'text';
  lastName.name = 'last_name';
  lastName.value = data.lastName;
  const email = document.createElement('input');
  email.type = 'text';
  email.name = 'email';
  email.value = data.email;
  const url = document.createElement('input');
  url.type = 'text';
  url.name = 'url';
  url.value = data.url;
  const title = document.createElement('input');
  title.type = 'text';
  title.name = 'title';
  title.value = data.title;
  form.appendChild(firstName);
  form.appendChild(lastName);
  form.appendChild(email);
  form.appendChild(title);
  form.appendChild(url);
  form.style.display = 'none';
  document.body.appendChild(form);
  const iframe = document.createElement('iframe');
  iframe.name = form.target;
  // iframe.style.display = 'none';
  iframe.src = 'about:blank';
  document.body.appendChild(iframe);
  form.submit();
  iframe.onload = function () {
    document.body.removeChild(form);
    document.body.removeChild(iframe);
  };
}

/***/ }),

/***/ "./node_modules/js-cookie/dist/js.cookie.mjs":
/*!***************************************************!*\
  !*** ./node_modules/js-cookie/dist/js.cookie.mjs ***!
  \***************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ api)
/* harmony export */ });
/*! js-cookie v3.0.5 | MIT */
/* eslint-disable no-var */
function assign (target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i];
    for (var key in source) {
      target[key] = source[key];
    }
  }
  return target
}
/* eslint-enable no-var */

/* eslint-disable no-var */
var defaultConverter = {
  read: function (value) {
    if (value[0] === '"') {
      value = value.slice(1, -1);
    }
    return value.replace(/(%[\dA-F]{2})+/gi, decodeURIComponent)
  },
  write: function (value) {
    return encodeURIComponent(value).replace(
      /%(2[346BF]|3[AC-F]|40|5[BDE]|60|7[BCD])/g,
      decodeURIComponent
    )
  }
};
/* eslint-enable no-var */

/* eslint-disable no-var */

function init (converter, defaultAttributes) {
  function set (name, value, attributes) {
    if (typeof document === 'undefined') {
      return
    }

    attributes = assign({}, defaultAttributes, attributes);

    if (typeof attributes.expires === 'number') {
      attributes.expires = new Date(Date.now() + attributes.expires * 864e5);
    }
    if (attributes.expires) {
      attributes.expires = attributes.expires.toUTCString();
    }

    name = encodeURIComponent(name)
      .replace(/%(2[346B]|5E|60|7C)/g, decodeURIComponent)
      .replace(/[()]/g, escape);

    var stringifiedAttributes = '';
    for (var attributeName in attributes) {
      if (!attributes[attributeName]) {
        continue
      }

      stringifiedAttributes += '; ' + attributeName;

      if (attributes[attributeName] === true) {
        continue
      }

      // Considers RFC 6265 section 5.2:
      // ...
      // 3.  If the remaining unparsed-attributes contains a %x3B (";")
      //     character:
      // Consume the characters of the unparsed-attributes up to,
      // not including, the first %x3B (";") character.
      // ...
      stringifiedAttributes += '=' + attributes[attributeName].split(';')[0];
    }

    return (document.cookie =
      name + '=' + converter.write(value, name) + stringifiedAttributes)
  }

  function get (name) {
    if (typeof document === 'undefined' || (arguments.length && !name)) {
      return
    }

    // To prevent the for loop in the first place assign an empty array
    // in case there are no cookies at all.
    var cookies = document.cookie ? document.cookie.split('; ') : [];
    var jar = {};
    for (var i = 0; i < cookies.length; i++) {
      var parts = cookies[i].split('=');
      var value = parts.slice(1).join('=');

      try {
        var found = decodeURIComponent(parts[0]);
        jar[found] = converter.read(value, found);

        if (name === found) {
          break
        }
      } catch (e) {}
    }

    return name ? jar[name] : jar
  }

  return Object.create(
    {
      set,
      get,
      remove: function (name, attributes) {
        set(
          name,
          '',
          assign({}, attributes, {
            expires: -1
          })
        );
      },
      withAttributes: function (attributes) {
        return init(this.converter, assign({}, this.attributes, attributes))
      },
      withConverter: function (converter) {
        return init(assign({}, this.converter, converter), this.attributes)
      }
    },
    {
      attributes: { value: Object.freeze(defaultAttributes) },
      converter: { value: Object.freeze(converter) }
    }
  )
}

var api = init(defaultConverter, { path: '/' });
/* eslint-enable no-var */




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
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
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
/*!*************************************************!*\
  !*** ./assets/src/protect-free-lesson/index.ts ***!
  \*************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _index_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.css */ "./assets/src/protect-free-lesson/index.css");
/* harmony import */ var js_cookie__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! js-cookie */ "./node_modules/js-cookie/dist/js.cookie.mjs");
/* harmony import */ var _utils_google_sheets__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../utils/google-sheets */ "./assets/src/utils/google-sheets.ts");



// RUNS THE WIDGET
document.addEventListener("DOMContentLoaded", init);
const COOKIE_NAME = "signed_up_for_free_lessons";
function init() {
  const modal = document.querySelector(".free-lesson-signup__popup");
  if (js_cookie__WEBPACK_IMPORTED_MODULE_1__["default"].get(COOKIE_NAME) && modal) {
    modal?.remove();
  }
  if (!modal) return;
  const form = modal?.querySelector("#free-lesson-signup__form");
  if (!form) {
    console.log("no form");
    return;
  }
  form.addEventListener("submit", function (e) {
    var _formData$get$toStrin, _formData$get$toStrin2, _formData$get$toStrin3, _modal$querySelector$;
    e.preventDefault();
    const formData = new FormData(form);
    (0,_utils_google_sheets__WEBPACK_IMPORTED_MODULE_2__["default"])({
      email: (_formData$get$toStrin = formData.get("email")?.toString()) !== null && _formData$get$toStrin !== void 0 ? _formData$get$toStrin : "",
      firstName: (_formData$get$toStrin2 = formData.get("first_name")?.toString()) !== null && _formData$get$toStrin2 !== void 0 ? _formData$get$toStrin2 : "",
      lastName: (_formData$get$toStrin3 = formData.get("last_name")?.toString()) !== null && _formData$get$toStrin3 !== void 0 ? _formData$get$toStrin3 : "",
      url: window.location.href,
      title: (_modal$querySelector$ = modal.querySelector("[data-title]")?.getAttribute("data-title")) !== null && _modal$querySelector$ !== void 0 ? _modal$querySelector$ : ""
    });
    js_cookie__WEBPACK_IMPORTED_MODULE_1__["default"].set(COOKIE_NAME, "true", {
      expires: 365
    });
    modal?.remove();
  });
  modal.showModal();
}
})();

/******/ })()
;
//# sourceMappingURL=protect-free-lesson.js.map