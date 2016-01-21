require('./fonts/fonts.css');

var cookieDays = 1;

function setCookie() {
    var date = new Date();
    date.setTime(date.getTime() + (cookieDays * 24 * 60 * 60 * 1000));

    window.document.cookie = 'fonts-loaded=true; expires=' + date.toGMTString() + '; path=/';
}

function checkCookie() {
    return ('; ' + document.cookie).split('; fonts-loaded=').length === 2;
}

function loaded() {
    document.documentElement.className += ' fonts-loaded';
}

if (checkCookie()) {
    loaded();
} else {
    require.ensure(['fontfaceobserver'], function() {
        var FontFaceObserver = require('fontfaceobserver');

        var observer = new FontFaceObserver('Roboto');

        observer
            .check()
            .then(loaded)
            .then(setCookie)
            .then(null, function(){})
        ;
    });
}
