$(function() {
    var slider = $('.slider');

    if (!slider.length) {
        return;
    }

    require.ensure([
        './style.less',
        'slick-carousel/slick/slick.js'
    ], function() {
        require('./style.less');
        require('slick-carousel/slick/slick.js');

        slider.slick({
            dots: true,
            arrows: false
        });
    });
});
