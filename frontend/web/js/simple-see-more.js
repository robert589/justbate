/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('click', '.simple-see-more-text-link', function(event) {
    var id = $(this).data('id');
    $("#" + id).find('.simple-see-more-text-active').addClass('simple-see-more-text-hide');
    $("#" + id).find('.simple-see-more-text-not-active').removeClass('simple-see-more-text-hide');
}) ;
