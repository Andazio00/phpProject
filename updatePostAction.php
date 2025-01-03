<?php
session_start();
include "dbConn.php";

// 로그인 확인
if (!isset($_SESSION['user'])) {
    echo "<script>document.location.href='login.html'</script>";
    exit();
}

if (isset($_POST['post_id']) && isset($_POST['update_title']) && isset($_POST['update_content'])) {
    $post_id = $_POST['post_id'];
    $update_title = $_POST['update_title'];
    $update_content = $_POST['update_content'];
    $username = $_SESSION['user'];

    // 데이터베이스에서 해당 게시글을 업데이트
    $stmt = $conn->prepare("
        UPDATE posts 
        SET post_title = ?, post_content = ? 
        WHERE post_id = ? AND write_id = (SELECT id FROM users WHERE username = ? LIMIT 1)
    ");
    $stmt->bind_param('ssis', $update_title, $update_content, $post_id, $username);

    if ($stmt->execute()) {
        echo "게시글이 성공적으로 수정되었습니다.";
        echo "<script>document.location.href='home.php'</script>";
    } else {
        echo "게시글 수정에 실패했습니다. 오류: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "잘못된 요청입니다.";
}
?>