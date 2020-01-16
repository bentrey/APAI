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
     '            <li class="active"><a href="/login.php">Login</a></li>'."\r\n".
     '            <li><a href="/signup.php">Sign up</a></li>'."\r\n".
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
    $conn=mysqli_connect($server,$username,$password,$database);
    $sql="SELECT * FROM users WHERE email="."'".$_POST['email']."' and "."password="."'".
      $_POST['password']."'";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    if(count($row)>0){
      $_SESSION['email'] = $_POST['email'];
      $_SESSION['number_attempted_this_session'] = 0;
      echo '<br>'."\r\n".
           '<p align = "center">You are logged in as '.$_SESSION['email'].'</p>';
    }else{
      echo '<br>'."\r\n".
           '<p align = "center">There is no record of that email and password.</p>';
    }
  }elseif(isset($_SESSION['email'])){
      echo '<br>'."\r\n".
           '<p align = "center">You are logged in as '.$_SESSION['email'].'</p>';
  }else{
    echo '  <div align = "center">'."\r\n".
         '    <form action="login.php" method="post">'."\r\n".
         '    E-mail: <input type="text" name="email"><br>'."\r\n".
         '    Password: <input type="password" name="password"><br>'."\r\n".
         '    <input type="submit">'.
         '    </form>'."\r\n".
         '  </div>'."\r\n";
  }
echo '</body>'."\r\n\r\n".'</html>';

?>