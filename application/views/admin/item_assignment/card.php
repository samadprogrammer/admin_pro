<section class="columns is-gapless mb-0 pb-0 ">
	<div class="column is-narrow is-fullheight is-hidden-print" id="custom-sidebar">
		<?php $this->view('admin/commons/sidebar'); ?>
	</div>

	<div class="column">
		<div class="columns">
			<div class="column section">

				<div class="columns is-hidden-touch">
					<div class="column is-hidden-print">
						<form action="<?= base_url('admin/search_item') ?>" method="GET">
							<div class="field has-addons">
								<div class="control has-icons-left is-expanded">
									<input class="input is-small is-fullwidth" name="search" type="search"
										placeholder="Search Items"
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
					<div class="column is-hidden-print">
						<div class="field has-addons">
							<p class="control">
								<button onclick="location.href='<?= base_url('admin/item_register'); ?>'"
									class="button is-small <?= (isset($item_register)) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-list"></i>
									</span>
									<span>Items List</span>
								</button>
							</p>
							<p class="control">
								<button onclick="location.href='<?= base_url('admin/available_item_list'); ?>'"
									class="button is-small <?= (isset($available_page)) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="far fa-list-alt"></i>
									</span>
									<span>Available List</span>
								</button>
							</p>
							<p class="control">
								<button onclick="location.href='<?= base_url('admin/get_assign_item'); ?>'"
									class="button is-small <?= (isset($assign_page)) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-bars"></i>
									</span>
									<span>Assigned List</span>
								</button>
							</p>
							<p class="control">
								<button onclick="location.href='<?= base_url('admin/get_damaged_item'); ?>'"
									class="button is-small <?= (isset($damaged_item)) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-unlink"></i>
									</span>
									<span>Damaged List</span>
								</button>
							</p>
							<p class="control">
								<button onclick="location.href='<?= base_url('admin/add_item'); ?>'"
									class="button is-small <?= (isset($add_page)) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-plus"></i>
									</span>
									<span>Add New</span>
								</button>
							</p>
							<p class="control">
								<button
									class="button is-small <?= (isset($product_report)) ? 'has-background-primary-light' : '' ?>"
									id="report-btn">
									<span class="icon is-small">
										<i class="fas fa-paperclip"></i>
									</span>
									<span>Report</span>
								</button>
							</p>
						</div>
					</div>
				</div>

				<div class='container'>
					<div class='columns is-mobile'>
						<div class='column is-12'>
							<div class="card">
								<?php if(!empty($items)): ?>
								<p class="subtitle has-text-centered is-hidden">AH Group of Companies (Pvt.) Ltd.
									Islamabad, 44000</p>
								<p class="subtitle has-text-centered"><strong>Category</strong> &raquo;
									<?= $items[0]->cat_name ?></p>
								<div class="card-content">
									<div class="columns is-12">
										<div class="column">
											<div class="columns">
												<table class="table table-striped table-sm">
													<tbody>
														<tr>
															<th>Product</th>
															<?php if(!empty($items[0]->name)) { ?>
															<td><?= $items[0]->names; ?></td>
															<?php } else{ ?>
																<td>N/A</td>
																<?php } ?>
															<th>Employee</th>
															<?php if(!empty($items[0]->emp_name)) { ?>
															<td><?= $items[0]->emp_name; ?></td>
															<?php }else { ?>
																<td>N/A</td>
																<?php } ?>
														</tr>
														<tr>
															<th>Serial/IMEI</th>
															<?php if(!empty($items[0]->serial_number)) { ?>
															<td><?= $items[0]->serial_number; ?></td>
															<?php } else { ?>
																<td>N/A</td>
																<?php } ?>
															<th>Model</th>
															<?php if(!empty($items[0]->model)) { ?>
															<td><?= $items[0]->model; ?></td>
															<?php } else {?>
																<td>N/A</td>
																<?php } ?>
														</tr>
														<tr>
															<th>Purchase Date</th>
															<?php if(!empty($items[0]->purchasedate)) { ?>
															<td><?= $items[0]->purchasedate; ?></td>
															<?php } else {?>
																<td>N/A</td>
																<?php } ?>
															<th>Price</th>
															<?php if(empty($items[0]->price)) { ?>
															<td id="price"><?php echo '<span>'.$items[0]->price.'</span>'; ?></td>
															<?php } else {?>
																<td>N/A</td>
																<?php } ?>
														</tr>
														<tr>
															<th>Depreciation</th>
															<?php if(!empty($items[0]->depreciation)) { ?>
															<td><?php echo "<span id='dep'>".$items[0]->depreciation .'</span>'. "(%)"; ?></td>
															<?php } else {?>
																<td>N/A</td>
																<?php } ?>
															<th>Current Value</th> 
															<td><span id="current">
															<?php $percent = $items[0]->price * $items[0]->depreciation / 100;
															echo $current = $items[0]->price - $percent;
															?>
															</span></td>
														</tr>
														<tr>
															<?php if(!empty($current_item)) { ?>
															<th>Department</th>
															<td><?= $items[0]->department; ?></td>
														</tr>
														<?php } ?>
														<tr>
															<?php if(!empty($current_item)) { ?>
															<th>Contact </th>
															<td><?= $current_item[0]->phone; ?></td> 
														</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<?php else : ?>
									<p class="subtitle has-text-centered is-hidden">AH Group of Companies (Pvt.) Ltd.
										Islamabad, 44000</p>
									<p class="subtitle has-text-centered"><strong>Category</strong> &raquo;
										<?php if(!empty($item->cat_name)){ ?>
										<?= $item->cat_name; ?></p>
									<?php } ?>
									<div class="card-content">
										<div class="columns">
<div class="column">
<table class="table table-striped table-sm">
													<tbody>
														<tr>
															<th>Product</th>
															<?php if(!empty($item->name)) { ?>
															<td><?= $item->names; ?></td>
															<?php } else{ ?>
																<td>N/A</td>
																<?php } ?>
															<th>Employee</th>
															<?php if(!empty($item->emp_name)) { ?>
															<td><?= $item->emp_name; ?></td>
															<?php }else { ?>
																<td>N/A</td>
																<?php } ?>
														</tr>
														<tr>
															<th>Serial/IMEI</th>
															<?php if(!empty($item->serial_number)) { ?>
															<td><?= $item->serial_number; ?></td>
															<?php } else { ?>
																<td>N/A</td>
																<?php } ?>
															<th>Model</th>
															<?php if(!empty($item->model)) { ?>
															<td><?= $item->model; ?></td>
															<?php } else {?>
																<td>N/A</td>
																<?php } ?>
														</tr>
														<tr>
															<th>Purchase Date</th>
															<?php if(!empty($item->purchasedate)) { ?>
															<td><?= date('M d, Y', strtotime($item->purchasedate)); ?></td>
															<?php } else {?>
																<td>N/A</td>
																<?php } ?>
															<th>Price</th>  
															<?php if(!empty($item->price)){ ?>
															<td><?php echo "<spanp idy='price'>". $item->price.'</span>';?></td>
															<?php } else {?>
																<td>N/A</td>
																<?php } ?>
														</tr>
														<tr>
															<th>Depreciation</th>
															<td>
															<?php echo "<span id='dep'>".$item->depreciation .'</span>'. "(%)"; ?>
															<?php	error_reporting(0);
															if($item->depreciation > 0){ 
															$depreciation = ($item->price*$item->depreciation / 100) ;  
															echo $item->price - $depreciation;
															}
															?>
															</td>
															<th>Current Value</th>
															<td><span id="current"></span></td>
														</tr>
														<tr>
															<th>Department</th>
															<td>
															<?php echo $item->department; ?> 
															</td> 
														</tr>
														<tr>
															<th>Contact</th>
															<td><?= $item->phone; ?></td>
														</tr>
														<tr>
															<?php if(!empty($current_item)) { ?>
															<th>Department</th>
															<td><?= $item->department; ?></td>
															<th>Date of Joininig</th>
															<td><?= date('M d, Y', strtotime($current_item[0]->doj)); ?><td>
														</tr>
														<?php } ?>
														<tr>
															<?php if(!empty($current_item)) { ?>
															<th>Contact</th>
															<td><?= $current_item[0]->phone; ?></td>
															<th>Employee</th>
															<td><?= $current_item[0]->emp_name; ?></td>
														</tr>
														<?php } ?>
													</tbody>
												</table>
</div>
										</div>
										<span style='color: red;font-weight: bold'>This item still not assigned to an
											emplyee </span>
										<?php endif; ?>
										<div class="columns">
											<div class="column">
												<?php if(!empty($items)): ?>

												<table class="table is-fullwidth">
													<thead>
														<tr>
															<th>Emp Code</th>
															<th>Name</th>
															<th>Joining Date</th>
															<th>Assign Date</th>
															<th>Reason</th>
															<th>Return Date</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<?php $id = 1; ?>
															<?php if(!empty($items)): foreach($items as $item): ?>
														<tr>
															<!-- below some php code writen for available data which is not assign to someone -->
															<?php if(empty($item->assign_date)){?><div
																class="col-sm-12 text-center"> <strong>Availabe Still
																	Not Assignd</strong> </div>
															<?php 
															}
															else{
															?>
															<?php $returned_date = $item->return_back_date;
            $returned_date = ($returned_date) ? date('M d, Y', strtotime($item->return_back_date)) : ' Still In custody';?>
															<td> <?php echo '<span >S2S - '.ucfirst($item->user_id.'</span>')?></td>
															<td> <a data-id="<?= $item->asignment_id; ?>"class="emp_detail">
																	<?php echo '<span >'.ucfirst($item->emp_name.'</span>')?></a>
															</td>
															<?php if(isset($item->doj)){ ?>
															<td><?= date('M d, Y', strtotime($item->doj)) ?></td>
															<?php } else {?>
															<td>N/A</td>
															<?php } ?>
															<td><?php if(!empty($item->assign_date))
            {echo date('M d, Y', strtotime($item->assign_date)).'</date>';} 
            else{
            echo "<span'> - - - - - </span>";} ?>
															</td>
															<td>
																<?php if(!empty($item->return_back_date))
            {echo ' '.$item->returning_description;} 
            else{
            echo "<span style='font-weight:bold'>   - - - - - - </span>";} ?>
															</td>
															<td> <?php if(!empty($item->return_back_date))
            {echo date('M d, Y', strtotime($item->return_back_date));} 
            else{
            echo "<span style='font-weight:bold'> Still In custody </span>";} ?>
															</td>
															<?php } ?>
														</tr>
														<?php endforeach;  ?>
													</tbody>
												</table>
												<?php endif;  ?>
												<?php 
 endif;
?>
											</div>
										</div>

										<div class="buttons is-pulled-right">
											<button onclick="window.print();" type="button"
												class="button is-normal is-hidden-print">
												<span class="icon is-small">
													<i class="fas fa-print"></i>
												</span>
												<span>Print</span>
											</button>
										</div>
										<br>

									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
</section>

<!-- Modal to show employe detail -->
<div class="modal" id="emp_detail">
	<div class="modal-background"></div>
	<form action="<?=base_url('Purchase/po_supplier_order');?>" method="post" class="md-form">
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Employee Detail</p>
				<button class="delete" aria-label="close" id="exit-supplier-modal" type="button"></button>
			</header>
			<input type="hidden" name="assignment_id" id="assignment_id" value="">
			<section class="modal-card-body">
				<div class="columns">
					<div class="column">
						<p>Name :</p>
						<p>Department :</p>
						<p>Product</p>
						<p>Assigned Date :</p>
						<p>Remarks :</p>
						<p>Description :</p>
						<p>Return Date :</p>
					</div>
					<div class="column">
						<p id="emp_name"></p>
						<p id="department"></p>
						<p id="product"></p>
						<p id="assigned_date"></p>
						<p id="remarks"></p>
						<p id="returning_description"></p>
						<p id="return_back_date"></p>
					</div>
					<div class="column ">
						<img src="" alt="" id="item_image">
					</div>
				</div>
			</section>
			<footer class="modal-card-foot">
				<button class="button" aria-label="close" id="close-supplier-modal" type="button">Cancel</button>
			</footer>
		</div>
	</form>
</div>

<script>
	// code to show current value of product	
	$(document).ready(function () { 
		var price = document.getElementById("price").innerHTML;
		var prices = price.replace(/&nbsp;/, '');
		var dep = document.getElementById("dep").innerHTML;
		currentval = prices * dep / 100;
		alert(currentval)
		var output = document.getElementById("current").innerHTML = currentval;
	});


	// show assignment item employee detail 
	var sup1 = $("#exit-supplier-modal")
	var sup2 = $("#close-supplier-modal")
	var supmdl = new BulmaModal("#emp_detail")
	sup1.click(function (ev) {
		supmdl.close();
		ev.stopPropagation();
	});
	sup2.click(function (ev) {
		supmdl.close();
		ev.stopPropagation();
	});

	$(document).ready(function () {
		$('.emp_detail').click(function () {
			var emp_id = $(this).data('id');
			// AJAX request 
			document.getElementById('emp_name').value = '';
			$.ajax({
				url: '<?= base_url('admin/assigned_item_emp/'); ?>' + emp_id,
				method: 'POST',
				dataType: 'JSON',
				data: {
					emp_id: emp_id
				},
				success: function (response) {
					console.log(response);
					// Add options   
					document.getElementById("emp_name").innerHTML = response.fullname;
					document.getElementById("department").innerHTML = response.department;
					if(document.getElementById("product").innerHTML = response.sub_name == null){
						document.getElementById("product").innerHTML = 'N/A';
					}else{
						document.getElementById("product").innerHTML = response.sub_name;
					}
					if(document.getElementById("assigned_date").innerHTML = response
					.assigned_date == null){
						document.getElementById("product").innerHTML = 'N/A';
					}else{	
					document.getElementById("assigned_date").innerHTML = response
					.assigned_date;
					}
					if(document.getElementById("remarks").innerHTML = response.remarks == null){
						document.getElementById("remarks").innerHTML = 'N/A';
					}else{
						document.getElementById("remarks").innerHTML = response.remarks;
					} 
					document.getElementById("returning_description").innerHTML = response
						.returning_description;
					// document.getElementById("return_back_date").innerHTML = response.return_back_date;
					document.getElementById("item_image").innerHTML = "";
					$("#item_image").attr({
						src: "<?= base_url('upload/')?>" + response.item_file
					});
					// Display Modal
					supmdl.show();
				}
			});
			event.stopPropagation();
		});
	});

</script>
