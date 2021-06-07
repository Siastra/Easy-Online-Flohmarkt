<script>
    $(document).ready(function () {
        let x = document.getElementsByTagName("TITLE")[0];
        x.innerHTML = "Forgot password";
    });
</script>
<section id="LoginBody">
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card-login">
                <div class="card-header">
                    <h3>Forgot your password?</h3>
                </div>
                <div class="card-body">
                    <form method="get" action="backend/userHandling.php">
                        <input type="hidden" name="type" value="forgotPassword">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Username" name="username" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Reset password" class="btn float-right forgot_btn" required>
                        </div>
                    </form>
                </div>
                <br><br>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        Your new password will be sent to your email!
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>