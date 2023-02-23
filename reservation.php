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
  $futureEnd = [];
  $futureCost = [];
  $future = [];
  $futurecarids = [];
  $pastcars = [];
  $currentcars = [];
  $sql = "SELECT *
          FROM reservation
          WHERE userid = '$userid' AND (startdate < '$timezone' AND enddate < '$timezone')";
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) {
    $pastCars[] = $row['carids'];
    $pastRes[]= "Start date: ".$row['startdate']." | "."End date: ".$row['enddate']."|------| Cost: ".$row['cost'];
  }
  $sql = "SELECT *
          FROM reservation
          WHERE userid = '$userid' AND (startdate <= '$timezone' AND enddate >= '$timezone')";
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) {
    $currentcars[] = $row['carids'];
    $currentRes[]= "Start date: ".$row['startdate']." | "."End date: ".$row['enddate']."|------| Cost: ".$row['cost'];
  }
  $sql = "SELECT *
          FROM reservation
          WHERE userid = '$userid' AND (startdate > '$timezone' AND enddate > '$timezone')";
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) {
    $future[] = $row['reservationid'];
    $futureRes[]= "Start date: ".$row['startdate'];
    $futureEnd[]= "End date: ".$row['enddate'];
    $futureCost[]= "Cost: ".$row['cost'];
    $futurecarids[] = $row['carids'];

  }
  $asd= "";
  if (count($future) == 0) {

  }
  else {
    foreach ($future as $value){
      if (isset($_POST["$value"])) {
        $_SESSION["deleted"] = $value;
      }
    }

    if (isset($_POST["delete"])) {
      $asd = $_SESSION["deleted"];
      $sql = "DELETE FROM reservation WHERE  reservationid = '$asd' AND userid = '$userid'";
      if ($conn->query($sql) === TRUE) {
      } else {
      }
      header("location:reservation.php");
    }
          foreach ($future as $value){
          $value2 = $value."edit";
        if (isset($_POST["$value2"])) {
          $_SESSION['reservationid'] = $value;
          header("location:edit.php");
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
    <div id="popup1" class="overlay">
     <div class="popup">
       <h2>Do you want to delete your reservation ?</h2>
       <a class="close" href="#">&times;</a>
       <div class="content">
         <form class="" action="#" method="post">
            <button style="margin-right:30%; margin-left:15%; width: 20%;" class="button" type="submit" name="delete">Yes</button>
            <button style=" width: 20%;" class="button" type="submit" name="No">No</button>
          </form>
       </div>
     </div>
    </div>
    <script>

      var futurestr = <?php echo json_encode($future); ?>;
      var past = <?php echo json_encode($pastRes); ?>;
      var current = <?php echo json_encode($currentRes); ?>;
      var future = <?php echo json_encode($futureRes); ?>;
      var futureend = <?php echo json_encode($futureEnd); ?>;
      var futurecost = <?php echo json_encode($futureCost); ?>;
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
        var editname = futurestr[i]+"edit";
        var textt = document.createTextNode(futureend[i]);
        var texttt = document.createTextNode(futurecost[i]);
        var close = document.createElement("input");
        var edit = document.createElement("input");
        var br = document.createElement("br");
        var br2 = document.createElement("br");
        var form = document.createElement("form");
        form.action = "#popup1";
        edit.type = "submit";
        edit.name = editname;
        edit.value = "change";
        edit.style.height = "22px";
        edit.style.backgroundColor = "green";
        close.type = "submit";
        close.name = futurestr[i];
        close.value = "X";
        close.style.height = "22px";
        close.style.backgroundColor = "red";
        form.method = "post";
        form.appendChild(close);

        p.style.fontSize = '20px';
        p.appendChild(text);
        p.appendChild(edit);
        p.appendChild(br);
        p.appendChild(textt);
        p.appendChild(br2);
        p.appendChild(texttt);
        p.appendChild(form);
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
