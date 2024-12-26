<!-- 사용자가 로그인을 하는 php 페이지 -->

<?php
 
 include "dbConn.php";
 
 // 0. 세션을 시작하는 함수이며 , 로그인 상태를 유지합니다.
 session_start();


 /* 
  1. 로그인 폼을 통해 제출합니다.
  POST 요청은 URL에 데이터가 안보이므로 보안에 유리합니다. 
 */

 if($_SERVER['REQUEST_METHOD'] === 'POST'){

    /* 
      2.  로그인폼으로부터 username , password를 입력받아서 
      변수인 $username , $password에 저장합니다.
    */
    $username = $_POST['username'];
    $password = $_POST['password'];





    // 4. username이  ㅇㅇㅇ 인 사람이 users테이블에 있는지 확인하기

    $stmt = $conn -> prepare("SELECT * FROM users WHERE username=?");
    if(!$stmt) die("쿼리 준비 실패:". $conn -> error);

    $stmt -> bind_param("s", $username);
    $stmt -> execute();
    $result = $stmt -> get_result(); 


 // 6. 0보다 크다 = 해당 레코드를 테이블 users 에서 가져옵니다. 
if ($result->num_rows > 0) {


        $user = $result->fetch_assoc();

        // 7. 사용자가 입력한 비밀번호와 데이터베이스에 저장된 해시 비밀번호를 비교합니다.

        if (password_verify($password, $user['password'])) {
        
            // 세션에 user라는 이름으로 사용자 정보를 저장합니다. 
            $_SESSION['user'] = $username;

            // 로그인 성공: 세션 ID 생성및 저장합니다.
            $sessionId = session_id();
            $updateStmt = $conn->prepare("UPDATE users SET session_id = ? WHERE username = ?");
            $updateStmt->bind_param("ss", $sessionId, $username);
            $updateStmt->execute();

            // 홈 페이지로 리디렉션
            header("Location: home.php");
            exit;
        } else {  // 8. 66번째와 69번째 줄은 에러메세지를 의미합니다.
            echo "잘못된 비밀번호입니다.";
        }
    } else {   
        echo "사용자 이름이 존재하지 않습니다.";
        header("Location:join.html");
    }

    // 9. 데이터베이스 연결과 prepared Statement 연결을 끊습니다. 
    $stmt->close();
    $conn->close();
}
?>