<?php
echo "<html>\n";
define("IN_CODE",1);
include "dbconfig.php";
$con = mysqli_connect($host, $username, $password, $dbname) 
      or die("<br>Cannot connect to DB:$dbname on $host. Error:" . 
      mysqli_connect_error()); #use procedural style    

    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_POST['username']))
        $user=$_POST['username'];
    else
        die("<br>Must have Username");

    if (isset( $_POST['password'] ))
        $pass=$_POST['password'];
    else
        die("<br>Must have password");

    echo "<br>Your IP: $ip\n";
    $IPv4= explode(".",$ip); #split token
    if ($IPv4[0] == "131" and $IPv4[1] == "125" or $IPv4[0] == "10") { 
        echo "<br>You are from Kean University.\n"; 
        }
    else { 
        echo "<br>You are NOT from Kean University.\n"; 
    }

$sql = "select *,DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),dob)),'%Y')+0 as age from TECH3740.Admin where login='$user' and password='$pass'";
$result = mysqli_query($con, $sql); 
if ($result) {
	if (mysqli_num_rows($result)>0) {
		$row = mysqli_fetch_array($result);
		$mypassword=$row['password'];
		$aid=$row['aid'];
        $name=$row['name'];
        $dob=$row['dob'];
        $address=$row['Address'];
        $gender=$row['gender'];
        $age=$row['age'];
        $joindate=$row['join_date'];
        $logout = 'logout.php';
        $addcourse = 'add_course.php';
        if ($age=='') { // If age is null then print null as red else print table value as black
                $age="NULL";
                $color="red";
        }        
        else {
                $color="black";
        }
        if ($dob=='') { // If dob is null then print null as red else print table value as black
                $dob="NULL";
                $color="red";
        }
        else {
                $color="black";
        }
        echo "<br><a href=".$logout.">Logout</a>";
        echo "<br>Welcome user: $name";
        echo "<br>DOB: <font color='$color'>$dob</font>";
        echo "<br>Address: $address";
        echo "<br>Gender: $gender";
        echo "<br>Age: <font color='$color'>$age</font>";
        echo "<br>Join date: $joindate<br>";
        echo "<br><a href='add_course.php'>Add a course</a>";
        echo "<FORM action='search_course.php' method='GET'>";
        echo "Search course (id or name):";
        echo "<br><INPUT type='text' name='search_course'>";
        echo "<INPUT type='submit' name='search' value='Search'>";
        echo "</FORM>";
		setcookie('login_id',$aid,time() + 3600);	
	}
}

$sql = "select * from TECH3740.Admin where login='$user' and password!='$pass'";
$result = mysqli_query($con, $sql); 
if($result)  {
    if (mysqli_num_rows($result)>0) {
        echo"<br>User <b>$user</b> is in the database, but wrong password was entered.";
    }
}

$sql = "select * from TECH3740.Admin where login='$user'";
$result = mysqli_query($con, $sql); 
if($result)  {
    if (mysqli_num_rows($result)<1) {
        echo "<br>No such user <b>$user</b> in the system.\n";
    }
}

else {
  echo "<br>Something is wrong with SQL: " . mysqli_error($con);	
}
mysqli_free_result($result);
mysqli_close($con);
echo "</html>";
?>