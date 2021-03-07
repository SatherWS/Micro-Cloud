<div class="comment-area">
    <form method="post" action="../models/comment.php" id="comments">                                                       
        <div class="log-details comment-form-bg">                                                                               
            <textarea class="comment-txt" name="comment" cols="30" placeholder="Commenting as <?php echo $user;?>"></textarea>
            <input type="hidden" name="art_id" value="<?php echo $_GET['journal'];?>">                                              
            <br>
            <input type="submit" value="Post Comment" class="add-btn-2">
        </div>
    </form>
    <br>
    <div class="log-details clr-grey">
    <?php                                                                                                                   
    $comments = new Comments();
    $comm_lst = $comments -> showComments($curs, $_GET["journal"]);                                                                                                                                                                         
    while ($row = mysqli_fetch_assoc($comm_lst)) {                                                                          
        echo "<div class='uline'></div>";                                                                                   
        echo "<p><b>".$row["user_email"]."</b></p>";                                                                        
        echo "<p>".$row["comment"]."</p>";
        echo "<small>".$row["date_created"]."</small><br><br>";                                                         
    }
    ?>
    </div>
</div>

