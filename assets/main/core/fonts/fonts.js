require('./fonts.css');
var shared = require('./fonts-shared');

var cookieDays = 1;

function setCookie() {
    var date = new Date();
    date.setTime(date.getTime() + (cookieDays * 24 * 60 * 60 * 1000));

    window.document.cookie = 'fonts-loaded=true; expires=' + date.toGMTString() + '; path=/';
}

if (!shared.check()) {
    require.ensure(['fontfaceobserver/fontfaceobserver'], function() {
        var FontFaceObserver = require('fontfaceobserver/fontfaceobserver');

        var observer = new FontFaceObserver('Roboto');

        observer
            .load()
            .then(shared.loaded)
            .then(setCookie)
            .then(null, function(){})
        ;
    });
}
