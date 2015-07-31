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
        var sort = data.order_by;
    
        if ("desc" == data.sort_order) sort = "-" + sort;         
        
        var params = {
            "fields": 'id,slug,title,description,thumbnail_base_url,thumbnail_path,description,video_base_url,video_path',
            "limit": data.count,        
            "sort": sort,
        };

        $.getJSON(
                app.config.frontend_app_api_url + '/db/clients',
                params,
                function (clientsData) {
                    $.extend(data, clientsData);

                    $.each(data.items, function (key, val) {
                        data.items[key].previewImg = val.thumbnail_base_url + '/' + val.thumbnail_path;
                        //data.items[key].viewUrl = app.view.helper.preffix + '/client/' + val.slug;
                        //data.items[key].description = val.description;
                        //data.items[key].previewVideo = val.video_base_url + '/' + val.video_path;
                    });

                    //data.urlToPortfolio = app.view.helper.preffix + '/client/index';

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

