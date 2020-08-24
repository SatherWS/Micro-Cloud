<?php
    function get_projects($curs) {
        // USED IN TEAM SELECTOR SIDE BAR COMPONENT
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
<section class="side-bar">
    <div class="fixed-content">
        <div class="fixed-content-items">
            <div>
                <h3>Project List</h3>
                <?php
                    echo get_projects($curs);
                    if (!isset($_SESSION["team"]))
                        echo "<p>This user doesn't have any projects.</p>";
                ?>
            </div>
            <div>
                <h4 class="dash-btn"><a href="#myModal" id="myBtn">
                    <span>Add Project</span>
                    <i class="fa fa-plus-circle"></i>
                </a></h4>
                <h4 class="dash-btn"><a href="./create-journal.php" class="todo-flex">
                    <span>Hide Projects</span>
                    <i class="fa fa-chevron-circle-left"></i>
                </a></h4>
            </div>
        </div>
    </div>
</section>