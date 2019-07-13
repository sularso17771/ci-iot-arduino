                {MESSAGES}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{SUBTITLE}</strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                {DATA_ENTRY}
                                <form method="POST" action="users_profil">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" class="form-control fullname" name="login_name" value="{login_name}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control username" name="login_username" value="{login_username}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input type="text" class="form-control username" name="login_email" value="{login_email}">
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info btn-fill pull-right" id="update">Update Profile</button>

                                    <div class="clearfix"></div>

                                </form>
                                {/DATA_ENTRY}
                            </div>
                        </div> <!-- .card -->

                    </div><!--/.col-->


                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{SUBTITLE_SECOND}</strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->

                                <form method="POST" action="users_pass">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control password" name="login_password">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control password" name="confirm_password">
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info btn-fill pull-right" id="update">Update Password</button>

                                    <div class="clearfix"></div>

                                </form>
                            </div>
                        </div> <!-- .card -->

                    </div><!--/.col-->

                </div>