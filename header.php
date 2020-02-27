<?php
    session_start();
    include_once 'include/get_account_info.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Online Store, MDN Challenge #2</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="src/css/reset_style.css">
    <link rel="stylesheet" href="src/css/style.css">
    <script src="https://kit.fontawesome.com/56a075a703.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <form action="<?php echo htmlspecialchars('include/signout.inc.php')?>" 
        method="post" id="signoutForm"></form>

        <nav class="main-nav">
            <a class="logo" href="index.php">Armazon</a>
            
            <?php
                if (!isset($_SESSION['login'])) {
                    echo '<a href="signin.php" 
                    class="account-icon fas fa-user-circle" title="Sign In"></a>';
                } else {
                    $details = getAccountInfo();

                    echo '
                    <div class="dropdown-wrapper">
                        <div class="account-icon acct-avatar-thumbnail" 
                        title="'.$details->fullName.'">
                            <img src="'.$details->avatar.'?'.mt_rand().'" draggable="false">
                        </div>

                        <ul class="dropdown">
                            <li><a href="userpage.php">Your Account</a></li>

                            <li><a href=#>Manage Settings</a></li>
                            <li>
                                <button class="logout" type="submit" 
                                name="signout-submit" value="signout-submit" form="signoutForm">
                                    Sign Out
                                    <i class="material-icons">&#xe879;</i>
                                </button>
                            </li>
                        </ul>
                    </div>';
                }
            ?>
        </nav>
    </header>