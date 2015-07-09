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

        data = widget;

        loadTemplate(data);
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

        setTimeout(function () {
            processGoogleMap();
        }, 1000);
        app.view.afterWidget(widget);
    }

    function processGoogleMap() {
        renderGoogleMap();
        bindGoogleMapEvents();
    }

    function bindGoogleMapEvents() {
        google.maps.event.addDomListener(window, 'resize', initializeGoogleMap());

        $(window).load(function () {
            var container = $(".contacts-map");

            if ($(window).height() > 1150)
                container.height($(window).height() - $("nav").outerHeight() - $("footer").outerHeight());
            else
                container.attr({"style": ""});
        });

        $(window).resize(function () {
            if ($(window).height() > 1150)
                container.height($(window).height() - $("nav").outerHeight() - $("footer").outerHeight());
            else
                container.attr({"style": ""});
        });

        /*$('.contacts-box').click(function () {
            window.open(app.config.frontend_site_content_map_click_url);
        });*/

    }

    function renderGoogleMap() {
        initializeGoogleMap();
    }

    function initializeGoogleMap() {

        var mapOptions = {
            zoom: 17,
            center: new google.maps.LatLng(data.map_y, data.map_x),
            disableDefaultUI: true,
            scrollwheel: false,
            styles: [{"stylers": [{"hue": "#ff1a00"}, {"invert_lightness": true}, {"saturation": -100}, {"lightness": 33}, {"gamma": 0.5}]}, {"featureType": "water", "elementType": "geometry", "stylers": [{"color": "#2D333C"}]}]
        };

        map = new google.maps.Map(document.getElementById('map'), mapOptions);

        var image = app.config.frontend_app_web_url + '/img/pointer-clear.png';

        var myLatLng = new google.maps.LatLng(data.marker_y, data.marker_x);
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            url: 'https://www.google.com.ua/maps/place/@' + data.marker_y + ',' + data.marker_x + ',17z/data=!4m2!3m1!1s0x40d4cefec397bd8f:0xd344af779861fc77',
            icon: image
        });

        google.maps.event.addListener(marker, 'click', function () {
            window.location.href = marker.url;
        });
    }

})();

