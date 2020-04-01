<?php

if (
    isset($_POST["Username"]) &&
    isset($_POST["Password"])
) {
    include_once("credentials.php");
    // Create connection
    $connection = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $userFromMyDatabase = $connection->prepare("SELECT * FROM ppl WHERE UserName=?");
    $userFromMyDatabase->bind_param("s", $_POST["Username"]);
    $userFromMyDatabase->execute();
    $result = $userFromMyDatabase->get_result();
    if ($result->num_rows === 1) {
        print "We are checking your password <BR>";
        $row = $result->fetch_assoc();
        
        if(password_verify($_POST["Password"], $row["Password"]))
        {
            print "Ok... You are now successfully registered";
        }
        else
        {
            print "Wrong password !";
        }
    } else
    {
        print "Your username is not in our database !! Please consider registering !";
        ?> <a href="Signup.php">Go to the signup page</a>
            <a href="Login.php">Try again</a>
        <?php
    }
}
else {
?>
<form action="Login.php" method="post">
    Username: <input type="text" name="Username" required><br>
    Password: <input type="text" name="Password" required><br>    
    <input type="submit" name="Login" value="Login">
</form>
<?php 
}
?>