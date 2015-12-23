function changeThis(){
    var formInput = document.getElementById('userDescription').value;
    document.getElementById('description').innerHTML = formInput;
}

$("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });