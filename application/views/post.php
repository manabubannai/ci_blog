<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>個別記事ページ</title>
</head>
<body>
<h1>個別記事ページ｜CodeIgniterでブログ作成</h1>

<h2><?php echo $query[0]->entry_name; ?></h2>
<h2><?php echo $query[0]->entry_body; ?></h2>

<hr />

<h3>コメント</h3>
<?php
	if($comments){
		foreach( $comments as $comment ){
			echo $comment->comment_body;
			echo "<br />";
			echo $comment->comment_name;
			echo "<br />";

			// strtotime()：引数で指定された文字列をタイムスタンプに変換する
			echo date("Y-m-d", strtotime($comment->comment_date));
		}
	}else{
		echo "コメントはありません。";
	}
?>

<hr />

<h4>コメントを投稿する</h4>
<?php
	echo validation_errors();

	if( $this->session->flashdata("message") ){
		echo $this->session->flashdata("message");
	}

	echo form_open("blog/post/" . $query[0]->entry_id );

	echo form_label("名前", "commentor");
	 $data = array(
	 	"name" => "commentor"
	 );
	echo form_input($data);

	echo form_label("Email", "email");
	 $data = array(
	 	"name" => "email"
	 );
	echo form_input($data);

	echo form_label("コメント", "comment");
	 $data = array(
	 	"name" => "comment",
	 	"rows" => 5,
	 	"cols" => 50
	 );
	echo form_textarea($data);

	echo form_submit("contactSubmit", "コメント送信");

	echo form_close();

?>

</body>
</html>