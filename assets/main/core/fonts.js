var $ = require('jquery');

var html = $(document.documentElement);

if (!html.is('.fonts-loaded')) {
    window.WebFontConfig = {
        google: {
            families: ['Roboto']
        },
        classes: false,
        active: function() {
            html.addClass('fonts-loaded')
        }
    };

    // Don't use $.getScript() as it uses cache: false
    // https://api.jquery.com/jquery.getscript/#caching-requests
    $.ajax({
        dataType: 'script',
        cache: true,
        url: '//ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js'
    });

    var date = new Date();
    date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));

    window.document.cookie = 'fonts-loaded=true; expires=' + date.toGMTString() + '; path=/';
}
