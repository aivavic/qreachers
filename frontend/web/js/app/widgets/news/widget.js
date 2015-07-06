(function () {
    /*** process   ***/
    //run()->loadData()->loadTemplate(data)->renderWidget(html);

    var widget = app.view.getCurrentWidget();
    app.view.beforeWidget(widget);

    run();

    function run() {
        app.logger.func('run');

        //set default values
        sessionStorage.setItem('page.view.news.news.filter.page', 1);

        loadData();
    }

    function loadData() {
        app.logger.func('loadData()');

        data = widget;

        //load categories
        $.getJSON(
                app.config.frontend_app_api_url + '/db/article-categories',
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

        app.container.html(html);

        setTimeout(function () {
            changeFilterButtonsState();
            //bind ajax load to links                                 
            app.bindContainerAjaxLinks(app.config.frontend_app_conainer);

            //bindCategoryClickEvent(app.config.frontend_app_conainer);
            bindShowMoreScrollEvent();
        }, 500);

        loadArticles(data);

        app.view.afterWidget(widget);
    }

    function changeFilterButtonsState() {

        var cid = sessionStorage.getItem('articles.index.filter.category_id');

        if (cid) {
            app.logger.text('changeFilterButtonsState, cid: ' + cid);
            $('.filter-btn').trigger('click');
            var arr = cid.split(',');
            $('.filter-box').find('.article-category-item').each(function (k, v) {
                if (-1 != arr.indexOf($(v).attr('categoryid'))) {
                    $(v).addClass('active');
                }
            });
        }
    }

    function bindCategoryClickEvent(selector) {
        app.logger.func('bindCategoryClickEvent(' + selector + ')');

        $(selector).find('.article-category-item').off('click');
        $(selector).find('.article-category-item').click(function () {
            app.logger.text($(this).attr('article-id'));

            var cid = $(this).attr('categoryId');
            var currentCid = sessionStorage.getItem('articles.index.filter.category_id');

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');

                if (currentCid) {
                    cid = unsetStringElement(currentCid, cid);
                }
            }
            else {
                $(this).addClass('active');

                if (currentCid) {
                    cid = currentCid + ',' + cid;
                }
            }

            sessionStorage.setItem('articles.index.filter.category_id', cid);

            loadArticles();
        });

        $('#resetCategories').click(function () {
            $(this).toggleClass('active');

            sessionStorage.removeItem('articles.index.filter.category_id');
            sessionStorage.setItem('page.view.news.news.filter.page', 1);

            loadArticles();
        });


    }

    function loadArticles() {
        var sort = data.order_by;
        if ("desc" == data.sort_order)
            sort = "-" + sort;

        var params = {
            "fields": 'id,category_id,slug,thumbnail_base_url,thumbnail_path,title',
            "per-page": data.count,
            "expand": 'categories',
            "sort": sort
        };

        var cid = sessionStorage.getItem('articles.index.filter.category_id');
         
         if (cid) {
         params.category_id = cid;
         }

        var page = sessionStorage.getItem('page.view.news.news.filter.page');

        if (page) {
            params.page = page;
        }

        $.getJSON(
                app.config.frontend_app_api_url + '/db/articles',
                params,
                function (artData) {

                    $.each(artData.items, function (key, val) {
                        artData.items[key].previewImg = val.thumbnail_base_url + '/' + val.thumbnail_path;
                        artData.items[key].viewUrl = app.view.helper.preffix + '/article/view/' + val.slug;
                        artData.items[key].dataFilterCategories = getDataFilterCategories(val.categories);
                    });

                    data.items = artData.items;

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
        app.logger.func('loadTemplate(data)');
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

        $(".news-container .news-wrap").remove();
        $(".news-container").prepend(html);

        setTimeout(function () {
            app.bindContainerAjaxLinks(app.config.frontend_app_conainer);
        }, 500);

    }

    function bindShowMoreScrollEvent() {
        $(".projects .show-more").click(function () {
            var page = sessionStorage.getItem('page.view.news.news.filter.page');

            if (page) {
                sessionStorage.setItem('page.view.news.news.filter.page', page + 1);
            }

            loadArticles();
        });
    }

    function getDataFilterCategories(categories) {
        var result = '';
        $.each(categories, function (k, v) {
            result = result + ' data-filter-' + v.category_id;
        });

        return result;
    }



})();

