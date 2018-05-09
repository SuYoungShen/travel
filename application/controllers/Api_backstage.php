<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_backstage extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('bs_model'));
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

  //add edit、delete的功能 in 20180509
  function do_attractions(){
    $PostData = array(
      'id' => $this->input->post('id'),
      'place' => $this->input->post('place')
    );
    $where = 'id = '."'".$PostData['id']."'";
    $view_data['one_att'] = $this->bs_model->get_once($PostData['place'], $where);
    echo json_encode($view_data);
  }//do_attractions

}
