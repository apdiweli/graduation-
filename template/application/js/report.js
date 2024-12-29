

$(".get").click(function(e){
    e.preventDefault();

     var url=$(this).attr("href");
    $.post(url,function(ress){
    $(".form-place").html(ress);

    loadData();
    //  console.log("Requesting URL:", url);


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
                            // Skip the 'storing_file' column in the table header
                            if (i !== 'storing_file') {
                                th += `<th> ${i} </th>`;
                            }
                        }
                        th += "<th>Action</th>";
                        th += "</tr>";
                    
                        tr += "<tr>";
                        for (let i in item) {
                            // Skip the 'storing_file' column in the table row
                            if (i !== 'storing_file') {
                                tr += `<td> ${item[i]} </td>`;
                            }
                        }
                    
                        // Add download button (hides raw file path)
                        if (item['storing_file']) {
                            tr += `
                                <td>
                                    <a href="${item['storing_file']}" class="btn btn-primary" download>
                                        <i class="fas fa-download"></i>
                                    </a>
                                    &nbsp; &nbsp;
                                    <a class="btn btn-info update_info" update_id="${item['id']}">
                                        <i class="fas fa-edit" style="color:#fff"></i>
                                    </a>
                                    &nbsp; &nbsp;
                                    <a class="btn btn-danger delete_info" delete_id="${item['id']}">
                                        <i class="fas fa-trash" style="color:#fff"></i>
                                    </a>
                                </td>`;
                        } else {
                            tr += `
                                <td>
                                    No file available
                                    &nbsp; &nbsp;
                                    <a class="btn btn-info update_info" update_id="${item['id']}">
                                        <i class="fas fa-edit" style="color:#fff"></i>
                                    </a>
                                    &nbsp; &nbsp;
                                    <a class="btn btn-danger delete_info" delete_id="${item['id']}">
                                        <i class="fas fa-trash" style="color:#fff"></i>
                                    </a>
                                </td>`;
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








