<?php $session = $this->session->userdata('user_role'); ?>
<section class="columns is-gapless mb-0 pb-0">
	<div class="column is-narrow is-fullheight is-hidden-print" id="custom-sidebar">
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

				<div class="columns is-hidden-touch">
                    <div class="column"></div>
					<div class="column is-hidden-print is-narrow">
						<div class="field has-addons">
							<p class="control">
								<a href="<?= base_url("admin/acl_component/") ?>"
									class="button is-small <?= (isset($acl_component)) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-list"></i>
									</span>
									<span>Add Component</span>
								</a>
							</p>
						</div>
					</div>
					<div class="column is-hidden-print is-narrow">
						<div class="field has-addons">
							<p class="control">
								<a href="<?= base_url("admin/acl/") ?>"
									class="button is-small <?= (isset($acl_page)) ? 'has-background-primary-light' : '' ?>">
									<span class="icon is-small">
										<i class="fas fa-list"></i>
									</span>
									<span>Access Control List</span>
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

                <form method="POST" action="<?= base_url('admin/update_access_list') ?>">
                    <div class="columns">
                        <div class="column">
                            <div class="card">
                                <header class="card-header">
                                    <p class="card-header-title">
                                        Assets <span class="ml-2 has-text-weight-light">(Global Access)</span>
                                    </p>
                                    <button class="card-header-icon" aria-label="more options">
                                        <span class="icon">
                                            <i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </span>
                                    </button>
                                </header>
                                <div class="card-content">
                                    <div class="content">
                                        <div class="columns">
                                            <div class="column">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Read</th>
                                                            <th>Write</th>
                                                            <th>Update</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($assets_access_list as $key => $data) : ?>
                                                        <tr>
                                                            <th><?= $data->title ?></th>
                                                            <td><input type="checkbox"
                                                                    name="read[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->read == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                        <td><input type="checkbox"
                                                                name="write[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->write == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="update[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->update == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="delete[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->delete == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                        </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="card">
                                <header class="card-header">
                                    <p class="card-header-title">
                                        Suppliers <span class="ml-2 has-text-weight-light">(Global Access)</span>
                                    </p>
                                    <button class="card-header-icon" aria-label="more options">
                                        <span class="icon">
                                            <i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </span>
                                    </button>
                                </header>
                                <div class="card-content">
                                    <div class="content">
                                        <div class="columns">
                                            <div class="column">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Read</th>
                                                            <th>Write</th>
                                                            <th>Update</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($suppliers_access_list as $key => $data) : ?>
                                                        <tr>
                                                            <th><?= $data->title ?></th>
                                                            <td><input type="checkbox"
                                                                    name="read[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->read == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="write[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->write == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="update[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->update == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="delete[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->delete == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                        </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="card">
                                <header class="card-header">
                                    <p class="card-header-title">
                                        Employees <span class="ml-2 has-text-weight-light">(Global Access)</span>
                                    </p>
                                    <button class="card-header-icon" aria-label="more options">
                                        <span class="icon">
                                            <i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </span>
                                    </button>
                                </header>
                                <div class="card-content">
                                    <div class="content">
                                        <div class="columns">
                                            <div class="column">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Read</th>
                                                            <th>Write</th>
                                                            <th>Update</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($employees_access_list as $key => $data) : ?>
                                                        <tr>
                                                            <th><?= $data->title ?></th>
                                                            <td><input type="checkbox"
                                                                    name="read[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->read == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="write[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->write == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="update[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->update == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="delete[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->delete == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                        </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="card">
                                <header class="card-header">
                                    <p class="card-header-title">
                                        Categories <span class="ml-2 has-text-weight-light">(Global Access)</span>
                                    </p>
                                    <button class="card-header-icon" aria-label="more options">
                                        <span class="icon">
                                            <i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </span>
                                    </button>
                                </header>
                                <div class="card-content">
                                    <div class="content">
                                        <div class="columns">
                                            <div class="column">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Read</th>
                                                            <th>Write</th>
                                                            <th>Update</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($categories_access_list as $key => $data) : ?>
                                                        <tr>
                                                            <th><?= $data->title ?></th>
                                                            <td><input type="checkbox"
                                                                    name="read[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->read == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="write[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->write == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="update[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->update == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="delete[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->delete == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                        </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="card">
                                <header class="card-header">
                                    <p class="card-header-title">
                                        Register <span class="ml-2 has-text-weight-light">(Global Access)</span>
                                    </p>
                                    <button class="card-header-icon" aria-label="more options">
                                        <span class="icon">
                                            <i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </span>
                                    </button>
                                </header>
                                <div class="card-content">
                                    <div class="content">
                                        <div class="columns">
                                            <div class="column">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Read</th>
                                                            <th>Write</th>
                                                            <th>Update</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($register_access_list as $key => $data) : ?>
                                                        <tr>
                                                            <th><?= $data->title ?></th>
                                                            <td><input type="checkbox"
                                                                    name="read[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->read == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="write[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->write == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="update[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->update == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                            <td><input type="checkbox"
                                                                    name="delete[<?= $data->component ?>][<?= $key + 1 ?>]"
                                                                    <?= $data->delete == 1 ? 'checked' : '' ?>
                                                                    value="1"></td>
                                                        </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
</section>

<script>
	$.fn.toggleCheck = function () {
		$(this).prop('checked', !($(this).is(':checked')));
	}

	$(document).ready(function () {

		$("form").submit(function (e) {

			e.preventDefault(); // avoid to execute the actual submit of the form.

			var form = $(this);
			var url = form.attr('action');

			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				success: function (data) {}
			});

		});

		$("td").click(function () {

			$(this).find(':checkbox').toggleCheck();

			$(this).parent().submit();

		});

        $(".card-header-icon").click(function() {
            $(this).toggleClass('rotate-90');
            $(this).parent().parent().find(".card-content").slideToggle();
        })
	})

</script>

<style>
    .card-header-icon {
        transition:all 0.5s;
    }
    .card-content {
        display: none;
    }
    .rotate-90 {
        transform: rotate(180deg);
    }
</style>