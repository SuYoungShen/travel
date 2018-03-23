<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Travel extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form'));
		$this->load->model('travel_model');
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

				$url = @file_get_contents("https://data.kcg.gov.tw/api/action/datastore_search?resource_id=92290ee5-6e61-456f-80c0-249eae2fcc97");

				if ($url) {//判斷是否抓取成功
					$data = json_decode($url);
					$data->title = "高雄景點";
					$data->Img01 = $data->result->records[0]->Picture1;
					$data->Name01 = $data->result->records[0]->Name;
					$data->OpenTime01 = $data->result->records[0]->Opentime;
					$data->Tel01 = $data->result->records[0]->Tel;
					$data->FullAddress01 = $data->result->records[0]->Add;
					$data->Total = count($data->result->records);
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
						}
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
							$data->Img01 = $data->result->records[0]->Picture1;
							$data->Name01 = $data->result->records[0]->Name;
							$data->OpenTime01 = $data->result->records[0]->Opentime;
							$data->Tel01 = $data->result->records[0]->Tel;
							$data->FullAddress01 = $data->result->records[0]->Add;
							$data->Total = count($data->result->records);
							$this->output->set_content_type('application/json')->set_output(json_encode($data));
						}
						//20180323
					}
				}else{//END $url
					//當api掛掉時，抓取資料庫資料
					$true = $this->travel_model->get_all($place);

					@$data = new stdClass();//陣列轉換class後存自此變數;@禁止顯示錯誤
					$data->Total = $this->travel_model->get_num($place);
					$data->title = "高雄景點";

					foreach ($true as $key => $value) {
						if ($key === 0) {
							$data->Id = $value['id'];
							$data->Img01 = $value['Picture'];
							$data->Name01 = $value['Name'];
							$data->OpenTime01 = $value['Opentime'];
							$data->Tel01 = $value['Tel'];
							$data->FullAddress01 = $value['Add'];
						}else {
							@$data->result->records[$key]->id = $value['id'];
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
			}
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

			
			}
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

	function details($travel, $place, $i){//說明頁面
		$view_data = array(
											'title' => "旅遊與美食",
											"sub_title" => "Travel && Food",
											"description" => "旅遊途中一定要嘗試美食",
											"page" => "detals_main.php"
											);
	if (isset($travel) && !empty($travel) && $travel == "attractions") {

		if (isset($place) && !empty($place) && $place == "pingtung") {
				$view_data["place"] = "屏東";
				$view_data["travel"] = "景點";

				$data = json_decode($this->pingtung());

				$view_data["Name"] = $data->data[$i]->Name;//名稱
				$view_data["Introduction"] = $this->noempty("", $data->data[$i]->Introduction);//描述
				$view_data["OpenTime"] = $this->noempty("開放時間：", $data->data[$i]->OpenTime);//開放時間
				$view_data["Tel"] = $this->noempty("電話：", $data->data[$i]->Tel);//電話
				$view_data["FullAddress"] = $this->noempty("地址：", $data->data[$i]->FullAddress);//地址
				$view_data["Driving"] = $this->noempty("如何到達：", $data->data[$i]->Driving);//如何到達
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

			}else if(isset($place) && !empty($place) && $place == "kaohsiung"){

 				$view_data["place"] = "高雄";
 				$view_data["travel"] = "景點";
 				$url = file_get_contents("https://data.kcg.gov.tw/api/action/datastore_search?resource_id=92290ee5-6e61-456f-80c0-249eae2fcc97");
 				$data = json_decode($url);
 				// var_dump($data);
				$where = array('id' => $i);
				$datas = $this->travel_model->get_once($place, $where);

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

	function noempty($title, $value){//不等於空
		$data = !empty($value)? $title.$value : "";
		return $data;
	}
}
?>
