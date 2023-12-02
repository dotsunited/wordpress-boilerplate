/* eslint no-undef: 0 */

const { getCategories, setCategories } = wp.blocks;

setCategories([
    {
        slug: 'wordpress-boilerplate',
        title: 'WordPress Boilerplate',
    },
    ...getCategories().filter(({ slug }) => slug !== 'wordpress-boilerplate'),
]);
