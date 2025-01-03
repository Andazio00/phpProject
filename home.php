
<?php
 include"dbConn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/home.css">
</head>
<body> 
    <header class="homepage_header ">
    <h1 class="homepage_title">우하하 커뮤니티</h1>

   <?php
       
    session_start(); // 로그인 유지

    if(isset($_SESSION['user'])){
      $username = $_SESSION['user'];
      
      echo "

     
      <div class='loginUser_info'><b class='username'>{$username}님</b>
        <div>
            <button type='button' class='btn btn-primary btn-sm' >
           <a class='homepage_option_list_link' href='/blog/logout.php'>            로그아웃</a></button>
            <button type='button' class='btn btn-primary btn-sm'>내정보</button>
               <button type='button' class='btn btn-primary btn-sm'><a class='homepage_option_list_link'  href='/blog/writePost.html'>글쓰기</a></button>
        </div>
         
      </div>";


     }else{
        // 비 로그인 사용자가 보게 될 내용
        echo  "

       <ul class='homepage_option'>
        <li class='homepage_option_list'><button type='button' class='btn btn-primary'><a class='homepage_option_list_link'  href='/blog/login.html'>로그인</a></button></li>
        <li class='homepage_option_list'><button type='button' class='btn btn-primary'><a class='homepage_option_list_link' href='/blog/join.html'>회원가입</a></button></li>
    </ul>
        ";
     
     }
   ?>
   

 
    </header>
  

    <table class="table">

    <div class="">
      
    </div>

      <thead>
        <tr>
            <th>제목</th>
            <td>작성자</td>
            
        </tr>
     </thead>
     <tbody>
        <!-- 사용자가 로그인 하면 테이블 전체가 보임 -->
        <?php
        
        // db 조인을 통해서  포스트 테이블과 링크된 users 테이블 전체 데이터 끌고오기
        $tblStmt = $conn -> prepare("SELECT * FROM posts 
                           LEFT JOIN users ON posts.write_id = users.id");

         // 어떠한 요인에 의해 쿼리를 가져오기 실패하면 에러 보내기
         if(!$tblStmt) die("쿼리 준비 실패:".$conn ->error); 
        
        
         // 145번째 쿼리 실행
        $tblStmt -> execute();

       // 153번째 쿼리 실행해서 결과 가져오기
        $resultTbl = $tblStmt -> get_result();
       
         
         // 가져온 테이블 결과의 행 수가 여러개면
        if($resultTbl -> num_rows > 0){

          
     
            // while 이하 동작들을 실행
            while( $row = $resultTbl -> fetch_assoc()){
                echo "<tr>
                        <td><a class='post_list_link'  href='/blog/postView.php?post_id={$row['post_id']}'>{$row['post_title']}</a></td>
                        <td>{$row['username']}</td>
                </tr>
                ";
            }

          



        }else{  // 비 로그인 사용자에게 보여지는 글
            echo "<tr>
            <td colspan='3' >글이 없습니다.</td>
          </tr>";
        }


        ?>
           
   
             
          
    </tbody>
     

    </table>









<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>