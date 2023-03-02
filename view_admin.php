<?php
echo "<html>";
define("IN_CODE",1);
include "dbconfig.php";

$con = mysqli_connect($host, $username, $password, $dbname)
      or die("<br>Cannot connect to DB:$dbname on $host. Error:" .
      mysqli_connect_error()); #use procedural style;

$sql="select * from TECH3740.Admin";
$result = mysqli_query($con, $sql);
$admins = mysqli_num_rows($result);
# echo "<br>SQL: $sql\n";

echo "There are <b>$admins</b> admin(s) in the database\n";
if ($result) {
        if (mysqli_num_rows($result)>0) {
                echo "<TABLE border=1>\n";
                echo "<TR><TH>ID</TH><TH>Login</TH><TH>Password</TH><TH>Name</TH><TH>DOB</TH><TH>Join Date</TH><TH>Gender</TH><TH>Address</TH></TR>\n";
            while($row = mysqli_fetch_array($result)){
                $id = $row["aid"];
                $login = $row["login"];
                $password = $row["password"];
                $name = $row["name"];
                $dob = $row["dob"];
                $joindate = $row["join_date"];
                $gender = $row["gender"];
                $address = $row["Address"];
                if ($joindate < $dob)
                        $color="red";
                else
                        $color="blue";

                if ($dob=='') {
                	$dob='<font color="red">NULL</font>';
                }
                else {
                        $dob = $row["dob"];
                }
                echo "<TR><TD>$id</TD><TD>$login</TD><TD>$password</TD><TD>$name</TD><TD><font color='$color'>$dob</font></TD><TD><font color='$color'>$joindate</font></TD><TD>$gender</TD><TD>$address</TD>\n";
            }
            echo "</TABLE>\n";
        }
        else
                echo "<br>No record(s) found\n";
}
else {
  echo "<br>Something is wrong with SQL:" . mysqli_error($con);
}
mysqli_free_result($result);
mysqli_close($con);
echo "</html>";
?>