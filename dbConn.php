<?php
 // db와 연결하는 php 파일
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "test";

 $conn = mysqli_connect($servername , $username , $password , $dbname);

 if(! $conn) die("연결 실패".mysqli_connect_error());



 

?>