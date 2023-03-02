<?php
echo "<html>\n";
define("IN_CODE",1);
include 'dbconfig.php';

$con = mysqli_connect($host, $username, $password, $dbname)
      or die("<br>Cannot connect to DB:$dbname on $host. Error:" .
      mysqli_connect_error()); #use procedural style;
      
if (isset($_COOKIE['login_id'])) {

    echo "<a href='logout.php'>logout</a><br>";
    echo "<font size=4><b>Add a course</b></font>";
    echo "<form action='insert_course.php' method='post' required='required'>Course ID: <input type='text' name='course_id' size = '5' required='required'> (ex: CPS1231) <BR>";
    echo "<form action='insert_course.php' method='post' required='required'>Course Name: <input type='text' name='course_name' required='required'><BR>";
    echo "Term: <input type='checkbox' name='term[]' value='Spring'>Spring";
    echo "<input type='checkbox' name='term[]' value='Summer'>Summer";
    echo "<input type='checkbox' name='term[]' value='Fall'>Fall <BR>";
    echo "<form action='insert_course.php' method='post' required='required'>Enrollment: <input type='text' name='enrollment' size='3' required='required'>(# of registered students) <BR>";

    $selectFac = "select Fid, Name from TECH3740.Faculty";
    $facultySQL = mysqli_query($con,$selectFac);
    echo "Select a faculty: ";
    echo '<select name="fid">';
    echo '<option value></option>';
    while($row = mysqli_fetch_array($facultySQL)){
        echo '<option value='.$row['Fid'].'>'.$row['Name'].'</option>';   
    }
    echo '</select>';
    echo '<br>';

    $selectRooms = "select Rid,concat(Building,' ',Number) as rn, size from TECH3740.Rooms";
    $roomsSQL = mysqli_query($con,$selectRooms);
    echo "Room: ";
    echo '<select name="rid">';
    echo '<option value></option>';
    while($row = mysqli_fetch_array($roomsSQL)){
        echo '<option value='.$row['Rid'].'>'.$row['rn'].' has '.$row['size'].' seats</option>';
        }
       
    echo "</select><input type='submit' value='submit'></form>";
    echo '<br>';
    
     } 
 else{
    die("Please login first.");
    }
mysqli_free_result($facultySQL);
mysqli_free_result($roomsSQL);
mysqli_close($con);
echo "</html>"; 
?>