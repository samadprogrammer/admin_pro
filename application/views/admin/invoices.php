<section class="columns is-gapless mb-0 pb-0">
	<div class="column is-narrow is-fullheight is-hidden-print" id="custom-sidebar">
		<?php $this->view('admin/commons/sidebar'); ?>
	</div>
	<div class="column">
		<div class="columns">
			<div class="column section">
				<div class="columns">
					<div class="column">
						<?php $this->view('admin/commons/breadcrumb'); ?>
					</div>
				</div>
				<div class="columns is-hidden-touch">
					<div class="column is-hidden-print">
						<form action="<?= base_url('admin/search_invoices'); ?>" method="get">
							<div class="field has-addons">
								<div class="control has-icons-left is-expanded">
									<input class="input is-small is-fullwidth" name="search" id="myInput" type="search"
										placeholder="Search Invoices"
										value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" required>
									<span class="icon is-small is-left">
										<i class="fas fa-search"></i>
									</span>
								</div>
								<div class="control">
									<button class="button is-small" type="submit"><span class="icon is-small">
											<i class="fas fa-arrow-right"></i>
										</span>
									</button>
								</div>
							</div>
						</form>
					</div>
					<div class="column is-hidden-print is-narrow">
						<div class="field has-addons">
							<p class="control">
								<a href='<?= base_url('admin/invoices'); ?>'"
									class="button is-small <?= isset($invoices) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-list"></i>
									</span>
									<span>Invoice List</span>
								</a>
							</p>
							<?php if($AssetsAccess->write == 1) : ?>
							<p class="control">
								<a href='<?= base_url('admin/add_invoice'); ?>'"
									data-target="#add_supplier"
									class="button is-small <?= (isset($add_invoice)) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-plus"></i>
									</span>
									<span>Add New</span>
								</a>
							</p>
							<?php endif ?>
						</div>
					</div>
				</div>
				<?php if($this->session->flashdata('success')) : ?>
				<div class="columns">
					<div class="column">
						<div class="notification is-success is-light">
							<button class="delete is-small"></button>
							<div class="columns is-vcentered">
								<div class="column is-size-7">
									<i class="fas fa-check pr-1"></i>
									<?= $message = $this->session->flashdata('success'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php elseif($this->session->flashdata('failed')) : ?>
				<div class="columns">
					<div class="column">
						<div class="notification is-danger is-light">
							<button class="delete is-small"></button>
							<div class="columns is-vcentered">
								<div class="column is-size-7">
									<i class="fas fa-exclamation pr-1"></i>
									<?= $message = $this->session->flashdata('failed'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endif ?>
				<div class="tile is-ancestor">
					<div class="tile is-parent">
						<div class="tile is-child box">

							<div class="columns" style="display: grid">
								<div class="column table-container ">
									<table class="table table-sm is-fullwidth">
										<thead>
											<tr>
												<th class="has-text-weight-semibold">ID</th>
												<th class="has-text-weight-semibold">Inv No.</th>
												<th class="has-text-weight-semibold">Supplier</th>
												<th class="has-text-weight-semibold">Location</th>
												<th class="has-text-weight-semibold">Project</th>
												<th class="has-text-weight-semibold">Item</th>
												<th class="has-text-weight-semibold">Amount</th>
												<th class="has-text-weight-semibold">Date</th>
												<th class="has-text-weight-semibold">R/Reason</th>
												<th class="has-text-weight-semibold">Status</th>
												<th class="has-text-weight-semibold">Action</th>
											</tr>
										</thead>
										<?php if(empty($results)): ?>
										<tbody>
											<?php if(!empty($invoices)): foreach($invoices as $inv): ?>
											<tr>
												<td><?= 'S2S-'.$inv->id; ?></td>
												<td><?= $inv->inv_no; ?></td>
												<td><?= $inv->sup_name; ?></td>
												<td><?= ucfirst($inv->name); ?></td>
												<td><?= $inv->project_name; ?></td>
												<td><?= $inv->item; ?></td>
												<td><?= number_format($inv->amount); ?></td>
												<td><?php if($inv->inv_date){ echo date('M d, Y', strtotime($inv->inv_date)); }else{ echo '--/--/--'; } ?>
												</td>
												<?php if(!empty($inv->status_reason)){?>
												<td><?= $inv->status_reason; ?></td>
												<?php }else{ ?>
												<td>N/A</td>
												<?php } ?>
												<td><?php if($inv->status == 0){ echo "<span class='tag is-warning is-light'>Pending</span>"; }else{ echo "<span class='tag is-success is-light'>Cleared</span>"; } ?>
												</td>

												<td class="">
													<div class="field has-addons">
														<a href="<?= base_url('admin/edit_invoice/' . $inv->id) ?>"
															class="button is-small"><span class="icon is-small"><i
																	class="fa fa-edit"></i></span></a>
														<?php if($inv->status == 0) {?>			
														<a href="<?= base_url('admin/invoice_status/' . $inv->id) ?>"
															class="button is-small"><span class="icon is-small"><i
																	class="fa fa-check"></i></span></a>
														<?php } else {?>
															
															<p class="control return-btn">
															<button type="button" 
																data-id="<?= $inv->id; ?>"
																class="button is-small has-text-danger return-btn">
																<span class="icon is-small">
																	<i class="fas fa-ban"></i>
																</span>
															</button>
														</p> 
																	<?php } ?>
														<a href="<?= base_url('admin/print_invoice/' . $inv->id) ?>"
															class="button is-small"><span class="icon is-small"><i
																	class="fa fa-print"></i></span></a>
													</div>
												</td>
											</tr>
											<?php endforeach; else: echo "<tr class='table-danger text-center'><td colspan='9'>No record found.</td></tr>"; endif; ?>
										</tbody>
										<?php else: ?>
										<tbody>
											<?php if(!empty($results)): $expenses = 0; foreach($results as $res): $expenses += $res->amount; ?>
											<tr>
												<td><?= 'S2S-'.$res->id; ?></td>
												<td><?= $res->inv_no; ?></td>
												<td><?= $res->sup_name; ?></td>
												<td><?= ucfirst($res->name); ?></td>
												<td><?= $res->project_name; ?></td>
												<td><?= $res->item; ?></td>
												<td><?= number_format($res->amount); ?></td>
												<td><?php if($res->inv_date){ echo date('M d, Y', strtotime($res->inv_date)); }else{ echo '--/--/--'; } ?>
												</td>
												<td><?php if($res->status == 0){ echo "<span class='tag is-warning is-light'>Pending</span>"; }else{ echo "<span class='tag is-success is-light'>Cleared</span>"; } ?>
												</td>
												<td class="">
													<div class="field has-addons">
														<a href="<?= base_url('admin/edit_invoice/' . $res->id) ?>"
															class="button is-small"><span class="icon is-small"><i
																	class="fa fa-edit"></i></span></a>
																	<?php if($res->status == 0) {?>			
														<a href="<?= base_url('admin/invoice_status/' . $res->id) ?>"
															class="button is-small"><span class="icon is-small"><i
																	class="fa fa-check"></i></span></a>
														<?php } else {?>
															
															<p class="control return-btn">
															<button type="button" 
																data-id="<?= $res->id; ?>"
																class="button is-small has-text-danger return-btn">
																<span class="icon is-small">
																	<i class="fas fa-ban"></i>
																</span>
															</button>
														</p> 
																	<?php } ?> 
														<a href="<?= base_url('admin/print_invoice/' . $res->id) ?>"
															class="button is-small"><span class="icon is-small"><i
																	class="fa fa-print"></i></span></a>
													</div>
												</td>
											</tr>
											<?php endforeach; else: echo "<tr class='table-danger text-center'><td colspan='9'>No record found.</td></tr>"; endif; ?>

										</tbody>
										<?php endif; ?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="column">
					<div class="columns">
						<div class="column is-hidden-print">
							<label class="mr-2">Number of Records:</label>
							<select class="result_limit">
								<option <?= $this->input->get('limit') == 25 ? 'selected' : '' ?> value="25">25
								</option>
								<option <?= $this->input->get('limit') == 50 ? 'selected' : '' ?> value="50">50
								</option>
								<option <?= $this->input->get('limit') == 100 ? 'selected' : '' ?> value="100">100
								</option>
							</select>
						</div>
						<div class="column is-hidden-print">
							<nav class="pagination is-small" role="navigation" aria-label="pagination"
								style="justify-content: center;">
								<?php if(empty($results) AND !empty($items)){ echo $this->pagination->create_links(); } ?>
							</nav>
						</div>
						<div class="column is-hidden-print">
							<div class="buttons is-pulled-right">
								<button onClick="window.print();" type="button" class="button is-small ">
									<span class="icon is-small">
										<i class="fas fa-print"></i>
									</span>
									<span>Print</span>
								</button>
								<a href="javascript:exportTableToExcel('myTable','Item  Records');" type="button"
									class="button is-small ">
									<span class="icon is-small">
										<i class="fas fa-file-export"></i>
									</span>
									<span>Export</span>
								</a>
							</div>
						</div>
					</div>
				</div>
	
				<div class="modal" id="modal-rej">
			<div class="modal-background"></div>
			<form action="<?= base_url('admin/invoice_status_pending'); ?>" method="POST" enctype="multipart/form-data">
				<div class="modal-card">
					<input type="hidden" name="id" id="invoice-id" value="">
					<header class="modal-card-head">
						<p class="modal-card-title">Revert Status</p>
						<button class="delete" aria-label="close" id="exit-return-modal" type="button"></button>
					</header>
					<section class="modal-card-body"> 
						<div class="columns">
							<div class="column">
								<textarea name="reason" class="textarea"
									placeholder="Please elaboratly describe your reason for reverting the status."></textarea>
							</div>
						</div>
					</section>
					<footer class="modal-card-foot">
						<button class="button is-success" type="submit">Apply</button>
						<button class="button" aria-label="close" id="close-return-modal" type="reset">Cancel</button>
					</footer>
				</div>
			</form>
		</div>

			</div>
</section>

<script>
	$(document).ready(function () {
		$(".result_limit").on('change', function () {
			var val = $(this).val();
			$(location).prop('href', '<?= current_url() ?>?<?= $this->uri->segment(2) == 'search_invoices' ? 'search=' . $this->input->get('search') . ' & ' : '' ?>limit=' + val)
		})
	})
 
	$('.return-btn').click(function () {
		var invoice_id = $(this).data('id');
 
		$('#invoice-id').val(invoice_id);
	});

	var btn2 = $(".return-btn")
	var btn3 = $("#exit-report-modal")
	var btn4 = $("#close-report-modal")
	var btn5 = $("#exit-return-modal")
	var btn6 = $("#close-return-modal")

	var md2 = new BulmaModal("#modal-rej")
 
btn2.click(function (ev) {
	md2.show();
	$(".modal-card-head").show();
	ev.stopPropagation();
});
btn3.click(function (ev) {
	mdl.close();
	ev.stopPropagation();
});
btn4.click(function (ev) {
	mdl.close();
	ev.stopPropagation();
});
btn5.click(function (ev) {
	md2.close();
	ev.stopPropagation();
});
btn6.click(function (ev) {
	md2.close();
	ev.stopPropagation();
});



</script>
