<section class="columns is-gapless mb-0 pb-0">
	<div class="column is-narrow is-fullheight" id="custom-sidebar">
		<?php $this->view('admin/commons/sidebar'); ?>
	</div>
	<div class="column">
		<div class="columns">
			<div class="column section py-5">
				<div class="columns">
					<div class="column">
						<?php $this->view('admin/commons/breadcrumb'); ?>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<form action="<?= base_url('admin/search_invoices'); ?>" method="get">
							<div class="field has-addons">
								<div class="control has-icons-left is-expanded">
									<input class="input is-small is-fullwidth" name="search" type="search"
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
								<div class="ml-1 control">
									<a href="<?= base_url('report/invoice_report') ?>" class="button is-small">
										<span class="icon is-small">
											<i class="fas fa-sort-alpha-down"></i>
										</span>
										<span>Filter</span>
									</a>
								</div>
							</div>
						</form>
					</div>
					<div class="column is-hidden-touch is-narrow">
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
									class="button is-small <?= isset($add_invoice) ? 'has-background-primary-light' : '' ?>">
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

				<form
					action="<?php if(empty($edit)){ echo base_url('admin/save_invoice'); }else{ echo base_url('admin/update_invoice'); } ?>"
					method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $this->uri->segment(3); ?>">
					<div class="columns">
						<div class="column">
							<fieldset>
								<div class="field">
									<label class="label is-small">Invoice Number <span
											class="has-text-danger">*</span></label>
									<div class="control has-icons-left">
										<input type="number" name="inv_no" id="" class="input is-small"
											value="<?php if(!empty($edit)){ echo $edit->inv_no; } ?>" type="text"
											placeholder="Invoice number ..." required="">
										<span class="icon is-small is-left">
											<i class="fas fa-file-invoice"></i>
										</span>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="column">
							<div class="control">
								<label class="label is-small">Suppliers <span class="has-text-danger">*</span></label>
								<div class="control has-icons-left">
									<span class="select is-small is-fullwidth">
										<select name="supplier" id="supplier" required>
											<option selected disabled value="">Select a Supplier</option>
											<?php if(!empty($suppliers)): foreach($suppliers as $supplier): ?>
											<option value="<?= $supplier->id; ?>"
												<?= !empty($edit) && $edit->supplier == $supplier->id ? 'selected' : '' ?>>
												<?= ucwords($supplier->sup_name); ?>
											</option>
											<?php endforeach; endif; ?>
										</select>
									</span>
								</div>
							</div>
						</div>

					</div>
					<div class="columns">

						<div class="column">
							<label class="label is-small">Location <span class="has-text-danger">*</span></label>
							<div class="control has-icons-left">
								<span class="select select is-small is-fullwidth">
								<select name="region" required id="location">
											<option selected disabled value="">Select a Location</option>
											<?php if(!empty($locations)): foreach($locations as $loc): ?>
											<option value="<?= $loc->id; ?>"
												<?= !empty($edit) && $edit->region == $loc->id ? 'selected' : '' ?>>
												<?= $loc->name; ?>
											</option>
											<?php endforeach; endif; ?>
										</select>

									<span class="icon is-small is-left">
										<i class="fas fa-globe"></i>
									</span>
								</span>
							</div>
						</div>
						<div class="column">
							<label class="label is-small">Project <span class="has-text-danger">*</span></label>
							<div class="control has-icons-left">
								<span class="select is-small is-fullwidth"> 
									<select name="project" required>
											<option selected disabled value="">Select a Project</option>
											<?php if(!empty($projects)): foreach($projects as $proj): ?>
											<option value="<?= $proj->id; ?>"
												<?= !empty($edit) && $edit->project == $proj->id ? 'selected' : '' ?>>
												<?= $proj->project_name; ?>
											</option>
											<?php endforeach; endif; ?>
										</select>
								</span>
								<span class="icon is-small is-left">
									<i class="fa fa-tasks" aria-hidden="true"></i>
								</span>
							</div>
						</div>
					</div>
					<div class="columns">

						<div class="column">
							<fieldset>
								<div class="field">
									<label class="label is-small">Item <span class="has-text-danger">*</span></label>
									<div class="control has-icons-left">
										<input type="text" name="item_name" id="" class="input is-small"
											value="<?php if(!empty($edit)){ echo $edit->item; } ?>" type="text"
											placeholder="Item name ..." required="">
										<span class="icon is-small is-left">
											<i class="fas fa-list"></i>
										</span>
									</div>
								</div>
							</fieldset>
						</div>

						<div class="column">
							<label class="label is-small">File </label>
							<div class="file is-small has-name is-fullwidth">
								<label class="file-label">
									<input class="file-input" name="userfile" type="file">
									<span class="file-cta">
										<span class="file-icon">
											<i class="fas fa-upload"></i>
										</span>
										<span class="file-label">
											Choose a file…
										</span>
									</span>
									<span class="file-name">
										Example.png
									</span>
								</label>
							</div>
						</div>

					</div>

					<div class="columns">

						<div class="column">
							<fieldset>
								<div class="field">
									<label class="label is-small">Amount <span class="has-text-danger">*</span></label>
									<div class="control has-icons-left">
										<input type="number" name="amount" id="" class="input is-small"
											value="<?php if(!empty($edit)){ echo $edit->amount; } ?>"
											placeholder="1-9,999,999" required="">
										<span class="icon is-small is-left">
											<i class="far fa-money-bill-alt"></i>
										</span>
									</div>
								</div>
							</fieldset>
						</div>

						<div class="column">
							<fieldset>
								<div class="field">
									<label class="label is-small">Date <span class="has-text-danger">*</span></label>
									<div class="control has-icons-left">
										<input type="date" name="inv_date" id="" class="input is-small"
											value="<?php if(!empty($edit)){ echo $edit->inv_date; } ?>" required="">
										<span class="icon is-small is-left">
											<i class="far fa-calendar-alt"></i>
										</span>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
					<div class="columns">
						<div class="column is-6">
							<fieldset>
								<div class="field">
									<label class="label is-small">Description</label>
									<div class="control has-icons-left">
										<textarea class="textarea is-small" name="inv_desc" rows="1"
											placeholder="some detail"><?php if(!empty($edit)){ echo $edit->inv_desc; } ?></textarea>
									</div>
								</div>
							</fieldset>
						</div>
					</div>

					<div class="columns">
						<div class="column has-text-right">
							<div class="buttons is-pulled-right">
								<?php if(!isset($edit_item)): ?>
								<button class="button is-danger is-small is-outlined" type="reset">Reset Form</button>
								<?php endif ?>
								<p class="control">
									<button class="button is-small is-success" type="submit"
										<?= isset($edit) && $AssetsAccess->update == 0 || $AssetsAccess->write == 0 ? 'disabled' : '' ?>>
										<span><?= !isset($edit_item) ? 'Save and continue' : 'Save Changes' ?></span>
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
	$("#supplier").select2();
</script>
