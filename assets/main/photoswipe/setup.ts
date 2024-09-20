import PhotoSwipeLightbox from 'photoswipe/lightbox';
import 'photoswipe/style.css';

export function setup(gallery: HTMLElement) {
    const items = gallery.querySelectorAll('a');

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
        gallery,
        children: 'a',
        pswpModule: () => import('photoswipe'),
    });

    lightbox.init();
}
