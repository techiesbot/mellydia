<section class="content">
            <header class="content__title">
               <h1>Penjualan (Sedang Dikirim)</h1>
               <div class="actions">
                  <button class="btn btn-primary font-btn" onclick="tambah()"><i class="zmdi zmdi-plus zmdi-hc-fw"></i></button>
               </div>
            </header>
            <div class="card">
               <div class="card-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url();?>penjualan">Sedang Dikemas</a>
                    </li>
                    <li class="nav-item">
						<a class="nav-link active" href="#">Proses</a>
                    </li>
                    <li class="nav-item">
						<a class="nav-link" href="<?php echo base_url();?>penjualan/selesai">Selesai</a>
                    </li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url();?>penjualan/batal">Batal</a>
                    </li>
				</ul>
			   <br>
				<form class="form-inline" action="" method="post">
                     <div class="form-group mb-4 mr-sm-4">
						<select class="form-control" name="admin_id">
						<option value="0">Semua Penjual</option>
						<?php foreach ($user as $ku) { ?>
							<option <?php if($ku->id_admin == $admin_id) { echo 'selected'; } ?>><?php echo $ku->nama_admin;?></option>
						<?php } ?>
						</select>
					 </div>
					 <div class="form-group mb-4 mr-sm-4">
                        <input type="date" class="form-control" name="start" value="<?php echo $awal;?>">
                        <i class="form-group__bar"></i>
                     </div>
                     <div class="form-group mb-4 mr-sm-4">
                        <input type="date" class="form-control" name="end" value="<?php echo $akhir;?>">
                        <i class="form-group__bar"></i>
                     </div>
                     <button type="submit" class="btn btn-primary mb-4">Filter</button>
				</form>
                  <div class="table-responsive">
                     <table class="table table-bordered" id="datatables">
                        <thead>
                              <tr>
                                 <th>No</th>
								 <th>Tanggal</th>
								 <th>Harga</th>
								 <th>Penerima</th>
								 <th>Marketplace</th>
								 <th>Total</th>
                                 <th class="text-right"></th>
                              </tr>
                           </thead>
                           <tfoot>
                              <tr>
                                 <th>No</th>
								 <th>Tanggal</th>
								 <th>Harga</th>
								 <th>Penerima</th>
								 <th>Marketplace</th>
								 <th>Total</th>
                                 <th class="text-right"></th>
                              </tr>
                           </tfoot>
                           <tbody>
                              <?php $no=1;
                                 foreach ($penjualan as $k) { ?>
                              <tr>
                                 <td><?php echo $no;?></td>
								 <td>Pembelian <?php echo date("j M Y", strtotime($k->tgl_penjualan));?>
								 <div class="collapse mt-2 expand<?php echo $no;?>">
									Proses <?php echo date("j M Y", strtotime($k->tgl_proses));?>
								</div>
								 </td>
								 <td><div class="collapse mt-2 expand<?php echo $no;?>">
									<?php foreach($penjualan_paket as $kp) {
										if($kp->penjualan_id == $k->id_penjualan) {
										echo '<div class="border p-1">';
										if($kp->paket_id == 0) {
											echo "<b>Ecer</b><br><br>";
										} else {
											foreach ($paket as $kpaket) {
												if($kpaket->id_paket == $kp->paket_id) {
													echo "<b>".$kpaket->nama_paket.'</b><br><br>';
												}
											}
										}
										foreach ($produk as $kpro) {
											if($kpro->penjualan_paket_id == $kp->id_penjualan_paket) {
												echo $kpro->nama_produk."<br>".$kpro->qty." qty ".number_format($kpro->harga,0,",",".")."<hr>";
											}
										}
										echo "Berat ".number_format($kp->berat_paket,0,",",".")." gram<br>";
										echo 'Total '.number_format($kp->harga_paket,0,",",".");
										echo '</div><br>';
										}
									} ?>
									<b><?php echo number_format($k->total_berat,0,",",".");?> gram</b><br>
									+10% pajak
								</div><b><?php echo number_format($k->total_harga,0,",",".");?></b>
								 </td>
								 <td><?php echo $k->nama_penerima;?><br>
								 <div class="collapse mt-2 expand<?php echo $no;?>">
									<?php echo $k->alamat_penerima."<br>".$k->telp_penerima."<br>(".$k->kurir.") ".number_format($k->ongkir,0,",","."); ?>
								</div>
								 </td>
								 <td><?php echo $k->nama_market;?></td>
								 <td><div class="collapse mt-2 expand<?php echo $no;?>">
									<?php echo "(harga) ".number_format($k->total_harga,0,",",".")." + (ongkir) ".number_format($k->ongkir,0,",","."); ?><br>
								</div><b><?php echo number_format($k->total_harga+$k->ongkir,0,",",".");?></b>
								 </td>
                                 <td class="td-actions text-right">
									<a class="btn btn-warning mb-2" href="<?php echo base_url();?>penjualan/invoice/<?php echo $k->id_penjualan;?>" target="_blank">
									<i class="zmdi zmdi-print zmdi-hc-fw"></i>
									</a>
									&nbsp;
									<button class="btn btn-primary mb-2" type="button" data-toggle="collapse" data-target=".expand<?php echo $no;?>" aria-expanded="false" aria-controls="expand<?php echo $no;?>">
									<i class="zmdi zmdi-eye zmdi-hc-fw"></i>
									</button>
									&nbsp;
									<button type="button" onclick="kirim(<?php echo $k->id_penjualan;?>)" rel="tooltip" class="btn btn-info btn-round mb-2" data-original-title="" title="">
									<i class="zmdi zmdi-local-shipping zmdi-hc-fw"></i>
									</button>
									&nbsp;
                                    <button type="button" onclick="selesai(<?php echo $k->id_penjualan;?>)" rel="tooltip" class="btn btn-success btn-round mb-2" data-original-title="" title="">
                                       <i class="zmdi zmdi-check zmdi-hc-fw"></i>
                                    </button>
                                 </td>
                              </tr>
                              <?php $no++; } ?>
                           </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <footer class="footer hidden-xs-down">
               <p>© Mellydia's Team <?php echo date("Y");?>.</p>
            </footer>
         </section>

<script>
var table;
var simpan;
$(document).ready(function () {
	setTimeout(function() {
		table = $("#datatables").DataTable({
			autoWidth: !1,
			responsive: !0,
			lengthMenu: [
				[15, 30, 45, -1],
				["15 Rows", "30 Rows", "45 Rows", "Everything"]
			],
			language: {
				searchPlaceholder: "Search for records..."
			},
			sDom: '<"dataTables__top"lfB>rt<"dataTables__bottom"ip><"clear">',
			buttons: [{
				extend: "excelHtml5",
				title: "Export Data",
				exportOptions: {
					format: {
						body: function(data, column, row) {
							if (typeof data === 'string' || data instanceof String) {
								data = data.replace(/<br\s*\/?>/ig, "\r\n");
							}
							data = data.replace(/<.*?>/ig, "");
							return data;
						}
					}
				},
			}, {
				extend: "print",
				title: "Print",
				exportOptions: {
					format: {
						body: function(data, column, row) {
							if (typeof data === 'string' || data instanceof String) {
								data = data.replace(/<br\s*\/?>/ig, "\r\n");
							}
							data = data.replace(/<.*?>/ig, "");
							return data;
						}
					}
				},
			}],
			initComplete: function (a, b) {
				$(this).closest(".dataTables_wrapper").find(".dataTables__top").prepend('<div class="dataTables_buttons hidden-sm-down actions"><div class="dropdown actions__item"><i data-toggle="dropdown" class="zmdi zmdi-download" /><ul class="dropdown-menu dropdown-menu-right"><a href="" class="dropdown-item" data-table-action="excel">Excel (.xlsx)</a></ul></div></div>')
			}
		}), $(".dataTables_filter input[type=search]").focus(function () {
			$(this).closest(".dataTables_filter").addClass("dataTables_filter--toggled")
		}), $(".dataTables_filter input[type=search]").blur(function () {
			$(this).closest(".dataTables_filter").removeClass("dataTables_filter--toggled")
		}), $("body").on("click", "[data-table-action]", function (a) {
			a.preventDefault();
			var b = $(this).data("table-action");
			if ("excel" === b && $(this).closest(".dataTables_wrapper").find(".buttons-excel").trigger("click"), "csv" === b && $(this).closest(".dataTables_wrapper").find(".buttons-csv").trigger("click"), "print" === b && $(this).closest(".dataTables_wrapper").find(".buttons-print").trigger("click"), "fullscreen" === b) {
				var c = $(this).closest(".card");
				c.hasClass("card--fullscreen") ? (c.removeClass("card--fullscreen"), $("body").removeClass("data-table-toggled")) : (c.addClass("card--fullscreen"), $("body").addClass("data-table-toggled"))
			}
		})
		
		$(".xform-lg").on("submit", (function (b) {
			b.preventDefault();
			$(".input-mask").unmask()
			var a;
			if (simpan == "tambah") {
				a = "<?php echo base_url();?>penjualan/add"
			} else {
				a = "<?php echo base_url();?>penjualan/update"
			}
			$.ajax({
				url: a,
				type: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function (c) {
					$("#modal-lg").modal("hide");
					//swal("Sukses!", "", "success");
					location.reload();
				},
				error: function (c, e, d) {
					swal("Error", "", "error")
				}
			});
			return false
		}));
		
		$(".xform").on("submit", (function (b) {
			b.preventDefault();
			$(".input-mask").unmask()
			var a = "<?php echo base_url();?>penjualan/update_ongkir";
			$.ajax({
				url: a,
				type: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function (c) {
					$("#modal-lg").modal("hide");
					//swal("Sukses!", "", "success");
					location.reload();
				},
				error: function (c, e, d) {
					swal("Error", "", "error")
				}
			});
			return false
		}));
		
    }, 1500)
});

function tambah() {
	simpan = "tambah";
	$(".form")[0].reset();
	$("#modal-lg").modal("show");
	$("#modalbody-lg").load("<?php echo base_url();?>penjualan/modal/", function (a) {
		$("#modalbody-lg").html(a)
	})
}

function ganti(a) {
	simpan = "update";
	$(".form")[0].reset();
	$("#modal-lg").modal("show");
	$("#modalbody-lg").load("<?php echo base_url();?>penjualan/edit/" + a, function (b) {
		$("#modalbody-lg").html(b)
	})
}

function kirim(a) {
	$(".form")[0].reset();
	$("#myModal").modal("show");
	$("#modalbody").load("<?php echo base_url();?>penjualan/ongkir/" + a, function (b) {
		$("#modalbody").html(b);
	})
}

function selesai(a) {
	Swal.fire({
	  title: 'Penjualan Selesai?',
	  text: "",
	  type: 'success',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Ya',
	  cancelButtonText: "Batal"
	}).then((result) => {
	  if (result.value == true) {
		$.get("<?php echo base_url()?>penjualan/update_selesai/" + a, function (b) { location.reload(); })
	  }
	})
};
</script>