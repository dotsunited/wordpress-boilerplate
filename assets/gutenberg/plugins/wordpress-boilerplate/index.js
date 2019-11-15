import './editor.css';

const {
    __
} = wp.i18n;

const {
    Panel,
    PanelBody,
    PanelRow,
} = wp.components;

const {
} = wp.date;

const {
    Component,
    Fragment,
} = wp.element;

const {
    RichText
} = wp.blockEditor;

const {
    withSelect,
    withDispatch
} = wp.data;

const {
    PluginSidebar,
    PluginSidebarMoreMenuItem
} = wp.editPost;

const {
    compose,
} = wp.compose;


class WordpressBoilerplatePlugin extends Component {

    render() {

        const {
            meta: {
                wordpress_boilerplate_plugin_text,
            } = {},
            updateMeta,
        } = this.props;

        return (
            <Fragment>
                <PluginSidebarMoreMenuItem
                    name="wordpress-boilerplate-plugin-sidebar"
                    type="sidebar"
                    target="wordpress-boilerplate-plugin-sidebar"
                >
                    { __( 'Demo', 'wordpress-boilerplate' ) }
                </PluginSidebarMoreMenuItem>
                <PluginSidebar
                    name="wordpress-boilerplate-plugin-sidebar"
                    title={ __( 'Demo', 'wordpress-boilerplate' ) }
                >
                    <Panel>
                        <PanelBody
                            title="Demo Text"
                            initialOpen={ false }
                            className="wordpress-boilerplate-plugin-description"
                        >
                            <PanelRow>
                                <RichText
                                    value={ wordpress_boilerplate_plugin_text }
                                    title={ __( 'Demo', 'wordpress-boilerplate' ) }
                                    placeholder={ __('Demo Placeholder', 'wordpress-boilerplate') }
                                    onChange={ ( value ) => {
                                        updateMeta( { wordpress_boilerplate_plugin_text: value } );
                                    } }
                                />
                            </PanelRow>
                        </PanelBody>
                    </Panel>
                </PluginSidebar>
            </Fragment>
        );
    }
}

// Fetch the post meta.
const applyWithSelect = withSelect( ( select ) => {
    const { getEditedPostAttribute } = select( 'core/editor' );

    return {
        meta: getEditedPostAttribute( 'meta' ),
    };
} );

// Provide method to update post meta.
const applyWithDispatch = withDispatch( ( dispatch, { meta } ) => {
    const { editPost } = dispatch( 'core/editor' );

    return {
        updateMeta( newMeta ) {
            editPost( { meta: { ...meta, ...newMeta } } );
        },
    };
} );

const render = compose( [
    applyWithSelect,
    applyWithDispatch
] )( WordpressBoilerplatePlugin );

export default wp.plugins.registerPlugin('wordpress-boilerplate-gutenberg-plugin', {
    icon: 'admin-tools',
    render
});
