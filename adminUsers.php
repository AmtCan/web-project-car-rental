<?php session_start(); ?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$usernames = [];
$usermails = [];
$usernumbers = [];
$sql = "SELECT *
        FROM users ";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
  $usernames[] = $row['username'];
  $usermails[] = $row['email'];
  $usernumbers[] = $row['phonenumber'];
}

 ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
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
      .userTable{
        width: 100%;
        background-color: #584E34;

      }
      .userTable table{
        border-radius: solid;
      }
      .userTable tr:hover{
        background-color: #CEDDD5;
      }
      .userTable tr:hover td{
        color: black
      }
      .userTable tr{
        font-size: 25px;
        border-style: solid;
      }
      .userTable td{
        border-style: solid;
        border-color: black;
        color: #CEDDD5;
      }
    </style>
  </head>
  <body>
    <div class="topnav">
        <a class="fa fa-home" onclick="offAll();" href="admin.php"> Home</a>
      </div>
      <div class="userTable">
      <table name = "usertable" id="users" style="width: 100%;">
        <tr>
          <th style="text-decoration: underline;">Name</th>
          <th style="text-decoration: underline;">E-mails</th>
          <th style="text-decoration: underline;">Phone</th>
        </tr>
      </table>
      <script>
        var names = <?php echo json_encode($usernames); ?>;
        var mails = <?php echo json_encode($usermails); ?>;
        var numbers = <?php echo json_encode($usernumbers); ?>;
        var table = document.getElementById("users");
        for (var i = 0; i < names.length; i++) {
          var name = names[i];
          var username = document.createTextNode(name);
          var tr = document.createElement("tr");
          var td = document.createElement("TD");
          td.appendChild(username);
          var tda = document.createElement("TD");
          var mail = document.createTextNode(mails[i]);
          tda.appendChild(mail);
          var tdb = document.createElement("TD");
          var number = document.createTextNode(numbers[i]);
          tdb.appendChild(number);
          tr.appendChild(td);
          tr.appendChild(tda);
          tr.appendChild(tdb);
          table.appendChild(tr);
        }
      </script>
    </div>
  </body>
</html>
