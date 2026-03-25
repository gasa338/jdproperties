(function() {
    // Font Size dugme
    tinymce.PluginManager.add('koritim_fontsize', function(editor, url) {
        editor.addButton('koritim_fontsize', {
            type: 'menubutton',
            text: 'Font Size',
            icon: 'fontselect',
            tooltip: 'Izaberite veličinu fonta',
            menu: [
                {
                    text: 'Small',
                    icon: 'arrow-down',
                    onclick: function() {
                        applyFontSize('text-sm');
                    }
                },
                {
                    text: 'Medium',
                    icon: 'arrow-left',
                    onclick: function() {
                        applyFontSize('text-lg');
                    }
                },
                {
                    text: 'Large',
                    icon: 'arrow-up',
                    onclick: function() {
                        applyFontSize('text-xl');
                    }
                },
                {
                    text: 'Extra Large',
                    icon: 'arrow-up',
                    onclick: function() {
                        applyFontSize('text-2xl');
                    }
                }
            ]
        });
    });

    // Color dugme
    tinymce.PluginManager.add('koritim_color', function(editor, url) {
        editor.addButton('koritim_color', {
            type: 'menubutton',
            text: 'Color',
            icon: 'backcolor',
            tooltip: 'Izaberite boju teksta',
            menu: [
                {
                    text: 'Crvena',
                    icon: 'bullet',
                    style: 'color: #ff0000',
                    onclick: function() {
                        applyColor('color-red');
                    }
                },
                {
                    text: 'Plava',
                    icon: 'bullet',
                    style: 'color: #0000ff',
                    onclick: function() {
                        applyColor('color-blue');
                    }
                },
                {
                    text: 'Zelena',
                    icon: 'bullet',
                    style: 'color: #00ff00',
                    onclick: function() {
                        applyColor('color-green');
                    }
                },
                {
                    text: 'Background',
                    icon: 'bullet',
                    style: 'color: #ffffff',
                    onclick: function() {
                        applyColor('text-background');
                    }
                },
                {
                    text: 'Foreground',
                    icon: 'bullet',
                    style: 'color: #000000',
                    onclick: function() {
                        applyColor('text-foreground');
                    }
                },
                {
                    text: 'Primary',
                    icon: 'bullet',
                    style: 'color: #000000',
                    onclick: function() {
                        applyColor('text-primary');
                    }
                },
                {
                    text: 'Secondary',
                    icon: 'bullet',
                    style: 'color: #000000',
                    onclick: function() {
                        applyColor('text-secondary');
                    }
                },
                {
                    text: 'Muted',
                    icon: 'bullet',
                    style: 'color: #000000',
                    onclick: function() {
                        applyColor('text-muted');
                    }
                },
                {
                    text: 'Accent',
                    icon: 'bullet',
                    style: 'color: #000000',
                    onclick: function() {
                        applyColor('text-accent');
                    }
                }
            ]
        });
    });

    // Helper funkcija za primenu font size
    function applyFontSize(className) {
        var editor = tinyMCE.activeEditor;
        var selectedNode = editor.selection.getNode();
        
        // Pronalazimo odgovarajući P tag
        var targetNode = null;
        if (selectedNode.nodeName === 'P') {
            targetNode = selectedNode;
        } else {
            targetNode = editor.dom.getParent(selectedNode, 'p');
        }
        
        if (targetNode) {
            // Uklanjamo postojeće font size klase
            editor.dom.removeClass(targetNode, 'font-small font-medium font-large');
            // Dodajemo novu klasu
            editor.dom.addClass(targetNode, className);
            
            // Označavamo promenu
            editor.nodeChanged();
        }
    }

    // Helper funkcija za primenu boje
    function applyColor(className) {
        var editor = tinyMCE.activeEditor;
        var selectedNode = editor.selection.getNode();
        
        // Pronalazimo odgovarajući P tag
        var targetNode = null;
        if (selectedNode.nodeName === 'P') {
            targetNode = selectedNode;
        } else {
            targetNode = editor.dom.getParent(selectedNode, 'p');
        }
        
        if (targetNode) {
            // Uklanjamo postojeće color klase
            editor.dom.removeClass(targetNode, 'color-red color-blue color-green');
            // Dodajemo novu klasu
            editor.dom.addClass(targetNode, className);
            
            // Označavamo promenu
            editor.nodeChanged();
        }
    }

    // Dodavanje keyboard shortcut-a
    tinymce.PluginManager.add('koritim_shortcuts', function(editor) {
        editor.addShortcut('Ctrl+Shift+F', 'Font size', function() {
            editor.execCommand('koritim_fontsize');
        });
        
        editor.addShortcut('Ctrl+Shift+C', 'Color', function() {
            editor.execCommand('koritim_color');
        });
    });
})();