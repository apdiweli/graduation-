

$(".get_form").click(function(e){
        e.preventDefault();

         var url=$(this).attr("href");
        $.post(url,function(ress){
        $(".form-place").html(ress);


        $("#projectForm").on("submit",function(event){
            event.preventDefault();
            
        
            let form_data =new FormData($("#projectForm")[0]);
         
        
            form_data.append("action","project_registration");
        
            
        
            // console.log("Requesting URL:", url);
            $.ajax({
                method: "POST",
                dataType: "JSON",
                url: "application/api/project.php",
                data: form_data,
                processData: false,
                contentType: false,
                success:function(data){
                    // console.log("Requesting URL:", url);

             
                    let status=data.status;
                    let reponse = data.data;
                    if(status){
                        displayMessege("success",reponse);
                        
                     
                        
                    }
                    else{
                        displayMessege("error",reponse);
                    }
        
                },
                error :function(data){
                    displayMessege("error");
                }
        
                
        
        
            })
        
        })


        // function loadData(){

        //     $("#projectTable tbody").html("");
        
        //     let sendingData={
        //         action : "readAllprojects"
        
        //     }
        
        //     $.ajax({
        //         method:"POST",
        //         type:"JSON",
        //         url:("application/api/project_report.php"),
        //         data:sendingData,
        //         success:function(data){
        
        //             let status=data.status;
        //             let reponse = data.data;
        //             let html ='';
        //             let th='';
        //             let tr ='';
        
        //             if(status){
        //                 reponse.forEach(item => {
                            
        //                     th="<tr>";
        //                     for(let i in item){
        //                         th+=`<th> ${i} </th>`;
        
        //                     }
        //                     th+="<th>action </th>";
        //                     th+="</tr>";
        
        //                     tr += "<tr>";
        //                     for(let res in item){
        //                         if(res =="image"){
                                    
        //                                 tr +=`<td> <img style="width:60px; border:1px solid #e3ebe7; height:60px; border-radius:50%; margin-left:20px; object-fit:cover" src="../uploads/${item[res]}" > </td>`;
                        
                                    
        //                         }
        //                         else{
        //                             tr +=`<td> ${item [res]} </td>`;
        //                         }
        
        //                     };
        
        //                     tr += `<td> 
        //                         <a class="btn btn-info update_info" update_id="${item['id']}">
        //                             <i class="fas fa-edit" style="color:#fff"></i>
        //                         </a> &nbsp; &nbsp;
        //                         <a class="btn btn-danger delete_info" delete_id="${item['id']}">
        //                             <i class="fas fa-trash" style="color:#fff"></i>
        //                         </a>
        //                     </td>`;
        //                     tr += "</tr>";
                            
                            
        //                 });
        //                 $("#projectTable thead").append(th);
        //                 $("#projectTable tbody").append(tr);
        //             }
        
        //         },
        //         error : function(data){
        //             displayMessege("error",reponse);
        
        //         }
        
        //     })
        
        // }



        function displayMessege(type,messege){
            let success=document.querySelector(".alert-success");
            let error=document.querySelector(".alert-danger");
        
            if(type =="success"){
                error.classList="alert alert-danger d-none";
                success.classList="alert alert-success ";
                success.innerHTML=messege;
        
                setTimeout(function(){
                   
                    $("#projectForm")[0].reset();
                    success.classList="alert alert-success  d-none";
        
                },3000)
        
            }
            else{
                error.classList="alert alert-danger";
                error.innerHTML=messege;
            }
        
        }
        

        
       
        
    })
})

// $(".get").click(function(e){
//     e.preventDefault();

//      var url=$(this).attr("href");
//     $.post(url,function(ress){
//     $(".form-place").html(ress);


    
// })
// })








