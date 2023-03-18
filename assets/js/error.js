var $ = require('jquery')
$(function () {
    $(document).on('click', '.linkjs', function () {
        var id = $('#' + $(this).data('target')), links = $('.linkjs')
        for (var a = 0; a < links.length; a++) {
            $('#way-' + a).addClass('disabled')
        }
        id.removeClass('disabled')
        var length = id.children('.row-info').length
        id.css('height', ((length * 34) + (4.8 * length)) + 'px')
        return false
    })
    $('.errorTitle').css('height', (parseFloat($('h1').css('height')) + parseFloat($('h1').css('margin-bottom'))) + 'px')
})