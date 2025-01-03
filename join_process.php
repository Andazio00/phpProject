<?php
 

 include './dbConn.php';


 if($_SERVER['REQUEST_METHOD'] === 'POST'){
 	// 사용자 입력시 데이터 가져오기
 	$username = $_POST['username'];
 	$password = $_POST['password'];
    
    // 9: 회원가입시 비밀번호를 다시한번 입력한 값을 저장
    $confirm_password = $_POST['confirm_password'];

    
    // 빈값 들어가기 방지
    if(empty($username) || empty($password)){
    	echo "모든 필드를 채워주세요";
    	exit;
    }

    
    // 입력한 비밀번호와 재입력한 비밀번호가 동일하지 않은지 비교
    if($password !== $confirm_password){
    	echo "비밀번호가 일치하지 않습니다.";
    	exit;
    }




  // 사용자 이름 중복 확인
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "이미 사용 중인 사용자 이름입니다.";
        exit;
    }

    // 비밀번호 해싱
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 새로운 사용자 저장
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        echo "회원가입이 완료되었습니다.";
        header("Location: login.html"); // 가입 후 로그인 페이지로 리디렉션
        exit;
    } else {
        echo "회원가입 중 오류가 발생했습니다.";
    }

    // 리소스 정리
    $stmt->close();
    $conn->close();

}
?>