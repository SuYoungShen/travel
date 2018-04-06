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
			$where = "id="."'".$dataArray['id']."'"."&& email="."'".$dataArray['email']."'";
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
	function Delete_Am(){
		$dataArray = array(
			'am_id' => $this->input->post('am_id'),
			'id' => $this->input->post('id'),
			'email' => $this->input->post('email')
		);

		if (!empty($dataArray['am_id']) && !empty($dataArray['id']) && !empty($dataArray['email'])) {

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
