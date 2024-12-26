

<?php

session_start();


session_unset();


if(ini_get("session.use_cookies")){
	$params = session_get_cookie_params();

	setcookie(
     session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
	);
}


session_destroy();
?>


<script>
   alert("로그아웃 되었습니다.");
   location.replace('login.html');

</script>