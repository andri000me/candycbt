<?php
	$pesan = '';
	if (isset($_POST['simpanserver'])) {
		$kode = $_POST['kodeserver'];
		$nama = $_POST['namaserver'];
		$status = $_POST['status'];
		$cek = mysql_num_rows(mysql_query("select * from server where kode_server='$kode'"));
		if ($cek == 0) {
			$exec = mysql_query("INSERT INTO server (kode_server,nama_server,status)value('$kode','$nama','$status')");
			$pesan = "<div class='alert alert-success alert-dismissible'>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
										<i class='icon fa fa-info'></i>
										Data Berhasil ditambahkan ..
										</div>";
		} else {
			$pesan = "<div class='alert alert-warning alert-dismissible'>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
										<i class='icon fa fa-info'></i>
										Maaf Kode server Sudah ada !
										</div>";
		}
	}
	if (isset($_POST['editserver'])) {
		$kode = $_POST['kodeserver'];
		$nama = $_POST['namaserver'];
		$status = $_POST['status'];
		$status_sycn = $_POST['status_sycn'];
		$exec = mysql_query("UPDATE server set nama_server='$nama',status='$status' ,status_sycn='$status_sycn'where kode_server='$kode'");
		$pesan = "<div class='alert alert-success alert-dismissible'>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
										<i class='icon fa fa-info'></i>
										Data Berhasil diperbaharui ..
									</div>";
	}
	echo "
								<div class='row'><div class='col-md-12'>$pesan</div>
									<div class='col-md-12'>
										<div class='box box-primary'>
											<div class='box-header with-border'>
												<h3 class='box-title'>Data Server Lokal</h3>
												<div class='box-tools pull-right btn-group'>
													<button class='btn btn-sm btn-primary' data-toggle='modal' data-target='#tambahserver'><i class='fa fa-check'></i> Tambah server</button>
													
												</div>
									
											</div><!-- /.box-header -->
											<div class='box-body'>
											<div class='table-responsive'>
												<table id='example1' class='table table-bordered table-striped'>
													<thead>
														<tr>
															<th width='5px'>#</th>
															<th>Kode server</th>
															<th>Nama Server</th>
															<th>Status Server</th>
															<th>Status Sycn</th>
															<th></th>
															
															
														</tr>
													</thead>
													<tbody>";
	
	$serverQ = mysql_query("SELECT * FROM server ORDER BY nama_server ASC");
	
	while ($server = mysql_fetch_array($serverQ)) {
		$no++;
		echo "
															<tr>
																<td>$no</td>
																<td>$server[kode_server]</td>
																<td>$server[nama_server]</td>
																<td>";
		if ($server['status'] == 'aktif') {
			echo "<label class='label label-success'>$server[status]</label></td>";
		} else {
			echo "<label class='label label-warning'>$server[status]</label></td>";
		}
		echo "
																<td>";
		if ($server['status_sycn'] == 'sudah') {
			echo "<label class='label label-success'>$server[status_sycn]</label></td>";
		} else {
			echo "<label class='label label-warning'>$server[status_sycn]</label></td>";
		}
		echo "</td>
																<td align='center'>
																	<div class='btn-group'>
																			<a><button class='btn btn-warning btn-xs' data-toggle='modal' data-target='#editserver$server[kode_server]'><i class='fa fa-pencil-square-o'></i></button></a>
																			<a><button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#hapus$server[kode_server]'><i class='fa fa-trash-o'></i></button></a>
																	</div>
																</td>
															</tr>";
		$sql = mysql_query("select * from server where kode_server='$server[kode_server]'");
		$sqlx = mysql_fetch_array($sql);
		
		$info = info("Anda yakin akan menghapus Nama Server $server[kode_server] ini  ?");
		if (isset($_POST['hapus'])) {
			$exec = mysql_query("DELETE from server where kode_server='$_POST[idu]'");
			(!$exec) ? $info = info("Gagal menghapus!", "NO") : jump("?pg=$pg");
			
		}
		echo "
															
													<div class='modal fade' id='hapus$server[kode_server]' style='display: none;'>
													<div class='modal-dialog'>
													<div class='modal-content'>
													<div class='modal-header'>
															<h3 class='modal-title'>Hapus Soal</h3>
															</div>
													<div class='modal-body'>
													<form action='' method='post'>
													<input type='hidden' id='idu' name='idu' value='$server[kode_server]'/>
													<div class='callout callout-warning'>
															<h4>$info</h4>
													</div>
													<div class='modal-footer'>
													<div class='box-tools pull-right btn-group'>
																<button type='submit' name='hapus' class='btn btn-sm btn-danger'><i class='fa fa-trash-o'></i> Hapus</button>
																<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
													</div>	
													</div>
													</form>
													</div>
								
													</div>
														<!-- /.modal-content -->
													</div>
														<!-- /.modal-dialog -->
													</div>
								
															<div class='modal fade' id='editserver$server[kode_server]' style='display: none;'>
															<div class='modal-dialog'>
															<div class='modal-content'>
															<div class='modal-header'>
															<h3 class='modal-title'>Edit Nama Server</h3>
															</div>
															<div class='modal-body'>
															<form action='' method='post'>
															<div class='form-group'>
																<label>Kode server</label>
																<input type='text' name='kodeserver' class='form-control' value='$server[kode_server]' readonly/>
															</div>
															<div class='form-group'>
																<label>Nama Server</label>
																<input type='text' name='namaserver'  class='form-control' value='$server[nama_server]' required='true'/>
															</div>
															<div class='form-group'>
																<label>Status Server</label>
																<select class='form-control' name='status'>
																<option value='aktif'>aktif</option>
																<option value='tidak'>tidak</option>
																</select>
															</div>
															<div class='form-group'>
																<label>Status Sycn</label>
																<select class='form-control' name='status_sycn'>
																<option value='sudah'>sudah</option>
																<option value='belum'>belum</option>
																</select>
															</div>
															<div class='modal-footer'>
															<div class='box-tools pull-right btn-group'>
																<button type='submit' name='editserver' class='btn btn-sm btn-success'><i class='fa fa-check'></i> Simpan</button>
																<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
															</div>
															</div>
															</form>
															</div>
								
															</div>
															<!-- /.modal-content -->
															</div>
															<!-- /.modal-dialog -->
															</div>
														";
	}
	echo "
													</tbody>
												</table>
												</div>
												
											</div><!-- /.box-body -->
										</div><!-- /.box -->
									</div>
															<div class='modal fade' id='tambahserver' style='display: none;'>
															<div class='modal-dialog'>
															<div class='modal-content'>
															<div class='modal-header'>
															<h3 class='modal-title'>Tambah Nama Server</h3>
															</div>
															<div class='modal-body'>
															<form action='' method='post'>
															<div class='form-group'>
																<label>Kode server</label>
																<input type='text' name='kodeserver' class='form-control'  required='true'/>
															</div>
															<div class='form-group'>
																<label>Nama Server</label>
																<input type='text' name='namaserver'  class='form-control' required='true'/>
															</div>
															<div class='form-group'>
																<label>Status Server</label>
																<select class='form-control' name='status'>
																<option value='aktif'>aktif</option>
																<option value='tidak'>tidak</option>
																</select>
															</div>
															<div class='modal-footer'>
															<div class='box-tools pull-right btn-group'>
																<button type='submit' name='simpanserver' class='btn btn-sm btn-success'><i class='fa fa-check'></i> Simpan</button>
																<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
															</div>
															</div>
															</form>
															</div>
								
															</div>
															<!-- /.modal-content -->
															</div>
															<!-- /.modal-dialog -->
															</div>";