<?php
class Travel_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  //資料表有幾筆資料
  public function get_num($table){
    $table = $this->db->get($table)->num_rows();
    return $table;
  }

  //抓取特定資料
  public function get_once($table, $where){
    return $this->db->get_where($table, $where)->row();
  }

  //抓取全部資料
  public function get_all($table){
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

  //抓取日期
  public function get_date($table){
    return $this->db->select('Update_Date')->get($table)->row();
  }

}
?>
