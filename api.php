<?php  

function getLatestComments(){

	require_once("db.php");
	$link = db_connect();

	// Формируем запрос
	$query = "SELECT * FROM comments ORDER BY id DESC";

	// Выполняем запрос
	$result = mysqli_query($link, $query);
	if ( !$result ) {
		die(mysqli_error($link));
	}

	// Записываем  полученные данные в массив $appartments 
	$n = mysqli_num_rows($result);
	$comments = array();
	for ( $i = 0; $i < $n; $i++ ) {
		$row = mysqli_fetch_assoc($result);
		$comments[] = $row;
	}

	echo json_encode($comments);
}

// getLatestComments();
// print_r($_GET['action']);
// if ( isset($_GET['action'] == ['getNew']) {

if ( $_GET['action'] == 'getNew') {
	getLatestComments();
}


?>