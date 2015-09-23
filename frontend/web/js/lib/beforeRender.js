$(document).ready(function () {
    var params = {
        "fields": 'id,title'
    };
    //article
    var resultArticle = [];
    $.getJSON(
            app.config.frontend_app_api_url + '/db/article-categories',
            params,
            function (catData) {
                $.each(catData.items, function (k, v) {
                    resultArticle[v.id] = v.title;
                });
                app.view.articleCategories = resultArticle;
            });
    //project
    var resultProject = [];
    $.getJSON(
            app.config.frontend_app_api_url + '/db/project-categories',
            params,
            function (catData) {
                $.each(catData.items, function (k, v) {
                    resultProject[v.id] = v.title;
                });
                app.view.projectCategories = resultProject;
            });

    //FB init
    window.fbAsyncInit = function () {
        FB.init({
            appId: app.config.frontend_app_facebook_app_id,
            xfbml: true,
            version: 'v2.3'
        });
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
});