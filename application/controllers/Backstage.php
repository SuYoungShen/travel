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
			'breadcrumb_title' => '地區資訊',//麵包穴抬頭
			'title' => '地區名',
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

	function attractions()
  {
		$view_data = array(
			'breadcrumb_title' => '地區資訊',//麵包穴抬頭
			'title' => '景點資訊',
			'page' => 'attractions.php'
		);

		//select 用 in 20180507
		$select = 'ch_place , en_place';
		$where = array('1'=> 1);
		$view_data['place'] = $this->bs_model->get_once_field('place', $where, $select);
		//select 用 in 20180507

		if (!$this->input->post('place')) {
			//景點資訊(DataTable) in 20180507
			//add Update_Date in 20180509
			$select = 'id, Name , Opentime, Tel, Add, Update_Date';
			$where = array('Type'=> '0');//0=景點
			
			$view_data['attractions'] = $this->bs_model->get_once_field($view_data['place'][0]['en_place'], $where, $select);
			//景點資訊(DataTable) in 20180507
			$this->load->view('backstage/layout', $view_data);
		}else {
			//景點資訊(DataTable) in 20180507
			//add Update_Date in 20180509
			$select = 'id, Name , Opentime, Tel, Add, Update_Date';
			$where = array('Type'=> '0');
			$attractions = $this->bs_model->get_once_field($this->input->post('place'), $where, $select);
			//景點資訊(DataTable) in 20180507
			echo json_encode($attractions);
		}
  }
}
?>
