<?php
include_once "sessionCheck.php"; ?>
<html>

<body>
    <?php
    include_once "credentials.php";
    include_once "displayUser.php";
    if (isset($_POST["Logout"])) {
        session_unset();
        session_destroy();
        print "Successfully unregistered";
    } elseif ($_SESSION["UserLogged"]) {
        print "You are already logged in. You cannot signup twice...";
        DisplayUserDetails($connection);
    } elseif (isset($_POST["FirstName"]) && isset($_POST["LastName"]) && isset($_POST["Username"]) && isset($_POST["Password"])) {
        print "You are about to register .... but not yet<BR>";
        $isUserThere = $connection->prepare("SELECT * FROM ppl WHERE UserName=?");
        $isUserThere->bind_param("s", $_POST["Username"]);
        $isUserThere->execute();

        $result = $isUserThere->get_result();
        if ($result->num_rows > 0) {
            print "Your username is already taken ! <BR>";
        } else {
            $stmt = $connection->prepare(
                "INSERT INTO ppl(First_Name,Second_Name,Age,UserName,Password,Nationality,User_role ) VALUES(?,?,?,?,?,?,?)"
            );

            $hashedPassword = password_hash($_POST["Password"], PASSWORD_BCRYPT);
            $userType = 2;
            $stmt->bind_param(
                "ssissii",
                $_POST["FirstName"],
                $_POST["LastName"],
                $_POST["Age"],
                $_POST["Username"],
                $hashedPassword,
                $_POST["Country"],
                $userType // this MUST BE a CUSTOMER !!!
            );
            $stmt->execute();
            print "Yaaay you have registered. Check the database <BR>";

            $_SESSION["UserLogged"] = true;
            // We need to ask the database back WHAT is the PERSON_ID that was associated to this USER that we have just inserted !
            $newSelectStatement = $connection->prepare("SELECT PERSON_ID FROM ppl WHERE Username=?");
            $newSelectStatement->bind_param("s", $_POST["Username"]);
            $newSelectStatement->execute();
            $resultingUser = $newSelectStatement->get_result();
            $rowCurrentId = $resultingUser->fetch_assoc();
            $_SESSION["CurrentUser"] = $rowCurrentId["PERSON_ID"];

            DisplayUserDetails($connection);
        }
    } else {
         ?>
        <form action="Signup.php" method="post">
            First name: <input type="text" name="FirstName" required><br>
            Last name: <input type="text" name="LastName" required><br>
            Age: <input type="text" name="Age"><br>
            UserName: <input type="text" name="Username" required><br>
            Password: <input type="text" name="Password" required><br>

            <select name="Country">
                <?php
                $stmt = $connection->prepare("SELECT * FROM COUNTRIES");
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["COUNTRY_ID"] . '">' . $row["COUNTRY_NAME"] . '</option>';
                    }
                } else {
                    echo "0 results";
                }
                $connection->close();
                ?>
            </select>
            <br>
            <input type="submit" name="Register" value="Register">
        </form>
    <?php
    }
    ?>

</body>

</html>