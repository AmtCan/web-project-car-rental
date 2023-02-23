<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php session_start();?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
        body{
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
          width: 500px;
          height: 638px;
          padding: 10px;
        }
        .container input{
          padding: 20px;
          border-radius: 15px;
          background-color: rgba(44, 36, 3, 0.5);
          width: 220px;
          font-family: monospace;
          border-color: white;
          font-size: 18px;
          color: #CEDDD5;
        }
        .containerC {
          background-color: rgba(44, 36, 3, 0.8);
          width: 500px;
          height: 638px;
          padding: 10px;
          position: absolute;
          left: 525px;
          top: 95px;
        }
        .containerC input{
          padding: 20px;
          border-radius: 15px;
          background-color: rgba(44, 36, 3, 0.5);
          width: 220px;
          font-family: monospace;
          border-color: white;
          font-size: 18px;
          color: #CEDDD5;
        }
        .containerK {
          background-color: rgba(44, 36, 3, 0.8);
          width: 500px;
          height: 638px;
          padding: 10px;
          position: absolute;
          width: 466px;
          left: 1050px;
          top: 95px;
        }
        .containerK input{
          padding: 20px;
          border-radius: 15px;
          background-color: rgba(44, 36, 3, 0.5);
          width: 220px;
          font-family: monospace;
          border-color: white;
          font-size: 18px;
          color: #CEDDD5;
        }
        .container p{
          font-family: monospace;
          font-size: 25px;
          color: #CEDDD5
        }
        .containerC p{
          font-family: monospace;
          font-size: 25px;
          color: #CEDDD5
        }
        .containerK p{
          font-family: monospace;
          font-size: 25px;
          color: #CEDDD5
        }
        .container h1{
          font-size:40px;
          color:#CEDDD5;
          font-family: monospace;
          text-align: center;
        }
        .containerC h1{
          font-size:40px;
          color:#CEDDD5;
          font-family: monospace;
          text-align: center;
        }
        .containerK h1{
          font-size:40px;
          color:#CEDDD5;
          font-family: monospace;
          text-align: center;
        }
         @media only screen and (max-width: 1500px){
           [class="containerK"]{
             position: absolute;
             top: 760px;
             left: 0px;
             width: 500px;

           }
         }
         @media only screen and (max-width: 900px){
           [class="containerC"]{
             position: absolute;
             top: 760px;
             left: 0px;
             width: 500px;

           }
           [class="containerK"]{
             position: absolute;
             top: 1460px;
             left: 0px;
             width: 500px;

           }
         }
    </style>
  </head>
  <body>
    <?php
    $servername = "localhost";
    $dbname = "car_rental";
    $username = "root";
    $password = "";
    $name = $pass = $email = $number = $passRpt = "";
    $nameErr = $passwordErr = $emailErr = $passRptErr = $notSame = $numberErr = $currentPassErr = "";
    $cardErr = $cardExist = "";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $email = $_SESSION['e-mail'];
    $idofuser = $_SESSION['userid'];
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);}
    if (isset($_POST['nameChange'])) {
      $name = $_POST['Name'];
      if ($name == "") {
        $nameErr = "User name required!";
      }
      if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $nameErr = "Only letters and white space allowed";
      }
      if (strlen($name) > 20) {
        $nameErr = "Maximum length is 20 characters";
      }
      $sql = "SELECT DISTINCT username
              FROM users
              WHERE username = '$name'";
      $result = $conn->query($sql);
      if(mysqli_num_rows($result) > 0){
        $nameErr = "User name has been taken!";
      }
      if (empty($nameErr)) {
            $sql = "UPDATE users
            SET username = '$name'
            WHERE userid = '$idofuser'";
            if ($conn->query($sql) === TRUE) {}
      }
    }
    $sql = "SELECT username
            FROM users
            WHERE userid = '$idofuser';";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $nameofuser = $row["username"];

    if (isset($_POST['emailChange'])) {
      $email = $_POST['Email'];
      if (!filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid e-mail format!";
      }
      $sql = "SELECT DISTINCT email
              FROM users
              WHERE email = '$email'";
      $result = $conn->query($sql);
      if(mysqli_num_rows($result) > 0){
        $emailErr = "E-mail name has been taken!";
      }
      if (empty($emailErr)) {
            $sql = "UPDATE users
            SET email = '$email'
            WHERE userid = '$idofuser'";
            if ($conn->query($sql) === TRUE) {}
      }
    }
    $sql = "SELECT email
            FROM users
            WHERE userid = '$idofuser';";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $emailofuser = $row["email"];

    if (isset($_POST['passChange'])) {
      $pass = md5($_POST['newPass']);
      $passRpt = md5($_POST['newPassRpt']);
      if ($pass == md5("")) {
        $passwordErr = "New Password required!";
      }
      elseif ($passRpt == md5("")) {
        $passwordErr = "New Password again required!";
      }
      if ($pass != $passRpt) {
        $passwordErr = "Password missmatch!";
      }
      $sql = "SELECT password
              FROM users
              WHERE userid = '$idofuser'";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $passwordofuser = $row["password"];
      if ($passwordofuser != md5($_POST["oldPass"])) {
        $currentPassErr = "Wrong Password";
      }
      if (empty($passwordErr) && empty($currentPassErr)) {
            $sql = "UPDATE users
            SET password = '$pass'
            WHERE userid = '$idofuser'";
            if ($conn->query($sql) === TRUE) {}
      }
    }
    $sql = "SELECT email
            FROM users
            WHERE userid = '$idofuser';";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $emailofuser = $row["email"];

    if (isset($_POST['numberChange'])) {
      $number = $_POST['newnumber'];
      if ($number == "") {
        $numberErr = "number required!";
      }
      if (strlen($number)!=10) {
        $numberErr = "Phone number must have 10 number for example 5554443322";
      }
      $sql = "SELECT phonenumber
              FROM users
              WHERE userid = '$idofuser'";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $numberofuser = $row['phonenumber'];
      if ($numberofuser != $_POST['phoneNumber']) {
        $numberErr = "Wrong number!";
      }
      if (strlen($_POST['phoneNumber'])!=10) {
        $numberErr = "Phone number must have 10 number for example 5554443322";
      }
      if (empty($numberErr)) {
            $sql = "UPDATE users
            SET phonenumber = '$number'
            WHERE userid = '$idofuser'";
            if ($conn->query($sql) === TRUE) {}
      }
    }
    if (isset($_POST['addCard'])) {
      $cardNumber = $_POST['cardNumber'];
      $cardNumberYear = $_POST['cardNumberYear'];
      $cardNumberMonth = $_POST['cardNumberMonth'];
      $cardOwner = $_POST['ownerName'];
      $cardCvv = $_POST['cvv'];
      if (empty($cardNumber) || empty($cardNumberYear) || empty($cardNumberMonth) || empty($cardOwner) ||empty($cardCvv) ) {
        $cardErr = "Empty input!";
      }
      elseif(strlen($cardNumber)!=16) {
        $cardErr = "Invalid card number!";
      }
      elseif ($cardNumberMonth > 12 || $cardNumberMonth < 1) {
        $cardErr = "Invalid date value!";
      }
      elseif (!preg_match("/^[a-zA-Z-' ]*$/",$cardOwner)) {
        $cardErr = "Only letters and white space allowed";
      }
      elseif (strlen($cardCvv) > 3 || strlen($cardCvv) < 1) {
        $cardErr = "Invalid cvv value";
      }
      if (empty($cardErr)) {
        $sql = "SELECT cardnumber
                FROM cards
                WHERE cardnumber = '$cardNumber'";
        $result = $conn->query($sql);
        if(mysqli_num_rows($result) > 0){
          $cardErr = "Card is already added!";
        }
        if (empty($cardErr)) {
          $sql = "INSERT INTO cards(`cardnumber`, `cardmonth`, `cardyear`, `cvv`, `cardowner`, `userid`)
                  VALUES('$cardNumber', '$cardNumberMonth', '$cardNumberYear', '$cardCvv', '$cardOwner', '$idofuser' )";
                  if ($conn->query($sql) === TRUE) {}
                    else {
                  echo "Error: " . $sql . "<br>" . $conn->error;
                  }
                  $conn->close();
        }
      }
    }
    ?>
    <div class="topnav">
      <a class="fa fa-home" onclick="offAll();" href="mainPage.php"> Home</a>
      </div>
    <div id="profile" class="container" style=" position: absolute; left: 0px; top: 95px;">
      <form action="#" method="post">
      <div style="padding:20px; margin: -20px;">
        <h1>Profile Information</h1>
        </div>
        <div style="margin:0;">
            <p><?php echo $nameofuser; ?> <span style="color: red;"><?php echo $nameErr; ?></span></p>
            <input type="text" name="Name" placeholder="Change Username">
            <input style=" margin:0px 0px 0px 25px; cursor:pointer; background-color: #584E34;" type="submit" name="nameChange" value="Change">
          </div>
        <div>
          <p>Change Password:</p>
          <input style="font-size: 15px;" type="password" name="oldPass" placeholder="Current Password"><span style="font-family: monospace; font-size: 25px;color: red;"> <?php echo $currentPassErr;?></span> <br><br>
          <input style="font-size: 15px;" type="password" name="newPass" placeholder="New Password"><span style="font-family: monospace; font-size: 25px;color: red;"> <?php echo $passwordErr;?></span><br><br>
          <input style="font-size: 15px;" type="password" name="newPassRpt" placeholder="New Password Again">
          <input style=" margin:0px 0px 0px 25px; cursor:pointer; background-color: #584E34;" type="submit" name="passChange" value="Change">
        </div>
          </form>
      </div>
      <div class="containerC">
        <form action="#" method="post">
        <div style="padding:20px; margin: -20px;">
          <h1>Contact</h1>
        </div>
        <div style="margin:0;">
          <p style="margin-left:15px;"><?php echo $emailofuser;?> <span style="color: red;"><?php echo $emailErr; ?></span></p>
          <input style="margin-left:15px;" type="text" name="Email" placeholder="Change E-mail">
          <input style=" margin:0px 0px 0px 25px; cursor:pointer; background-color: #584E34;" type="submit" name="emailChange" value="Change">
        </div>
        <div>
          <p style="margin-left:15px;">Phone Number: 111 222 3333</p>
          <p style="margin-left:15px;">Change Phone Number:</p>
          <input style="font-size: 15px; margin-left:15px;" type="text" name="phoneNumber" placeholder="Current Phone Number"> <br><br>
          <input style="font-size: 15px; margin-left:15px;" type="text" name="newnumber" placeholder="New Phone Number">
          <input onclick="change()" style=" margin:0px 0px 0px 25px; cursor:pointer; background-color: #584E34;" type="submit" name="numberChange" value="Change">
          <span style="font-family: monospace; font-size: 25px;color: red;"> <?php echo $numberErr;?></span>
        </div>
      </form>
      </div>
      <div class="containerK">
        <div style="padding:20px; margin-top:20px;">
          <h1 style="margin-top:-20px;">Add Card</h1>
        </div>
        <div style="margin:0;">
          <form  action="#" method="post">
            <p style="margin: -5px 0px 0px 15px">Card Number: <input style="width: 240px;" type="text" name="cardNumber" placeholder="0000-0000-0000-0000"></p>
            <p style="margin-left: 15px">Date: <input style="width: 100px" type="text" name="cardNumberMonth" placeholder="Month">
            <input style="width: 100px" type="text" name="cardNumberYear" placeholder="Year"></p>
            <p style="margin-left: 15px">Card Owner Name: <input style="width:200px;"type="text" name="ownerName" placeholder="Name Surname"></p>
            <p style="margin-left: 15px">Card CVV: <input style="width:200px;"type="text" name="cvv" placeholder="CVV"></p>
            <input style=" margin:0px 0px 0px 25px; cursor:pointer; background-color: #584E34;" type="submit" name="addCard" value="Add">
            <p style="color: red"> <?php echo "    ".$cardErr; ?></p>
          </form>
        </div>
      </div>

  </body>
</html>
