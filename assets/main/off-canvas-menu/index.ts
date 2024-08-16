import ctrly from 'ctrly/src/ctrly';
import { ready } from 'domestique';

import './style.scss';
import './style-control.scss';
import './style-target.scss';
import './style-navigation.scss';

ready(() => {
    ctrly({
        selector: '.js-off-canvas-menu-control',
        closeOnScroll: true,
        trapFocus: true,
    });

    ctrly({
        selector: '.js-off-canvas-menu-submenu-control',
        closeOnOutsideClick: false,
        closeOnBlur: false,
    });
});
