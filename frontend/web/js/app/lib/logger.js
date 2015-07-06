window.app.logger = (function () {
    var startLogTime;    

    public = {
        prefix : '[app]',
        
        page: function (message) {                        
            if (false != app.config.frontend_app_log_clear_page) {            
                console.clear();                
            }
            
            consoleLog(message, '');
        },
        func: function (message) {
            consoleLog(message, '      ');
        },
        text: function (message) {
            consoleLog(message, '            ');
        },
        var : function (v) {
            consoleDir(v);
        },
        
        resetTimer : function() {            
            startLogTime = (new Date()).getTime();        
        }
    };

    function consoleDir(v) {
        if (false == app.config.frontend_app_debug)
            return true;

        console.dir(v);
    }

    function consoleLog(message, tab) {
        if (false == app.config.frontend_app_debug)
            return true;

        var style = 'color: green';

        console.log('%c ' + tab + ' [' + getLogTime() + ' s] '+ window.app.logger.prefix + ' ' + message + ' ', style);
    }

    function getLogTime() {
        if (undefined == startLogTime) {
            startLogTime = (new Date()).getTime();
        }

        return (((new Date()).getTime() - startLogTime) / 1000).toFixed(2);
    }

    return public;
})()