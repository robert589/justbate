/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
// */
//$(document).on("mouseenter", ".child-comment-container", function() {
//    $(this).find(".child-comment-action-wrapper").removeClass("child-comment-hide");
//});

$(document).on("mouseleave", ".child-comment-container", function() {
    $(this).find(".child-comment-action-wrapper").addClass("child-comment-hide");
});
