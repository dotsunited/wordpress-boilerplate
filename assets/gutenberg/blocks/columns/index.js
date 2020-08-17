const { Path, SVG } = wp.components;

wp.domReady(() => {

    // Remove core columns variants
    wp.blocks.unregisterBlockVariation('core/columns', 'two-columns-equal');
    wp.blocks.unregisterBlockVariation('core/columns', 'three-columns-equal');
    wp.blocks.unregisterBlockVariation('core/columns', 'two-columns-one-third-two-thirds');
    wp.blocks.unregisterBlockVariation('core/columns', 'two-columns-two-thirds-one-third');
    wp.blocks.unregisterBlockVariation('core/columns', 'three-columns-wider-center');

    // Add custom columns variants
    wp.blocks.registerBlockVariation(
            'core/columns',
            [
                {
                    name: '1/2-1/2',
                    title: '1/2 Spalten',
                    isDefault: false,
                    attributes: {
                        className: ''
                    },
                    innerBlocks: [
                        [ 'core/column', { className: 'w-full md:w-1/2 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/2 px-2' } ]
                    ],
                    icon: (
                            <SVG
                                    width="48"
                                    height="48"
                                    viewBox="0 0 48 48"
                                    xmlns="http://www.w3.org/2000/svg"
                            >
                                <Path
                                        fillRule="evenodd"
                                        clipRule="evenodd"
                                        d="M39 12C40.1046 12 41 12.8954 41 14V34C41 35.1046 40.1046 36 39 36H9C7.89543 36 7 35.1046 7 34V14C7 12.8954 7.89543 12 9 12H39ZM39 34V14H25V34H39ZM23 34H9V14H23V34Z"
                                />
                            </SVG>
                    ),
                    scope: [ 'block' ]
                },
                {
                    name: '1/3-1/3-1/3',
                    title: '1/3 Spalten',
                    isDefault: false,
                    attributes: {
                        className: ''
                    },
                    innerBlocks: [
                        [ 'core/column', { className: 'w-full md:w-1/3 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/3 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/3 px-2' } ]
                    ],
                    icon: (
                            <SVG
                                    width="48"
                                    height="48"
                                    viewBox="0 0 48 48"
                                    xmlns="http://www.w3.org/2000/svg"
                            >
                                <Path
                                        fillRule="evenodd"
                                        d="M41 14a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h30a2 2 0 0 0 2-2V14zM28.5 34h-9V14h9v20zm2 0V14H39v20h-8.5zm-13 0H9V14h8.5v20z"
                                />
                            </SVG>
                    ),
                    scope: [ 'block' ]
                },
                {
                    name: '1/4-1/4-1/4-1/4',
                    title: '1/4 Spalten',
                    isDefault: false,
                    attributes: {
                        className: ''
                    },
                    innerBlocks: [
                        [ 'core/column', { className: 'w-full md:w-1/4 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/4 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/4 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/4 px-2' } ]
                    ],
                    icon: (
                            <SVG
                                    width="48"
                                    height="48"
                                    viewBox="0 0 48 48"
                                    xmlns="http://www.w3.org/2000/svg"
                            >
                                <Path
                                        fillRule="evenodd"
                                        d="M41,14c0-1.1-0.9-2-2-2H9c-1.1,0-2,0.9-2,2v20c0,1.1,0.9,2,2,2h30c1.1,0,2-0.9,2-2V14z M23.2,34H17V14h6.2V34z
	 M25,34V14h6.3v20H25z M32.7,34V14h6.3v20H32.7z M15.3,34H9.1V14h6.3V34z"
                                />
                            </SVG>
                    ),
                    scope: [ 'block' ]
                },
                {
                    name: '1/5-1/5-1/5-1/5-1/5',
                    title: '1/5 Spalten',
                    isDefault: false,
                    attributes: {
                        className: ''
                    },
                    innerBlocks: [
                        [ 'core/column', { className: 'w-full md:w-1/2 lg:w-1/5 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/2 lg:w-1/5 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/2 lg:w-1/5 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/2 lg:w-1/5 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/2 lg:w-1/5 px-2' } ]
                    ],
                    icon: (
                            <SVG
                                    width="48"
                                    height="48"
                                    viewBox="0 0 48 48"
                                    xmlns="http://www.w3.org/2000/svg"
                            >
                                <Path
                                        fillRule="evenodd"
                                        d="M41,14c0-1.1-0.9-2-2-2H9c-1.1,0-2,0.9-2,2v20c0,1.1,0.9,2,2,2h30c1.1,0,2-0.9,2-2V14z M20.2,34h-4.9V14h4.9V34
	z M21.6,34V14h4.9v20H21.6z M27.7,34V14h4.9v20H27.7z M34,34V14h4.9v20H34z M14,34H9.1V14H14V34z"
                                />
                            </SVG>
                    ),
                    scope: [ 'block' ]
                },
                {
                    name: '1/6-1/6-1/6-1/6-1/6-1/6',
                    title: '1/6 Spalten',
                    isDefault: false,
                    attributes: {
                        className: ''
                    },
                    innerBlocks: [
                        [ 'core/column', { className: 'w-full md:w-1/2 lg:w-1/6 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/2 lg:w-1/6 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/2 lg:w-1/6 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/2 lg:w-1/6 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/2 lg:w-1/6 px-2' } ],
                        [ 'core/column', { className: 'w-full md:w-1/2 lg:w-1/6 px-2' } ]
                    ],
                    icon: (
                            <SVG
                                    width="48"
                                    height="48"
                                    viewBox="0 0 48 48"
                                    xmlns="http://www.w3.org/2000/svg"
                            >
                                <Path
                                        fillRule="evenodd"
                                        d="M41,14c0-1.1-0.9-2-2-2H9c-1.1,0-2,0.9-2,2v20c0,1.1,0.9,2,2,2h30c1.1,0,2-0.9,2-2V14z M18.3,34h-4.1V14h4.1V34
	z M19.4,34V14h4.1v20H19.4z M24.4,34V14h4.1v20H24.4z M29.6,34V14h4.1v20H29.6z M34.8,34V14h4.1v20H34.8z M13.2,34H9.1V14h4.1V34z"
                                />
                            </SVG>
                    ),
                    scope: [ 'block' ]
                }
            ]
    );

});

// Wrap columns block in div.
wp.hooks.addFilter(
        'blocks.getSaveElement',
        'slug/modify-get-save-content-extra-props',
        modifyGetSaveContentExtraProps
);

/**
 * Wrap columns block in div.
 *
 * @param {object} element
 * @param {object} blockType
 * @param {object} attributes
 *
 * @return The element.
 */
function modifyGetSaveContentExtraProps( element, blockType, attributes  ) {
    // Check if that is not a columns block.
    if (blockType.name !== 'core/columns') {
        return element;
    }

    // Return the cloumns block with div wrapper.
    return (
            <div className='px-2'>
                {element}
            </div>
    );
}
