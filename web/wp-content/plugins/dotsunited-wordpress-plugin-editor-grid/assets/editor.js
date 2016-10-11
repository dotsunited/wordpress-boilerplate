(function($) {
    function isEmpty(el) {
        el = $(el);
        return !el.text() && !el.children().not('br').length;
    }

    function editor_grid_create() {
        var selectedContent = tinyMCE.activeEditor.selection.getContent();
        var children = $('<div>' + selectedContent + '</div>').children('p');
        var contents = [];
        var transColumn = tinyMCE.i18n.translate('Column %num%');

        var units = [6, 6];
        var numChildren = children.length;

        if (!numChildren) {
            contents.push(selectedContent);
        } else {
            contents = children.toArray();

            if (numChildren > 2) {
                switch (numChildren) {
                    case 3:
                        units = [4, 4, 4];
                        break;
                    case 4:
                        units = [3, 3, 3, 3];
                        break;
                    case 5:
                        units = [3, 3, 2, 2, 2];
                        break;
                    case 6:
                        units = [2, 2, 2, 2, 2, 2];
                        break;
                    case 7:
                        units = [2, 2, 2, 2, 2, 1, 1];
                        break;
                    case 8:
                        units = [2, 2, 2, 2, 1, 1, 1, 1];
                        break;
                    case 9:
                        units = [2, 2, 2, 1, 1, 1, 1, 1, 1];
                        break;
                    case 10:
                        units = [2, 2, 1, 1, 1, 1, 1, 1, 1, 1];
                        break;
                    case 11:
                        units = [2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
                        break;
                    default:
                        units = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
                        break;
                }
            }
        }

        // Insert
        var content, insert = $('<div class="editor-grid-container"/>');

        for (var i = 0, l = units.length - 1; i < l; i++) {
            content = '';

            if (!!contents.length) {
                content = contents[0];
                contents = contents.slice(1);
            }

            if (!content) {
                content = '<p>' + transColumn.replace('%num%', i + 1) + '</p>';
            }

            insert.append($('<div class="editor-grid-unit editor-grid-unit-' + units[i] + '"/>').append(content));
        }

        content = '<p>' + transColumn.replace('%num%', i + 1) + '</p>';

        if (!!contents.length) {
            content = contents;
        }

        // Add last unit
        insert.append($('<div class="editor-grid-unit editor-grid-unit-' + units[i] + '"/>').append(content));

        insert = insert.wrap('<div class="editor-grid"/>').parent();

        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, insert.wrap('<div/>').parent().html());
    }

    tinymce.PluginManager.add('editor_grid', function(editor) {
        var toolbar;

        function editor_grid_style_button(selector) {
            return {
                type: 'listbox',
                text: 'Style',
                classes: 'btn widget fixed-width',
                icon: false,
                onselect: function(e) {},
                values: [
                    {
                        text: 'No background',
                        onclick : function() {
                            $(editor.selection.getNode())
                                .closest(selector)
                                .removeClass('editor-grid-background editor-grid-background-highlight')
                            ;
                        },
                        value: ''
                    },
                    {
                        text: 'Background',
                        onclick : function() {
                            $(editor.selection.getNode())
                                .closest(selector)
                                .removeClass('editor-grid-background-highlight')
                                .addClass('editor-grid-background')
                            ;
                        },
                        value: 'background'
                    },
                    {
                        text: 'Highlight',
                        onclick : function() {
                            $(editor.selection.getNode())
                                .closest(selector)
                                .removeClass('editor-grid-background editor-grid-background-highlight')
                                .removeClass('editor-grid-background')
                                .addClass('editor-grid-background-highlight')
                            ;
                        },
                        value: 'background-highlight'
                    }
                ],
                onPostRender: function() {
                    var self = this;

                    editor.on('NodeChange', function(event) {
                        var el = $(event.element).closest(selector);

                        if (!el.length) {
                            return;
                        }

                        var value = '';

                        if (el.hasClass('editor-grid-background-highlight')) {
                            value = 'background-highlight';
                        } else if (el.hasClass('editor-grid-background')) {
                            value = 'background';
                        }

                        self.value(value);
                    });
                }
            };
        }

        function editor_grid_shadow_button(selector) {
            return {
                tooltip: 'Shadow',
                icon: 'editor-grid-icon editor-grid-icon-shadow',
                onclick: function() {
                    var el = $(editor.selection.getNode()).closest(selector);

                    if (!el.length) {
                        return;
                    }

                    el.toggleClass('editor-grid-shadow');
                    this.active(el.hasClass('editor-grid-shadow'));
                },
                onPostRender: function() {
                    var self = this;

                    editor.on('NodeChange', function(event) {
                        var el = $(event.element).closest(selector);

                        if (!el.length) {
                            return;
                        }

                        self.active(el.hasClass('editor-grid-shadow'));
                    });
                }
            };
        }

        function editor_grid_size_button(selector, sizes) {
            var values = [];
            var transSize = tinyMCE.i18n.translate('%size% of %sizes%');
            var allClasses = [];

            for (var i = 1; i <= sizes; i++) {
                allClasses.push('editor-grid-unit-' + i);

                values.push({
                    text: transSize.replace('%size%', i).replace('%sizes%', sizes),
                    onclick: (function(i) {
                        return function() {
                            $(editor.selection.getNode())
                                .closest(selector)
                                .removeClass(allClasses.join(' '))
                                .addClass('editor-grid-unit-' + i)
                            ;
                        }
                    })(i),
                    value: 'editor-grid-unit-' + i
                });
            }

            return {
                type: 'listbox',
                text: 'Column size',
                classes: 'btn widget fixed-width',
                icon: false,
                onselect: function(e) {},
                values: values,
                onPostRender: function() {
                    var self = this;

                    editor.on('NodeChange', function(event) {
                        var el = $(event.element).closest(selector);

                        if (!el.length) {
                            return;
                        }

                        var value = '';

                        for (var i = 0, l = allClasses.length; i < l; i++) {
                            if (el.hasClass(allClasses[i])) {
                                value = allClasses[i];
                                break;
                            }
                        }

                        self.value(value);
                    });
                }
            };
        }

        editor.addButton('editor_grid_unit_size', editor_grid_size_button('.editor-grid-unit', 12));

        editor.addButton('editor_grid_unit_style', editor_grid_style_button('.editor-grid-unit'));
        editor.addButton('editor_grid_unit_shadow', editor_grid_shadow_button('.editor-grid-unit'));

        editor.addButton('editor_grid_unit_remove', {
            tooltip: 'Remove column',
            icon: 'dashicon dashicons-no',
            onclick: function() {
                var el = $(editor.selection.getNode()).closest('.editor-grid-unit');

                if (!el.length) {
                    return;
                }

                var grid = el.closest('.editor-grid');

                el.remove();

                if (!grid.find('.editor-grid-unit').length) {
                    grid.remove();
                }

                toolbar.hide();
            }
        });

        editor.addButton('editor_grid_remove', {
            tooltip: 'Remove grid',
            icon: 'dashicon dashicons-no',
            onclick: function() {
                var el = $(editor.selection.getNode()).closest('.editor-grid');

                if (!el.length) {
                    return;
                }

                el.find('.editor-grid-unit').each(function() {
                    if (isEmpty(this)) {
                        return;
                    }

                    el.before($(this).html());
                });

                el.remove();
                toolbar.hide();
            }
        });

        editor.addButton('editor_grid_add_unit', {
            tooltip: 'Add column',
            icon: 'dashicon dashicons-plus',
            onclick: function() {
                var el = $(editor.selection.getNode()).closest('.editor-grid-unit');

                if (!el.length) {
                    return;
                }

                var container = el.closest('.editor-grid-container');
                var transColumn = tinyMCE.i18n.translate('Column %num%');
                var content = '<p>' + transColumn.replace('%num%', container.find('.editor-grid-unit').length + 1) + '</p>';

                container.append(el.clone().html(content));
            }
        });

        editor.addButton('editor_grid_style', editor_grid_style_button('.editor-grid'));

        editor.addButton('editor_grid_shadow', editor_grid_shadow_button('.editor-grid'));

        editor.addButton('editor_grid_equal_height', {
            tooltip: 'Equalize column heights',
            icon: 'editor-grid-icon editor-grid-icon-equalize-height',
            onclick: function() {
                var el = $(editor.selection.getNode()).closest('.editor-grid');

                if (!el.length) {
                    return;
                }

                el.toggleClass('editor-grid-equal-height');
                this.active(el.hasClass('editor-grid-equal-height'));
            },
            onPostRender: function() {
                var self = this;

                editor.on('NodeChange', function(event) {
                    var el = $(event.element).closest('.editor-grid');

                    if (!el.length) {
                        return;
                    }

                    self.active(el.hasClass('editor-grid-equal-height'));
                });
            }
        });

        editor.addButton('editor_grid_create', {
            title: 'Create grid',
            icon: 'editor-grid-icon editor-grid-icon-create',
            onclick: function() {
                editor_grid_create([6, 6]);
            },
            onPostRender: function() {
                var ctrl = this, selector = '.editor-grid';

                function bindStateListener() {
                    ctrl.disabled(
                        !!editor.dom.getParent(
                            editor.selection.getStart(),
                            selector
                        )
                    );

                    editor.selection.selectorChanged(selector, function(state) {
                        ctrl.disabled(!!state);
                    });
                }

                if (editor.initialized) {
                    bindStateListener();
                } else {
                    editor.on('init', bindStateListener);
                }
            }
        });

        // Add toolbar
        editor.once('preinit', function() {
            toolbar = editor.wp._createToolbar([
                'editor_grid_unit_size',
                'editor_grid_unit_style',
                'editor_grid_unit_shadow',
                'editor_grid_unit_remove',
                '|',
                'editor_grid_add_unit',
                '|',
                'editor_grid_style',
                'editor_grid_shadow',
                'editor_grid_equal_height',
                'editor_grid_remove'
            ], true);
        });

        editor.on('wptoolbar', function(e) {
            var el = e.element, parent;

            while (el.getAttribute('data-mce-bogus')) {
                el = el.parentNode;
            }

            parent = el;

            if (!editor.dom.hasClass(parent, 'editor-grid-unit')) {
                parent = parent.parentNode;
            }

            if (editor.dom.hasClass(parent, 'editor-grid-unit')) {
                e.toolbar = toolbar;
                //e.selection = editor.dom.getParent(parent, '.editor-grid');
                e.selection = parent;
            }
        });

        // When pressing ENTER inside a unit, move the cursor to a new parapraph
        // under it but only if its the last child.
        editor.on('KeyDown', function(event) {
            var node, wrap, P, spacer,
                selection = editor.selection,
                keyCode = event.keyCode,
                dom = editor.dom,
                VK = tinymce.util.VK;

            // When pressing Enter inside a unit move the caret to a new
            // paragraph under it
            if (keyCode === VK.ENTER) {
                node = selection.getNode();

                if (!editor.dom.hasClass(node, 'editor-grid-unit') && !isEmpty(node)) {
                    return;
                }

                dom.events.cancel(event); // Doesn't cancel all :(

                spacer = tinymce.Env.ie && tinymce.Env.ie < 11 ? '' : '<br data-mce-bogus="1" />';
                P = dom.create('p', null, spacer);

                dom.add(node, P);

                editor.nodeChanged();
                selection.setCursorLocation(P, 0);
                return;
            }

            // Prevent removing box with Backspace and Delete
            if (keyCode === VK.BACKSPACE || keyCode === VK.DELETE) {
                node = selection.getNode();

                wrap = dom.getParent(node, '.editor-grid-unit');

                if (wrap && (!wrap.children.length || (1 === wrap.children.length && isEmpty(wrap.children[0])))) {
                    dom.events.cancel(event);
                    return false;
                }
            }
        });

        editor.on('NodeChange', function(event) {
            var el = $(event.element).closest('.editor-grid');

            if (!el.find('.editor-grid-unit').length) {
                el.remove();
            }
        });

        // Allow to place the caret behind a box.
        // This fix will force a paragraph element after the table but only when
        // the forced_root_block setting is enabled.
        // Copied from TinyMCE tabel plugin.
        editor.on('KeyDown SetContent VisualAid', function() {
            var last;

            // Skip empty text nodes from the end
            for (last = editor.getBody().lastChild; last; last = last.previousSibling) {
                if (last.nodeType == 3) {
                    if (last.nodeValue.length > 0) {
                        break;
                    }
                } else if (last.nodeType == 1 && (last.tagName == 'BR' || !last.getAttribute('data-mce-bogus'))) {
                    break;
                }
            }

            if (last && last.nodeName == 'DIV') {
                if (editor.settings.forced_root_block) {
                    editor.dom.add(
                        editor.getBody(),
                        editor.settings.forced_root_block,
                        editor.settings.forced_root_block_attrs,
                        tinymce.Env.ie && tinymce.Env.ie < 11 ? '&nbsp;' : '<br data-mce-bogus="1" />'
                    );
                } else {
                    editor.dom.add(editor.getBody(), 'br', {'data-mce-bogus': '1'});
                }
            }
        });

        editor.on('PreProcess', function(o) {
            var last = o.node.lastChild;

            if (last && (last.nodeName == 'BR' || (last.childNodes.length == 1 &&
                (last.firstChild.nodeName == 'BR' || last.firstChild.nodeValue == '\u00a0'))) &&
                last.previousSibling && last.previousSibling.nodeName == 'DIV') {
                editor.dom.remove(last);
            }
        });
    });
})(jQuery);
