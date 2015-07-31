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

        getSlugCategories();
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

        app.bindContainerAjaxLinks(app.config.frontend_app_conainer);
        registerCategoryClick(app.router.controller);

        app.view.afterWidget(widget);
    }

    function registerCategoryClick(controller) {
        app.logger.func('registerCategoryClick');

        $(".widget-filter").find('a').click(function () {
            app.logger.text('click categoty: ' + $(this).attr("categotyId"));
            sessionStorage.setItem(controller + 's.index.filter.category_id', $(this).attr("categotyId"));
        });

        //bind ajax load to links                                 



    }

    function getSlugCategories() {
        var params = {
            "fields": 'category_id',
            "expand": 'categories',
            "limit": 1,
            where: {
                slug: app.router.slug,             
                locale: app.config.frontend_app_locale            
            }

        };

        $.getJSON(
                app.config.frontend_app_api_url + '/db/' + app.router.controller + 's',
                params,
                function (controllerData) {
                    var options = {
                        where: {
                            id: getCatgoriesFromControllerData(controllerData.items[0].categories)                            
                        }
                        
                    };

                    loadFilteredData(options);
                });
    }

    function loadFilteredData(options) {
        var params = options;

        //load categories
        $.getJSON(
                app.config.frontend_app_api_url + '/db/' + app.router.controller + '-categories',
                params,
                function (data) {

                    $.each(data.items, function (key, val) {

                        switch (app.router.controller) {
                            case 'article':
                                data.items[key].url = app.view.helper.preffix + '/news';
                                break;
                            case 'project':
                                data.items[key].url = app.view.helper.preffix + '/portfolio';
                                break;
                        }
                    });

                    loadTemplate(data);
                });
    }

    function getCatgoriesFromControllerData(categories) {
        var arr = [];
        $.each(categories, function (k, v) {
            arr.push(v.category_id);
        });

        return arr;
    }
})();

