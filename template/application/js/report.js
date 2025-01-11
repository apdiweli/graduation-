

$(".get").click(function(e){
    e.preventDefault();

     var url=$(this).attr("href");
    $.post(url,function(ress){
    $(".form-place").html(ress);

    loadData();
   


    function loadData(){

        $("#projectTable tbody").html("");
    
        let sendingData={
            action : "readAllprojects"
    
        }

        
        $.ajax({
            method:"POST",
            type:"JSON",
            url: "application/api/project.php",
            data:sendingData,
            success:function(data){

               
    
                let status=data.status;
                let reponse = data.data;
                let html ='';
                let th='';
                let tr ='';

                
    
                if(status){
                    reponse.forEach(item => {
                        th = "<tr>";
                        for (let i in item) {
                           
                                th += `<th> ${i} </th>`;
                            
                        }
                        th += "<th>Action</th>";
                        th += "</tr>";
                    
                        tr += "<tr>";
                        for (let i in item) {
                            // Skip the 'storing_file' column in the table row
                           
                                tr += `<td> ${item[i]} </td>`;
                            
                        }
                    
                        // Add download button (hides raw file path)
                       
                            tr += `
                                <td>
                                    
                                    &nbsp; &nbsp;
                                    <a class="label theme-bg2 text-white f-12 update_info" update_id="${item['id']}">
                                        <i class="fas fa-edit" style="color:#fff"></i>
                                    </a>
                                    &nbsp; &nbsp;
                                    <a class="label theme-bg text-white f-12  delete_info" delete_id="${item['id']}">
                                        <i class="fas fa-trash" style="color:#fff"></i>
                                    </a>
                                </td>`;
                      
                    
                        tr += "</tr>";
                    });
                    $("#projectTable thead").html(th); // Reset table header
                    $("#projectTable tbody").html(tr); // Reset table body
                    
                    
                    
                    
                    
                    
                }
    
            },
            error : function(data){
                displayMessege("error");
    
            }
    
        })
    
    }
        
    function fetch_user(id) {
        let sendingData = {
            action: "read_userNFO",
            id: id
        };
    
        $.ajax({
            method: "POST",
            dataType: "JSON",
            url: "application/api/project.php",
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
            url: "application/api/project.php",
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



    $("#projectTable").on("click", "a.update_info", function(event) {
        event.preventDefault();  // Prevent default link behavior
        let id = $(this).attr("update_id");  // Get the ID of the student to update
       
        fetch_user(id);  // Fetch the student's information
    });



    
    $("#projectTable").on("click", "a.delete_info", function(event) {
        event.preventDefault();  
    
        let id = $(this).attr("delete_id");
        alert(id); 

        if (confirm("Are you sure you want to delete?")) {
            deletestudent(id); 
        }
    });
    
    




    function displayMessege(type,messege){
        let success=document.querySelector(".alert-success");
        let error=document.querySelector(".alert-danger");
    
        if(type =="success"){
            error.classList="alert alert-danger d-none";
            success.classList="alert alert-success ";
            success.innerHTML=messege;
    
            setTimeout(function(){
               
                // $("#projectForm")[0].reset();
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








