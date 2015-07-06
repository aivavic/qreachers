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

        if (data.share_buttons) {
            data = getShareButtons(data);
        }

        if (data.published_at) {
            getControllerData(data);
        }
        else {
            loadTemplate(data);
        }
    }

    function getControllerData(data) {
        var params = {
            fields: 'id, published_at',
            limit: 1,
            where: {
                slug: app.router.slug,             
                locale: app.config.frontend_app_locale            
            }

        };

        $.getJSON(
                app.config.frontend_app_api_url + '/db/' + app.router.controller + 's',
                params,
                function (controllerData) {
                    if (undefined != controllerData.items[0].published_at) {
                        var timestamp = controllerData.items[0].published_at;
                        var date = new Date(timestamp * 1000);

                        data.published_at = date.toLocaleDateString();
                    }

                    loadTemplate(data);
                });
    }


    function loadTemplate(data) {
        app.logger.func('loadTemplate(data)');
        var params = '';
        if (true == app.config.frontend_app_debug) {
            params = '?_' + Date.now();
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

    function getShareButtons(data) {
        data.facebookHref = 'https://www.facebook.com/dialog/share';        
        data.twitterHref = 'https://twitter.com/intent/tweet?url=' + urlencode(location.href) + '&text=' + urlencode(document.title);

        return data;
    }

})();

