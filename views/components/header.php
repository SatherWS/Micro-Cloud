<nav class="topnav" id="myTopnav">
    <div class="index-nav parent-nav">
        <ul>
            <li>
                <!-- Team Steep vs. Team Stoop -->
                <a href="../views/dashboard.php" class="active">Swoop.Team</a>
                <i class="fa fa-wifi"></i>
            </li>
        </ul>
        <ul class="topnav-list">
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Team Posts</a>
                <div class="dropdown-content">
                    <a href="./create-journal.php">Create Post</a>
                    <a href="./logs.php">View Posts</a>
                    <a href="./categories.php">Categories</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Task List</a>
                <div class="dropdown-content">
                    <a href="./create-task.php">Create Task</a>
                    <a href="./show-tasks.php">Manage Tasks</a>
                </div>
            </li>
            <li>
                <a href="./analytics.php">Analytics</a>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Bonus Apps</a>
                <div class="dropdown-content">
                    <a href="./bonus_apps/data-storage.php">Data Storage</a>
                    <a href="./bonus_apps/join-chat.php">Chatrooms</a>
                    <a href="./bonus_apps/polls.php">Votting App</a>
                    <a href="./bonus_apps/pain-rating.php">Pain Rating</a>
                </div>
            </li>
            <li>
                <a href="../controllers/logout.php">Logout</a>
            </li>
            <a href="javascript:void(0);" class="icon" onclick="navToggle()">
                <i class="fa fa-bars"></i>
            </a>
        </ul>
    </div>
</nav>