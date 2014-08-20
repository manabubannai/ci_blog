<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>CodeIgniterでブログ作成</title>
</head>
<body>
<h2>CodeIgniterでブログ作成</h2>

<div id="container">
<a href="<?php echo base_url() . 'blog/add_new_entry'; ?>">新規記事投稿</a>
<hr />
<?php

	// $this->load->view("blog/menu");
	if($query){
		foreach($query as $post):
			echo "<h2>";
			// anchor(リンク先URL, アンカーテキスト);
			echo anchor('blog/post/' . $post->entry_id, $post->entry_name);
			echo "</h2>";
			echo "<p>";
			echo $post->entry_date;
			echo "<br />";
			echo $post->entry_body;
			echo "<br />";
			echo "コメント数：";
			echo $this->blog_model->total_comments($post->entry_id);
			echo "</p>";
		endforeach;
	}else{
		echo "記事がありません";
	}

?>

</div>

</body>
</html>