<?php
    session_start();

    if(! isset($_SESSION['is_admin_user'])) {

        echo "<div class='text-center font-weight-bold alert alert-secondary'> PAGE NOT FOUND ! </div>";
        die;
    }
?>