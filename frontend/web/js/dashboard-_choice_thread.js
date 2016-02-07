$(window).load(function(){
    for(var i = 2; i < 8; i++){
        if($("#disabled_" + i).val() == 1){
            $("#option_" + i).hide();
        }
    }
});

$(document).ready(function(){
   $("#addOption").click(function(){
        for(var i = 2; i < 8; i++){
            if($("#disabled_" + i).val() == 1){
                $("#disabled_" + i).val(0);
                $("#option_" + i).show();
                return 1;
            }
        }
   });

    $("#closeOptionButton2").on('click', function(){
        $("#disabled_" + 2).val(1);

        $("#option_" + 2).hide();
    })
    $("#closeOptionButton3").on('click', function(){
        $("#disabled_" + 3).val(1);

        $("#option_" + 3).hide();
    })
    $("#closeOptionButton4").on('click', function(){
        $("#disabled_" + 4).val(1);

        $("#option_" + 4).hide();
    })
    $("#closeOptionButton5").on('click', function(){
        $("#disabled_" + 5).val(1);

        $("#option_" + 5).hide();
    })
    $("#closeOptionButton6").on('click', function(){
        $("#disabled_" + 6).val(1);

        $("#option_" + 6).hide();
    })
    $("#closeOptionButton7").on('click', function(){
        $("#disabled_" + 7).val(1);

        $("#option_" + 7).hide();
    })


});