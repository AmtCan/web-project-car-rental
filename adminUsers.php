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
      <table style="width: 100%;">
        <tr>
          <th style="text-decoration: underline;">Name</th>
          <th style="text-decoration: underline;">Surname</th>
          <th style="text-decoration: underline;">City</th>
          <th style="text-decoration: underline;">Phone</th>
        </tr>
        <tr>
          <td>Ahmet Can</td>
          <td>Dericioglu</td>
          <td>Bartin</td>
          <td>5356953516</td>
        </tr>
        <tr>
          <td>Emre</td>
          <td>Gulbay</td>
          <td>Izmir</td>
          <td>5353131313</td>
        </tr>
        <tr>
          <td>name</td>
          <td>Surname</td>
          <td>City</td>
          <td>0000000000</td>
        </tr>

      </table>
    </div>
  </body>
</html>
