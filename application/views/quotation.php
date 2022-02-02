<style>
	.print:focus {
		outline: none;
		border: none;
		box-shadow: none;
	}

</style>

<div class="container ">
	<div class="columns is-centered ">

		<div class="column is-three-quarters ">
			<img src="https://s2smark.com/assets/img/logo/s2s-logo-1.png" class="logo">
			<!-- <img src="<?= base_url('assets/img/logo/s2s-logo-1.png')?>" class="logo"> -->
			<br><br><br>
			<?php   
                  $email_id = $this->uri->segment(3); 
                  $id = base64_decode($email_id);
                //  echo $id;
$quotations = $this->Requisition_Model->VendorQuotation($id);
 
            ?>


			<!-- //////////////// success modal //////////////////// -->
			<div class="modal" id="success_modal">
				<div class="modal-background"></div>
				<form action="https://mail.google.com/mail/u/0/#inbox" method="">
					<div class="modal-card">
						<input type="hidden" name="id" id="request_id" value="">
						<header class="modal-card-head">
							<p class="modal-card-title">Success</p>
							<button class="delete" aria-label="close" id="exit-success-modal" type="button"></button>
						</header>
						<section class="modal-card-body">
							<div class="columns">
								<div class="column">
									<?php if($this->session->flashdata('success')) : ?>
									<div class="columns">
										<div class="column">
											<div class="notification is-success is-light">
												<div class="columns is-vcentered">
													<div class="column is-size-14">
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
								</div>
							</div>
						</section>
						<footer class="modal-card-foot">
							<button class="button is-success" type="submit"> <span class="icon is-small">
									<i class="fas fa-check"></i></span> </button> </footer>
					</div>
				</form>
			</div>
			<!-- success message modal start-->
			<?php if(!empty($this->session->flashdata('success'))) : ?>
			<script>
				var md2 = new BulmaModal("#success_modal")
				var btn5 = $("#exit-success-modal")
				var btn6 = $("#close-success-modal")

				$(window).on('load', function () {
					md2.show();
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
			<?php endif ?>
			<!-- /////////////////// success modal end ////////////////// -->

			<?php if(!empty($quotations->qut_id)){ ?>
			<form action="<?= base_url('login/save_quotation')?>" method="POST">
				<input type="hidden" name="quot_id" value="<?php echo $id; ?>">
				<div class="columns">
					<div class="column">
						<fieldset>
							<div class="field">
								<label class="label is-small">Request From </label>
								<div class="control has-icons-left">
									<input type="text" class="input is-small" value="<?= $quotations->fullname; ?>"
										type="text" placeholder="e.g John Doe" required disabled>
									<span class="icon is-small is-left is-hidden-print">
										<i class="fas fa-user-tie"></i>
									</span>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="column">
						<fieldset>
							<div class="field">
								<label class="label is-small">Requested To</label>
								<div class="control has-icons-left">
									<input type="text" class="input is-small" value="<?= $quotations->sup_name; ?>"
										type="text" placeholder="e.g S2S-123" required disabled>
									<span class="icon is-small is-left is-hidden-print">
										<i class="fas fa-signature"></i>
									</span>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<fieldset>
							<div class="field">
								<label class="label is-small">Location</label>
								<div class="control has-icons-left">
									<input type="text" class="input is-small" value="<?= $quotations->loc_name; ?>"
										type="text" placeholder="e.g location" required disabled>
									<span class="icon is-small is-left is-hidden-print">
										<i class="fas fa-street-view"></i>
									</span>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="column">
						<div class="control">

							<fieldset>
								<div class="field">
									<label class="label is-small">Requisition Date </label>
									<div class="control has-icons-left">
										<input type="" class="input is-small"
											value="<?=  date('M d, Y', strtotime($quotations->date)); ?>" required
											disabled>
										<span class="icon is-small is-left is-hidden-print">
											<i class="fas fa-envelope"></i>
										</span>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
				<hr>
				<div class="columns">
					<div class="column">
						<div class="columns">
							<div class="column">
								<fieldset>
									<div class="field">
										<label class="label is-small">Item</label>
										<div class="control has-icons-left">
											<input type="text" class="input is-small"
												value="<?= $quotations->item_name; ?>" type="text" readonly>
											<span class="icon is-small is-left is-hidden-print">
												<i class="fas fa-luggage-cart"></i>
											</span>
										</div>
									</div>
								</fieldset>
							</div>
							<div class="column">
								<fieldset>
									<div class="field">
										<label class="label is-small">Requirement</label>
										<div class="control has-icons-left">
											<input type="text" class="input is-small" name="requirement"
												value="<?= $quotations->item_requirement; ?>"
												placeholder="e.g laptop core i5 6th Gen">
											<span class="icon is-small is-left is-hidden-print">
												<i class="fas fa-asterisk"></i>
											</span>
										</div>
									</div>
								</fieldset>
							</div>
						</div>

						<div class="columns">


							<div class="column">

								<fieldset>
									<div class="field">
										<label class="label is-small">Quantity</label>
										<div class="control has-icons-left">
											<input type="number" class="input is-small"
												value="<?= $quotations->quantity; ?>" type="text" readonly>
											<span class="icon is-small is-left is-hidden-print">
												<i class="fas fa-sort-numeric-up"></i>
											</span>
										</div>
									</div>
								</fieldset>
							</div>
							<div class="column">
								<fieldset>
									<div class="field">
										<label class="label is-small">Price</label>
										<div class="control has-icons-left">
											<input type="text" class="input is-small" name="price" required
												value="<?= $quotations->price; ?>" type="text" placeholder="30,000 e.g">
											<span class="icon is-small is-left is-hidden-print">
												<i class="fas fa-rupee-sign"></i>
											</span>
										</div>
									</div>
								</fieldset>
							</div>
						</div>

					</div>

				</div>
				<hr>
				<div class="columns">
					<div class="column">
						<fieldset>
							<div class="field">
								<label class="label is-small">Description (Quotation) </label>
								<div class="control">
									<textarea name="quotation" class="textarea is-small" rows="4" value=""
										placeholder="Quotation for product"><?= $quotations->description; ?></textarea>
								</div>
							</div>
						</fieldset>
					</div>
				</div>

				<div class="columns">
					<div class="column"></div>
					<div class="column">

						<div class="buttons is-pulled-right">
							<?php if(empty($quotations->price)){ ?>
							<button class="button is-danger is-small is-outlined is-hidden-print" type="reset">Reset Form</button>
							<p class="control is-hidden-print">
								<button class="button is-small is-success" type="submit">
									<span>Save and continue</span>
									<span class="icon is-small">
										<i class="fas fa-arrow-right"></i>
									</span>
								</button>
							</p>
							<?php } ?>
							<p class="control is-hidden-print">
								<button onClick="window.print();" type="button" class="button is-small print">
									<span class="icon is-small">
										<i class="fas fa-print"></i>
									</span>
									<span>Print</span>
								</button>
							</p>
						</div>

					</div>

				</div>

			</form>
			<?php } ?>
		</div>
	</div>

	<div class="columns is-centered">

		<div class="column is-half has-text-centered">

			<label class="has-text-grey">

				Department of Admin & Operations - S2S Marketing (Pvt.) Ltd. Islamabad, 44000.

			</label>

		</div>

	</div>

</div>
</section>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

<script>
	$("#login-form").submit(function (event) {
		$(".button").addClass('is-loading');
		var userPassword = document.getElementById('user-password').value;
		var passwordBytes = CryptoJS.enc.Utf8.parse(userPassword);
		var sha1Hash = CryptoJS.SHA1(passwordBytes);
		$("#user-password").val(sha1Hash);
	});

	$(".print").focus(function () {
		$("input").css("border", "none");
		$(".has-icons-left").css("float", "left");
		$(".has-icons-left").css("margin-right", "-100px");
		$(".icon is-small").css("display", "none");
		$("textarea").css("border", "none");
	});
// remove icon class 
	$(".print").focus(function () { 
		$(".icon is-small").css("display", "none");
		$("hr").css("display", "none");
		$( "div" ).removeClass( "has-icons-left" ).addClass( "has-icons-right" );
	}); 
</script>
