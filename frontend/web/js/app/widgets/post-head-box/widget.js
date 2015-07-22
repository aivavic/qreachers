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
            "fields": 'id,slug,title,description,thumbnail_base_url,thumbnail_path,image_base_url,image_path,description',
            "expand": 'categories',
            //"per-page": data.count,
            //"sort": sort,
            "where" :{
                locale: app.config.frontend_app_locale,
                slug: app.router.slug
            }
            
        };
        $.getJSON(
                app.config.frontend_app_api_url + '/db/articles',
                params,
                function (articlesData) {
                    $.extend(data, articlesData);
                    data.urlToNews = app.view.helper.preffix + '/page/view/news';
                    data.currentItem = {};
                    data.currentItem.title = data.items[0].title;
                    data.currentItem.image = data.items[0].image_base_url + '/' + data.items[0].image_path;
                    app.logger.var(data.items[0]);
                    //data.currentItem.video = data.items[0].video_base_url + '/' + data.items[0].video_path;
                    data.currentItem.category_id = (data.items[0].categories[0]) ? data.items[0].categories[0].id : '-';
                    loadDataAll(data);
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
                app.config.frontend_app_api_url + '/db/article-categories',
                params,
                function (catData) {
                    data.category_title = catData.items[0].title;
                    loadTemplate(data);
                });
    }
    
    function loadDataAll(data) {
        app.logger.func('loadDataAll()');

        var data = widget;
        
        var params = {
            "fields": 'id,slug,title,description,thumbnail_base_url,thumbnail_path,description,video_base_url,image_base_url,image_path,video_path',
            "sort" : '-id',              
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
                app.config.frontend_app_api_url + '/db/articles',
                params,
                function (articlesData) {
                    $.each(articlesData.items, function (key,val) {
                        if(val.slug == app.router.slug){
                            if(articlesData.items[key-1]){  
                              data.prevUrl = app.view.helper.preffix + '/article/view/' + articlesData.items[key-1].slug;
                            } else {
                               data.prevUrl = app.view.helper.preffix + '/article/view/' + articlesData.items[articlesData.items.length-1].slug; 
                            }
                            if(articlesData.items[key+1]){
                              data.nextUrl = app.view.helper.preffix + '/article/view/' + articlesData.items[key+1].slug;
                            } else {
                              data.nextUrl = app.view.helper.preffix + '/article/view/' + articlesData.items[0].slug;  
                            }
                       }
                       
                    });
                    loadCategory(data);
                });
    }

    function renderWidget(html) {
        app.logger.func('renderWidget(html)');
        app.container.append(html);

        //bind ajax load to links                                 
        app.bindContainerAjaxLinks("#main-article-list-container");

        app.view.afterWidget(widget);
    }

})();

