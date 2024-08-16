import { ready } from 'domestique';

ready(() => {
    const galleries = document.querySelectorAll('.wp-block-gallery') as NodeListOf<HTMLElement>;

    if (!galleries) {
        return;
    }

    import('./setup').then((module) => {
        galleries.forEach((gallery) => {
            module.setup(gallery);
        });
    });
});
