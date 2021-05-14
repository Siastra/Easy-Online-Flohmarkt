<script>
    $(document).ready(function () {
        let x = document.getElementsByTagName("TITLE")[0];
        x.innerHTML = "Login page";
    });
</script>
<section id="LoginBody">
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card card-login">
                <div class=" card-header card-header-login">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <form method="get" action="backend/userHandling.php">
                        <input type="hidden" name="type" value="login">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="email" name="email" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="Password" name="pw">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Login" class="btn float-right login_btn" required>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        Don't have an account?<a href="index.php?section=register">Register</a>
                    </div>
                    <div class="d-flex justify-content-center links">
                        Forgot your password?<a href="index.php?section=forgotPw">Change password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>