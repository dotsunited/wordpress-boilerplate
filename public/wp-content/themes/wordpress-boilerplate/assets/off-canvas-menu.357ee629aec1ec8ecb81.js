(self.webpackChunk_dotsunited_wordpress_boilerplate=self.webpackChunk_dotsunited_wordpress_boilerplate||[]).push([[87],{7923:function(t,e,n){"use strict";function r(){try{var t=document.activeElement;return t&&t.nodeName?t:document.body}catch(t){return document.body}}n.r(e);var o={thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_:[0,"",""]};o.tbody=o.thead,o.tfoot=o.thead,o.colgroup=o.thead,o.caption=o.thead,o.th=o.td;function a(t){for(var e=[];t&&t.parentNode&&1===t.parentNode.nodeType;)t=t.parentNode,e.push(t);return e}function i(t){var e=a(t).map((function(t){return[t,t.scrollTop,t.scrollLeft]}));return function(){e.forEach((function(t){t[0].scrollTop=t[1],t[0].scrollLeft=t[2]}))}}function u(t){var e,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},r=n.restoreScrollPosition;r&&(e=i(t));try{t.focus()}catch(t){}e&&e()}function c(t,e){if(!t)return!1;var n=t.matches||t.webkitMatchesSelector||t.msMatchesSelector;return"function"==typeof n&&n.call(t,e)}function l(t,e){if(!t)return null;if("function"==typeof t.closest)return t.closest(e);do{if(c(t,e))return t;t=t.parentNode}while(t&&1===t.nodeType);return null}function s(t,e){return t&&"function"==typeof t.querySelectorAll?[].slice.call(t.querySelectorAll(e)):[]}var d,f=["a[href]","area[href]","input","select","textarea","button","iframe","object","audio[controls]","video[controls]","[contenteditable]","[tabindex]"].join(","),p=/^(input|select|textarea|button|object)$/;function v(t){var e=t.nodeName.toLowerCase();if("area"===e)return function(t){var e=t.parentNode,n=e.name;if(!t.href||!n||"map"!==e.nodeName.toLowerCase())return!1;var r=s(document,'img[usemap="#'.concat(n,'"]'));return r.length>0&&m(r[0])}(t);if(t.disabled)return!1;if(p.test(e)){var n=l(t,"fieldset");if(n&&n.disabled)return!1}return m(t)}function b(t){var e=y(t);return v(t)&&e>=0}function h(t,e){var n=y(t,!0),r=y(e,!0);return n===r?2&t.compareDocumentPosition(e)?1:-1:n-r}function m(t){var e=getComputedStyle(t);return"hidden"!==e.visibility&&"collapse"!==e.visibility&&"none"!==e.display&&a(t).every((function(t){return"none"!==getComputedStyle(t).display}))}function y(t){var e=arguments.length>1&&void 0!==arguments[1]&&arguments[1],n=parseInt(t.getAttribute("tabindex"),10);return isNaN(n)||e&&n<0?0:n}function g(t){return c(t,f)&&b(t)}function A(){if(d)return d;d={capture:!1,once:!1,passive:!1};var t={get capture(){return d.capture=!0,!1},get once(){return d.once=!0,!1},get passive(){return d.passive=!0,!1}};return window.addEventListener("test",t,t),window.removeEventListener("test",t,t),d}function w(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},e=A(),n=e.once,r=e.passive,o=e.capture;return n||r||o?(n||delete t.once,r||delete t.passive,o||delete t.capture,t):Boolean(t.capture)}function E(t,e,n){var r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{capture:!1};t&&"function"==typeof t.removeEventListener&&t.removeEventListener(e,n,w(r))}function O(t,e,n){var r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{capture:!1};if(!t||"function"!=typeof t.addEventListener)return function(){};var o=n,a=function(){E(t,e,o,r)};return r.once&&!A().once&&(o=function(e){a(),n.call(t,e)}),t.addEventListener(e,o,w(r)),a}function x(t,e,n,r){var o=arguments.length>4&&void 0!==arguments[4]?arguments[4]:{capture:!1},a=!0===o.once;delete o.once;var i=O(t,e,(function(t){var e=l(t.target,n);e&&(a&&i(),r.call(e,t,e))}),o);return i}function C(t,e){var n,r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};if(!t||"function"!=typeof t.dispatchEvent)return!0;r.bubbles=r.bubbles||!1,r.cancelable=r.cancelable||!1,r.composed=r.composed||!1,r.detail=r.detail||null;try{n=new CustomEvent(e,r)}catch(t){(n=document.createEvent("CustomEvent")).initCustomEvent(e,r.bubbles,r.cancelable,r.detail)}return t.dispatchEvent(n)}function L(t){var e=document.readyState;"complete"!==e&&"interactive"!==e?document.addEventListener("DOMContentLoaded",(function(){t()}),w({capture:!0,once:!0,passive:!0})):setTimeout(t,0)}function k(t,e){var n=arguments.length>1?e:document;return n&&"function"==typeof n.querySelectorAll?[].slice.call(n.querySelectorAll(t)):[]}function N(t){return s(arguments.length>0?t:document,f).filter(b).sort(h)}var S={selector:"[data-ctrly]",context:null,focusTarget:!0,closeOnBlur:!0,closeOnEsc:!0,closeOnOutsideClick:!0,closeOnScroll:!1,trapFocus:!1,allowMultiple:!1,on:null,autoInit:!0};function D(t){var e={};return[S,t].forEach((function(t){for(var n in t)Object.prototype.hasOwnProperty.call(t,n)&&(e[n]=t[n])})),e}function T(t){return"which"in t?t.which:t.keyCode}function j(t){return k('[aria-controls="'.concat(t.id,'"]'))}function _(t){return document.getElementById(t.getAttribute("aria-controls")||t.getAttribute("data-ctrly"))}function B(t){t.removeAttribute("aria-pressed"),t.removeAttribute("aria-controls"),t.removeAttribute("aria-expanded")}var M=0;function P(){var t,e,n=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},o=D(n),a=o.selector,i=o.on||{},c={};function s(t){return o.context?l(t,o.context):document}function d(t,e){return("function"!=typeof i[e]||!1!==i[e](t))&&!1!==C(t,"ctrly:".concat(e),{bubbles:!0,cancelable:!0})}function f(t){for(var e=t;e;){if(e.id&&c[e.id])return e;e=e.parentElement}}function p(t){var e=!(arguments.length>1&&void 0!==arguments[1])||arguments[1];if(!t)return!1;if(!t.hasAttribute("data-ctrly-opened"))return!1;if(!d(t,"close"))return!1;var n=r(),o=c[t.id]||{},a=o.lastActiveElement,i=o.destroy;return delete c[t.id],i&&i(),j(t).forEach((function(t){"button"!==t.tagName.toLowerCase()&&t.setAttribute("aria-pressed","false"),t.setAttribute("aria-expanded","false")})),t.removeAttribute("data-ctrly-opened"),t.setAttribute("aria-hidden","true"),t.removeAttribute("tabindex"),t.blur(),e&&a&&t.contains(n)&&u(a,{restoreScrollPosition:!0}),d(t,"closed"),t}function v(t){k(a,s(t)).forEach((function(e){var n=_(e);n&&n.id!==t.id&&p(n,!1)}))}function b(t,e){var n=[];if(o.closeOnBlur&&!o.trapFocus&&n.push(O(document,"focusin",(function(t){e.contains(t.target)||setTimeout((function(){p(e,!1)}),0)}),{capture:!0,passive:!0})),o.closeOnEsc&&n.push(O(document,"keydown",(function(t){27===T(t)&&p(e)&&t.preventDefault()}))),o.closeOnOutsideClick&&n.push(O(document,"click",(function(t){1!==T(t)||e.contains(t.target)||l(t.target,a)||p(e)}),{passive:!0})),o.closeOnScroll){var i=!1,c=function(){i=!0},s=function(){i=!1};n.push(O(e,"mouseenter",c,{passive:!0})),n.push(O(e,"mouseleave",s,{passive:!0})),n.push(O(e,"touchstart",c,{passive:!0})),n.push(O(e,"touchend",s,{passive:!0})),n.push(O(window,"scroll",(function(){i||p(e)}),{passive:!0}))}return o.trapFocus&&n.push(O(document,"keydown",(function(t){if(9===T(t)){var n=N(e);if(!n[0])return t.preventDefault(),void u(e);var o=r(),a=n[0],i=n[n.length-1];if(t.shiftKey&&o===a)return t.preventDefault(),void u(i);t.shiftKey||o!==i||(u(a),t.preventDefault())}}))),function(){for(;n.length;)n.shift().call()}}function h(t){var e=_(t);return e?!e.hasAttribute("data-ctrly-opened")&&(!!d(e,"open")&&(c[e.id]={lastActiveElement:r(),destroy:b(0,e)},j(e).forEach((function(t){"button"!==t.tagName.toLowerCase()&&t.setAttribute("aria-pressed","true"),t.setAttribute("aria-expanded","true")})),e.setAttribute("data-ctrly-opened",""),e.setAttribute("aria-hidden","false"),e.setAttribute("tabindex","-1"),d(e,"opened"),e)):(B(t),!1)}function m(t,e){var n=_(e);n?"true"!==e.getAttribute("aria-expanded")?(o.allowMultiple||v(n),h(e),n&&(t.preventDefault(),o.focusTarget&&u(N(n)[0]||n),n.scrollTop=0,n.scrollLeft=0)):p(n)&&t.preventDefault():p(f(e))&&t.preventDefault()}function y(){t||(t=x(document,"click",a,(function(t,e){1===T(t)&&m(t,e)})),e=x(document,"keydown",a,(function(t,e){13!==T(t)&&32!==T(t)||m(t,e)}))),k(a).forEach((function(t){var e=_(t);if(e){"button"!==t.tagName.toLowerCase()&&(t.hasAttribute("role")||t.setAttribute("role","button"),g(t)||t.setAttribute("tabindex","0")),t.setAttribute("aria-controls",e.id);var n=j(e).map((function(t){return t.id||t.setAttribute("id","ctrly-control-"+ ++M),t.id})),r=(e.getAttribute("aria-labelledby")||"").split(" ").concat(n).filter((function(t,e,n){return""!==t&&n.indexOf(t)===e}));e.setAttribute("aria-labelledby",r.join(" ")),"true"===t.getAttribute("aria-expanded")||t.hasAttribute("data-ctrly-open")?h(t):("button"!==t.tagName.toLowerCase()&&t.setAttribute("aria-pressed","false"),t.setAttribute("aria-expanded","false"),e.setAttribute("aria-hidden","true"),e.removeAttribute("tabindex"))}else B(t)}))}function A(n){for(var r in n&&t&&(t(),t=null,e(),e=null),k(a).forEach((function(t){n&&B(t);var e=_(t);e&&(p(e,!1),n&&e.removeAttribute("aria-hidden"))})),c)Object.prototype.hasOwnProperty.call(c,r)&&(c[r].destroy(),delete c[r])}function w(){A(!1)}function E(){A(!0)}return o.autoInit&&L(y),{closeAll:w,destroy:E,init:y}}P({selector:".js-off-canvas-menu-control",closeOnScroll:!0,trapFocus:!0}),P({selector:".js-off-canvas-menu-submenu-control",closeOnOutsideClick:!1,closeOnBlur:!1})}}]);