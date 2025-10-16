<?php

$servername = "localhost";
$username = "php_tesztelo";
$password = "0tW[PcVoM4zcqaDt";
$dbname = "php_teszt";



$target_dir = "logos/";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['id'])) {
    $sql = "UPDATE cars SET 
              brand = '" . $_POST['brand'] . "', 
              stock = " . $_POST['stock'] . ", 
              sold = " . $_POST['sold'] . "
            WHERE id = " . $_POST['id'];
  } else {
    $sql = "INSERT INTO cars (brand, stock, sold) 
              VALUES ('" . $_POST['brand'] . "'," . $_POST['stock'] . "," . $_POST['sold'] . ")";
  }
  $result = $conn->query($sql);


  if (!isset($_POST["id"])) {
    $_POST["id"] = $conn->insert_id;
  }




  if ($_FILES["brandLogo"]["tmp_name"]) {
    $target_file = $target_dir . $_POST['id'];
    $uploadOk = 1;

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES['brandLogo']['tmp_name']);
    if ($check !== false) {
      echo "File is an image" . $check["mime"] . " ";
      $fileExt = preg_split("/\//", $check["mime"]);
      $target_file = $target_file . "." . $fileExt[1];
      $uploadOk = 1;
    }
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
  if (move_uploaded_file($_FILES["brandLogo"]["tmp_name"], $target_file)) {
    echo ("The file" . htmlspecialchars(basename($_FILES["brandLogo"]["name"])) . " has been uploaded");
  } else {
    echo "sorry there was an error uploading your file.";
  }

} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET['action'])) {
    switch ($_GET['action']) {
      case "update":
        $sql = "SELECT id, brand, stock, sold FROM cars WHERE id = " . $_GET['id'];
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
          $update = $row;
        }
        break;

      case "delete":
        $sql = "DELETE from cars WHERE id = " . $_GET['id'];
        $result = $conn->query($sql);
        break;
    }
  }
}

?>
<!DOCTYPE html>
<html>

<body>

  <h1>My first PHP page</h1>

  <form enctype="multipart/form-data" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <?php

    if (isset($update)) {
      echo "  Brand: <input type=\"text\" name=\"brand\" value=\"" . $update['brand'] . "\">
            Stock: <input type=\"text\" name=\"stock\" value=\"" . $update['stock'] . "\">
            Sold: <input type=\"text\" name=\"sold\" value=\"" . $update['sold'] . "\">
            <input type=\"hidden\" name=\"id\" value=\"" . $update['id'] . "\">";
    } else {
      ?>
      Brand: <input type="text" name="brand"> <br>
      Stock: <input type="text" name="stock"> <br>
      Sold: <input type="text" name="sold"> <br>
      File: <input type="file" name="brandLogo" id="fileToUpload"> <br>
      <?php
    }
    ?>
    <input type="submit">
  </form>
  <table>
    <?php

    $sql = "SELECT id, brand, stock, sold FROM cars";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
        echo "  <tr>";
        foreach ($row as $data) {
          echo "<td>$data</td>";
        }
        echo "<td><a href=\"index.php?action=update&id=" . $row["id"] . "\">Módosítás</a></td>";
        echo "<td><a href=\"index.php?action=delete&id=" . $row["id"] . "\">Törlés</a></td>";
        echo "  </tr>";
      }
    }

    ?>
  </table>

</body>

</html>