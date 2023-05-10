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