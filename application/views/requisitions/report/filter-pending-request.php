<section class="columns is-gapless mb-0 pb-0">
	<div class="column is-narrow is-fullheight is-hidden-print" id="custom-sidebar">
		<?php $this->view('requisitions/commons/sidebar'); ?>
	</div>
	<div class="column">
		<div class="columns">
			<div class="column section py-5">
				<div class="columns">
					<div class="column is-hidden-print">
						<?php $this->view('requisitions/commons/breadcrumb'); ?>
					</div>
				</div>

				<div class="columns is-hidden-touch">
					<div class="column is-hidden-print">
						<form action="<?= base_url('requisitions/search_request'); ?>" method="get">
							<div class="field has-addons">
								<div class="control has-icons-left is-expanded">
									<input class="input is-small is-fullwidth" name="search" id="myInput" type="search"
										placeholder="Search Request"
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
								<a href='<?= base_url('Requisition_report/pending_request_report'); ?>'
									class="button is-small <?= isset($pending_request_report) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-list"></i>
									</span>
									<span>Pending</span>
								</a>
							</p>
							
							<p class="control">
								<a href="<?= base_url("Requisition_report/process_request_report") ?>"
									class="button is-small <?= (isset($process_request_report)) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-list"></i>
									</span>
									<span>Process</span>
								</a>
							</p>
							<p class="control">
								<a href="<?= base_url("Requisition_report/approved_request_report") ?>"
									class="button is-small <?= (isset($approved_request_report)) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-list"></i>
									</span>
									<span>Approved</span>
								</a>
							</p>
							<?php if($ApprovalAccess->write == 1) : ?>
							<p class="control">
								<a href='<?= base_url('requisitions/add_request'); ?>' data-target="#add_supplier"
									class="button is-small <?= (isset($add_asset)) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-list"></i>
									</span>
									<span>Add Request</span>
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
							<button class="delete"></button>
							<?= $message = $this->session->flashdata('success'); ?>
						</div>
					</div>
				</div>
				<?php elseif($this->session->flashdata('failed')) : ?>
				<div class="columns">
					<div class="column">
						<div class="notification is-danger is-light">
							<button class="delete"></button>
							<?= $message = $this->session->flashdata('failed'); ?>
						</div>
					</div>
				</div>
				<?php endif ?> 
				<!-- tab start here -->

<?php
$id = $this->uri->segment(3);

?>
				<!-- tab end here -->
				<div class="tile is-ancestor">
					<div class="tile is-parent">
						<div class="tile is-child box">
							<div class="columns" style="display: grid">
								<div class="column table-container ">
									<table class="table is-hoverable table-sm is-fullwidth" id="myTable">
										<thead>
											<tr>
												<th class="has-text-weight-semibold">ID</th>
												<th class="has-text-weight-semibold">Item</th>
												<th class="has-text-weight-semibold">Description</th>
												<th class="has-text-weight-semibold"><abbr title="Requested By">Req By</abbr></th>
												<th class="has-text-weight-semibold">Quantity</th>
												<th class="has-text-weight-semibold"><abbr title="Request Date">Req Date</abbr></th>
												<th class="has-text-weight-semibold">Status</th>
												<th class="has-text-weight-semibold is-hidden-print" id="action">Action</th>
											</tr>
										</thead>
										<tfoot class="is-hidden-print">
											<tr>
												<th class="has-text-weight-semibold">ID</th>
												<th class="has-text-weight-semibold">Item</th>
												<th class="has-text-weight-semibold">Description</th>
												<th class="has-text-weight-semibold"><abbr title="Requested By">Req By</abbr></th>
												<th class="has-text-weight-semibold">Quantity</th>
												<th class="has-text-weight-semibold"><abbr title="Request Date">Req Date</abbr></th>
												<th class="has-text-weight-semibold">Status</th>
												<th class="has-text-weight-semibold">Action</th>
											</tr>
										</tfoot>
										<?php if(empty($results)): ?>
										<tbody>
											<?php if(!empty($requests)): foreach($requests as $request): ?>
											<tr>
												<td class="is-narrow"><?= 'S2S-'.$request->id; ?></td>
												<td><?= ucwords($request->item_name); ?></td>
												<td><span
														class=""><?= ucwords(substr($request->item_desc,0,75)); ?></span>
												</td>
												<td><?= ucwords($request->fullname); ?></td>
												<td><?= ucwords($request->item_qty); ?></td>
												<td><?= date('M d, Y', strtotime($request->date)); ?></td>
												<?php if($request->status == NULL) : ?>
												<td>
													<span class="tag is-warning is-light">Pending</span></td>
												<?php elseif($request->status == 2) : ?>
												<td>
												<span class="tag is-info is-light">Process</span></td>
												<?php elseif($request->status == 1) : ?> 
												<td>
												<span class="tag is-success is-light">Approved </span></td> 
												<?php else : ?> 
												<td>
												<span class="tag is-danger is-light">Rejected </span>
												</td>
												<?php endif ?>
												<td class="is-narrow is-hidden-print">
													<div class="field has-addons">
														<p class="control">
															<a href="<?= base_url('requisitions/view_request/'.$request->id); ?>"
																class="button is-small">
																<span class="icon is-small">
																	<i class="fas fa-eye"></i>
																</span>
															</a>
														</p> 
													</div>
												</td>
											</tr>
											<?php endforeach; else: echo "<tr class='table-danger text-center'><td colspan='12'>No record found.</td></tr>"; endif; ?>
										</tbody>
										<?php else: ?>
										<tbody>
											<?php if(!empty($results)): foreach($results as $res): ?>
											<tr>
												<td class="is-narrow"><?= 'S2S-'.$res->id; ?></td>
												<td><?= ucwords($res->item_name); ?></td>
												<td><span
														class="is-size-7"><?= ucwords(substr($res->item_desc,0,75)); ?></span>
												</td>
												<td><?= ucwords($res->fullname); ?></td>
												<td><?= ucwords($res->item_qty); ?></td>
												<td><?= date('M d, Y', strtotime($res->date)); ?></td>

												<?php if($res->status == NULL) : ?>
												<td>
													<span class="tag is-warning is-light">Pending</span></td>
												<?php elseif($res->status == 2) : ?>
												<td>
												<span class="tag is-info is-light">Process</span></td>
												<?php elseif($res->status == 1) : ?> 
												<td>
												<span class="tag is-success is-light">Approved </span></td> 
												<?php else : ?> 
												<td>
												<span class="tag is-danger is-light">Rejected </span>
												</td>
												<?php endif ?>
												<td class="is-narrow is-hidden-print">
													<div class="field has-addons">
														<p class="control">
															<a href="<?= base_url('requisitions/view_request/'.$res->id); ?>"
																class="button is-small">
																<span class="icon is-small">
																	<i class="fas fa-eye"></i>
																</span>
															</a>
														</p> 
													</div>
												</td>
											</tr>
											<?php endforeach; else: echo "<tr class='table-danger text-center'><td colspan='12'>No record found.</td></tr>"; endif; ?>
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
								<?php if(empty($results) AND !empty($requests)){ echo $this->pagination->create_links(); } ?>
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
									class="button is-small exporttable">
									<span class="icon is-small">
										<i class="fas fa-file-export"></i>
									</span>
									<span>Export</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
</section>
<script>
	$(document).ready(function () {
		$(".result_limit").on('change', function () {
			var val = $(this).val();
			$(location).prop('href', '<?= current_url() ?>?<?= $this->uri->segment(2) == 'search_request' ? 'search=' . $this->input->get('search') . '&' : '' ?>limit=' + val)
		})
	})

// code to export report
function exportTableToExcel(tableId, filename) {
		let dataType = 'application/vnd.ms-excel';
		let extension = '.xls';

		let base64 = function (s) {
			return window.btoa(unescape(encodeURIComponent(s)))
		};

		let template =
			'<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
		let render = function (template, content) {
			var r1 = template.replace(/{(\w+)}/g, function (m, p) {
				return content[p];
			});
			var r2 = r1.replace(/{(\w+)}/g, function (m, p) {
				return content[p];
			});
			return r2
		};

		let tableElement = document.getElementById(tableId);

		let tableExcel = render(template, {
			worksheet: filename,
			table: tableElement.innerHTML
		});

		filename = filename + extension;

		if (navigator.msSaveOrOpenBlob) {
			let blob = new Blob(
				['\ufeff', tableExcel], {
					type: dataType
				}
			);

			navigator.msSaveOrOpenBlob(blob, filename);
		} else {
			let downloadLink = document.createElement("a");

			document.body.appendChild(downloadLink);

			downloadLink.href = 'data:' + dataType + ';base64,' + base64(tableExcel);

			downloadLink.download = filename;

			downloadLink.click();
		}
	}

// Hide tfoot when table search returns empty
   $('.exporttable').click(function () {
  $('tfoot').remove();
  $('#action').remove();
});

</script>
