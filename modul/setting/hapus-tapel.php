<?php require_once '../../config/config.php';require_once '../../config/db_connect.php';$output = array('success' => false, 'messages' => array());$tema = $_POST['member_id'];$sql = "DELETE from tapel where nama_tapel='$tema'";$query = $connect->query($sql);if($query === TRUE) {	$output['success'] = true;	$output['messages'] = 'Tapel Berhasil dihapus';} else {	$output['success'] = false;	$output['messages'] = 'Error saat mencoba menghapus tapel';}// close database connection$connect->close();echo json_encode($output);