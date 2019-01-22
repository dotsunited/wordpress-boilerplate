import './editor.css';

// lodash/times needs to be imported this way!
// See https://github.com/WordPress/gutenberg/issues/4043#issuecomment-361001527
import times from 'lodash/times';
import classnames from 'classnames';
import memoize from 'memize';

const __ = wp.i18n.__;
const {
    registerBlockType
} = wp.blocks;

const {
    InspectorControls,
    InnerBlocks,
} = wp.editor;

const {
    PanelBody,
    RangeControl,
} = wp.components;

const {
    Fragment
} = wp.element;

const ALLOWED_BLOCKS = ['wordpress-boilerplate/grid-item'];

const getItemsTemplate = memoize((columns) => {
    return times(columns, () => ['wordpress-boilerplate/grid-item']);
});

registerBlockType('wordpress-boilerplate/grid', {
    title: __('Wordpress Boilerplate Grid', 'wordpress-boilerplate'),
    icon: 'grid-view',
    category: 'wordpress-boilerplate',

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

    description: __('Add a block that displays content in multiple columns and rows, then add whatever content blocks you’d like.', 'wordpress-boilerplate'),

    supports: {
        align: ['wide', 'full'],
        html: false,
    },

    edit({attributes, setAttributes, className}) {
        const {columns, rows} = attributes;
        const classes = classnames(className, `has-${columns}-columns has-${rows}-rows`);

        return (
            <Fragment>
                <InspectorControls>
                    <PanelBody>
                        <RangeControl
                            label={__('Columns')}
                            value={columns}
                            onChange={(nextColumns) => {
                                setAttributes({
                                    columns: nextColumns,
                                });
                            }}
                            min={1}
                            max={4}
                        />
                        <RangeControl
                            label={__('Rows', 'bvn')}
                            value={rows}
                            onChange={(nextRows) => {
                                setAttributes({
                                    rows: nextRows,
                                });
                            }}
                            min={1}
                            max={6}
                        />
                    </PanelBody>
                </InspectorControls>
                <div className={classes}>
                    <InnerBlocks
                        template={getItemsTemplate(columns * rows)}
                        templateLock="all"
                        allowedBlocks={ALLOWED_BLOCKS}
                    />
                </div>
            </Fragment>
        );
    },

    save({attributes}) {
        const {columns, rows} = attributes;

        return (
            <div className={`wordpress-boilerplate-block-grid has-${columns}-columns has-${rows}-rows`}>
                <div className="wordpress-boilerplate-block-grid__wrapper">
                    <InnerBlocks.Content/>
                </div>
            </div>
        );
    },
});
