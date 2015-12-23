 $('#comment-box').keydown(function(event) {
    if (event.keyCode == 13) {
        $(this.form).submit()
        return false;
     }
}).focus(function(){
    if(this.value == "Write your comment here..."){
         this.value = "";
    }

}).blur(function(){
    if(this.value==""){
         this.value = "Write your comment here...";
    }
});