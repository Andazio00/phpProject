<?php

  session_start();

 // 사용자가 입력한 정보가  db에 반영되어야하기 때문 
 include "dbConn.php";


 // POST 요청여부 확인 
  if( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user']) ){

     $username = $_SESSION['user'];
    $post_title = $_POST['post_title'];
    $post_content = $_POST['post_content'];
    $post_pw = $_POST['post_pw'];
    

    if(empty($post_title) || empty($post_content) || empty($post_pw)){
    	die("All fields are required");

        }


    $stmtUser = $conn -> prepare("SELECT id FROM users WHERE username=?");

    if(!$stmtUser) {
    	 die("쿼리 준비 실패:".$conn ->error); 
    	}

    $stmtUser -> bind_param("s",$username);
    $stmtUser -> execute();
    $resultUser = $stmtUser -> get_result();



    if($resultUser->num_rows >0){
         $row = $resultUser -> fetch_assoc();


    
    $stmt = $conn->prepare("INSERT INTO posts ( post_title, post_content,post_pw,write_id) VALUES (?, ?, ?,?)");
    
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }
    

    $stmt->bind_param("ssss",  $post_title, $post_content,$post_pw , $row['id']);
    
    if ($stmt->execute()) {
        echo "Post submitted successfully!";
        echo "<script>document.write(location.href='home.php' )</script>";
    } else {
    	   echo "Failed to submit the post: " . $stmt->error;
    }
    
    $stmt->close();

  }  else{
  	echo "User not found";
  }
  
  $stmtUser -> close();

 }else{
 	echo "허용되지 않은 접근이거나 요청이 바르지 않습니다.";
 }

?>