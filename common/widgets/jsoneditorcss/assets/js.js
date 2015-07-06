function run(fieldId, jsonEncodeOptions) {

    var options = $.parseJSON(jsonEncodeOptions);
    var startval = $("#" + fieldId).val();
    if (undefined != startval && "" != startval && null != startval && "null" != startval) {
        options.startval = $.parseJSON(startval)
    }

    // Specify upload handler
    JSONEditor.defaults.options.upload = function (id, file, cbs) {

        var name = '_fileinput_' + id.replace(/\./g, '_');

        $('div[data-schemapath="' + id + '"]:visible').find('input[type="file"]').attr('id', id);
        $('div[data-schemapath="' + id + '"]:visible').find('input[type="file"]').attr('name', name);

        var data = new FormData();
        jQuery.each(jQuery('input[name="' + name + '"]')[0].files, function (i, file) {
            dump(file);
            data.append(name, file);
        });

        jQuery.ajax({
            url: '/file-storage/upload?fileparam=' + name,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                dump(data);
                cbs.success(data.files[0].url);
            }
        });

        //url: "http://16on9.storage.dev/source/1/tlVu5m8CyGcxuADyIJIsfjYsIQgtRqTe.jpg"
        //delete_url: "/file-storage/upload-delete?path=1%2FtlVu5m8CyGcxuADyIJIsfjYsIQgtRqTe.jpg"
        //delete not allowed  http://16on9.backend.dev/file-storage/upload-delete?path=1/tlVu5m8CyGcxuADyIJIsfjYsIQgtRqTe.jpg
    }

    var editor = new JSONEditor(document.getElementById(fieldId + "_holder"), options);
    if (undefined == window.jsoneditorcsseditors) {
        window.jsoneditorcsseditors = {}
    }

    window.jsoneditorcsseditors[fieldId] = editor;


    editor.on("change", function () {
        var editor = window.jsoneditorcsseditors[fieldId];
        $("#" + fieldId).val(JSON.stringify(editor.getValue()));
    });

    var editor = window.jsoneditorcsseditors[fieldId].getEditor("root");
    if (undefined != editor.rows)
        $.each(editor.rows, function (rowKey, row) {
            $.each(row.value, function (k, v) {
                if ($.isEmptyObject(v) || ('wselect' == k && v != '-')) {
                    var emptySelector = "div[data-schemapath=\"" + "root." + rowKey + "." + k + "\"]";
                    $(emptySelector).parent().hide();
                }
            })
        });

    var widgetEditor = window.jsoneditorcsseditors[fieldId].getEditor("root");
    if (undefined != widgetEditor) {
        $(widgetEditor.add_row_button).click(function () {
            var wblock = $(this).parent().parent();
            wblock.find("select[name*=\"wselect\"]").change(function () {
                var index = $(this).attr("name").match(/root\[(\d+)\]\[wselect\]/)[1];

                var selectedValue = $(this).val();
                var selectedAttrName = $(this).attr("name");
                var curretEditor = window.jsoneditorcsseditors[fieldId].getEditor("root." + index);

                $.each(curretEditor.defaultProperties, function (k, v) {
                    if (v == selectedValue) {
                        var selectedWidgetName = selectedAttrName.replace("wselect", selectedValue);
                        var selectedWidgetId = selectedWidgetName.replace(/\]\[/g, ".").replace(/\[/g, ".").replace(/\]/g, ".").replace(/\.$/, "");
                        var selector = "div[data-schemapath=\"" + selectedWidgetId + "\"]";
                        wblock.find(selector).addClass("col-md-12").show();

                    } else {
                        window.jsoneditorcsseditors[fieldId].getEditor("root." + index + "." + v).options.hidden = true;
                        var path = window.jsoneditorcsseditors[fieldId].getEditor("root." + index + "." + v).path;
                        var selector = "div[data-schemapath=\"" + path + "\"]";
                        wblock.find(selector).parent().hide();
                        if ('wselect' != v) {
                            window.jsoneditorcsseditors[fieldId].getEditor("root." + index + "." + v).setValue(null);
                        }
                        window.jsoneditorcsseditors[fieldId].getEditor("root." + index + "." + v).change();
                    }
                });

            });
        });
    }
}

run(fieldId, jsonEncodeOptions);