<?php

function random_list($input_string,$num_of_probs,$num_of_choices){
  $return_array=array();
  $range_array=range(0,$num_of_choices-1);
  while(count($return_array)<$num_of_probs){
    $n=$num_of_choices-count($return_array);
    $pop_index=hexdec(hash("sha256",$input_string,'pickle'))%($n);
    array_push($return_array,$range_array[$pop_index]);
    array_splice($range_array,$pop_index,1);
  }
  return $return_array;
}

function random_number($user_name,$seed){
  $return_value=round(hexdec(substr(hash('md5',$user_name.$seed),-5))/pow(2,20),2);
  if($return_value<0.01){
    $return_value=$return_value+0.01;
  }
  return $return_value;
  return 0.5;
}

function problem_getter($id,$email){
  include 'connect.php';
  $sql = "SELECT * FROM problems WHERE id='".strval($id)."'";
  $conn = mysqli_connect($server,$username,$password,$database);
  if(!$conn){
    header("LOCATION: /connectionError.php");
  }
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);
  $problem_line = $row['question'];
  $random_value = $row['random'];
  $sql = "SELECT * FROM activity WHERE email='".strval($email)."'";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);
  $user_random=$row['random'];
  $random_number=random_number($email,$random_value.$user_random);
  $problem_line=str_replace('random_value',strval($random_number),$problem_line);
  while(strpos($problem_line,'<<<<') !== false){
    $computation = explode('<<<<',explode('>>>>',$problem_line)[0])[1];
    eval('return $executed='.$computation.';');
    $problem_line=str_replace('<<<<'.$computation.'>>>>',strval($executed),$problem_line);
  }
  mysqli_close($conn);
  return $problem_line;
}

function random_getter($email){
  include 'connect.php';
  $sql="SELECT * FROM activity where email='".$email."'";
  $conn=mysqli_connect($server,$username,$password,$database);
  $result=mysqli_query($conn,$sql);
  if(mysqli_num_rows($result)<1){
    $letters=['0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f'];
    $random=join("",array_rand($letters,16));
    $sql="INSERT INTO activity (email,random) values ('".$email."','".$random."')";
    $result=mysqli_query($conn,$sql);
  }else{
    $row=mysqli_fetch_assoc($result);
    $random=$row['random'];
  }
  mysqli_close($conn);
  return $random;
}

function number_of_problems(){
  include 'connect.php';
  $sql="SELECT * FROM problems";
  $conn=mysqli_connect($server,$username,$password,$database);
  if(!$conn){
    header("LOCATION: /connectionError.php");
  }
  $result=mysqli_query($conn,$sql);
  mysqli_close($conn);
  return mysqli_num_rows($result);
}

function get_number_correct($email){
  include 'connect.php';
  $sql="SELECT * FROM activity where email='".$email."'";
  $conn=mysqli_connect($server,$username,$password,$database);
  if(!$conn){
    header("LOCATION: /connectionError.php");
  }
  $result=mysqli_query($conn,$sql);
  $row=mysqli_fetch_assoc($result);
  mysqli_close($conn);
  return $row['total_correct'];
}

function increase_number_correct($email){
  include 'connect.php';
  $sql="SELECT * FROM activity where email='".$email."'";
  $conn=mysqli_connect($server,$username,$password,$database);
  if(!$conn){
    header("LOCATION: /connectionError.php");
  }
  $result=mysqli_query($conn,$sql);
  $row=mysqli_fetch_assoc($result);
  $number = $row['total_correct']+1;
  $sql = "UPDATE activity SET total_correct=".$number." where email='".$email."'";
  if(!$conn){
    header("LOCATION: /connectionError.php");
  }
  $result=mysqli_query($conn,$sql);
  mysqli_close($conn);
}

function best_problem_number_getter($email){
  include 'connect.php';
  #start timer
  if(!isset($_SESSION['start_time'])){
    $_SESSION['start_time'] = microtime(true);
  }
  #get time
  $time = strval(microtime(true) - $_SESSION['start_time']);
  #number attempted this session update
  $_SESSION['number_attempted_this_session'] = $_SESSION['number_attempted_this_session'] + 1;
  $number_attempted_this_session = $_SESSION['number_attempted_this_session'];
  #get total_correct
  $sql = "SELECT * FROM activity where email='".$email."'";
  $conn=mysqli_connect($server,$username,$password,$database);
  if(!$conn){
    header("LOCATION: /connectionError.php");
  }
  $result=mysqli_query($conn,$sql);
  $row=mysqli_fetch_assoc($result);
  $number_correct_lifetime = strval($row['total_correct']);
  $return_value = 1;
  if($number_correct_lifetime<3){
    $return_value = rand(1,3);
  }else{
    for($n=0;$n<3;$n++){
      $numbers = array();
      while(count(indicies)<3){
        #make problem_number_getter
        $possible_number = problem_number_getter($number_correct_lifetime);
        if(!in_array($possible_number,$numbers)){
          array_push($numbers,$possible_numbers);
        }
      }
    }
    $best_number = 1;
    $best_prob = 0;
    for($n=0;$n<count($possible_numbers);$n++){
      #find topic ratio
      $sql = "SELECT * FROM problems WHERE id='".$possible_numbers[$n]."'";
      if(!$conn){
        header("LOCATION: /connectionError.php");
      }
      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_assoc($result);
      $unit = $row['unit'];
      $topic = $row['topic'];
      #find difficulty
      $difficulty = strval($row['difficulty']);
      $sql = "SELECT * FROM activity WHERE email='".$_SESSION['email']."'";
      if(!$conn){
        header("LOCATION: /connectionError.php");
      }
      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_assoc($result);
      $number_in_topic = $row[strval($unit).'_'.$topic.'_'.'T'];
      if(intval($row[strval($unit).'_'.$topic.'_'.'T'])<1){
        $topic_ratio = 0;
      }else{
        $topic_ratio = strval(floatval($row[[$unit].'_'.$topic.'_'.'C'])/
                         floatval($row[[$unit].'_'.$topic.'_'.'T']));
      }
      $args = $total_correct.','.$number_attempted_this_session.','.$topic_ratio.','.
        $number_in_topic.','.$difficulty.','.$time;
      exec('python3 /var/www/html/prediction.py '.$args,$result);
      if(floatval($result)>$best_prob){
        $best_prob = floatval($result);
        $best_number = $numbers[$n];
      }
    }
  }
  return $return_value;
}

function problem_number_getter($total_correct){
  if($total_correct<1){
    return 0;
  }
  $normalization = 0;
  for($n=1;$n<=$total_correct;$n++){
    $normalization = $normalization + 0.05 + exp(-($n+1-$total_correct)^2/2.0)/(2*M_pi)^0.5;
  }
  $sum = 0;
  $random_value = rand()*$normalization;
  for($n=1;$n<=$total_correct;$n++){
    $sum = $sum + 0.05 + exp(-($n+1-$total_correct)^2/2.0)/(2*M_pi)^0.5;
    if($random_value < $sum){
      return $n;
    }
  }
}

function grader($id,$answer){
  include 'connect.php';
  $sql = "SELECT * FROM problems WHERE id ='".strval($id)."'";
  $conn=mysqli_connect($server,$username,$password,$database);
  if(!$conn){
    header("LOCATION: /connectionError.php");
  }
  $result=mysqli_query($conn,$sql);
  $row=mysqli_fetch_assoc($result);
  $sql_answer = $row['answer'];
  $unit = $row['unit'];
  $topic = $row['topic'];
  $correct = true;
  $answer_list = explode($answer,' ');
  $type = $answer_list[0];
  $user_answer = $answer_list[1];
  if($type=="CHAR"){
    if(strtolower($user_answer)!==strtolower($sql_answer)){
      $correct = false;
    }
  }elseif($type=="FLOAT"){
    if(!(
    abs((floatval($user_answer)-floatval($sql_answer))/floatval($sql_answer)<0.01) or 
    abs(floatval($user_answer)-floatval($sql_answer))<0.001)){
      $correct = false;
    }
  }
  $sql="SELECT * FROM activity where email='".$email."'";
  $conn=mysqli_connect($server,$username,$password,$database);
  if(!$conn){
    header("LOCATION: /connectionError.php");
  }
  $result=mysqli_query($conn,$sql);
  $row=mysqli_fetch_assoc($result);
  $topic_total = $row[strval($unit).'_'.strval($unit).'_'.'T']+1;
  $sql = "UPDATE activity SET ".strval($unit)."_".strval($topic)."_T=".$topic_total.
    " where email='".$_SESSION['email']."'";
  if(!$conn){
    header("LOCATION: /connectionError.php");
  }
  $result=mysqli_query($conn,$sql);
  if($correct AND isset($_SESSION['email'])){
    increase_number_correct($_SESSION['email']);
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    $topic_total = $row[strval($unit).'_'.strval($unit).'_'.'C']+1;
    $sql = "UPDATE activity SET ".strval($unit)."_".strval($topic)."_C=".$topic_total.
      " where email='".$_SESSION['email']."'";
    if(!$conn){
      header("LOCATION: /connectionError.php");
    }
    $result=mysqli_query($conn,$sql);
  }
  mysqli_close($conn);
  return $correct;
}

?>