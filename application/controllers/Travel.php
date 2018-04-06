<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Travel extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('travel_model');
		$this->load->model('travel_member');
	}

	function index()
	{
		$view_data = array(
											'title' => "旅遊與美食",
											"sub_title" => "Travel && Food",
											"description" => "旅遊途中一定要嘗試美食",
											"page" => "main.php"
											);

		$options = array(
											'attractions' => '景點',
											'food' => '美食'
										);

		$view_data["TravelDropdown"] = form_dropdown('travel', $options, '', 'id="travel" class="selectpicker" data-width="auto" data-style="btn-primary"');
		// if (isset($_POST["travel"]) && isset($_POST["place"])) {
    //
		// 	$travel = $_POST["travel"];
		// 	$place = $_POST["place"];

			// if (($travel == "attractions") && ($place == "pingtung")) {
				// $view_data = $this->pingtung();
				// $this->load->view("layout", $view_data);
		// 	}else {
		// 		$this->load->view("layout", $view_data);
		// 	}
		// }else {
		$view_data['sys_code'] = 200;
		$this->load->view("layout", $view_data);
		// }
	}

	function attractions_place(){
		$place = array(
										"alltaiwan" => "全台",
										// "pingtung" => "屏東",
										"kaohsiung" => "高雄",
										"tainan" => "台南"
									);
		$this->output->set_content_type('application/json')->set_output(json_encode($place));
	}

	function food_place(){
		$place = array(
										// "pingtung" => "屏東",
										"kaohsiung" => "高雄"
									);
		$this->output->set_content_type('application/json')->set_output(json_encode($place));
	}

	function pingtung(){

		$base = base_url().uri_string();

		if (isset($_POST["place"]) && !empty($_POST["place"]) && $_POST["place"] == "pingtung") {

				$place = $_POST["place"];
				$travel = $_POST["travel"];

			if (isset($travel) && !empty($travel) && $travel == "attractions") {

				$url = file_get_contents("http://i-pingtung.com/OpenData/Attractions?start=0&limit=2000");
				$data = json_decode($url);

				$data->title = "屏東景點";

				$data->Img01 = $data->data[0]->Images[0]->Original;
				$data->Name01 = $data->data[0]->Name;
				$data->Title01 = $data->data[0]->Title;
				$data->OpenTime01 = $data->data[0]->OpenTime;
				$data->Tel01 = $data->data[0]->Tel;
				$data->FullAddress01 = $data->data[0]->FullAddress;

				$this->output->set_content_type('application/json')->set_output(json_encode($data));

			}else if (isset($travel) && !empty($travel) && $travel == "food") {

				$url = file_get_contents("http://i-pingtung.com/OpenData/Consume?start=0&limit=1000");
				$data = json_decode($url);

				$data->title = "屏東美食";
				$data->Img01 = $data->data[0]->Images[0]->Original;//第一張圖片
				$data->Name01 = $data->data[0]->Name;
				$data->Title01 = $data->data[0]->Title;
				$data->OpenTime01 = $data->data[0]->OpenTime;
				$data->Tel01 = $data->data[0]->Tel;
				$data->FullAddress01 = $data->data[0]->FullAddress;

				$this->output->set_content_type('application/json')->set_output(json_encode($data));

			}
		}else if(strpos(uri_string(), "attractions")){//網址上為景點
			$url = file_get_contents("http://i-pingtung.com/OpenData/Attractions?start=0&limit=2000");
			$data = json_decode($url);
		 	return json_encode($data);
		}else if(strpos(uri_string(), "food")){//網址上為食物
			$url = file_get_contents("http://i-pingtung.com/OpenData/Consume?start=0&limit=1000");
			$data = json_decode($url);
			return json_encode($data);
		}
	}

	function kaohsiung(){

 		$base = base_url().uri_string();

		$place = $this->input->post('place');
		$travel = $this->input->post('travel');

		if (isset($place) && !empty($place) && $place == "kaohsiung") {

			if (isset($travel) && !empty($travel) && $travel == "attractions") {

				$url = file_get_contents("https://data.kcg.gov.tw/api/action/datastore_search?resource_id=92290ee5-6e61-456f-80c0-249eae2fcc97");

				if ($url) {//判斷是否抓取成功
					$data = json_decode($url);
					$data->title = "高雄景點";
					$data->Img01 = $data->result->records[0]->Picture1;
					$data->Name01 = $data->result->records[0]->Name;
					$data->OpenTime01 = $data->result->records[0]->Opentime;
					$data->Tel01 = $data->result->records[0]->Tel;
					$data->FullAddress01 = $data->result->records[0]->Add;
					$data->Total = count($data->result->records);

					//20180324
					date_default_timezone_set("Asia/Taipei");//設定時區

					//20180323
					$Today_Date = date('Y-m-d');//今天日期

					if($this->travel_model->get_num($place) === 0){//判斷資料庫有無資料

						foreach ($data->result->records as $key => $value) {
							$datas = array(
								'id' => uniqid(),
								'Picture' => $value->Picture1,
								'name' => $value->Name,
								'Description'=> $value->Description,
								'Opentime' => $value->Opentime,
								'Tel' => $value->Tel,
								'Add' => $value->Add,
								'Driving' => $value->Travellinginfo,
								'Py' => $value->Py,
								'Px' => $value->Px,
								'Update_Date' => $Today_Date
							);
							$true = $this->travel_model->insert($place, $datas);
						}//end foreach

						if($true){
							$datas = $this->travel_model->get_all($place);
							foreach ($datas as $key => $value) {
								if ($key === 0) {
									$data->Id01 = $value['id'];
								}else {
									$data->Id[$key] = $value['id'];
								}
							}
							$this->output->set_content_type('application/json')->set_output(json_encode($data));
						}else {
							$res['sys_code'] = 404;
							$res['sys_msg'] = "新增資料庫失敗";
							$this->output->set_content_type('application/json')->set_output(json_encode($res));
						}

					}else {//資料表有資料

						$Update_Date = $this->travel_model->get_date($place);

						//判斷今天日期有無大於table日期，有表示要做更新
						if(strtotime($Today_Date) > strtotime($Update_Date->Update_Date)){

							$id = $this->travel_model->get_id($place);

							foreach ($data->result->records as $key => $value) {
								$datas = array(
									'Name' => $value->Name,
									'Picture' => $value->Picture1,
									'Description'=> $value->Description,
									'Opentime' => $value->Opentime,
									'Tel' => $value->Tel,
									'Add' => $value->Add,
									'Driving' => $value->Travellinginfo,
									'Py' => $value->Py,
									'Px' => $value->Px,
									'Update_Date' => $Today_Date
								);
								$where = "id ="."'".$id[$key]['id']."'";

								$true = $this->travel_model->update($place, $datas, $where);
							}
							if($true){
									$this->output->set_content_type('application/json')->set_output(json_encode($data));
								}else {
									$res['sys_code'] = 404;
									$res['sys_msg'] = "更新資料庫失敗";
									$this->output->set_content_type('application/json')->set_output(json_encode($res));
							}
						}else {//END 比對時間

							$data->title = "高雄景點";
							$datas = $this->travel_model->get_all($place);

							foreach ($datas as $key => $value) {
								if ($key === 0) {
									$data->Id01 = $value['id'];
								}else {
									$data->Id[$key] = $value['id'];
								}
							}

							$this->output->set_content_type('application/json')->set_output(json_encode($data));
						}
						//20180323
					}
				}else{//END $url
					//當api掛掉時，抓取資料庫資料
					$true = $this->travel_model->get_all($place);

					$data = new stdClass();//陣列轉換class後存自此變數;@禁止顯示錯誤
					$data->Total = $this->travel_model->get_num($place);
					$data->title = "高雄景點";

					foreach ($true as $key => $value) {
						if ($key === 0) {
							$data->Id01 = $value['id'];
							$data->Img01 = $value['Picture'];
							$data->Name01 = $value['Name'];
							$data->OpenTime01 = $value['Opentime'];
							$data->Tel01 = $value['Tel'];
							$data->FullAddress01 = $value['Add'];
						}else {
							$data->Id[$key] = $value['id'];
							@$data->result->records[$key]->Picture1 = $value['Picture'];
							@$data->result->records[$key]->Name = $value['Name'];
							@$data->result->records[$key]->Opentime = $value['Opentime'];
							@$data->result->records[$key]->Tel = $value['Tel'];
							@$data->result->records[$key]->Add = $value['Add'];
						}
					}
					$this->output->set_content_type('application/json')->set_output(json_encode($data));

				}
			}else if(isset($travel) && !empty($travel) && $travel == "food"){
				$url = file_get_contents("https://data.kcg.gov.tw/api/action/datastore_search?resource_id=ed80314f-e329-4817-bfbb-2d6bc772659e");
				$data = json_decode($url);

				$data->title = "高雄美食";

				$data->Img01 = $data->result->records[0]->Picture1;
				$data->Name01 = $data->result->records[0]->Name;
				$data->OpenTime01 = $data->result->records[0]->Opentime;
				$data->Tel01 = $data->result->records[0]->Tel;
				$data->FullAddress01 = $data->result->records[0]->Add;
				$data->Total = count($data->result->records);//總比數

				// echo "<pre>";
				// var_dump($data);
				// echo "</pre>";
				$this->output->set_content_type('application/json')->set_output(json_encode($data));

			}//food
		}else if($base == "http://104.199.199.61/kaohsiung/attractions"){//用來看景點資料

			$url = file_get_contents("https://data.kcg.gov.tw/api/action/datastore_search?resource_id=92290ee5-6e61-456f-80c0-249eae2fcc97");
			$data = json_decode($url);

			$Total = count($data->result->records);//總比數

			$this->output->set_content_type('application/json')->set_output(json_encode($data));

		}else if($base == "http://104.199.199.61/kaohsiung/food"){

			$url = file_get_contents("https://data.kcg.gov.tw/api/action/datastore_search?resource_id=ed80314f-e329-4817-bfbb-2d6bc772659e");
			$data = json_decode($url);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}else if($base == "http://104.199.199.61/kaohsiung/test"){
			$place = "kaohsiung";
			$true = $this->travel_model->get_all($place);

			$data = new stdClass();//陣列轉換class後存自此變數;@禁止顯示錯誤
			$data->Total = $this->travel_model->get_num($place);
			$data->title = "高雄景點";

			foreach ($true as $key => $value) {
				if ($key === 0) {
					$data->Id01 = $value['id'];
					$data->Img01 = $value['Picture'];
					$data->Name01 = $value['Name'];
					$data->OpenTime01 = $value['Opentime'];
					$data->Tel01 = $value['Tel'];
					$data->FullAddress01 = $value['Add'];
				}else {
					$data->Id[$key] = $value['id'];
					@$data->result->records[$key]->Picture1 = $value['Picture'];
					@$data->result->records[$key]->Name = $value['Name'];
					@$data->result->records[$key]->Opentime = $value['Opentime'];
					@$data->result->records[$key]->Tel = $value['Tel'];
					@$data->result->records[$key]->Add = $value['Add'];
				}
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	function tainan(){//沒照片...

		$base = base_url().uri_string();
		if (isset($_POST["place"]) && !empty($_POST["place"]) && $_POST["place"] == "tainan") {

			$place = $_POST["place"];
			$travel = $_POST["travel"];

			if (isset($travel) && !empty($travel) && $travel == "attractions") {

				$url = file_get_contents("https://www.twtainan.net/opendata/attractionapi?category=0&township=0&type=JSON");
				$data = json_decode($url);

				$arrayData = new stdClass();//陣列轉換class後存自此變數
				foreach ($data as $key => $value) {
					$arrayData->data[$key] = $value;
				}
				// echo $arrayData->D[0]->id;
				// echo "<pre>";
				// var_dump($arrayData);
				// echo "</pre>";

				$arrayData->title = "台南景點";
				$arrayData->Id01 = $arrayData->data[0]->id;//第一筆資料的名稱
				$arrayData->Name01 = $arrayData->data[0]->name;//第一筆資料的名稱
				$arrayData->OpenTime01 = $arrayData->data[0]->opentime;
				$arrayData->Tel01 = $arrayData->data[0]->tel;
				$arrayData->FullAddress01 = $arrayData->data[0]->address;
				$arrayData->Total = count($data);
				$this->output->set_content_type('application/json')->set_output(json_encode($arrayData));

			}else if(isset($travel) && !empty($travel) && $travel == "food"){
				$url = file_get_contents("https://data.kcg.gov.tw/api/action/datastore_search?resource_id=ed80314f-e329-4817-bfbb-2d6bc772659e");
				$data = json_decode($url);

				$data->title = "台南美食";

				$data->Img01 = $data->result->records[0]->Picture1;
				$data->Name01 = $data->result->records[0]->Name;
				$data->OpenTime01 = $data->result->records[0]->Opentime;
				$data->Tel01 = $data->result->records[0]->Tel;
				$data->FullAddress01 = $data->result->records[0]->Add;
				// echo "<pre>";
				// var_dump($data);
				// echo "</pre>";
				$this->output->set_content_type('application/json')->set_output(json_encode($data));
			}
		}else if($base == "http://104.199.199.61/tainan/attractions"){//word_censor用來檢查看看網址有無此文字

			$url = file_get_contents("https://www.twtainan.net/opendata/attractionapi?category=0&township=0&type=JSON");
			$data = json_decode($url);
			$arrayData = new stdClass();//陣列轉換class後存自此變數
			foreach ($data as $key => $value) {
				$arrayData->data[$key] = $value;
			}
			// echo "<pre>";
			// var_dump($arrayData);
			// echo "</pre>";
			$this->output->set_content_type('application/json')->set_output(json_encode($data));

		}else if($base == "http://104.199.199.61/tainan/food"){

			$url = file_get_contents("https://data.kcg.gov.tw/api/action/datastore_search?resource_id=ed80314f-e329-4817-bfbb-2d6bc772659e");
			$data = json_decode($url);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));

		}
	}

	function alltaiwan(){

		$url = "http://gis.taiwan.net.tw/XMLReleaseALL_public/scenic_spot_C_f.json";

		$output = file_get_contents($url);

		$output = trim($output, "\xEF\xBB\xBF");//\xEF\xBB\xBF=utf-8編碼
		$data = json_decode($output);

		$Picture1 = $data->XML_Head->Infos->Info[0]->Picture1;//取第一個景點的照片
		$Name01 = $data->XML_Head->Infos->Info[0]->Name;//取第一個景點的名稱
		$OpenTime01 = $data->XML_Head->Infos->Info[0]->Opentime;
		$Tel01 = $data->XML_Head->Infos->Info[0]->Tel;
		$FullAddress01 = $data->XML_Head->Infos->Info[0]->Add;
		// echo "<pre>";
		// var_dump($data);
		// echo "</pre>";
		$data->title = "全台景點";

		$data->Img01 = !empty($Picture1)?$Picture1:"https://upload.wikimedia.org/wikipedia/commons/3/3f/No-red.svg";
		$data->Name01 = $this->noempty("", $Name01);
		$data->OpenTime01 = $this->noempty("", $OpenTime01);
		$data->Tel01 = $this->noempty("", $Tel01);
		$data->FullAddress01 = $this->noempty("", $FullAddress01);

		$this->output->set_output(json_encode($data));

	}

//說明頁面
	function details($travel, $place, $i){
		$view_data = array(
											'title' => "旅遊與美食",
											"sub_title" => "Travel && Food",
											"description" => "旅遊途中一定要嘗試美食",
											"page" => "detals_main.php"
											);

		$where = array('id' => $i);
		$view_data['AM'] = $this->travel_model->get_once_all('attractions_message', $where);
		//AMT = attractions_message_total 特定景點留言有幾筆
		$view_data['AMT'] = count($view_data['AM']);

	if (isset($travel) && !empty($travel) && $travel == "attractions") {

		if (isset($place) && !empty($place) && $place == "pingtung") {
				// $view_data["place"] = "屏東";
				// $view_data["travel"] = "景點";
				//
				// $data = json_decode($this->pingtung());
				//
				// $view_data["Name"] = $data->data[$i]->Name;//名稱
				// $view_data["Introduction"] = $this->noempty("", $data->data[$i]->Introduction);//描述
				// $view_data["OpenTime"] = $this->noempty("開放時間：", $data->data[$i]->OpenTime);//開放時間
				// $view_data["Tel"] = $this->noempty("電話：", $data->data[$i]->Tel);//電話
				// $view_data["FullAddress"] = $this->noempty("地址：", $data->data[$i]->FullAddress);//地址
				// $view_data["Driving"] = $this->noempty("如何到達：", $data->data[$i]->Driving);//如何到達
				// $view_data["Title"] = $this->noempty("-", $data->data[$i]->Title);
				// $view_data["Images"] = $data->data[$i]->Images;//照片
				// $view_data["Count"] = count($data->data[$i]->Images);
				//
				// $GPS = $this->noempty("", $data->data[$i]->Coordinate);//GPS經緯度
				//
				// $config['center'] = $GPS;
				// $config['zoom'] = '16';
				// $this->googlemaps->initialize($config);
				//
				// $marker = array();
				// $marker['position'] = $GPS;
				// $this->googlemaps->add_marker($marker);
				// $view_data['map'] = $this->googlemaps->create_map();

			}else if(isset($place) && !empty($place) && $place == "kaohsiung"){

 				$view_data["place"] = "高雄";
 				$view_data["travel"] = "景點";
 				$url = file_get_contents("https://data.kcg.gov.tw/api/action/datastore_search?resource_id=92290ee5-6e61-456f-80c0-249eae2fcc97");
 				$data = json_decode($url);
 				// var_dump($data);
				$where = array('id' => $i);
				$datas = $this->travel_model->get_once($place, $where);

				$view_data["Id"] = $i;
 				$view_data["Name"] = $datas->Name;//名稱
 				$view_data["Introduction"] = $this->noempty("景點簡介：", $datas->Description);//描述
 				$view_data["OpenTime"] = $this->noempty("開放時間：", $datas->Opentime);//開放時間
 				$view_data["Tel"] = $this->noempty("電話：", $datas->Tel);//電話
 				$view_data["FullAddress"] = $this->noempty("地址：", $datas->Add);//地址
 				$PyPx = $datas->Py.",".$datas->Px;//Py經度Px緯度
 				$view_data["Driving"] = $this->noempty("如何到達：", $datas->Driving);//如何到達
 				$view_data["Images"] = $datas->Picture;//照片
 				$view_data["Count"] = count($datas->Picture);

 				$GPS = $this->noempty("", $PyPx);//GPS經緯度

 				$config['center'] = $GPS;
 				$config['zoom'] = '16';
 				$this->googlemaps->initialize($config);

 				$marker = array();
 				$marker['position'] = $GPS;
 				$this->googlemaps->add_marker($marker);
 				$view_data['map'] = $this->googlemaps->create_map();

			}else if(isset($place) && !empty($place) && $place == "tainan"){
				$view_data["place"] = "台南";
 				$view_data["travel"] = "景點";
				$url = file_get_contents("https://www.twtainan.net/opendata/attractionapi?category=0&township=0&type=JSON");
				$data = json_decode($url);
				$arrayData = new stdClass();//陣列轉換class後存自此變數
				foreach ($data as $key => $value) {
					$arrayData->data[$key] = $value;
				}

 				$view_data["Name"] = $arrayData->data[$i]->name;//名稱
 				$view_data["Introduction"] = $this->noempty("", $arrayData->data[$i]->introduction);//描述
 				$view_data["OpenTime"] = $this->noempty("開放時間：", $arrayData->data[$i]->opentime);//開放時間
 				$view_data["Tel"] = $this->noempty("電話：", $arrayData->data[$i]->tel);//電話
 				$view_data["FullAddress"] = $this->noempty("地址：", $arrayData->data[$i]->address);//地址
 				$PyPx = $arrayData->data[$i]->lat.",".$arrayData->data[$i]->long;//lat經度long緯度
 				$view_data["Driving"] = $this->noempty("如何到達：", "123");//如何到達
 				// $view_data["Title"] = $this->noempty("-", "");
 				$view_data["Images"] = " ";//照片
 				$view_data["Count"] = 1;

 				$GPS = $this->noempty("", $PyPx);//GPS經緯度

 				$config['center'] = $GPS;
 				$config['zoom'] = '16';
 				$this->googlemaps->initialize($config);

 				$marker = array();
 				$marker['position'] = $GPS;
 				$this->googlemaps->add_marker($marker);
 				$view_data['map'] = $this->googlemaps->create_map();
			}
		}//attractions

		if (isset($travel) && !empty($travel) && $travel == "food") {
			if (isset($place) && !empty($place) && $place == "pingtung") {

				$view_data["place"] = "屏東";
				$view_data["travel"] = "美食";

				$data = json_decode($this->pingtung());

				$view_data["Name"] = $data->data[$i]->Name;//名稱
				$view_data["Introduction"] = $this->noempty("", $data->data[$i]->Introduction);//描述
				$view_data["OpenTime"] = $this->noempty("開放時間：", $data->data[$i]->OpenTime);//開放時間
				$view_data["Tel"] = $this->noempty("電話：", $data->data[$i]->Tel);//電話
				$view_data["FullAddress"] = $this->noempty("地址：", $data->data[$i]->FullAddress);//地址
				$view_data["Driving"] = $this->noempty("如何到達：", $data->data[$i]->Traffic);//如何到達
				$view_data["Title"] = $this->noempty("-", $data->data[$i]->Title);
				$view_data["Images"] = $data->data[$i]->Images;//照片
				$view_data["Count"] = count($data->data[$i]->Images);

				$GPS = $this->noempty("", $data->data[$i]->Coordinate);//GPS經緯度

				$config['center'] = $GPS;

				$config['zoom'] = '16';
				$this->googlemaps->initialize($config);

				$marker = array();
				$marker['position'] = $GPS;
				$this->googlemaps->add_marker($marker);
				$view_data['map'] = $this->googlemaps->create_map();

			}else if (isset($place) && !empty($place) && $place == "kaohsiung") {
				$view_data["place"] = "高雄";
				$view_data["travel"] = "美食";
				$url = file_get_contents("https://data.kcg.gov.tw/api/action/datastore_search?resource_id=ed80314f-e329-4817-bfbb-2d6bc772659e");
				$data = json_decode($url);
				// var_dump($data);
				// $data->Img01 = $data->result->records[$i]->Picture1;
				// $data->Name01 = $data->result->records[$i]->Name;
				// $data->Title01 = $data->result->records[$i]->Picdescribe1;
				// $data->OpenTime01 = $data->result->records[$i]->Opentime;
				// $data->Tel01 = $data->result->records[$i]->Tel;
				// $data->FullAddress01 = $data->result->records[$i]->Add;

				$view_data["Name"] = $data->result->records[$i]->Name;//名稱
				$view_data["Introduction"] = $this->noempty("", $data->result->records[$i]->Description);//描述
				$view_data["OpenTime"] = $this->noempty("開放時間：", $data->result->records[$i]->Opentime);//開放時間
				$view_data["Tel"] = $this->noempty("電話：", $data->result->records[$i]->Tel);//電話
				$view_data["FullAddress"] = $this->noempty("地址：", $data->result->records[$i]->Add);//地址
				$PyPx = $data->result->records[$i]->Py.",".$data->result->records[$i]->Px;//Py經度Px緯度
				$view_data["Driving"] = $this->noempty("如何到達：", "123");//如何到達
				$view_data["Title"] = $this->noempty("-", $data->result->records[$i]->Picdescribe1);
				$view_data["Images"] = $data->result->records[$i]->Picture1;//照片
				$view_data["Count"] = count($data->result->records[$i]->Picture1);

				$GPS = $this->noempty("", $PyPx);//GPS經緯度

				$config['center'] = $GPS;
				$config['zoom'] = '16';
				$this->googlemaps->initialize($config);

				$marker = array();
				$marker['position'] = $GPS;
				$this->googlemaps->add_marker($marker);
				$view_data['map'] = $this->googlemaps->create_map();
			}
		}
		$this->load->view("layout", $view_data);
	}

	//20180325景點留言
	function AMessage(){

		$Id = $this->input->post('Id');
		$Place = $this->input->post('Place');
		$Post_Name = $this->input->post('Post_Name');
		$Post_Email = $this->input->post('Post_Email');
		$Message = $this->input->post('Message');

		$where = array('id' => $Id);
		if ($this->travel_model->get_once($Place, $where)) {
			date_default_timezone_set("Asia/Taipei");//設定時區

			$data = array(
				'am_id' => uniqid(),
				'id' => $Id,
				'place' => $Place,
				'name' => $Post_Name,
				'email' => $Post_Email,
				'message' => $Message,
				'create_date' => date('Y-m-d'),
				'create_time' => date('H:i:s')
			);
			$How = $this->travel_model->insert('attractions_message', $data);
			if ($How) {
				$dataResponse["sys_code"] = 200;
				$dataResponse["sys_msg"] = "留言成功";
			}else {
				$dataResponse["sys_code"] = 404;
				$dataResponse["sys_msg"] = "留言失敗...";
			}
			echo json_encode($dataResponse);
		}
	}

	function login(){
		$view_data = array(
			'title' => '歡迎登入',
			'form_title' => '登入',
			'button' => '登入',
			'path_title' => '沒有帳號嗎!',
			'path' => 'register',
			'page' => 'logins.php'
		);
		if ($this->travel_member->chk_login_status()) {
			redirect(base_url());
		}else {
			if ($this->input->post('rule') == 'login') {

				$email = $this->input->post('email');
				$pass = sha1($this->input->post('pass'));

				if($this->travel_member->chk_login_user($email, $pass)){
					$this->travel_member->do_login($email);
					$view_data['sys_code'] = 200;
					$view_data['sys_msg'] = '恭喜登入成功';
					redirect(base_url('memberInfo'));
				}else {
					$view_data['sys_code'] = 404;
					$view_data['sys_msg'] = '你是誰，賣來亂...?';
				}
			}
		}
		$this->load->view('login', $view_data);
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
							$view_data["sys_code"] = 200;
							$view_data["sys_msg"] = '新增成功！';
							$this->travel_member->do_login($dataArray['email']);
							redirect(base_url('memberInfo'));
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

	function logout(){
		if ($this->travel_member->logout()) {
			redirect(base_url());
		}
	}

	function forget(){
		$view_data = array(
			'title' => '忘記密碼了嗎',
			'form_title' => '請輸入資料',
			'button' => '查詢',
			'path_title' => '回登入囉~~~',
			'path' => 'login',
			'page' => 'forget.php'
		);
		if ($this->travel_member->chk_login_status()) {
			redirect(base_url(''));
		}else {
			if ($this->input->post('rule') == 'forget') {

				$dataArray = array(
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone')
				);

				if (!empty($dataArray['email']) && !empty($dataArray['phone'])) {
					$user = $this->travel_member->get_once_by_email($dataArray['email']);
					if($user['phone'] === $dataArray['phone']){

						$this->session->set_flashdata('news', $user['id']);
						$view_data['sys_code'] = 200;
						$view_data['sys_msg'] = '恭喜驗證完成，請嘗試輸入新密碼..?';

					}else {
						$view_data['sys_code'] = 404;
						$view_data['sys_msg'] = '信箱有人使用過囉...?';
					}
				}else {
					$view_data['sys_code'] = 404;
					$view_data['sys_msg'] = '表單上未填寫完成';
				}
			}else if($this->input->post('rule') == 'news'){

				$id = $this->input->post('id');
				$dataArray = array(
					'password' => $this->input->post('password')
				);

				if (!empty($dataArray['password']) && !empty($this->input->post('re-password') &&
					$dataArray['password']) == $this->input->post('re-password')) {

					$dataArray['password'] = sha1($dataArray['password']);

					if ($this->travel_member->update($id, $dataArray)) {
							$view_data["sys_code"] = "ok";
							$view_data["sys_msg"] = '密碼更新成功，請嘗試用新密碼登入。';
						}else {
							$view_data["sys_code"] = 404;
							$view_data["sys_msg"] = '發生錯誤，更新失敗';
						}

				}else {
					$view_data['sys_code'] = 404;
					$view_data['sys_msg'] = '密碼不一致哦~~~';
				}
			}
		}
		$this->load->view('login', $view_data);
	}

	//會員資訊20180403
	function memberInfo(){

		$view_data = array(
			'instructions' => '這裡可以修改自己的基本資料、查看曾經留言與喜愛的景點。',
			'page' => 'member.php'
		);

		if ($this->travel_member->chk_login_status()) {
			$user = $this->travel_member->get_once_by_email($this->session->userdata('user_email'));
			$Place = $this->travel_model->get_all('place');

			//用Email去搜尋，景景點留言，後存到AM=attractions_message
			$where = "email = "."'".$user['email']."'";
			//抓取留言訊息
			$AM = $this->travel_model->get_once_all('attractions_message', $where);

			$Att = array();

			for ($i=0; $i < count($AM); $i++) {
				for ($j=0; $j < count($Place); $j++) {
					array_push($Att, $this->travel_model->get_once_all($Place[$j]['en_place'], "id="."'".$AM[$i]['id']."'"));
					$Att[$i][$j]['ch_place'] = $Place[$j]['ch_place'];
				}
			}

			//景點資訊
			$view_data['Att'] = $Att;
			//訊息
			$view_data['AM'] = $AM;

			$view_data['user_name'] = $user['nickname'];
			$view_data['type'] = $user['type'];
			$view_data['user_email'] = $user['email'];
			$view_data['user_phone'] = $user['phone'];

			if ($this->input->post('rule') == "update") {
				$dataArray = $this->input->post('datas');

				if ($dataArray['type'] == 'normal') {
					if (!empty($dataArray['nickname']) && !empty($dataArray['email'])  && !empty($dataArray['password'])) {
						$dataArray['password'] = sha1($dataArray['password']);
						if($this->travel_member->update($user['id'], $dataArray)){
							$view_data['sys_title'] = '更新成功!';
							$view_data['sys_msg'] = '資料已經更新成功囉';
							$view_data['sys_status'] = 'success';
						}else {
							$view_data['sys_title'] = '更新失敗!';
							$view_data['sys_msg'] = '如要更新資料，請密碼也填寫';
							$view_data['sys_status'] = 'error';
						}
					}else {
						// 20180404
						if (empty($dataArray['password'])) {
							$view_data['sys_msg'] = '如要更新資料，請密碼也填寫';
						}else {
							$view_data['sys_msg'] = '姓名與Email必填，如要更新資料，請密碼也填寫';
						}
						$view_data['sys_title'] = '資料請填寫完整!';
						$view_data['sys_status'] = 'error';
					}
					echo json_encode($view_data);
				}else if ($dataArray['type'] == 'facebook') {

					if (!empty($dataArray['nickname']) && !empty($dataArray['email'])) {

						if($this->travel_member->update($user['id'], $dataArray)){
							$view_data['sys_title'] = '更新成功!';
							$view_data['sys_msg'] = '資料已經更新成功囉';
							$view_data['sys_status'] = 'success';
						}else {
							$view_data['sys_title'] = '更新失敗!';
							$view_data['sys_msg'] = '更新失敗';
							$view_data['sys_status'] = 'error';
						}
					}else {
						$view_data['sys_title'] = '更新失敗!';
						$view_data['sys_msg'] = '如沒要更新，請別亂!';
						$view_data['sys_status'] = 'error';
					}
					echo json_encode($view_data);
				}
				// 20180404
			}else {
				$this->load->view('layout', $view_data);
			}
		}else{
			redirect(base_url('/login'));
		}
	}

	//隱私權20180402
	function privacy(){
		$view_data = array(
			'title' => '隱私權政策',
			'page' => 'privacy.php'
		);
		$this->load->view('layout', $view_data);
	}

	function test(){
		$daraRespone = array();
		if ($this->travel_member->chk_login_status()) {
			$daraRespone = 200;
		}else {
			$daraRespone = 404;
		}
		echo json_encode($daraRespone);
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
