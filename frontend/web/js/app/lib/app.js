/* Simple single page application 
 * with :
 * jquery, 
 * jquery.loadTemplate, 
 * jquery.url-params
 * 
 * @author Eugene Fabrikov eugene.fabrikov@gmail.com
 */

window.app = (function () {
    // ------------------ private vars ---------------------- //

    var public = {
        // ------------------ public vars ----------------------- //
        container: null,
        isFirstLoad: true,
        // ------------------ public functions ------------------ //
        run: function () {
            app.logger.page(location.href);
            app.logger.func('run()');
            init();
            bindEventListeners();
            process();
        },
        bindContainerAjaxLinks: function (selector) {
            app.logger.func('bindContainerAjaxLinks( ' + selector + ')');

            if (app.config.frontend_app_conainer != selector) {
                app.container.find(selector).find('.ajaxLink').off('click');
                app.container.find(selector).find('.ajaxLink').click(fClickAjaxLink);
                app.logger.text('!=selector');
            }
            else {
                app.logger.text('=selector');
                app.container.find('.ajaxLink').off('click');
                app.container.find('.ajaxLink').click(fClickAjaxLink);
            }
        },
        bindAllAjaxLinks: function () {
            app.logger.func('bindAllAjaxLinks');
                $('body').find('.ajaxLink').off('click');
                $('body').find('.ajaxLink').click(fClickAjaxLink);

        },
        afterPageRender: function () {
            app.logger.func('afterPageRender()');

            $('.main-container').show();
            $('footer').show();

            if (app.isFirstLoad) {
                preloadLogoEnd();
				console.log(Modernizr);
            }
            else {
                preloadFadeOut();
            }

        }

    }

    // ------------------ private functions ----------------- //
    function init() {
        app.logger.func('init()');
        public.container = $(app.config.frontend_app_conainer);
        registerHandlebarsHelpers();
    }

    function bindEventListeners() {
        app.logger.func('bindEventListeners()');
        bindAjaxLinks();

        preloadStart();
    }

    function process() {
        app.logger.func('process()');
        
        app.router.run(location.pathname);
        
    }

    function bindAjaxLinks() {
        app.logger.func('bindAjaxLinks()');
        //bind ajax load to links 
        $('.ajaxLink').off('click');
        $('.ajaxLink').click(fClickAjaxLink);
    }

    function registerHandlebarsHelpers() {
        Handlebars.registerHelper('link', function (text, url) {
            text = Handlebars.Utils.escapeExpression(text);
            url = Handlebars.Utils.escapeExpression(url);

            var result = '<a href="' + url + '">' + text + '</a>';

            return new Handlebars.SafeString(result);
        });
    }

    function changePage(url, params) {
        // Change url
        if (url != window.location) {
            window.history.pushState(null, null, url);
        }

        //load html
        app.router.run(url + params);

        //Back Forward buttons
        $(window).off('popstate');
        $(window).bind('popstate', function () {
            app.router.run(location.pathname + params);
        });
    }

    fClickAjaxLink = (function () {
        app.logger.prefix = '[app]';
        app.logger.page(location.href);
        app.logger.func('fClickAjaxLink()');

        app.logger.resetTimer();

        app.isFirstLoad = false;

        sessionStorage.setItem('app.previous_url', location.href);

        var url = $(this).attr('href');
        var params = '';

        preloadFadeIn();

        setTimeout(function () {
            changePage(url, params);
        }, 1000);

        // Prevent default action
        return false;
    })

    return public;
})();

//tmp fix
window.app.config = {};