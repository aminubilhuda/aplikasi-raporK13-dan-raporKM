<?php
require_once '../../config/db_connect.php';
$kelas=$_GET['kelas'];
$tapel=$_GET['tapel'];
$smt=$_GET['smt'];
$ab=substr($kelas,0,1);
//$tpem=$_GET['tp'];
$output = array('data' => array());

$sql = "select penempatan.peserta_didik_id,siswa.nama from penempatan left join siswa on penempatan.peserta_didik_id=siswa.peserta_didik_id where penempatan.rombel='$kelas' and penempatan.tapel='$tapel' and penempatan.smt='$smt' order by siswa.nama asc";
$query = $connect->query($sql);
//$mapel=$connect->query("select * from mata_pelajaran where id_mapel='$mp'")->fetch_assoc();
if($kelas==0){
}else{
	?>
<div class="table-responsive">
	<table class="table table-striped table-hover mb-0" id="datatable-1">
		<thead>
			<tr>
				<th width="30%">Nama</th>
				<?php 
				$sql1 = "select * from mata_pelajaran order by id_mapel asc";
				$query1 = $connect->query($sql1);
				while ($row1 = $query1->fetch_assoc()) {
				?>
				<th><?=$row1['kd_mapel'];?></th>
				<?php } ?>
				<th>Jumlah</th>
				<th>Rerata</th>
				<th>Rank</th>
			</tr>
		</thead>
		<tbody>
	<?php
while($s=$query->fetch_assoc()) {
	$idp=$s['peserta_didik_id'];
	$siswa=$connect->query("select * from siswa where peserta_didik_id='$idp'")->fetch_assoc();
	$sql2 = "select * from mata_pelajaran order by id_mapel asc";
	$query2 = $connect->query($sql2);
?>
			<tr>
				<td><?=$s['nama'];?></td>
<?php 
	while($sl=$query2->fetch_assoc()) {
		$idm=$sl['id_mapel'];
		$ada1=$connect->query("select * from raport_ikm where id_pd='$idp' and kelas='$kelas' and smt='$smt' and tapel='$tapel' and mapel='$idm'")->num_rows;
		if($ada1>0){
			$nh1=$connect->query("select * from raport_ikm where id_pd='$idp' and kelas='$kelas' and smt='$smt' and tapel='$tapel' and mapel='$idm'")->fetch_assoc();
			$nilai1=number_format($nh1['nilai'],0);
		}else{
			$nilai1="";
		};
?>
				<td><?=$nilai1;?></td>
<?php 
	};
	$jumlah=$connect->query("select sum(nilai) as jumlah from raport_ikm where id_pd='$idp' and kelas='$kelas' and smt='$smt' and tapel='$tapel'")->fetch_assoc();
	$total=$jumlah['jumlah'];
	$cekrapor=$connect->query("SELECT * FROM ranking_ikm WHERE id_pd='$idp' AND kelas='$kelas' AND smt='$smt' AND tapel='$tapel'")->num_rows;
	if($cekrapor>0){
		$idr=$connect->query("SELECT * FROM ranking_ikm WHERE id_pd='$idp' AND kelas='$kelas' AND smt='$smt' AND tapel='$tapel'")->fetch_assoc();
		$idrp=$idr['id_rank'];
		$sql1 = "UPDATE ranking_ikm set jumlah='$total' WHERE id_rank='$idrp'";
		$query1 = $connect->query($sql1);
	}else{
		$sql1 = "INSERT INTO ranking_ikm(id_pd,kelas,tapel,smt,jumlah) VALUES('$idp','$kelas','$tapel','$smt','$total')";
		$query1 = $connect->query($sql1);
	};
	//Rerata
	$rerata=$connect->query("select AVG(nilai) as rerata from raport_ikm where id_pd='$idp' and kelas='$kelas' and smt='$smt' and tapel='$tapel'")->fetch_assoc();
	
	$ranking=$connect->query("select id_pd,jumlah,(select find_in_set(jumlah,(select group_concat(distinct jumlah order by jumlah desc separator ',') from ranking_ikm where kelas='$kelas' AND smt='$smt' AND tapel='$tapel'))) as ranking from ranking_ikm where id_pd='$idp' AND kelas='$kelas' AND smt='$smt' AND tapel='$tapel'")->fetch_assoc();
?>
				<td><?=number_format($jumlah['jumlah'],0);?></td>
				<td><?=number_format($rerata['rerata'],2);?></td>
				<td><?=$ranking['ranking'];?></td>
			</tr>
<?php 
};
?>
	</tbody>
</table>
</div>
<?php 
};
?>
