
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글쓰기</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .post_view{
          margin:12px;
          box-shadow: 1px 1px 1px 1px gray;
        }

        .post_view > .post_view_title{
           padding:10px;
           font-weight: 600;
        } 


         .post_view > .post_view_author{
           margin: 10px;
         }

        .post_view > .post_view_author > .post_view_author_name{
           padding: 3px;
           font-weight: 600;
           color: black;

        }

        .post_view > .post_view_content {
           padding: 10px;
        }


    </style>
</head>
<body>

<div class="post_view">
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
    echo "<h1 class='post_view_title'>" . $post['post_title'] . "</h1>";
    echo "<p class='post_view_author'>작성자: " ."<span class='post_view_author_name'>".htmlspecialchars($post['username'] ?? '알 수 없음') ."<span>". "</p>";
    
    echo "<div class='post_view_content'>" .$post['post_content'] . "</div>";
} 





$conn->close();
?>

  <div>
  <?php

      include "dbConn.php";
      session_start();
      $post_id = $_GET['post_id'];
      $username = $_SESSION['user'];
   

        
   
     $postStmt = $conn-> prepare("SELECT * FROM posts LEFT JOIN users ON posts.write_id = users.id WHERE posts.post_id = ? AND users.username= ?");
      $postStmt -> bind_param('ii',$post_id,$username);
      $postStmt -> execute();
      $result = $postStmt -> get_result();
      $post = $result -> fetch_assoc();





      if($post) 
         {
            echo "<button><a href='./deletePost.php?post_id=$post_id'>삭제</a></button>";
            echo "<button><a href='./updatePost.php?post_id=$post_id'>수정</a></button>";         
         }
    


   ?>
  </div>


</div>

</body>
</html>