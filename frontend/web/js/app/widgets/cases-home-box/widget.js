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
            "per-page": data.count,
            "expand": 'categories',
            "sort" : sort,              
            "where" :{
                locale: app.config.frontend_app_locale
            }           
        };

        $.getJSON(
                app.config.frontend_app_api_url + '/db/projects',
                params,
                function (projectsData) {
                    $.extend(data, projectsData);
                    var i = 0;
                    $.each(data.items, function (key, val) {
                        data.items[key].previewImg = val.thumbnail_base_url + '/' + val.thumbnail_path;
                        data.items[key].viewUrl = app.view.helper.preffix + '/project/view/' + val.slug;
                        data.items[key].description = val.description;
                        data.items[key].previewVideo = val.video_base_url + '/' + val.video_path;
                        data.items[key].category_id = (val.categories[0]) ? val.categories[0].id : '-';
                        if(i == 0){
                            data.items[key].rows = 'col-md-offset-1';    
                        } else if(i == 1) {
                            data.items[key].rows = 'hidden-sm hidden-xs';
                            return i = 0;
                        }
                        i++;
                    });

                    data.urlToPortfolio = app.view.helper.preffix + '/page/view/portfolio';
                    data.groups = items_array_chunk(data.items, 2);
                    app.logger.var(data.groups);
                    app.logger.var(data.items.length);
                    if(data.items.length > 2){
                        data.itemsCount = true;                        
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

        //bind ajax load to links                                 
        app.bindContainerAjaxLinks("#main-project-list-container");

        app.view.afterWidget(widget);
    }

})();

