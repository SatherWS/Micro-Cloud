<?php
    $login_link = "";
    $signup_link = "";

    if (isset($_POST["query"])) {
        $login_link = "../authentication/login.php";
        $signup_link = "../authentication/register.php";
    }
    else {
        $login_link = "./authentication/login.php";
        $signup_link = "./authentication/register.php";
    }
?>
<nav class="topnav" id="myTopnav">
    <div class="index-nav parent-nav">
        <ul>
            <li>
                <a href="#" class="active">Swoop CTMS</a>
                <i class="fa fa-wifi"></i>
            </li>
        </ul>
        <ul class="topnav-list">
            <li>
                <a href="<?php echo $login_link;?>">Login</a>
            </li>
            <li>
                <a href="<?php echo $signup_link;?>">Register</a>
            </li>
            <a href="javascript:void(0);" class="icon" onclick="navToggle()">
                <i class="fa fa-bars"></i>
            </a>
        </ul>
    </div>
</nav>