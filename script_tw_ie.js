
$(function(){
    var func_afterdo = function (var1, data1, textStatus, jqXHR) {
        // console.log(textStatus+":"+JSON.stringify(data1));
        if (data1.need_refresh) {
            window.location.reload();
            return false;
        }
    };
    var func_twie_ajax = function (twie_ajaxurl, cmd, var1) {
        var fd = new FormData();
        if (var1) {
            fd.append('style_tw', var1);
            fd.append('cmd', cmd);
            fd.append('action','twie_ajaxpost');
            return $.ajax({
                type: 'POST',
                url: twie_ajaxurl,
                data: fd,
                processData: false,
                contentType: false,
                timespan: 1000,
            });
        }
    };
    var func_get_tw_style = function() {
        $twstyle = "";
        $('head style:not([type])').each(function(index, val) {
            var tmp = $(val).html();
            if (0 <= tmp.indexOf("--tw")) {
                $twstyle = tmp;
                return;
            }
        });
        return $twstyle;
    };

    // on js <style></style> get and return
    var userAgent = window.navigator.userAgent.toLowerCase();
    if(userAgent.indexOf('msie') != -1 || userAgent.indexOf('trident') != -1) {
    } else {
        var var1 = func_get_tw_style();
        func_twie_ajax(twie_ajaxurl,"",var1).done(function(data1, textStatus, jqXHR) {
            func_afterdo(var1, data1, textStatus, jqXHR);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus+":"+errorThrown+" > "+JSON.stringify(jqXHR));
        });
    }
});
