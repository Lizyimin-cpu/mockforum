<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * from system_settings limit 1");
if ($qry->num_rows > 0) {
	foreach ($qry->fetch_array() as $k => $val) {
		$meta[$k] = $val;
	}
}
?>
<div class="container-fluid">
	<style>
		img#cimg {
			max-height: 10vh;
			max-width: 6vw;
		}
	</style>
	<div class="card col-lg-12">
		<div class="card-body">
			<form action="" id="manage-settings">
				<div class="form-group">
					<label for="name" class="control-label">System Name</label>
					<input type="text" class="form-control" id="name" name="name" value="<?php echo isset($meta['name']) ? $meta['name'] : '' ?>" required>
				</div>
				<div class="form-group">
					<label for="email" class="control-label">Email</label>
					<input type="email" class="form-control" id="email" name="email" value="<?php echo isset($meta['email']) ? $meta['email'] : '' ?>" required>
				</div>
				<div class="form-group">
					<label for="contact" class="control-label">Contact</label>
					<input type="text" class="form-control" id="contact" name="contact" value="<?php echo isset($meta['contact']) ? $meta['contact'] : '' ?>" required>
				</div>
				<div class="form-group">
					<label for="about" class="control-label">About Content</label>
					<textarea name="about" class="text-jqte"><?php echo isset($meta['about']) ? $meta['about'] : '' ?></textarea>
				</div>
				<div class="form-group">
					<label for="copyright" class="control-label">Copyright</label>
					<textarea class="form-control" cols="5" rows="5" name="copyright"><?php echo isset($meta['copyright']) ? htmlspecialchars($meta['copyright']) : '' ?></textarea>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Logo</label>
					<input type="file" name="image" id="imgUpload">
					<img src="<?php echo isset($meta['img']) ? $meta['img'] : '' ?>" alt="" id="imgPath" width="120">
					<input class="form-control" type="hidden" name="imagePath" value="<?php echo isset($meta['img']) ? $meta['img'] : '' ?>">
				</div>

				<center>
					<button class="btn btn-info btn-primary btn-block col-md-2">Save</button>
				</center>
			</form>
		</div>
	</div>


	<script>
		$('.text-jqte').jqte();

		$('#manage-settings').submit(function(e) {
			e.preventDefault()
			start_load()
			$.ajax({
				url: 'ajax.php?action=save_settings',
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				error: err => {
					console.log(err)
				},
				success: function(resp) {
					if (resp == 1) {
						alert_toast('Save successful', 'success')
						setTimeout(function() {
							location.reload()
						}, 1000)
					} else if (resp == 2) {
						alert_toast('Please fill in complete system information', 'danger')
						setTimeout(function() {
							location.reload()
						}, 1000)
					} else if (resp == 3) {
						alert_toast('Please upload a logo', 'danger')
						setTimeout(function() {
							location.reload()
						}, 1000)
					}
				}
			})

		})


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
						alert_toast('Logo upload successful', 'success')
						$("#imgPath").attr("src", res.data.file);
						$("[name='imagePath']").val(res.data.file);
					} else {
						alert_toast("Error")
						setTimeout(function() {
							location.reload()
						}, 1500)
					}
				}
			})
		})
	</script>
	<style>

	</style>
</div>
