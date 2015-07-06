window.app.templateLoader = (function () {
    public = {
        getTemplateAjax: function (path, callback) {
            var source;
            var template;
            $.ajax({
                url: path,                
                success: function (data) {
                    source = data;
                    template = Handlebars.compile(source);
                    //execute the callback if passed
                    if (callback) {
                        callback(template);
                    }
                    else {
                        return template;
                    }
                        
                }
            });
        }
    }
    
    return public;

})();