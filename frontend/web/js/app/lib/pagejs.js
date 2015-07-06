$(document).ready(function () {
    window.app.pagejs = (function () {
        public = {
            load: function (page) {
                var url;
                url = page.url.replace(/article\/view\/.+/g, "article/view");
                url = page.url.replace(/project\/view\/.+/g, "project/view");
                app.logger.func('pagejs.load ' + url)

                if (undefined != app.config.page_files[url]) {
                    $.each(app.config.page_files[url], function (k, v) {
                        app.logger.text('load ' + v);
                        $.getScript(v);
                    });
                }

            },
        };

        return public;
    })()
});



