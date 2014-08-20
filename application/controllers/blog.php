<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("blog_model");
	}

	// データベースからすべてのエントリーを取得するファンクション
	function index(){
		// blog_modelのget_all_postファンクションを実行して、データをqueryに格納
		$data['query'] = $this->blog_model->get_all_posts();
		$this->load->view("index", $data);
	}

	function add_new_entry(){
		$this->load->helper("form");
		// form_validationとsessionライブラリを読み込む
		$this->load->library(array("form_validation", "session"));

		// バリデーションルールの設定
		$this->form_validation->set_rules("entry_name", "タイトル", "required|xss_clean|max_length[200]");
		$this->form_validation->set_rules("entry_body", "本文", "required|xss_clean");

		if( $this->form_validation->run() == FALSE ){
			// フォームバリデーションエラーが起きたら以下を実行
			// ページの初回読み込み時は自動的に起動
			$this->load->view("add_new_entry");
		}else{
			// POSTされた内容を変数に格納する
			$name = $this->input->post("entry_name");
			$body = $this->input->post("entry_body");

			// add_new_entryモデルを実行し、POSTデータを投げる
			$this->blog_model->add_new_entry($name, $body);

			// "フラッシュデータ"
			// 通知メッセージやステータスメッセージ(ex:レコード2は削除されました)によく利用されます。
			$this->session->set_flashdata("message", "記事が追加されました");

			// $this->load->view()の場合と表記法法が異なることに注意
			redirect("blog/add_new_entry");

		}
	}

	public function post($id){
		// 記事の情報を取得
		$data["query"] = $this->blog_model->get_post($id);

		// コメントデータを取得
		$data["comments"] = $this->blog_model->get_post_comment($id);

		// 記事のIDを取得
		$data["post_id"] = $id;

		// 合計のコメント数を取得
		$data["total_comments"] = $this->blog_model->total_comments($id);


		/*----------------------------------------------------------*/
		// 以下は、個別記事ページでのコメント追加用の機能
		/*----------------------------------------------------------*/
		// フォームヘルパーと、ライブラリ（バリデーション、セッション）の読み込み
		$this->load->helper("form");
		$this->load->library(array("form_validation", "session"));

		// バリデーションルールの設定
		$this->form_validation->set_rules("commentor", "名前", "required|xss_clean|max_length[200]");
		$this->form_validation->set_rules("email", "Email", "required|valid_email|xss_clean");
		$this->form_validation->set_rules("comment", "コメント", "required|xss_clean");

		if( $this->blog_model->get_post($id) ){

			// get_postモデルが正常に実行されたら以下の処理を行なう
			foreach( $this->blog_model->get_post($id) as $row ){
				// ページのタイトル設定
				$data["title"] = $row->entry_name;
			}

			if( $this->form_validation->run() == FALSE ){
				// バリデーションエラーの場合は以下を実行
				$this->load->view("post", $data);
			}else{
				// POSTされたコメント投稿者名を$nameに格納
				$name = $this->input->post("commentor");
				$email = $this->input->post("email");
				$comment = $this->input->post("comment");
				$post_id = $id;

				$this->blog_model->add_new_comment($post_id, $name, $email, $comment);
				$this->session->set_flashdata("message", "コメントが追加されました。");
				redirect("blog/post/". $id);
			}
		}else{
			show_404();
		}
	}
}














