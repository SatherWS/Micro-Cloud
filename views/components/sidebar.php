<?php
    function get_projects($curs) {
        // SHOW USER PROJECTS SELECTOR SIDE BAR COMPONENT
        $sql2 = "select team_name from members where email = ?";
        $stmnt2 = mysqli_prepare($curs, $sql2);
        $stmnt2->bind_param("s", $_SESSION["unq_user"]);
        $stmnt2->execute();
        $results2 = $stmnt2 -> get_result();
        $project = "";
        while ($row = mysqli_fetch_assoc($results2)) {
            $team = $row["team_name"];
            $project .= "<h3><a href='../controllers/change_team.php?switched=".$row["team_name"]."'>";
            $project .= $row["team_name"]."</a></h3>";
        }
        return $project;
    }
?>
<section class="side-bar" id="side-bar">
    <div class="fixed-content">
        <div class="fixed-content-items">
            <div>
                <h3>Project List</h3>
                <?php
                    if (isset($_GET["error"])) 
                        echo "<p class='error-msg'><b>Error:</b> ".$_GET["error"]."</p>";
                    else if (isset($_GET["msg"])) 
                        echo "<p class='success-msg'><b>Success:</b> ".$_GET["msg"]."</p>";
                    if (!isset($_SESSION["team"]))
                        echo "<p>This user doesn't have any projects.</p>";
                    else 
                        echo get_projects($curs);   
                ?>
            </div>
            <div>
                <h4 class="dash-btn"><a href="#myModal" id="myBtn" class="spc-flex">
                    <span>Add Project</span>
                    <i class="fa fa-plus-circle"></i>
                </a></h4>
                <h4 class="dash-btn"><a href="#" onclick="hideSideBar()" class="spc-flex">
                    <span>Hide Projects</span>
                    <i class="fa fa-chevron-circle-left"></i>
                </a></h4>
            </div>
        </div>
    </div>
</section>
<section class="show-sidebar" id="mini-btn">
    <h4 class="dash-btn"><a href="#" onclick="hideSideBar()" class="todo-flex">
        <span>Show Projects</span>
        <i class="fa fa-chevron-circle-left"></i>
    </a></h4>
</section>