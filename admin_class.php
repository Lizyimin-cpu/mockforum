<?php
session_start();
ini_set('display_errors', 1);
class Action
{
	private $db;

	public function __construct()
	{
		ob_start();
		include 'db_connect.php';

		$this->db = $conn;
	}
	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}
	// 登录
	function login()
	{

		extract($_POST);
		if (empty($username) || empty($password)) {
			return 2;
		}
		$qry = $this->db->query("SELECT * FROM users where username = '" . $username . "' and password = '" . md5($password) . "' ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'password' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			return 1;
		} else {
			return 3;
		}
	}
	// 退出登录
	function logout()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}

	// 修改系统信息
	function save_settings()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about = '$about' ";
		$data .= ", img = '$imagePath' ";
		$data .= ", copyright = '" . $copyright . "' ";
		if (!$name || !$email || !$contact || !$about || !$copyright) {
			return 2;
		}
		if (!$imagePath) {
			return 3;
		}
		$save = $this->db->query("UPDATE system_settings set " . $data);
		if ($save) {
			return 1;
		}
	}
	// 添加/修改用户
	function save_user()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if (!empty($password)) {
			$data .= ", password = '" . md5($password) . "' ";
		}
		$data .= ", type = $type ";
		if (!$imagePath) {
			$data .= ", avatar = './assets/img/user.png' ";
		} else {
			$data .= ", avatar = '$imagePath' ";
		}

		if (empty($id)) {
			$chk = $this->db->query("SELECT * FROM users where username = '" . $username . "'")->num_rows;

			if ($chk > 0) {
				return 2;
				exit;
			}
			$save = $this->db->query("INSERT INTO users set " . $data);
		} else {
			$save = $this->db->query("UPDATE users set " . $data . " where id = " . $id);
		}

		if ($save) {
			return 1;
		}
	}
	// 删除用户
	function delete_user()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = " . $id);
		if ($delete)
			return 1;
	}
	// 注册
	function signup()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '" . md5($password) . "' ";
		$data .= ", type = '" . $type . "' ";
		if (!$name || !$username || !$password || !$type) {
			return 3;
			exit;
		}
		if (!$imagePath) {
			return 4;
			exit;
		} else {
			$data .= ", avatar = '$imagePath' ";
		}
		$chk = $this->db->query("SELECT * FROM users where username = '$username' ")->num_rows;
		if ($chk > 0) {
			return 2;
			exit;
		}

		$save = $this->db->query("INSERT INTO users set " . $data);
		if ($save) {
			return 1;
		}
	}
	// 添加/修改分类
	function save_category()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", description = '$description' ";
		$uid = $_SESSION['login_id'];

		if ($imagePath) {
			$data .= ", image = '$imagePath' ";
		} else {
			return 4;
		}
		if (!$name || !$description) {
			return 3;
		}

		if ($id) {
			if ($uid != '1') {
				$data .= ", user_id = " . $uid;
				$save = $this->db->query("UPDATE categories set $data where id = $id and user_id = $uid");
			} else {
				$save = $this->db->query("UPDATE categories set $data where id = $id");
			}

			if ($save) {
				return 1;
			} else {
				return 5;
			}
		} else {
			$data .= ", user_id = " . $uid;
			$save = $this->db->query("INSERT INTO categories set " . $data);
		}


		if ($save)
			return 2;
	}
	// 删除分类
	function delete_category()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM categories where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	// 添加/修改主题
	function save_topic()
	{
		extract($_POST);
		$data = " title = '$title' ";
		$data .= ", category_ids = '" . (implode(",", $category_ids)) . "' ";
		$data .= ", content = '" . htmlentities(str_replace("'", "&#x2019;", $content)) . "' ";

		if (empty($id)) {
			$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$save = $this->db->query("INSERT INTO topics set " . $data);
		} else {
			$save = $this->db->query("UPDATE topics set " . $data . " where id=" . $id);
		}
		if ($save)
			return 1;
	}
	// 删除主题
	function delete_topic()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM topics where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	// 添加/编辑评论
	function save_comment()
	{
		extract($_POST);
		$data = " comment = '" . htmlentities(str_replace("'", "&#x2019;", $comment)) . "' ";

		if (empty($id)) {
			$data .= ", topic_id = '$topic_id' ";
			$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$data .= ", date_updated = '" . date('Y-m-d H:i:s', time()) . "'";
			$save = $this->db->query("INSERT INTO comments set " . $data);
		} else {
			$save = $this->db->query("UPDATE comments set " . $data . " where id=" . $id);
		}
		if ($save)
			return 1;
	}
	// 删除评论
	function delete_comment()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM comments where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	// 添加/编辑回复
	function save_reply()
	{
		extract($_POST);
		$data = " reply = '" . htmlentities(str_replace("'", "&#x2019;", $reply)) . "' ";

		if (empty($id)) {
			$data .= ", comment_id = '$comment_id' ";
			$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$data .= ", date_updated = '" . date('Y-m-d H:i:s', time()) . "'";
			$save = $this->db->query("INSERT INTO replies set " . $data);
		} else {
			$save = $this->db->query("UPDATE replies set " . $data . " where id=" . $id);
		}
		if ($save)
			return 1;
	}
	// 删除回复
	function delete_reply()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM replies where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	// 搜索
	function search()
	{
		extract($_POST);
		$data = array();
		$tag = $this->db->query("SELECT * FROM categories order by name asc");
		while ($row = $tag->fetch_assoc()) :
			$tags[$row['id']] = $row['name'];
		endwhile;
		$ts = $this->db->query("SELECT * FROM categories where name like '%{$keyword}%' ");
		$tsearch = '';
		while ($row = $ts->fetch_assoc()) :
			$tsearch .= " or concat('[',REPLACE(t.category_ids,',','],['),']') like '%[{$row['id']}]%' ";
		endwhile;
		// echo "SELECT t.*,u.name FROM topics t inner join users u on u.id = t.user_id where t.title LIKE '%{$keyword}%' or content LIKE '%{$keyword}%' $tsearch order by unix_timestamp(t.date_created) desc";
		$topic = $this->db->query("SELECT t.*,u.name FROM topics t inner join users u on u.id = t.user_id where t.title LIKE '%{$keyword}%' or content LIKE '%{$keyword}%' $tsearch order by unix_timestamp(t.date_created) desc");
		while ($row = $topic->fetch_assoc()) :
			$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
			unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
			$desc = strtr(html_entity_decode($row['content']), $trans);
			$row['desc'] = strip_tags(str_replace(array("<li>", "</li>"), array("", ","), $desc));
			$row['view'] = $this->db->query("SELECT * FROM forum_views where topic_id=" . $row['id'])->num_rows;
			$row['comments'] = $this->db->query("SELECT * FROM comments where topic_id=" . $row['id'])->num_rows;
			$row['replies'] = $this->db->query("SELECT * FROM replies where comment_id in (SELECT id FROM comments where topic_id=" . $row['id'] . ")")->num_rows;
			$row['tags'] = array();
			foreach (explode(",", $row['category_ids']) as $cat) :
				$row['tags'][] = $tags[$cat];
			endforeach;
			$row['created'] = date('M d, Y h:i A', strtotime($row['date_created']));
			$row['posted'] = ucwords($row['name']);
			$data[] = $row;
		endwhile;
		return json_encode($data);
	}

	// 上传
	function upload()
	{
		extract($_POST);
		$file = $_FILES['file'];
		if ($file['error'] > 0) return 2;
		$uploadPath = './assets/uploads/' . date('ymd');
		if (!file_exists($uploadPath)) {
			if (mkdir($uploadPath, 0777, true)) chmod($uploadPath, 0777);
		}
		$srcImgPath = $file['tmp_name'];
		$targetImgPath = $uploadPath . '/thumb_' . $file['name'];
		$targetW = 75;
		$targetH = 75;
		$imgSize = GetImageSize($srcImgPath);
		$imgType = $imgSize[2];
		//@ 使函数不向页面输出错误信息
		switch ($imgType) {
			case 1:
				$srcImg = @ImageCreateFromGIF($srcImgPath);
				break;
			case 2:
				$srcImg = @ImageCreateFromJpeg($srcImgPath);
				break;
			case 3:
				$srcImg = @ImageCreateFromPNG($srcImgPath);
				break;
		}
		//取源图象的宽高
		$srcW = ImageSX($srcImg);
		$srcH = ImageSY($srcImg);
		if ($srcW > $targetW || $srcH > $targetH) {
			$targetX = 0;
			$targetY = 0;
			if ($srcW > $srcH) {
				$finaW = $targetW;
				$finalH = round($srcH * $finaW / $srcW);
				$targetY = floor(($targetH - $finalH) / 2);
			} else {
				$finalH = $targetH;
				$finaW = round($srcW * $finalH / $srcH);
				$targetX = floor(($targetW - $finaW) / 2);
			}
			if (function_exists("ImageCreateTrueColor")) {
				$targetImg = ImageCreateTrueColor($finaW, $finalH);
			} else {
				$targetImg = ImageCreate($finaW, $finalH);
			}
			$targetX = ($targetX < 0) ? 0 : $targetX;
			$targetY = ($targetX < 0) ? 0 : $targetY;
			$targetX = ($targetX > ($finaW / 2)) ? floor($finaW / 2) : $targetX;
			$targetY = ($targetY > ($finalH / 2)) ? floor($finalH / 2) : $targetY;
			// 背景白色
			$white = ImageColorAllocate($targetImg, 255, 255, 255);
			ImageFilledRectangle($targetImg, 0, 0, $finaW, $finalH, $white);
			/*
                PHP的GD扩展提供了两个函数来缩放图象：
                ImageCopyResized 在所有GD版本中有效，其缩放图象的算法比较粗糙，可能会导致图象边缘的锯齿。
                ImageCopyResampled 需要GD2.0.1或更高版本，其像素插值算法得到的图象边缘比较平滑，
                    该函数的速度比ImageCopyResized慢。
            */
			if (function_exists("ImageCopyResampled")) {
				ImageCopyResampled($targetImg, $srcImg, 0, 0, 0, 0, $finaW, $finalH, $srcW, $srcH);
			} else {
				ImageCopyResized($targetImg, $srcImg, 0, 0, 0, 0, $finaW, $finalH, $srcW, $srcH);
			}
			switch ($imgType) {
				case 1:
					ImageGIF($targetImg, $targetImgPath);
					break;
				case 2:
					ImageJpeg($targetImg, $targetImgPath);
					break;
				case 3:
					ImagePNG($targetImg, $targetImgPath);
					break;
			}
			ImageDestroy($srcImg);
			ImageDestroy($targetImg);
		} else {
			//不超出指定宽高则直接复制
			copy($srcImgPath, $targetImgPath);
			ImageDestroy($srcImg);
		}
		$filePath = $uploadPath . '/' . $file['name'];
		move_uploaded_file($file['tmp_name'], $filePath);
		return json_encode(['code' => 1, 'data' => ['file' => $filePath], 'thumb' => $targetImgPath]);
	}
}
