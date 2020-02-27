<?php
    include 'header.php';
?>
<main>
    <section class="signin-container">
        <h3>Create account</h3>

        <form action="<?php echo htmlspecialchars('include/signup.inc.php')?>" 
        method="post" name="signupForm">
            <div class="row">
                <label for="fullname">Your name</label>
                <input class="form-input" type="text" name="fullname" autofocus>
            </div>
            <div class="row">
                <label for="email">Email (phone for mobile accounts)</label>
                <input class="form-input" type="text" name="email">
            </div>
            <div class="row">
                <label for="password">Password</label>
                <input class="form-input" type="password" name="password">
            </div>
            <div class="row">
                <label for="repassword">Re-enter password</label>
                <input class="form-input" type="password" name="repassword">
            </div>
            <div class="row">
                <input type="hidden" name="signup-submit" value="signup">
                <button class="btn btn-l" type="submit">Create your Armazon account</button>
            </div>

            <div class="signin-box">
                <span>Already a member?</span>
                <a class="btn" href="signin.php">Sign In</a>
            </div>
        </form>
    </section>
</main>

<script src="src/js/signup.js"></script>
<?php
    include 'footer.html';
?>  