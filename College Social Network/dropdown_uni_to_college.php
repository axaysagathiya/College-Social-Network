<!-- for ajax : dynamic college name dropdown -->

<?php

require 'con_db.php';

$uni_id=!empty($_POST['uni_id'])?$_POST['uni_id']:'';

if(!empty($uni_id))
  {
  
  $query="SELECT * from college WHERE universityID= $uni_id";

  $result= mysqli_query($conn,$query) ;
        
  if($result->num_rows>0)
  {
     echo "<option value='' selected disabled> College Name </option>";
     while($arr= $result->fetch_assoc())
     {
        echo "<option value=".$arr['collegeID'].">".$arr['college_name']."</option><br>";
        
      }
   }  
 }

 mysqli_close($conn);
 ?>