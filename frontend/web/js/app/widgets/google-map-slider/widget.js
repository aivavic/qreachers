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
            
            initialize(widget.items[mapIndex].latitude, widget.items[mapIndex].longitude);
        }, 2000);

        registerUaButton();
        registerKzButton();

        app.view.afterWidget(widget);
    }

    function initialize(lat, long) {
        
        //$(".city").html(widget.items[mapIndex].city)
        //$(".street").html(widget.items[mapIndex].street)*/
        
        
        // Coordinates        
        var myLatlng = new google.maps.LatLng(lat, long-0.004);

        // Map options
        var mapOptions = {
            disableDefaultUI: true,
            center: new google.maps.LatLng(lat, long),
            zoom: 17,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: [{"stylers": [{"hue": "#03303c"}, {"invert_lightness": true}, {"saturation": 50}, {"lightness": 33}, {"gamma": 0.5}]}, {"featureType": "water", "elementType": "geometry", "stylers": [{"color": "#2D333C"}]}]
        }

        // Init map
        var map = new google.maps.Map(document.getElementById('bigmap'), mapOptions);

        // Add markers
        var marker = new google.maps.Marker({
            position: myLatlng,
            animation: google.maps.Animation.DROP,
            map: map,
            icon: '/img/ico-contacts_marker.png',
            url: 'https://www.google.com.ua/maps/place/@' + lat + ',' + long + ',17z/data=!4m2!3m1!1s0x40d4cefec397bd8f:0xd344af779861fc77',
        });
        
        $(".show-inmap a").click(function() {
            window.open(marker.url);
            return false;
        });
    }

    function registerUaButton() {
        $("a[aria-controls=contacts-ukraine]").click(function () {            
            initialize(widget.items[mapIndex].latitude, widget.items[mapIndex].longitude)                            
        });

    }

    function registerKzButton() {
        $("a[aria-controls=contacts-kz]").click(function () {            
            initialize(widget.items[mapIndex+1].latitude, widget.items[mapIndex+1].longitude)                
            
        });
    }


})();

