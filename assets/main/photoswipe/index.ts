import { ready } from 'domestique';

ready(() => {
    const galleries = document.querySelectorAll(
        '.wp-block-gallery',
    ) as NodeListOf<HTMLElement>;

    const images = document.querySelectorAll(
        '.wp-block-image',
    ) as NodeListOf<HTMLImageElement>;

    if (galleries.length > 0 || images.length > 0) {
        import('./setup').then((module) => {
            if (galleries) {
                galleries.forEach((gallery) => {
                    module.setup(gallery);
                });
            }

            if (images) {
                images.forEach((image) => {
                    module.setup(image);
                });
            }
        });
    }
});
