<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Fund extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'encryption', 'form_validation', 'security', 'email', 'pagination'));
        $this->load->model(array('User_model'));
        $this->load->helper(array('user', 'super','compose'));
        $this->userinfo = userinfo();
        $this->bankinfo = bankinfo();
    }

    // private function wallet_generate()
    // {
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'http://139.59.62.163:3019/generate_bep_address',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'GET',
    //     ));

    //     $response = curl_exec($curl);

    //     curl_close($curl);
    //     return $response;
    // }

    public function Request_fund()
    {
        if (is_logged_in()) {
            $response = array();
            $response['user'] = get_single_record('tbl_users', array('user_id' => $this->session->userdata['user_id']), '*');
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->security->xss_clean($this->input->post());
                $check = get_single_record('tbl_payment_request', array('transaction_id' => $data['txn_id']), '*');
                if (empty($check) && !empty($data['txn_id'])) {
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|heic';
                    $config['file_name'] = 'payment_slip' . time();
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('image')) {
                        set_flashdata('message', $this->upload->display_errors());
                    } else {
                        $fileData = array('upload_data' => $this->upload->data());
                        $reqArr = array(
                            'user_id' => $this->session->userdata['user_id'],
                            'amount' => $data['amount'],
                            'payment_method' => $data['payment_method'],
                            'transaction_id' => $data['txn_id'],
                            'image' => $fileData['upload_data']['file_name'],
                            'type' => 'fund_request',
                            'status' => 0,
                        );
                        $res = add('tbl_payment_request', $reqArr);
                        $message = "Dear Team ,<br></br> I Informed you that I Requested for fund amount is Rs." . $data['amount'] ." Please Update fund in my wallet from User ID:" . $this->session->userdata['user_id'] .',' . base_url();

                        composeMail('digiwallet.365@gmail.com', 'Fund Request', $message);
                        if ($res) {
                            set_flashdata('message', span_success('Payment Request Submitted Successfully'));
                        } else {
                            set_flashdata('message', span_danger('Error While Submitting Payment Request Please Try Again ...'));
                        }
                    }
                } else {
                    set_flashdata('message', span_info('Error please enter vaild Hash ID.'));
                }
            }
            $response['heeader'] = 'Request Fund';
            $response['qrcode'] = get_records('tbl_qrcode', array(), '*');
            $this->load->view('request_fund', $response);
        } else {
            redirect('login');
        }
    }
    private function wallet_generate()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://143.244.158.173:2662/get_bep20_address',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }


    public function Deposit_fund()
    {
        if (is_logged_in()) {
            $response = array();
            $response['user'] = get_single_record('tbl_users', array('user_id' => $this->session->userdata['user_id']), '*');
            if (empty($response['user']['wallet_address']) && empty($response['user']['private_key'])) {
                $walletGenerate = $this->wallet_generate();
                $json_wallet = json_decode($walletGenerate, true);
                // pr($json_wallet,true);
                $update['wallet_address'] = $json_wallet['account']['address'];
                $update['wallet_private'] = $json_wallet['account']['private_key'];
                update('tbl_users', ['user_id' => $this->session->userdata['user_id']], $update);
                redirect('dashboard/fund-request');
            }
            $response['heeader'] = deposit_header;
            $this->load->view('deposit_fund', $response);
        } else {
            redirect('login');
        }
    }



    public function fundHistory()
    {
        if (is_logged_in()) {
            $response['header'] = 'wallet Ledger';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = ['user_id' => $this->session->userdata['user_id']];
            if (!empty($type)) {
                $where = [$type => $value, 'user_id' => $this->session->userdata['user_id']];
            }
            $records = pagination('tbl_wallet', $where, '*', 'dashboard/fund-history', 3, 10);
            $response['path'] =  $records['path'];

            $response['field'] = '';
            $response['thead'] = '<tr>
                            <th>#</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Remark</th>
                            <th>Created At</th>
                         </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                $tbody[$key]  = ' <tr>
                            <td>' . $i . '</td>
                            <td>' . $amount . '</td>
                            <td>' . ($amount > 0 ? badge_success('Credit') : badge_danger('Debit')) . '</td>
                            <td>' . $type . '</td>
                            <td>' . $remark . '</td>
                            <td>' . $created_at . '</td>
                         </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['balance'] = true;
            $response['total_income'] = get_sum('tbl_wallet', $where, 'ifnull(sum(amount),0) as sum');
            $this->load->view('reports', $response);
        } else {
            redirect('login');
        }
    }

    public function fundRequestHistory()
    {
        if (is_logged_in()) {
            $response['header'] = 'Fund Request History';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = ['user_id' => $this->session->userdata['user_id']];
            if (!empty($type)) {
                $where = [$type => $value, 'user_id' => $this->session->userdata['user_id']];
            }
            $records = pagination('tbl_payment_request', $where, '*', 'dashboard/fundrequest-history', 3, 10);
            $response['path'] =  $records['path'];

            $response['field'] = '';
            $response['thead'] = '<tr>
                            <th>#</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Remarks</th>
                            <th>Created At</th>
                            <th>Status</th>
                         </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                $tbody[$key]  = ' <tr>
                            <td>' . $i . '</td>
                            <td>' . $amount . '</td>
                            <td>' . ucwords(str_replace('_', ' ', $type)) . '</td>
                            <td>' . $remarks . '</td>
                            <td>' . $created_at . '</td>
                            <td>' . ($status == 0 ? badge_warning('Pending') : ($status == 1 ? badge_success('Approved') : ($status == 2 ? badge_danger('Rejected') : badge_info('Fund')))) . '</td>
                         </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['balance'] = true;
            $this->load->view('reports', $response);
        } else {
            redirect('login');
        }
    }

    public function walletDepositAjax()
    {
        if (is_logged_in()) {
            $user = $this->User_model->get_single_record('tbl_users', ['user_id' => $this->session->userdata['user_id']], 'wallet_address');
            // $tokenValue = $this->User_model->get_single_record('tbl_token_value', ['id' => 1], 'amount');

            $walletAddress = $user['wallet_address'];
            $url = 'https://api.bscscan.com/api?module=account&action=tokentx&contractaddress=0x55d398326f99059fF775485246999027B3197955&address=' . $walletAddress . '&page=1&offset=100&startblock=0&endblock=999999999&sort=desc&apikey=D4J7HQQSRA6AKKS3ABBCP9PI7ZSF5G5G78';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $jsonD = json_decode($response, true);
            // pr($jsonD);
            if (!empty($jsonD['result']) && $jsonD['result'] != 'Error! Invalid address format') {
                foreach ($jsonD['result'] as $transaction) {
                    $check = $this->User_model->get_single_record('tbl_block_address', ['timeStamp' => $transaction['timeStamp']], 'timeStamp');
                    if (empty($check)  && strtoupper($walletAddress) == strtoupper($transaction['to'])) {
                        $addredArr  = [
                            'user_id' => $this->session->userdata['user_id'],
                            'timeStamp' => $transaction['timeStamp'],
                            'hash' => $transaction['hash'],
                            'blockHash' => $transaction['hash'],
                            'from' => $transaction['from'],
                            'to' => $transaction['to'],
                            'value' => ($transaction['value'] / 1000000000000000000),
                            // 'amount' => ($transaction['value'] / 1000000000000000000) ,
                            // 'token_price' => $tokenValue['amount'],
                            'tokenName' => 'USDT',
                            'tokenDecimal' => 18,
                            // 'transaction_type' => 'wallet',

                        ];
                        if ($addredArr['value'] > 0) {
                            $this->User_model->add('tbl_block_address', $addredArr);
                        }
                        $senderData = array(
                            'user_id' => $this->session->userdata['user_id'],
                            'amount' => ($transaction['value'] / 1000000000000000000),
                            'sender_id' => $transaction['from'],
                            'type' => 'automatic_fund_deposit',
                            'remark' => 'Automatic fund deposit',
                        );
                        if ($senderData['amount'] > 0) {
                            $res = $this->User_model->add('tbl_wallet', $senderData);
                        }
                    }
                }
            }

            $response1['records'] = $this->User_model->get_single_record('tbl_wallet', ['user_id' => $this->session->userdata['user_id']], 'ifnull(sum(amount),0) as balance');
            echo json_encode($response1);
        } else {
            redirect('login');
        }
    }



    public function walletHistory()
    {
        if (is_logged_in()) {
            $user = $this->User_model->get_single_record('tbl_users', ['user_id' => $this->session->userdata['user_id']], 'wallet_address');
            $tokenValue = $this->User_model->get_single_record('tbl_token_value', ['id' => 1], 'amount');

            $walletAddress = $user['wallet_address'];
            $url = 'https://api.bscscan.com/api?module=account&action=tokentx&contractaddress=0x55d398326f99059fF775485246999027B3197955&address=' . $walletAddress . '&page=1&offset=100&startblock=0&endblock=999999999&sort=desc&apikey=D4J7HQQSRA6AKKS3ABBCP9PI7ZSF5G5G78';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $jsonD = json_decode($response, true);

            // pr($jsonD , True);
            if (!empty($jsonD['result']) && $jsonD['result'] != 'Error! Invalid address format') {
                foreach ($jsonD['result'] as $transaction) {
                    $check = $this->User_model->get_single_record('tbl_block_address', ['timeStamp' => $transaction['timeStamp']], 'timeStamp');
                    if (empty($check) && strtoupper($walletAddress) == strtoupper($transaction['to'])) {
                        $addredArr  = [
                            'user_id' => $this->session->userdata['user_id'],
                            'timeStamp' => $transaction['timeStamp'],
                            'hash' => $transaction['hash'],
                            'blockHash' => $transaction['hash'],
                            'from' => $transaction['from'],
                            'to' => $transaction['to'],
                            // 'type' => $transaction['raw_data']['contract'][0]['type'],
                            'value' => ($transaction['value'] / 1000000000000000000),
                            'amount' => ($transaction['value'] / 1000000000000000000) / $tokenValue['amount'],
                            'token_price' => $tokenValue['amount'],
                            'tokenName' => 'USDT',
                            'tokenDecimal' => 18,
                            // 'transaction_type' => 'wallet',
                        ];
                        if ($addredArr['value'] > 0) {
                            $this->User_model->add('tbl_block_address', $addredArr);
                        }
                        $senderData = array(
                            'user_id' => $this->session->userdata['user_id'],
                            'amount' => ($transaction['value'] / 1000000000000000000),
                            'sender_id' => $transaction['from'],
                            'type' => 'automatic_fund_deposit',
                            'remark' => 'Automatic fund deposit',
                        );
                        if ($senderData['amount'] > 0) {
                            $res = $this->User_model->add('tbl_wallet', $senderData);
                        }
                    }
                }
            }

            $response1['records'] = $this->User_model->get_records('tbl_block_address', ['user_id' => $this->session->userdata['user_id']], '*');
            $this->load->view('walletHistory', $response1);
        } else {
            redirect('login');
        }
    }


     
    public function depositAjax()
    {
        if (is_logged_in()) {
            $user = $this->User_model->get_single_record('tbl_users', ['user_id' => $this->session->userdata['user_id']], 'wallet_address');
            // $tokenValue = $this->User_model->get_single_record('tbl_token_value', ['id' => 1], 'amount');

            $walletAddress = $user['wallet_address'];
            $url = 'https://api.bscscan.com/api?module=account&action=tokentx&contractaddress=' . contract . '&address=' . $walletAddress . '&page=1&offset=100&startblock=0&endblock=999999999&sort=desc&apikey=' . apikey;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $jsonD = json_decode($response, true);
            // pr($jsonD);
            if (!empty($jsonD['result'])) {
                foreach ($jsonD['result'] as $transaction) {
                    $check = $this->User_model->get_single_record('tbl_block_address', ['timeStamp' => $transaction['timeStamp']], 'timeStamp');
                    if (empty($check)  && strtoupper($walletAddress) == strtoupper($transaction['to'])) {
                        $deposit_value = ($transaction['value'] / pow(10, decimal));
                        $addredArr  = [
                            'user_id' => $this->session->userdata['user_id'],
                            'timeStamp' => $transaction['timeStamp'],
                            'hash' => $transaction['hash'],
                            'blockHash' => $transaction['hash'],
                            'from' => $transaction['from'],
                            'to' => $transaction['to'],
                            'value' => floor($deposit_value*1000)/1000,
                            // 'amount' => ($transaction['value'] / 1000000000000000000) / $tokenValue['amount'],
                            // 'token_price' => $tokenValue['amount'],
                            'tokenName' => token,
                            'tokenDecimal' => decimal
                        ];
                        if ($addredArr['value'] > 0) {
                            $this->User_model->add('tbl_block_address', $addredArr);
                        }
                        $senderData = array(
                            'user_id' => $this->session->userdata['user_id'],
                            'amount' => floor($deposit_value*1000)/1000,
                            'sender_id' => $transaction['from'],
                            'type' => 'automatic_fund_deposit',
                            'remark' => 'Automatic fund deposit',
                        );
                        if ($senderData['amount'] > 0) {
                            $res = $this->User_model->add('tbl_wallet', $senderData);
                        }
                    }
                }
            }

            $response1['records'] = $this->User_model->get_single_record('tbl_wallet', ['user_id' => $this->session->userdata['user_id']], 'ifnull(sum(amount),0) as balance');
            echo json_encode($response1);
        } else {
            redirect('login');
        }
    }



    private function depositHistory()
    {
        if (is_logged_in()) {
            $user = $this->User_model->get_single_record('tbl_users', ['user_id' => $this->session->userdata['user_id']], 'wallet_address');
            // $tokenValue = $this->User_model->get_single_record('tbl_token_value', ['id' => 1], 'amount');

            $walletAddress = $user['wallet_address'];
            $url = 'https://api.bscscan.com/api?module=account&action=tokentx&contractaddress=' . contract . '&address=' . $walletAddress . '&page=1&offset=100&startblock=0&endblock=999999999&sort=desc&apikey=' . apikey;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $jsonD = json_decode($response, true);

            // pr($jsonD);
            if (!empty($jsonD['result'])) {
                foreach ($jsonD['result'] as $transaction) {
                    $check = $this->User_model->get_single_record('tbl_block_address', ['timeStamp' => $transaction['timeStamp']], 'timeStamp');
                    if (empty($check) && strtoupper($walletAddress) == strtoupper($transaction['to'])) {
                        $deposit_value = ($transaction['value'] / pow(10, decimal));
                        
                        $addredArr  = [
                            'user_id' => $this->session->userdata['user_id'],
                            'timeStamp' => $transaction['timeStamp'],
                            'hash' => $transaction['hash'],
                            'blockHash' => $transaction['hash'],
                            'from' => $transaction['from'],
                            'to' => $transaction['to'],
                            // 'type' => $transaction['raw_data']['contract'][0]['type'],
                            'value' => floor($deposit_value*1000)/1000,
                            // 'amount' => ($transaction['value'] / 1000000000000000000) / $tokenValue['amount'],
                            // 'token_price' => $tokenValue['amount'],
                            'tokenName' => token,
                            'tokenDecimal' => decimal
                        ];
                        if ($addredArr['value'] > 0) {
                            $this->User_model->add('tbl_block_address', $addredArr);
                        }
                        $senderData = array(
                            'user_id' => $this->session->userdata['user_id'],
                            'amount' => floor($deposit_value*1000)/1000,
                            'sender_id' => $transaction['from'],
                            'type' => 'automatic_fund_deposit',
                            'remark' => 'Automatic fund deposit',
                        );
                        if ($senderData['amount'] > 0) {
                            $res = $this->User_model->add('tbl_wallet', $senderData);
                        }
                    }
                }
            }

            // $response1['records'] = $this->User_model->get_records('tbl_block_address', ['user_id' => $this->session->userdata['user_id']], '*');
            // $this->load->view('depositHistory', $response1);
        } else {
            redirect('login');
        }
    }

    public function DepositTransaction()
    {
        if (is_logged_in()) {
            $this->depositHistory();

            $response['header'] = 'Deposit History';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = ['user_id' => $this->session->userdata['user_id']];
            // $order_by = ['createdAt' => 'ASC'];
            if (!empty($type)) {
                $where = [$type => $value, 'user_id' => $this->session->userdata['user_id']];
            }
             // Merge $order_by with $where
            // $where = array_merge($where, $order_by);
            $records = pagination('tbl_block_address', $where, '*', 'dashboard/deposit-history', 3, 10, 'DESC');
            $response['path'] =  $records['path'];

            $response['field'] = '';
            $response['thead'] = '<tr>
                            <th>#</th>
                            <th>hash</th>
                            <th>from</th>
                            <th>To</th>
                            <th>value</th>
                            <th>tokenName</th>
                            <th>Date</th>
                         </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                $view = '<a href="https://bscscan.com/tx/' . $hash . '">View</a>';
                $tbody[$key]  = ' <tr>
                            <td>' . $i . '</td>
                            <td>' . $view . '</td>
                            <td>' . $from . '</td>
                            <td>' . $to . '</td>
                            <td>' . $value . '</td>
                            <td>' . $tokenName . '</td>
                            <td>' . $createdAt . '</td>
                         </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['balance'] = true;
            $this->load->view('reports', $response);
        } else {
            redirect('login');
        }
    }
}
