window.app.view = (function () {
    var currentWidget;

    public = {
        renderPage: function (page) {
            app.logger.prefix = '[app][view]';

            //no widgets
            if (!page.body)
                return false;

            app.page = page;
            document.title = app.page.title;
            app.page.widgets = getWidgetsFromBody(app.page.body);
            this.helper.preffix = app.config.frontend_app_web_url + '/' + app.router.locale
                    
            beforePageRender();
            selectMenuItem();
            changeHomeUrl();
            renderWidgets();
        },
        getCurrentWidget: function () {
            return currentWidget;
        },
        beforeWidget: function (w) {
            app.logger.prefix = '[widget][' + w.widgetId + ']';
            app.logger.var(w);
        },
        afterWidget: function (w) {
            app.page.widgets[w.widgetId].rendered = true;
            app.logger.prefix = '';
        },
        helper: {
            preffix: null
        },
        getTranslationsFromData: function (data) {
            if ($.isEmptyObject(data.t)) {
                return {};
            }
            var t = {};

            $.each(data.t, function (k, v) {
                if (v.key && v.value) {
                    t[v.key] = v.value;
                }
            });

            return t;
        }

    };

    function getWidgetsFromBody(body) {
        var widgets = {};
        var obj = JSON.parse(body);
        var index = 0;

        $.each(obj, function (k, v) {
            var wname = getWnameFromWidget(v);

            if (!$.isEmptyObject(v) && 'tab_title' != k && '___' + wname + '___' != k) {

                var wid = wname + '__' + index;
                index++;
                widgets[wid] = v;
                widgets[wid].widgetId = wid;
                widgets[wid].widgetName = wname;
            }
        });

        return widgets;
    }

    function renderWidgets() {

        var callback = function () {
            //app.logger.text('call interval ');

            //render widgets array            
            var process = false;

            $.each(app.page.widgets, function (k, v) {
                //if true ...                               
                //if false break
                //if undefined run, set false ,break

                if (false === app.page.widgets[k].rendered) {
                    process = true;
                    return false;
                }

                if (undefined === app.page.widgets[k].rendered) {
                    app.page.widgets[k].rendered = false;
                    process = true;
                    currentWidget = app.page.widgets[k];
                    $.getScript(app.config.frontend_app_web_url + '/js/app/widgets/' + v.widgetName + '/widget.js');
                    return false;
                }
            });

            if (false === process) {
                app.logger.text('clear interval');
                clearInterval(window.intervalId)

                afterPageRender();
                app.afterPageRender();
            }
        };

        window.intervalId = setInterval(callback, 200);
    }

    function selectMenuItem() {
        $("nav").find(".nav-active").removeClass("nav-active");
        $('a[href*="' + location.pathname + '"]').addClass("nav-active");
    }

    function getWnameFromWidget(v) {
        var wname;

        $.each(v, function (k, v) {
            //app.logger.text(k);
            if (k.match(/___(.+)___/)) {
                wname = k.match(/___(.+)___/)[1];
            }
        });

        return wname;
    }

    function beforePageRender() {
        addHeader();  
        
        //clear all
        app.container.html('');

        if (undefined != twttr && undefined != twttr.events && undefined != twttr.events._handlers) {
            twttr.events.unbind('tweet');
        }

        $.getScript(app.config.frontend_app_web_url + '/js/lib/beforeRender.js');
    }

    function afterPageRender() {
        addFooter();
        app.bindAllAjaxLinks();
        //add ga
        //$.getScript(app.config.frontend_app_web_url + '/js/lib/google.analytics.js');
    }

    function changeHomeUrl() {
        if ('ru' == app.router.locale && 'page' == app.router.controller && 'view' == app.router.action && 'home' == app.router.slug) {
            // Change url            
            window.history.pushState(null, null, '/');
        }

        if ('en' == app.router.locale && 'page' == app.router.controller && 'view' == app.router.action && 'home' == app.router.slug) {
            // Change url            
            window.history.pushState(null, null, '/en');
        }
    }

    function addHeader() {
        if (app.view.headerLoaded) {
            return;
        }

        app.logger.func('addHeader');

        var params = {
            "fields": 'id,slug,title,body',
            "where": {
                "slug": "header",
                "locale": app.config.frontend_app_locale
            },
            "where_operator_format": [
                "like",
                "domain",
                location.protocol + '//' + location.hostname,
            ]
        };

        $.getJSON(
                app.config.frontend_app_api_url + '/db/blocks',
                params,
                function (data) {
                    var body = data.items[0].body.replace(/^\[/, '').replace(/\]$/, '');
                    data = JSON.parse(body);

                    data.t = app.view.getTranslationsFromData(data);

                    data.isRu = ('ru-RU' == app.config.frontend_app_locale) ? true : false;
                    data.urlToRu = app.config.frontend_app_web_url + '/site/set-locale?locale=ru-RU';
                    data.isEn = ('en-US' == app.config.frontend_app_locale) ? true : false;
                    data.urlToEn = app.config.frontend_app_web_url + '/site/set-locale?locale=en-US';

                    data.urlToHome = app.view.helper.preffix + '/page/view/home';

                    $.each(data.menu, function (key, val) {
                        if ('@frontend' == val.host) {
                            data.menu[key].url = app.view.helper.preffix + val.url;
                        }
                    });

                    var params = '';

                    if (true == app.config.frontend_app_debug) {
                        params = '?_' + Date.now();
                    }

                    app.templateLoader.getTemplateAjax(app.config.frontend_app_web_url + '/js/app/templates/header.html' + params, function (template) {
                        app.logger.var(data);

                        $(template(data)).insertBefore(app.config.frontend_app_conainer);
                        app.view.headerLoaded = true;
                    });
                });
    }

    function addFooter() {
        if (app.router.slug != 'contact') {            
            $('#contacts').show();
        }else {
            $('#contacts').hide();            
        }

        if (app.view.footerLoaded) {
            return;
        }

        app.logger.func('addFooter');

        var params = {
            "fields": 'id,slug,title,body',
            "where": {
                "slug": "footer",
                "locale": app.config.frontend_app_locale
            },
            "where_operator_format": [
                "like",
                "domain",
                location.protocol + '//' + location.hostname,
            ]
        };

        $.getJSON(
                app.config.frontend_app_api_url + '/db/blocks',
                params,
                function (data) {
                    var body = data.items[0].body.replace(/^\[/, '').replace(/\]$/, '');
                    data = JSON.parse(body);

                    data.t = app.view.getTranslationsFromData(data);

                    /*$.each(data.items, function (key, val) {
                     //data.items[key].previewImg = val.thumbnail_base_url + '/' + val.thumbnail_path;                        
                     });*/

                    var params = '';

                    if (true == app.config.frontend_app_debug) {
                        params = '?_' + Date.now();
                    }

                    app.templateLoader.getTemplateAjax(app.config.frontend_app_web_url + '/js/app/templates/footer.html' + params, function (template) {
                        app.logger.var(data);

                        $(template(data)).insertAfter(app.config.frontend_app_conainer);
                        app.view.footerLoaded = true;

                        if (app.router.slug == 'contact') {
                            $('#contacts').hide();
                        }
                    });
                });
    }

    return public;
})()