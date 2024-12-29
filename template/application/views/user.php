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

                                           
                                            <button class="btn btn-secondary float-left" id="Addstudent">student Registration</button>
                                            <button class="btn btn-primary float-right" id="AddNew">Add New User</button>
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="userTable">
                                                    <thead  class=" bg-success  text-white" >
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
                                                    <h5 class="modal-title">Leader Registration</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" id="user_form">
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
                                                                <label for="">username</label>
                                                                <input type="text" name="username" id="username" class="form-control">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">Student_id</label>
                                                                <input type="text" name="Student_id" id="Student_id" class="form-control">
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="">passward</label>
                                                                <input type="password" name="passward" id="passward" class="form-control">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">Email</label>
                                                                <input type="email" name="Email" id="Email" class="form-control">
                                                            </div>


                                                            <div class="form-group">
                                                                <label for="">file</label>
                                                                <input type="file" name="image" id="image" class="form-control">
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-4"> </div>
                                                                <div class="col-sm-4"> 
                                                                        <div class="form-group justify-content-center">
                                                                        <img src="" alt="" id="show">
                                                                        </div>

                                                                 </div>
                                                                
                                                            
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




                                        <div class="modal" tabindex="-1" id="student_registration">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Student  Registration</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" id="student_form">
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
                                                                <label for="">Name</label>
                                                                <input type="text" name="fname" id="fname" class="form-control">
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="">Faculty</label>
                                                                <input type="text" name="Faculty" id="Faculty" class="form-control">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">Department</label>
                                                                <input type="text" name="Department" id="Department" class="form-control">
                                                            </div>


                                                            <div class="form-group">
                                                                <label for="">address</label>
                                                                <input type="text" name="address" id="address" class="form-control">
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


                                