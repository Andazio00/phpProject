<?php

   include "dbConn.php";


   //게시글 제목 가져오기
   $post_id = $_GET['post_id'] ;

   if(!$post_id || !is_numeric($post_id)){
   	  die("유효하지 않은 제목입니다.");
   }



   $postStmt = $conn-> prepare("SELECT posts.* , users.username FROM posts LEFT JOIN users ON posts.write_id = users.id WHERE posts.post_id = ?");

 
   $postStmt -> bind_param('i',$post_id);

   $postStmt -> execute();

   $result = $postStmt -> get_result();

   $post = $result -> fetch_assoc();


   if ($post) {
    echo "<h1>" . htmlspecialchars($post['post_title']) . "</h1>";
    echo "<p>작성자: " . htmlspecialchars($post['username'] ?? '알 수 없음') . "</p>";
    
    echo "<div>" . nl2br(htmlspecialchars($post['post_content'])) . "</div>";
} else {
    echo "게시글을 찾을 수 없습니다.";
}



$conn->close();
?>