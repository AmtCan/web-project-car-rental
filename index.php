<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php session_start();?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <style media="screen">
        .fa {
          opacity: 1;
          text-decoration: none;
        }
        #About {
          position: absolute;
          display: none;
          width: 700px;
          height: 400px;
          top: 200px;
          left: 100px;
          background-color: rgba(0,0,0,0.6);
          z-index: 2;
        }
        #Contact {
          position: absolute;
          display: none;
          width: 700px;
          height: 400px;
          top: 200px;
          left: 100px;
          background-color: rgba(0,0,0,0.6);
          z-index: 2;
        }
        #aboutSite {
          position: absolute;
          top: 50px;
          left: 100px;
          font-size: 20px;
          color: #CEDDD5;
        }
        #aboutContact {
          position: absolute;
          top: 20px;
          left: 100px;
          font-size: 20px;
          color: #CEDDD5;
        }
        body {
          background-image: url('car3.jpg');
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: cover;
          margin: 0;
          font-family: monospace;
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
          background-color: rgba(44, 36, 3, 0.8);
          width: 350px;
          height: 500px;
          padding: 10px;
          border-radius: 25px;
          position: absolute;
          right: 10%; top: 25%;

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
        .container span{
          text-align: center;
          color: white;
          font-size: 8px;
        }
        .sign-container {
          background-color: rgba(44, 36, 3, 0.8);
          text-align: center;
          width: 350px;
          height: 525px;
          padding: 10px;
          border-radius: 25px;
          position: absolute;
          left: 10%; top:25%;
        }
        .sign-container input{
          padding: 20px;
          border-radius: 15px;
          background-color: rgba(44, 36, 3, 0.5);
          width: 220px;
          font-family: monospace;
          border-color: white;
          font-size: 18px;
          color: #CEDDD5;
        }
        .aboutS{
          background-color: red;
        }
        @media only screen and (max-width: 900px) {
          /* For mobile phones: */
          [class="sign-container"] {
            top: 650px;
            left: 5%;
          }
          [class="container"] {
            left: 5%;
          }
        }
      </style>
  </head>
<body>
  <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "car_rental";
      $name = $pass = $email = $number ="";
      $nameErr = $passwordErr = $emailErr = $passRptErr = $notSame = $numberErr = "";
      $usertaken ="";
      $signLoginUp ="";
   ?>
   <?php
   if (isset($_POST['login'])) {
     $conn = mysqli_connect($servername, $username, $password, $dbname);
     if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
     }
     if ($_POST["e-mail"] == "") {
       $emailErr = "E-mail required!";
     }
     elseif ($emailErr == "") {
         $pass = md5($_POST["password"]);
         $email = $_POST["e-mail"];
         $sql = "SELECT email
                 FROM users
                 WHERE email = '$email'";
         $result = $conn->query($sql);
         if(mysqli_num_rows($result) == 0){
           $emailErr = "invalid E-mail";
         }
         if ($emailErr == "") {
           $sql = "SELECT password
                   FROM users
                   WHERE password = '$pass' AND email ='$email'";
           $result = $conn->query($sql);
           if(mysqli_num_rows($result) == 0){
             $passwordErr = "Wrong password";
           }
         }
     }
     if ($_POST["password"] == "") {
       $passwordErr = "Password required!";
     }
     $result;
     if (empty($passwordErr) && empty($emailErr)) {
       $_SESSION["e-mail"] = $email;
       $sql = "SELECT email, password
               FROM users
               WHERE password = '$pass' AND email ='$email'";
       $result = $conn->query($sql);
       if ($result->num_rows > 0){
       $row = $result->fetch_assoc();
       if ($email == $row["email"] && $pass == $row["password"]) {
         $sql = "SELECT userid
                 FROM users
                 WHERE email = '$email';";
         $result = $conn->query($sql);
         $row = $result->fetch_assoc();
         $idofuser = $row["userid"];
         $_SESSION["userid"] = $idofuser;
         header("location: mainPage.php");
       }
     }
   }
}
    ?>
<!-- Top navbar -->
<div class="topnav">
    <a class="fa fa-home" onclick="offAll();" href="index.php"> Home</a>
      <script type="text/javascript">
        function offAll(){
          offA();
          offC();
          offS();
        }
        </script>
        <a class="fa fa-book" onclick="onA()" href="#about"> About</a>
        <script>
        function onA() {
          document.getElementById("About").style.display = "block";
          offC();
          offS();
        }
        function offA() {
          document.getElementById("About").style.display = "none";
        }
        </script>
        <a class= "fa fa-phone" onclick="onC()" href="#contact"> Contact</a>
        <script>
        function onC() {
          document.getElementById("Contact").style.display = "block";
          offA();
          offS();
        }
        function offC() {
          document.getElementById("Contact").style.display = "none";
        }
        </script>

      </div>
    <div  id="About" onclick="offA()">
      <div id="aboutSite">
        <h1>About Site</h1>
        <p>This site helps you to rent car. There are a lot of car type here. You can
          create your own profile and start searching for car that you want to rent.</p>
        </div>
      </div>
    <div id="Contact" onclick="offC()">
      <div id="aboutContact">
        <h2 style="font-size: 30px; width:500px;">You can contact with us here.</h2>
        <br>
        <br>
        <a class="fa fa-facebook" style="font-size: 35px; color:#CEDDD5" href="https://www.facebook.com/" style="text-decoration: none;">
          Facebook</a>
          <br>
          <br>
          <br>
          <a class="fa fa-youtube" style="font-size: 35px; color:#CEDDD5" href="https://www.youtube.com/" style="text-decoration: none;">
            Youtube</a>
            <br>
            <br>
            <br>
            <a class="fa fa-twitter" style="font-size: 35px; color:#CEDDD5" href="https://www.twitter.com/" style="text-decoration: none;">
        Twitter</a>
      </div>
    </div>

<!--Login container-->

<div class="container" style="">
  <form action="index.php" method="post">
    <div style="padding:20px; margin: -10px;">
      <h1 style="text-align:center; font-size:40px; color:#CEDDD5; font-family: monospace;">Login</h1>
      </div>
      <div style="margin-bottom: 15px; margin-left: 65px;">
      <input  type="text" name="e-mail" placeholder="E-mail">
      </div>
      <div style="text-align: center;">
        <p style="color: white;"><?php echo " ". $emailErr; ?></p>
      </div>
      <div style="margin-left: 65px;">
      <input  type="password" name="password" placeholder="Password">
    </div>
    <div style="text-align: center;">
      <p style="color: white;"><?php echo " ". $passwordErr; ?></p>
    </div>
    <div style="margin-top: 30px; margin-left: 65px;">
      <a href="#"><input style=" background-color: #584E34;" type="submit" name="login" value="Login"></a>
    </div>
    <div>
      <p style="margin-left: 65px; color:#CEDDD5; font-size: 15px; ">
        Don't have an account?
         <a href="#" onclick="onnS()" onMouseOver="this.style.color='#f00'"
            onMouseOut="this.style.color='#767C68'"
            style="color: #767C68; text-decoration: none;">
           sign up
         </a>
       </p>
    </div>
  </form>
</div>

  <!--Sign up container-->

<div id="signUp" class="sign-container" style="display: none;">
  <form action="index.php" method="post">
  <div style="padding:20px; margin: -20px;">
    <a href="#" onclick="offS()" style="float: right; color:#CEDDD5; font-size:25px; text-decoration: none;
    "onMouseOver="this.style.color='#f00'" onMouseOut="this.style.color='#CEDDD5'">
      x
    </a>
    <h1 style="font-size:40px; color:#CEDDD5; font-family: monospace;">Sign Up</h1>
    </div>
    <div style="margin-top:1px;">
      <input  type="text" name="UserName" placeholder="User Name">
    </div>
    <div style="margin-top:1px;">
      <input  type="text" name="E-mail" placeholder="E-mail">
    </div>
    <div style="margin-top:1px;">
      <input  type="password" name="Password" placeholder="Password">
    </div>
    <div style="margin-top:1px;">
      <input  type="password" name="PasswordAgn" placeholder="Password again">
    </div>
    <div style="margin-top:1px;">
      <input  type="text" name="phoneNumber" placeholder="Phone Number">
    </div>
    <div style="margin-top:1px;">
      <input style=" background-color: #584E34;" type="submit" name="signUp" value="Sign Up">
    </div>
  </form>
</div>
<?php
if (isset($_POST['signUp'])) {
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
      if ($_POST["UserName"] == "") {
        $nameErr = "User name required!";
      }
      if (!preg_match("/^[a-zA-Z-' ]*$/",$_POST["UserName"])) {
        $nameErr = "Only letters and white space allowed";
      }
      if (strlen($_POST["UserName"]) > 20) {
        $nameErr = "Maximum length is 20 characters";
      }
      if ($_POST["E-mail"] == "") {
        $emailErr = "E-mail required!";
      }
      if (!filter_var($_POST["E-mail"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
      }
      if ($_POST["Password"] == "") {
        $passwordErr = "Password required!";
      }
      if ($_POST["PasswordAgn"] == "") {
        $passRptErr = "Password again required!";
      }
      if ($_POST["Password"] != $_POST["PasswordAgn"]) {
        $notSame = "Password missmatch!";
      }
      if ($_POST["phoneNumber"] == "") {
        $numberErr = "Phone number required!";
      }
      $Phone = $_POST["phoneNumber"]."";
      if (strlen($Phone)!=10) {
        $numberErr = "Phone number must have 10 number for example 5554443322";
      }
    }
    if ($_SERVER["REQUEST_METHOD"]=="POST"){
      if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($passRptErr) && empty($notSame) &&empty($numberErr)) {
        $name = $_POST["UserName"];
        $pass = md5($_POST["Password"]);
        $email = $_POST["E-mail"];
        $number = $_POST["phoneNumber"];

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        $userTaken = " ";
        $sql = "SELECT DISTINCT username
                FROM users
                WHERE username = '$name'";
        $result = $conn->query($sql);
        if(mysqli_num_rows($result) > 0){
          $userTaken = "User name has been taken!";
        }
        $sql = "SELECT DISTINCT email
                FROM users
                WHERE email = '$email'";
        $result = $conn->query($sql);
        if(mysqli_num_rows($result) > 0){
          $userTaken .= "/ E-mail has been taken!";
        }
        $sql = "SELECT DISTINCT phonenumber
                FROM users
                WHERE phonenumber = '$number'";
        $result = $conn->query($sql);
        if(mysqli_num_rows($result) > 0){
          $userTaken .= "/ Number has been taken!";
        }
        if ($userTaken == " "){
          $sql ="INSERT INTO users(`username`, `password`, `email`, `phonenumber`)
          VALUES ('$name', '$pass', '$email','$number');";
          if ($conn->query($sql) === TRUE) {}
            else {
          echo "Error: " . $sql . "<br>" . $conn->error;
          }
          $conn->close();
        }
        else {
          echo "<script type='text/javascript'>alert('$userTaken');</script>";
        }
      }
      elseif (!empty($nameErr)) {
        echo "<script type='text/javascript'>alert('$nameErr');</script>";
      }
      elseif (!empty($emailErr)) {
        echo "<script type='text/javascript'>alert('$emailErr');</script>";
      }
      elseif (!empty($passwordErr)) {
        echo "<script type='text/javascript'>alert('$passwordErr');</script>";
      }
      elseif (!empty($passRptErr)) {
        echo "<script type='text/javascript'>alert('$passRptErr');</script>";
      }
      elseif (!empty($notSame)) {
        echo "<script type='text/javascript'>alert('$notSame');</script>";
      }
      elseif (!empty($numberErr)) {
        echo "<script type='text/javascript'>alert('$numberErr');</script>";
      }
    }
    }
?>

<script>
  function onnS(){
    document.getElementById("signUp").style.display = "block";
    document.getElementById("signUp").style.opacity = 1;
    offA();
    offC();
  }
  function offS(){
    document.getElementById("signUp").style.display = "none";
    document.getElementById("signUp").style.opacity = 0;
  }
</script>

</body>
</html>
