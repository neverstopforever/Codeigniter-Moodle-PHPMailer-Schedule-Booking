<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *@property TarifasTModel $TarifasTModel
 *@property TarifasLModel $TarifasLModel
 */
class Rates extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('user_agent');
		$this->lang->load('rates', $this->data['lang']);
		$this->load->library('form_validation');
		if(!$this->session->userdata('loggedIn')){
			redirect('/auth/login/', 'refresh');
		}
	}
	
	public function index(){
        $this->lang->load('quicktips', $this->data['lang']);
        $this->load->model('TarifasTModel');
		$this->load->model('TarifasLModel');

		$this->data['page'] = 'rates';
		$this->layouts->add_includes('js', 'app/js/rates/index.js');
		$this->data['rates'] = $this->TarifasTModel->getRates();

		$this->data['fees'] = $this->TarifasLModel->getFees();
//		printr($this->data['rates']);
//		printr($this->data['fees']);
//		die;
		$this->layouts->view('rates/indexView', $this->data);
	}



	public function getFees(){
		if($this->input->is_ajax_request()){
			$this->load->model('TarifasLModel');
			$rate_id = $this->input->post('rate_id', true);
			$fees = array();
			if(!empty($rate_id)) {
				$fees = $this->TarifasLModel->getFees($rate_id);
			}
			echo json_encode(array('data' => $fees));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}
	public function addRate(){
		if($this->input->is_ajax_request()){
			$this->load->model('TarifasTModel');
			$rate_name = $this->input->post('rate_name', true);
			$last_id = $this->TarifasTModel->insertRate($rate_name);
			echo json_encode(array('rate_id' => $last_id));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function editRate(){
			if($this->input->is_ajax_request()){
				$this->load->model('TarifasTModel');
				$rate_name = $this->input->post('rate_name', true);
				$rate_id = $this->input->post('rate_id', true);
				$result = false;
				if(!empty($rate_name) &&  !empty($rate_id)) {
					$result = $this->TarifasTModel->updateRate($rate_id, $rate_name);
				}
				echo json_encode(array('success' => $result));
				exit;
			}else{
				$this->layouts->view('error_404',$this->data, 'error_404');
			}
	}

	public function addFee(){
		if($this->input->is_ajax_request()){
			$this->load->model('TarifasLModel');
			$interval_array = array('1','2','3','4','6','12');
			$subject = $this->input->post('subject', true);
			$fee_amount = $this->input->post('fee_amount', true);
			$payment_date_first = $this->input->post('payment_date_first', true);
			$rate_id = $this->input->post('rate_id', true);
			$fees_number = $this->input->post('fees_number', true);
			$interval_between_fees = $this->input->post('interval_between_fees', true);
			$fees = $this->input->post('fees_tax', true);
			$total_fees = $this->input->post('fees_amount_tax', true);
			$total_amount = $this->input->post('fees_total_amount', true);

			$result = false;
			$added_data = array();
			if(!empty($subject) &&  !empty($fee_amount) && $this->checkdate($payment_date_first) && !empty($rate_id) && !empty($fees_number)){
				if($fees_number > 1 && $fees_number < 1000) {
					$interval_fees = in_array($interval_between_fees, $interval_array) ? $interval_between_fees : 1;
					$insert_data = array();
					$date_interval = $payment_date_first ? $payment_date_first : date('Y-m-d');
					for($i=0; $i < $fees_number; $i++) {
						$insert_data[] = array(
							'fecha_vto' => $date_interval,
							'concepto' => $subject,
							'neto' => $fee_amount,
							'idtarifa' => $rate_id,
							'porcentaje_impuesto' => $fees,
							'impuesto'=> $total_fees,
							'importe'=> $total_amount,
						);
						$date_interval = date('Y-m-d', strtotime("+".$interval_fees." months", strtotime($date_interval)));

					}
					if(!empty($insert_data)) {
						$result = $this->TarifasLModel->insertFeeBatch($insert_data);
						$first_id = $result->first_id;
						foreach($insert_data as $data){
								$added_data[] = array(
									"id" => $first_id,
									"payment_date" => $data['fecha_vto'],
									"amount" => $data['neto'],
									"subject" => $data['concepto'],
									"fees" => $fees,
									"total_fees" => $total_fees,
									"total_amount" => $total_amount);
							$first_id++;
						}
					}
				}elseif($fees_number == '1'){
					$insert_data = array(
						'fecha_vto' => $payment_date_first ? $payment_date_first : date('Y-m-d'),
						'concepto' => $subject,
						'neto' => $fee_amount,
						'porcentaje_impuesto' => $fees,
						'impuesto'=> $total_fees,
						'importe'=> $total_amount,
						'idtarifa' => $rate_id,
					);
					$result = $this->TarifasLModel->insertFee($insert_data);
					if($result){
						$added_data[] = array(
							"id" => $result,
							"payment_date" => $insert_data['fecha_vto'],
							"amount" => $insert_data['neto'],
							"subject" => $insert_data['concepto'],
							"fees" => $fees,
							"total_fees" => $total_fees,
							"total_amount" => $total_amount);
					}
				}
			}
			echo json_encode(array('result' => $result, 'insert_data' => $added_data));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	public function editFee(){
		if($this->input->is_ajax_request()){
			$this->load->model('TarifasLModel');
			$fee_id = $this->input->post('fee_id', true);
			$subject = $this->input->post('subject', true);
			$fee_amount = $this->input->post('fee_amount', true);
			$payment_date_first = $this->input->post('payment_date_first', true);
			$fees = $this->input->post('fees_tax', true);
			$total_fees = $this->input->post('fees_amount_tax', true);
			$total_amount = $this->input->post('fees_total_amount', true);

			$rate_id = $this->input->post('rate_id', true);
			$result = false;
			if(!empty($subject) &&  !empty($fee_amount) && $this->checkdate($payment_date_first) && !empty($rate_id) && !empty($fee_id)){
				$update_data = array(
						'fecha_vto' => $payment_date_first ? $payment_date_first : date('Y-m-d'),
						'concepto' => $subject,
						'neto' => $fee_amount,
					    'porcentaje_impuesto' => $fees,
                        'impuesto'=> $total_fees,
                        'importe'=> $total_amount,
				);
				$where = array('id' => $fee_id, 'idtarifa' => $rate_id);
				$result = $this->TarifasLModel->updateFee($update_data, $where);
			}
			echo json_encode(array('success' => $result));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}

	private function checkDate($date){
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date))
		{
			return true;
		}else{
			return false;
		}
	}

	public function deleteRateFee(){
		if($this->input->is_ajax_request()){
			$this->load->model('TarifasLModel');
			$this->load->model('TarifasTModel');
			$data_type = $this->input->post('data_type', true);
			$result = false;
			$error_msg = '';
			if($data_type == 'rate'){
				$id = $this->input->post('data_id', true);
				$checkingLinks = $this->TarifasLModel->getFees($id);
				if(empty($checkingLinks)){
					$result = $this->TarifasTModel->deleteRate($id);
				}else{
					$error_msg = $this->lang->line('rates_rate_delete_no_success');
				}
			}elseif($data_type == 'fee'){
				$ids = $this->input->post('data_id');
				if(!empty($ids) && is_array($ids)){
					$result = $this->TarifasLModel->deleteFees($ids);
				}


			}

			echo json_encode(array('success' => $result, 'error_msg' => $error_msg));
			exit;
		}else{
			$this->layouts->view('error_404',$this->data, 'error_404');
		}
	}




}
