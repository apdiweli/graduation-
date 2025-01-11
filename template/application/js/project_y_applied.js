$(".get_applied").click(function(e){


    e.preventDefault();

    var url=$(this).attr("href");
   $.post(url,function(ress){
   $(".form-place").html(ress);

//    alert(333);




   })




})