<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Page Title</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <style>
            .Product {
                display: inline-block;
                border: 2px solid black;
            }
        </style>
    </head>
    <body>
        <h1>This is a list of our products</h1>
        <?php
        $databaseName = "testexample";
        $username = "root";
        $passwordDb = "";

        $connection = mysqli_connect("localhost", $username, $passwordDb, $databaseName);

        $sqlSelectStatement = $connection->prepare("SELECT * FROM products");
        // THIS IS NOT NEEDED NOW : $sqlSelectStatement->bind_param()
        $sqlSelectStatement->execute();
        $result = $sqlSelectStatement->get_result();
        while ($row = $result->fetch_assoc()) { ?>

        <div class="Product">
            <img src="images/potato.jpg" />
            <h3>Name: <?php print $row["Name"]; ?></h3>
            <h2>Description: this is the description</h2>
            <h4>Price: 3 &euro;</h4>
        </div>

        <?php }
        ?>
    </body>
</html>
