<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backstage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('bs_model'));
	}

	function index()
  {
		$view_data = array(
			'title' => '地區',
			'page' => 'place.php'
		);
    $this->load->view('backstage/layout', $view_data);
  }

	function place()
  {
		$view_data = array(
			'title' => '地區名',
			'breadcrumb_title' => '地區資訊',//麵包穴抬頭
			'page' => 'place.php'
		);
		//新增地區名 ok in 20180430
		if (!empty($this->input->post("rule")) && $this->input->post('rule') == "New_place") {
			if (!empty($this->input->post('ch_place')) && !empty($this->input->post('en_place'))) {

				$ch_place = $this->input->post('ch_place');//地區名
				$en_place = $this->input->post('en_place');//地區名
				date_default_timezone_set("Asia/Taipei");//設定時區

				$dataArray['id'] = uniqid();
				$dataArray['en_place'] = $en_place;
				$dataArray['ch_place'] = $ch_place;
				$dataArray["update_date"] = date("Y-m-d");
        $dataArray["update_time"] = date("H:i:s");

				if($this->bs_model->insert('place', $dataArray)){
					$view_data['sys_code'] = 200;
					$view_data['sys_msg_title'] = '恭喜!';
					$view_data['sys_msg'] = '新增地區名成功';
					$view_data['status'] = 'success';
				}else {
					$view_data['sys_code'] = 404;
					$view_data['sys_msg_title'] = '有錯誤!';
					$view_data['sys_msg'] = '新增地區名失敗';
					$view_data['status'] = 'error';
				}
			}else {
				$view_data['sys_code'] = 404;
				$view_data['sys_msg_title'] = '有錯誤!';
				$view_data['sys_msg'] = '不能為空';
				$view_data['status'] = 'error';
			}
		}

		$view_data['place'] = $this->bs_model->get_all('place');

    $this->load->view('backstage/layout', $view_data);
  }

	//add 刪除、編輯地區功能 in 20180507
	function do_place(){
		$dataArray = array(
			'rule' => $this->input->post('rule'),
			'place_id' => $this->input->post('place_id')
		);
		if (!empty($dataArray['place_id'])) {
			if (!empty($dataArray['rule']) && $dataArray['rule'] == "Delete") {

				$where = "id="."'".$dataArray['place_id']."'";
				if ($this->bs_model->delete('place', $where)) {
					$view_data['sys_code'] = 200;
					$view_data['sys_title'] = '成功';
					$view_data['sys_msg'] = "恭喜刪除成功!!!";
					$view_data['status'] = 'warning';

				}else {
					$view_data['sys_code'] = 404;
					$view_data['sys_title'] = '失敗';
					$view_data['sys_msg'] = "刪除地區失敗!!!";
					$view_data['status'] = 'error';
				}
				$this->output->set_content_type('application/json')->set_output(json_encode($view_data));
			}else if(!empty($dataArray['rule']) && $dataArray['rule'] == "Edit"){
				//增加編輯功能 in 201080506
				$data = array(
					'ch_place' => $this->input->post('ed_ch_place'),
					'en_place' => $this->input->post('ed_en_place')
				);

				$where = "id="."'".$dataArray['place_id']."'";
				if ($this->bs_model->update('place', $data, $where)) {
					$view_data['sys_code'] = 200;
					$view_data['sys_title'] = '成功';
					$view_data['sys_msg'] = "恭喜更新成功!!!";
					$view_data['status'] = 'success';

				}else {
					$view_data['sys_code'] = 404;
					$view_data['sys_title'] = '失敗';
					$view_data['sys_msg'] = "更新地區失敗!!!";
					$view_data['status'] = 'error';
				}
				$this->output->set_content_type('application/json')->set_output(json_encode($view_data));
			}
		}
	}//do_place


	function attractions()
  {
		$view_data = array(
			'title' => '景點資訊',
			'page' => 'attractions.php'
		);
    $this->load->view('backstage/layout', $view_data);
  }
}
?>
