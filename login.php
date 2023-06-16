<?php
  include 'connection.php';
  $name = $pass = $email = $number = "";
  $nameErr = $passwordErr = $emailErr = $passRptErr = $notSame = $numberErr = "";
  $usertaken = "";
  $signLoginUp = "";

  if (isset($_POST['login'])) {

    if ($_POST["e-mail"] == "") {
      $emailErr = "E-mail required!";
    } elseif ($emailErr == "") {
      $pass = md5($_POST["password"]);
      $email = $_POST["e-mail"];
      $sql = "SELECT email
                 FROM users
                 WHERE email = '$email'";
      $result = $conn->query($sql);
      if (mysqli_num_rows($result) == 0) {
        $emailErr = "invalid E-mail";
      }
      if ($emailErr == "") {
        $sql = "SELECT password
                   FROM users
                   WHERE password = '$pass' AND email ='$email'";
        $result = $conn->query($sql);
        if (mysqli_num_rows($result) == 0) {
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
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($email == $row["email"] && $pass == $row["password"]) {
          $sql = "SELECT userid
                 FROM users
                 WHERE email = '$email';";
          $result = $conn->query($sql);
          $row = $result->fetch_assoc();
          $idofuser = $row["userid"];
          $_SESSION["userid"] = $idofuser;

          $sql = "SELECT role
                 FROM users
                 WHERE email = '$email';";
          $result = $conn->query($sql);
          $row = $result->fetch_assoc();
          $role = $row["role"];
          if ($role == "admin") {
            header("location: admin.php");
          } else {
            header("location: mainPage.php");
          }

        }
      }
    }
  }
  ?>