import { ready } from 'domestique';

const init = () => {
    const galleries = document.querySelectorAll('.wp-block-gallery');

    if (!galleries) {
        return;
    }

    import('./setup').then((module) => {
        galleries.forEach((gallery) => {
            module.setup(gallery);
        });
    });
};

ready(() => {
    init();
});
