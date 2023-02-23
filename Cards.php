<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php session_start();?>
<?php
  $servername = "localhost";
  $dbname = "car_rental";
  $password = "";
  $username = "root";
  $idofuser = $_SESSION["userid"];
  $card_array = [];
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  $sql = "SELECT *
          FROM cards
          WHERE userid = '$idofuser'";
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) {
    $card_array[]= $row['cardnumber'];
  }
  if (count($card_array) == 0) {
  }
  else {
      foreach ($card_array as $value) {
         if (isset($_POST["$value"])){
           $sql = "DELETE FROM cards WHERE  cardnumber = '$value'";
           if ($conn->query($sql) === TRUE) {
           } else {
           }
           header("location:Cards.php");
           }
        }
    }


  ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
      .fa {
        opacity: 1;
        text-decoration: none;
      }
      body{
        background: transparent;
        margin: 0;
        background-image: url("car8.jpg");
        animation:image 25s infinite alternate;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
      }
      @keyframes image{
        0%{
          background:url("car8.jpg");
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: cover;
        }

        25%{
          background:url("car7.jpg");
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: cover;
        }
        50%{
          background:url("car5.jpg");
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: cover;
        }
        75%{
          background:url("car4.jpg");
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: cover;
        }
        100%{
          background:url("car1.jpg");
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: cover;
        }
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
        background-color: brown;
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


    </style>
  </head>
  <body>

    <div class="topnav">
        <a class="fa fa-home" onclick="offAll();" href="mainPage.php"> Home</a>
      </div>
      <form class="" action="#" method="post">
        <div class="container" style="position: absolute; left: 50%; top: 200px; margin-left:-175px;">
          <div style="">
            <h1 style="font-size:40px; color:#CEDDD5; font-family: monospace;">Cards</h1>
          </div>
          <div id="card-con">

          </div>
        </div>
      </form>
      <script>

        var cardarray = <?php echo json_encode($card_array); ?>;
        for (var i = 0; i < cardarray.length; i++) {
          var tag = document.createElement("p");
          var info = document.createTextNode(cardarray[i]);
          var close = document.createElement("input");
          close.classList.add("closeicon");
          close.type = "submit";
          close.name = cardarray[i];
          close.value = "X";
          tag.appendChild(info);
          tag.appendChild(close);
          var element = document.getElementById("card-con");

          element.appendChild(tag);
          }
      </script>
    </body>
</html>
