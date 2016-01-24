function beginEditModal(){
    $("#editModal").modal("show")
        .find('#editModal')
        .load($(this).attr("value"));
}