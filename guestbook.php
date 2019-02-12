<?php
	require_once("db.php");
	$link = db_connect();
	define('ROOT', dirname(__FILE__) . '/');

	if ($_POST['comment-add']) {

		$name = trim($_POST['comment-name']);
		$email = trim($_POST['comment-email']);
		$text = trim($_POST['comment-text']);

		$name = strip_tags($name);
		$email = strip_tags($email);
		$text = strip_tags($text);

		$errors = array();

		if (trim($text) == '') {
			$errors[] = 'Введите текст отзыва';
		}

		if ( empty($errors)) {

			$t = "INSERT INTO comments (name, email, text, date) VALUES ('%s', '%s', '%s', NOW())";

			$query = sprintf(
				$t,
				mysqli_real_escape_string($link, $name),
				mysqli_real_escape_string($link, $email),
				mysqli_real_escape_string($link, $text)
			);

			$result = mysqli_query($link, $query);
			if ( !$result ) {
				die(mysqli_error($link));
			}

		} else {
			echo '<div class="message message--error">';
			echo 'Введите текст комментария!';
			echo '</div>';
		}
	}

	// Формируем запрос
	$query = "SELECT * FROM comments ORDER BY id DESC";    

	// Выполняем запрос
	$resultShow = mysqli_query($link, $query);
	if ( !$resultShow ) {
		die(mysqli_error($link));
	}

	// Записываем  полученные данные в массив $appartments 
	$n = mysqli_num_rows($resultShow);
	$comments = array();
	for ( $i = 0; $i < $n; $i++ ) {
		$row = mysqli_fetch_assoc($resultShow);
		$comments[] = $row;
	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<title>Гостевая книга</title>
	<link rel="stylesheet" href="libs/bootstrap-4/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/main.css"/>
	<link rel="stylesheet" href="libs/jquery-ui-1.12.1.custom/jquery-ui.min.css"/>
	<link rel="stylesheet" href="libs/jquery-ui-1.12.1.custom/jquery-ui.structure.css"/>
	<link rel="stylesheet" href="libs/jquery-ui-1.12.1.custom/jquery-ui.theme.min.css"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,700,700i&amp;amp;subset=cyrillic-ext"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/><!--[if lt IE 9]>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script><![endif]-->
</head>
<body>
	<div class="wrapper">
		<?php
			include("header.tpl");			
		?>
		<div class="section-header special-bg--blue">
			<div class="logo">
				<h4>Гостевая книга</h4>
			</div>
		</div>
		<div class="section-content">
			<?php
				// echo "<pre>";
				// print_r($_POST);    
				// print_r($_FILES);
				// echo "</pre>";

				if ( $result ) {
					echo '<div class="message message--success">';
					echo 'Отзыв успешно добавлен!';
					echo '</div>';
				}

			?>


			<h1>Отзывы о отеле</h1>
			
			<div class="mt30" id="comments">

				

			<?php 
		
				// echo "<pre>";
				// print_r($comments);
				// echo "</pre>";
				foreach ($comments as $value) {
				?>

				<div class="appartment">
					<div class="appartment__desc">
						<div class="appartment__header">
							<div class="appartment__title comment-title"><?php echo($value[name]); ?></div>
						</div>
						<p class="comment-email"><?php echo $value[email]; ?></p>
						<div class="appartment__text">
							<p class="comment-text"><?php echo $value[text]; ?></p>
						</div>
						<div class="appartment__footer">
							<div class="appartment__options">
								<div class="tag comment-date"><?php echo $value[date]; ?></div>
							</div>
						</div>
					</div>
				</div>
				<?php


			}

		
			?>

			</div>




			<h4>Добавить отзыв</h4>
			<form class="contact-form mt30" id="" action="guestbook.php" method="POST">
				<div class="row" id="form-notify"></div>
				
				<div class="contact-form__row">
					<input class="input" type="text" id="comment-name" name="comment-name" placeholder="Ваше имя"/>
				</div>
				<div class="contact-form__row">
					<input class="input" type="text" id="comment-email" name="comment-email" placeholder="Email"/>
				</div>
				<div class="contact-form__row">
					<textarea class="textarea" id="comment-text" name="comment-text" placeholder="Текст отзыва"></textarea>
				</div>
				<div class="contact-form__row">
					<input class="button" type="submit" id="comment-add" name="comment-add" value="Добавить отзыв"/>
				</div>
			</form>
		</div>
		<div class="section-footer">
			<div class="address">
				<p>© Админ панель</p>
			</div>
		</div>
	</div>
</body>
<script src="libs/jquery.js"></script>
<script src="libs/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="libs/bootstrap-4/js/bootstrap.min.js"></script>
<script src="js/comments.js"></script>
</html>