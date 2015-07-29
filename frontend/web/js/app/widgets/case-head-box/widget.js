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
        if ("desc" == data.sort_order)
            sort = "-" + sort;

        var params = {
            "fields": 'id,slug,title,description,thumbnail_base_url,thumbnail_path,description,video_base_url,video_path',
            //"per-page": data.count,
            "expand": 'categories',
            //"sort" : sort,              
            "where": {
                locale: app.config.frontend_app_locale,
                slug: app.router.slug
            },
        };

        $.getJSON(
                app.config.frontend_app_api_url + '/db/projects',
                params,
                function (projectsData) {
                    $.extend(data, projectsData);
                    data.currentItem = {};
                    data.currentItem.title = data.items[0].title;
                    data.currentItem.video = data.items[0].video_base_url + '/' + data.items[0].video_path;
                    data.currentItem.category_id = (data.items[0].categories[0]) ? data.items[0].categories[0].id : '-';
                    data.urlToPortfolio = app.view.helper.preffix + '/page/view/portfolio';
                    data.category_title = getCategoryTitles(data.items[0].categories);
                    loadDataAll(data);
                });
    }


    function loadCategory(data) {
        app.logger.func('loadCategory()');

        var data = widget;

        var params = {
            "fields": 'id,title',
            "where": {
                'id': data.category_id
            }
        };

        $.getJSON(
                app.config.frontend_app_api_url + '/db/project-categories',
                params,
                function (catData) {
                    data.category_title = catData.items[0].title;
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

    function loadDataAll(data) {
        app.logger.func('loadDataAll()');

        var data = widget;

        var params = {
            "fields": 'id,slug,title,description,thumbnail_base_url,thumbnail_path,description,video_base_url,video_path',
            "sort": '-id',
            "where": {
                locale: app.config.frontend_app_locale,
            },
            "where_operator_format": [
                "like",
                "domain",
                location.protocol + '//' + location.hostname,
            ]
        };

        $.getJSON(
                app.config.frontend_app_api_url + '/db/projects',
                params,
                function (projectsData) {
                    $.each(projectsData.items, function (key, val) {
                        if (val.slug == app.router.slug) {
                            if (projectsData.items[key - 1]) {
                                data.prevUrl = app.view.helper.preffix + '/project/view/' + projectsData.items[key - 1].slug;
                            } else {
                                data.prevUrl = app.view.helper.preffix + '/project/view/' + projectsData.items[projectsData.items.length - 1].slug;
                            }
                            if (projectsData.items[key + 1]) {
                                data.nextUrl = app.view.helper.preffix + '/project/view/' + projectsData.items[key + 1].slug;
                            } else {
                                data.nextUrl = app.view.helper.preffix + '/project/view/' + projectsData.items[0].slug;
                            }
                        }

                    });
                    
                    //loadCategory(data);                    
                    loadTemplate(data);
                });
    }

    function renderWidget(html) {
        app.logger.func('renderWidget(html)');
        app.container.append(html);

        //bind ajax load to links                                 
        app.bindContainerAjaxLinks(".blog_post");

        app.view.afterWidget(widget);
    }

    function getCategoryTitles(categories) {
        var result = [];

        $.each(categories, function (k, v) {
            if (v.category_id) {
                result.push(app.view.projectCategories[v.category_id]);
            }
        });

        return result.join(' / ');
    }

})();

