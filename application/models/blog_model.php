<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	// データベースからすべてのエントリーを取得するファンクション
	function get_all_posts(){

		// エントリーのカラムから情報を取得して、queryに格納
		$query = $this->db->get("entry");

		// エントリーカラム情報を持ったqueryをresultに挿入
		// result()メソッドは、結果をオブジェクトの配列として、または失敗した場合には 空の配列 を返します。
		return $query->result();
	}

	// 新規記事をDBに挿入する機能
	function add_new_entry($name, $body){
		$data = array(
			"entry_name" => $name,
			"entry_body" => $body
		);
		$this->db->insert("entry", $data);
	}

	function get_post($id){
		// $idはget_all_postsモデルが実行されたときから保持されている
		$this->db->where("entry_id", $id);

		// entryテーブルから情報を取得
		$query = $this->db->get("entry");

		if( $query->num_rows() != 0 ){
			// データ数が0ではなかった場合に以下を実行
			return $query->result();
		}else{
			return FALSE;
		}
	}

	function get_post_comment($post_id){
		$this->db->where("entry_id", $post_id);
		$query = $this->db->get("comment");
		return $query->result();
	}

	function total_comments($id){
		// 検索でよく使う LIKE 句を生成できます。
		// WHERE entry_id LIKE '%id%'
		$this->db->like("entry_id", $id);
		$this->db->from("comment");

		// count_all_results()：特定のActive Record クエリの行数を調べる
		return $this->db->count_all_results();
	}

	// コメント情報をDBに挿入する機能
	function add_new_comment($post_id, $commentor, $email, $comment){
		$data = array(
			"entry_id" => $post_id,
			"comment_name" => $commentor,
			"comment_email" => $email,
			"comment_body" => $comment
		);
		$this->db->insert("comment" ,$data);
	}

}
