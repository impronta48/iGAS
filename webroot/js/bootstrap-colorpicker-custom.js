$(function() {
    // Code for those demos
    var _createColorpickers = function() {
        $('#cp1').colorpicker({
            format: 'hex'
        });
        $('#cp2').colorpicker();
        $('#cp3').colorpicker();
        $('#cp4').colorpicker();
    }

    _createColorpickers();

    $('.bscp-destroy').click(function(e) {
        e.preventDefault();
        $('.bscp').colorpicker('destroy');
    });

    $('.bscp-create').click(function(e) {
        e.preventDefault();
        _createColorpickers();
    });


});
