/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {

    function resizeTextarea(e) {
        $(e).css({'height':'auto','overflow-y':'hidden'}).height(e.scrollHeight);
     
    }

    $('.auto-height-text-area').each(function () {
        
    }).on('input', function () {
      resizeTextarea(this);
    });
 
});