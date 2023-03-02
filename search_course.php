<?php
echo "<html>\n";
define("IN_CODE",1);
include "dbconfig.php";
$con = mysqli_connect($host, $username, $password, $dbname) 
      or die("<br>Cannot connect to DB:$dbname on $host. Error:" . 
      mysqli_connect_error()); #use procedural style 

if(isset($_COOKIE['login_id'])){

$keyword = $_GET["search_course"];
      
if($keyword == '*') {
$sql = "select sr.cid as Course_ID,sr.name as Course_Name,f.Name as Faculty_Name,sr.term as Term, sr.enrollment as Enrollment, concat(r.Building,' ',r.Number) as Building_Room,r.Size as Size,
a.name as Added_By_Admin 
from TECH3740_xxxx.Courses_xxxx as sr join TECH3740.Faculty as f on sr.Fid=f.Fid join TECH3740.Rooms as r on sr.Rid=r.Rid join TECH3740.Admin as a on sr.aid=a.aid order by sr.name ASC";

$selectEnroll = "select sum(enrollment) as total_enrollment from TECH3740_xxxx.Courses_xxxx";
      }

else {
$sql = "select sr.cid as Course_ID,sr.name as Course_Name,f.Name as Faculty_Name,sr.term as Term, sr.enrollment as Enrollment, concat(r.Building,' ',r.Number) as Building_Room,r.Size as Size,
a.name as Added_By_Admin 
from TECH3740_xxxx.Courses_xxxx as sr join TECH3740.Faculty as f on sr.Fid=f.Fid join TECH3740.Rooms as r on sr.Rid=r.Rid join TECH3740.Admin as a on sr.aid=a.aid
where sr.cid like '%$keyword%' or sr.name like '%$keyword%' order by sr.name ASC";

$selectEnroll = "select sum(enrollment) as total_enrollment from TECH3740_xxxx.Courses_xxxx where cid like '%$keyword%' or name like '%$keyword%'";
}   

#echo "<br>SQL: $sql\n";  

$result = mysqli_query($con, $sql);
echo "The following course ID and name matched the search keyword <b>$keyword</b>.\n";
if ($result) {
        if (mysqli_num_rows($result)>0) {
            echo "<TABLE border=1>\n";
            echo "<TR><TH>Course ID</TH><TH>Course Name</TH><TH>Faculty Name</TH><TH>Term</TH><TH>Enrollment</TH><TH>Building Room</TH><TH>Size</TH><TH>Added by Admin</TH></TR>\n";
            while($row = mysqli_fetch_array($result)){
            $id = $row["Course_ID"];
            $cname = $row["Course_Name"];
            $fname = $row["Faculty_Name"];
            $term = $row["Term"];
            $ement = $row["Enrollment"];
            $broom = $row["Building_Room"];
            $size = $row["Size"];
            $admin = $row["Added_By_Admin"];
            if ($size-$ement < 3)
                        $color="red";
                else
                        $color="black";
            echo "<TR><TD>$id<TD>$cname<TD>$fname<TD>$term<TD><font color='$color'>$ement</font><TD>$broom<TD>$size<TD>$admin\n";
            }
            echo "</TABLE>";
            }
        else
            echo "<br>No record(s) found\n";
        }
else {
   echo "<br>Something is wrong with SQL:" . mysqli_error($con);
}        

$result = mysqli_query($con, $selectEnroll);
$sumEnroll = mysqli_fetch_array($result);

echo 'Total Enrollment: ' .$sumEnroll[0];
#reference https://www.folkstalk.com/2022/09/calculate-sum-total-of-column-in-php-with-code-examples.html

}
else{
    die("Please login first.");
    }
mysqli_free_result($result);
mysqli_close($con);
echo "</html>";
?>