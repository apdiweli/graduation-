<style>
                                                #show{
                                                    width: 150px;
                                                    height:150px;
                                                    border :solid 1px #744547;
                                                    border-radius :50%;
                                                    object-fit :cover;
                                                }
                                            </style>

                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Hover Table</h5>
                                            <span class="d-block m-t-5">use class <code>table-hover</code> inside table element</span>
                                        </div>
                                        <div class="card-block table-border-style">

                                         
                                            <button class="btn btn-primary float-right" id="AddNew">Add New Supervisor</button>
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="supervisorTable">
                                                    <thead  class=" theme-bg  text-white" >
                                                    <tr>
                                                        
                                                       </tr> 
                                                    </thead>
                                                    <tbody>
                                                     
                                                    </tbody>
                                                </table>

                                                <div class="modal" tabindex="-1" id="user_model">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Teacher Registration</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" id="supervisor_form">
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
                                                                
                                                                <input type="hidden" name="student_id" id="student_id" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">full_name</label>
                                                                <input type="text" name="full" id="full" class="form-control">
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="">degree_information</label>
                                                                <input type="degree" name="degree" id="degree" class="form-control">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">experience</label>
                                                                <input type="text" name="experience" id="experience" class="form-control">
                                                            </div>


                                                            

                                       

                                                            
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
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