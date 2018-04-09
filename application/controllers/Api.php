<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('travel_model');
		$this->load->model('travel_member');
	}

  function third_Fb_Login(){
    $dataArray = array(
      'fb_id' => $this->input->post('id'),
      'email' => $this->input->post('email'),
      'nickname' => $this->input->post('name')
    );

    if (!empty($dataArray['email']) && !empty($dataArray['fb_id']) && !empty($dataArray['nickname'])) {
      $user = $this->travel_member->get_once_by_email($dataArray['email']);
      if(!$user){//確認有無五使用者
        $dataArray['id'] = uniqid();
        $dataArray['type'] = 'facebook';
        $dataArray["create_date"] = date("Y-m-d");
        $dataArray["create_time"] = date("H:i:s");

        if ($this->travel_member->insert($dataArray)) {
          $view_data["sys_code"] = 200;
          $view_data["sys_msg"] = '新增成功！';
          $this->travel_member->do_login($dataArray['email']);
					redirect(base_url(''));
        }else {
          $view_data['sys_code'] = 404;
          $view_data['sys_msg'] = '新增失敗...?';
        }
      }else {
        if ($user['type'] == 'facebook') {
          $this->travel_member->do_login($dataArray['email']);
          $view_data["sys_code"] = 200;
          $view_data["sys_msg"] = '登入成功！';

        }else {
          $view_data['sys_code'] = 404;
          $view_data['sys_msg'] = '信箱有人使用過囉...?';
        }
      }
    }else {
      $view_data['sys_code'] = 404;
      $view_data['sys_msg'] = '表單上未填寫完成';
    }

    echo json_encode($view_data);
  }

	function register(){
		$view_data = array(
			'title' => '歡迎註冊',
			'form_title' => '註冊',
			'button' => '註冊',
			'path_title' => '回登入囉~~~',
			'path' => 'login',
			'page' => 'register.php'
		);

		if ($this->input->post('rule') == 'register') {

			$dataArray = array(
				'email' => $this->input->post('email'),
				'password' => $this->input->post('pass'),
				'nickname' => $this->input->post('nickname'),
				'phone' => $this->input->post('phone')
			);

			if (!empty($dataArray['email']) && !empty($dataArray['password']) &&
					!empty($this->input->post('re-pass')) && !empty($dataArray['nickname']) &&
					!empty($dataArray['phone'])) {

				if ($dataArray['password'] === $this->input->post('re-pass')) {

					if(!$this->travel_member->get_once_by_email($dataArray['email'])){//確認有無五使用者
						$dataArray['id'] = uniqid();
						$dataArray['password'] = sha1($dataArray['password']);
						$dataArray["create_date"] = date("Y-m-d");
						$dataArray["create_time"] = date("H:i:s");

						if ($this->travel_member->insert($dataArray)) {
							// $view_data["sys_code"] = 200;
							// $view_data["sys_msg"] = '新增成功！';
							$this->travel_member->do_login($dataArray['email']);
							redirect(base_url(''));
						}else {
							$view_data['sys_code'] = 404;
							$view_data['sys_msg'] = '新增失敗...?';
						}
					}else {
						$view_data['sys_code'] = 404;
						$view_data['sys_msg'] = '信箱有人使用過囉...?';
					}
				}else {
					$view_data['sys_code'] = 404;
					$view_data['sys_msg'] = '密碼不一致...!';
				}
			}else {
				$view_data['sys_code'] = 404;
				$view_data['sys_msg'] = '表單上未填寫完成';
			}
		}
		$this->load->view('login', $view_data);
	}

	//20180406 Att景點，Am訊息
	function Att_and_Am(){
		$dataArray = array('id' => $this->input->post('id'), 'email' => $this->session->userdata('user_email'));
		if (!empty($dataArray['id']) && !empty($dataArray['email'])) {
			$where = "id = ". '"'.$dataArray['id'].'"';
			$Am = $this->travel_model->get_once('attractions_message', $where);

			$select = "ch_place";
			$where = "en_place=".'"'.$Am->place.'"';
			$place = $this->travel_model->get_once_field('place', $where, $select);

			$select = "Picture, Name, Description, Opentime, Tel, Add";
			$where = "id="."'".$dataArray['id']."'";
			$Att = $this->travel_model->get_once_field($Am->place, $where, $select);

			$dataArray['data']["Am"] = $Am;
			$dataArray['data']["Place"] = $place;
			$dataArray['data']["Att"] = $Att;
			$this->output->set_content_type('application/json')->set_output(json_encode($dataArray['data']));
		}
	}

	//20180406刪除留言
	function delete_Am(){
		$dataArray = array(
			'am_id' => $this->input->post('am_id'),
			'id' => $this->input->post('id'),
			'email' => $this->input->post('email')
		);

		if (!empty($dataArray['am_id']) && !empty($dataArray['id']) && !empty($dataArray['email'])) {
			//更新成以下格式 in 20180409
			$where = "am_id="."'".$dataArray['am_id']."'"."&& id="."'".$dataArray['id']."'"."&& email="."'".$dataArray['email']."'";
			if ($this->travel_model->delete('attractions_message', $where)) {
				$view_data['sys_code'] = 200;
				$view_data['sys_title'] = '成功';
				$view_data['sys_msg'] = "恭喜刪除留言成功!!!";
				$view_data['status'] = 'success';

			}else {
				$view_data['sys_code'] = 404;
				$view_data['sys_title'] = '失敗';
				$view_data['sys_msg'] = "刪除留言失敗!!!";
				$view_data['status'] = 'error';
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($view_data));
		}
	}

	//20180409 Att景點，UL = user_like
	function Att_and_UL(){
		$dataArray = array('id' => $this->input->post('id'));
		if (!empty($dataArray['id'])) {

			$where = "id="."'".$dataArray['id']."'";
			$user_like = $this->travel_model->get_once_all('user_like', $where);

			//更新成以下格式 in 20180409
			$select = "ch_place";
			$where = "en_place=".'"'.$user_like[0]["place"].'"';
			$place = $this->travel_model->get_once_field('place', $where, $select);

			$select = "Picture, Name, Description, Opentime, Tel, Add";
			$where = "id="."'".$user_like[0]["place_id"]."'";
			$Att = $this->travel_model->get_once_field($user_like[0]["place"], $where, $select);

			$dataArray['data']["user_like"] = $user_like;
			$dataArray['data']["Place"] = $place;
			$dataArray['data']["Att"] = $Att;
			$this->output->set_content_type('application/json')->set_output(json_encode($dataArray['data']));
		}
	}

	//20180409刪除最愛
	function delete_UL(){
		$dataArray = array(
			'like_id' => $this->input->post('like_id'),
			'place_id' => $this->input->post('place_id'),
			'user_id' => $this->session->userdata('user_id')
		);

		if (!empty($dataArray['like_id']) && !empty($dataArray['place_id']) && !empty($dataArray['user_id'])) {

			$where = "id="."'".$dataArray['like_id']."'"."&& place_id="."'".$dataArray['place_id']."'"."&& user_id="."'".$dataArray['user_id']."'";
			if ($this->travel_model->delete('user_like', $where)) {
				$view_data['sys_code'] = 200;
				$view_data['sys_title'] = '成功';
				$view_data['sys_msg'] = "恭喜刪除留言成功!!!";
				$view_data['status'] = 'success';

			}else {
				$view_data['sys_code'] = 404;
				$view_data['sys_title'] = '失敗';
				$view_data['sys_msg'] = "刪除留言失敗!!!";
				$view_data['status'] = 'error';
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($view_data));
		}
	}

	//add like 功能 in 20180407
	function user_like(){
		$dataResponse = array();

		date_default_timezone_set("Asia/Taipei");
		$dataArray = array(
			"id" => uniqid(),
			"place_id"  => $this->input->post('place_id'),
			"place"  => $this->input->post('place'),
			"user_id" => $this->session->userdata('user_id'),
			"create_date" => date('Y-m-d'),
		  "create_time" => date('H:i:s')
		);

		if ($this->travel_member->chk_login_status()) {
			$action = $this->input->post('action');//抓取新增或刪除 in 20180409
			if ($action == "insert") {
				if (!empty($dataArray['place_id']) && !empty($dataArray['place']) && !empty($dataArray['user_id'])) {
					if ($this->travel_model->insert('user_like', $dataArray)) {
						$dataResponse['sys_code'] = 200;
						$dataResponse['sys_msg_title'] = "成功!!!";
						$dataResponse['sys_msg'] = "已加入您的最愛";
						$dataResponse['status'] = "success";
					}else {
						$dataResponse['sys_code'] = 404;
						$dataResponse['sys_msg_title'] = "失敗!!!";
						$dataResponse['sys_msg'] = "加入失敗";
						$dataResponse['status'] = "error";
					}
				}else {
					$dataResponse['sys_code'] = 404;
					$dataResponse['sys_msg_title'] = "注意!!!";
					$dataResponse['sys_msg'] = "如喜歡此景點，請先登入會員!";
					$dataResponse['status'] = "warning";
				}
			}else if($action == "delete"){
				if (!empty($dataArray['place_id']) && !empty($dataArray['place']) && !empty($dataArray['user_id'])) {
					$where = "id =".'"'.$this->input->post('id').'"';
					if ($this->travel_model->delete('user_like', $where)) {
						$dataResponse['sys_code'] = 200;
						$dataResponse['sys_msg_title'] = "移除成功!!!";
						$dataResponse['sys_msg'] = "已移除您的最愛";
						$dataResponse['status'] = "warning";
					}else {
						$dataResponse['sys_code'] = 404;
						$dataResponse['sys_msg_title'] = "失敗!!!";
						$dataResponse['sys_msg'] = "加入失敗";
						$dataResponse['status'] = "error";
					}
				}else {
					$dataResponse['sys_code'] = 404;
					$dataResponse['sys_msg_title'] = "注意!!!";
					$dataResponse['sys_msg'] = "如喜歡此景點，請先登入會員!";
					$dataResponse['status'] = "warning";
				}
			}//End Delete
		}else {
			$dataResponse['sys_code'] = 404;
			$dataResponse['sys_msg_title'] = "注意!!!";
			$dataResponse['sys_msg'] = "如喜歡此景點，請先登入會員!";
			$dataResponse['status'] = "warning";
		}

		echo json_encode($dataResponse);
	}

	function test(){

	}

	function noempty($title, $value){//不等於空
		$data = !empty($value)? $title.$value : "";
		return $data;
	}

	function send_mail(){

		$this->email->from('suyoungshen@gmail.com', 'Su Shen');
		$this->email->to('k90218104@gcloud.csu.edu.tw');

		$this->email->subject('您好!');
		$this->email->message('
		<a href="https://tw.yahoo.com/">點八</a>
		');

		$this->email->send();
	}
}
?>
