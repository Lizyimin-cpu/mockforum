<?php include 'db_connect.php' ?>
<?php
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM comments where id=" . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}

?>
<div class="container-fluid">
	<form action="" id="update-comment">
		<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>" class="form-control">

		<div class="row form-group">
			<div class="col-md-12">
				<label class="control-label">评论</label>
				<textarea name="comment" class="text-jqte"><?php echo isset($comment) ? $comment : '' ?></textarea>
			</div>
		</div>
	</form>
</div>

<script>
	$('.select2').select2({
		placeholder: "请在此处选择",
		width: "100%"
	})
	$('.text-jqte').jqte();
	$('#update-comment').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'ajax.php?action=save_comment',
			method: 'POST',
			data: $(this).serialize(),
			success: function(resp) {
				if (resp == 1) {
					alert_toast("操作成功", 'success')
					setTimeout(function() {
						location.reload()
					}, 1000)
				}
			}
		})
	})
</script>