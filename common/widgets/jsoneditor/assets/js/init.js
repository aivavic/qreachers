function setGlobalOptions(conf) {    
    JSONEditor.plugins.sceditor.style = '//cdn.jsdelivr.net/sceditor/1.4.3/jquery.sceditor.default.min.css';
    JSONEditor.plugins.sceditor.width = "754px";    
    JSONEditor.plugins.sceditor.toolbar = "source|maximize|bold,font,size|pastetext,bulletlist,orderedlist,removeformat|link|image";

    // Global Select2 options
    JSONEditor.plugins.select2.width = "100%";

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


    /*JSONEditor.defaults.resolvers.unshift(function (schema) {
        if (schema.type === "string" && schema.format === "yiiUploadKit") {
            log("yiiUploadKit");            
            //jQuery('#w1').yiiUploadKit({"name":"root[common][image][content]","url":"/file-storage/upload?fileparam=_fileinput_w1","multiple":false,"sortable":false,"maxNumberOfFiles":1,"maxFileSize":5000000,"acceptFileTypes":null,"files":null});

            return "string";
        }

        // If no valid editor is returned, the next resolver function will be used
    });*/
}

function log(msg) {
    if (conf.debug) {
        console.log('[jsoneditor] ' + msg);
    }
}

function dump(v) {
    if (conf.debug) {
        console.dir(v);
    }
}

function initialize(conf) {
    log('initialize ' + conf.fieldId);
    // This is the starting value for the editor
    // We will use this to seed the initial editor         
    if (!$.isEmptyObject($("#" + conf.fieldId).val())) {
        conf.options.startval = $.parseJSON($("#" + conf.fieldId).val());
    }

    setGlobalOptions(conf);

    // Initialize the editor
    var editor = new JSONEditor(document.getElementById(conf.fieldId + '_holder'), conf.options);

    editor.on('change', function () {
        $("#" + conf.fieldId).val(JSON.stringify(editor.getValue()));
    });


    log('conf :');
    dump(conf);
    log('editor :');
    dump(editor);
}

conf = $.parseJSON(conf);
dump(conf);

initialize(conf);


