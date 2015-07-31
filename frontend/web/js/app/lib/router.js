window.app.router = (function () {

    public = {
        locale: null,
        controller: null,
        action: null,
        slug: null,
        run: function (url) {
            app.logger.prefix = '[app][router]';
            app.logger.func('router run ' + url);

            var arr = url.replace(/^\//, '').split('/');

            app.logger.var(arr);

            switch (arr.length) {
                case 1:
                    if (!arr[0]) {
                        // empty url, default uk
                        arr[0] = 'ru';
                        arr[1] = 'page';
                        arr[2] = 'view';
                        arr[3] = 'home';
                    } else {
                        // /ru                  
                        arr[0] = arr[0];
                        arr[1] = 'page';
                        arr[2] = 'view';
                        arr[3] = 'home';
                    }
                    break;
                case 2:
                    //set default values
                    //ru/news
                    arr[3] = arr[1];
                    arr[1] = 'page';
                    arr[2] = 'view';
                    break;
                case 3:
                    //set default values
                    //ru/promo/helolo-moto
                    arr[3] = arr[2];
                    arr[2] = 'view'
                    break;
            }

            this.locale = arr[0];
            this.controller = arr[1];
            this.action = arr[2];
            this.slug = arr[3];

            app.logger.text('this.controller: ' + this.controller);
            app.logger.text('this.action: ' + this.action);
            app.logger.text('this.slug: ' + this.slug);

            switch (this.controller) {
                case 'page':
                    switch (this.action) {
                        case 'view':
                            $.getJSON(
                                    app.config.frontend_app_api_url + '/db/page',
                                    {where: {slug: this.slug, locale: app.config.frontend_app_locale}, fields: 'id,slug,head,body,title'},
                            function (data) {
                                app.view.renderPage(data.items[0]);
                            });
                            break;
                        case 'preview':
                            var data = getPageDataFromUrl(this.controller);

                            app.view.renderPage(data);
                            break;
                    }
                    break;
                case 'article':
                    switch (this.action) {
                        case 'view':
                            $.getJSON(
                                    app.config.frontend_app_api_url + '/db/article',
                                    {where: {slug: this.slug, locale: app.config.frontend_app_locale}, fields: 'id,slug,head,body,title'},
                            function (data) {
                                app.view.renderPage(data.items[0]);
                            });
                            break;
                        case 'preview':
                            var data = getPageDataFromUrl(this.controller);

                            app.view.renderPage(data);
                            break;
                    }
                    break;
                case 'project':
                    switch (this.action) {
                        case 'view':
                            $.getJSON(
                                    app.config.frontend_app_api_url + '/db/project',
                                    {where: {slug: this.slug, locale: app.config.frontend_app_locale}, fields: 'id,slug,head,body,title'},
                            function (data) {
                                app.view.renderPage(data.items[0]);
                            });
                            break;
                        case 'preview':
                            var data = getPageDataFromUrl(this.controller);

                            app.view.renderPage(data);
                            break;
                    }
                    break;
            }

        }
    };

    function getPageDataFromUrl(controller) {
        app.logger.var($.urlParams("all"));

        var data = {};
        $.each($.urlParams("keys"), function (k, v) {
            var key = unescape(v).toLowerCase();
            if (-1 != key.indexOf(controller)) {
                key = key.split('[')[1].replace(/]/, '');
                data[key] = $.urlParams("all")[v];
            }

        })

        app.logger.var(data);

        return data;
    }


    return public;
})()