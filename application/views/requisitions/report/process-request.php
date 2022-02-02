<section class="columns is-gapless mb-0 pb-0">
	<div class="column is-narrow is-fullheight" id="custom-sidebar">
		<?php $this->view('requisitions/commons/sidebar'); ?>
	</div>
	<div class="column">
		<div class="columns">
			<div class="column section py-5">
				<div class="columns">
					<div class="column">
						<?php $this->view('requisitions/commons/breadcrumb'); ?>
					</div>
				</div>
				<div class="columns">
					<div class="column is-hidden-print">
						<form action="<?= base_url('requisitions/search_request'); ?>" method="get">
							<div class="field has-addons">
								<div class="control has-icons-left is-expanded">
									<input class="input is-small is-fullwidth" name="search" id="myInput" type="search"
										placeholder="Search Request"
										value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" >
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
					<div class="column is-hidden-touch is-narrow">
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
							<p class="control">
								<a href="<?= base_url("Requisition_report/reject_request_report") ?>"
									class="button is-small <?= (isset($reject_request_report)) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-list"></i>
									</span>
									<span>Reject</span>
								</a>
							</p>
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
                <form action="<?php echo base_url('Requisition_report/filter_process_request'); ?>" method="get"> 
					<input type="hidden" value="<?php echo $this->uri->segment(3); ?>">
					<div class="columns"> 
						<div class="column">
							<div class="control has-icons-left">
								<label class="label is-small">Location </label>
								<div class="select is-small is-fullwidth">
									<select name="city" id="city">
										<option value="" selected>Select a City</option>
										<?php foreach ($locations as $data) : ?>
										<option value="<?= $data->id ?>">
											<?= ucwords($data->name); ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
						</div>
                        <div class="column">
							<div class="control has-icons-left">
								<label class="label is-small">Company</label>
								<div class="select is-small is-fullwidth">
									<select name="company">
										<option selected value="">Select a Company</option>
										<?php foreach ($companies as $data) : ?>
										<option value="<?= $data->id ?>">
											<?= ucwords($data->name); ?></option>
										<?php endforeach ?>
									</select>
									 
								</div>
							</div>
						</div> 
                        
					</div>

					<div class="columns">

                    <div class="column">
							<div class="control has-icons-left">
								<label class="label is-small">Department</label>
								<div class="select is-small is-fullwidth">
									<select name="department">
										<option selected value="">Select a Department</option>
										<?php foreach ($departments as $data) : ?>
										<option value="<?= $data->id ?>">
											<?= ucwords($data->department); ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
						</div>

                    <div class="column">
							<div class="control">
								<label class="label is-small">Name</label>
								<div class="control has-icons-left">
									<span class="select is-small is-fullwidth">
										<select name="name" id="employee">
											<option selected disabled value="">Select a Employee</option> 
										</select>
									</span>
								</div>
							</div>
						</div>

					</div>
 
					<div class="columns">
						<div class="column">
							<div class="columns"> 
								<div class="column">
									<fieldset>
										<div class="field">
											<label for="" class="label is-small">Particular</label>
											<div class="control has-icons-left">
												<input type="text" name="item" class="input is-small"
													placeholder="Particular"> <span
													class="icon is-small is-left">
													<i class="fas fa-quote-left"></i>
												</span>
											</div>
										</div>
									</fieldset>
								</div> 
								<div class="column">
									<fieldset>
										<div class="field">
											<label for="" class="label is-small">Model</label>
											<div class="control has-icons-left">
												<input type="text" name="model" class="input is-small"
													placeholder="e.g laptop core i5 6th Gen">
												<span class="icon is-small is-left">
													<i class="fas fa-asterisk"></i>
												</span>
											</div>
										</div>
									</fieldset>
								</div>
							</div>
						</div>
					</div>

					<div class="columns">
						<div class="column">
							<div class="columns">  
								<div class="column">
									<fieldset>
										<div class="field">
										<label for="" class="label is-small">Quantity</label>
											</label>
											<div class="control has-icons-left">
											<input type="number" name="quantity" class="input is-small" placeholder="Quantity"
										min="1" max="10">
												<span class="icon is-small is-left">
													<i class="fas fa-sort-numeric-up"></i>
												</span>
											</div>
										</div>
									</fieldset>
								</div> 
								<div class="column"></div>

							</div>
						</div>
					</div> 
					<div class="columns">
						<div class="column has-text-right">
							<div class="buttons is-pulled-right">
								<?php if(!isset($edit_item)): ?>
								<button class="button is-danger is-small is-outlined" type="reset">Reset Form</button>
								<?php endif ?>
								<p class="control">
									<button class="button is-small is-success" type="submit">
										<span><?= 'Filter'?></span>
										<span class="icon is-small">
											<i class="fas fa-arrow-right"></i>
										</span>
									</button>
								</p>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<script>
  $("#employee").select2();

// code to load employee against location
$(document).ready(function(){ 
 $('#city').on('change', function(){
   var city = $(this).val();
   // AJAX request
   $.ajax({
     url:'<?=base_url('Requisition_report/city_user/')?>' + city,
     method: 'post',
     data: {city: city},
     dataType: 'json',
     success: function(response){
      console.log(response); 
      $('#employee').find('option').not(':first').remove(); 
        $.each(response, function(index, data){
            $('#employee').append('<option value="'+data['id']+'">'+data['fullname']+'</option>');
        }); 
     }
  }); 
});
});
</script>