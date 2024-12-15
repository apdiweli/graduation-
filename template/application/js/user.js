$(".yuu").click(function(e){
    e.preventDefault();

     var url=$(this).attr("href");
    $.post(url,function(ress){
    $(".form-place").html(ress);

      loadData();
   

            let filename =document.querySelector("#image");
            let showinput =document.querySelector("#show");

            const reader =new FileReader();
            filename.addEventListener("change",(e)=> {
                const selectedfile =e.target.files[0];
                reader.readAsDataURL(selectedfile);

            })

            reader.onload = e =>{
                showinput.src =e.target.result;

            }



            $("#AddNew").on("click",function(){
                $("#user_model").modal("show");
            })

            // alert(44);

            $("#user_form").on("submit",function(e){
                    e.preventDefault();
                    

                    let form_data =new FormData($("#user_form")[0]);
                    form_data.append("image",$("input[type =file]")[0].files[0]);

                    form_data.append("action","register_user");
                    

                    
                

                    $.ajax({
                        method:"POST",
                        type:"JSON",
                        url:("application/api/user.php"),
                        data:form_data,
                        processData :false,
                        contentType :false,
                        success:function(data){
                            let status=data.status;
                            let reponse = data.data;
                            if(status){
                                displayMessege("success",reponse);
                                $("user_form")[0].reset();
                                // loadData();
                                
                            }
                            else{
                                displayMessege("error",reponse);
                            }

                        },
                        error :function(data){
                            displayMessege("error",reponse);
                        }

                        


                    })

            })


            function loadData(){

                $("#userTable tbody").html("");
            
                let sendingData={
                    action : "readAlluser"
            
                }
            
                $.ajax({
                    method:"POST",
                    type:"JSON",
                    url:("application/api/user.php"),
                    data:sendingData,
                    success:function(data){
            
                        let status=data.status;
                        let reponse = data.data;
                        let html ='';
                        let th='';
                        let tr ='';
            
                        if(status){
                            reponse.forEach(item => {
                                
                                th="<tr>";
                                for(let i in item){
                                    th+=`<th> ${i} </th>`;
            
                                }
                                th+="<th>action </th>";
                                th+="</tr>";
            
                                tr += "<tr>";
                                for(let res in item){
                                    if(res =="image"){
                                        
                                            tr +=`<td> <img style="width:60px; border:1px solid #e3ebe7; height:60px; border-radius:50%; margin-left:20px; object-fit:cover" src="application/uploads/${item[res]}" > </td>`;
                            
                                        
                                    }
                                    else{
                                        tr +=`<td> ${item [res]} </td>`;
                                    }
            
                                };
            
                                tr += `<td> 
                                    <a class="btn btn-info update_info" update_id="${item['id']}">
                                        <i class="fas fa-edit" style="color:#fff"></i>
                                    </a> &nbsp; &nbsp;
                                    <a class="btn btn-danger delete_info" delete_id="${item['id']}">
                                        <i class="fas fa-trash" style="color:#fff"></i>
                                    </a>
                                </td>`;
                                tr += "</tr>";
                                
                                
                            });
                            $("#userTable thead").append(th);
                            $("#userTable tbody").append(tr);
                        }
            
                    },
                    error : function(data){
                        displayMessege("error",reponse);
            
                    }
            
                })
            
            }




    

    })

})