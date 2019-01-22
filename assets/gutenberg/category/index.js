const { getCategories, setCategories } = wp.blocks;

setCategories( [
    {
        slug: 'wordpress-boilerplate',
        title: 'Wordpress Boilerplate'
    },
    ...getCategories().filter( ( { slug } ) => slug !== 'wordpress-boilerplate' ),
] );
