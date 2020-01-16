<?php
include 'helpers.php';
include 'header.php';
if(session_status()===PHP_SESSION_NONE){
  session_start();
}
echo '<body>'."\r\n".
     '  <div class="navbar navbar-fixed-top">'."\r\n".
     '    <div class="navbar-inner">'."\r\n".
     '      <div class="container">'."\r\n".
     '        <button type="button" class="btn btn-navbar"'."\r\n".
     '          data-toggle="collapse" data-target=".nav-collapse">'."\r\n".
     '          <span class="icon-bar"></span>'."\r\n".
     '          <span class="icon-bar"></span>'."\r\n".
     '          <span class="icon-bar"></span>'."\r\n".
     '        </button>'."\r\n".
     '        <ul class="nav navbar-nav navbar-left">'."\r\n".
     '          <li><img src="/pics/logo.jpg" width="40"></li>'."\r\n".
     '        </ul>'."\r\n".
     '        <a class="brand" href="#">ApDaptive</a>'."\r\n".
     '        <div class="nav-collapse collapse">'."\r\n".
     '          <ul class="nav">'."\r\n".
     '            <li><a href="/">Home</a></li>'."\r\n".
     '            <li class="active"><a href="/practice.php">Practice</a></li>'."\r\n".
     '            <li><a href="/login.php">Login</a></li>'."\r\n".
     '            <li><a href="/signup.php">Sign up</a></li>'."\r\n".
     '          </ul>'."\r\n".
     '        </div>'."\r\n".
     '      </div>'."\r\n".
     '    </div>'."\r\n".
     '  </div>'."\r\n";
if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(grader($_POST['id'],$_POST['answer'])){
    echo '  <p>Correct!</p>'."\r\n";
  }else{
    echo '  <p>Incorrect.</p>'."\r\n";
  }
  echo '  <input href="/practice.php">Next Problem</input>';
}else{
$problem_number = best_problem_number_getter($_SESSION['email']);
  echo '  <div class="container">'."\r\n".
       '    <div class="row">'."\r\n".
       '      <div class="col-sm-4">'."\r\n".
       '      </div>'."\r\n".
       '      <div class="col-sm-4">'."\r\n".
       '        <p>'.problem_getter($problem_number,$_SESSION['email']).'</p><br>'."\r\n".
       '        <div align = "center">'."\r\n".
       '          <form action="practice.php" method="post">'."\r\n".
       '            Answer: <input type="text" name="answer"><br>'."\r\n".
       '            <input type="submit">'.
       '          </form>'."\r\n".
       '        </div>'."\r\n".
       '      </div>'."\r\n".
       '      <div class="col-sm-4">'."\r\n".
       '      </div>'."\r\n".
       '      </div>'."\r\n".
       '    </div>'."\r\n".
       '  </div>';
}
echo '</body>'."\r\n".
     '</html>';
?>