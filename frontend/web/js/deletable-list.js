/*!
 * @copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @version 1.4.1
 *
 * Bootstrap Popover Extended - Popover with modal behavior, styling enhancements and more.
 *
 * For more JQuery/Bootstrap plugins and demos visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */
(function ($) {
    "use strict";
    $(document).on("click", ".widget-deletable-list-remove-button", function(e){
        var to_be_deleted_issue  = $(this).data('service');
        var widget_id = $(this).data('widget-id');
        var controller_hidden_input_id = widget_id + "-controller-hidden-input";
        var name_id = widget_id + "-name";
        $.ajax({
            url: $("#" + controller_hidden_input_id).val(),
            type: 'POST',
            data:
            {
                deleted_issue: to_be_deleted_issue
            },
            success: function(success){
                if(success){
                    $(".widget-deletable-list-remove-button[data-service='"+ to_be_deleted_issue +"']")
                        .closest('.widget-deletable-list-remove-button-container').remove();

                }
            }
        });

    });


})(window.jQuery);