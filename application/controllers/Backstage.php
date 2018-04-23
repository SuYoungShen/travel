<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backstage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

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
			'title' => '地區',
			'page' => 'place.php'
		);
    $this->load->view('backstage/layout', $view_data);
  }

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
