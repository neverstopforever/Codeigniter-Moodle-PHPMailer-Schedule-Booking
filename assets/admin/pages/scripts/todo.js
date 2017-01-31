/**
Todo Module
**/
var Todo = function() {

    // private functions & variables

    var _initComponents = function() {

        // init datepicker
        var datepicker_format = 'yyyy-mm-dd';
        var language = 'en';
        if(lang == "spanish"){
            datepicker_format = 'dd-mm-yyyy';
            language = 'es';
        }
        $('.task_end').datepicker({
            format: datepicker_format,
            autoclose: true,
            todayHighlight: true,
            toggleActive: true,
            language: language
        });

        // init tags        
        // $(".todo-taskbody-tags").select2({
        //         placeholder: "Status"
        // })
    }

    var _handleProjectListMenu = function() {
        if (Metronic.getViewPort().width <= 992) {
            $('.todo-project-list-content').addClass("collapse");
        } else {
            $('.todo-project-list-content').removeClass("collapse").css("height", "auto");
        }
    }

    // public functions
    return {

        //main function
        init: function() {
            _initComponents();
            _handleProjectListMenu();

            Metronic.addResizeHandler(function() {
                _handleProjectListMenu();
            });
        }

    };

}();
