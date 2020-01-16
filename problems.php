<?php
  #Units and Topics Tree
  #1.Kinematics
    #1.Area under graph is displacement
    #2.v^2 = v^2 + 2 a dx
  #2.Dymanics
    #1.Inclined Plane
    #2.Tension
  #3.Energy
    #1. Elastic Potential
  #4.Momentum
    #1. Conservation
  #5.Rotational Motion
    #1.Centripetal Force
  #6.Oscilations
    #1.Amplitude
    #2.Frequency
  #7.Charges
  #8.Circuits
  #9.Connection Variables
  include '/var/www/html/connect.php';
  //Deleting old homework if it exists
  $conn=mysqli_connect($server,$username,$password,$database);
  $sql='SELECT * FROM problems';
  $result=mysqli_query($conn,$sql);
  $row=mysqli_fetch_assoc($result);
  if($row){
    $sql='DELETE FROM problems WHERE id>0';
    echo 'deleted HW';
  }
  $result=mysqli_query($conn,$sql);
  $id=array();
  $unit=array();
  $topic=array();
  $difficulty=array();
  $random=array();
  $problems=array();
  $answers=array();
  #Creating Problem and Answer arrays
  #p1
  array_push($id,'1');
  array_push($unit,'1');
  array_push($topic,'1');
  array_push($difficulty,'0.7');
  array_push($random,'be2e5d1a8f');
  array_push($problems,'<br><a href=""/pics/p1.jpg"">
  <img src=""/pics/p1.jpg"" style=""max-width: 450px""/></a><br>
  The graph above shoes the velocity of an object as a function of time. What is the net 
  displacement of the object from \\\\(t=0\\\\) to 
  \\\\(t=<<<<2*intval(3*random_value+1)>>>>\\\\)');
  array_push($answers,'FLOAT [6,10.5,4.5,-3.5][2*intval(3*random_value+1)]');
  #p2
  array_push($id,'2');
  array_push($unit,'2');
  array_push($topic,'1');
  array_push($difficulty,'0.9');
  array_push($random,'1a3e5d1a8b');
  array_push($problems,'<br><a href=""/pics/p2.jpg"">
  <img src=""/pics/p2.jpg"" style=""max-width: 450px""/></a><br>
  If a ball is rolling down an inclined plane without slipping, which force is responsible for 
  causing its rotation.
  <br>&nbsp;&nbsp;(A) 
  <<<<[""Normal Force"",""Gravity"",""Kinetic Friction"",""Static Friction""][random_list(random_value,4,4)[0]]>>>>
  <br>&nbsp;&nbsp;(B) 
  <<<<[""Normal Force"",""Gravity"",""Kinetic Friction"",""Static Friction""][random_list(random_value,4,4)[1]]>>>>
  <br>&nbsp;&nbsp;(C) 
  <<<<[""Normal Force"",""Gravity"",""Kinetic Friction"",""Static Friction""][random_list(random_value,4,4)[2]]>>>>
  <br>&nbsp;&nbsp;(D)
  <<<<[""Normal Force"",""Gravity"",""Kinetic Friction"",""Static Friction""][random_list(random_value,4,4)[3]]>>>>');
  array_push($answers,'CHAR array_search(3,random_list(random_number,4))');
  #p3
  array_push($id,'3');
  array_push($unit,'5');
  array_push($topic,'1');
  array_push($difficulty,'0.5');
  array_push($random,'1a3e5d1c8b');
  array_push($problems,'An object is resting on a circular platform that rotates at a constant speed. At 
  first, it is a distance of \\\\(\\\\frac{1}{<<<<intval(2+4*random_value)>>>>} r\\\\) from the 
  center. If the object is moved to the edge of the platform, what happens to the centripetal force 
  it experiences? Assume the platform continues rotating at the same speed.');
  array_push($answers,'FLOAT intval(2+4*random_value)');
  #p4
  array_push($id,'4');
  array_push($unit,'1');
  array_push($topic,'2');
  array_push($difficulty,'0.5');
  array_push($random,'2a3e5d1c8a');
  array_push($problems,'A car of mass \\\\(1000 \\\\textrm{kg}\\\\) is traveling at a speed of \\\\(5 
  \\\\textrm{m/s}\\\\). The driver applies the breaks, generating a constant frictional force, and 
  skids for a distance of \\\\(<<<<15+intval(10*random_value)>>>>\\\\textrm{m}\\\\) before coming
  to a complete stop. Given this information, what is the coefficient of friction between the 
  car\'s tires and the ground?');
  array_push($answers,'FLOAT 25/2/(15+intval(15+10*random_value))/9.8');
  #p5
  array_push($id,'5');
  array_push($unit,'6');
  array_push($topic,'1');
  array_push($difficulty,'0.5');
  array_push($random,'2a3eb51c8a');
  array_push($problems,'A spring-block system is oscillating without friction on a horizontal surface. If 
  a second block wiith a mass <<<<intval(2+3*random_value)>>>> times as large was placed on top of 
  the original block at a time when the spring is at maximum compression by what factor does 
  applitude change?');
  array_push($answers,'FLOAT 1');
  #p6
  array_push($id,'6');
  array_push($unit,'6');
  array_push($topic,'2');
  array_push($difficulty,'0.7');
  array_push($random,'2b3eb54c8a');
  array_push($problems,'A spring-block system is oscillating without friction on a horizontal surface. If 
  a second block wiith a mass <<<<intval(2+3*random_value)>>>> times as large was placed on top of 
  the original block at a time when the spring is at maximum compression by what factor does 
  frequency change?');
  array_push($answers,'FLOAT pow(1/(intval(2+3*intval)),0.5)');
  #p7
  array_push($id,'7');
  array_push($unit,'3');
  array_push($topic,'1');
  array_push($difficulty,'0.7');
  array_push($random,'2b4cb54c8a');
  array_push($problems,'A spring-block system is oscillating without friction on a horizontal surface. If 
  a second block wiith a mass <<<<intval(2+3*random_value)>>>> times as large was placed on top of 
  the original block at a time when the spring is at maximum compression by what factor does 
  the maximum speed change?');
  array_push($answers,'FLOAT pow(1/(intval(2+3*intval)),0.5)');
  #p8
  array_push($id,'8');
  array_push($unit,'5');
  array_push($topic,'1');
  array_push($difficulty,'0.5');
  array_push($random,'3a4cb54c8a');
  array_push($problems,'A certain theme park ride involves people standing against the walls of
  a cylindrical room that rotates at a rapid pace, making them stick to
  the walls without needing support from the ground. Once the ride
  achieves its maximum speed, the floor drops out from under the
  riders, but the circular motion holds them in place. Which of the
  following factors could make this ride dangerous for some riders but
  not others?<br>&nbsp;&nbsp(A) The mass of the individuals
  <br>&nbsp;&nbsp;(B) The coefficient of friction of their clothing in contact with the
  walls<br>&nbsp;&nbsp;(C) Both of the above<br>&nbsp;&nbsp;(D) None of the above');
  array_push($answers,'CHAR B');
  #p9
  array_push($id,'9');
  array_push($unit,'4');
  array_push($topic,'1');
  array_push($difficulty,'0.9');
  array_push($random,'3a4cb56c8a');
  array_push($problems,'A mass of \\\\(5 \\\\textrm{kg}\\\\) traveling with a velocity of \\\\(20 
  \\\\textrm{m/s}\\\\) in the positive x-direction collides with a mass of 
  \\\\(<<<<intval(10-5*random_value)>>>> \\\\textrm{kg}\\\\) initially at rest. After the 
  collision the \\\\(5 \\\\textrm{kg}\\\\) mass has a y-component of velocity of
  \\\(<<<<intval(2+3*random_value)>>>> \\\\textrm{m/s}\\\\) in the positive y-direction. Find
  the final y-component of velocity of the other mass.');
  array_push($answers,'FLOAT -5*intval(2+3*random_value)/intval(10-5*random_value)');
  #p10
  array_push($id,'10');
  array_push($unit,'2');
  array_push($topic,'1');
  array_push($difficulty,'0.9');
  array_push($random,'3a4cb5c68a');
  array_push($problems,'Find the tension in the string of a pendulum with an instaneous angle of \\\\(
  <<<<intval(10+10*random_value)>>>>^\\\\circ\\\\), length of \\\\(0.8 \\\\textrm{m}\\\\),
  and speed \\\\(0.25 \\\\textrm{m/s}\\\\). The mass at the end is \\\\(2 \\\\textrm{kg}\\\\)');
  array_push($answers,'FLOAT 2*(0.0625/0.8 + cos(intval(10+10*random_value)*pi()/180)*9.81)');
  #upload
  for($n=0;$n<10;$n++){
    $sql='INSERT INTO problems (id, unit, topic, question, answer, random, difficulty) ';
    $sql=$sql.'values ("'.$id[$n].'","'.$unit[$n].'","'.$topic[$n].'","'.$problems[$n]
      .'","'.$answers[$n].'","'.$random[$n].'","'.$difficulty[$n].'")';
    $sqlQuery=mysqli_query($conn,$sql);
    $sql = "ALTER TABLE activity ADD ".$unit[$n]."_".$topic[$n]."_T INT DEFAULT 0 ";
    echo $sql."\n";
    $sqlQuery=mysqli_query($conn,$sql);
    $sql = "ALTER TABLE activity ADD ".$unit[$n]."_".$topic[$n]."_C INT DEFAULT 0 ";
    echo $sql."\n";
    $sqlQuery=mysqli_query($conn,$sql);
  }
  #Formating for php page
  mysqli_close($conn);
?>