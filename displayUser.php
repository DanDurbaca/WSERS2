<?php
function DisplayUserDetails($connection)
{
    if (!isset($_SESSION["CurrentUser"])) {
        print "You are trying to diplay a user details without loggin in";
    } else {
        // SHOW PERSONAL DETAILS:
        $userFromMyDatabase = $connection->prepare("SELECT * FROM ppl WHERE PERSON_ID=?");
        $userFromMyDatabase->bind_param("i", $_SESSION["CurrentUser"]);
        $userFromMyDatabase->execute();
        $result = $userFromMyDatabase->get_result();
        // NORMALLY -> I MUST HAVE 1 SINGLE RESULT
        if ($result->num_rows == 0) {
            // BUT WHAT IF I DONT !?!?!?
            print "Failed displaying user data. Something is wrong with the database -> Logging out automatically";
            session_destroy();
            session_unset();
            die("We stopped here");
        }

        $row = $result->fetch_assoc();
        /* 
            -> First_Name
            -> Second_Name
            -> Age
            -> UserName
            -> Country that you registered with ! -> USE AN SQL SELECT Statement !
            */
        print "First name: " . $row["First_Name"] . "<BR>";
        print "Second name: " . $row["Second_Name"] . "<BR>";
        print "Age: " . $row["Age"] . "<BR>";
        print "Username: " . $row["UserName"] . "<BR>";
        $countrySelect = $connection->prepare("SELECT COUNTRY_NAME FROM countries WHERE COUNTRY_ID=?");
        $countrySelect->bind_param("i", $row["Nationality"]);
        $countrySelect->execute();
        $resultCountry = $countrySelect->get_result();
        $rowCountry = $resultCountry->fetch_assoc();
        print "Country: " . $rowCountry["COUNTRY_NAME"] . "<BR>";
        /*
        WE Know the following PHP arrays:
        $_GET
        $_POST
        $_SESSION
        $_SERVER ['PHP_SELF'] -> current filename !!
         */
    } ?>
    <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="submit" name="Logout" value="Logout">
</form>
    <?php
}
?>
