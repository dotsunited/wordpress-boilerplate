!function(){"use strict";var e,t,r,n,o={},i={};function u(e){if(i[e])return i[e].exports;var t=i[e]={exports:{}};return o[e](t,t.exports,u),t.exports}u.m=o,u.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return u.d(t,{a:t}),t},u.d=function(e,t){for(var r in t)u.o(t,r)&&!u.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})},u.f={},u.e=function(e){return Promise.all(Object.keys(u.f).reduce((function(t,r){return u.f[r](e,t),t}),[]))},u.u=function(e){return"off-canvas-menu.357ee629aec1ec8ecb81.js"},u.miniCssF=function(e){return{87:"off-canvas-menu",179:"main",578:"icons",666:"runtime"}[e]+"."+{87:"0b46a61a",179:"9ec6779b",578:"e25ae78c",666:"undefine"}[e]+".css"},u.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"==typeof window)return window}}(),u.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},e={},u.l=function(t,r,n){if(e[t])e[t].push(r);else{var o,i;if(void 0!==n)for(var a=document.getElementsByTagName("script"),c=0;c<a.length;c++){var s=a[c];if(s.getAttribute("src")==t||s.getAttribute("data-webpack")=="@dotsunited/wordpress-boilerplate:"+n){o=s;break}}o||(i=!0,(o=document.createElement("script")).charset="utf-8",o.timeout=120,u.nc&&o.setAttribute("nonce",u.nc),o.setAttribute("data-webpack","@dotsunited/wordpress-boilerplate:"+n),o.src=t),e[t]=[r];var f=function(r,n){o.onerror=o.onload=null,clearTimeout(l);var i=e[t];if(delete e[t],o.parentNode&&o.parentNode.removeChild(o),i&&i.forEach((function(e){return e(n)})),r)return r(n)},l=setTimeout(f.bind(null,void 0,{type:"timeout",target:o}),12e4);o.onerror=f.bind(null,o.onerror),o.onload=f.bind(null,o.onload),i&&document.head.appendChild(o)}},u.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},function(){var e;u.g.importScripts&&(e=u.g.location+"");var t=u.g.document;if(!e&&t&&(t.currentScript&&(e=t.currentScript.src),!e)){var r=t.getElementsByTagName("script");r.length&&(e=r[r.length-1].src)}if(!e)throw new Error("Automatic publicPath is not supported in this browser");e=e.replace(/#.*$/,"").replace(/\?.*$/,"").replace(/\/[^\/]+$/,"/"),u.p=e}(),t=function(e,t,r){var n=document.createElement("link");return n.rel="stylesheet",n.type="text/css",n.onload=t,n.onerror=function(t){var o=t&&t.target&&t.target.src||e,i=new Error("Loading CSS chunk "+chunkId+" failed.\n("+o+")");i.code="CSS_CHUNK_LOAD_FAILED",i.request=o,n.parentNode.removeChild(n),r(i)},n.href=e,document.getElementsByTagName("head")[0].appendChild(n),n},r=function(e){return new Promise((function(r,n){var o=u.miniCssF(e),i=u.p+o;if(function(e,t){for(var r=document.getElementsByTagName("link"),n=0;n<r.length;n++){var o=(u=r[n]).getAttribute("data-href")||u.getAttribute("href");if("stylesheet"===u.rel&&(o===e||o===t))return u}var i=document.getElementsByTagName("style");for(n=0;n<i.length;n++){var u;if((o=(u=i[n]).getAttribute("data-href"))===e||o===t)return u}}(o,i))return r();t(i,r,n)}))},n={666:0},u.f.miniCss=function(e,t){n[e]?t.push(n[e]):0!==n[e]&&{87:1}[e]&&t.push(n[e]=r(e).then((function(){n[e]=0}),(function(t){throw delete n[e],t})))},function(){var e={666:0},t=[];u.f.j=function(t,r){var n=u.o(e,t)?e[t]:void 0;if(0!==n)if(n)r.push(n[2]);else{var o=new Promise((function(r,o){n=e[t]=[r,o]}));r.push(n[2]=o);var i=u.p+u.u(t),a=new Error;u.l(i,(function(r){if(u.o(e,t)&&(0!==(n=e[t])&&(e[t]=void 0),n)){var o=r&&("load"===r.type?"missing":r.type),i=r&&r.target&&r.target.src;a.message="Loading chunk "+t+" failed.\n("+o+": "+i+")",a.name="ChunkLoadError",a.type=o,a.request=i,n[1](a)}}),"chunk-"+t)}};var r=function(){};function n(){for(var r,n=0;n<t.length;n++){for(var o=t[n],i=!0,a=1;a<o.length;a++){var c=o[a];0!==e[c]&&(i=!1)}i&&(t.splice(n--,1),r=u(u.s=o[0]))}return 0===t.length&&(u.x(),u.x=function(){}),r}u.x=function(){u.x=function(){},i=i.slice();for(var e=0;e<i.length;e++)o(i[e]);return(r=n)()};var o=function(n){for(var o,i,c=n[0],s=n[1],f=n[2],l=n[3],d=0,p=[];d<c.length;d++)i=c[d],u.o(e,i)&&e[i]&&p.push(e[i][0]),e[i]=0;for(o in s)u.o(s,o)&&(u.m[o]=s[o]);for(f&&f(u),a(n);p.length;)p.shift()();return l&&t.push.apply(t,l),r()},i=self.webpackChunk_dotsunited_wordpress_boilerplate=self.webpackChunk_dotsunited_wordpress_boilerplate||[],a=i.push.bind(i);i.push=o}(),u.x()}();