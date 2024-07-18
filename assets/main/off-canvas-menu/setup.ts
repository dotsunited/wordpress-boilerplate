import ctrly from 'ctrly/src/ctrly';

import './style-control.css';
import './style-target.css';
import './style-navigation.css';

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
