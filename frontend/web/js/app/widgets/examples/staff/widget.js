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
        var ids = [];
        
        $.each(data.members, function(k,v) {
            ids[k] = v.split('#')[1];
        });
        
        var params = {
            fields: 'id, thumbnail_base_url, thumbnail_path, firstname, lastname, position, video, video_mobile',            
            where : {
                id : ids
            }
        };

        $.getJSON(
                app.config.frontend_app_api_url + '/db/member',
                params,
                function (membersData) {
                    $.extend(data, membersData);

                    $.each(data.items, function (key, val) {
                        data.items[key].previewImg = val.thumbnail_base_url + '/' + val.thumbnail_path;                        
                    });

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

        //bind ajax load to links                                 
        app.bindContainerAjaxLinks("#main-client-list-container");

        app.view.afterWidget(widget);
    }

})();

