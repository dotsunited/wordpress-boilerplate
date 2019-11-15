const __ = wp.i18n.__;
const {
    registerBlockType
} = wp.blocks;

const {
    InnerBlocks,
} = wp.blockEditor;

const {
    Path,
    SVG,
} = wp.components;

registerBlockType('wordpress-boilerplate/grid-item', {
    title: __('Wordpress Boilerplate Grid Item', 'wordpress-boilerplate'),

    parent: ['wordpress-boilerplate/grid'],

    icon: <SVG xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><Path fill="none" d="M0 0h24v24H0V0z"/><Path d="M11.99 18.54l-7.37-5.73L3 14.07l9 7 9-7-1.63-1.27zM12 16l7.36-5.73L21 9l-9-7-9 7 1.63 1.27L12 16zm0-11.47L17.74 9 12 13.47 6.26 9 12 4.53z"/></SVG>,

    description: __('A single grid item within a grid block.', 'wordpress-boilerplate'),

    category: 'common',

    attributes: {
        columns: {
            type: 'number',
            default: 2,
        },
        rows: {
            type: 'number',
            default: 1,
        },
    },

    supports: {
        inserter: false,
        reusable: false,
        html: false,
    },

    edit() {
        return <InnerBlocks templateLock={false}/>;
    },

    save() {
        return (
            <div className="wordpress-boilerplate-block-grid-item">
                <InnerBlocks.Content/>
            </div>
        );
    },
});
