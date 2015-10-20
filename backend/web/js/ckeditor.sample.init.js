
﻿/**
 * Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

        /* exported initSample */

        if (CKEDITOR.env.ie && CKEDITOR.env.version < 9)
    CKEDITOR.tools.enableHtml5Elements(document);

// The trick to keep the editor in the sample quite small
// unless user specified own height.
CKEDITOR.config.height = 150;
CKEDITOR.config.width = 'auto';

var initSample = (function (textareaId, jsonEditorFieldEditor) {
    var wysiwygareaAvailable = isWysiwygareaAvailable(),
            isBBCodeBuiltIn = !!CKEDITOR.plugins.get('bbcode');

    return function (textareaId, jsonEditorFieldEditor) {

        var editorElement = CKEDITOR.document.getById(textareaId);
        console.log('add CKEDITOR to ' + textareaId);
        //$('textarea[data-schemaformat="html"]')
        //<textarea class="form-control" data-schemaformat="html" name="root[0][text]" style="display: none;"></textarea>

        // :(((
        if (isBBCodeBuiltIn) {
            editorElement.setHtml(
                    'Hello world!\n\n' +
                    'I\'m an instance of [url=http://ckeditor.com]CKEditor[/url].'
                    );
        }

        // Depending on the wysiwygare plugin availability initialize classic or inline editor.
        if (wysiwygareaAvailable) {
            var editor = CKEDITOR.replace(textareaId);
            
            editor.on('change', function (evt) {
                // getData() returns CKEditor's HTML content.
                //console.log('Total bytes: ' + evt.editor.getData().length);                
                //$('#' + textareaId).val(evt.editor.getData());
                jsonEditorFieldEditor.setValue(evt.editor.getData());                
            });

        } else {
            editorElement.setAttribute('contenteditable', 'true');
            CKEDITOR.inline(textareaId);

            // TODO we can consider displaying some info box that
            // without wysiwygarea the classic editor may not work.
        }
    };

    function isWysiwygareaAvailable() {
        // If in development mode, then the wysiwygarea must be available.
        // Split REV into two strings so builder does not replace it :D.
        if (CKEDITOR.revision == ('%RE' + 'V%')) {
            return true;
        }

        return !!CKEDITOR.plugins.get('wysiwygarea');
    }
})();





