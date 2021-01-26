<nav class="topnav" id="myTopnav">
    <div class="index-nav parent-nav">
        <ul>
            <li>
                <!-- Team Steep vs. Team Stoop -->
                <a href="#" class="active">Swoop CTMS</a>
                <i class="fa fa-wifi"></i>
            </li>
        </ul>
        <ul class="topnav-list">
            <li class="dropdown">
                <a href="javascript:void(0)">Explore</a>
                <div class="dropdown-content">
                    <a href="#">Home Page</a>
                    <a href="./views/dashboard.php">Dashboard</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Tasks</a>
                <div class="dropdown-content">
                    <a href="./views/create-task.php">Create Task</a>
                    <a href="./views/show-tasks.php">View Tasks</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Articles</a>
                <div class="dropdown-content">
                    <a href="./views/create-journal.php">New Article</a>
                    <a href="./views/logs.php">View Articles</a>
                    <!--<a href="./views/categories.php">Categories</a>-->
                </div>
            </li>
            <li>
                <a href="./views/file-storage.php">Storage</a>
            </li>
            <li>
                <a href="./views/analytics.php">Analytics</a>
            </li>
            <li>
                <a href="./views/settings.php">Settings</a>
            </li>
            <li>
                <a href="./controllers/logout.php">Logout</a>
            </li>
            <a href="javascript:void(0);" class="icon" onclick="navToggle()">
                <i class="fa fa-bars"></i>
            </a>
        </ul>
    </div>
</nav>