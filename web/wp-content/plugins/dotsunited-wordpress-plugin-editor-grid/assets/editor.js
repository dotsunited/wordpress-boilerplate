(function($) {
    function isEmpty(el) {
        el = $(el);
        return !el.text() && !el.children().not('br').length;
    }

    function grid_create() {
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
        var content, insert = $('<div class="grid-container"/>');

        for (var i = 0, l = units.length - 1; i < l; i++) {
            content = '';

            if (!!contents.length) {
                content = contents[0];
                contents = contents.slice(1);
            }

            if (!content) {
                content = '<p>' + transColumn.replace('%num%', i + 1) + '</p>';
            }

            insert.append($('<div class="grid-unit grid-unit-' + units[i] + '"/>').append(content));
        }

        content = '<p>' + transColumn.replace('%num%', i + 1) + '</p>';

        if (!!contents.length) {
            content = contents;
        }

        // Add last unit
        insert.append($('<div class="grid-unit grid-unit-' + units[i] + '"/>').append(content));

        insert = insert.wrap('<div class="grid"/>').parent();

        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, insert.wrap('<div/>').parent().html());
    }

    tinymce.PluginManager.add('grid', function(editor) {
        var toolbar;

        function grid_style_button(selector) {
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
                                .removeClass('grid-background grid-background-highlight')
                            ;
                        },
                        value: ''
                    },
                    {
                        text: 'Background',
                        onclick : function() {
                            $(editor.selection.getNode())
                                .closest(selector)
                                .removeClass('grid-background-highlight')
                                .addClass('grid-background')
                            ;
                        },
                        value: 'background'
                    },
                    {
                        text: 'Highlight',
                        onclick : function() {
                            $(editor.selection.getNode())
                                .closest(selector)
                                .removeClass('grid-background grid-background-highlight')
                                .removeClass('grid-background')
                                .addClass('grid-background-highlight')
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

                        if (el.hasClass('grid-background-highlight')) {
                            value = 'background-highlight';
                        } else if (el.hasClass('grid-background')) {
                            value = 'background';
                        }

                        self.value(value);
                    });
                }
            };
        }

        function grid_shadow_button(selector) {
            return {
                tooltip: 'Shadow',
                icon: 'grid-icon grid-icon-shadow',
                onclick: function() {
                    var el = $(editor.selection.getNode()).closest(selector);

                    if (!el.length) {
                        return;
                    }

                    el.toggleClass('grid-shadow');
                    this.active(el.hasClass('grid-shadow'));
                },
                onPostRender: function() {
                    var self = this;

                    editor.on('NodeChange', function(event) {
                        var el = $(event.element).closest(selector);

                        if (!el.length) {
                            return;
                        }

                        self.active(el.hasClass('grid-shadow'));
                    });
                }
            };
        }

        function grid_size_button(selector, sizes) {
            var values = [];
            var transSize = tinyMCE.i18n.translate('%size% of %sizes%');
            var allClasses = [];

            for (var i = 1; i <= sizes; i++) {
                allClasses.push('grid-unit-' + i);

                values.push({
                    text: transSize.replace('%size%', i).replace('%sizes%', sizes),
                    onclick: (function(i) {
                        return function() {
                            $(editor.selection.getNode())
                                .closest(selector)
                                .removeClass(allClasses.join(' '))
                                .addClass('grid-unit-' + i)
                            ;
                        }
                    })(i),
                    value: 'grid-unit-' + i
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

        editor.addButton('grid_unit_size', grid_size_button('.grid-unit', 12));

        editor.addButton('grid_unit_style', grid_style_button('.grid-unit'));
        editor.addButton('grid_unit_shadow', grid_shadow_button('.grid-unit'));

        editor.addButton('grid_unit_remove', {
            tooltip: 'Remove column',
            icon: 'dashicon dashicons-no',
            onclick: function() {
                var el = $(editor.selection.getNode()).closest('.grid-unit');

                if (!el.length) {
                    return;
                }

                var grid = el.closest('.grid');

                el.remove();

                if (!grid.find('.grid-unit').length) {
                    grid.remove();
                }

                toolbar.hide();
            }
        });

        editor.addButton('grid_remove', {
            tooltip: 'Remove grid',
            icon: 'dashicon dashicons-no',
            onclick: function() {
                var el = $(editor.selection.getNode()).closest('.grid');

                if (!el.length) {
                    return;
                }

                el.find('.grid-unit').each(function() {
                    if (isEmpty(this)) {
                        return;
                    }

                    el.before($(this).html());
                });

                el.remove();
                toolbar.hide();
            }
        });

        editor.addButton('grid_add_unit', {
            tooltip: 'Add column',
            icon: 'dashicon dashicons-plus',
            onclick: function() {
                var el = $(editor.selection.getNode()).closest('.grid-unit');

                if (!el.length) {
                    return;
                }

                var container = el.closest('.grid-container');
                var transColumn = tinyMCE.i18n.translate('Column %num%');
                var content = '<p>' + transColumn.replace('%num%', container.find('.grid-unit').length + 1) + '</p>';

                container.append(el.clone().html(content));
            }
        });

        editor.addButton('grid_style', grid_style_button('.grid'));

        editor.addButton('grid_shadow', grid_shadow_button('.grid'));

        editor.addButton('grid_equal_height', {
            tooltip: 'Equalize column heights',
            icon: 'grid-icon grid-icon-equalize-height',
            onclick: function() {
                var el = $(editor.selection.getNode()).closest('.grid');

                if (!el.length) {
                    return;
                }

                el.toggleClass('grid-equal-height');
                this.active(el.hasClass('grid-equal-height'));
            },
            onPostRender: function() {
                var self = this;

                editor.on('NodeChange', function(event) {
                    var el = $(event.element).closest('.grid');

                    if (!el.length) {
                        return;
                    }

                    self.active(el.hasClass('grid-equal-height'));
                });
            }
        });

        editor.addButton('grid_create', {
            title: 'Create grid',
            icon: 'grid-icon grid-icon-create',
            onclick: function() {
                grid_create([6, 6]);
            }
        });

        // Add toolbar
        editor.once('preinit', function() {
            toolbar = editor.wp._createToolbar([
                'grid_unit_size',
                'grid_unit_style',
                'grid_unit_shadow',
                'grid_unit_remove',
                '|',
                'grid_add_unit',
                '|',
                'grid_style',
                'grid_shadow',
                'grid_equal_height',
                'grid_remove'
            ], true);
        });

        editor.on('wptoolbar', function(e) {
            var parent = e.element.parentNode;

            if (editor.dom.hasClass(parent, 'grid-unit')) {
                e.toolbar = toolbar;
                //e.selection = editor.dom.getParent(parent, '.grid');
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

                if (!editor.dom.hasClass(node, 'grid-unit') && !isEmpty(node)) {
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

                wrap = dom.getParent(node, '.grid-unit');

                if (wrap && (!wrap.children.length || (1 === wrap.children.length && isEmpty(wrap.children[0])))) {
                    dom.events.cancel(event);
                    return false;
                }
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
