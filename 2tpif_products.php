<?php
include_once "sessionCheck.php";
include_once "credentials.php";
include_once "displayUser.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Products page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" media="screen" href="2tpif.css" />
    </head>
    <body>
        <nav id="NavigationBar">
            <div id="NavigationTitle">
                <h3>Products</h3>
            </div>
            <div id="NavigationLinks">
                <a href="2tpif_products.html">Products</a>
                <a href="2tpif_about.html">About</a>
            </div>
            <div id="Login">

<?php if (isset($_POST["Logout"])) {

    session_unset();
    session_destroy();
    print "Logged out successfully";
    ?> <a href="2tpif_products.php">Login again</a> <?php
} elseif ($_SESSION["UserLogged"]) {
    //print "You already have logged in ";
    DisplayUserDetails($connection);
} elseif (isset($_POST["Username"]) && isset($_POST["Password"])) {
    $userFromMyDatabase = $connection->prepare("SELECT * FROM ppl WHERE UserName=?");
    $userFromMyDatabase->bind_param("s", $_POST["Username"]);
    $userFromMyDatabase->execute();
    $result = $userFromMyDatabase->get_result();
    if ($result->num_rows === 1) {
        /*print "We are checking your password <BR>";*/
        $row = $result->fetch_assoc();
        if (password_verify($_POST["Password"], $row["Password"])) {
            $_SESSION["UserLogged"] = true;
            $_SESSION["CurrentUser"] = $row["PERSON_ID"];
            DisplayUserDetails($connection);
        } else {
            print "Wrong password !"; ?><a href="2tpif_products.php">Try again</a> <?php
        }
    } else {
        print "Your username is not in our database !! Please consider registering !"; ?> <a href="Signup.php">Go to the signup page</a>
            <a href="2tpif_products.php">Try again</a>
        <?php
    }
} else {
     ?>
        <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
            <div>
                <div>
                    <label for="Username">Username</label> 
                    <input type="text" name="Username" />
                </div>
                <div>
                    <label for="Password">Password</label> 
                    <input type="password" name="Password" />
                </div>
            </div>
            <input type="submit" name="Login" value="Login">
        </form>
    <?php
} ?>
            </div>
            <?php if (isset($_SESSION["UserLogged"])) {
                if (!$_SESSION["UserLogged"]) { ?>

            <div id="Signup"><a href="Signup.php">Signup</a></div>
            
            <?php }
            } ?>

            
            <div id="NavigationLanguage">
                <a href="#">Change language</a>
            </div>
        </nav>

        <h1>This is a list of our products:</h1>
        
        <div id="AllProducts">
            <div class="Product">
                <img src="WEBSITE/Images/Pepa/pepa1.png" />
                <p>This is a short description of my product</p>
                <p>Price: 4 &euro;</p>
            </div>

            <div class="Product">
                <img src="WEBSITE/Images/Pepa/pepa1.png" />
                <p>This is a short description of my product</p>
                <p>Price: 4 &euro;</p>
            </div>

            <div class="Product">
                <img src="WEBSITE/Images/Pepa/pepa1.png" />
                <p>This is a short description of my product</p>
                <p>Price: 4 &euro;</p>
            </div>
            <div class="Product">
                <img src="WEBSITE/Images/Pepa/pepa1.png" />
                <p>This is a short description of my product</p>
                <p>Price: 4 &euro;</p>
            </div>
            <div class="Product">
                <img src="WEBSITE/Images/Pepa/pepa1.png" />
                <p>This is a short description of my product</p>
                <p>Price: 4 &euro;</p>
            </div>
        </div>
    </body>
</html>
