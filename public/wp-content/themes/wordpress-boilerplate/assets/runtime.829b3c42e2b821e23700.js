!function(){"use strict";var e,t,n,r,o,u={},i={};function a(e){if(i[e])return i[e].exports;var t=i[e]={exports:{}};return u[e](t,t.exports,a),t.exports}a.m=u,a.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(t,{a:t}),t},a.d=function(e,t){for(var n in t)a.o(t,n)&&!a.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},a.f={},a.e=function(e){return Promise.all(Object.keys(a.f).reduce((function(t,n){return a.f[n](e,t),t}),[]))},a.u=function(e){return"off-canvas-menu.357ee629aec1ec8ecb81.js"},a.miniCssF=function(e){return{87:"off-canvas-menu",179:"main",578:"icons",666:"runtime"}[e]+"."+{87:"0b46a61a",179:"9ec6779b",578:"e25ae78c",666:"undefine"}[e]+".css"},a.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"==typeof window)return window}}(),a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},e={},t="@dotsunited/wordpress-boilerplate:",a.l=function(n,r,o){if(e[n])e[n].push(r);else{var u,i;if(void 0!==o)for(var f=document.getElementsByTagName("script"),c=0;c<f.length;c++){var s=f[c];if(s.getAttribute("src")==n||s.getAttribute("data-webpack")==t+o){u=s;break}}u||(i=!0,(u=document.createElement("script")).charset="utf-8",u.timeout=120,a.nc&&u.setAttribute("nonce",a.nc),u.setAttribute("data-webpack",t+o),u.src=n),e[n]=[r];var l=function(t,r){u.onerror=u.onload=null,clearTimeout(d);var o=e[n];if(delete e[n],u.parentNode&&u.parentNode.removeChild(u),o&&o.forEach((function(e){return e(r)})),t)return t(r)},d=setTimeout(l.bind(null,void 0,{type:"timeout",target:u}),12e4);u.onerror=l.bind(null,u.onerror),u.onload=l.bind(null,u.onload),i&&document.head.appendChild(u)}},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.p="",n=function(e,t,n){var r=document.createElement("link");return r.rel="stylesheet",r.type="text/css",r.onload=t,r.onerror=function(t){var o=t&&t.target&&t.target.src||e,u=new Error("Loading CSS chunk "+chunkId+" failed.\n("+o+")");u.code="CSS_CHUNK_LOAD_FAILED",u.request=o,r.parentNode.removeChild(r),n(u)},r.href=e,document.getElementsByTagName("head")[0].appendChild(r),r},r=function(e){return new Promise((function(t,r){var o=a.miniCssF(e),u=a.p+o;if(function(e,t){for(var n=document.getElementsByTagName("link"),r=0;r<n.length;r++){var o=(i=n[r]).getAttribute("data-href")||i.getAttribute("href");if("stylesheet"===i.rel&&(o===e||o===t))return i}var u=document.getElementsByTagName("style");for(r=0;r<u.length;r++){var i;if((o=(i=u[r]).getAttribute("data-href"))===e||o===t)return i}}(o,u))return t();n(u,t,r)}))},o={666:0},a.f.miniCss=function(e,t){o[e]?t.push(o[e]):0!==o[e]&&{87:1}[e]&&t.push(o[e]=r(e).then((function(){o[e]=0}),(function(t){throw delete o[e],t})))},function(){var e={666:0},t=[];a.f.j=function(t,n){var r=a.o(e,t)?e[t]:void 0;if(0!==r)if(r)n.push(r[2]);else{var o=new Promise((function(n,o){r=e[t]=[n,o]}));n.push(r[2]=o);var u=a.p+a.u(t),i=new Error;a.l(u,(function(n){if(a.o(e,t)&&(0!==(r=e[t])&&(e[t]=void 0),r)){var o=n&&("load"===n.type?"missing":n.type),u=n&&n.target&&n.target.src;i.message="Loading chunk "+t+" failed.\n("+o+": "+u+")",i.name="ChunkLoadError",i.type=o,i.request=u,r[1](i)}}),"chunk-"+t)}};var n=function(){};function r(){for(var n,r=0;r<t.length;r++){for(var o=t[r],u=!0,i=1;i<o.length;i++){var f=o[i];0!==e[f]&&(u=!1)}u&&(t.splice(r--,1),n=a(a.s=o[0]))}return 0===t.length&&(a.x(),a.x=function(){}),n}a.x=function(){a.x=function(){},u=u.slice();for(var e=0;e<u.length;e++)o(u[e]);return(n=r)()};var o=function(r){for(var o,u,f=r[0],c=r[1],s=r[2],l=r[3],d=0,p=[];d<f.length;d++)u=f[d],a.o(e,u)&&e[u]&&p.push(e[u][0]),e[u]=0;for(o in c)a.o(c,o)&&(a.m[o]=c[o]);for(s&&s(a),i(r);p.length;)p.shift()();return l&&t.push.apply(t,l),n()},u=self.webpackChunk_dotsunited_wordpress_boilerplate=self.webpackChunk_dotsunited_wordpress_boilerplate||[],i=u.push.bind(u);u.push=o}(),a.x()}();