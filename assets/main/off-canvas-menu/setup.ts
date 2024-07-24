import ctrly from 'ctrly/src/ctrly';

import './style-control.scss';
import './style-target.scss';
import './style-navigation.scss';

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
