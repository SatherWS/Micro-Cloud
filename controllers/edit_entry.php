<?php
include_once '../config/database.php';
$database = new Database();
$curs = $database->getConnection();

if ($curs->connect_error) {
    die("Connection failed: " . $curs->connect_error);
}

/* 
*   Article editing section 
*/

// TODO: Change below post name to something other than `edit`
// update an article according to the changes made in the details form
if (isset($_POST['edit'])) {
    $sql = "update journal set message = ?, subject = ? where id = ?";
    mysqli_query($curs, $sql);
    $stmnt = mysqli_prepare($curs, $sql);
    $journal_edit = $_POST['edited'];
    $stmnt -> bind_param("sss", $journal_edit, $_POST['jsubs'], $_POST['edit']);
    $stmnt -> execute();
    header("Location: ../views/journal-details.php?journal=".$_POST['edit']);
}

if (isset($_POST["img-upload"])) {
    $msg = "Image upload was clicked";
    header("Location: ./test.php?msg=$msg");
}

if (isset($_POST["file-upload"])) {
    $msg = "File upload was clicked";
    header("Location: ./test.php?msg=$msg");
}

if (isset($_POST['delete'])) {
    $sql = "delete from todo_list where id = ?";
    mysqli_query($curs, $sql);
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_POST['delete']);
    $stmnt -> execute();
    header("Location: ../views/show-tasks.php");
}

/* 
*   Main Tasks & Sub Task Editing Section 
*/

if (isset($_POST['mod-task'])) {
    $id = $_POST['mod-task'];
    $sql = "update todo_list set title=?, description=?, date_created=?, deadline=?, importance=?, status=?, assignee=?, creator=? where id=?";
    mysqli_query($curs, $sql);
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("sssssssss", $_POST["title"], $_POST["description"], $_POST["start-date"], $_POST["end-date"], $_POST["importance"], $_POST['change-status'], $_POST["change-assignee"], $_POST["change-creator"], $id);
    $stmnt -> execute();
    header("Location: ../views/task-details.php?task=".$id);
}
$curs -> close();
?>
