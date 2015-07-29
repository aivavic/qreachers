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
        app.view.grid = null;

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
                    var cids = [];
                    $.each(data.categories, function (k, v) {
                        cids.push(v.id);
                    });

                    sessionStorage.setItem('projects.index.filter.category_id', cids.join(','));

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
            bindShowMoreClickEvent();
        }, 500);

        loadProjects(data);

        app.view.afterWidget(widget);
    }

    function changeFilterButtonsState() {

        /*var cid = sessionStorage.getItem('projects.index.filter.category_id');
         
         if (cid) {
         app.logger.text('changeFilterButtonsState, cid: ' + cid);
         $('.filter-btn').trigger('click');
         var arr = cid.split(',');
         $('.filter-box').find('.project-category-item').each(function (k, v) {
         if (-1 != arr.indexOf($(v).attr('categoryid'))) {
         $(v).addClass('active');
         }
         });
         }*/
    }

    function loadProjects() {
        var sort = data.order_by;
        if ("desc" == data.sort_order)
            sort = "-" + sort;

        var params = {
            "fields": 'id,category_id,description,slug,thumbnail_base_url,thumbnail_path,title,video_base_url,video_path',
            "per-page": data.count,
            "expand": 'categories',
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
                    var i = 0;
                    $.each(artData.items, function (key, val) {
                        artData.items[key].previewImg = val.thumbnail_base_url + '/' + val.thumbnail_path;
                        artData.items[key].viewUrl = app.view.helper.preffix + '/project/view/' + val.slug;
                        artData.items[key].video = val.video_base_url + '/' + val.video_path;
                        artData.items[key].dataFilterCategories = getDataFilterCategories(val.categories);
                        artData.items[key].categoryTitles = getCategoryTitles(val.categories);
                        if (i == 0) {
                            artData.items[key].rows = 'col-md-offset-1';
                        } else if (i == 1) {
                            artData.items[key].rows = 'hidden-sm hidden-xs';
                            return i = 0;
                        }
                        i++;

                    });

                    //show more bitton logic
                    data.items = artData.items;
                    app.logger.var(data.items.length);
                    if (artData._meta.pageCount > 1 && artData._meta.currentPage != artData._meta.pageCount) {
                        $('#portfolioShowMore').show();
                    }
                    else {
                        $('#portfolioShowMore').hide();
                    }
                    loadTemplateItems(data);
                });
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

        if ($.isEmptyObject(app.view.grid)) {
            $(".projects").append(html);
            bindFilterClick();
        }
        else {
            app.logger.text('app.view.grid exist, remove, insert');
            app.view.grid.isotope('remove', $(".project-box"));
            app.view.grid.isotope('insert', $(html));
            //app.view.grid.isotope('layout');            
        }

        setTimeout(function () {
            //bind ajax load to links      
            app.bindContainerAjaxLinks(app.config.frontend_app_conainer);
        }, 500);

        $(window).trigger('page.view.portfolio.portfolio.renderWidgetItems');
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
                result.push(app.view.projectCategories[v.category_id]);
            }
        });

        return result.join(' / ');
    }

    function bindFilterClick() {
        // bind filter a click
        $('.project-category-item').on('click', function () {
            var cid = $(this).attr('categoryid');

            if ($(this).hasClass('active')) {
                removeItemsWithCategory(cid);
            } else {
                addItemsWithCategory(cid);
            }

            loadProjects();
        });
    }

    function removeItemsWithCategory(cid) {
        app.logger.text('remove cid:' + cid);
        sessionStorage.setItem('page.view.portfolio.portfolio.filter.page', 1);

        var cids = sessionStorage.getItem('projects.index.filter.category_id');
        cids = cids.split(',');
        var newCids = [];
        $.each(cids, function (k, v) {
            if (v != cid) {
                newCids.push(v);
            }
        });
        sessionStorage.setItem('projects.index.filter.category_id', newCids.join(','));
    }

    function addItemsWithCategory(cid) {
        app.logger.text('add cid:' + cid);
        sessionStorage.setItem('page.view.portfolio.portfolio.filter.page', 1);

        var cids = sessionStorage.getItem('projects.index.filter.category_id');
        if (!$.isEmptyObject(cids)) {
            cids = cids.split(',');
            cids.push(cid);
            cids = cids.join(',');
        }
        else {
            cids = cid;
        }

        sessionStorage.setItem('projects.index.filter.category_id', cids);
    }

})();

