<?php
include 'header.php';
if(session_status()===PHP_SESSION_NONE){
  session_start();
}
echo '<body>'."\r\n".
     '  <div class="navbar navbar-fixed-top">'."\r\n".
     '    <div class="navbar-inner">'."\r\n".
     '      <div class="container">'."\r\n".
     '        <button type="button" class="btn btn-navbar"'."\r\n".
     '            data-toggle="collapse" data-target=".nav-collapse">'."\r\n".
     '          <span class="icon-bar"></span>'."\r\n".
     '          <span class="icon-bar"></span>'."\r\n".
     '          <span class="icon-bar"></span>'."\r\n".
     '        </button>'."\r\n".
     '        <ul class="nav navbar-nav navbar-left">'."\r\n".
     '          <li><img src="/pics/logo.jpg" width="40"></li>'."\r\n".
     '        </ul>'."\r\n".
     '        <a class="brand" href="/">ApDaptive</a>'."\r\n".
     '        <div class="nav-collapse collapse">'."\r\n".
     '          <ul class="nav">'."\r\n".
     '            <li><a href="/index.php">Home</a></li>'."\r\n".
     '            <li><a href="/practice.php">Practice</a></li>'."\r\n".
     '            <li><a href="/login.php">Login</a></li>'."\r\n".
     '            <li class="active"><a href="/signup.php">Sign up</a></li>'."\r\n".
     '          </ul>'."\r\n".
     '        </div>'."\r\n";
if(isset($_SESSION['email'])){
  echo '        <p align="right">'.$_SESSION['email'].' <a href="/logout.php">logout</a></p>'.
       "\r\n";
}
echo '      </div>'."\r\n".
     '    </div>'."\r\n".
     '  </div>'."\r\n";
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'connect.php';
    $error_message="";
    if($_POST['password']!==$_POST['password_check']){
      $error_message='Sorry, your passwords don\'t match.';
    }elseif(preg_match('/[^A-Za-z0-9.#\\-$]/', $_POST['password'])){
      $error_message='Sorry, your password contains an invalid character.';
    }elseif(preg_match('/[^A-Za-z0-9.#\\-$]/', $_POST['email'])){
      $error_message='Sorry, your email contains an invalid character.';
    }elseif(strlen($_POST['password'])<8){
      $error_message='Sorry, your password is too short.';
    }elseif(strlen($_POST['email'])<5){
      $error_message='Sorry, your email address is too short.';
    }else{
      $conn=mysqli_connect($server,$username,$password,$database);
      $sql="SELECT * FROM users WHERE email="."'".$_POST['email']."'";
      $result=mysqli_query($conn,$sql);
      $row=mysqli_fetch_assoc($result);
      if(count($row)>0){
        $error_message='This email was already taken.';
      }
    }
    if($error_message!==""){
      $tries=0;
      $conn=mysqli_connect($server,$username,$password,$database);
      $sql="SELECT * FROM users WHERE email="."'".$_POST['email']."'";
      $result=mysqli_query($conn,$sql);
      $row=mysqli_fetch_assoc($result);
      while(count($row)<1 and $tries<100){
        $sql="INSERT INTO users (email,password,rank) VALUES ('".$_POST['email']."','".
          $_POST['password']."',1)";
        $result=mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);
        $sql="SELECT * FROM users WHERE email="."'".$_POST['email']."'";
        $result=mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);
        $sql = "UPDATE activity where email='".$_POST['email']."' SET total_correct=0";
        $result=mysqli_query($conn,$sql);
        mysqli_close($result);
        $tries+=1;
      }
      if($tries<100){
        $error_message='User '.$_POST['email'].' successfully created.';
      }else{
        $error_message='Sorry, there was a problem creating your account.';
      }
    }
    echo '<p align="center">'.$error_message.'</p>';
  }else{
    echo '  <div align = "center">'."\r\n".
         '    <form action="signup.php" method="post">'."\r\n".
         '    E-mail: <input type="text" name="email"><br>'."\r\n".
         '    Password: <input type="password" name="password"><br>'."\r\n".
         '    Re-enter Password: <input type="password" name="password_check"><br>'."\r\n".
         '    <input type="submit">'."\r\n".
         '    </form>'."\r\n".
         '  </div>'."\r\n";
  }
echo '</body>'."\r\n\r\n".'</html>';

?>