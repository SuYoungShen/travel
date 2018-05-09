<?php
class Bs_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  //抓取資料在資料表有幾筆
  public function get_num($table){
    $table = $this->db->get($table)->num_rows();
    return $table;
  }

  //20180406取得特定欄位
  public function get_once_field($table, $where, $select){
    $this->db->select($select);
    return $this->db->get_where($table, $where)->result_array();
  }

  public function get_once_all($table, $where){
    $this->db->where($where);
    $table = $this->db->get($table)->result_array();
    return $table;
  }

  //抓取特定一筆資料
  public function get_once($table, $where){
    return $this->db->get_where($table, $where)->row();
  }

  //抓取全部資料
  public function get_all($table){
    // $this->db->select('id, Picture, Name, phone');
    // return $this->db->get_compiled_select($table);//印出字串
    return $this->db->get($table)->result_array();
  }

  //抓取ID
  public function get_id($table){
    $this->db->select('id');
    return $this->db->get($table)->result_array();
  }

  //資料表新增
  public function insert($table, $datas){
    return $this->db->insert($table, $datas);
  }

  //更新資料表
  public function update($table, $datas, $where){
    $this->db->where($where);
    return  $this->db->update($table, $datas);
  }

  public function delete($table, $where){
    $this->db->where($where);
    return $this->db->delete($table);
  }

  //抓取日期
  public function get_date($table){
    return $this->db->select('Update_Date')->get($table)->row();
  }

  //設定create日期
  // function set_create_date($id){
  //   date_default_timezone_set("Asia/Taipei");
  //   $dataArray = array(
  //     'create_date' => date('Y-m-d'),
  //     'create_time' => date('H:i:s')
  //   );
  //   $this->db->where('id', $id);//以id當條件
  //   $this->db->update('user_like', $dataArray);//更新最後登入時間
  // }

}
?>
