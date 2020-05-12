<?php
include_once "sessionCheck.php";
include_once "credentials.php";
if (!$_SESSION["UserLogged"]) {
    die("you are not logged in");
}
$userselect = $connection->prepare("SELECT User_role FROM ppl WHERE PERSON_ID=?");
$userselect->bind_param("i", $_SESSION["CurrentUser"]);
$userselect->execute();
$resultuser = $userselect->get_result();
$rowuser = $resultuser->fetch_assoc();
if ($rowuser["User_role"] !== 1) {
    die("you are not an adminstrator");
}

if (isset($_POST["Username"])) {
    $deleteThisStatement = $connection->prepare("DELETE FROM ppl where UserName=?");
    $deleteThisStatement->bind_param("s", $_POST["Username"]);
    $deleteThisStatement->execute();
}

$users = $connection->prepare("SELECT UserName FROM ppl WHERE PERSON_ID<>?");
$users->bind_param("i", $_SESSION["CurrentUser"]);
$users->execute();
$resultuser = $users->get_result();
while ($rowusers = $resultuser->fetch_assoc()) {
    print $rowusers['UserName']; ?>
    <form action="adminstration.php" method="post">
    <input type="hidden" name="Username" value="<?php print $rowusers['UserName']; ?>">
    <input type="submit" name="Delete" value="Delete"><BR>
    </form>
    <?php
}
?>

Add a new product to the database:<BR>
<form action="adminstration.php" method="post">
    Name: <input type="text" name="ProductName" required><br>
    Description: <input type="text" name="ProductDescription"><br>
    Price: <input type="text" name="ProductPrice"><br>
    PictureName: <input type="text" name="ProductPicture" required><br>    
    <input type="submit" name="Add" value="Add">
</form>
