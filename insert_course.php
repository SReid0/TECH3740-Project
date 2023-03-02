<?php
echo "<html>\n";
define("IN_CODE",1);
include "dbconfig.php";
$con = mysqli_connect($host, $username, $password, $dbname) 
      or die("<br>Cannot connect to DB:$dbname on $host. Error:" . 
      mysqli_connect_error()); # use procedural style

if (isset($_COOKIE['login_id'])) {
    $aid = $_COOKIE['login_id'];
    $cid = $_POST['course_id'];
    $cname = $_POST['course_name'];
    $terms = '';
    $i = 0;
    if(!isset($_POST["term"])){
      die("You must select at least one term");
    }
    while($i<count($_POST["term"])){
      if($i==0&&count($_POST["term"])>2||$i==1&&count($_POST["term"])>2||$i==0&&count($_POST["term"])>1){ # made this while loop using outside research from google
        $terms .=$_POST["term"][$i].", ";
      }
      else{
        $terms .=$_POST["term"][$i];
      }$i += 1;
    }
    $enrollment = $_POST['enrollment'];
    $fid = $_POST['fid'];
    $rid = $_POST['rid'];
    $selectSize = "select * from TECH3740.Rooms where Rid like '%$rid%'";
    $sizeSQL = mysqli_query($con,$selectSize);
    $check = '';
    while($row = mysqli_fetch_array($sizeSQL)){
        $check = $row["Size"];
    }
    if($enrollment<=$check){
        if($enrollment>0){
          $selectCid = "select * from TECH3740_xxxx.Courses_xxxx where cid LIKE '%$cid%'";
          $cidSQL = mysqli_query($con,$selectCid);
          $selectCname = "select * from TECH3740_xxxx.Courses_xxxx where name LIKE '%$cname%'";
          $cnameSQL = mysqli_query($con,$selectCname);
          $checkCid = mysqli_num_rows($cidSQL);
          $checkName = mysqli_num_rows($cnameSQL);
          if($checkCid==0){ # if number of rows equals 0 entered Course ID is valid
            if($checkName==0){ # if number of rows equals 0 entered Course Name is valid
              $insertCourse = "insert into TECH3740_xxxx.Courses_xxxx (cid,name,term,enrollment,Fid,Rid,aid) VALUES ('$cid','$cname','$terms','$enrollment','$fid','$rid','$aid')";
              $courseSQL = mysqli_query($con,$insertCourse);
              echo"Course ".$cname." has been added successfully";
            }
            else{
              echo "There is a course in the database with that name already";
            }
          }
          else{
            echo "There is a course in the database with that ID already";
          }
        }
        else{
          echo"The enrollment size must be greater than 0";
        }
    }
    else{
      echo"The enrollment must not exceed the room size";
    }
    } 
 else{
  die("Please login first.");
   }  
echo "</html>";   
?>