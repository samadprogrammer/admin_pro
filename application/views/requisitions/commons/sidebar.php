<div class="is-flex is-justify-content-center">
	<div class="mx-5 my-2">
		<img src="https://s2smark.com/assets/img/logo/s2s-logo-1.png" class="logo">
	</div>
</div>
<aside class="section py-4 is-narrow-mobile" id="categories">
	<p class="menu-label">
		General
	</p>
	<ul class="menu-list">
		<!-- <li><a class="<?= $this->uri->segment(2) == 'dashboard' ? 'is-primary is-inverted' : '' ?> nav-category"
				<?= $this->uri->segment(2) == 'dashboard' ? 'style="background-color:#f1f1f1;"' : '' ?>>Dashboard</a>
			<ul class="sub-categories"
				style="<?= $this->uri->segment(2) == 'dashboard' ? '' : 'display: none;' ?>">
			</ul>
		</li> -->
		<li><a class="<?= $this->uri->segment(2) == 'dashboard' ? 'is-primary is-inverted' : '' ?>"
				href="<?= base_url('requisitions/dashboard') ?>"
				<?= $this->uri->segment(2) == 'dashboard' ? 'style="background-color:#f1f1f1;"' : '' ?>>Dashboard</a>
		</li>
	</ul>
	<p class="menu-label">
		Requisition
	</p>
	<ul class="menu-list">
		<li><a class="<?= $this->uri->segment(2) == 'request_list' || $this->uri->segment(2) == 'add_request' || $this->uri->segment(2) == 'search_request' ? 'is-primary is-inverted' : '' ?> nav-category"
				<?= $this->uri->segment(2) == 'request_list' || $this->uri->segment(2) == 'add_request' || $this->uri->segment(2) == 'search_request' ? 'style="background-color:#f1f1f1;"' : '' ?>>Requests</a>
			<ul class="sub-categories"
				style="<?= $this->uri->segment(2) == 'request_list' || $this->uri->segment(2) == 'add_request' || $this->uri->segment(2) == 'search_request' ? '' : 'display: none;' ?>">
				<li
					class="is-size-7 <?= $this->uri->segment(2) == 'add_request' ? 'has-text-weight-bold' : '' ?>">
					<a href="<?= base_url('requisitions/add_request'); ?>"><i class="fas fa-plus mr-1"></i>
						Add Request</a></li>
				<li
					class="is-size-7 <?= $this->uri->segment(2) == 'request_list' || $this->uri->segment(2) == 'search_request' ? 'has-text-weight-bold' : '' ?>">
					<a href="<?= base_url('requisitions/request_list'); ?>"><i class="fas fa-list mr-1"></i>
						Request List</a></li>
				
			</ul>
		</li>
	</ul> 
	<?php if($this->session->userdata('user_role') == 1 || $this->session->userdata('user_role') == 3) {?>
	<ul class="menu-list">
		<li><a class="<?= $this->uri->segment(2) == 'approval_list' ? 'is-primary is-inverted' : '' ?> nav-category"
				<?= $this->uri->segment(2) == 'approval_list' ? 'style="background-color:#f1f1f1;"' : '' ?>>Approval</a>
			<ul class="sub-categories"
				style="<?= $this->uri->segment(2) == 'approval_list' ? '' : 'display: none;' ?>">
				<li
					class="is-size-7 <?= $this->uri->segment(2) == 'approval_list' ? 'has-text-weight-bold' : '' ?>">
					<a href="<?= base_url('requisitions/approval_list'); ?>"><i class="fas fa-list mr-1"></i>
						Approval List</a></li>

					<li class="is-size-7 <?= $this->uri->segment(2) == 'quotation_list' ? 'has-text-weight-bold' : '' ?>">
					<a href="<?= base_url('requisitions/quotation_list'); ?>"><i class="fa fa-question-circle mr-1" aria-hidden="true"></i>
						Qutotation</a></li>			
			</ul>
		</li>
	</ul>
<?php } ?>
	<ul class="menu-list">
		<li><a class="<?= $this->uri->segment(2) == 'user_asset_list' ? 'is-primary is-inverted' : '' ?> nav-category"
				<?= $this->uri->segment(2) == 'user_asset_list' ? 'style="background-color:#f1f1f1;"' : '' ?>>My Assets</a>
			<ul class="sub-categories"
				style="<?= $this->uri->segment(2) == 'user_asset_list' || $this->uri->segment(2) == 'Asset List' ? '' : 'display: none;' ?>">
				<li
					class="is-size-7 <?= $this->uri->segment(2) == 'user_asset_list' ? 'has-text-weight-bold' : '' ?>">
					<a href="<?= base_url('requisitions/user_asset_list'); ?>"><i class="fas fa-list mr-1"></i>
						Asset List</a></li>
			</ul>
		</li>
	</ul>
	<ul class="menu-list">
		<li><a class="<?= $this->uri->segment(2) == 'pending_request_report' || $this->uri->segment(2) == 'filter_request' || $this->uri->segment(2) == 'process_request_report' || $this->uri->segment(2) == 'filter_process_request' || $this->uri->segment(2) == 'approved_request_report'  || $this->uri->segment(2) == 'filter_approved_request' || $this->uri->segment(2) == 'reject_request_report' || $this->uri->segment(2) == 'filter_reject_request' ? 'is-primary is-inverted' : '' ?> nav-category"
				<?= $this->uri->segment(2) == 'pending_request_report' || $this->uri->segment(2) == 'filter_request' || $this->uri->segment(2) == 'pending_request_report' || $this->uri->segment(2) == 'process_request_report' || $this->uri->segment(2) == 'filter_process_request' || $this->uri->segment(2) == 'approved_request_report' || $this->uri->segment(2) == 'approved_request_report' || $this->uri->segment(2) == 'reject_request_report' || $this->uri->segment(2) == 'filter_reject_request' ? 'style="background-color:#f1f1f1;"' : '' ?>>Reports</a>
			<ul class="sub-categories"
				style="<?= $this->uri->segment(2) == 'pending_request_report' || $this->uri->segment(2) == 'filter_request' || $this->uri->segment(2) == 'process_request_report' || $this->uri->segment(2) == 'filter_process_request' || $this->uri->segment(2) == 'approved_request_report' || $this->uri->segment(2) == 'filter_approved_request' || $this->uri->segment(2) == 'reject_request_report' || $this->uri->segment(2) == 'filter_reject_request' ? '' : 'display: none;' ?>">
				<li class="is-size-7 <?= $this->uri->segment(2) == 'pending_request_report' || $this->uri->segment(2) == 'filter_request' ? 'has-text-weight-bold' : '' ?>">
					<a href="<?= base_url('Requisition_report/pending_request_report'); ?>"><i class="fas fa-list mr-1"></i>
						Pending</a></li>
				<li class="is-size-7 <?= $this->uri->segment(2) == 'process_request_report' || $this->uri->segment(2) == 'filter_process_request' ? 'has-text-weight-bold' : '' ?>">
					<a href="<?= base_url('Requisition_report/process_request_report'); ?>"><i class="fas fa-list mr-1"></i>
						Process</a></li>
				<li class="is-size-7 <?= $this->uri->segment(2) == 'approved_request_report' || $this->uri->segment(2) == 'filter_process_request' || $this->uri->segment(2) == 'filter_approved_request' ? 'has-text-weight-bold' : '' ?>">
					<a href="<?= base_url('Requisition_report/approved_request_report'); ?>"><i class="fas fa-list mr-1"></i>
						Approved</a></li>
				<li class="is-size-7 <?= $this->uri->segment(2) == 'reject_request_report' || $this->uri->segment(2) == 'filter_reject_request' ? 'has-text-weight-bold' : '' ?>">
					<a href="<?= base_url('Requisition_report/reject_request_report'); ?>"><i class="fas fa-list mr-1"></i>
						Reject</a></li>
			
					</ul>
		</li>
	</ul>


	<p class="menu-label">
		Control
	</p>
	<ul class="menu-list">
		<!-- <li><a href="<?= base_url('admin') ?>">Dashboard</a></li> -->
		<li><a href="<?= base_url('login/logout') ?>" data-no-instant>Logout</a></li>
	</ul>
	<!-- <ul class="menu-list">
			<li><a><b class="has-text-grey">Travel</b> Requests <span class="tag is-info is-light">2</span></a></li>
		</ul> -->
</aside>

<script>
$(document).ready(function(){
	$(".toggle").click(function(){ 
		$("aside").animate({
                width: "toggle"
            });
		// $("aside").slideToggle();
	}); 
}) 
</script>
