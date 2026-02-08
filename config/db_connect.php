<?php
       $servername = "localhost";
       $username = "root";
       $password = "";
       $dbname = "mero_blogs";

       #Connecting with MySQL
       try{
              $conn = new mysqli($servername, $username, $password, $dbname);
              // echo "Database connection successful";
       }catch(Exception $e){
              die("<b>Database connection Failed: </b>".$e->getMessage());
       }
       
?>