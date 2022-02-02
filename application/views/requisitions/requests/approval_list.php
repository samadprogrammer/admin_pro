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
						<form action="<?= base_url('requisitions/search_approval_request'); ?>" method="get">
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
								<a href='<?= base_url('requisitions/request_list'); ?>'
									class="button is-small <?= isset($asset_register) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-list"></i>
									</span>
									<span>Request List</span>
								</a>
							</p>
							<?php if($ApprovalAccess->write == 1) : ?>
							<p class="control">
								<a href='<?= base_url('requisitions/add_request'); ?>' data-target="#add_supplier"
									class="button is-small <?= (isset($add_asset)) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-plus"></i>
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


				<div class="tabs is-left is-hidden-print">
					<ul>
						<li class="<?php if($id == null){ echo "is-active";} ?>">
							<a href="<?= base_url('requisitions/approval_list') ?>">All</a>
						</li>
						<li class="<?php if($id == 3){ echo "is-active";} ?>">
							<a href="<?= base_url('requisitions/approval_list/3') ?>">Pending</a>
						</li>
						<li class="<?php if($id == 2){ echo "is-active";} ?>"><a
								href="<?= base_url('requisitions/approval_list/2') ?>">Process</a></li>
						<li class="<?php if($id == 1){ echo "is-active";} ?>"><a
								href="<?= base_url('requisitions/approval_list/1') ?>">Approved</a></li>
						<li class="<?php if($id == '0'){ echo "is-active";} ?>"><a
								href="<?= base_url('requisitions/approval_list/0') ?>">Reject</a></li>
					</ul>
				</div>
				<!-- tab end here -->
				<div class="tile is-ancestor">
					<div class="tile is-parent">
						<div class="tile is-child box">
							<div class="columns" style="display: grid">
								<div class="column table-container ">
									<table class="table is-hoverable table-sm is-fullwidth">
										<thead>
											<tr>
												<th class="has-text-weight-semibold">ID</th>
												<th class="has-text-weight-semibold">Item</th>
												<th class="has-text-weight-semibold"><abbr title="Depreciation Percentage">D%</abbr></th>
												<th class="has-text-weight-semibold"><abbr title="Rejectction Reason">Rej Reason</abbr></th> 
												<th class="has-text-weight-semibold"><abbr title="Requested By">Req By</abbr></th>
												<th class="has-text-weight-semibold">Quantity</th>
												<th class="has-text-weight-semibold">Date</th>
												<th class="has-text-weight-semibold">Status</th>
												<th class="has-text-weight-semibold is-hidden-print">Action</th>
											</tr>
										</thead>
										<tfoot class="is-hidden-print">
											<tr>
												<th class="has-text-weight-semibold">ID</th>
												<th class="has-text-weight-semibold">Item</th>
												<th class="has-text-weight-semibold"><abbr title="Depreciation Percentage">D%</abbr></th>
												<th class="has-text-weight-semibold"><abbr title="Rejectction Reason">Rej Reason</abbr></th>
												<th class="has-text-weight-semibold"><abbr title="Requested By">Req By</abbr></th>
												<th class="has-text-weight-semibold">Quantity</th>
												<th class="has-text-weight-semibold">Date</th>
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
												<td><span
														class=""><?= ucwords(substr($request->reject_reason,0,75)); ?></span>
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
													

													
                                                    <?php
													$role = ($this->session->userdata('user_role'));
													if($request->status == 1 && $role == 3 && $request->price == null){ ?>
													  <p class="control">
                                                                <a data-no-instant
                                                                href="<?= base_url('requisitions/view_request/'.$request->id); ?>"
                                                                title="View Request" class="button is-small">
                                                                    <span class="icon is-small">
                                                                    <i class="fas fa-eye"></i>
                                                                    </span>
                                                                </a>
                                                            </p> 
															<p class="control vendor">
															<button type="button"
																data-id="<?= $request->id; ?>"  title="Select Vendor"
																class="button is-small vendor">
																<span class="icon is-small">
																<i class="fas fa-shopping-cart"></i>
																</span>
															</button>
														</p>

														<?php }
													elseif($request->status == 1){ ?>
                                                            <p class="control">
                                                                <a data-no-instant
                                                                href="<?= base_url('requisitions/view_request/'.$request->id); ?>"
                                                                title="View Request" class="button is-small">
                                                                    <span class="icon is-small">
                                                                    <i class="fas fa-eye"></i>
                                                                    </span>
                                                                </a>
                                                            </p>
 
                                                    <?php }
													elseif($request->status == 1 || $request->status == '0'){ ?>
                                                            <p class="control">
                                                                <a data-no-instant
                                                                href="<?= base_url('requisitions/view_request/'.$request->id); ?>"
                                                                title="View Request" class="button is-small">
                                                                    <span class="icon is-small">
                                                                    <i class="fas fa-eye"></i>
                                                                    </span>
                                                                </a>
                                                            </p>

                                                    <?php }
													else{ ?>	
                                                        <p class="control">
                                                                <a data-no-instant
                                                                href="<?= base_url('requisitions/view_request/'.$request->id); ?>"
                                                                title="View Request" class="button is-small">
                                                                    <span class="icon is-small">
                                                                    <i class="fas fa-eye"></i>
                                                                    </span>
                                                                </a>
                                                            </p>
                                                        <!-- <p class="control">
															<a class="button is-small"
																href="<?= base_url("/requisitions/forward_request/" . $request->id) ?>" onclick="javascript:return confirm('Are you sure to Forward this request. Click OK to continue!');">
																<span class="icon is-small">
																	<i class="fas fa-arrow-right"></i>
																</span>
															</a>
														</p> -->

														<p class="control forwad-btn">
															<button type="button"
																data-id="<?= $request->id; ?>"  title="Forwad Request"
																class="button is-small forwad-btn">
																<span class="icon is-small">
																<i class="fas fa-arrow-right"></i>
																</span>
															</button>
														</p>

														<p class="control return-btn">
															<a class="button is-small"
																href="<?= base_url("/requisitions/approved_request/" . $request->id) ?>" onclick="javascript:return confirm('Are you sure to Approved this request. Click OK to continue!');"
																title="approved request">
																<span class="icon is-small  has-text-success">
																	<i class="fas fa-check"></i>
																</span>
															</a> 
														</p>  
														<p class="control reject-btn">
															<button type="button"
																data-id="<?= $request->id; ?>"  title="Reject request"
																class="button is-small has-text-danger reject-btn">
																<span class="icon is-small">
																	<i class="fas fa-times"></i>
																</span>
															</button>
														</p>

                                                        <?php } ?>
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
												<td class="is-narrow">
													<div class="field has-addons">
														<div class="field has-addons">
															<p class="control">
																<a data-no-instant
																	href="<?= base_url('requisitions/view_request/'.$res->id); ?>"
																	title="View Request" class="button is-small">
																	<span class="icon is-small">
																		<i class="fas fa-eye"></i>
																	</span>
																</a>
															</p>

															<p class="control">
																<a class="button is-small"
																	href="<?= base_url("/requisitions/forward_request/" . $res->id) ?>" onclick="javascript:return confirm('Are you sure to Forward this request. Click OK to continue!');">
																	<span class="icon is-small">
																		<i class="fas fa-arrow-right"></i>
																	</span>
																</a>
															</p>

															<p class="control return-btn">
																<a class="button is-small"
																	href="<?= base_url("/requisitions/approved_request/" . $res->id) ?>" onclick="javascript:return confirm('Are you sure to Approved this request. Click OK to continue!');"
																	title="approved request">
																	<span class="icon is-small  has-text-success">
																		<i class="fas fa-check"></i>
																	</span>
																</a>
															</p>
															<p class="control">
																<a class="button is-small"
																	href="<?= base_url("/requisitions/reject_request/" . $res->id) ?>"
																	onclick="javascript:return confirm('Are you sure to Reject this request. Click OK to continue!');"
																	title="reject request">
																	<span class="icon is-small has-text-danger">
																		<i class="fas fa-times"></i>
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
								<!-- <a href="javascript:exportTableToExcel('myTable','Item  Records');" type="button"
									class="button is-small ">
									<span class="icon is-small">
										<i class="fas fa-file-export"></i>
									</span>
									<span>Export</span>
								</a> -->
							</div>
						</div>
					</div>
				</div>
			</div>
</section>

<!-- forwaded list start modal -->
<div class="modal" id="modal-forwad">
			<div class="modal-background"></div>
			<form action="<?= base_url('requisitions/forward_request'); ?>" method="POST">
				<div class="modal-card">
					<input type="hidden" name="id" id="request_id" value="">
					<header class="modal-card-head">
						<p class="modal-card-title">Request Forward</p>
						<button class="delete" aria-label="close" id="exit-forward-modal" type="button"></button>
					</header>
					<section class="modal-card-body">
						<div class="columns">
							<div class="column">
								<div class="control has-icons-left">
									<div class="select is-small is-fullwidth">
										<select name="forward_to" required>
											<option value="" disabled selected>Forward To</option>
											<option value="1">Administrator</option>
											<option value="3">Supervisor</option>
											<option value="2">User</option>
											<option value="4">Employee</option>
										</select>
									</div>
									<span class="icon is-small is-left">
										<i class="fas fa-random"></i>
									</span>
								</div>
							</div> 
						</div> 	
					</section>
					<footer class="modal-card-foot">
						<button class="button is-success" type="submit"> <span class="icon is-small">
						<i class="fas fa-arrow-right"></i></span> </button>
						<button class="button" aria-label="close" id="close-forward-modal" type="reset">Cancel</button>
					</footer>
				</div>
			</form>
		</div>

<!-- forwaded list end modal-->

<!-- select vendor start modal -->
<div class="modal" id="modal-vendor">
			<div class="modal-background"></div>
			<form action="<?= base_url('requisitions/request_for_quotation'); ?>" method="POST">
				<div class="modal-card">
					<input type="hidden" name="request_id" id="requestid" value="">
					<header class="modal-card-head">
						<p class="modal-card-title">Select Vendor </p>
						<button class="delete" aria-label="close" id="exit-vendor-modal" type="button"></button>
					</header>
					<section class="modal-card-body">
						<p id="comment" style="color: red"></p>
						<div class="columns">  
							<div class="column">
							<div class="control">
								<label class="label is-small">Vendor <span class="has-text-danger">*</span></label>
								<div class="control has-icons-left">
									<span class="select is-small is-fullwidth">
										<select name="vendor" id="vendor" class="browser-default custom-select ">
											<option disabled value="" selected>Select Vendor</option>
											<?php if(!empty($suppliers)): foreach($suppliers as $supplier): ?>
											<option value="<?= $supplier->sup_id; ?>">
												<?= ucwords($supplier->sup_name); ?>
											</option> 
											<?php endforeach; endif; ?>
										</select>
									</span>
									<span class="icon is-small is-left">
										<i class="fas fa-user"></i>
									</span>
								</div>
							</div>
						</div> 

						</div> 	
					</section>
					<footer class="modal-card-foot">
						<button class="button is-success" type="submit"> <span class="icon is-small">
						<i class="fas fa-arrow-right"></i></span> </button>
						<button class="button" aria-label="close" id="close-vendor-modal" type="reset">Cancel</button>
					</footer>
				</div>
			</form>
		</div> 
<!-- select vendor modal-->

<!-- modal reject start -->

<div class="modal" id="modal-rej">
			<div class="modal-background"></div>
			<form action="<?= base_url('requisitions/reject_request'); ?>" method="POST">
				<div class="modal-card">
					<input type="hidden" name="id" id="req_id" value="">
					<header class="modal-card-head">
						<p class="modal-card-title">Reject Request</p>
						<button class="delete" aria-label="close" id="exit-reject-modal" type="button"></button>
					</header>
					<section class="modal-card-body">
					 
						<div class="columns">
							<div class="column">
								<textarea name="reason" class="textarea"
									placeholder="Please elaboratly describe your reason for reject the request."></textarea>
							</div>
						</div>
					</section>
					<footer class="modal-card-foot">
						<button class="button is-success" type="submit">Apply</button>
						<button class="button" aria-label="close" id="close-reject-modal" type="reset">Cancel</button>
					</footer>
				</div>
			</form>
		</div>

<!-- modal reject end -->


<script> 
$(document).ready(function () {
		$(".result_limit").on('change', function () {
			var val = $(this).val();
			$(location).prop('href', '<?= current_url() ?>?<?= $this->uri->segment(2) == 'search_request' ? 'search=' . $this->input->get('search') . '&' : '' ?>limit=' + val)
		})
	})

	// code for forwaded model
	$('.forwad-btn').click(function () { 
		var request_id = $(this).data('id'); 
		$('#request_id').val(request_id);
	});

	var btn2 = $(".forwad-btn")
	var md2 = new BulmaModal("#modal-forwad")

	var btn5 = $("#exit-forward-modal")
	var btn6 = $("#close-forward-modal")

	btn2.click(function (ev) {
		md2.show();
		$(".modal-card-head").show();
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

// code for select vendor modal
$('.vendor').click(function () { 
		var request_id = $(this).data('id');
		$('#requestid').val(request_id);
	});

	var btnven2 = $(".vendor")
	var mdven2 = new BulmaModal("#modal-vendor")

	var btnven5 = $("#exit-vendor-modal")
	var btnven6 = $("#close-vendor-modal")

	btnven2.click(function (ev) {
		mdven2.show();
		$(".modal-card-head").show();
		ev.stopPropagation();
	});

	btnven5.click(function (ev) {
		mdven2.close();
		ev.stopPropagation();
	});
	btnven6.click(function (ev) {
		mdven2.close();
		ev.stopPropagation();
	});

	// select coplained on vondor
	$(document).ready(function () { 
		$('#vendor').on('change', function () {
			var vendor = $(this).val();
			// AJAX request
			$.ajax({
				url: "<?=base_url("admin/get_vendor_complained/")?>" + vendor,
				method: "POST",
				data: {
					vendor: vendor
				},
				dataType: 'json',
				success: function (response) {
					// Remove options
					$('#comment').html("");
					if(response['complained'].length != '0'){ 
						var comment = response['complained']; 
						$('#comment').html(comment);

					}
				}
			});
		});
	});

// reject request code 
$('.reject-btn').click(function () {
		var req_id = $(this).data('id');
		$('#req_id').val(req_id);
	});
	var rejbtn = $(".reject-btn")
	var mdrej = new BulmaModal("#modal-rej")

	var rejbtn5 = $("#exit-reject-modal")
	var rejbtn6 = $("#close-reject-modal")

	rejbtn.click(function (ev) {
		mdrej.show();
		$(".modal-card-head").show();
		ev.stopPropagation();
	});
	rejbtn5.click(function (ev) {
		mdrej.close();
		ev.stopPropagation();
	});
	rejbtn6.click(function (ev) {
		mdrej.close();
		ev.stopPropagation();
	});

</script>
