function Tab_lib(){}

Tab_lib.prototype = {

    test : function ( e, pObj ) {
        setTimeout(function () {
            $('.nav-tabs').find('.active');
            $('.nav-tabs').find('.atab').tab('show');
        });
    }
};

$(function () {
    window.Tab_lib = new Tab_lib();
});
