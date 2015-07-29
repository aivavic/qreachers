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
        app.view.grid = null;

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
                    var cids = [];
                    $.each(data.categories, function (k, v) {
                        cids.push(v.id);
                    });
                    sessionStorage.setItem('articles.index.filter.category_id', cids.join(','));

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
            bindShowMoreClickEvent(data);
        }, 500);

        loadArticles(data);

        app.view.afterWidget(widget);
    }

    function changeFilterButtonsState() {

        /*var cid = sessionStorage.getItem('articles.index.filter.category_id');
         
         if (cid) {
         app.logger.text('changeFilterButtonsState, cid: ' + cid);
         $('.filter-btn').trigger('click');
         var arr = cid.split(',');
         $('.filter-box').find('.article-category-item').each(function (k, v) {
         if (-1 != arr.indexOf($(v).attr('categoryid'))) {
         $(v).addClass('active');
         }
         });
         }*/
    }

    function loadArticles(data) {
        var sort = data.order_by;
        if ("desc" == data.sort_order)
            sort = "-" + sort;

        var params = {
            "fields": 'id,category_id,slug,thumbnail_base_url,thumbnail_path,title',
            "per-page": data.count,
            "expand": 'categories',
            "sort": sort,
            "where_operator_format": [
                "like",
                "domain",
                location.protocol + '//' + location.hostname,
            ]
        };

        var cid = sessionStorage.getItem('articles.index.filter.category_id');

        if (cid) {
            params.category_id = cid;            
        }

        var page = sessionStorage.getItem('page.view.news.news.filter.page');

        if (page) {
            params.page = page;
            params.where = {
                locale: app.config.frontend_app_locale
            };
        }

        $.getJSON(
                app.config.frontend_app_api_url + '/db/articles',
                params,
                function (artData) {
                    var i = 0;
                    $.each(artData.items, function (key, val) {
                        artData.items[key].previewImg = val.thumbnail_base_url + '/' + val.thumbnail_path;
                        artData.items[key].viewUrl = app.view.helper.preffix + '/article/view/' + val.slug;
                        artData.items[key].dataFilterCategories = getDataFilterCategories(val.categories);
                        artData.items[key].categoryTitles = getCategoryTitles(val.categories);
                        if (i == 0) {
                            artData.items[key].boxLineBotton = '<div class="news_box__txt-top"></div><div class="news_box__txt-bt"></div>';
                        } else if (i == 1) {
                            artData.items[key].boxLineBotton = '<div class="news_box__txt-top"></div><div class="news_box__txt-bt"></div>';
                        } else {
                            artData.items[key].boxLineBotton = '<div class="news_box__txt-bt"></div>';
                        }
                        i++;
                    });

                    //show more bitton logic
                    data.items = artData.items;
                    if (artData._meta.pageCount > 1 && artData._meta.currentPage != artData._meta.pageCount) {
                        $('#newsShowMore').show();
                    }
                    else {
                        $('#newsShowMore').hide();
                    }
                    loadTemplateItems(data);
                });
    }

    function loadTemplateItems(data) {
        app.logger.func('loadTemplate(data)');
        var params = '';
        if (true == app.config.frontend_app_debug) {
            params = '?_' + Date.now();
        }
        app.templateLoader.getTemplateAjax(app.config.frontend_app_web_url + '/js/app/widgets/' + widget.widgetName + '/templates/_items.handlebars.html' + params, function (template) {
            renderWidgetItems(template(data), data);
        });
    }

    function renderWidgetItems(html, data) {
        app.logger.func('renderWidget(html)');

        if ($.isEmptyObject(app.view.grid)) {
            $(".news-container").append(html);
            bindFilterClick(data);
        }
        else {
            app.logger.text('app.view.grid exist, remove, insert, layout');
            
            if (data.removeItems) {
                app.view.grid.isotope('remove', $(".news-wrap"));
            }    
            
            app.view.grid.isotope('insert', $(html));
            //app.view.grid.isotope('layout');            
        }

        setTimeout(function () {
            app.bindContainerAjaxLinks(app.config.frontend_app_conainer);
        }, 500);

        $(window).trigger('page.view.article.article.renderWidgetItems');
    }

    function bindShowMoreClickEvent(data) {
        $("#newsShowMore").click(function () {
            var page = sessionStorage.getItem('page.view.news.news.filter.page');

            if (page) {
                sessionStorage.setItem('page.view.news.news.filter.page', page + 1);
            }

            data.removeItems = false;
            loadArticles(data);
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
                result.push(app.view.articleCategories[v.category_id]);
            }
        });

        return result.join(' / ');
    }

    function bindFilterClick(data) {
        // bind filter a click
        $('.article-category-item').on('click', function () {
            var cid = $(this).attr('categoryid');

            if ($(this).hasClass('active')) {
                removeItemsWithCategory(cid);
            } else {
                addItemsWithCategory(cid);
            }

            data.removeItems = true;
            loadArticles(data);
        });
    }

    function removeItemsWithCategory(cid) {
        app.logger.text('remove cid:' + cid);
        sessionStorage.setItem('page.view.news.news.filter.page', 1);

        var cids = sessionStorage.getItem('articles.index.filter.category_id');
        cids = cids.split(',');
        var newCids = [];
        $.each(cids, function (k, v) {
            if (v != cid) {
                newCids.push(v);
            }
        });
        sessionStorage.setItem('articles.index.filter.category_id', newCids.join(','));
    }

    function addItemsWithCategory(cid) {
        app.logger.text('add cid:' + cid);
        sessionStorage.setItem('page.view.news.news.filter.page', 1);

        var cids = sessionStorage.getItem('articles.index.filter.category_id');
        if (!$.isEmptyObject(cids)) {
            cids = cids.split(',');
            cids.push(cid);
            cids = cids.join(',');
        }
        else {
            cids = cid;
        }

        sessionStorage.setItem('articles.index.filter.category_id', cids);
    }



})();

