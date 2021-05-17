<!-- for ajax : dynamic university name dropdown -->

<?php

require 'con_db.php';

  $query="SELECT * from university";

  $result= mysqli_query($conn,$query) ;
        
  if($result->num_rows>0)
  {
     echo "<option value='' selected disabled>Select University</option>";
     while($arr= $result->fetch_assoc())
     {
        echo "<option value=".$arr['universityID'].">".$arr['university_name']."</option><br>";
        
      }
   }  

 mysqli_close($conn);
 ?>