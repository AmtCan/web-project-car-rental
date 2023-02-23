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
    $dateError = $cityError = "";
    $email = $_SESSION["e-mail"];
    $idofuser = $_SESSION['userid'];
    $sql = "SELECT username
            FROM users
            WHERE userid = '$idofuser';";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $user_name = $row["username"];
    $_SESSION['username'] = $user_name;
    // Carid and Car image selection.
    $cartypes = [];
    $car_array = [];
    $car_brand = [];
    $car_id = [];
    $carcount = 0;
    $sql = "SELECT *
          FROM cars;";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
      $car_img[$row['carid']]= $row['carimage'];
     }
     // cartype selection.
     $sql = "SELECT DISTINCT cartype
           FROM cars;";
           $result = $conn->query($sql);
           while ($row = $result->fetch_assoc()) {
       $cartypes[] = $row['cartype'];
      }

    // Car brand selection.
    $sql = "SELECT DISTINCT carbrand
            FROM cars;";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
      $car_brand[]= $row['carbrand'];
    }
    $sql = "SELECT cityname
            FROM cities;";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
      $cities[]= $row['cityname'];
    }

    // Selecting brand.
    $car_id = [];
    if (isset($_POST["submitbrand"])) {

      $brand = $_POST["brand"];
      $type = $_POST["types"];
      $start = $_POST["startdate"];
      $end = $_POST["enddate"];
      $city = $_POST["City"];

      if (empty($start) || empty($end)) {
        if ($city == "All cities" && $brand == "All cars" && $type == "All types") {
          $sql = "SELECT *
                  FROM cars
                  ";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            $car_array[]= $row['carimage'];
            $car_id[]= $row['carid'];
          }
          $carcount = count($car_array);
        }
        elseif ($city == "All cities" && $brand == "All cars") {
          $sql = "SELECT *
                  FROM cars
                  WHERE cartype = '$type'
                  ";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            $car_array[]= $row['carimage'];
            $car_id[]= $row['carid'];
          }
          $carcount = count($car_array);
        }
        elseif ($type == "All types" && $brand == "All cars") {
          $sql = "SELECT *
                  FROM cars
                  WHERE caraddress = '$city'
                  ";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            $car_array[]= $row['carimage'];
            $car_id[]= $row['carid'];
          }
          $carcount = count($car_array);
        }
        elseif ($type == "All types" && $city == "All cities") {
          $sql = "SELECT *
                  FROM cars
                  WHERE carbrand = '$brand'
                  ";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            $car_array[]= $row['carimage'];
            $car_id[]= $row['carid'];
          }
          $carcount = count($car_array);
        }
        elseif ($city == "All cities") {
          $sql = "SELECT *
                  FROM cars
                  WHERE carbrand = '$brand' AND cartype = '$type';
                  ";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            $car_array[]= $row['carimage'];
            $car_id[]= $row['carid'];
          }
          $carcount = count($car_array);
        }
        elseif ($brand == "All cars") {
          $sql = "SELECT *
                  FROM cars
                  WHERE caraddress = '$city' AND cartype = '$type';
                  ";
          $result = $conn->query($sql);

          while ($row = $result->fetch_assoc()) {
            $car_array[]= $row['carimage'];
            $car_id[]= $row['carid'];
          }
          $carcount = count($car_array);
        }
        elseif ($type == "All types") {
          $sql = "SELECT *
                  FROM cars
                  WHERE caraddress = '$city' AND carbrand = '$brand';
                  ";
          $result = $conn->query($sql);

          while ($row = $result->fetch_assoc()) {
            $car_array[]= $row['carimage'];
            $car_id[]= $row['carid'];
          }
          $carcount = count($car_array);
        }
        else {
          $sql = "SELECT *
                  FROM cars
                  WHERE carbrand ='$brand' AND caraddress = '$city' AND cartype = '$type' ";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
                $car_array[]= $row['carimage'];
                $car_id[]= $row['carid'];
              }
              $carcount = count($car_array);
            }
            $conn->close();
          }
        }
        else {
          if ($brand == "All cars" && $city == "All cities" && $type == "All types") {
            $sql = "SELECT *
                    FROM cars
                    WHERE carid NOT IN (SELECT carids
                            FROM reservation
                            WHERE (startdate BETWEEN '$start' AND '$end') OR
                            (enddate BETWEEN '$start' AND '$end') OR
                            ('$start' BETWEEN startdate AND enddate) OR
                            ('$end' BETWEEN startdate AND enddate))";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              $car_array[]= $row['carimage'];
              $car_id[]= $row['carid'];
            }
            $carcount = count($car_array);
          }
          elseif ($brand == "All cars" && $city == "All cities") {
            $sql = "SELECT *
                    FROM cars
                    WHERE cartype = '$type' AND (carid NOT IN (SELECT carids
                            FROM reservation
                            WHERE (startdate BETWEEN '$start' AND '$end') OR
                            (enddate BETWEEN '$start' AND '$end') OR
                            ('$start' BETWEEN startdate AND enddate) OR
                            ('$end' BETWEEN startdate AND enddate))) ";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              $car_array[]= $row['carimage'];
              $car_id[]= $row['carid'];
            }
            $carcount = count($car_array);
          }
          elseif ($brand == "All cars" && $type == "All types") {
            $sql = "SELECT *
                    FROM cars
                    WHERE caraddress = '$city' AND (carid NOT IN (SELECT carids
                            FROM reservation
                            WHERE (startdate BETWEEN '$start' AND '$end') OR
                            (enddate BETWEEN '$start' AND '$end') OR
                            ('$start' BETWEEN startdate AND enddate) OR
                            ('$end' BETWEEN startdate AND enddate)))";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              $car_array[]= $row['carimage'];
              $car_id[]= $row['carid'];
            }
            $carcount = count($car_array);
          }
          elseif ($type == "All types" && $city == "All cities") {
            $sql = "SELECT *
                    FROM cars
                    WHERE carbrand = '$brand' AND (carid NOT IN (SELECT carids
                            FROM reservation
                            WHERE (startdate BETWEEN '$start' AND '$end') OR
                            (enddate BETWEEN '$start' AND '$end') OR
                            ('$start' BETWEEN startdate AND enddate) OR
                            ('$end' BETWEEN startdate AND enddate)))";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              $car_array[]= $row['carimage'];
              $car_id[]= $row['carid'];
            }
            $carcount = count($car_array);
          }
          elseif ($brand == "All cars") {
            $sql = "SELECT *
                    FROM cars
                    WHERE (cartype = '$type') AND (caraddress = '$city' AND (carid NOT IN (SELECT carids
                            FROM reservation
                            WHERE (startdate BETWEEN '$start' AND '$end') OR
                            (enddate BETWEEN '$start' AND '$end') OR
                            ('$start' BETWEEN startdate AND enddate) OR
                            ('$end' BETWEEN startdate AND enddate)))) ";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              $car_array[]= $row['carimage'];
              $car_id[]= $row['carid'];
            }
            $carcount = count($car_array);
          }
          elseif ($city == "All cities") {
            $sql = "SELECT *
                    FROM cars
                    WHERE (cartype = '$type') AND (carbrand = '$brand' AND (carid NOT IN (SELECT carids
                            FROM reservation
                            WHERE (startdate BETWEEN '$start' AND '$end') OR
                            (enddate BETWEEN '$start' AND '$end') OR
                            ('$start' BETWEEN startdate AND enddate) OR
                            ('$end' BETWEEN startdate AND enddate))))";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              $car_array[]= $row['carimage'];
              $car_id[]= $row['carid'];
            }
            $carcount = count($car_array);
          }
          elseif ($type == "All types") {
            $sql = "SELECT *
                    FROM cars
                    WHERE (carbrand = '$brand') AND (caraddress = '$city' AND (carid NOT IN (SELECT carids
                            FROM reservation
                            WHERE (startdate BETWEEN '$start' AND '$end') OR
                            (enddate BETWEEN '$start' AND '$end') OR
                            ('$start' BETWEEN startdate AND enddate) OR
                            ('$end' BETWEEN startdate AND enddate))))";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              $car_array[]= $row['carimage'];
              $car_id[]= $row['carid'];
            }
            $carcount = count($car_array);
          }
          else {
            $sql = "SELECT *
                    FROM cars
                    WHERE (cartype = '$type') AND ((caraddress = '$city') AND (carbrand = '$brand' AND carid NOT IN (SELECT carids
                            FROM reservation
                            WHERE (startdate BETWEEN '$start' AND '$end') OR (enddate BETWEEN '$start' AND '$end'))))";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              $car_array[]= $row['carimage'];
              $car_id[]= $row['carid'];
            }
            $carcount = count($car_array);
          }
        }
      }
    else {
      $sql = "SELECT *
              FROM cars;";
      $result = $conn->query($sql);
      while ($row = $result->fetch_assoc()) {
        $car_array[]= $row['carimage'];
        $car_id[]= $row['carid'];
      }
      $carcount = count($car_array);
    }
    // Adding ids to Session.
    if (count($car_id) == 0) {
    }
    else{foreach ($car_id as $value) {
      if (isset($_POST["$value"])){
          $idvalue = "car".$value;
          $_SESSION["carid"] = $value;
          $_SESSION["startdate"] =$start;
          $_SESSION["enddate"] =$end;
          $sql = "UPDATE cars SET reserve ='1' WHERE carid = $value";
          if (mysqli_query($conn, $sql)) {
          } else {
            echo "Error updating record: " . mysqli_error($conn);
          }
          header("location:carPage.php");
    }
  }
}
    // Selecting car

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/styles-main.css">
  </head>
  <body>
    <div class="topnav">
      <a class="fa fa-home" onclick="offAll();" href="mainPage.php"> Home</a>
        <script type="text/javascript">
          function offAll(){
            offA();
            offS();
          }
        </script>
      <a class="fa fa-book" onclick="onA()" href="Cards.php"> My Cards</a>
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
      <a style="float: right; padding: 40px 66px; cursor: pointer; text-decoration: none;" class="fa fa-power-off topnav" onclick="onOffDrop()">
      </a>
      <a class="fa fa-user" style="float: right;">
        <?php echo $user_name;?>
      </a>
      <div id="drop" class="dropdown" style="position: absolute; top: 97.5px; right: 0px; display: none;">
        <button onclick="profilePage()" class="dropdown-item" type="button" name="button">
          Profile
        </button>
        <button onclick="reserv()" class="dropdown-item" type="button" name="button">
          Reservations
        </button>
        <button onclick="signOut()" class="dropdown-item" type="button" name="button">
          Sign Out
        </button>
      </div>
      <script>
        function reserv() {
          location.href =  "reservation.php";
        }
        function signOut() {
          location.href =  "index.php";
        }
        function profilePage(){
          location.href =  "profile.php";
        }
        function onOffDrop(){
          if (document.getElementById("drop").style.display == "block") {
              document.getElementById("drop").style.display = "none";
          }
          else {
              document.getElementById("drop").style.display = "block";
          }
        }
        </script>
      </div>
    <div class="container">
        <h1>Filter</h1>
        <form class="" action="#" method="post">
          <p id="brandcar">Brand:
              <select class="selecter" id="brands" name = "brand">
                <option value="All cars">All cars</option>
              </select>
            </p>
            <p id="cartype">Car Type:
              <select class="selecter" id="types" name = "types">
                <option value="All types">All types</option>
              </select>
            </p>
              <p>Start Date:
                <input style="width:175px; height:10px;" type="date" name="startdate" value="">
              </p>
              <p>End Date:
                <input style="width:175px; height:10px;" type="date" name="enddate" value="">
              </p>
              <p id="CarCity">City:
                <select class="selecter" name="City" id="City">
                  <option value="All cities">All cities</option>
                </select>
              </p>
              <p style="margin-left: 57px;"><input type="submit" style="margin-top:-5px;" name="submitbrand" value="Filter"></p>
              </div>

    <div id="car-con"  class="carContainer">

    </div>
    <div class="carcount">
      <p>Car number: <?php echo $carcount; ?> </p>
    </div>
      <script>
         var types =<?php echo json_encode($cartypes); ?>;
         var typeSelect = document.getElementById("cartype");
         var typelist = document.getElementById("types");
         typelist.classList.add("selecter");
         for (var i = 0; i < types.length; i++) {
           var option = document.createElement("option");
           option.value = types[i];
           option.name = types[i];
           option.text = types[i];
           typelist.appendChild(option);
         }
         typeSelect.appendChild(typelist);


        var cities = <?php echo json_encode($cities); ?>;
        var cityselect = document.getElementById("CarCity");
        var citylist = document.getElementById("City");
        citylist.classList.add("selecter");
        for (var i = 0; i < cities.length; i++) {
          var option = document.createElement("option");
          option.value = cities[i];
          option.name = cities[i];
          option.text = cities[i];
          citylist.appendChild(option);
        }
        cityselect.appendChild(citylist);

        var carbrand = <?php echo json_encode($car_brand); ?>;
        var brandselect = document.getElementById("brandcar");
        var brandlist = document.getElementById("brands");
        brandlist.classList.add("selecter");
        for (var i = 0; i < carbrand.length; i++) {
          var option = document.createElement("option");
          option.value = carbrand[i];
          option.name = carbrand[i];
          option.text = carbrand[i];
          brandlist.appendChild(option);
        }
        brandselect.appendChild(brandlist);

        var cararray = <?php echo json_encode($car_array); ?>;
        var carids = <?php echo json_encode($car_id); ?>;
        var element = document.getElementById("car-con");
        var form = document.createElement("form");
        form.action = "#";
        form.method = "post";
        for (var i = 0; i < cararray.length; i++) {
          var tag = document.createElement("p");
          var img = document.createElement("img");
          var submit = document.createElement("input");
          submit.type = "submit";
          submit.name = carids[i];
          submit.value = "Select";
          tag.name = carids[i];
          img.src = cararray[i];
          tag.id = carids[i];
          tag.appendChild(img);
          tag.appendChild(submit);
          form.appendChild(tag);
        }
        element.appendChild(form);

        </script>
  </body>
</html>
