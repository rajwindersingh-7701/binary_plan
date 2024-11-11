<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DigitalCron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('encryption', 'form_validation', 'security'));
        $this->load->model(array('Main_model'));
        $this->load->helper(array('admin', 'security','super'));
        date_default_timezone_set('Asia/Kolkata');
    } 

    public function index() {
        exit('No direct script access allowed');
    }

    public function usdt_detposit_transactions(){
         header('Content-Type: application/json; charset=utf-8');
        $pending_transcations = $this->Main_model->get_limit_records('tbl_block_address',
                                    [
                                        'transfer_status' => 0,
                                        // 'tokenSymbol' => 'BSC-USD'
                                    ],'*',2,0);
        foreach($pending_transcations as $key => $transaction){
            if($transaction['gas_deposit_status'] == 1){
                $user = $this->Main_model->get_single_record('tbl_users',['user_id' => $transaction['user_id']],'id,user_id,wallet_address,wallet_private');
                $pending_transcations[$key]['private_key'] = $user['wallet_private'];
            }
        }
        // pr($pending_transcations,true);
        echo json_encode($pending_transcations);
    }

    public function update_usdt_transaction_status(){
        $id = $this->input->post('id');
        $gas_deposit_hash = $this->input->post('gas_deposit_hash');
        $wArr = array(
            'gas_deposit_status' => 1,
            'gas_deposit_hash' => $gas_deposit_hash,
        );
        $res = $this->Main_model->update('tbl_block_address', array('id' => $id), $wArr);
        if ($res) {
            return $this->output
            ->set_content_type('application/json') //set Json header
            ->set_output(json_encode(['success' => 1]));// make output json encoded
            exit;
        } else {
            return $this->output
            ->set_content_type('application/json') //set Json header
            ->set_output(json_encode(['success' => 0]));// make output json encoded
            exit;
        }
    }
    public function update_usdt_transaction_debit_status(){
            $id = $this->input->post('id');
            $transaction_hash = $this->input->post('transaction_hash');
            $wArr = array(
                'transfer_status' => 1,
                'transaction_hash' => $transaction_hash,
            );
            $res = $this->Main_model->update('tbl_block_address', array('id' => $id), $wArr);
            if ($res) {
                return $this->output
                ->set_content_type('application/json') //set Json header
                ->set_output(json_encode(['success' => 1]));// make output json encoded
                exit;
            } else {
                return $this->output
                ->set_content_type('application/json') //set Json header
                ->set_output(json_encode(['success' => 0]));// make output json encoded
                exit;
            }

    }




    public function pendingwithdraw(){
        header('Content-Type: application/json; charset=utf-8');
        $pending_transcations = $this->Main_model->get_limit_records('tbl_withdraw',
                                    [
                                        'status' => 0,
                                        'admin_status' => 1,
                                        'credit_type' => 'USDT'
                                     ],'id,user_id,status,payable_amount',2,0);
        foreach($pending_transcations as $key => $transaction){
                $user = $this->Main_model->get_single_record('tbl_users',['user_id' => $transaction['user_id']],'eth_address');
                $pending_transcations[$key]['eth_address'] = $user['eth_address'];
        }
        echo json_encode($pending_transcations);
    }

    public function update_usdt_withdraw_credit_status()
    {
        $id = $this->input->post('id');
        $transaction_hash = $this->input->post('transaction_hash');
        $wArr = array(
            'status' => 1,
            'admin_status' => 2,
            'remark' => $transaction_hash,
            'credit_date' => date('Y-m-d H:i:s')
        );
        $res = $this->Main_model->update('tbl_withdraw', array('id' => $id), $wArr);
        if ($res) {
            return $this->output
                ->set_content_type('application/json') //set Json header
                ->set_output(json_encode(['success' => 1])); // make output json encoded
            exit;
        } else {
            return $this->output
                ->set_content_type('application/json') //set Json header
                ->set_output(json_encode(['success' => 0])); // make output json encoded
            exit;
        }
    }

}



?>