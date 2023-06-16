<?php
if (isset($_POST['signUp'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["UserName"] == "") {
            $nameErr = "User name required!";
        }
        if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["UserName"])) {
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
        $Phone = $_POST["phoneNumber"] . "";
        if (strlen($Phone) != 10) {
            $numberErr = "Phone number must have 10 number for example 5554443322";
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($passRptErr) && empty($notSame) && empty($numberErr)) {
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
            if (mysqli_num_rows($result) > 0) {
                $userTaken = "User name has been taken!";
            }
            $sql = "SELECT DISTINCT email
                FROM users
                WHERE email = '$email'";
            $result = $conn->query($sql);
            if (mysqli_num_rows($result) > 0) {
                $userTaken .= "/ E-mail has been taken!";
            }
            $sql = "SELECT DISTINCT phonenumber
                FROM users
                WHERE phonenumber = '$number'";
            $result = $conn->query($sql);
            if (mysqli_num_rows($result) > 0) {
                $userTaken .= "/ Number has been taken!";
            }
            if ($userTaken == " ") {
                $sql = "INSERT INTO users(`username`, `password`, `email`, `phonenumber`)
          VALUES ('$name', '$pass', '$email','$number');";
                if ($conn->query($sql) === TRUE) {
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $conn->close();
            } else {
                echo "<script type='text/javascript'>alert('$userTaken');</script>";
            }
        } elseif (!empty($nameErr)) {
            echo "<script type='text/javascript'>alert('$nameErr');</script>";
        } elseif (!empty($emailErr)) {
            echo "<script type='text/javascript'>alert('$emailErr');</script>";
        } elseif (!empty($passwordErr)) {
            echo "<script type='text/javascript'>alert('$passwordErr');</script>";
        } elseif (!empty($passRptErr)) {
            echo "<script type='text/javascript'>alert('$passRptErr');</script>";
        } elseif (!empty($notSame)) {
            echo "<script type='text/javascript'>alert('$notSame');</script>";
        } elseif (!empty($numberErr)) {
            echo "<script type='text/javascript'>alert('$numberErr');</script>";
        }
    }
}
?>