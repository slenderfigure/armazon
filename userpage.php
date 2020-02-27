<?php
    include 'header.php';

    if (!isset($_SESSION['login'])) {
        header('Location: signin.php');
        exit();
    }
?>
<main>
    <div class="userpage-wrapper wrapper">
        <ul class="user-options">
            <li><a class="active-link" href="userpage.php">Account Information</a></li>
            <li><a href="#">My Orders</a></li>
            <li><a href="#">Wish list</a></li>
            <?php
            if ($details->seller) {
                echo '
                <li><a href="viewmylistings.php">View my listings</a></li>
                <li><a href="createproductlisting.php">Create new listing</a></li>';
            } else {
                echo '
                <li><a href="becomeaseller.php">Become a seller</a></li>';
            }
            ?>
        </ul>

        <section class="control-panel">
        <?php
            echo '
            <h2>Hi, '.$details->fullName.'</h2>

            <div class="info-card">';
                echo '
                <div class="user-avatar">
                    <img src="'.$details->avatar.'?'.mt_rand().'" 
                    alt="'.$details->fullName.'">
                    
                    <label class="avatar-btn overlay">
                        <i class="fas fa-pen"></i>
                        <input type="file" name="avatar" form="avatarForm">
                    </label>
                </div>
                <p>You\'ve been a member since '
                .date('Y', strtotime($details->acct_creation)).'</p>';

                if ($details->seller) {
                    echo '<span class="seller-icon">Certified Armazon Seller<span>';
                }
            echo '</div>';
        ?>

            <form action="include/update_avatar.inc.php" method="post" 
            name="avatarForm" id="avatarForm" enctype="multipart/form-data">
                <input type="hidden" name="userlogin" 
                value="<?php echo $_SESSION['login']?>">
            </form>
        </section>
    </div>
</main>

<script src="src/js/userpage.js"></script>
<?php
    include 'footer.html';
?>  