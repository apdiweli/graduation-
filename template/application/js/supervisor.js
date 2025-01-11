let btnaction = "Insert";  // Default action is insert
$("#supervisor_page").click(function(e){
    
    e.preventDefault();

     var url=$(this).attr("href");
    $.post(url,function(ress){
    $(".form-place").html(ress);


    let btnaction = "Insert";

      loadData();
   

            // let filename =document.querySelector("#image");
            // let showinput =document.querySelector("#show");

            // const reader =new FileReader();
            // filename.addEventListener("change",(e)=> {
            //     const selectedfile =e.target.files[0];
            //     reader.readAsDataURL(selectedfile);

            // })

            // reader.onload = e =>{
            //     showinput.src =e.target.result;

            // }



            $("#AddNew").on("click",function(){
                $("#user_model").modal("show");
          
            })

            

            $("#user_form").on("submit",function(e){
                    e.preventDefault();
                    

                    let form_data =new FormData($("#user_form")[0]);
                    form_data.append("image",$("input[type =file]")[0].files[0]);

                    form_data.append("action","register_user");
                    

                    
                

                    $.ajax({
                        method:"POST",
                        type:"JSON",
                        url:("application/api/supervisor.php"),
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


            $("#supervisor_form").submit(function(event) {
                event.preventDefault();  // Prevent default form submission
                
                // Get the form data
                let form_data = new FormData($("#supervisor_form")[0]);
                
                // Set the appropriate action based on btnaction
                if (btnaction === "Insert") {
                    form_data.append("action", "supervisor_registered");
                }
                else if (btnaction === "Update") {
                    form_data.append("action", "updateStudent");
                }
            
                // Make the AJAX request
                $.ajax({
                    method: "POST",
                    dataType: "JSON",
                    url: "application/api/supervisor.php",
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        let status = data.data;
                        let response = data.data;
                       if(status){
                        // alert(status)
                        displayMessege("success",response);
                        btnaction = "Insert";
                       loadData();
                        // loadData();  // Reload the data after updating
                       }
                       else{
                        displayMessege("error",response);
                       }
                    },
                    error :function(data){
                        displayMessege("error",status);
                    }
                });
            });




            function loadData() {
                // Clear table headers and rows
                $("#supervisorTable thead").html("");
                $("#supervisorTable tbody").html("");
            
                let sendingData = {
                    action: "readAllsupervisor"
                };
            
                $.ajax({
                    method: "POST",
                    type: "JSON",
                    url: "application/api/supervisor.php",
                    data: sendingData,
                    success: function (data) {
                        let status = data.status;
                        let response = data.data;
            
                        if (status) {
                            let th = "<tr>";
                            let tr = "";
            
                            response.forEach((item, index) => {
                                // Dynamically generate table headers, excluding 'id'
                                if (index === 0) {
                                    for (let key in item) {
                                        if (key !== "id") { // Skip the 'id' column
                                            th += `<th>${key}</th>`;
                                        }
                                    }
                                    th += "<th>Action</th></tr>";
                                }
            
                                // Generate table rows, excluding 'id'
                                tr += "<tr>";
                                for (let key in item) {
                                    if (key !== "id") { // Skip the 'id' column
                                        tr += `<td>${item[key]}</td>`;
                                    }
                                }
            
                                // Add action buttons
                                tr += `
                                    <td>
                                        <a class="label theme-bg2 text-white f-12 update_info" update_id="${item['id']}">
                                            <i class="fas fa-edit" style="color:#fff"></i>
                                        </a> &nbsp; &nbsp;
                                        <a class="label theme-bg text-white f-12 delete_info" delete_id="${item['id']}">
                                            <i class="fas fa-trash" style="color:#fff"></i>
                                        </a>
                                    </td>
                                `;
                                tr += "</tr>";
                            });
            
                            // Append the headers and rows to the table
                            $("#supervisorTable thead").append(th);
                            $("#supervisorTable tbody").append(tr);
                        }
                    },
                    error: function (data) {
                        displayMessege("error", data.data);
                    }
                });
            }
            


            function fetch_user(id) {
                let sendingData = {
                    action: "read_userNFO",
                    id: id
                };
            
                $.ajax({
                    method: "POST",
                    dataType: "JSON",
                    url: "application/api/supervisor.php",
                    data: sendingData,
                    success: function(response) {
                        if (response.status) {
                            let data = response.data;
            
                            btnaction = "Update";
                            // Populate the modal fields with fetched data
                            $("#student_id").val(data.id);
                            $("#full").val(data.full_name);
                            $("#degree").val(data.degree_information);
                            $("#experience").val(data.experience);
            
            
                            
                            $("#user_model").modal("show");
                        } else {
                            console.log("Error: ", response.data);
                        }
                    },
                    error: function() {
                        console.log("Failed to fetch data");
                    }
                });
            }

            function deletestudent(id) {
                let sendDate = {
                    "action": "deleteStudent",
                    "id": id
                };
            
                // AJAX request to delete student
                $.ajax({
                    type: "POST",
                    url: "application/api/supervisor.php",
                    dataType: "JSON",
                    data: sendDate,
                    success: function(data) {
                        let status = data.status;
                        let response = data.data;
            
                        if (status) {
                            swal("Good job!", response, "success");
                            console.log("Successful deletion");
                            loadData(); // Reload table data
                        } else {
                            swal("Error", response, "error");
                            console.log("Failed to delete data: " + response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX error:", status, error);
                        console.log(xhr.responseText); // Log server response for debugging
                    }
                });
            }


            // function loadData(){

            //     $("#userTable tbody").html("");
            
            //     let sendingData={
            //         action : "readAlluser"
            
            //     }
            
            //     $.ajax({
            //         method:"POST",
            //         type:"JSON",
            //         url:("application/api/supervisor.php"),
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
                                        
            //                                 tr +=`<td> <img style="width:60px; border:1px solid #e3ebe7; height:60px; border-radius:50%; margin-left:20px; object-fit:cover" src="application/uploads/${item[res]}" > </td>`;
                            
                                        
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
            //                 $("#userTable thead").append(th);
            //                 $("#userTable tbody").append(tr);
            //             }
            
            //         },
            //         error : function(data){
            //             displayMessege("error",reponse);
            
            //         }
            
            //     })
            
            // }


            function displayMessege(type, messege) {
                let success = document.querySelector(".alert-success");
                let error = document.querySelector(".alert-danger");
            
                if (type === "success") {
                    error.classList = "alert alert-danger d-none";  // Hide error
                    success.classList = "alert alert-success";  // Show success
                    success.innerHTML = messege;  // Display the success message
            
                    // Automatically hide after 3 seconds
                    setTimeout(function() {
                        $("#user_model").modal("hide");
                        $("#supervisor_form")[0].reset();
                        success.classList = "alert alert-success d-none";
                    }, 3000);
                } else {
                    success.classList = "alert alert-success d-none";  // Hide success
                    error.classList = "alert alert-danger";  // Show error
                    error.innerHTML = messege;  // Display the error message
            
                    // Automatically hide after 3 seconds
                    setTimeout(function() {
                        error.classList = "alert alert-danger d-none";
                    }, 3000);
                }
            }
            





            $("#supervisorTable").on("click", "a.update_info", function(event) {
                event.preventDefault();  // Prevent default link behavior
                let id = $(this).attr("update_id");  // Get the ID of the student to update
               
                fetch_user(id);  // Fetch the student's information
            });



            
            $("#supervisorTable").on("click", "a.delete_info", function(event) {
                event.preventDefault();  
            
                let id = $(this).attr("delete_id");
                // alert(id); 

                if (confirm("Are you sure you want to delete?")) {
                    deletestudent(id); 
                }
            });






    

    })

})