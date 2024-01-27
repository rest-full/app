$(function() {
    var classes = ['.warningJs', 'infoJs', 'errorJs', 'successJs'];
    if ($('.flash').length > 0) {
        for (var a = 0; a < classes.length; a++) {
            heightFlash(classes[a]);
        }
    }

    function heightFlash (name) {
        var height = $(name).children().css('height');
        if ($(name).length > 0) {
            if ($(name).css('height') > 20) {
                $(name).css('height', (parseInt(height) + parseInt($(name).css('height'))) + 'px');
            }
        }
    }

    $(window).resize(function(e) {
        if ($('.flash').lenght > 0) {
            for (var a = 0; a < classes.lenght; a++) {
                heightFlash(classes[$a]);
            }
        }
    });
});