<!DOCTYPE html>
<html lang="hu">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <h1 class="text-center mb-5">My first PHP page</h1>
    <form class="w-50 m-auto" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="exampleFormControlInput1" class="form-label">Name</label>
        <input class="form-control" type="text" name="name">
        <label for="exampleFormControlInput1" class="form-label">Stock</label>
        <input class="form-control" type="number" name="stock">
        <label for="exampleFormControlInput1" class="form-label">Sold</label>
        <input class="form-control" type="number" name="sold">
        <input class="mb-4 mt-4 btn btn-secondary" type="submit">
    </form>

    <?php


    $servername = "localhost";
    $username = "php_tesztuser";
    $password = "epwvFD40Lh0Hl4Mw";
    $dbname = "php_teszt";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    
    $cars = array(
        array("Volvo", 22, 18),
        array("BMW", 15, 13),
        array("Saab", 5, 2),
        array("Land Rover", 17, 15)
    );




    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";


    foreach ($cars as $car) {
        $sql = "INSERT INTO cars (brand, stock, sold) VALUES ('".$car[0]."', '".$car[1]."', '".$car[2]."')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully <br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();



    ?>

    <table style="width:50%" class="table table-striped m-auto">
        <tr>
            <td>Name</td>
            <td>Stock</td>
            <td>Sold</td>
        </tr>
        <?php
        foreach ($cars as $car) {
            echo " <tr>";
            foreach ($car as $data) {
                echo "<td>$data</td>";
            }
            echo " </tr>";
        }
        ?>
    </table>

</body>

</html>