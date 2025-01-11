<style>
    #show {
        width: 150px;
        height: 150px;
        border: solid 1px #744547;
        border-radius: 50%;
        object-fit: cover;
    }

    .theme-bg {
        background-color: #744547; /* Example color */
    }

    .theme-bg2 {
        background-color: #f8f9fa; /* Example color */
    }
</style>

<div class="col-xl-12">
    <div class="card">
        <div class="card-header">
            <h4>User Information Table</h4>
            <span class="d-block mt-2">
                View and manage detailed information about all registered users below.
            </span>
        </div>

        <div class="card-block table-border-style">
            <button
                class="theme-bg2 p-2 border border-0 mb-3 text-dark fw-bolder f-12 float-right rounded-pill"
                id="AddNew"
            >
                Add New User
            </button>

            <div class="table-responsive">
                <table class="table table-hover" id="userTable">
                    <thead class="theme-bg text-white">
                        <tr>
                            <!-- Add table headers here -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Add table rows dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- User Registration Modal -->
<div class="modal" tabindex="-1" id="user_model">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Leader Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="post" id="user_form">
                    <div class="alert alert-success d-none" role="alert">
                        A simple success alert—check it out!
                    </div>
                    <div class="alert alert-danger d-none" role="alert">
                        A simple danger alert—check it out!
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="Student_id">Student ID</label>
                        <input type="text" name="Student_id" id="Student_id" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" name="Email" id="Email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="image">File</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <div class="text-center mt-3">
                        <img src="" alt="Preview" id="show">
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

<!-- Fetch User Modal -->
<div class="modal" tabindex="-1" id="fetch_model">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">update User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="fetch_form">
                    <div class="form-group">
                        <label for="username_fetch">Username</label>
                        <input type="text" name="username_fetch" id="username_fetch" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="Student_id_fetch">Student ID</label>
                        <input type="text" name="Student_id_fetch" id="Student_id_fetch" class="form-control">
                    </div>

                    

                    <div class="form-group">
                        <label for="Email_fetch">Email</label>
                        <input type="email" name="Email_fetch" id="Email_fetch" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="image_fetch">File</label>
                        <input type="file" name="image_fetch" id="image_fetch" class="form-control">
                    </div>

                    <div class="text-center mt-3">
                        <img src="" alt="Preview" id="show">
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
