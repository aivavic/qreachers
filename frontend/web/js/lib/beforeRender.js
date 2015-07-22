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
});