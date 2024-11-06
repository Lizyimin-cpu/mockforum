<?php
include('db_connect.php');
session_start();
if (isset($_GET['id'])) {
	$user = $conn->query("SELECT * FROM users where id =" . $_GET['id']);
	foreach ($user->fetch_array() as $k => $v) {
		$meta[$k] = $v;
	}
}
?>
<div class="container-fluid">
	<div id="msg"></div>

	<form action="" id="manage-user">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
		<div class="form-group">
			<label for="name">昵称</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name'] : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="username">用户名</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username'] : '' ?>" required autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">密码</label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			<?php if (isset($meta['id'])) : ?>
				<small><i>如果您不想更改密码，请将此项留空。</i></small>
			<?php endif; ?>
		</div>
		<div class="form-group">
			<label for="file" class="control-label">上传头像</label>
			<input type="file" name="avatar" id="imgUpload">
			<img src="<?php echo isset($meta['avatar']) ? $meta['avatar'] : '' ?>" alt="" id="imgPath" width="75">
			<input type="hidden" name="imagePath" value="<?php echo isset($meta['avatar']) ? $meta['avatar'] : '' ?>">
		</div>
		<?php if (isset($meta['type']) && $meta['type'] == 3) : ?>
			<input type="hidden" name="type" value="3">
		<?php else : ?>
			<?php if (!isset($_GET['mtype'])) : ?>
				<div class="form-group">
					<label for="type">用户类型</label>
					<select name="type" id="type" class="custom-select">
						<option value="3" <?php echo isset($meta['type']) && $meta['type'] == 3 ? 'selected' : '' ?>>学生</option>
						<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>其他</option>
						<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '' ?>>管理员</option>
					</select>
				</div>
			<?php endif; ?>
		<?php endif; ?>


	</form>
</div>
<script>
	$('#manage-user').submit(function(e) {
		e.preventDefault();
		start_load()
		$.ajax({
			url: 'ajax.php?action=save_user',
			method: 'POST',
			data: $(this).serialize(),
			success: function(resp) {
				if (resp == 1) {
					alert_toast("操作成功", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)
				} else if (resp == 2) {
					$('#msg').html('<div class="alert alert-danger">用户名已存在</div>')
					end_load()
				}
			}
		})
	})
	$('#imgUpload').change(function() {
		var imgObj = this.files[0];
		if (!/^image/.test(imgObj.type)) {
			alert("图片格式不正确");
			return;
		}
		if (imgObj.size > 52428800) {
			alert("文件太大");
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