/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/aim-expert-tag-input/app.tsx":
/*!*************************************************!*\
  !*** ./assets/src/aim-expert-tag-input/app.tsx ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   mountAimExpertTagInput: () => (/* binding */ mountAimExpertTagInput)
/* harmony export */ });
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _styles_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./styles.css */ "./assets/src/aim-expert-tag-input/styles.css");



function mountAimExpertTagInput(element, taxonomy, allTags, userTags) {
  const root = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createRoot)(element);
  const userTagFormatted = userTags.map(t => Object.entries(allTags).find(([id]) => id == t)).reduce((acc, [id, name]) => ({
    ...acc,
    [id]: name
  }), {});
  root.render((0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(AimExpertTagInput, {
    allTags: allTags,
    userTags: userTagFormatted,
    taxonomy: taxonomy
  }));
}
function AimExpertTagInput({
  allTags,
  userTags,
  taxonomy
}) {
  const element = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useRef)(null);
  const inputRef = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useRef)(null);
  const [input, setInput] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)("");
  const [isOpen, setIsOpen] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(false);
  const [allTagsList, setAllTagsList] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(allTags);
  const [userTagsList, setUserTagsList] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(userTags);
  const filteredTags = Object.values(allTagsList).filter(tag => tag.toLowerCase().includes(input?.toLowerCase()));
  const [] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(userTags);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useEffect)(() => {
    const inputEl = element.current?.closest('#instructor-specialty-tags')?.querySelector(`[name="users-${taxonomy}-tags"]`);
    if (!inputEl) return;
    inputEl.value = JSON.stringify(userTagsList);
  }, [userTagsList]);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useEffect)(() => {
    if (!element.current) return;
    const closeOnClickOutside = e => {
      if (element.current && !element.current.contains(e.target)) {
        setIsOpen(false);
      }
    };
    document.addEventListener("click", closeOnClickOutside);
    return () => {
      document.removeEventListener("click", closeOnClickOutside);
    };
  }, [setIsOpen]);
  function addTag(tagid, tagName) {
    if (!tagid || !tagName) return;
    setUserTagsList({
      ...userTagsList,
      [tagid]: tagName
    });
  }
  function removeFromUser(id, name) {
    delete userTagsList[id];
    setUserTagsList({
      ...userTagsList
    });
  }
  function handleAddTag(tag) {
    let inputTag = input;
    if (tag) {
      inputTag = tag;
    }
    if (!inputTag) {
      return;
    }
    if (filteredTags.length === 0) {
      const tag = Object.entries(allTagsList).find(([id, name]) => name == inputTag);
      if (tag) {
        addTag(tag[0], tag[1]);
        setInput("");
        return;
      }
      addTag(inputTag, inputTag);
    } else {
      const matchingtag = Object.entries(allTagsList).find(([id, name]) => name == inputTag);
      if (matchingtag) {
        addTag(matchingtag[0], matchingtag[1]);
        setInput("");
        return;
      }
      const tagName = filteredTags[0];
      const tag = Object.entries(allTagsList).find(([id, name]) => name == tagName);
      if (!tag) return;
      addTag(tag[0], tag[1]);
    }
    setInput("");
  }
  function handleEnterKey(e) {
    if (e.key !== "Enter") return;
    e.preventDefault();
    handleAddTag();
    setIsOpen(false);
  }
  async function handleclear() {
    setInput("");
    inputRef.current?.focus();
    await new Promise(r => setTimeout(r, 100));
    setIsOpen(true);
  }
  return (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)("div", {
    ref: element,
    className: "expert-select-input",
    children: [(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("h3", {
      children: taxonomy.replaceAll("-", " ")
    }), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)("div", {
      className: "combo",
      children: [(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)("div", {
        className: "input__outer-wrapper",
        children: [(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)("div", {
          className: "input__inner-wrapper",
          children: [Boolean(input.length) && (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("button", {
            type: "button",
            onClick: handleclear,
            children: "\u00D7"
          }), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("input", {
            ref: inputRef,
            id: `users-${taxonomy}-tags--inserter`,
            value: input !== null && input !== void 0 ? input : "",
            onChange: e => setInput(e.target.value),
            onFocus: () => setIsOpen(true),
            // @ts-ignore
            onKeyDown: handleEnterKey
          })]
        }), input && (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("button", {
          type: "button",
          className: "add-button",
          onClick: () => handleAddTag(),
          children: "Add"
        })]
      }), input.length > 0 && (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("div", {
        className: "components-form-token-field__suggestions-list",
        children: filteredTags.map(tag => (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("li", {
          className: "components-form-token-field__suggestion",
          children: (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("button", {
            type: "button",
            onClick: () => {
              handleAddTag(tag);
            },
            children: tag
          })
        }, tag))
      })]
    }), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("div", {
      className: "user-tags",
      children: Object.entries(userTagsList).map(([id, name]) => (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)("div", {
        className: "user-tag",
        children: [(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("span", {
          children: name
        }), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("button", {
          type: "button",
          onClick: () => removeFromUser(id, name),
          children: "\u00D7"
        })]
      }, id))
    })]
  });
}

/***/ }),

/***/ "./assets/src/aim-expert-tag-input/styles.css":
/*!****************************************************!*\
  !*** ./assets/src/aim-expert-tag-input/styles.css ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "react/jsx-runtime":
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["ReactJSXRuntime"];

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
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
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
/*!********************************************!*\
  !*** ./assets/src/aim-expert-tag-input.ts ***!
  \********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _aim_expert_tag_input_app__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./aim-expert-tag-input/app */ "./assets/src/aim-expert-tag-input/app.tsx");

// Aim Expert Tag Input functionality
document.addEventListener('DOMContentLoaded', async function () {
  var _element$getAttribute;
  await new Promise(r => setTimeout(r, 1000));
  const element = document.querySelector('[data-mount="expert-in-tags-mount"]');
  if (!element) return;
  const allTags = window.AIMEXPERTINTAGS;
  const userTags = JSON.parse((_element$getAttribute = element.getAttribute('data-tags')) !== null && _element$getAttribute !== void 0 ? _element$getAttribute : '[]');
  (0,_aim_expert_tag_input_app__WEBPACK_IMPORTED_MODULE_0__.mountAimExpertTagInput)(element, "expert-in-tag", allTags, userTags);
});
document.addEventListener('DOMContentLoaded', async function () {
  await new Promise(r => setTimeout(r, 1000));
  const element = document.querySelector('[data-mount="expert-with-tags-mount"]');
  if (!element) return;
  const allTags = window.AIMEXPERTWITHTAGS;
  console.log(allTags);
  const userTags = JSON.parse(element.getAttribute('data-tags') || '[]');
  (0,_aim_expert_tag_input_app__WEBPACK_IMPORTED_MODULE_0__.mountAimExpertTagInput)(element, "expert-with-tag", allTags, userTags);
});
//
//
//
})();

/******/ })()
;
//# sourceMappingURL=aim-expert-tag-input.js.map