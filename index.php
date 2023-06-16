<?php session_start();
include 'login.php';
include 'signup.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/styles-login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Rent a Car</title>
</head>

<body>
  <!-- Top navbar -->
  <div class="topnav">
    <a class="fa fa-home" onclick="offAll();" href="index.php"> Home</a>
    <a class="fa fa-book" onclick="onA()" href="#about"> About</a>
    <a class="fa fa-phone" onclick="onC()" href="#contact"> Contact</a>
  </div>

  <!--Sign up container-->
  <div class="login-signup-container">
    <div id="About" onclick="offA()">
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
        <a class="fa fa-facebook" style="font-size: 35px; color:#CEDDD5" href="https://www.facebook.com/"
          style="text-decoration: none;">
          Facebook</a>
        <br>
        <br>
        <br>
        <a class="fa fa-youtube" style="font-size: 35px; color:#CEDDD5" href="https://www.youtube.com/"
          style="text-decoration: none;">
          Youtube</a>
        <br>
        <br>
        <br>
        <a class="fa fa-twitter" style="font-size: 35px; color:#CEDDD5" href="https://www.twitter.com/"
          style="text-decoration: none;">
          Twitter</a>
      </div>
    </div>

    <div id="signUp" class="sign-container">
      <form action="index.php" method="post">
        <div>
          <a id="close-sign" href="#" onclick="offAll()">x</a>
          <h1>Sign Up</h1>
        </div>
        <div class="sign-up-infos">
          <input type="text" name="UserName" placeholder="User Name"> <br>
          <input type="text" name="E-mail" placeholder="E-mail"><br>
          <input type="password" name="Password" placeholder="Password"><br>
          <input type="password" name="PasswordAgn" placeholder="Password again"><br>
          <input type="text" name="phoneNumber" placeholder="Phone Number"><br>
          <input id="sign-up-button" type="submit" name="signUp" value="Sign Up">
        </div>
      </form>
    </div>

    <!--Login container-->

    <div class="container">
      <form action="index.php" method="post">
        <div>
          <h1>Login</h1>
          <hr>
        </div>
        <div class="login-infos">
          <input type="text" name="e-mail" placeholder="E-mail">
          <p>
            <?php echo " " . $emailErr; ?>
          </p>
          <input type="password" name="password" placeholder="Password">
          <p>
            <?php echo " " . $passwordErr; ?>
          </p>
          <a><input id="login-button" type="submit" name="login" value="Login"></a>
          <p>Don't have an account?<a href="#" onclick="onnS()"> sign up</a></p>
        </div>
      </form>
    </div>
  </div>
</body>
<script src="js/script.js"></script>

</html>