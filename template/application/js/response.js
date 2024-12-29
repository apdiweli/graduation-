$(".gt_submit").click(function(e){
    e.preventDefault();

     var url=$(this).attr("href");
    $.post(url,function(ress){
    $(".form-place").html(ress);


   




    })


})