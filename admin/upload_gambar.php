<?php
session_start();
if (isset($_SESSION["ses_username"]) == "") {
	header("location: ../login.php");
} else {
	$data_id = $_SESSION["ses_id"];
	$data_nama = $_SESSION["ses_nama"];
	$data_user = $_SESSION["ses_username"];
	$data_level = $_SESSION["ses_level"];
}
if ($_FILES['file']['name']) {
 if (!$_FILES['file']['error']) {
    $name = md5(rand(100, 200));
    $ext = explode('.', $_FILES['file']['name']);
    $filename = $name . '.' . $ext[1];
    $destination = '../img/' . $filename; //change this directory
    $location = $_FILES["file"]["tmp_name"];
    move_uploaded_file($location, $destination);
    echo '../img/' . $filename;//change this URL
 }
 else
 {
  echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
 }
}
