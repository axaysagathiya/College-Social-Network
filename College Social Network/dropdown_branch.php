<!-- for ajax : dynamic branch name dropdown -->

<?php

require 'con_db.php';

  $query="SELECT * from branch";

  $result= mysqli_query($conn,$query) ;
        
  if($result->num_rows>0)
  {
     echo "<option value='' selected disabled>Select Branch</option>";
     while($arr= $result->fetch_assoc())
     {
        echo "<option value=".$arr['branchID'].">".$arr['branch_name']."</option><br>";
        
      }
   }  

 mysqli_close($conn);
 ?>