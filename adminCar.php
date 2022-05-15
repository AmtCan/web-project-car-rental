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
      $dateErr = "";
      $start = $end = "";
      $carid = $_SESSION["carid"];
      $sql = "SELECT *
            FROM cars
            WHERE carid = '$carid'
            ";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $carimage = $row["carimage"];
            $carbrand = $row["carbrand"];
            $carcolor = $row["carcolor"];
            $carvalue = $row["carvalue"];
            $carLocation = $row["caraddress"];

      $sql = "SELECT *
            FROM carfeatures
            WHERE carid = '$carid'
            ";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $seatnum = $row["seatnumber"];
            $doornum = $row["doornumber"];
            $ac = $row["ac"];
            $gearbox = $row["gearbox"];

      if (isset($_POST['rent'])){
        $start = $_POST["startDate"];
        $end = $_POST["endDate"];
        if (empty($start) || empty($end)) {
          $dateErr = 'You need to choose date!';
        }
        $sql = "SELECT startdate,enddate
                FROM reservation
                WHERE carids = '$carid' AND
                ((startdate BETWEEN '$start' AND '$end') OR
                (enddate BETWEEN '$start' AND '$end') OR
                ('$start' BETWEEN startdate AND enddate) OR
                ('$end' BETWEEN startdate AND enddate))";
                $result = $conn->query($sql);
                if(mysqli_num_rows($result) > 0){
                  $dateErr = "Car is reserved these days!";
                }
        if (empty($dateErr)) {
            $_SESSION["carlocation"] = $carLocation;
            $_SESSION["carid"] = $carid;
            $_SESSION["cost"] = $carvalue;
            $_SESSION["startdate"] = $start;
            $_SESSION["enddate"] = $end;
            header("Location:payment.php");
            }
      }
      if (isset($_POST["delete"])) {
        $sql ="DELETE FROM cars
               WHERE carid = '$carid'";
               if ($conn->query($sql) === TRUE) {
                } else {
                }
                $conn->close();
                header("location:admin.php");
      }
      if (isset($_POST["update"])) {
        $_SESSION["carid"] = $carid;
        header("location:changepage.php");
      }


?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
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
      .error{
        margin-left: 2%;
        color: red;
        font-size: 20px;
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
      .container {
        width: 400px;
        height: 600px;
        margin-left: 5%;
        margin-top: 1%;
        border-style: solid;
        border-radius: 15px;
        float: left;
        padding: 15px;
        background-color: #D0DDD7;
      }
      .container li{
        font-size: 20px;
      }
      .container h1{
        font-family: georgia;
        text-align: center;
        text-shadow: 5px;
      }
      .container h2{
        font-family: sans-serif;
      }
      .container h3{
        color: #2C2403;
      }
      .car-image{
        margin-top: 100px;
        height: 55%;
        width: 44%;
        float: left;
        padding: 15px;
      }
      .car-image img{
        width: 100%;
        height: 100%;
      }
      ::-webkit-input-placeholder {
        color: black;
      }
      .container input{
        padding: 20px;
        border-radius: 15px;
        background-color: rgba(44, 36, 3, 0.5);
        width: 220px;
        font-family: monospace;
        font-size: 18px;
        color: #CEDDD5;

      }
      .selecter{
        border-radius: 25px;
        width: 200px;
        font-size: 20;
        background-color: #767C68;
      }
      .selecter option{
        color: white;
      }
      .dateCon{
        width: 150px;
        height:100px;
        margin-left: 2%;
        margin-top: 1%;
        border-style: solid;
        border-radius: 15px;
        float: left;
        padding: 15px;
        background-color: #D0DDD7;

      }
      .dateCon input{
        padding: 20px;
        margin-top: 20px;
        margin-left: 10px;
        border-radius: 15px;
        background-color: rgba(44, 36, 3, 0.5);
        width: 85%;
        font-family: monospace;
        font-size: 18px;
        color: #CEDDD5;
      }
      .dateCon input:hover{
        background-color: White;
        color: black;
      }
      @media only screen and (max-width: 768px) {
        /* For mobile phones: */
        [class="container"] {
          width: 90%;
          margin-left: 1%;

        }
        [class="car-image"] {
          width: 80%;
          height: 80%;

        }
      }
    </style>
  </head>
  <body>
    <div class="topnav">
        <a class="fa fa-home" onclick="offAll();" href="admin.php"> Home</a>
      </div>
      <div class="car-image">
        <img src="<?php echo $carimage; ?>" alt="car">
      </div>
      <div class="container">

        <strong><h1><?php echo $carbrand; ?></h1></strong>
          <h3>Car features:</h3>
          <ul id="car-features">
            <li>Seat Number: <?php echo $seatnum; ?></li>
            <li>Door Number: <?php echo $doornum; ?></li>
            <li>Air Conditioning: <?php echo $ac; ?></li>
            <li>Gearbox: <?php echo $gearbox; ?></li>
          </ul>
          <h3>Included in the price:</h3>
          <ul>
            <li>Snow Chains</li>
            <li>Collision Damage Waiver</li>
            <li>Theft Protection</li>
            <li>4,000 kilometres per rental</li>
            <li>Free cancellation up to 48 hours before pick-up</li>
            <li>Collision Damage Waiver with TRY 0 excess</li>
          </ul>
          <h3>Location: <?php echo $carLocation ?> </h3>
            <h2 style="float: left;"><?php echo $carvalue; ?> TL</h2>
      </div>
      <div class="dateCon">
        <form class="" action="#" method="post">
          <input style="background-color: red;" type="submit" name="delete" value="Delete">
        </form>
      </div>
      <div class="dateCon">
        <form class="" action="#" method="post">
          <input type="submit" name="update" value="Change">
        </form>
      </div>
  </body>
</html>
