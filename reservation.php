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
  date_default_timezone_set("Europe/Berlin");
  $timezone = date('Y/m/d');
  $pastRes = [];
  $currentRes = [];
  $futureRes = [];
  $future = [];
  $sql = "SELECT *
          FROM reservation
          WHERE userid = '$userid' AND (startdate < '$timezone' AND enddate < '$timezone')";
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) {
    $pastRes[]= "Start date: ".$row['startdate']." | "."End date: ".$row['enddate']."|------| Cost: ".$row['cost'];
  }
  $sql = "SELECT *
          FROM reservation
          WHERE userid = '$userid' AND (startdate <= '$timezone' AND enddate >= '$timezone')";
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) {
    $currentRes[]= "Start date: ".$row['startdate']." | "."End date: ".$row['enddate']."|------| Cost: ".$row['cost'];
  }
  $sql = "SELECT *
          FROM reservation
          WHERE userid = '$userid' AND (startdate > '$timezone' AND enddate > '$timezone')";
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) {
    $future[] = $row['startdate'];
    $futureRes[]= "Start date: ".$row['startdate']." | "."End date: ".$row['enddate']."|------| Cost: ".$row['cost'];
  }
  if (count($future) == 0) {

  }
  else {
    foreach ($future as $value){
      if (isset($_POST["$value"])) {
        $sql = "DELETE FROM reservation WHERE  startdate = '$value' AND userid = '$userid'";
        if ($conn->query($sql) === TRUE) {
        } else {
        }
        header("location:reservation.php");
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
        height: 86.9%;
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
        text-align:center;
        background-color: rgb(255, 255, 128);
        font-size: 25px;
        border-style: solid;
        border-color: white;
        border-width: 1px;
      }
      .container p:hover{
        background-color: white;
      }
      .container input{
        float: right;
        background-color: transparent;
        border-style: none;
        height: 30px;
        width: 60px;
        cursor: pointer;
      }
      .container input:hover{
        background-color: #2C2403;
        color: white;
      }

  </style>
  <body>
    <div class="topnav">
        <a class="fa fa-home" onclick="offAll();" href="mainPage.php"> Home</a>
    </div>
    <div class="container">
      <br>
      <br>
      <p>Upcoming Reservations <input style="float: right;" onclick="showUpcomingDate()" type="button" name="upcoming" value="V"> </p>
      <form style="margin-top: 0px;" action="#" method="post"><h3 id="upcomingdate"></h3></form>
      <p style="margin-bottom: 15px;">Current Reservation <input style="float: right;" onclick="showCurrentDate()" type="button" name="current" value="V"></p>
      <h3 id="currentdate" ></h3>
      <p>Past Reservations <input style="float: right;" onclick="showPastDate()" type="button" name="past" value="V"></p>
      <h3 id="pastdate" ></h3>
    </div>
    <script>

      var futurestr = <?php echo json_encode($future); ?>;
      var past = <?php echo json_encode($pastRes); ?>;
      var current = <?php echo json_encode($currentRes); ?>;
      var future = <?php echo json_encode($futureRes); ?>;
      var pastres = document.getElementById("pastdate");
      var currentres = document.getElementById("currentdate");
      var futureres = document.getElementById("upcomingdate");
      for (var i = 0; i < past.length; i++) {
        var p = document.createElement("p");
        var text = document.createTextNode(past[i]);
        var close = document.createElement("input");
        p.style.fontSize = '20px';
        p.appendChild(text);
        pastres.appendChild(p);
      }
      for (var i = 0; i < current.length; i++) {
        var p = document.createElement("p");
        var text = document.createTextNode(current[i]);
        var close = document.createElement("input");
        p.style.fontSize = '20px';
        p.appendChild(text);
        currentres.appendChild(p);

      }
      for (var i = 0; i < future.length; i++) {
        var p = document.createElement("p");
        var text = document.createTextNode(future[i]);
        var close = document.createElement("input");
        close.type = "submit";
        close.name = futurestr[i];
        close.value = "X";
        close.style.height = "23px";
        p.style.fontSize = '20px';
        p.appendChild(text);
        p.appendChild(close);
        futureres.appendChild(p);

      }
    </script>
    <script type="text/javascript">
      function showUpcomingDate(){
        offAll();
        document.getElementById("upcomingdate").style.display = "block";
      }
      function showCurrentDate(){
        offAll();
        document.getElementById("currentdate").style.display = "block";
      }
      function showPastDate(){
        offAll();
        document.getElementById("pastdate").style.display = "block";
      }
      function offAll(){
        document.getElementById("pastdate").style.display = "none";
        document.getElementById("currentdate").style.display = "none";
        document.getElementById("upcomingdate").style.display = "none";
      }
    </script>
  </body>
</html>
