<?php require_once '../../config/config.php';require_once '../../config/db_connect.php';$output = array('success' => false, 'messages' => array());$id = $_POST['member_id'];$sql = "DELETE from kecamatan where id='$id'";$query = $connect->query($sql);if($query === TRUE) {	$output['success'] = true;	$output['messages'] = 'Kecamatan Berhasil dihapus';} else {	$output['success'] = false;	$output['messages'] = 'Error saat mencoba menghapus Data';}// close database connection$connect->close();echo json_encode($output);