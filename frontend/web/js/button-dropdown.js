/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('click', '.button-dropdown-label', function(event) {
   var id = $(this).data('id');
   var widget = $("#" + id);
   
   var popover = widget.find('.button-dropdown-popover');
   popover.toggle(100);
});

$(document).on('blur', '.button-dropdown-label', function(event) {
   var id = $(this).data('id');
   var widget = $("#" + id);
   
   var popover = widget.find('.button-dropdown-popover');
   popover.hide(100); 
});

