<?php
session_start();

if (isset($_POST['id'])) {
	$_SESSION['id'] = $_POST['id'];
}
 ?>