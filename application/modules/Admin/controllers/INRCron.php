<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class INRCron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('encryption', 'form_validation', 'security'));
        $this->load->model(array('Main_model'));
        $this->load->helper(array('admin', 'security'));
        date_default_timezone_set('Asia/Kolkata');
    } 

    public function index() {
        exit('No direct script access allowed');
    }


    public function withdrawToUser()
    {
        $users = $this->Main_model->get_records_limit('tbl_withdraw', 'credit_type = "USDT" AND  process_status = "0" AND status = "0" ','2','0', '*');
        foreach ($users as $key => $user) {
            $process_status = $this->Main_model->get_single_record('tbl_withdraw', ['id' => $user['id']], '*');
            $this->Main_model->update('tbl_withdraw', ['id' => $user['id']], ['process_status' => 1]);
            if($process_status['process_status'] == 0 && $user['payable_amount'] > 0){
                $eth_address = $this->Main_model->get_single_record('tbl_users', ['user_id' => $user['user_id']], 'eth_address');
                if($eth_address){
                    $url = 'http://165.22.212.221:3000/manish/inrusdtwallet_bep20usdt_withdraw';
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "receving_address":"'.$eth_address['eth_address'].'",
                        "amount": '.$user['payable_amount'].',
                        "auth_token" : "U2FsdGVkX19Xt3+uvAdlI17fSu27gam9Dt05cgVjd/Ln3E3lw1Bc+lhyny6KWqgx"
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                    ));
                    $_response = curl_exec($curl);
                    curl_close($curl);
                    $response = json_decode($_response, true);
                    if(!empty($response)){
                        if($response['success'] == 'SUCCESS'){
                            $this->Main_model->update('tbl_withdraw', ['id' => $user['id']], ['status' => 1, 'paid_status' => 1, 'main_status' => 2]);
                            $txn_hash = $response['transaction']['transactionHash'];
                            $gasUsed = $response['transaction']['gasUsed'];
                            $this->Main_model->update('tbl_withdraw', ['id' => $user['id']], ['json_response' => $_response, 'gasUsed' => $gasUsed, 'remark' => $txn_hash, 'process_status' => 2, 'credit_date' => date('Y-m-d H:i:s')]);
                        }elseif($response['success'] == 'FAILED'){
                            $this->Main_model->update('tbl_withdraw', ['id' => $user['id']], ['json_response' => $_response, 'process_status' => 0]);
                        }else{
                            $this->Main_model->update('tbl_withdraw', ['id' => $user['id']], ['json_response' => 'Something went wrong, Api Not Responding', 'process_status' => 3]);
                        }
                    }else{
                        $this->Main_model->update('tbl_withdraw', ['id' => $user['id']], ['json_response' => 'Something went wrong, Api Not Responding', 'process_status' => 3]);
                    }
                }else{
                    $this->Main_model->update('tbl_withdraw', ['id' => $user['id']], ['json_response' => 'Address Not Found!', 'process_status' => 3]);
                }
            } 
        }
    }
}