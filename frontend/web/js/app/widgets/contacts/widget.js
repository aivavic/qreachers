(function () {
    /*** process   ***/
    //run()->loadData()->loadTemplate(data)->renderWidget(html);
    
    var widget = app.view.getCurrentWidget();
    app.view.beforeWidget(widget);           

    run();

    function run() {
        app.logger.func('run');
        loadData();
    }

    function loadData() {
        app.logger.func('loadData()');

        var data = widget;

        var params = {
            "fields": 'id,slug,title,body',
            "where": {
                "slug": "footer",
                "locale": app.config.frontend_app_locale
            },
            "where_operator_format": [
                "like",
                "domain",
                location.protocol + '//' + location.hostname,
            ]
        };

        $.getJSON(
                app.config.frontend_app_api_url + '/db/blocks',
                params,
                function (data) {
                    var body = data.items[0].body.replace(/^\[/, '').replace(/\]$/, '');
                    data = JSON.parse(body);
                    data.t = app.view.getTranslationsFromData(data);

                loadTemplate(data);
         });
    }

    function loadTemplate(data) {
        app.logger.func('loadTemplate(data)');
        var params = '';
        if ( true == app.config.frontend_app_debug) {
            params = '?_'+ Date.now();
        }
        app.templateLoader.getTemplateAjax(app.config.frontend_app_web_url + '/js/app/widgets/' + widget.widgetName + '/templates/handlebars.html' + params, function (template) {
            renderWidget(template(data));
        });
    }

    function renderWidget(html) {
        app.logger.func('renderWidget(html)');
        app.container.append(html);

        app.view.afterWidget(widget);
    }
})();

