import PhotoSwipeLightbox from 'photoswipe/lightbox';
import 'photoswipe/style.css';

export function setup(block: HTMLElement) {
    const items = block.querySelectorAll('a');

    let isValid = true;

    items.forEach((item) => {
        if (!item.href.includes('wp-content')) {
            isValid = false;
        }
    });

    if (!isValid) {
        return;
    }

    const lightbox = new PhotoSwipeLightbox({
        gallery: block,
        children: 'a',
        pswpModule: () => import('photoswipe'),
    });

    lightbox.init();
}
