<?php session_start(); ?>
<?php
    // Database connection.
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "car_rental";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $carid = $_SESSION["carid"];
    $seatErr = $doorErr = $acErr = $gearErr = $brandErr = $colorErr = $valueErr = $addressErr = $imageErr = "";

    if (isset($_POST["add"])) {
      $image = $_FILES["imagename"]["name"];
      $seat = $_POST["seat"];
      $door = $_POST["door"];
      $ac = $_POST["ac"];
      $gear = $_POST["gear"];
      $brand = $_POST["Brand"];
      $color = $_POST["Color"];
      $value = $_POST["Value"];
      $address = $_POST["Address"];
      if (empty($seat)) {
        $seatErr = "Required!";
      }
      if (empty($door)) {
        $doorErr = "Required!";
      }
      if (empty($ac)) {
        $acErr = "Required!";
      }
      if (empty($gear)) {
        $gearErr = "Required!";
      }
      if (empty($brand)) {
        $brandErr = "Required!";
      }
      if (empty($color)) {
        $colorErr = "Required!";
      }
      if (empty($value)) {
        $valueErr = "Required!";
      }
      if (empty($address)) {
        $addressErr = "Required!";
      }
      if (empty($image)) {
        $imageErr = "Required!";
      }
      if (empty($seatErr) && empty($doorErr) && empty($acErr) && empty($gearErr) &&
          empty($brandErr) && empty($colorErr) && empty($valueErr) && empty($addressErr) && empty($imageErr)){
            $sql = "INSERT INTO cars(carbrand, carcolor, carvalue, carinfo, caraddress, carimage, statu)
            VALUES('$brand','$color','$value','$brand','$address','$image','1')";
            if ($conn->query($sql) === TRUE) {}
              else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $sql = "SELECT MAX(carid) AS carid
                    FROM cars
                    ";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $lastid = $row['carid'];
            $sql = "INSERT INTO carfeatures(seatnumber, doornumber, ac, gearbox, carid)
                    VALUES('$seat','$door','$ac','$gear','$lastid')";
                    if ($conn->query($sql) === TRUE) {}
                      else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    }
      }
    }

 ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <style media="screen">
    .fa {
      opacity: 1;
      text-decoration: none;
    }
    body{
      background: transparent;
      margin: 0;
      background-color: #A4AE9D;
      background-attachment: fixed;
      background-size: cover;
    }
    .topnav {
      overflow: hidden;
      background-color: #2C2403;
    }
    .topnav a {
      float: left;
      border-color: white;
      color: white;
      text-align: center;
      padding: 2.6% 5.5%;
      text-decoration: none;
      font-size: 17px;
    }
    .topnav a:hover{
      background-color: #A4AE9D;
      color: black;
    }
    .change{
      float: left;
      margin-left: 20%;

      width: 20%;
    }
    .change p{
      font-size: 25px;


    }
    .change h1{

    }
    .change span{
      float: left;
      color: red;
      font-size: 20px;
    }
    .change input{
      font-size: 20px;
      border-radius: 5px;
      margin-left: 2%;
    }
  </style>
  <body>
    <div class="topnav">
      <a class="fa fa-home" href="admin.php"> Home</a>
    </div>
    <form class="" action="#" method="post" enctype="multipart/form-data">
    <div class="change">
        <h1>Car Informations</h1>
        <p> Brand: <input type="text" name="Brand" placeholder="enter here"> <span> * <?php echo $brandErr; ?> </span></p>
        <p> Color: <input type="text" name="Color" placeholder="enter here"> <span> * <?php echo $colorErr; ?></span> </p>
        <p> Value: <input type="text" name="Value" placeholder="enter here"> <span> * <?php echo $valueErr; ?></span> </p>
        <p> Address: <input type="text" name="Address" placeholder="enter here"> <span> * <?php echo $addressErr; ?></span> </p>
        <p> image: <input type="file" name="imagename" id= "fileToUpload"> <span> * <?php echo $addressErr; ?></span> </p>
    </div>
    <div class="change">
        <h1>Car Features</h1>
        <p> Seat Number: <input type="text" name="seat" placeholder="enter here"> <span> * <?php echo $seatErr; ?></span> </p>
        <p> Door Number: <input type="text" name="door" placeholder="enter here"> <span> * <?php echo $doorErr; ?></span> </p>
        <p> AC: <input type="text" name="ac" placeholder="enter here"> <span> * <?php echo $acErr; ?></span> </p>
        <p> Gearbox: <input type="text" name="gear" placeholder="enter here"> <span> * <?php echo $gearErr; ?></span> </p>
        <input style="padding: 20px;
        border-radius: 15px;
        background-color: rgba(44, 36, 3, 0.5);
        width: 220px;
        font-family: monospace;
        border-color: white;
        font-size: 18px;
        color: #CEDDD5;" type="submit" name="add" value="Add">
    </div>


    </form>

  </body>
</html>
