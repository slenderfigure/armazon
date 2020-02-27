<?php
    include 'header.php';
    
    if (isset($_SESSION['login'])) {
        header('Location: userpage.php');
    } 
?>
<main>
    <section class="signin-container">
        <h3>Sign In</h3>

        <form action="<?php echo htmlspecialchars('include/signin.inc.php')?>" 
        method="post" name="signForm">
            
            <div class="row">
                <label for="login">Email (phone for mobile accounts)</label>
                <?php
                if (!isset($_GET['login'])) {
                    echo '<input class="form-input" type="text" 
                        name="login" autofocus>';
                } else {
                    $login = $_GET['login'];
                    echo '<input class="form-input" type="text" 
                        name="login" value="'.$login.'" autofocus>';
                }
                ?>
            </div>
            <div class="row">
                <label for="password">Password</label>
                <input class="form-input" type="password" name="password">
            </div>
            <div class="row">
                <input type="hidden" name="signin-submit" value="signin">
                <button class="btn btn-l" type="submit">Sign In</button>
            </div>
        </form>

        <div class="signup-box">
            <div class="caption-already-member">
                <span>Not yet a memember?</span>
            </div>
            <a class="btn" href="signup.php">Create your Armazon account</a>
        </div>
    </section>
</main>

<script src="src/js/signin.js"></script>
<?php
    include 'footer.html';
?>  