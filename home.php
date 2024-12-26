
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
<style>
    .homepage_header{
       display:flex;
       justify-content:space-between;
       align-items:center;
       margin:1em;
    }

    .homepage_title{
        padding:1em;
        font-size: 2em;
    }

    .homepage_option{
        display:flex;
        list-style-type:none;
        margin:1em;

    }

    .homepage_option_list{
        margin:1em;
    }


    .homepage_option_list_link{
       text-decoration: none;
       color:white;
    }

    .homepage_option_list_link:hover{
        cursor:pointer;
        font-weight: 600;
    }


    .loginUser_info {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 20px;
        box-shadow: 4px 4px 4px 4px #eee;
        border-radius: 4px;
        padding: 10px;
    }

    .loginUser_info > .username{
        padding-right: 6em;
        font-size: 1em;
        padding-bottom: 0.5em;
    }



</style>

</head>
<body> 
    <header class="homepage_header">

    <h1 class="homepage_title">우하하 커뮤니티</h1>


   <?php
     
   
    session_start(); // 로그인 유지

    if(isset($_SESSION['user'])){
      $username = $_SESSION['user'];
      echo "<div class='loginUser_info'><b class='username'>{$username}님</b>
        <div>
            <button type='button' class='btn btn-primary btn-sm' >
           <a href='/blog/logout.php'>            로그아웃</a></button>
            <button type='button' class='btn btn-primary btn-sm'>내정보</button>
        </div>
         
      </div>";


     }else{
        // 비 로그인 사용자가 보게 될 내용
        echo  "

       <ul class='homepage_option'>
        <li class='homepage_option_list'><button type='button' class='btn btn-primary'><a class='homepage_option_list_link'  href='/blog/login.html'>로그인</a></button></li>
        <li class='homepage_option_list'><button type='button' class='btn btn-primary'><a class='homepage_option_list_link' href='/home/join.html'>회원가입</a></button></li>
    </ul>
        ";
     
     }
   ?>
   

 
    </header>
  

    <table class="table">
      <thead>
        <tr>
            <th>제목</th>
            <td>작성자</td>
            <td>옵션</td>
        </tr>
     </thead>
     <tbody>
        <!-- 사용자가 로그인 하면 테이블 전체가 보임 -->
        <?php
        $tblQuery = "SELECT * FROM posts";

        $result = mysqli_query($conn,$tblQuery);


        // 만약 게시글이 하나라도 있다면
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>
                       <td>{$row['post_title']}</td>
                       <td>홍길동</td>
                       <td>
                          <a class='homepage_option_list_link'  href='#'>수정</a>
                            <a class='homepage_option_list_link'  href='#'>삭제</a>

                       </td>

                       ";
            }
        }else{
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