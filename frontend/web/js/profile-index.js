function beginEditModal(){

    $("#editModal").modal("show")
        .find('#editModal')
        .load($(this).attr("value"));
}



function beginProfilePicModal(){

    $("#uploadProfilePicModal").modal("show")
        .find('#uploadProfilePicModal')
        .load($(this).attr("value"));
}


