
$(".get_student").click(function(e){
    e.preventDefault();

     var url=$(this).attr("href");
    $.post(url,function(ress){
    $(".form-place").html(ress);


    loadData();
    //  console.log("Requesting URL:", url);



    function loadData(){

        $("#projectTable tbody").html("");
    
        let sendingData={
            action : "readAllproject"
    
        }

       

        
        $.ajax({
            method:"POST",
            type:"JSON",
            url: "application/api/student.php",
            data:sendingData,
            success:function(data){

                

               
    
                let status=data.status;
                let reponse = data.data;
                let html ='';
                let th='';
                let tr ='';

                console.log(status);
    
                if(status){
                    reponse.forEach(item => {
                        th = "<tr>";
                        for (let i in item) {
                           
                                th += `<th> ${i} </th>`;
                
                        }
                       
                        th += "</tr>";
                    
                        tr += "<tr>";
                        for(let res in item){
                        tr +=`<td> ${item [res]} </td>`;
                        }


                       
                    
                     
                       
                    
                        tr += "</tr>";
                    });
                    $("#projectTable thead").html(th); // Reset table header
                    $("#projectTable tbody").html(tr); // Reset table bodys
                    
                    
                    
                    
                    
                    
                }
    
            },
            error : function(data){
                displayMessege("error");
    
            }
    
        })
    
    }

    $(document).ready(function() {
      $("#searchButton").click(function() {

        
       
    let projectTitle = $("input[name='projectTitle']").val().trim();

    

    if (projectTitle === "") {
        displayMessage("error", "Please enter a project title to search.");
       
        return;
    }

   
    
   

    let sendingData = {
        action: "searchProjectByTitle",
        title: projectTitle
    };

    $.ajax({
        method: "POST",
        url: "application/api/student.php",
        data: sendingData,
        dataType: "JSON",
        success: function(data) {
            let status = data.status;
            let response = data.data;

            if (status) {
                let html = '';
                let th = '';
                let tr = '';

                response.forEach(item => {
                    th = "<tr>";
                    for (let i in item) {
                        th += `<th>${i}</th>`;
                    }
                    th += "</tr>";
                    

                    tr += "<tr>";
                    for (let res in item) {
                        tr += `<td>${item[res]}</td>`;
                    }
                    tr += "</tr>";
                });

                $("#projectTable thead").html(th); // Reset table header
                $("#projectTable tbody").html(tr); // Reset table body
                // displayMessage("success", "Projects found successfully.");
            } else {
                displayMessage("error", response);
                $("#projectTable thead").html(""); // Clear table header
                $("#projectTable tbody").html(""); // Clear table body
            }
        },
        error: function() {
            displayMessage("error", "An error occurred while searching for the project.");
        }
    });
});

    
        function displayMessage(type, message) {
            let success = $(".alert-success");
            let error = $(".alert-danger");
    
            if (type === "success") {
                error.addClass("d-none");
                success.removeClass("d-none").text(message);
                setTimeout(() => success.addClass("d-none"), 3000);
            } else {
                error.removeClass("d-none").text(message);
            }
        }
    });

    
    $("#add_apply").on("click",function(event){
        event.preventDefault();
        $("#project_model").modal("show");
    })



    $("#user_form").on("submit", function (event) {
        event.preventDefault(); // Prevent default form submission
    
        let form_data = new FormData(this); // Create FormData object from the form
        form_data.append("action", "applyProject"); // Add the action parameter
    
        // Show a loading message or disable the submit button (optional)
        let submitButton = $(this).find("button[type='submit']");
        submitButton.prop("disabled", true).text("Submitting...");
    
        // Send AJAX request
        $.ajax({
            method: "POST",
            url: "application/api/apply_project.php",
            data: form_data,
            processData: false, // Prevent jQuery from automatically processing the data
            contentType: false, // Tell jQuery not to set contentType header
            dataType: "json", // Expect JSON response
            success: function (data) {
                let status = data.status;
                let response = data.data;
    
                if (status) {
                    displayMessege("success", response); // Display success message
                    $("#user_form")[0].reset(); // Reset the form
                    loadData(); // Refresh data if applicable
                } else {
                    displayMessege("error", response); // Display error message
                }
            },
            error: function (xhr, status, error) {
                // Handle unexpected errors
                console.error("AJAX Error:", error);
                displayMessege("error", "An unexpected error occurred.");
            },
            complete: function () {
                // Re-enable the submit button and reset text
                submitButton.prop("disabled", false).text("Apply");
            },
        });
    });
    
    

    
    function displayMessege(type,messege){
        let success=document.querySelector(".alert-success");
        let error=document.querySelector(".alert-danger");
    
        if(type =="success"){
            error.classList="alert alert-danger d-none";
            success.classList="alert alert-success ";
            success.innerHTML=messege;
    
            setTimeout(function(){
                $("#project_model").modal("hide");
                $("#user_form")[0].reset();
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








