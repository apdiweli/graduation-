

btnAction = "Insert";
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

            // $("#Addstudent").on("click",function(){
            //     $("#student_registration").modal("show");
            // })

            // alert(44);

            // $("#user_form").on("submit",function(e){
            //         e.preventDefault();
                    

            //         let form_data =new FormData($("#user_form")[0]);
            //         form_data.append("image",$("input[type =file]")[0].files[0]);

            //         form_data.append("action","register_user");
                    

                    
                

            //         $.ajax({
            //             method:"POST",
            //             type:"JSON",
            //             url:("application/api/user.php"),
            //             data:form_data,
            //             processData :false,
            //             contentType :false,
            //             success:function(data){
            //                 let status=data.status;
            //                 let reponse = data.data;
            //                 if(status){
            //                     displayMessege("success",reponse);
            //                     $("#user_model").modal("hide");
            //                     $("#user_form")[0].reset();
            //                     loadData();
                                
            //                 }
            //                 else{
            //                     displayMessege("error",reponse);
            //                 }

            //             },
            //             error :function(data){
            //                 displayMessege("error",reponse);
            //             }

                        


            //         })

            // })

            //  $(document).ready(function () {
            
            // $("#student_form").on("submit", function(e) {
            //     e.preventDefault();
            //     console.log(78456348);
            
                
            //     const formElement = $(this).is("form") ? $(this)[0] : $(this).find("form")[0];
            
            //     // if (!formElement) {
            //     //     console.error("No form element found within #modal-class");
            //     //     return;
            //     // }
            
              
            //     let fromdate = new FormData(formElement);
            //     fromdate.append("image", $("input[type=file]")[0]?.files[0]); 
            
               
            //     if (btnAction === "Insert") {
            //         fromdate.append("action", "student_registration");
            //     } else 
            //    // if (btnAction === "update") 
            //     {  
            //         const studentId = $("#update_id").val(); 
            //         fromdate.append("action", "update_user");
            //         fromdate.append("id", studentId); 
                     
            //     }
            
            //     $.ajax({ 
            //         type: "POST",
            //         url: "application/api/user.php",
            //         data: fromdate,
            //         dataType: "json",
            //         processData: false,
            //         contentType: false,
            //         success: function(response) {
            //             // let status = data.status;
            //             // let response = data.data;
            //             // console.log(response.error);
            
            //             if (response.status = "success") {
            //                 Swal.fire({
            //                     title: response.data,
            //                     icon: "success"
            //                 });
            //                 // loadData();
            //                 $('#student_from')[0].reset();
            //                 btnAction = "Insert";
            //             } else if (response.status = "error") {
            //                 // console.log(response);
            //                 Swal.fire({
            //                     title: response.data,
            //                     icon: "error"
            //                 });
            //             }
            //         },
            //         error: function(data) {
            //             console.log("error", data);
            //         }
            //     });
            // });
            //  });
            

            $(document).ready(function () {
                $("#student_form").on("submit", function (e) {
                    e.preventDefault();
            
                    let form_data = new FormData($("#student_form")[0]);
                    form_data.append("action", "student_registration");
            
                    $.ajax({
                        method: "POST",
                        url: "application/api/user.php",
                        data: form_data,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                             // Parse JSON response
                            let status = data.status;
                            let reponse = data.data;
            
                            if (status) {
                                displayMessege("success", reponse);
                                $("#student_form")[0].reset();
                                // loadData();
                                setTimeout(() => {
                                    $("#student_registration").modal("hide");
                                }, 2000)
                            } else {
                                displayMessege("error", reponse);
                            }
                        },
                        error: function () {
                            displayMessege("error", "An error occurred while submitting the form.");
                        },
                    });
                });
            });
            






            // student_name();

            // function student_name(){
            
               
            
            //     let sendingData = {
            //         "action" : "readAlluser"
            //     }
            
            //     $.ajax( {
            //         method: "POST",
            //         dataType: "JSON",
            //         url : "application/api/registartion_student.php",
            //         data : sendingData,
            //         success: function(data){
            
            //             let status = data.status;
            //             let response = data.data;
            //             let html = '';
            //             let tr = '';
            
            //             if(status){
            
                            
            //                 response.forEach( res => {
            
            //                    html += <option value="${res['student_id']}">${res['student_name']}</option>;
            //                 })
            
            //                 $("#class_id").append(html);
            
                          
            //             }else{
            //                 alert("error",response);
            //             }
                       
            
            //         },
            //         error: function(data){
            
            //         }
            //     })
            
            // }
            
            
            

      



            function loadData() {
                $("#userTable tbody").html("");
                $("#userTable thead").html("");
            
                let sendingData = {
                    action: "readAlluser"
                };
            
                $.ajax({
                    method: "POST",
                    type: "JSON",
                    url: "application/api/user.php",
                    data: sendingData,
                    success: function(data) {
                        let status = data.status;
                        let response = data.data;
                        let html = '';
                        let th = '';
                        let tr = '';
            
                        if (status) {
                            response.forEach((item, index) => {
                                // Create table headers (only once)
                                if (index === 0) {
                                    th = "<tr>";
                                    for (let i in item) {
                                        if (i !== "id") { // Skip 'id' column
                                            th += `<th>${i}</th>`;
                                        }
                                    }
                                    th += "<th>Action</th>";
                                    th += "</tr>";
                                    $("#userTable thead").append(th);
                                }
            
                                // Create table rows
                                tr += "<tr>";
                                for (let res in item) {
                                    if (res === "image") {
                                        tr += `<td>
                                            <img style="width:60px; border:1px solid #e3ebe7; height:60px; border-radius:50%; margin-left:20px; object-fit:cover" 
                                                 src="application/uploads/${item[res]}" />
                                           </td>`;
                                    } else if (res !== "id") { // Skip 'id' column
                                        tr += `<td>${item[res]}</td>`;
                                    }
                                }
            
                                // Add action buttons
                                tr += `<td>
                                        <a class="label theme-bg2 text-white f-12 update_info" update_id="${item['id']}">
                                            <i class="fas fa-edit" style="color:#fff"></i>
                                        </a> &nbsp; &nbsp;
                                        <a class="label theme-bg text-white f-12 delete_info" delete_id="${item['id']}">
                                            <i class="fas fa-trash" style="color:#fff"></i>
                                        </a>
                                       </td>`;
                                tr += "</tr>";
                            });
            
                            $("#userTable tbody").append(tr);
                        }
                    },
                    error: function(data) {
                        displayMessege("error", "Failed to load data.");
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
                    url: "application/api/user.php",
                    data: sendingData,
                    success: function(response) {
                        if (response.status) {
                            let data = response.data;
            
                            // Populate the modal fields with fetched data
                            $("#username_fetch").val(data.username);
                            $("#Student_id_fetch").val(data.student_id);
                            $("#Email_fetch").val(data.email);
            
                            // Update image preview
                            if (data.image) {
                                let fullPath = "application/uploads/" + data.image;
                                $("#image_fetch").attr("src", fullPath).show();
                            } else {
                                $("#image_fetch").attr("src", "application/uploads/default.png").show();
                            }
            
                            // Show the modal
                            $("#fetch_model").modal("show");
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
                    url: "application/api/user.php",
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


            $("#userTable").on("click", "a.update_info", function(event) {
                event.preventDefault();  // Prevent default link behavior
                let id = $(this).attr("update_id");  // Get the ID of the student to update
                alert(id);
                fetch_user(id);  // Fetch the student's information
            });



            
            $("#userTable").on("click", "a.delete_info", function(event) {
                event.preventDefault();  
            
                let id = $(this).attr("delete_id");
                console.log(id); 
                if (confirm("Are you sure you want to delete?")) {
                    deletestudent(id); 
                }
            });
            




            // $(document).on("click", ".reset_password", function () {
            //     let userId = $(this).attr("reset_id");

            //     console.log("User ID:", userId); // Debug log
            
            //     let sendingData = {
            //         action: "resetPassword",
            //         id: userId
            //     };
            
            //     $.ajax({
            //         method: "POST",
            //         type: "JSON",
            //         url: "application/api/user.php",
            //         data: sendingData,
            //         success: function (data) {
            //             let status = data.status;
            //             let message = data.message;
            //             let newPassword = data.new_password; // Extract the new password
            
            //             if (status) {
            //                 displayMessege("success", message);
            
            //                 // Show the new password to the user
            //                 alert(`The new password is: ${newPassword}`);
            //             } else {
            //                 displayMessege("error", message);
            //             }
            //         },
            //         error: function () {
            //             displayMessege("error", "Something went wrong.");
            //         }
            //     });
            // });


            // $("#userTable").on("click", "a.reset_password", function(event) {
            //     event.preventDefault();  // Prevent default link behavior
            //     let id = $(this).attr("reset_id");  // Get the ID of the student to update
            //     alert(id)
            // });

            // $("#userTable").on("click", "a.update_info", function(event) {
            //     event.preventDefault();  // Prevent default link behavior
            //     let id = $(this).attr("update_id");  // Get the ID of the student to update
            //    alert(id)  // Fetch the student's information
            // });
            

            function displayMessege(type, message) {
                // Select the correct alert box based on type
                let alertBox = type === "success" ? ".alert-success" : ".alert-danger";
            
                // Update the alert box text and make it visible
                $(alertBox).text(message).removeClass("d-none");
            
                // Automatically hide the alert after 3 seconds
                setTimeout(() => {
                    $(alertBox).addClass("d-none");
                }, 4000);
            }


            // $("#userTable").on("click", "a.delete_info", function(event) {
            //     event.preventDefault();  
                
            //     let id = $(this).attr("delete_id");
            //     console.log(id); 
            //     if(confirm("Are Sure to delete")){
            //         deletestudent(id); 
            //     } 
                 
            // });
            



    

    })

})