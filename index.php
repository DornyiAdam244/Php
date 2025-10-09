<?php

$servername = "localhost";
$username = "kecske";
$password = "sBXTGLq]PsZ_t7ND";
$dbname = "php_teszt";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST['id'])) {
    $sql = "UPDATE cars SET 
              brand = '".$_POST['brand']."', 
              stock = ".$_POST['stock'].", 
              sold = ".$_POST['sold']."
            WHERE id = ".$_POST['id'];
  }
  else {
    $sql = "INSERT INTO cars (brand, stock, sold) 
              VALUES ('".$_POST['brand']."',".$_POST['stock'].",".$_POST['sold'].")";
  }
  $result = $conn->query($sql);
}
elseif($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['action'])) {
      switch($_GET['action']) {
        case "update":
          $sql = "SELECT id, brand, stock, sold FROM cars WHERE id = ".$_GET['id'];
          $result = $conn->query($sql);
          if ($row = $result->fetch_assoc()) {
            $update = $row;
          }
        break;

        case "delete":
          $sql = "DELETE from cars WHERE id = ".$_GET['id'];
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

<form enctype="multipart/form-data" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
  <?php

  if(isset($update)) {
    echo "  Brand: <input type=\"text\" name=\"brand\" value=\"".$update['brand']."\">
            Stock: <input type=\"text\" name=\"stock\" value=\"".$update['stock']."\">
            Sold: <input type=\"text\" name=\"sold\" value=\"".$update['sold']."\">
            <input type=\"hidden\" name=\"id\" value=\"".$update['id']."\">";
  }
  else {
    ?>
  Brand: <input type="text" name="brand">
  Stock: <input type="text" name="stock">
  Sold: <input type="text" name="sold">
  File: <input type="file" name="image">
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
  while($row = $result->fetch_assoc()) {
    echo "  <tr>";
    foreach($row as $data) {
        echo "<td>$data</td>";
    }
    echo "<td><a href=\"index.php?action=update&id=".$row["id"]."\">Módosítás</a></td>";
    echo "<td><a href=\"index.php?action=delete&id=".$row["id"]."\">Törlés</a></td>";
    echo "  </tr>";
  }
}

?>
</table>

</body>
</html>