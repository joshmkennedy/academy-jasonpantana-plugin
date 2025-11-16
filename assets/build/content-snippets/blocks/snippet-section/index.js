/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/content-snippets/blocks/snippet-section/block.json":
/*!***********************************************************************!*\
  !*** ./assets/src/content-snippets/blocks/snippet-section/block.json ***!
  \***********************************************************************/
/***/ ((module) => {

module.exports = /*#__PURE__*/JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"jp-content-snippets/snippet-section","title":"Snippet Section","category":"text","post_types":["content-snippet"],"icon":"admin-comments","description":"A section of content snippets","textdomain":"snippet-section","attributes":{},"editorScript":"file:./index.js","editorStyle":"file:./editor.css","style":"file:./view.css","viewScript":"file:./view.js","viewScriptModule":"file:./view.js","render":"file:./render.php","variations":"file:./variations.php"}');

/***/ }),

/***/ "./assets/src/content-snippets/blocks/snippet-section/combobox.tsx":
/*!*************************************************************************!*\
  !*** ./assets/src/content-snippets/blocks/snippet-section/combobox.tsx ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Combobox: () => (/* binding */ Combobox)
/* harmony export */ });
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);



function Combobox({
  label,
  isLoading,
  options,
  onSelect,
  value
}) {
  const [filteredOptions, setFilteredOptions] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.useState)(options);
  return (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)("div", {
    className: "jp-blocks-combobox",
    children: [(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ComboboxControl, {
      label: isLoading ? "Fetching Options..." : label,
      value: value,
      onChange: onSelect,
      options: filteredOptions,
      __experimentalRenderItem: ({
        item
      }) => {
        return (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("div", {
          className: "jp-blocks-combobox__item ",
          style: {
            display: "flex",
            justifyContent: "space-between",
            alignItems: "center"
          },
          children: (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)("div", {
            children: [(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("p", {
              style: {
                fontSize: "12px",
                fontWeight: "bold",
                margin: 0
              },
              children: item.label
            }), item.subLabel && (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("p", {
              style: {
                fontSize: "10px",
                margin: 0
              },
              children: item.subLabel
            })]
          })
        }, item.value);
      },
      onFilterValueChange: inputValue => {
        const filterd = options.filter(option => {
          if (inputValue.length < 2) return true;
          return option.label.toLowerCase().includes(inputValue.toLowerCase());
        });
        setFilteredOptions(filterd);
      }
    }), isLoading && (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Spinner, {
      style: {
        width: `calc(4px * 8)`,
        height: `calc(4px * 8)`
      }
    })]
  });
}

/***/ }),

/***/ "./assets/src/content-snippets/blocks/snippet-section/edit.css":
/*!*********************************************************************!*\
  !*** ./assets/src/content-snippets/blocks/snippet-section/edit.css ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/src/content-snippets/blocks/snippet-section/edit.tsx":
/*!*********************************************************************!*\
  !*** ./assets/src/content-snippets/blocks/snippet-section/edit.tsx ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _select_lesson_form__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./select-lesson-form */ "./assets/src/content-snippets/blocks/snippet-section/select-lesson-form.tsx");




function Edit({
  clientId
}) {
  return (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)("div", {
    ...(0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps)(),
    children: [(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InspectorControls, {
      children: (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
        title: "Use Content From Lesson",
        initialOpen: true,
        children: (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_select_lesson_form__WEBPACK_IMPORTED_MODULE_3__.SelectLessonForm, {
          onSubmit: post => postDataForContent(clientId, post)
        })
      })
    }), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InnerBlocks, {})]
  });
}
async function postDataForContent(clientId, post) {
  const heading = post.title.rendered.trim();
  const description = (post.excerpt?.raw || post.content?.raw.substring(0, 10))?.trim();
  const headingBlock = findHeadingBlock(clientId);
  if (headingBlock && heading) {
    updateBlockContent(headingBlock.clientId, heading);
  }
  const descriptionBlock = findParagraphBlock(clientId);
  if (descriptionBlock && description) {
    updateBlockContent(descriptionBlock.clientId, description);
  }
  const buttonBlock = findButtonBlock(clientId);
  if (buttonBlock) {
    updateButtonLink(buttonBlock.clientId, post.link);
  }
  const imageBlock = findImageBlock(clientId);
  if (imageBlock) {
    const url = await getLessonImage(post.id);
    if (!url) return;
    await updateImageURL(imageBlock.clientId, url);
  } else {
    const rootGroup = findGroupWithBGImage(clientId);
    if (rootGroup) {
      const url = await getLessonImage(post.id);
      console.log(url);
      if (!url) return;
      console.log("url", url);
      updateBGImageURl(rootGroup.clientId, url, rootGroup);
    }
  }
}
function findHeadingBlock(clientId) {
  return findBlock(clientId, 'core/heading');
}
function findParagraphBlock(clientId) {
  return findBlock(clientId, 'core/paragraph');
}
function findButtonBlock(clientId) {
  return findBlock(clientId, 'core/button');
}
function findImageBlock(clientId) {
  return findBlock(clientId, 'core/image');
}
async function updateImageURL(clientId, url) {
  wp.data.dispatch('core/block-editor').updateBlock(clientId, {
    attributes: {
      url
    }
  });
}
function updateButtonLink(clientId, url) {
  wp.data.dispatch('core/block-editor').updateBlock(clientId, {
    attributes: {
      url
    }
  });
}
function findBlock(parentId, blockName) {
  const block = wp.data.select('core/block-editor').getBlock(parentId);
  if (block.name === blockName) {
    return block;
  }
  if (block.innerBlocks) {
    for (const innerBlock of block.innerBlocks) {
      const found = findBlock(innerBlock.clientId, blockName);
      if (found) {
        return found;
      }
    }
  }
  return undefined;
}
function updateBlockContent(clientId, content) {
  wp.data.dispatch('core/block-editor').updateBlock(clientId, {
    attributes: {
      content
    }
  });
}
async function getLessonImage(postId) {
  const url = await wp.apiFetch({
    path: "/jp/v1/lesson-video-url?id=" + postId
  }).then(data => data.url).catch(err => {
    console.error(err);
    return '';
  });
  return url;
}
function findGroupWithBGImage(clientId) {
  const block = wp.data.select('core/block-editor').getBlock(clientId)?.innerBlocks?.[0];
  console.log(block);
  if (block.name !== "core/group") return undefined;
  console.log(block.attributes.style.background.backgroundImage);
  if (!block.attributes.style.background.backgroundImage) return undefined;
  console.log("found image");
  return block;
}
function updateBGImageURl(clientId, url, block) {
  console.log("Updating image url", url);
  wp.data.dispatch('core/block-editor').updateBlock(clientId, {
    attributes: {
      ...block.attributes,
      style: {
        ...block.attributes.style,
        background: {
          ...block.attributes.style.background,
          backgroundImage: {
            ...block.attributes.style.background.backgroundImage,
            url
          }
        }
      }
    }
  });
}

/***/ }),

/***/ "./assets/src/content-snippets/blocks/snippet-section/save.tsx":
/*!*********************************************************************!*\
  !*** ./assets/src/content-snippets/blocks/snippet-section/save.tsx ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ save)
/* harmony export */ });
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);


function save() {
  return (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("div", {
    ..._wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps.save(),
    children: (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InnerBlocks.Content, {})
  });
}

/***/ }),

/***/ "./assets/src/content-snippets/blocks/snippet-section/select-lesson-form.tsx":
/*!***********************************************************************************!*\
  !*** ./assets/src/content-snippets/blocks/snippet-section/select-lesson-form.tsx ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   SelectLessonForm: () => (/* binding */ SelectLessonForm)
/* harmony export */ });
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _combobox__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./combobox */ "./assets/src/content-snippets/blocks/snippet-section/combobox.tsx");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_4__);





const POST_TYPE = "sfwd-lessons";
const CATEGORY = "ld_lesson_category";
function SelectLessonForm({
  onSubmit
}) {
  var _selectedLesson$id$to;
  const [selectedLesson, setSelectedLesson] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.useState)(undefined);
  const {
    terms,
    termsLoading
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => {
    const query = {
      per_page: -1
    };
    return {
      terms: select('core').getEntityRecords('taxonomy', CATEGORY, query),
      termsLoading: select('core').isResolving('core', 'getEntityRecords', ['taxonomy', CATEGORY, query])
    };
  }, []);
  const {
    posts,
    postsLoading
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => {
    const query = {
      per_page: -1,
      post_type: POST_TYPE,
      _embed: true
    };
    return {
      posts: select('core').getEntityRecords('postType', POST_TYPE, query),
      postsLoading: select('core').isResolving('core', 'getEntityRecords', ['postType', POST_TYPE, query])
    };
  }, []);
  const isLoading = postsLoading || termsLoading;
  console.log(posts);
  return (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)("div", {
    children: [(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("h1", {
      children: "Select Lesson Form"
    }), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)("form", {
      onSubmit: e => {
        e.preventDefault();
        if (selectedLesson) {
          onSubmit(selectedLesson);
        }
      },
      children: [(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_combobox__WEBPACK_IMPORTED_MODULE_1__.Combobox, {
        label: "Pick a Lesson to use it's content",
        isLoading: isLoading,
        options: !isLoading && posts?.length ? posts.map(postToOption) : [],
        value: (_selectedLesson$id$to = selectedLesson?.id.toString()) !== null && _selectedLesson$id$to !== void 0 ? _selectedLesson$id$to : null,
        onSelect: value => {
          if (value) {
            const post = posts?.find(post => post.id.toString() === value);
            setSelectedLesson(post);
          }
        }
      }), (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("button", {
        type: "submit",
        className: "button button-small",
        children: "Submit"
      })]
    })]
  });
}
function postToOption(post) {
  const option = {
    value: post.id.toString(),
    label: post.title.raw
  };
  if (post?._embedded['wp:term']?.length) {
    const terms = post._embedded['wp:term'].map(tax => {
      return tax.map(term => {
        return term.name;
      }).flat();
    });
    option.subLabel = terms.filter(Boolean).join(', ');
  }
  return option;
}

/***/ }),

/***/ "./assets/src/content-snippets/blocks/snippet-section/view.css":
/*!*********************************************************************!*\
  !*** ./assets/src/content-snippets/blocks/snippet-section/view.css ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/core-data":
/*!**********************************!*\
  !*** external ["wp","coreData"] ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["wp"]["coreData"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["data"];

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
/*!*********************************************************************!*\
  !*** ./assets/src/content-snippets/blocks/snippet-section/index.ts ***!
  \*********************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./block.json */ "./assets/src/content-snippets/blocks/snippet-section/block.json");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./assets/src/content-snippets/blocks/snippet-section/edit.tsx");
/* harmony import */ var _edit_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./edit.css */ "./assets/src/content-snippets/blocks/snippet-section/edit.css");
/* harmony import */ var _view_css__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./view.css */ "./assets/src/content-snippets/blocks/snippet-section/view.css");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./save */ "./assets/src/content-snippets/blocks/snippet-section/save.tsx");






(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_1__.name, {
  attributes: _block_json__WEBPACK_IMPORTED_MODULE_1__.attributes,
  category: _block_json__WEBPACK_IMPORTED_MODULE_1__.category,
  title: _block_json__WEBPACK_IMPORTED_MODULE_1__.title,
  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_2__["default"],
  /**
   * @see ./save.js
   */
  save: _save__WEBPACK_IMPORTED_MODULE_5__["default"]
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map