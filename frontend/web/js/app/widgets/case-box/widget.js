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
            "fields": 'id,slug,title,description,thumbnail_base_url,thumbnail_path,description,video_base_url,video_path,domain',            
            /*"per-page": data.count,*/
            "sort" : sort,
            "where" :{
                locale: app.config.frontend_app_locale
            },
            "where_operator_format": [
                "not like",
                "slug",
                app.router.slug,
            ]
        };

        $.getJSON(
                app.config.frontend_app_api_url + '/db/projects',
                params,
                function (projectsData) {
                    $.extend(data, projectsData);
                    var currentDomain = location.protocol + '//' + location.hostname;  
                    var tmpItems = [];
                    var i = 0;
                    $.each(data.items, function (key, val) {
                        if (i != data.count) {
                            data.items[key].previewImg = val.thumbnail_base_url + '/' + val.thumbnail_path;
                            data.items[key].viewUrl = app.view.helper.preffix + '/project/view/' + val.slug;
                            data.items[key].description = val.description;
                            data.items[key].previewVideo = val.video_base_url + '/' + val.video_path;

                            if (val.domain.match(currentDomain)) {
                                tmpItems.push(data.items[key]);
                                i++;
                            }
                        }
                    });
                    data.items = tmpItems;
                    app.logger.var(data.items);
                    data.urlToPortfolio = app.view.helper.preffix + '/page/view/portfolio';

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

