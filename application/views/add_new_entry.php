<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>記事投稿｜CodeIgniterでブログ作成</title>
</head>
<body>
<h2>記事投稿ページ</h2>

<div id="container">
<?php
	echo validation_errors();

	if( $this->session->flashdata("message") ){
		echo $this->session->flashdata("message");
	}

	// $this->load->view("blog/menu");
	echo form_open("blog/add_new_entry");

	echo form_label("タイトル", "entry_name");
	$data = array(
		"name" => "entry_name",
	);
	echo form_input($data);

	echo form_label("本文", "entry_body");
	$data = array(
		"name" => "entry_body",
		"rows" => 5,
		"cols" => 50
	);
	echo form_textarea($data);

	echo form_submit("contactSubmit", "送信");

	echo form_close();

?>

</div>

</body>
</html>