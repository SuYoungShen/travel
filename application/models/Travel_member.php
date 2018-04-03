<?php
class Travel_member extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  //確認會員是否登入
  function chk_login_status(){
    return $this->session->userdata('login_status');
  }

  //確定使用者是否存在
  function chk_login_user($email, $password){
    $this->db->where('email', $email);
    $this->db->where('password', $password);
    $this->db->where('type', 'normal');
    //count_all_results = 查詢結果列的數量
    if ($this->db->count_all_results('user_main') > 0) {
      return true;
    }else {
      return false;
    }
  }

  //取得會員特定資料
  function get_once($id){
    $this->db->select('id, email, nickname, phone');
    $this->db->where('id', $id);
    return $this->db->get('user_main')->row_array();
  }

  ///用Email去取得資料
  function get_once_by_email($email){
    $this->db->where('email', $email);
    //count_all_results = 查詢結果列的數量
    return $this->db->get('user_main')->row_array();
  }

  //設定最後登入時間
  function set_last_login($id){
    date_default_timezone_set("Asia/Taipei");
    $dataArray = array(
      'last_date' => date('Y-m-d'),
      'last_time' => date('H:i:s')
    );
    $this->db->where('id', $id);//以id當條件
    $this->db->update('user_main', $dataArray);//更新最後登入時間
  }

  //登入
  function do_login($email){
    $user = $this->get_once_by_email($email);
    $session_array = array(
      'user_name' => $user['nickname'],
      'user_email' => $user['email'],
      'user_id' => $user['id'],
      'login_status' => true
    );
    $this->set_last_login($user['id']);
    $this->session->set_userdata($session_array);
    return true;
  }
  //會員登出
  function logout(){
    $session_array = array(
      'user_name', 'user_name',
      'user_id', 'login_status'
    );
    $this->session->unset_userdata($session_array);
    return true;
  }

  //新增會員
  function insert($dataArray){
    return $this->db->insert('user_main', $dataArray);
  }

  //會員更新
  function update($id, $dataArray){
    $this->db->where('id', $id);
    return $this->db->update('user_main', $dataArray);
  }

}
?>
