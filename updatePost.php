<?php
// 세션 시작
session_start();
include "dbConn.php";

// 로그인 확인
if (!isset($_SESSION['user'])) {
    echo "<script>document.location.href='login.html'</script>";
    exit();
}

// URL에서 post_id를 가져옴
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    // 데이터베이스에서 해당 게시글 정보를 가져옴
    $username = $_SESSION['user'];
    $stmt = $conn->prepare("
        SELECT post_title, post_content 
        FROM posts 
        WHERE post_id = ? AND write_id = (SELECT id FROM users WHERE username = ?)
    ");
    $stmt->bind_param('is', $post_id, $username); // post_id는 정수형, username은 문자열
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
        $title = $post['post_title'];
        $content = $post['post_content'];
    } else {
        echo "게시글을 찾을 수 없습니다.";
        exit();
    }
} else {
    echo "잘못된 요청입니다.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 수정</title>

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h1>게시글 수정</h1>

    <form action="updatePostAction.php" method="POST">
        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

        <label for="update_title">제목</label>
        <input type="text" id="update_title" name="update_title" value="<?php echo htmlspecialchars($title); ?>" required><br><br>

        <label for="update_content">내용</label><br>
        <textarea id="update_content" name="update_content" rows="4" cols="50" required><?php echo htmlspecialchars($content); ?></textarea><br><br>

        <button class="btn btn-primary" type="submit">수정하기</button>
    </form>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</body>
</html>

