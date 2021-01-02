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
            if ($team == $_SESSION["team"] && !isset($_GET["project"]))
                $project .= "<h3 class='selected'><a href='../controllers/change_team.php?switched=".$row["team_name"]."&location=".$_SERVER['REQUEST_URI']."'>"; 
            else {
                $project .= "<h3><a href='../controllers/change_team.php?switched=".$row["team_name"]."&location=".$_SERVER['REQUEST_URI']."'>";
                $project .= $row["team_name"]."</a></h3>";
            }
        }
        return $project;
    }
?>
<section class="side-bar" id="side-bar">
    <div class="fixed-content">
        <div class="fixed-content-items">
            <div>
                <?php
                    if (isset($_GET["error"])) 
                        echo "<p class='error-msg'><b>Error:</b> ".$_GET["error"]."</p>";
                        
                    else if (isset($_GET["msg"])) 
                        echo "<p class='success-msg'><b>Success:</b> ".$_GET["msg"]."</p>";

                    if (!isset($_SESSION["team"]) && isset($_SESSION["unq_user"]))
                        echo "<p>This user doesn't have any projects.</p>";

                    else if (!isset($_SESSION["team"]) && !isset($_SESSION["unq_user"]))
                        echo "<p>You must be logged in order to join or create projects.</p>";
                    else 
                        echo get_projects($curs);   
                ?>
            </div>
            <div>
                <?php
                    if (isset($_SESSION["unq_user"])) {
                        echo "<h4 class='dash-btn'><a href='#myModal' id='myBtn' class='spc-flex'>";
                        echo "<span>Add Project</span>";
                        echo "<i class='fa fa-plus-circle'></i>";
                        echo "</a></h4>";
                    }
                
                    if (!isset($_SESSION["unq_user"])) {
                	echo "<h4 class='dash-btn'><a href='./authentication/register.php' class='spc-flex'>";
			echo	"<span>Sign Up Today!</span>";
			echo "</a></h4>";
		    }
		?>
		<h4 class="dash-btn"><a href="#" onclick="hideSideBar()" class="spc-flex">
                    <span>Hide</span>
                    <i class="fa fa-chevron-circle-right"></i>
                </a></h4>
            </div>
        </div>
    </div>
</section>
<section class="show-sidebar" id="mini-btn">
    <h4 class="dash-btn"><a href="#" onclick="hideSideBar()" class="todo-flex">
        <span>Show</span>
        <i class="fa fa-chevron-circle-right"></i>
    </a></h4>
</section>
