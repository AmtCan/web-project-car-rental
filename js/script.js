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
  function offAll() {
    document.getElementById("About").style.display = "none";
    document.getElementById("Contact").style.display = "none";
    document.getElementById("signUp").style.display = "none";
  }
  function onA() {
    offAll();
    document.getElementById("About").style.display = "block";
  }
  function onC() {
    offAll();
    document.getElementById("Contact").style.display = "block";
  }
  function onnS() {
    offAll();
    document.getElementById("signUp").style.display = "flex";
    document.getElementById("signUp").style.opacity = 1;
  }

  