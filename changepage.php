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

    if (isset($_POST["features"])) {
      if (!empty($_POST["seat"])) {
        $seat = $_POST["seat"];
        $sql = "UPDATE carfeatures SET seatnumber ='$seat' WHERE carid='$carid'";
        if (mysqli_query($conn, $sql)) {
        } else {
        }
      }
      if (!empty($_POST["door"])) {
        $door = $_POST["door"];
        $sql = "UPDATE carfeatures SET doornumber ='$door' WHERE carid='$carid'";
        if (mysqli_query($conn, $sql)) {
        } else {
        }
      }
      if (!empty($_POST["ac"])) {
        $ac = $_POST["ac"];
        $sql = "UPDATE carfeatures SET ac ='$ac' WHERE carid='$carid'";
        if (mysqli_query($conn, $sql)) {
        } else {
        }
      }
      if (!empty($_POST["gear"])) {
        $gear = $_POST["gear"];
        $sql = "UPDATE carfeatures SET gearbox ='$gear' WHERE carid='$carid'";
        if (mysqli_query($conn, $sql)) {
        } else {
        }
      }
    }
    if (isset($_POST["infos"])) {
      if (!empty($_POST["Brand"])) {
        $brand = $_POST["Brand"];
        $sql = "UPDATE cars SET carbrand ='$brand' WHERE carid='$carid'";
        if (mysqli_query($conn, $sql)) {
        } else {
        }
      }
      if (!empty($_POST["Type"])) {
        $type = $_POST["Type"];
        $sql = "UPDATE cars SET cartype ='$type' WHERE carid='$carid'";
        if (mysqli_query($conn, $sql)) {
        } else {
        }
      }
      if (!empty($_POST["Value"])) {
        $value = $_POST["Value"];
        $sql = "UPDATE cars SET carvalue ='$value' WHERE carid='$carid'";
        if (mysqli_query($conn, $sql)) {
        } else {
        }
      }
      if (!empty($_POST["Address"])) {
        $address = $_POST["Address"];
        $sql = "UPDATE cars SET caraddress ='$address' WHERE carid='$carid'";
        if (mysqli_query($conn, $sql)) {
        } else {
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
    <div class="change">
      <form class="" action="#" method="post">
        <h1>Car Informations</h1>
        <p> Brand: <input type="text" name="Brand" placeholder="enter here"> </p>
        <p> Type: <input type="text" name="Type" placeholder="enter here"> </p>
        <p> Value: <input type="text" name="Value" placeholder="enter here"> </p>
        <p> Address: <input type="text" name="Address" placeholder="enter here"> </p>
        <input style="padding: 20px;
        border-radius: 15px;
        background-color: rgba(44, 36, 3, 0.5);
        width: 220px;
        font-family: monospace;
        border-color: white;
        font-size: 18px;
        color: #CEDDD5;" type="submit" name="infos" value="Change">
      </form>
    </div>
    <div class="change">
      <form class="" action="#" method="post">
        <h1>Car Features</h1>
        <p> Seat Number: <input type="text" name="seat" placeholder="enter here"> </p>
        <p> Door Number: <input type="text" name="door" placeholder="enter here"> </p>
        <p> AC: <input type="text" name="ac" placeholder="enter here"> </p>
        <p> Gearbox: <input type="text" name="gear" placeholder="enter here"> </p>
        <input style="padding: 20px;
        border-radius: 15px;
        background-color: rgba(44, 36, 3, 0.5);
        width: 220px;
        font-family: monospace;
        border-color: white;
        font-size: 18px;
        color: #CEDDD5;" type="submit" name="features" value="Change">
      </form>
    </div>
  </body>
</html>
