( function ( wp ) {
    'use strict';
    var __ = wp.i18n.__;
    var registerPlugin = wp.plugins.registerPlugin;
    var PluginSidebarMoreMenuItem = wp.editPost.PluginSidebarMoreMenuItem;
    var PluginSidebar = wp.editPost.PluginSidebar;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var createElement = wp.element.createElement;
    var useSelect = wp.data.useSelect;
    var useDispatch = wp.data.useDispatch;

    registerPlugin( 'excerpt-customizer', {
        render: function () {
            var meta     = useSelect( function ( select ) { return select( 'core/editor' ).getEditedPostAttribute( 'meta' ); } );
            var editPost = useDispatch( 'core/editor' ).editPost;
            var length   = meta && meta['_exc_length'] ? String( meta['_exc_length'] ) : '';
            var more     = meta && meta['_exc_more']   ? meta['_exc_more'] : '';

            function setMeta( key, value ) {
                var updated = {};
                updated[key] = value;
                editPost( { meta: updated } );
            }

            return createElement( wp.element.Fragment, null,
                createElement( PluginSidebarMoreMenuItem, { target: 'excerpt-customizer-sidebar' }, __( 'Excerpt Customizer', 'excerpt-customizer' ) ),
                createElement( PluginSidebar, { name: 'excerpt-customizer-sidebar', title: __( 'Excerpt Customizer', 'excerpt-customizer' ) },
                    createElement( PanelBody, { initialOpen: true },
                        createElement( TextControl, {
                            label: __( 'Word count (leave blank for default)', 'excerpt-customizer' ),
                            type: 'number',
                            value: length,
                            min: 1, max: 500,
                            onChange: function ( v ) { setMeta( '_exc_length', v ? parseInt( v, 10 ) : 0 ); },
                        } ),
                        createElement( TextControl, {
                            label: __( '"Read more" text', 'excerpt-customizer' ),
                            value: more,
                            placeholder: __( 'e.g. Continue reading…', 'excerpt-customizer' ),
                            onChange: function ( v ) { setMeta( '_exc_more', v ); },
                        } )
                    )
                )
            );
        },
    } );
} )( window.wp );
