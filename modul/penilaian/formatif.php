<?phprequire_once '../../config/db_connect.php';
$kelas=$_GET['kelas'];$mp=$_GET['mp'];$materi=$_GET['lm'];$tapel=$_GET['tapel'];$smt=$_GET['smt'];
$ab=substr($kelas,0,1);//$tpem=$_GET['tp'];$output = array('data' => array());$sql = "select * from penempatan where tapel='$tapel' and smt='$smt' and rombel='$kelas' order by nama asc";$query = $connect->query($sql);$mapel=$connect->query("select * from mata_pelajaran where id_mapel='$mp'")->fetch_assoc();if($mp==0 or $materi==0){}else{	?><div class="table-responsive">	<table class="table table-striped table-hover mb-0">		<thead>			<tr>				<th>Nama</th>				<?php 				$sql3 = "select * from tp where kelas='$ab' and lm='$materi' and smt='$smt' and mapel='$mp' order by tp asc";				$query3 = $connect->query($sql3);				while($sm=$query3->fetch_assoc()) {				?>				<th>TP <?=$sm['tp'];?></th>				<?php } ?>			</tr>		</thead>		<tbody>	<?phpwhile($s=$query->fetch_assoc()) {	$idp=$s['peserta_didik_id'];	$siswa=$connect->query("select * from siswa where peserta_didik_id='$idp'")->fetch_assoc();	$sql2 = "select * from tp where kelas='$ab' and lm='$materi' and smt='$smt' and mapel='$mp' order by tp asc";	$query2 = $connect->query($sql2);?>			<tr>				<td><?=$siswa['nama'];?></td><?php 	while($sl=$query2->fetch_assoc()) {		$tpem=$sl['tp'];		$sql1 = "select * from formatif where id_pd='$idp' and smt='$smt' and tapel='$tapel' and mapel='$mp' and lm='$materi' and tp='$tpem'";		$nh = $connect->query($sql1);		$m=$nh->fetch_assoc();		if(empty($m['nilai'])){			$nHar='';		}else{			$nHar=number_format($m['nilai'],0);		};		//$ids=$s['id_lm'];		$actionButton = '		<span class="input form-control form-control-sm" contenteditable="true" data-old_value="'.$nHar.'"  onBlur="saveFormatif(this,\'nilai\',\''.$idp.'\',\''.$ab.'\',\''.$smt.'\',\''.$tapel.'\',\''.$mp.'\',\''.$tpem.'\',\''.$materi.'\')" onClick="highlightEdit(this);">'.$nHar.'</span>		';?>				<td><?=$actionButton;?></td><?php 	};?>			</tr><?php };?>	</tbody></table></div><?php };?>