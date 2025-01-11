<?php
session_start();

?>
<div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>project-taken page</h5>
                                            <span class="d-block m-t-5">Innovation is the catalyst for growth.</span>
                                        </div>
                                        <div class="card-block table-border-style">

                                            

                                        <div class="row">
                                            <div class="col-12">

                                                     
                                                        <form action="" id="userForm">

                                                        

                                                            <div class="row justify-content-center mb-3">
                                                            <div class="col-sm-2">
                                                            </div>
                                                            
                                                            <div class="col-sm-4">
                                                            <input type="text" name="projectTitle"  class="form-control">
                                                            </div>

                                                            

                                                            <div class="col-sm-3">
                                                            <button type="button" id="searchButton" class="btn btn-info  text-white pt-2"> Saarch</button>
                                                            </div>
                                                        
                                                            <div class="col-sm-3">
                                                            <button type="submit" id="add_apply" class="btn btn-secondary text-white pt-2 float-right">Apply New project</button>
                                                            </div>
                                                            </div>
                                                        </form>

                                                        <div class="alert alert-success d-none"></div>
                                                        <div class="alert alert-danger d-none"></div>
                                            </div>
                                            
                                        </div>


                                            <div class="table-responsive">
                                                <table class="table table-hover" id="projectTable">
                                                    <thead  class=" theme-bg  text-white" >
                                                      
                                                    </thead>
                                                    <tbody>
                                                     
                                                    </tbody>
                                                </table>

                                                <div class="modal" tabindex="-1" id="project_model">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                        <div class="modal-header">
                                                                    <h5 class="modal-title">Leader Registration</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                <div class="modal-body">
                                                    <form method="post" id="user_form" enctype="multipart/form-data">

                                                       <div class="row">
                                                            <div class="col-12">
                                                                <div class="alert alert-success d-none" role="alert">
                                                                A simple success alert—check it out!
                                                                </div>
                                                                <div class="alert alert-danger d-none" role="alert">
                                                                A simple danger alert—check it out!
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label for="">Project Title</label>
                                                                            <input type="text" name="Project" id="Project" class="form-control">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            
                                                                            <input type="" name="user_id" id="user_id" value="<?php echo isset($_SESSION['student_id']) ? $_SESSION['student_id'] : ''; ?>" class="form-control" required readonly>
                                                                        </div>
                                                                    
                                                                        <!-- <div class="form-group">
                                                                            <label for="">Project discription</label>
                                                                            <input type="test" name="passward" id="passward" class="form-control">
                                                                        </div> -->
                                                                        <div class="form-group">
                                                                            <label for="">Leader Name</label>
                                                                            <input type="text" name="leader" id="leader" class="form-control">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Group Name</label>
                                                                            <input type="text" name="Group_Name" id="Group_Name" class="form-control">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Members</label>
                                                                            <textarea class="form-control" id="members" name="members"  rows="1"></textarea>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Language Build</label>
                                                                            <input type="text" name="Language" id="Language" class="form-control">
                                                                        </div>

                                                                   


                                                                      

                                                                        

                                                            </div>

                                                            
                                                                
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Apply</button>
                                                            </div>
                                                            </div>

                                                            
                                                        </div>
                                                        </div>

                                                        
                                                            
                                                    </form>
                                                </div>
                                                
                                                </div>
                                            </div>
                                            </div>
                                            </div>
                                        </div>

                                               
                                           
                                            </div>
                                            </div>
                                        </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>



