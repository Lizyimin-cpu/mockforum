<?php include('db_connect.php'); ?>

<div class="container-fluid">

	<div class="col-lg-12">
		<div class="row">

			<div class="col-md-4">
				<form action="" id="manage-category">
					<div class="card">
						<div class="card-header">
							Category Information
						</div>
						<input type="hidden" name="id">
						<div class="card-body">

							<div class="form-group">
								<label class="control-label">Name</label>
								<input type="text" class="form-control" name="name">
							</div>
						</div>
						<div class="card-body">

							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea class="form-control" name="description" cols="30" rows="10"></textarea>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="file" class="control-label">Upload</label>
								<input type="file" name="image" id="imgUpload">
								<img src="" alt="" id="imgPath" width="75">
								<input type="hidden" name="imagePath" value="">
							</div>
						</div>

						<div class="card-footer">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-sm btn-primary col-sm-3 offset-md-3">Save</button>
									<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-category').get(0).reset()">Cancel</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Category List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<colgroup>
								<col width="5%">
								<col width="75%">
								<col width="20%">
							</colgroup>
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Information</th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								if ($_SESSION['login_id'] != '1') {
									$category = $conn->query("SELECT * FROM categories where user_id = " . $_SESSION['login_id'] . " order by name asc");
								} else {
									$category = $conn->query("SELECT * FROM categories order by name asc");
								}

								while ($row = $category->fetch_assoc()) :
								?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td class="">
											<p>Name: <b><?php echo $row['name'] ?></b></p>
											<p>Description:</p>
											<p class="truncate"><?php echo $row['description'] ?></p>
											<p><img src="<?php echo $row['image'] ?>" alt="" width="75"></p>
											<p> <?php echo $_SESSION['login_id'] == '1' ? 'Creator ID:' . $row['user_id'] : ''; ?></p>
										</td>
										<td class="text-center">
											<button class="btn btn-sm btn-primary edit_category" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-description="<?php echo $row['description'] ?>" data-image="<?php echo $row['image'] ?>">Edit</button>
											<button class="btn btn-sm btn-danger delete_category" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>

</div>
<style>
	td {
		vertical-align: middle !important;
	}
</style>
<script>
	$('#manage-category').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'ajax.php?action=save_category',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Modification successful", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				} else if (resp == 2) {
					alert_toast("Addition successful", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				} else if (resp == 3) {
					alert_toast("Category name and content cannot be empty", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				} else if (resp == 4) {
					alert_toast("Please upload category image", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				} else if (resp == 5) {
					alert_toast("You did not create this category", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	})
	$('.edit_category').click(function() {
		start_load()
		var cat = $('#manage-category')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		cat.find("#imgPath").attr("src", $(this).attr('data-image'));
		cat.find("[name='imagePath']").val($(this).attr('data-image'));
		end_load()
	})
	$('.delete_category').click(function() {
		_conf("Are you sure you want to delete this category?", "delete_category", [$(this).attr('data-id')])
	})

	function delete_category($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_category',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Deletion successful", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
	$('table').dataTable()
	$('#imgUpload').change(function() {
		var imgObj = this.files[0];
		if (!/^image/.test(imgObj.type)) {
			alert("Incorrect image format");
			return;
		}
		if (imgObj.size > 52428800) {
			alert("File is too large");
			return;
		}
		var formData = new FormData();
		formData.append('file', imgObj);
		$.ajax({
			url: 'ajax.php?action=upload',
			data: formData,
			dataType: "json",
			async: false,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			success: function(res) {
				if (res.code == 1) {
					$("#imgPath").attr("src", res.data.file);
					$("[name='imagePath']").val(res.data.file);
				} else {
					alert_toast("error")
					setTimeout(function() {
						location.reload()
					}, 1500)
				}
			}
		})
	})
</script>
