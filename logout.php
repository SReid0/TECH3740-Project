<?php
echo "<html>\n";
define("IN_CODE",1);
include "dbconfig.php";
$con = mysqli_connect($host, $username, $password, $dbname) 
      or die("<br>Cannot connect to DB:$dbname on $host. Error:" . 
      mysqli_connect_error()); #use procedural style

if(isset($_COOKIE['login_id'])){
      echo $_COOKIE['login_id']." has been successfully logged out.<br>";
      echo '<a href="index.html">Return to homepage.</a>';
      unset($_COOKIE['login_id']);
      setcookie('login_id','',time() - 3600);}
else{
      echo "You are not logged in.<br>";
      echo '<a href="index.html">Return to homepage.</a>';
}
echo "</html>";     
?>