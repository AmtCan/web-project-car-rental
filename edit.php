<?php session_start(); ?>
<?php
  $reservationid = $_SESSION['reservationid'];
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "car_rental";
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT *
          FROM reservation
          WHERE reservationid = '$reservationid'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $carid = $row['carids'];
  $userid = $row['userid'];
  $currstr = $row['startdate'];
  $currend = $row['enddate'];

  date_default_timezone_set("Europe/Berlin");
  $dateError = "";
  $sql = "SELECT carvalue
          FROM cars
          WHERE carid = '$carid' ";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $cost = $row['carvalue'];
  if (isset($_POST['editdate'])) {
    if ($_POST['Start'] == "" || $_POST['End'] == "") {
      $dateError = "required";
    }
    else{
      $newstr = $_POST['Start'];
      $newend = $_POST['End'];
      $timezone = date('Y/m/d');
      $stringDate = strtotime($timezone);
      $enddate=strtotime($newend);
      $startdate=strtotime($newstr);
      $days_between = ($enddate-$startdate)/86400+1;
      $total = $days_between*$cost;
      $timediff = $startdate - $stringDate;
      $timediff2 = $enddate - $stringDate;
      $timediff3 = $enddate - $startdate;
      if($timediff < 0 || $timediff2 < 0 || $timediff3 < 0){
        $dateError = 'invalid date entered!';
      }
      else {
        $sql = "SELECT DISTINCT userid
                FROM reservation
                WHERE carids = '$carid' AND
                ((startdate BETWEEN '$newstr' AND '$newend') OR
                (enddate BETWEEN '$newstr' AND '$newend') OR
                ('$newstr' BETWEEN startdate AND enddate) OR
                ('$newend' BETWEEN startdate AND enddate))";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $reserveuser = $row['userid'];
                if((mysqli_num_rows($result) == 1 && $reserveuser == $userid) || mysqli_num_rows($result) == 0){
                  $dateError = "";
                }
                else {
                  $dateError = "Car is reserved these days!";
                }
              }
            }
      if (empty($dateError)) {
        $_SESSION['cost'] = $total;
        $_SESSION['startdate'] = $newstr;
        $_SESSION['enddate'] = $newend;
        $_SESSION['reserveid'] = $reservationid;


        header("location:editpayment.php");
      }
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

      .popup {
        margin: 70px auto;
        padding: 20px;
        background: #fff;
        border-radius: 5px;
        width: 30%;
        position: relative;
        transition: all 5s ease-in-out;
      }

      .popup h2 {
        margin-top: 0;
        color: #333;
        font-family: Tahoma, Arial, sans-serif;
      }
      .popup .close {
        position: absolute;
        top: 20px;
        right: 30px;
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: #333;
      }
      .popup .close:hover {
        color: red;
      }
      .popup .content {
        height: 50%;
        overflow: auto;
      }
      body{
        background: transparent;
        margin: 0;
        background-image: url("bckgrnd (2).jpg");
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
      .container{
        width: 40%;
        height: 650px;
        background-color: rgba(186, 158, 80);
        border-color: white;
        border-right-style:solid;
        animation-duration: 4s;
      }
      .container h3{
        display: none;
      }
      .container p{
        color: #2C2403;
        margin: 0;

        background-color: rgb(255, 255, 128);
        font-size: 25px;
        border-style: solid;
        border-color: white;
        border-width: 1px;
      }
      .overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
      }
      .overlay:target {
        visibility: visible;
        opacity: 1;
      }
      .button {
        font-size: 1em;
        padding: 10px;
        color: #fff;
        border: 2px solid #2C2403;
        border-radius: 20px/50px;
        background-color: #2C2403;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease-out;
      }
      .button:hover {
        background: #A4AE9D;
      }
  </style>
  <body>
    <div class="topnav">
        <a class="fa fa-home" onclick="offAll();" href="mainPage.php"> Home</a>
    </div>
    <div class="container">
      <br>
      <br>
        <p>Current start date: <?php echo $currstr ?></p>
        <p>Current end date: <?php echo $currend ?></p>
        <br>
        <h1>Change date:</h1>
      <form class="" action="#" method="post">
        <p>Start date: <input type="date" name="Start"> <span style='color: red;'><?php echo $dateError; ?></span> </p>
        <p>End date: <input type="date" name="End"> <span style='color: red;'><?php echo $dateError; ?></span> </p>
        <br>
        <p style=" background-color:transparent;border-color: transparent;text-align: center;">
          <a class="button" href="#popup1">Change</a>
        </p>
         <div id="popup1" class="overlay">
         	<div class="popup">
         		<h2>Do you want to change your reservation date ?</h2>
         		<a class="close" href="#">&times;</a>
         		<div class="content">
         			<form class="" action="#" method="post">
                 <button style="margin-right:30%; margin-left:15%; width: 20%;" class="button" type="submit" name="editdate">Yes</button>
                 <button style=" width: 20%;" class="button" type="submit" name="No">No</button>
               </form>
         		</div>
         	</div>
         </div>

      </form>
    </div>
  </body>
</html>
