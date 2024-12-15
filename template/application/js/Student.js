
$(".get_student").click(function(e){
    e.preventDefault();

     var url=$(this).attr("href");
    $.post(url,function(ress){
    $(".form-place").html(ress);


    loadData();
    //  console.log("Requesting URL:", url);

    $("#add_New").on("click",function(event){
        event.preventDefault();

        $("#project_model").modal("show");
    })


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
                    $("#projectTable tbody").html(tr); // Reset table body
                    
                    
                    
                    
                    
                    
                }
    
            },
            error : function(data){
                displayMessege("error");
    
            }
    
        })
    
    }

    $(document).ready(function() {
      $("#searchButton").click(function() {
    let projectTitle = $("input[name='']").val().trim();

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
    
            
    
    




   

    
})
})








