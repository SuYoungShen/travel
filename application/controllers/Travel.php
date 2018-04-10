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

		$view_data['sys_code'] = 200;
		$this->load->view("layout", $view_data);
	}

	function attractions_place(){
		$place = $this->travel_model->get_all('place');

		$this->output->set_content_type('application/json')->set_output(json_encode($place));
	}

	function food_place(){

		$place = $this->travel_model->get_all('place');

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

					//20180324
					date_default_timezone_set("Asia/Taipei");//設定時區

					//20180323
					$Today_Date = date('Y-m-d');//今天日期

					$where = "type = 0";//景點
					if($this->travel_model->get_once($place, $where) === null){//判斷資料庫有無資料

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
							$where = "type = 0";//0=景點；1=美食
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "高雄景點";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));//
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
								$where = "id =".'"'.$id[$key]['id'].'"';

								$true = $this->travel_model->update($place, $datas, $where);
							}
							if($true){

								$where = "type = 0";//0=景點；1=美食
								$datas = $this->travel_model->get_once_all($place, $where);
								$datas["total"] = count($datas);
								$datas["title"] = "高雄景點";

								$this->output->set_content_type('application/json')->set_output(json_encode($datas));
								}else {
									$res['sys_code'] = 404;
									$res['sys_msg'] = "更新資料庫失敗";
									$this->output->set_content_type('application/json')->set_output(json_encode($res));
							}
						}else {//END 比對時間

							$where = "type = 0";//0=景點；1=美食
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "高雄景點";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));
						}
						//20180323
					}
				}else{//END $url
					//當api掛掉時，抓取資料庫資料
					$where = "type = 0";//0=景點；1=美食
					$datas = $this->travel_model->get_once_all($place, $where);
					$datas["total"] = count($datas);
					$datas["title"] = "高雄景點";

					$this->output->set_content_type('application/json')->set_output(json_encode($datas));

				}
			}else if(isset($travel) && !empty($travel) && $travel == "food"){
				$url = file_get_contents("https://data.kcg.gov.tw/api/action/datastore_search?resource_id=ed80314f-e329-4817-bfbb-2d6bc772659e");

				if ($url) {//判斷是否抓取成功
					$data = json_decode($url);

					//20180324
					date_default_timezone_set("Asia/Taipei");//設定時區

					//20180323
					$Today_Date = date('Y-m-d');//今天日期
					$where = "Type = 1";

					if($this->travel_model->get_once($place, $where) === null){//判斷資料庫有無資料

						foreach ($data->result->records as $key => $value) {
							$datas = array(
								'id' => uniqid(),
								'Picture' => $value->Picture1,
								'name' => $value->Name,
								'Description'=> $value->Description,
								'Opentime' => $value->Opentime,
								'Tel' => $value->Tel,
								'Add' => $value->Add,
								'Type' => 1,
								'Py' => $value->Py,
								'Px' => $value->Px,
								'Update_Date' => $Today_Date
							);
							$true = $this->travel_model->insert($place, $datas);
						}//end foreach

						if($true){
							$where = "Type = 1";//0=景點；1=美食
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "高雄美食";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));//
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
									$where = "id =".'"'.$id[$key]['id'].'"';

									$true = $this->travel_model->update($place, $datas, $where);
								}
								if($true){

									$where = "Type = 0";//0=景點；1=美食
									$datas = $this->travel_model->get_once_all($place, $where);
									$datas["total"] = count($datas);
									$datas["title"] = "高雄景點";

									$this->output->set_content_type('application/json')->set_output(json_encode($datas));
								}else {
									$res['sys_code'] = 404;
									$res['sys_msg'] = "更新資料庫失敗";
									$this->output->set_content_type('application/json')->set_output(json_encode($res));
								}
							}else {//END 比對時間

								$where = "Type = 1";//0=景點；1=美食
								$datas = $this->travel_model->get_once_all($place, $where);
								$datas["total"] = count($datas);
								$datas["title"] = "高雄景點";

								$this->output->set_content_type('application/json')->set_output(json_encode($datas));
							}
							//20180323
						}
					}else{//END $url
						//當api掛掉時，抓取資料庫資料
						$where = "Type = 1";//0=景點；1=美食
						$datas = $this->travel_model->get_once_all($place, $where);
						$datas["total"] = count($datas);
						$datas["title"] = "高雄景點";

						$this->output->set_content_type('application/json')->set_output(json_encode($datas));

					}
				}//food

				// $this->output->set_content_type('application/json')->set_output(json_encode($datas));

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

	//有更新過 in 20180409
	function tainan(){//沒照片...

		$base = base_url().uri_string();
		if (isset($_POST["place"]) && !empty($_POST["place"]) && $_POST["place"] == "tainan") {

			$place = $_POST["place"];
			$travel = $_POST["travel"];

			if (isset($travel) && !empty($travel) && $travel == "attractions") {

				$url = file_get_contents("https://www.twtainan.net/opendata/attractionapi?category=0&township=0&type=JSON");
				if ($url) {//判斷是否抓取成功
					$data = json_decode($url);

					//20180324
					date_default_timezone_set("Asia/Taipei");//設定時區

					//20180323
					$Today_Date = date('Y-m-d');//今天日期

					$where = "Type = 0";//景點 in 20180409
					if($this->travel_model->get_once($place, $where) === null){//判斷資料庫有無資料

						foreach ($data as $key => $value) {
							$datas = array(
								'id' => uniqid(),
								'Name' => $value->name,
								'Description'=> $value->introduction,
								'Opentime' => $value->opentime,
								'Tel' => $value->tel,
								'Add' => $value->address,
								'Driving' => "",
								'Py' => $value->lat,
								'Px' => $value->long,
								'Update_Date' => $Today_Date
							);
							$true = $this->travel_model->insert($place, $datas);
						}//end foreach

						if($true){
							$where = "Type = 0";//0=景點；1=美食 in 20180409
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "台南景點";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));//
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

							foreach ($data as $key => $value) {
								$datas = array(
									'Name' => $value->name,
									'Description'=> $value->introduction,
									'Opentime' => $value->opentime,
									'Tel' => $value->tel,
									'Add' => $value->address,
									'Driving' => "",
									'Py' => $value->lat,
									'Px' => $value->long,
									'Update_Date' => $Today_Date
								);

								$where = "id =".'"'.$id[$key]['id'].'"';

								$true = $this->travel_model->update($place, $datas, $where);
							}
							if($true){

								$where = "Type = 0";//0=景點；1=美食
								$datas = $this->travel_model->get_once_all($place, $where);
								$datas["total"] = count($datas);
								$datas["title"] = "台南景點";

								$this->output->set_content_type('application/json')->set_output(json_encode($datas));
								}else {
									$res['sys_code'] = 404;
									$res['sys_msg'] = "更新資料庫失敗";
									$this->output->set_content_type('application/json')->set_output(json_encode($res));
							}
						}else {//END 比對時間

							$where = "Type = 0";//0=景點；1=美食
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "台南景點";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));
						}
						//20180323
					}
				}else{//END $url
					//當api掛掉時，抓取資料庫資料
					$where = "Type = 0";//0=景點；1=美食
					$datas = $this->travel_model->get_once_all($place, $where);
					$datas["total"] = count($datas);
					$datas["title"] = "台南景點";

					$this->output->set_content_type('application/json')->set_output(json_encode($datas));

				}

			}else if(isset($travel) && !empty($travel) && $travel == "food"){
				$url = file_get_contents("https://www.twtainan.net/opendata/consumeApi?category=0&township=0&type=JSON");

				//Insert 以下程式 in 20180409
				if ($url) {//判斷是否抓取成功
					$data = json_decode($url);

					date_default_timezone_set("Asia/Taipei");//設定時區

					$Today_Date = date('Y-m-d');//今天日期

					$where = "Type = 1";//景點
					if($this->travel_model->get_once($place, $where) === null){//判斷資料庫有無資料

						foreach ($data as $key => $value) {
							$datas = array(
								'id' => uniqid(),
								'Picture' => "",
								'Name' => $value->name,
								'Description'=> $value->introduction,
								'Opentime' => $value->opentime,
								'Tel' => $value->tel,
								'Add' => $value->address,
								'Driving' => "",
								'Type' => 1,
								'Py' => $value->lat,
								'Px' => $value->long,
								'Update_Date' => $Today_Date
							);
							$true = $this->travel_model->insert($place, $datas);
						}//end foreach
						// $true = true;

						if($true){
							$where = "Type = 1";//0=景點；1=美食 in 20180409
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "台南美食";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));
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

							foreach ($data as $key => $value) {
								$datas = array(
									'Name' => $value->name,
									'Description'=> $value->introduction,
									'Opentime' => $value->opentime,
									'Tel' => $value->tel,
									'Add' => $value->address,
									'Driving' => "",
									'Py' => $value->lat,
									'Px' => $value->long,
									'Update_Date' => $Today_Date
								);
								$where = "id =".'"'.$id[$key]['id'].'"'."&& Type = 1";

								$true = $this->travel_model->update($place, $datas, $where);
							}
							if($true){

								$where = "Type = 1";//0=景點；1=美食
								$datas = $this->travel_model->get_once_all($place, $where);
								$datas["total"] = count($datas);
								$datas["title"] = "台南景點";

								$this->output->set_content_type('application/json')->set_output(json_encode($datas));
								}else {
									$res['sys_code'] = 404;
									$res['sys_msg'] = "更新資料庫失敗";
									$this->output->set_content_type('application/json')->set_output(json_encode($res));
							}
						}else {//END 比對時間

							$where = "Type = 1";//0=景點；1=美食
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "台南美食";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));
						}
						//20180323
					}
				}else{//END $url
					//當api掛掉時，抓取資料庫資料
					$where = "Type = 1";//0=景點；1=美食
					$datas = $this->travel_model->get_once_all($place, $where);
					$datas["total"] = count($datas);
					$datas["title"] = "台南美食";

					$this->output->set_content_type('application/json')->set_output(json_encode($datas));

				}
			}//End Food
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

	//新增以下程式 in 20180410 嘉義縣
	function chiayi(){
		$this->load->helper('text');

		$base = base_url().uri_string();
		if (isset($_POST["place"]) && !empty($_POST["place"]) && $_POST["place"] == "chiayi") {

			$place = $_POST["place"];
			$travel = $_POST["travel"];

			if (isset($travel) && !empty($travel) && $travel == "attractions") {

				$url = file_get_contents(base_url('assets/file/chiayi_att.json'));
				if ($url) {//判斷是否抓取成功
					$data = json_decode($url);

					date_default_timezone_set("Asia/Taipei");//設定時區

					$Today_Date = date('Y-m-d');//今天日期

					$where = "Type = 0";//景點
					if($this->travel_model->get_once($place, $where) === null){//判斷資料庫有無資料

						foreach ($data as $key => $value) {
							$value->poi_bannerPicURL = str_replace("../../", "http://opendata.dazone.tw/", $value->poi_bannerPicURL);

							$datas = array(
								'id' => uniqid(),
								'Picture' => $value->poi_bannerPicURL,
								'Name' => $value->poi_name,
								'Description'=> $value->poi_fulldesc,
								'Opentime' => $value->poi_openhour,
								'Tel' => $value->poi_phone,
								'Add' => empty($value->poi_address)?$value->poi_publicTraffic:$value->poi_address,
								'Driving' => empty($value->poi_trafficInfo)?$value->poi_driveInfo:$value->poi_trafficInfo,
								'Py' => $value->poi_latitude,
								'Px' => $value->poi_longitude,
								'Update_Date' => $Today_Date
							);
							$true = $this->travel_model->insert($place, $datas);
						}//end foreach

						if($true){
							$where = "Type = 0";//0=景點；1=美食
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "嘉義縣景點";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));//
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

							foreach ($data as $key => $value) {
								$value->poi_bannerPicURL = str_replace("../../", "http://opendata.dazone.tw/", $value->poi_bannerPicURL);

								$datas = array(
									'Picture' => $value->poi_bannerPicURL,
									'Name' => $value->poi_name,
									'Description'=> $value->poi_fulldesc,
									'Opentime' => $value->poi_openhour,
									'Tel' => $value->poi_phone,
									'Add' => empty($value->poi_address)?$value->poi_publicTraffic:$value->poi_address,
									'Driving' => empty($value->poi_trafficInfo)?$value->poi_driveInfo:$value->poi_trafficInfo,
									'Py' => $value->poi_latitude,
									'Px' => $value->poi_longitude,
									'Update_Date' => $Today_Date
								);
								$where = "id =".'"'.$id[$key]['id'].'"';

								$true = $this->travel_model->update($place, $datas, $where);
							}
							if($true){

								$where = "Type = 0";//0=景點；1=美食
								$datas = $this->travel_model->get_once_all($place, $where);
								$datas["total"] = count($datas);
								$datas["title"] = "嘉義縣景點";

								$this->output->set_content_type('application/json')->set_output(json_encode($datas));
								}else {
									$res['sys_code'] = 404;
									$res['sys_msg'] = "更新資料庫失敗";
									$this->output->set_content_type('application/json')->set_output(json_encode($res));
							}
						}else {//END 比對時間

							$where = "Type = 0";//0=景點；1=美食
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "嘉義縣景點";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));
						}
					}
				}else{//END $url
					//當api掛掉時，抓取資料庫資料
					$where = "Type = 0";//0=景點；1=美食
					$datas = $this->travel_model->get_once_all($place, $where);
					$datas["total"] = count($datas);
					$datas["title"] = "嘉義縣景點";

					$this->output->set_content_type('application/json')->set_output(json_encode($datas));

				}

			}else if(isset($travel) && !empty($travel) && $travel == "food"){
				$url = file_get_contents(base_url("assets/file/chiayi_food.json"));

				if ($url) {//判斷是否抓取成功
					$data = json_decode($url);

					date_default_timezone_set("Asia/Taipei");//設定時區

					$Today_Date = date('Y-m-d');//今天日期

					$where = "Type = 1";//景點
					if($this->travel_model->get_once($place, $where) === null){//判斷資料庫有無資料

						foreach ($data as $key => $value) {

							$value->shopBannerImgURL = str_replace("../../", "http://opendata.dazone.tw/", $value->shopBannerImgURL);
							$datas = array(
								'id' => uniqid(),
								'Picture' => $value->shopBannerImgURL,
								'Name' => $value->shop_name,
								'Description'=> "",
								'Opentime' => "",
								'Tel' => $value->shop_phone,
								'Add' => $value->shop_address,
								'Driving' => "",
								'Type' => 1,
								'Py' => $value->shop_latitude,
								'Px' => $value->shop_longitude,
								'Update_Date' => $Today_Date
							);

							$true = $this->travel_model->insert($place, $datas);
						}//end foreach

						if($true){
							$where = "Type = 1";//0=景點；1=美食
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "嘉義縣美食";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));
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

							foreach ($data as $key => $value) {
								$datas = array(
									'Name' => $value->name,
									'Description'=> $value->introduction,
									'Opentime' => $value->opentime,
									'Tel' => $value->tel,
									'Add' => $value->address,
									'Driving' => "",
									'Py' => $value->lat,
									'Px' => $value->long,
									'Update_Date' => $Today_Date
								);
								$where = "id =".'"'.$id[$key]['id'].'"';

								$true = $this->travel_model->update($place, $datas, $where);
							}
							if($true){

								$where = "Type = 1";//0=景點；1=美食
								$datas = $this->travel_model->get_once_all($place, $where);
								$datas["total"] = count($datas);
								$datas["title"] = "嘉義縣美食";

								$this->output->set_content_type('application/json')->set_output(json_encode($datas));
								}else {
									$res['sys_code'] = 404;
									$res['sys_msg'] = "更新資料庫失敗";
									$this->output->set_content_type('application/json')->set_output(json_encode($res));
							}
						}else {//END 比對時間

							$where = "Type = 1";//0=景點；1=美食
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "嘉義縣美食";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));
						}
					}
				}else{//END $url
					//當api掛掉時，抓取資料庫資料
					$where = "Type = 1";//0=景點；1=美食
					$datas = $this->travel_model->get_once_all($place, $where);
					$datas["total"] = count($datas);
					$datas["title"] = "嘉義縣美食";

					$this->output->set_content_type('application/json')->set_output(json_encode($datas));

				}
			}//End Food
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

	//新增以下程式 in 20180410 嘉義市
	function chiayis(){
		$this->load->helper('text');

		$base = base_url().uri_string();
		if (isset($_POST["place"]) && !empty($_POST["place"]) && $_POST["place"] == "chiayis") {

			$place = $_POST["place"];
			$travel = $_POST["travel"];

			if (isset($travel) && !empty($travel) && $travel == "attractions") {

				$url = simplexml_load_file('http://travel_old.chiayi.gov.tw/xml/C1_376600000A.xml');
				$count = count($url->Infos->Info);//計算總比數
				$data = array();
				for ($i=0; $i < $count; $i++) {
					foreach($url->Infos->Info[$i]->attributes() as $key => $state)
					{
						$data[$key][$i] = $state;
					}
				}

				if ($url) {//判斷是否抓取成功

					date_default_timezone_set("Asia/Taipei");//設定時區

					$Today_Date = date('Y-m-d');//今天日期

					$where = "Type = 0";//景點
					if($this->travel_model->get_once($place, $where) === null){//判斷資料庫有無資料

						for ($i=0; $i < $count; $i++) {
							$datas = array(
								'id' => uniqid(),
								'Picture' => "",
								'Name' => $data["Name"][$i],
								'Description'=> $data["Toldescribe"][$i],
								'Opentime' =>  $data["Opentime"][$i],
								'Tel' =>  $data["Tel"][$i],
								'Add' => $data["Add"][$i],
								'Driving' => "",
								'Py' => $data["Py"][$i],
								'Px' => $data["Px"][$i],
								'Update_Date' => $Today_Date
							);
							$true = $this->travel_model->insert($place, $datas);
						}//End For

						if($true){
							$where = "Type = 0";//0=景點；1=美食
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "嘉義市景點";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));//
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

							for ($i=0; $i < $count; $i++) {
								$datas = array(
									'Picture' => "",
									'Name' => $data["Name"][$i],
									'Description'=> $data["Toldescribe"][$i],
									'Opentime' =>  $data["Opentime"][$i],
									'Tel' =>  $data["Tel"][$i],
									'Add' => $data["Add"][$i],
									'Driving' => "",
									'Py' => $data["Py"][$i],
									'Px' => $data["Px"][$i],
									'Update_Date' => $Today_Date
								);
								$where = "id =".'"'.$id[$i]['id'].'"';
								$true = $this->travel_model->update($place, $datas, $where);
							}//End For

							if($true){

								$where = "Type = 0";//0=景點；1=美食
								$datas = $this->travel_model->get_once_all($place, $where);
								$datas["total"] = count($datas);
								$datas["title"] = "嘉義市景點";

								$this->output->set_content_type('application/json')->set_output(json_encode($datas));
								}else {
									$res['sys_code'] = 404;
									$res['sys_msg'] = "更新資料庫失敗";
									$this->output->set_content_type('application/json')->set_output(json_encode($res));
							}
						}else {//END 比對時間

							$where = "Type = 0";//0=景點；1=美食
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "嘉義市景點";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));
						}

					}
				}else{//END $url
					//當api掛掉時，抓取資料庫資料
					$where = "Type = 0";//0=景點；1=美食
					$datas = $this->travel_model->get_once_all($place, $where);
					$datas["total"] = count($datas);
					$datas["title"] = "嘉義市景點";

					$this->output->set_content_type('application/json')->set_output(json_encode($datas));

				}

			}else if(isset($travel) && !empty($travel) && $travel == "food"){//add in 20180410

				$url = simplexml_load_file('http://travel_old.chiayi.gov.tw/xml/C3_376600000A.xml');
				$count = count($url->Infos->Info);//計算總比數
				$data = array();
				for ($i=0; $i < $count; $i++) {
					foreach($url->Infos->Info[$i]->attributes() as $key => $state)
					{
						$data[$key][$i] = $state;
					}
				}

				if ($url) {//判斷是否抓取成功

					date_default_timezone_set("Asia/Taipei");//設定時區

					$Today_Date = date('Y-m-d');//今天日期

					$where = "Type = 1";//景點
					if($this->travel_model->get_once($place, $where) === null){//判斷資料庫有無資料

						for ($i=0; $i < $count; $i++) {
							$datas = array(
								'id' => uniqid(),
								'Picture' => "",
								'Name' => $data["Name"][$i],
								'Description'=> $data["Description"][$i],
								'Opentime' =>  $data["Opentime"][$i],
								'Tel' =>  $data["Tel"][$i],
								'Add' => $data["Add"][$i],
								'Driving' => "",
								'Type' => 1,
								'Py' => $data["Py"][$i],
								'Px' => $data["Px"][$i],
								'Update_Date' => $Today_Date
							);
							$true = $this->travel_model->insert($place, $datas);
						}//End For

						if($true){
							$where = "Type = 1";//0=景點；1=美食
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "嘉義市美食";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));//
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

							for ($i=0; $i < $count; $i++) {
								$datas = array(
								'Picture' => "",
								'Name' => $data["Name"][$i],
								'Description'=> $data["Description"][$i],
								'Opentime' =>  $data["Opentime"][$i],
								'Tel' =>  $data["Tel"][$i],
								'Add' => $data["Add"][$i],
								'Driving' => "",
								'Py' => $data["Py"][$i],
								'Px' => $data["Px"][$i],
								'Update_Date' => $Today_Date
								);
								$where = "id =".'"'.$id[$i]['id'].'"';
								$true = $this->travel_model->update($place, $datas, $where);
							}//End For

							if($true){

								$where = "Type = 1";//0=景點；1=美食
								$datas = $this->travel_model->get_once_all($place, $where);
								$datas["total"] = count($datas);
								$datas["title"] = "嘉義市美食";

								$this->output->set_content_type('application/json')->set_output(json_encode($datas));
							}else {
								$res['sys_code'] = 404;
								$res['sys_msg'] = "更新資料庫失敗";
								$this->output->set_content_type('application/json')->set_output(json_encode($res));
							}
						}else {//END 比對時間

							$where = "Type = 1";//0=景點；1=美食
							$datas = $this->travel_model->get_once_all($place, $where);
							$datas["total"] = count($datas);
							$datas["title"] = "嘉義市美食";

							$this->output->set_content_type('application/json')->set_output(json_encode($datas));
						}

					}
				}else{//END $url
					//當api掛掉時，抓取資料庫資料
					$where = "Type = 1";//0=景點；1=美食
					$datas = $this->travel_model->get_once_all($place, $where);
					$datas["total"] = count($datas);
					$datas["title"] = "嘉義市景點";

					$this->output->set_content_type('application/json')->set_output(json_encode($datas));

				}
			}//End Food
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

		}else if($base == base_url('chiayis/test')){

			$url = simplexml_load_file('http://travel_old.chiayi.gov.tw/xml/C3_376600000A.xml');
			$count = count($url->Infos->Info);//計算總比數
			$data = array();


				for ($i=0; $i < $count; $i++) {
					foreach($url->Infos->Info[$i]->attributes() as $key => $state)
					{
						$data[$key][$i] = $state;
					}
				}

			echo "<pre>";
			var_dump($data);
			echo "</pre>";

			// $this->output->set_content_type('application/json')->set_output(json_encode($data));

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

		$where = array('id' => $i);//景點編號 in 20180408
		$view_data['AM'] = $this->travel_model->get_once_all('attractions_message', $where);
		//AMT = attractions_message_total 特定景點留言有幾筆
		$view_data['AMT'] = count($view_data['AM']);

		$where = array(
			'place_id' => $i,//景點編號
			'place' => $place,
			'user_id' => $this->session->userdata('user_id')
		);//加入最愛用 in 20180408
		$view_data['user_like'] = $this->travel_model->get_once('user_like', $where);
		//總共有幾筆 in 20180409
		$view_data['user_like_total'] = count($this->travel_model->get_once('user_like', $where));

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

				$where = array(
					'id' => $i,
					'type' => 0
				);
				$datas = $this->travel_model->get_once($place, $where);

				$view_data["Id"] = $i;//景點ID
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

				$where = array(
					'id' => $i,
					'type' => 0
				);
				$datas = $this->travel_model->get_once($place, $where);

				$view_data["Id"] = $i;//景點ID
				$view_data["Name"] = $datas->Name;//名稱
				$view_data["Introduction"] = $this->noempty("景點簡介：", $datas->Description);//描述
				$view_data["OpenTime"] = $this->noempty("開放時間：", $datas->Opentime);//開放時間
				$view_data["Tel"] = $this->noempty("電話：", $datas->Tel);//電話
				$view_data["FullAddress"] = $this->noempty("地址：", $datas->Add);//地址
				$PyPx = $datas->Py.",".$datas->Px;//Py經度Px緯度
				$view_data["Driving"] = $this->noempty("如何到達：", "");//如何到達

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
			}else if(isset($place) && !empty($place) && $place == "chiayis"){//Add in 20180410
				$view_data["place"] = "嘉義市";
 				$view_data["travel"] = "景點";

				$where = array(
					'id' => $i,
					'type' => 0
				);
				$datas = $this->travel_model->get_once($place, $where);

				$view_data["Id"] = $i;//景點ID
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

				$where = array(
					'id' => $i,
					'type' => 0
				);
				$datas = $this->travel_model->get_once($place, $where);

				$view_data["Id"] = $i;//景點ID
				$view_data["Name"] = $datas->Name;//名稱
				$view_data["Introduction"] = $this->noempty("景點簡介：", $datas->Description);//描述
				$view_data["OpenTime"] = $this->noempty("開放時間：", $datas->Opentime);//開放時間
				$view_data["Tel"] = $this->noempty("電話：", $datas->Tel);//電話
				$view_data["FullAddress"] = $this->noempty("地址：", $datas->Add);//地址
				$PyPx = $datas->Py.",".$datas->Px;//Py經度Px緯度
				$view_data["Driving"] = $this->noempty("如何到達：", "");//如何到達

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

				$where = array(
					'id' => $i,
					'type' => 1
				);
				$datas = $this->travel_model->get_once($place, $where);

				$view_data["Id"] = $i;//景點ID
				$view_data["Name"] = $datas->Name;//名稱
				$view_data["Introduction"] = $this->noempty("景點簡介：", $datas->Description);//描述
				$view_data["OpenTime"] = $this->noempty("開放時間：", $datas->Opentime);//開放時間
				$view_data["Tel"] = $this->noempty("電話：", $datas->Tel);//電話
				$view_data["FullAddress"] = $this->noempty("地址：", $datas->Add);//地址
				$PyPx = $datas->Py.",".$datas->Px;//Py經度Px緯度
				$view_data["Driving"] = $this->noempty("如何到達：", "");//如何到達
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
			}else if (isset($place) && !empty($place) && $place == "tainan") {
				//新增以下程式 in 20180409
				$view_data["place"] = "台南";
				$view_data["travel"] = "美食";

				$where = array(
					'id' => $i,
					'type' => 1
				);
				$datas = $this->travel_model->get_once($place, $where);

				$view_data["Id"] = $i;//景點ID
				$view_data["Name"] = $datas->Name;//名稱
				$view_data["Introduction"] = $this->noempty("景點簡介：", $datas->Description);//描述
				$view_data["OpenTime"] = $this->noempty("開放時間：", $datas->Opentime);//開放時間
				$view_data["Tel"] = $this->noempty("電話：", $datas->Tel);//電話
				$view_data["FullAddress"] = $this->noempty("地址：", $datas->Add);//地址
				$PyPx = $datas->Py.",".$datas->Px;//Py經度Px緯度
				$view_data["PyPx"] = false;//用於沒經緯度時 in 20180409
				$view_data["Driving"] = $this->noempty("如何到達：", "");//如何到達
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
			}else if (isset($place) && !empty($place) && $place == "chiayis") {//add in 20180410
				$view_data["place"] = "嘉義縣美食";
				$view_data["travel"] = "美食";

				$where = array(
					'id' => $i,
					'type' => 1
				);
				$datas = $this->travel_model->get_once($place, $where);

				$view_data["Id"] = $i;//景點ID
				$view_data["Name"] = $datas->Name;//名稱
				$view_data["Introduction"] = $this->noempty("景點簡介：", $datas->Description);//描述
				$view_data["OpenTime"] = $this->noempty("開放時間：", $datas->Opentime);//開放時間
				$view_data["Tel"] = $this->noempty("電話：", $datas->Tel);//電話
				$view_data["FullAddress"] = $this->noempty("地址：", $datas->Add);//地址
				$PyPx = $datas->Py.",".$datas->Px;//Py經度Px緯度
				$view_data["Driving"] = $this->noempty("如何到達：", "");//如何到達
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
			}else if (isset($place) && !empty($place) && $place == "chiayi") {//add in 20180410
				$view_data["place"] = "嘉義縣";
				$view_data["travel"] = "美食";

				$where = array(
					'id' => $i,
					'type' => 1
				);
				$datas = $this->travel_model->get_once($place, $where);

				$view_data["Id"] = $i;//景點ID
				$view_data["Name"] = $datas->Name;//名稱
				$view_data["Introduction"] = $this->noempty("景點簡介：", $datas->Description);//描述
				$view_data["OpenTime"] = $this->noempty("開放時間：", $datas->Opentime);//開放時間
				$view_data["Tel"] = $this->noempty("電話：", $datas->Tel);//電話
				$view_data["FullAddress"] = $this->noempty("地址：", $datas->Add);//地址
				$PyPx = $datas->Py.",".$datas->Px;//Py經度Px緯度
				$view_data["Driving"] = $this->noempty("如何到達：", "");//如何到達
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
			}
		}
		$this->load->view("layout", $view_data);
	}

	//20180325景點留言
	function AMessage(){

		$Id = $this->input->post('Id');//景點id
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
							$this->send_mail();//20180411 新增
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

			$Att = array();//景點留言

			foreach ($AM as $keys => $values) {
				array_push($Att, $this->travel_model->get_once_all($values['place'],  array('id' => 	$values['id'])));

				foreach ($Place as $key => $value) {
					if ($value['en_place'] == $values['place']) {
						$Att[$keys]['ch_place'] = $value['ch_place'];
					}
				}
			}

			//抓取全部的最愛 in 20180409
			$where = "user_id = "."'".$user['id']."'";
			$user_like = $this->travel_model->get_once_all('user_like', $where);

			$Att_like = array();//我得最愛景點

			foreach ($user_like as $keys => $values) {
				array_push($Att_like, $this->travel_model->get_once_all($values['place'],  array('id' => 	$values['place_id'])));

				foreach ($Place as $key => $value) {
					if ($value['en_place'] == $values['place']) {
						$Att_like[$keys]['ch_place'] = $value['ch_place'];
					}
				}
			}

			//景點資訊
			$view_data['Att'] = $Att;
			//訊息
			$view_data['AM'] = $AM;

			//我得最愛景點資訊
			$view_data['Att_like'] = $Att_like;
			//我得最愛
			$view_data['user_like'] = $user_like;

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
		$this->email->to($this->session->userdata('user_email'));//20180411 更改

		$this->email->subject("歡迎".$this->session->userdata('user_name')."加入!");//20180411 更改
		$this->email->message("
		<h2 style='color:red;font-weight:bold;'>恭喜".$this->session->userdata('user_name')."註冊成功</h2>
		<p>您可透過連結到網站<a href='https://sushentravel.tk/'>https://sushentravel.tk/</a></p>
		");//20180411 更改

		$this->email->send();
	}
}
?>
