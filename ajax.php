<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if ($action == 'login') {
	$login = $crud->login();
	if ($login)
		echo $login;
}

if ($action == 'logout') {
	$logout = $crud->logout();
	if ($logout)
		echo $logout;
}

if ($action == 'save_user') {
	$save = $crud->save_user();
	if ($save)
		echo $save;
}
if ($action == 'delete_user') {
	$save = $crud->delete_user();
	if ($save)
		echo $save;
}
if ($action == 'signup') {
	$save = $crud->signup();
	if ($save)
		echo $save;
}

if ($action == "save_settings") {
	$save = $crud->save_settings();
	if ($save)
		echo $save;
}
if ($action == "save_category") {
	$save = $crud->save_category();
	if ($save)
		echo $save;
}

if ($action == "delete_category") {
	$delete = $crud->delete_category();
	if ($delete)
		echo $delete;
}

if ($action == "save_topic") {
	$save = $crud->save_topic();
	if ($save)
		echo $save;
}
if ($action == "delete_topic") {
	$save = $crud->delete_topic();
	if ($save)
		echo $save;
}


if ($action == "save_comment") {
	$save = $crud->save_comment();
	if ($save)
		echo $save;
}
if ($action == "delete_comment") {
	$save = $crud->delete_comment();
	if ($save)
		echo $save;
}


if ($action == "save_reply") {
	$save = $crud->save_reply();
	if ($save)
		echo $save;
}
if ($action == "delete_reply") {
	$save = $crud->delete_reply();
	if ($save)
		echo $save;
}

if ($action == "search") {
	$get = $crud->search();
	if ($get)
		echo $get;
}

if ($action == "upload") {
	$get = $crud->upload();
	if ($get) echo $get;
}
ob_end_flush();
