(function () {
    /*** process   ***/
    //run()->loadData()->loadTemplate(data)->renderWidget(html);

    var widget = app.view.getCurrentWidget();
    app.view.beforeWidget(widget);

    run();

    function run() {
        app.logger.func('run');

        //set default values
        sessionStorage.setItem('page.view.portfolio.portfolio.filter.page', 1);

        loadData();
    }

    function loadData() {
        app.logger.func('loadData()');

        data = widget;

        //load categories
        $.getJSON(
                app.config.frontend_app_api_url + '/db/project-categories',
                function (catData) {
                    data.categories = catData.items;
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
            renderWidget(template(data), data);
        });
    }

    function renderWidget(html, data) {
        app.logger.func('renderWidget(html)');

        app.container.append(html);

        setTimeout(function () {
            changeFilterButtonsState();
            //bind ajax load to links                                 
            app.bindContainerAjaxLinks(app.config.frontend_app_conainer);

            //bindCategoryClickEvent(app.config.frontend_app_conainer);
            //bindShowMoreClickEvent();
        }, 500);

        loadProjects(data);

        app.view.afterWidget(widget);
    }

    function changeFilterButtonsState() {

        var cid = sessionStorage.getItem('projects.index.filter.category_id');

        if (cid) {
            app.logger.text('changeFilterButtonsState, cid: ' + cid);
            $('.filter-btn').trigger('click');
            var arr = cid.split(',');
            $('.filter-box').find('.project-category-item').each(function (k, v) {
                if (-1 != arr.indexOf($(v).attr('categoryid'))) {
                    $(v).addClass('active');
                }
            });
        }
    }

    function loadProjects() {
        var sort = data.order_by;
        if ("desc" == data.sort_order)
            sort = "-" + sort;

        var params = {
            "fields": 'id,category_id,description,slug,thumbnail_base_url,thumbnail_path,title,video_base_url,video_path',
            "expand": 'categories',
            "per-page": data.count,
            "sort": sort,
            "where_operator_format": [
                "like",
                "domain",
                location.protocol + '//' + location.hostname,
            ]
        };

        var cid = sessionStorage.getItem('projects.index.filter.category_id');

        if (cid) {
            params.category_id = cid;
        }

        var page = sessionStorage.getItem('page.view.portfolio.portfolio.filter.page');

        if (page) {
            params.page = page;
            params.where = {
                locale: app.config.frontend_app_locale
            };
        }

        $.getJSON(
                app.config.frontend_app_api_url + '/db/projects',
                params,
                function (artData) {

                    $.each(artData.items, function (key, val) {
                        artData.items[key].previewImg = val.thumbnail_base_url + '/' + val.thumbnail_path;
                        artData.items[key].viewUrl = app.view.helper.preffix + '/project/view/' + val.slug;
                        artData.items[key].video = val.video_base_url + '/' + val.video_path;
                        artData.items[key].dataFilterCategories = getDataFilterCategories(val.categories);
                        artData.items[key].categoryTitles = getCategoryTitles(val.categories);

                    });

                    data.items = artData.items;
                    app.logger.var(data.items.length);
                    if(data.items.length > 6){
                        data.itemsCount = true;                        
                    }
                    loadTemplateItems(data);
                });
    }

    function unsetStringElement(old, id) {
        var arr = old.split(',');
        var index = arr.indexOf(id);
        if (-1 != index) {
            arr.splice(index, 1);
        }

        return arr.join(',');
    }

    function loadTemplateItems(data) {
        app.logger.func('loadTemplateItems(data)');
        var params = '';
        if (true == app.config.frontend_app_debug) {
            params = '?_' + Date.now();
        }
        app.templateLoader.getTemplateAjax(app.config.frontend_app_web_url + '/js/app/widgets/' + widget.widgetName + '/templates/_items.handlebars.html' + params, function (template) {
            renderWidgetItems(template(data));
        });
    }

    function renderWidgetItems(html) {
        app.logger.func('renderWidget(html)');

        $(".project-box").remove();
        $(".projects").prepend(html);

        setTimeout(function () {
            //bind ajax load to links      
            app.bindContainerAjaxLinks(app.config.frontend_app_conainer);
        }, 500);

        setTimeout(function () {
            $(window).trigger('page.view.portfolio.portfolio.renderWidgetItems');
        }, 2000);
    }

    function bindShowMoreClickEvent() {
        $("#portfolioShowMore").click(function () {
            var page = sessionStorage.getItem('page.view.portfolio.portfolio.filter.page');

            if (page) {
                sessionStorage.setItem('page.view.portfolio.portfolio.filter.page', parseInt(page) + 1);
            }

            loadProjects();
        });
    }

    function getDataFilterCategories(categories) {
        var result = '';
        $.each(categories, function (k, v) {
            result = result + ' data-filter-' + v.category_id;
        });

        return result;
    }

    function getCategoryTitles(categories) {
        var result = [];

        $.each(categories, function (k, v) {
            if (v.category_id) {
                result.push(v.category_id);
            }
        });

        //TODO: get category title from data.categories

        return result.join(',');
    }



})();

