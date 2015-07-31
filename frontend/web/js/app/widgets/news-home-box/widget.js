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
            "expand": 'categories',
            "per-page": data.count,
            "sort": sort,
            "where" :{
                locale: app.config.frontend_app_locale
            }
            
        };

        $.getJSON(
                app.config.frontend_app_api_url + '/db/articles',
                params,
                function (articlesData) {
                    $.extend(data, articlesData);
                    var i = 0;
                    $.each(data.items, function (key, val) {
                        data.items[key].previewImg = val.thumbnail_base_url + '/' + val.thumbnail_path;
                        data.items[key].viewUrl = app.view.helper.preffix + '/article/' + val.slug;
                        data.items[key].description = val.description;
                        data.items[key].previewVideo = val.video_base_url + '/' + val.video_path;
                        data.items[key].category_id = (val.categories[0]) ? getCategoryTitles(val.categories) : '-';
                        if(i == 0){
                            data.items[key].boxLineBotton = '<div class="news_box__txt-top wow fadeInLeft animated" data-wow-duration="1.2s" data-wow-delay="1s" data-wow-offset="60" style="visibility: visible; -webkit-animation: fadeInLeft 1.2s 1s;"></div><div class="news_box__txt-bt wow fadeInLeft animated" data-wow-duration="1.2s" data-wow-delay="1s" data-wow-offset="60" style="visibility: visible; -webkit-animation: fadeInLeft 1.2s 1s;"></div>';   
                        } else if(i == 1) {
                            data.items[key].boxLineBotton = '<div class="news_box__txt-top wow fadeInLeft animated" data-wow-duration="1.2s" data-wow-delay="1s" data-wow-offset="60" style="visibility: visible; -webkit-animation: fadeInLeft 1.2s 1s;"></div><div class="news_box__txt-bt wow fadeInLeft animated" data-wow-duration="1.2s" data-wow-delay="1s" data-wow-offset="60" style="visibility: visible; -webkit-animation: fadeInLeft 1.2s 1s;"></div>';
                        } else if(i == 2) {
                            data.items[key].boxLineBotton = '<div class="news_box__txt-bt wow fadeInLeft" data-wow-duration="1.2s" data-wow-delay="1s" data-wow-offset="60"></div>';
                        } else if(i == 3) {
                            data.items[key].boxLineBotton = '<div class="news_box__txt-bt wow fadeInLeft" data-wow-duration="1.2s" data-wow-delay="1s" data-wow-offset="60"></div>';
                            return i = 0;
                        }
                        i++;
                    });

                    data.urlToNews = app.view.helper.preffix + '/news';

                    data.groups = items_array_chunk(data.items, 4);
                    app.logger.var(data.groups);
                    app.logger.var(data.items.length);
                    if(data.items.length > 4){
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
        app.bindContainerAjaxLinks(".news_box");

        app.view.afterWidget(widget);
    }

    function getCategoryTitles(categories) {
        var result = [];

        $.each(categories, function (k, v) {
            if (v.category_id) {
                result.push(app.view.articleCategories[v.category_id]);
            }
        });

        //TODO: get category title from data.categories

        return result.join(' / ');
    }

})();

