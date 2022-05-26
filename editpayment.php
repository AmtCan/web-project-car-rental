<?php session_start(); ?>
<?php
  $userid = $_SESSION["userid"];
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "car_rental";
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $start = $_SESSION["startdate"];
  $end = $_SESSION["enddate"];
  $userid = $_SESSION["userid"];
  $carid = $_SESSION["carid"];
  $cost = $_SESSION["cost"];
  $reservationid = $_SESSION["reserveid"];
  $enddate=strtotime($end);
  $startdate=strtotime($start);
  $days_between = ($enddate-$startdate)/86400;


  if (isset($_POST["payment"])) {
    $sql = "UPDATE reservation
            SET startdate = '$start',enddate = '$end', cost = $cost
            WHERE reservationid = '$reservationid'";
    if ($conn->query($sql) === TRUE) {}
      header("location:reservation.php");
          }
 ?>
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
        background-image: url("car8.jpg");
        background-repeat: no-repeat;
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
        padding: 40px 100px;
        text-decoration: none;
        font-size: 17px;
      }
      .topnav a:hover{
        background-color: #A4AE9D;
        color: black;
      }
      .container {
        background-color: rgba(44, 36, 3, 0.8);
        width: 350px;
        height: 500px;
        border-radius: 25px;
      }

      .container p{
        margin-left: 20px;
        margin-top: 60px;
        background-color: rgba(44, 36, 3, 0.5);
        width: 220px;
        height: 50px;
        font-family: monospace;
        border-style: solid;
        border-width: 2px;
        border-color: white;
        font-size: 18px;
        color: #CEDDD5;

      }
      .container h1{
        font-size:40px;
        color:#CEDDD5;
        font-family: monospace;
        margin-left: 20px;
      }
      .container p:hover{
        background-color: white;
        color: black;
        cursor: pointer;
      }
      .closeicon{
        height: 50px;
        width: 50px;
        background-color: red;
        color: white;
        float: right;
      }
      .closeicon:hover{
        background-color: white;
        color: black;
      }
      .paymentPopUp{
        background-color: rgba(44, 36, 3, 1);
        width: 300px;
        height: 550px;
        padding: 10px;
        border-radius: 25px;
        border-style: solid;
        border-color: white;
        position:absolute;
        top:150px;
        left: 40%;
      }
      .paymentPopUp h1{
        font-size: 35;
        font-family: monospace;
        color: #CEDDD5;
      }
      .paymentPopUp h2{
        font-size: 20;
        font-family: monospace;
        color: #CEDDD5;
      }
      .paymentPopUp p{
        font-size: 20px;
        float: left;
        color: #CEDDD5;
      }
      .paymentPopUp input{
        border-radius: 15px;
        background-color: #767C68;
        color: black;
      }
      .valuecon{
        position: absolute;
        left: 10%;
        width: 300px;
        top: 150px;
        background-color: #767C68;
        border-radius: 15px;
        border-style: solid;
        border-color: white;
      }
      .valuecon li{
        font-size: 25px;
      }
      .valuecon ul{
        font-size: 30px;
      }
  </style>
  <body>
    <div class="topnav">
        <a class="fa fa-home" onclick="offAll();" href="mainPage.php"> Home</a>
      </div>
      <div id="payment" class="paymentPopUp">
        <h1>Payment</h1>
        <h2>Select Card:</h2>
          <select class="selecter" name="">
            <option value="card1">Card1</option>
            <option value="card2">Card2</option>
          </select>
          <h2>Or:</h2>
          <div style="margin:0;">
            <form  action="#" method="post">
              <p>Card Number: <input type="text" name="cardNumber" placeholder="0000-0000-0000-0000"></p>
              <p>Date: <input style="width: 100px" type="text" name="cardNumberMonth" placeholder="Month">
              <input style="width: 100px" type="text" name="cardNumberYear" placeholder="Year"></p>
              <p>Owner Name: <input style="width:150px;"type="text" name="ownerName" placeholder="Name Surname"></p>
              <p>Card CVV: <input style="width:200px;"type="text" name="cvv" placeholder="CVV"></p>
              <input style="font-size:24px; margin:0px 0px 0px 25px; cursor:pointer;
              background-color: #584E34;" type="submit" name="payment" value="approve">

            </form>
          </div>
      </div>
      <div class="valuecon">
        <h1 style="margin-left: 10px;">Total: <?php echo $cost; ?></h1>
        <ul style="margin-left: 10px;">For <?php echo $days_between; ?> days:</ul>
        <li style="margin-left: 10px;">Start day: <?php echo $start; ?></li>
        <li style="margin-left: 10px;">End date: <?php echo $end; ?></li>
      </div>
  </body>
</html>
