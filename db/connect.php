<?php $db_host = "localhost";
            $db_user = "root";
            $db_password = "";
            $db_name = "pqt_khaosat";
            $conn = mysqli_connect($db_host,$db_user,$db_password,$db_name);
            if(!$conn)
            {
                header("Location: install/index.php");
            } ?>