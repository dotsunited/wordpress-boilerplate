/* eslint no-undef: 0 */

const { registerBlockType } = wp.blocks;
const { createElement } = wp.element;
const { useBlockProps } = wp.blockEditor;

registerBlockType('wordpress-boilerplate/example', {
    apiVersion: 3,
    title: 'Example',
    description: 'A minimal example block.',
    category: 'wordpress-boilerplate',
    icon: 'welcome-learn-more',
    edit: function Edit() {
        return createElement(
            'p',
            useBlockProps(),
            'Example block',
        );
    },
    save: function Save() {
        return createElement(
            'p',
            useBlockProps.save(),
            'Example block',
        );
    },
});
