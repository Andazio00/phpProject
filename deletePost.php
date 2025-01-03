<?php

  // 0. 이문구는 꼭 해주어야 함
 session_start(); 

 // db를 통해 삭제하므로 연결
 include "dbConn.php";


 // 1. 이사람이 로그인한 사용자인가 유무
 if(!isset($_SESSION['user']) )  { // 아니면
 	echo "<script>document.location.href='login.html'</script>"; // 로그인페이지로 이동
}

 // 2. 만약 post_id 가 존재한다면  post_id 변수에 저장
 if(isset($_SESSION['user']) && isset($_GET['post_id'])){


 

     // 3. 디비에 접속하여 관련 게시글을 삭제하는 것
 	 $post_id = $_GET['post_id'];
 	 $username = $_SESSION['user'];
 	 $postStmt = $conn-> prepare("DELETE  FROM posts  WHERE post_id = ?  AND write_id IN (SELECT id FROM users WHERE username = ? ) ");
   	 $postStmt -> bind_param('is',$post_id,$username);
     
      if ($postStmt->execute()) {
        echo "게시글이 삭제되었습니다."."<script>document.location.href='home.php'</script>";
    } else {
        echo "게시글 삭제에 실패했습니다.";
    }
     
   
     
    
    $postStmt->close();
    $conn->close(); 
 }else{
 	echo "잘못된 요청입니다.";
 }


 
 

?>