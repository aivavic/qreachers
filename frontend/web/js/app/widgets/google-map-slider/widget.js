(function () {
    /*** process   ***/
    //run()->loadData()->loadTemplate(data)->renderWidget(html);

    var widget = app.view.getCurrentWidget();
    app.view.beforeWidget(widget);

    var mapIndex = 0;

    run();

    function run() {
        app.logger.func('run');
        loadData();
    }

    function loadData() {
        app.logger.func('loadData()');

        var data = widget;

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
            google.maps.event.addDomListener(window, 'resize', initialize(widget.items[mapIndex].latitude, widget.items[mapIndex].longitude));
            if ( widget.items.length < 2) {
                $('.map-left').hide();
                $('.map-right').hide();
            }
            initialize(widget.items[mapIndex].latitude, widget.items[mapIndex].longitude);
        }, 2000);

        registerPrevButton();
        registerNextButton();

        app.view.afterWidget(widget);
    }

    function initialize(lat, long) {

        var mapOptions = {
            zoom: 17,
            center: new google.maps.LatLng(lat, long),
            disableDefaultUI: true,
            scrollwheel: false,
            styles: [{"stylers": [{"hue": "#ff1a00"}, {"invert_lightness": true}, {"saturation": -100}, {"lightness": 33}, {"gamma": 0.5}]}, {"featureType": "water", "elementType": "geometry", "stylers": [{"color": "#2D333C"}]}]
        };

        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var imgNumber = mapIndex +1;
        var point1 = app.config.frontend_app_web_url + '/img/pointer' + imgNumber + '.png';

        var myLatLng = new google.maps.LatLng(lat - 0.0011, long);
        var Marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            icon: point1
        });
        
        $(".city").html(widget.items[mapIndex].city)
        $(".street").html(widget.items[mapIndex].street)
    }

    function registerNextButton() {
        $(".map-right").click(function () {
            if (undefined != widget.items[mapIndex +1]) {
                mapIndex++;
                initialize(widget.items[mapIndex].latitude, widget.items[mapIndex].longitude)                
            }
        });

    }

    function registerPrevButton() {
        $(".map-left").click(function () {
            
            if (undefined != widget.items[mapIndex-1]  ) {
                mapIndex--;
                initialize(widget.items[mapIndex].latitude, widget.items[mapIndex].longitude)            
            }
        });
    }


})();

