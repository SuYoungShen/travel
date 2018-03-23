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

  //資料庫新增
  public function insert($table, $datas){
    return $this->db->insert($table, $datas);
  }

  //更新資料庫
  public function update($table, $datas, $where){
    $this->db->where($where);
    return  $this->db->update($table, $datas);
  }

  public function get_date($table){
    return $this->db->select('Update_Date')->get($table)->row();
  }

}
?>
