$(function () {
    var id = $('#' + $('.linkjs').data('target')).eq(0), length, height = 0
    $(document).on('click', '.linkjs', function () {
        var links = $('.linkjs')
        id = $('#' + $(this).data('target'))
        height = 0
        for (var number = 0; number < links.length; number++) {
            if (!($('#way-' + number).hasClass('cols-7-disabled'))) {
                $('#way-' + number).addClass('cols-7-disabled')
            }
        }
        id.removeClass('cols-7-disabled')
        renderHeight();
        return false
    })
    renderHeight();

    function renderHeight() {
        length = id.children('.row-info').length
        for (var number = 0; number < length; number++) {
            height += parseFloat(id.children('.row-info').eq(number).css('height')) + parseFloat(id.children('.row-info').eq(number).css('margin-bottom'));
        }
        var heightRem = height / 16
        if (height === 196) {
            heightRem -= 0.25
        }
        id.css('height', heightRem + 'rem')
    }
})