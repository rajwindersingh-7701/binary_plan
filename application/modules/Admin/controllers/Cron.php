<?php

use phpDocumentor\Reflection\Types\Null_;

defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'encryption', 'form_validation', 'security', 'email'));
        $this->load->model(array('Main_model'));
        $this->load->helper(array('admin', 'security', 'super'));
        date_default_timezone_set('Asia/Kolkata');
    }

    public function empty_Data()
    {
        die('Data Not Empty');
        $this->Main_model->deleteCron('tbl_withdraw', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_wallet', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_users', ['id !=' => 1]);
        $this->Main_model->deleteCron('tbl_bank_details', ['id !=' => 1]);
        $this->Main_model->deleteCron('tbl_support_message', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_pool', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_pool2', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_pool3', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_pool4', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_income_wallet', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_activation_details', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_cron', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_sponser_count', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_sms_counter', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_roi', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_rewards', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_downline_count', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_downline_business', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_point_matching_income', ['id !=' => 0]);
        $this->Main_model->deleteCron('tbl_payment_request', ['id !=' => 0]);

        $userDtaa = array(
            'user_id' => 'admin',
            'name' => 'administrator',
            'directs' => '0',
            'package_amount' => '0',
            'package_id' => '0',
            'total_package' => '0',
            'team_business' => '0',
            'paid_status' => '0',
            'email' => 'admin@gmail.com',
            'phone' => '0987654321',
            'left_node' => '',
            'right_node' => '',
            'last_left' => 'admin',
            'last_right' => 'admin',
            'left_count' => '0',
            'right_count' => '0',
            'leftPower' => '0',
            'rightPower' => '0',
            'leftBusiness' => '0',
            'rightBusiness' => '0',
            'team_business_plan' => '0',
            'total_limit' => '0',
            'pending_limit' => '0',
            'roi_limit' => '0',
            'roi_pending' => '0',
        );
        update('tbl_users', ['id' => 1], $userDtaa);
        $userDtaa = array(
            'user_id' => 'admin',

        );
        update('tbl_bank_details', ['id' => 1], $userDtaa);
        echo 'data empty done';
    }


    public function freeUser()
    {
        $users = get_records('tbl_users', ['paid_status' => 1], 'user_id,package_amount,topup_date');
        foreach ($users as $user) :
            $cycleData = get_single_record('tbl_deactivation_details', ['user_id' => $user['user_id']], 'count(id) as record');
            $userinfo = get_single_record('tbl_income_wallet', ['user_id' => $user['user_id'], 'created_at >=' => $user['topup_date']], 'ifnull(sum(amount),0) as balance');

            $incomeLimit = $user['package_amount'] * 3;
            if ($userinfo['balance'] >= $incomeLimit) {
                $deactive = [
                    'paid_status' => 0,
                    'package_id' => 0,
                    'package_amount' => 0,
                    'topup_date' => '0000-00-00 00:00:00',
                    'incomeLimit2' => 0,
                ];
                update('tbl_users', ['user_id' => $user['user_id']], $deactive);
                $activeData = [
                    'user_id' => $user['user_id'],
                    'deactivater' => 'auto',
                    'package' => $user['package_amount'],
                    'topup_date' => $user['topup_date'],
                ];
                pr($activeData);
                add('tbl_deactivation_details', $activeData);
            }
        endforeach;
    }

    public function sapphireIncome()
    {
        $date1 = date('Y-m-d');
        $cron = get_single_record('tbl_cron', ['date' => $date1, 'cron_name' => 'sapphireIncome'], '*');
        if (empty($cron)) {
            add('tbl_cron', ['cron_name' => 'sapphireIncome', 'date' => $date1]);
            $date = date('Y-m-d', strtotime(date('Y-m-d') . ' 0 days'));
            $users = get_records('tbl_income_wallet', "amount > '0' and type != 'direct_sponsor_leadership' and date(created_at) = '" . $date . "' GROUP BY user_id", 'ifnull(sum(amount),0) as todayIncome,user_id');
            foreach ($users as $key => $user) {
                if ($user['todayIncome'] > 0) {
                    pr($user);
                    $getSponsor = get_single_record('tbl_users', array('user_id' => $user['user_id']), 'user_id,sponser_id');
                    if (!empty($getSponsor)) {
                        $perID = $user['todayIncome'] * 0.05;
                        $incomeArr = array(
                            'user_id' => $getSponsor['sponser_id'],
                            'amount' => $perID,
                            'type' => 'direct_sponsor_leadership',
                            'description' => 'Direct Sponsor Leadership Income From User ' . $user['user_id'],
                        );
                        pr($incomeArr);
                        add('tbl_income_wallet', $incomeArr);
                    }
                }
            }
        } else {
            echo 'Today Cron already run';
        }
    }

    public function roiCron()
    {
        if (date('D') == 'Sun' || date('D') == 'Sat') {
            die('its weekend');
        }
        $date = date('Y-m-d');
        $currentMonth = date('n');
        $currentYear = date('Y');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        $cron = get_single_record('tbl_cron', ['date' => $date, 'cron_name' => 'roiCron'], '*');
        // if (empty($cron)) {
       add('tbl_cron', ['cron_name' => 'roiCron', 'date' => $date]);
        $roi_users = get_records('tbl_roi', array('days >' => 0, 'status' => 0), '*');
        foreach ($roi_users as $key => $user) {


            $date1 = date('Y-m-d H:i:s');
            $date2 = date('Y-m-d H:i:s', strtotime($user['creditDate'] . '+ 0 days'));
            $diff = strtotime($date1) - strtotime($date2);
            echo $diff . ' / ' . $user['user_id'] . '<br>';
            if ($diff >= 0) {
                $userinfo = get_single_record('tbl_users', ['user_id' => $user['user_id']], '*');
                if ($userinfo['roi_income'] == 0) {
                    //  $checkCapping = get_single_record('tbl_income_wallet',['user_id' =>$userinfo['user_id'],'date(created_at)' => $date,'amount >' => 0,'type!=' =>'withdraw_request'],'ifnull(sum(amount),0) as total');
                    $roi_amount2 = $user['roi_amount'] ;
                    // if($checkCapping['total']+$roi_amount < $userinfo['capping']){
                    $new_day = $user['days'] - 1;
                    $days = ($user['total_days'] + 1) - $user['days'];
                    if (income_limit == 0) {
                        $CheckLimit = incomeProccess($user['user_id'], $roi_amount2);
                        if ($CheckLimit > 0) {
                            $roi_amount = $CheckLimit;
                        } else {
                            $roi_amount = 0;
                        }
                    }
                        if($roi_amount >0){
                            $incomeArr = array(
                                'user_id' => $user['user_id'],
                                'amount' => $roi_amount,
                                'type' => 'daily_trading_income',
                                'description' => '' . ucwords(str_replace('_', ' ', $user['type'])) . ' Income at day ' . $days,
                            );
                            pr($incomeArr);
                            add('tbl_income_wallet', $incomeArr);
                            // update('tbl_users', ['user_id' => $user['user_id']], ['roi_pending' => ($userinfo['roi_pending'] + $incomeArr['amount'])]);
                            update('tbl_roi', array('id' => $user['id']), array('days' => $new_day, 'amount' => ($user['amount'] - $user['roi_amount']), 'creditDate' => date('Y-m-d')));
                            // $sponsor = get_single_record('tbl_users', ['user_id' => $user['user_id']], 'sponser_id');
                            // $level_income = '0.2,0.2,0.15,0.10,0.10,0.005,0.005,0.005,0.005,0.005';
                            // $this->level_income($sponsor['sponser_id'], $user['user_id'], $level_income, $roi_amount);
                        }
                    // }
                }
            }
        }
        // } else {
        //     echo 'Today cron already run';
        // }
    }



    public function directRoiCron()
    {
        if (date('D') == 'Sun' || date('D') == 'Sat') {
            die('its weekend');
        }
        $date = date('Y-m-d');
        $currentMonth = date('n');
        $currentYear = date('Y');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        $cron = get_single_record('tbl_cron', ['date' => $date, 'cron_name' => 'directRoiCron'], '*');
     if (empty($cron)) {
       // add('tbl_cron', ['cron_name' => 'directRoiCron', 'date' => $date]);
        $roi_users = get_records('tbl_roi_direct', array('days >' => 0, 'status' => 0), '*');
        foreach ($roi_users as $key => $user) {


            $date1 = date('Y-m-d H:i:s');
            $date2 = date('Y-m-d H:i:s', strtotime($user['creditDate'] . '+ 0 days'));
            $diff = strtotime($date1) - strtotime($date2);
            echo $diff . ' / ' . $user['user_id'] . '<br>';
            if ($diff >= 0) {
                $userinfo = get_single_record('tbl_users', ['user_id' => $user['user_id']], '*');
                if ($userinfo['roi_income'] == 0) {
                    //  $checkCapping = get_single_record('tbl_income_wallet',['user_id' =>$userinfo['user_id'],'date(created_at)' => $date,'amount >' => 0,'type!=' =>'withdraw_request'],'ifnull(sum(amount),0) as total');
                    $roi_amount2 = $user['roi_amount'];
                    // if($checkCapping['total']+$roi_amount < $userinfo['capping']){
                    $new_day = $user['days'] - 1;
                    $days = ($user['total_days'] + 1) - $user['days'];
                    // if ($userinfo['roi_limit'] > $userinfo['roi_pending']) {
                    //     $totalCredit = $userinfo['roi_pending'] + ($roi_amount2);
                    //     if ($totalCredit < $userinfo['roi_limit']) {
                    //         $roi_amount = ($roi_amount2);
                    //     } else {
                    //         $roi_amount = $userinfo['roi_limit'] - $userinfo['roi_pending'];
                    //     }
                    if (income_limit == 0) {
                        $CheckLimit = incomeProccess($user['user_id'], $roi_amount2);
                        if ($CheckLimit > 0) {
                            $roi_amount = $CheckLimit;
                        } else {
                            $roi_amount = 0;
                        }
                    }
                        if ($roi_amount > 0) {
                            $incomeArr = array(
                                'user_id' => $user['user_id'],
                                'amount' => $roi_amount,
                                'type' => $user['type'],
                                'description' => ucwords(str_replace('_', ' ', $user['type'])) . ' Income at day ' . $days,
                            );
                            pr($incomeArr);
                            add('tbl_income_wallet', $incomeArr);
                            //update('tbl_users', ['user_id' => $user['user_id']], ['roi_pending' => ($userinfo['roi_pending'] + $incomeArr['amount'])]);
                            update('tbl_roi_direct', array('id' => $user['id']), array('days' => $new_day, 'amount' => ($user['amount'] - $user['roi_amount']), 'creditDate' => date('Y-m-d')));
                            // $sponsor = get_single_record('tbl_users', ['user_id' => $user['user_id']], 'sponser_id');
                            // $level_income = '0.2,0.2,0.15,0.10,0.10,0.005,0.005,0.005,0.005,0.005';
                            // $this->level_income($sponsor['sponser_id'], $user['user_id'], $level_income, $roi_amount);
                        }
                    }
                // }
            }
        }
        } else {
            echo 'Today cron already run';
        }
    }


    private function level_income($sponser_id, $activated_id, $package_income, $package)
    {
        $incomeArr = explode(',', $package_income);

        foreach ($incomeArr as $key => $income) {
            $level = $key + 1;
            if ($level >= 1 && $level <= 2) {
                $direct =  1;
            } else {
                $direct =  5;
            }
            $sponser = get_single_record('tbl_users', array('user_id' => $sponser_id), 'id,user_id,sponser_id,paid_status,package_amount,level_directs,total_limit,pending_limit,level_income');
            if (!empty($sponser)) {
                if ($sponser['level_income'] == 0) {
                    if ($sponser['paid_status'] == 1) {
                        if ($sponser['level_directs'] >= $direct) {
                            if ($sponser['total_limit'] > $sponser['pending_limit']) {
                                $totalCredit = $sponser['pending_limit'] + ($package * $income);
                                if ($totalCredit < $sponser['total_limit']) {
                                    $level_income = ($package * $income);
                                } else {
                                    $level_income = $sponser['total_limit'] - $sponser['pending_limit'];
                                }
                                $LevelIncome = array(
                                    'user_id' => $sponser['user_id'],
                                    'amount' => $level_income,
                                    'type' => 'level_income',
                                    'description' => 'Level Income from ROI of Member (' . currency . $package . ') ' . $activated_id . ' At level ' . ($level),
                                );
                                pr($LevelIncome);
                                add('tbl_income_wallet', $LevelIncome);
                                update('tbl_users', ['user_id' => $sponser['user_id']], ['pending_limit' => ($sponser['pending_limit'] + $LevelIncome['amount'])]);
                            }
                        }
                    }
                }
                $sponser_id = $sponser['sponser_id'];
            }
        }
    }

    // private function roiLevelIncome($user_id, $linkedID, $amount)
    // {
    //     for ($i = 1; $i <= 5; $i++) {
    //         if ($i == 1) {
    //             $incomeArr[$i] = ['amount' => 0.1, 'direct' => 1];
    //         } elseif ($i == 2) {
    //             $incomeArr[$i] = ['amount' => 0.08, 'direct' => 2];
    //         } elseif ($i == 3) {
    //             $incomeArr[$i] = ['amount' => 0.05, 'direct' => 3];
    //         } elseif ($i == 4) {
    //             $incomeArr[$i] = ['amount' => 0.04, 'direct' => 4];
    //         } elseif ($i == 5) {
    //             $incomeArr[$i] = ['amount' => 0.03, 'direct' => 5];
    //         }
    //     }
    //     $tokenValue = get_single_record('tbl_token_value', ['id' => 1], 'amount');
    //     foreach ($incomeArr as $key => $income) :
    //         //$direct = $directArr[$key];
    //         $userinfo = get_single_record('tbl_users', ['user_id' => $user_id], 'user_id,sponser_id,directs,incomeLimit,incomeLimit2,total_package');
    //         if (!empty($userinfo['user_id'])) :
    //             $directs = get_single_record('tbl_users', ['sponser_id' => $user_id, 'total_package >=' => $userinfo['total_package']], 'count(id) as direct');
    //             if ($directs['direct'] >= $income['direct']) :
    //                 if ($userinfo['total_limit'] > $userinfo['pending_limit']) {
    //                     $totalCredit = $userinfo['pending_limit'] + ($amount * $income['amount']);
    //                     if ($totalCredit < $userinfo['total_limit']) {
    //                         $level_income = ($amount * $income['amount']);
    //                     } else {
    //                         $level_income = $userinfo['total_limit'] - $userinfo['pending_limit'];
    //                     }
    //                     $creditIncome = [
    //                         'user_id' => $userinfo['user_id'],
    //                         'amount' => $level_income,
    //                         'type' => 'roi_level_income',
    //                         'description' => 'ROI Level Income from User ' . $linkedID . ' at level ' . $key,
    //                     ];
    //                     add('tbl_income_wallet', $creditIncome);
    //                     update('tbl_users', ['user_id' => $userinfo['user_id']], ['pending_limit' => ($userinfo['pending_limit'] + $creditIncome['amount'])]);
    //                 }
    //             endif;
    //             $user_id = $userinfo['sponser_id'];
    //         endif;
    //     endforeach;
    // }

    public function boosterCron()
    {
        if (date('D') != 'Sun') {
            $roi_users = get_records('tbl_roi', array('amount >' => 0, 'type' => 'direct_booster_income', 'days >' => 0), '*');
            foreach ($roi_users as $key => $user) {
                $date1 = date('Y-m-d H:i:s');
                $date2 = date('Y-m-d H:i:s', strtotime($user['created_at'] . '+ 1 days'));
                $diff = strtotime($date1) - strtotime($date2);
                if ($diff >= 0) {
                    $new_day = $user['days'] - 1;
                    $days = 21 - $user['days'];
                    $incomeArr = array(
                        'user_id' => $user['user_id'],
                        'amount' => $user['roi_amount'],
                        'type' => 'direct_boost_income',
                        'description' => 'Direct Booster Income at ' . $new_day . ' Day',
                    );
                    pr($incomeArr);
                    add('tbl_income_wallet', $incomeArr);
                    update('tbl_roi', array('id' => $user['id']), array('days' => $new_day, 'amount' => ($user['amount'] - $user['roi_amount'])));
                    $sponsor = get_single_record('tbl_users', ['user_id' => $user['user_id']], 'sponser_id');
                    $this->levelIncome($sponsor['sponser_id'], $user['user_id']);
                }
            }
        }
    }

    public function point_match_cron()
    {
        // if(date('D') == 'Sun'){
        $response['users'] = get_records('tbl_users', '(leftPower >= 2 and rightPower >= 1 ) OR (leftPower >= 1 and rightPower >= 2 )', '*');
        foreach ($response['users'] as $user) {
            pr($user);
            // $package = get_single_record_desc('tbl_package', array('id' => $user['package_id']), '*');
            $user_match = $this->Main_model->get_single_record_desc('tbl_point_matching_income', array('user_id' => $user['user_id']), '*');
            // $position_directs = $this->Main_model->count_position_directs($user['user_id']);
            $leftDirect = get_single_record('tbl_users', array('sponser_id' => $user['user_id'], 'position' => 'L', 'paid_status' => 1), 'ifnull(count(id),0) as leftDirect');
            $rightDirect = get_single_record('tbl_users', array('sponser_id' => $user['user_id'], 'position' => 'R', 'paid_status' => 1), 'ifnull(count(id),0) as rightDirect');
            // if ($rightDirect['rightDirect'] >= 1 && $leftDirect['leftDirect'] >= 1) {
                if (!empty($user_match)) {
                    if ($user['leftPower'] > $user['rightPower']) {
                        $old_income = $user['rightPower'];
                    } else {
                        $old_income = $user['leftPower'];
                    }
                    if ($user_match['left_bv'] > $user_match['right_bv']) {
                        $new_income = $user_match['right_bv'];
                    } else {
                        $new_income = $user_match['left_bv'];
                    }
                    $income = ($old_income - $new_income);
                    $match_bv = $income;
                    $carry_forward = abs($user['leftPower'] - $user['rightPower']);

                    $user_income = $income * 2 / 100;
                    if ($user_income > 0) {
                        $matchArr = array(
                            'user_id' => $user['user_id'],
                            'left_bv' => $user['leftPower'],
                            'right_bv' => $user['rightPower'],
                            'amount' => $user_income,
                            'match_bv' => $match_bv,
                            'carry_forward' => $carry_forward,
                        );
                        add('tbl_point_matching_income', $matchArr);
                        if ($user['capping'] < $user_income) {
                            $user_income = $user['capping'];
                        }
                        // if($user['incomeLimit2'] > $user['incomeLimit']){
                        //     $totalCredit = $user['incomeLimit'] + $user_income;
                        //     if($totalCredit < $user['incomeLimit2']){
                        $matching_income = $user_income;
                        // } else {
                        //     $matching_income = $user['incomeLimit2'] - $user['incomeLimit'];
                        // }
                        if (income_limit == 0) {
                            $CheckLimit = incomeProccess($user['user_id'], $matching_income);
                            if ($CheckLimit > 0) {
                                $matching_income = $CheckLimit;
                            } else {
                                $matching_income = 0;
                            }
                        }
                        if($matching_income >0){

                        $incomeArr = array(
                            'user_id' => $user['user_id'],
                            'amount' => $matching_income,
                            'type' => 'binary_matching_income',
                            'description' => 'Point Matching Bonus'
                        );
                        add('tbl_income_wallet', $incomeArr);
                    
                    }
                        $checkSponser = get_single_record('tbl_users', ['user_id' => $user['sponser_id'], 'paid_status' => 1], 'user_id');
                        if (!empty($checkSponser)) {
                            $sponserincomeArr = array(
                                'user_id' => $checkSponser['user_id'],
                                'amount' => $matching_income * 0.05,
                                'type' => 'sponsor_balancing_income',
                                'description' => 'Sponser Balancing Income form ' . $user['user_id'],
                            );
                            //  add('tbl_income_wallet', $sponserincomeArr);
                        }
                        //  update('tbl_users',['user_id' => $user['user_id']],['incomeLimit' => ($user['incomeLimit'] + $incomeArr['amount'])]);
                        //  }
                        // $this->generation_income($user['sponser_id'],$matching_income, $user['user_id']);

                        pr($matchArr);
                    }
                } else {
                    if ($user['leftPower'] > $user['rightPower']) {
                        $leftPower = $user['leftPower'] - 0;
                        $rightPower = $user['rightPower'];
                    } else {
                        $rightPower = $user['rightPower'] - 0;
                        $leftPower = $user['leftPower'];
                    }
                    if ($leftPower > $rightPower) {
                        $income = $rightPower;
                    } else {
                        $income = $leftPower;
                    }
                    $match_bv = $income;
                    $carry_forward = abs($leftPower - $rightPower);

                    $user_income = $income * 2 / 100;
                    //                echo $user_income;
                    if ($user['capping'] < $user_income) {
                        $user_income = $user['capping'];
                    }
                    $matchArr = array(
                        'user_id' => $user['user_id'],
                        'left_bv' => $user['leftPower'],
                        'right_bv' => $user['rightPower'],
                        'amount' => $user_income,
                        'match_bv' => $match_bv,
                        'carry_forward' => $carry_forward,
                    );
                    add('tbl_point_matching_income', $matchArr);
                    // if($user['incomeLimit2'] > $user['incomeLimit']){
                    //     $totalCredit = $user['incomeLimit'] + $user_income;
                    //     if($totalCredit < $user['incomeLimit2']){
                    $matching_income = $user_income;
                    // } else {
                    //     $matching_income = $user['incomeLimit2'] - $user['incomeLimit'];
                    // }

                    if (income_limit == 0) {
                        $CheckLimit = incomeProccess($user['user_id'], $matching_income);
                        if ($CheckLimit > 0) {
                            $matching_income = $CheckLimit;
                        } else {
                            $matching_income = 0;
                        }
                    }
                    if($matching_income >0){
                        $incomeArr = array(
                            'user_id' => $user['user_id'],
                            'amount' => $matching_income,
                            'type' => 'binary_matching_income',
                            'description' => 'Point Matching Bonus'
                        );
                        add('tbl_income_wallet', $incomeArr);
                    }
                    $checkSponser = get_single_record('tbl_users', ['user_id' => $user['sponser_id'], 'paid_status' => 1], 'user_id');
                    if (!empty($checkSponser)) {
                        $sponserincomeArr = array(
                            'user_id' => $checkSponser['user_id'],
                            'amount' => $matching_income * 0.1,
                            'type' => 'sponsor_balancing_income',
                            'description' => 'Sponser Balancing Income form ' . $user['user_id'],
                        );
                        //  add('tbl_income_wallet', $sponserincomeArr);
                    }
                    // update('tbl_users',['user_id' => $user['user_id']],['incomeLimit' => ($user['incomeLimit'] + $incomeArr['amount'])]);
                    // }
                    //  $this->generation_income($user['sponser_id'],$matching_income, $user['user_id']);

                    pr($matchArr);
                }
            // }
        }
        //  }
        //pr($response);
        die('code executed Successfully');
    }


    public function direct_point_match_cron()
    {
        // if(date('D') == 'Sun'){
        $response['users'] = get_records('tbl_users', '(leftPower >= 2 and rightPower >= 1 ) OR (leftPower >= 1 and rightPower >= 2  )', '*');
        foreach ($response['users'] as $user) {
            pr($user);
            $leftPower = get_single_record('tbl_users',['sponser_id' => $user['user_id'],'paid_status' =>1,'position' =>"L"],'ifnull(sum(total_package),0)as business');
            $rightPower = get_single_record('tbl_users',['sponser_id' => $user['user_id'],'paid_status' =>1,'position' =>"R"],'ifnull(sum(total_package),0)as business');
            $user['leftPower'] = $leftPower['business'];
            $user['rightPower'] = $rightPower['business'];

            pr($user['leftPower']);
            pr($user['rightPower']);

            // $package = get_single_record_desc('tbl_package', array('id' => $user['package_id']), '*');
            $user_match = $this->Main_model->get_single_record_desc('tbl_direct_point_matching_income', array('user_id' => $user['user_id']), '*');
            // $position_directs = $this->Main_model->count_position_directs($user['user_id']);
            $leftDirect = get_single_record('tbl_users', array('sponser_id' => $user['user_id'], 'position' => 'L', 'paid_status' => 1), 'ifnull(count(id),0) as leftDirect');
            $rightDirect = get_single_record('tbl_users', array('sponser_id' => $user['user_id'], 'position' => 'R', 'paid_status' => 1), 'ifnull(count(id),0) as rightDirect');
            if ($rightDirect['rightDirect'] >= 1 && $leftDirect['leftDirect'] >= 1) {
                if (!empty($user_match)) {
                    if ($user['leftPower'] > $user['rightPower']) {
                        $old_income = $user['rightPower'];
                    } else {
                        $old_income = $user['leftPower'];
                    }
                    if ($user_match['left_bv'] > $user_match['right_bv']) {
                        $new_income = $user_match['right_bv'];
                    } else {
                        $new_income = $user_match['left_bv'];
                    }
                    $income = ($old_income - $new_income);
                    $match_bv = $income;
                    $carry_forward = abs($user['leftPower'] - $user['rightPower']);

                    $user_income = $income * 5 / 100;
                    if ($user_income > 0) {
                        $matchArr = array(
                            'user_id' => $user['user_id'],
                            'left_bv' => $user['leftPower'],
                            'right_bv' => $user['rightPower'],
                            'amount' => $user_income,
                            'match_bv' => $match_bv,
                            'carry_forward' => $carry_forward,
                        );
                        add('tbl_direct_point_matching_income', $matchArr);
                        if ($user['capping'] < $user_income) {
                            $user_income = $user['capping'];
                        }
                        // if($user['incomeLimit2'] > $user['incomeLimit']){
                        //     $totalCredit = $user['incomeLimit'] + $user_income;
                        //     if($totalCredit < $user['incomeLimit2']){
                        $matching_income = $user_income;
                        // } else {
                        //     $matching_income = $user['incomeLimit2'] - $user['incomeLimit'];
                        // }
                        if (income_limit == 0) {
                            $CheckLimit = incomeProccess($user['user_id'], $matching_income);
                            if ($CheckLimit > 0) {
                                $matching_income = $CheckLimit;
                            } else {
                                $matching_income = 0;
                            }
                        }
                        if($matching_income >0){

                        $incomeArr = array(
                            'user_id' => $user['user_id'],
                            'amount' => $matching_income,
                            'type' => 'direct_binary',
                            'description' => 'Direct Binary '
                        );
                        add('tbl_income_wallet', $incomeArr);
                    }
                        //  update('tbl_users',['user_id' => $user['user_id']],['incomeLimit' => ($user['incomeLimit'] + $incomeArr['amount'])]);
                        //  }
                        // $this->generation_income($user['sponser_id'],$matching_income, $user['user_id']);

                        pr($matchArr);
                    }
                } else {
                    if ($user['leftPower'] > $user['rightPower']) {
                        $leftPower = $user['leftPower'] - 0;
                        $rightPower = $user['rightPower'];
                    } else {
                        $rightPower = $user['rightPower'] - 0;
                        $leftPower = $user['leftPower'];
                    }
                    if ($leftPower > $rightPower) {
                        $income = $rightPower;
                    } else {
                        $income = $leftPower;
                    }
                    $match_bv = $income;
                    $carry_forward = abs($leftPower - $rightPower);

                    $user_income = $income * 5 / 100;
                    //                echo $user_income;
                    if ($user['capping'] < $user_income) {
                        $user_income = $user['capping'];
                    }
                    $matchArr = array(
                        'user_id' => $user['user_id'],
                        'left_bv' => $user['leftPower'],
                        'right_bv' => $user['rightPower'],
                        'amount' => $user_income,
                        'match_bv' => $match_bv,
                        'carry_forward' => $carry_forward,
                    );
                    add('tbl_direct_point_matching_income', $matchArr);
                    // if($user['incomeLimit2'] > $user['incomeLimit']){
                    //     $totalCredit = $user['incomeLimit'] + $user_income;
                    //     if($totalCredit < $user['incomeLimit2']){
                    $matching_income = $user_income;
                    // } else {
                    //     $matching_income = $user['incomeLimit2'] - $user['incomeLimit'];
                    // }

                    if (income_limit == 0) {
                        $CheckLimit = incomeProccess($user['user_id'], $matching_income);
                        if ($CheckLimit > 0) {
                            $matching_income = $CheckLimit;
                        } else {
                            $matching_income = 0;
                        }
                    }
                    if($matching_income >0){
                        $incomeArr = array(
                            'user_id' => $user['user_id'],
                            'amount' => $matching_income,
                            'type' => 'direct_binary',
                            'description' => 'Direct Binary Bonus'
                        );
                        add('tbl_income_wallet', $incomeArr);
                    }
                  
                    // update('tbl_users',['user_id' => $user['user_id']],['incomeLimit' => ($user['incomeLimit'] + $incomeArr['amount'])]);
                    // }
                    //  $this->generation_income($user['sponser_id'],$matching_income, $user['user_id']);

                    pr($matchArr);
                }
            }
        }
        //  }
        //pr($response);
        die('code executed Successfully');
    }




    // public function point_match_cron() {
    //     $response['users'] = get_records('tbl_users', '(leftPower >= 1 and rightPower >= 1) OR (leftPower >= 1 and rightPower >= 1)', '*');
    //     $point_users = [];
    //     $pair_counts = 0;
    //     foreach ($response['users']  as $userkey => $user) {
    //         $user_match = get_single_record_desc('tbl_point_matching_income', array('user_id' => $user['user_id']), '*');
    //         $position_directs = $this->Main_model->count_position_directs($user['user_id']);
    //       //   if(!empty($position_directs) && count($position_directs) == 2){
    //             if (!empty($user_match)) {
    //                 if ($user['leftPower'] > $user['rightPower']) {
    //                     $old_income = $user['rightPower'];
    //                 } else {
    //                     $old_income = $user['leftPower'];
    //                 }
    //                 if ($user_match['left_bv'] > $user_match['right_bv']) {
    //                     $new_income = $user_match['right_bv'];
    //                 } else {
    //                     $new_income = $user_match['left_bv'];
    //                 }
    //                 $income = ($old_income - $new_income);
    //                 $match_bv = $income;
    //                 $carry_forward = abs($user['leftPower'] - $user['rightPower']);

    //                 $user_income = $income * 50/100;
    //                 if ($user_income > 0) {
    //                     $matchArr = array(
    //                         'user_id' => $user['user_id'],
    //                         'left_bv' => $user['leftPower'],
    //                         'right_bv' => $user['rightPower'],
    //                         'amount' => $user_income,
    //                         'match_bv' => $match_bv,
    //                         'carry_forward' => $carry_forward,
    //                     );
    //                     add('tbl_point_matching_income', $matchArr);
    //                     if($user['capping'] < $user_income){
    //                         $user_income = $user['capping'];
    //                     }
    //                     // if($user['incomeLimit'] > $user['incomeLimit']){
    //                     //     $totalCredit = $user['incomeLimit'] + $user_income;
    //                     //     if($totalCredit < $user['incomeLimit']){
    //                             $matching_income = $user_income;
    //                         // } else {
    //                         //     $matching_income = $user['incomeLimit'] - $user['incomeLimit'];
    //                         // }
    //                         $point_users[$userkey]['user_id'] = $user['user_id'];
    //                         $point_users[$userkey]['point'] =$match_bv;
    //                         $point_users[$userkey]['capping'] = $user['capping'];
    //                         // $point_users[$userkey]['incomeLimit'] = $user['incomeLimit'];
    //                         // $point_users[$userkey]['incomeLimit2'] = $user['incomeLimit2'];
    //                         $pair_counts = $pair_counts + $match_bv;
    //                     // }
    //                     pr($matchArr);
    //                 }
    //             } else {
    //                 if ($user['leftPower'] > $user['rightPower']) {
    //                     $leftPower = $user['leftPower'];
    //                     $rightPower = $user['rightPower'];
    //                 } else {
    //                     $rightPower = $user['rightPower'];
    //                     $leftPower = $user['leftPower'];
    //                 }
    //                 if($leftPower > $rightPower){
    //                     $income = $rightPower;

    //                 }else{
    //                     $income = $leftPower;
    //                 }
    //                 $match_bv = $income;
    //                 $carry_forward = abs($leftPower - $rightPower);

    //                 $user_income = $income * 50/100;
    //                 //                echo $user_income;
    //                 if($user['capping'] < $user_income){
    //                     $user_income = $user['capping'];
    //                 }
    //                 $matchArr = array(
    //                     'user_id' => $user['user_id'],
    //                     'left_bv' => $user['leftPower'],
    //                     'right_bv' => $user['rightPower'],
    //                     'amount' => $user_income,
    //                     'match_bv' => $match_bv,
    //                     'carry_forward' => $carry_forward,
    //                 );
    //                 add('tbl_point_matching_income', $matchArr);
    //                 // if($user['incomeLimit'] > $user['incomeLimit']){
    //                 //     $totalCredit = $user['incomeLimit'] + $user_income;
    //                 //     if($totalCredit < $user['incomeLimit']){
    //                         $matching_income = $user_income;
    //                     // } else {
    //                     //     $matching_income = $user['capping'] - $user['incomeLimit'];
    //                     // }

    //                     $point_users[$userkey]['user_id'] = $user['user_id'];
    //                     $point_users[$userkey]['point'] = $match_bv;
    //                     $point_users[$userkey]['capping'] = $user['capping'];
    //                     // $point_users[$userkey]['incomeLimit'] = $user['incomeLimit'];
    //                     // $point_users[$userkey]['incomeLimit2'] = $user['incomeLimit2'];
    //                     $pair_counts = $pair_counts + $match_bv;
    //                 //}
    //                 pr($matchArr);
    //                 pr($point_users);
    //             }
    //         //}
    //     }

    //     $againReceiver = [];
    //     $receiverAmount = 0;
    //     $ar = 0;
    //     $cyclePair = 0;

    //     if(!empty($point_users)){
    //         // pr($point_users);
    //         $date = date('Y-m-d',strtotime(date('Y-m-d').' - 1 day'));
    //         $today_earning = get_single_record('tbl_wallet','date(created_at) = "'.$date.'" and type = "account_activation"','ifnull(sum(amount),0) as today_joining');

    //         if(!empty($today_earning)){
    //             echo 'Today joining ' . abs($today_earning['today_joining']) . '<br>';
    //             echo 'Today pairs ' . $pair_counts. '<br>';
    //             $perpairamount = (abs($today_earning['today_joining']) * 50/100) / $pair_counts;
    //             echo 'per pair amount ' . $perpairamount ;
    //             foreach($point_users as $k => $point_user){
    //                 PR($point_user);
    //                 $userIncome = $point_user['point'] * $perpairamount;

    //                 if($point_user['capping'] > $userIncome){
    //                     $userIncome = $userIncome;

    //                     $againReceiver[$ar]['user_id'] = $point_user['user_id'];
    //                     $againReceiver[$ar]['incomeLimit'] = $point_user['incomeLimit'];
    //                     $againReceiver[$ar]['incomeLimit2'] = $point_user['incomeLimit2'];
    //                     $againReceiver[$ar]['points'] = $point_user['point'];

    //                     $cyclePair = $cyclePair + $point_user['point'];

    //                 }else{
    //                     $receiverAmount = $receiverAmount + ($userIncome - $point_user['capping']);
    //                     $userIncome = $point_user['capping'];
    //                 }

    //                 // if($point_user['incomeLimit2'] > $point_user['incomeLimit']){
    //                 //     $totalCredit = $point_user['incomeLimit'] + $userIncome;
    //                 //     if($totalCredit < $point_user['incomeLimit2']){
    //                         $matching_income = $userIncome;
    //                     // } else {
    //                     //     $matching_income = $point_user['incomeLimit2'] - $point_user['incomeLimit'];
    //                     // }

    //                     $incomeArr = array(
    //                         'user_id' => $point_user['user_id'],
    //                         'amount' => $matching_income,
    //                         'type' => 'matching_bonus',
    //                         'description' => 'Point Matching Bonus',
    //                         'per_pair_amount' =>  $perpairamount,
    //                         'total_pair' => $pair_counts,
    //                     );
    //                     add('tbl_income_wallet', $incomeArr);
    //                     // update('tbl_users',['user_id' => $point_user['user_id']],['incomeLimit' => ($point_user['incomeLimit'] + $incomeArr['amount'])]);
    //                 // }

    //                 if($point_user['capping'] > $userIncome){
    //                     $againReceiver[$ar]['capping'] = $point_user['capping'] - $incomeArr['amount'];
    //                     $ar++;
    //                 }
    //             }
    //         } else {
    //             echo 'No Today Earning<br>';
    //         }
    //     } else {
    //         echo 'No Today Matching<br>';
    //     }

    //     $matching_income = 0;
    //     echo 'First Round<br>';
    //     pr($againReceiver);
    //     if(!empty($receiverAmount) && $receiverAmount > 0 && !empty($againReceiver)){
    //         $this->calculateFinalBinary($receiverAmount,$cyclePair,$againReceiver);
    //     } else {
    //         echo '2nd cycle amount is '.$receiverAmount.'<br>';
    //     }
    //     // pr($response);
    //     die('code executed Successfully');
    // }

    private function calculateFinalBinary($receiverAmount, $cyclePair, $againReceiver)
    {

        $againReceiver2 = [];
        $receiverAmount2 = 0;
        $ar = 0;
        $cyclePair2 = 0;

        $perPairValue = $receiverAmount / $cyclePair;

        echo 'Total Pair ' . $cyclePair . ' & amount is ' . $receiverAmount . ' & per pair value ' . $perPairValue . '<br';
        if (!empty($againReceiver)) {
            foreach ($againReceiver as $agr) {
                $creditValue = $agr['points'] * $perPairValue;

                if ($agr['capping'] > $creditValue) {
                    $creditValue = $creditValue;

                    $againReceiver2[$ar]['user_id'] = $agr['user_id'];
                    $againReceiver2[$ar]['incomeLimit'] = $agr['incomeLimit'];
                    $againReceiver2[$ar]['incomeLimit2'] = $agr['incomeLimit2'];
                    $againReceiver2[$ar]['points'] = $agr['points'];

                    $cyclePair2 = $cyclePair2 + $agr['points'];
                } else {
                    $receiverAmount2 = $receiverAmount2 + ($creditValue - $agr['capping']);
                    $creditValue = $agr['capping'];
                }

                // if($agr['incomeLimit2'] > $agr['incomeLimit']){
                //     $totalCredit = $agr['incomeLimit'] + $creditValue;
                //     if($totalCredit < $agr['incomeLimit2']){
                $matching_income = $creditValue;
                // } else {
                //     $matching_income = $agr['incomeLimit2'] - $agr['incomeLimit'];
                // }

                $incomeArr = array(
                    'user_id' => $agr['user_id'],
                    'amount' => $matching_income,
                    'type' => 'balancing_income',
                    'description' => 'Point Balancing Bonus',
                    'per_pair_amount' =>  $perPairValue,
                    'total_pair' => $cyclePair,
                );
                add('tbl_income_wallet', $incomeArr);


                // update('tbl_users',['user_id' => $agr['user_id']],['incomeLimit' => ($agr['incomeLimit'] + $incomeArr['amount'])]);
                // }
                if ($agr['capping'] > $creditValue) {
                    if (!empty($incomeArr['amount'])) {
                        $againReceiver2[$ar]['capping'] = $agr['capping'] - $incomeArr['amount'];
                    } else {
                        $againReceiver2[$ar]['capping'] = $agr['capping'];
                    }
                    $ar++;
                }
            }

            if (!empty($receiverAmount2) && $receiverAmount2 > 0) {
                echo 'Repeat Round<br>';
                pr($againReceiver2);
                $this->calculateFinalBinary($receiverAmount2, $cyclePair2, $againReceiver2);
            }
        } else {
            echo 'No 2nd cycle receiver<br>';
        }
    }





    private function generation_income($user_id, $amount, $sender_id)
    {
        for ($i = 1; $i <= 5; $i++) {
            $user = get_single_record('tbl_users', ['user_id' => $user_id], 'user_id,sponser_id,package_amount,paid_status,incomeLimit,incomeLimit2');
            if (!empty($user)) {
                if ($i == 1 && ($user['package_amount'] == '200' || $user['package_amount'] >= '500')) {
                    if ($user['package_amount'] == '200') :
                        $percent = 0.005;
                    else :
                        $percent = 0.005;
                    endif;
                    if ($user['incomeLimit2'] > $user['incomeLimit']) {
                        $totalCredit = $user['incomeLimit'] + $amount * $percent;
                        if ($totalCredit < $user['incomeLimit2']) {
                            $leadership_bonus = $amount * $percent;
                        } else {
                            $leadership_bonus = $user['incomeLimit2'] - $user['incomeLimit'];
                        }
                        $incomeArr = array(
                            'user_id' => $user['user_id'],
                            'amount' => $leadership_bonus,
                            'type' => 'leadership_bonus',
                            'description' => 'Leadership Bonus From ' . $sender_id . ' at level ' . $i,
                        );
                        add('tbl_income_wallet', $incomeArr);
                        update('tbl_users', ['user_id' => $user['user_id']], ['incomeLimit' => ($user['incomeLimit'] + $incomeArr['amount'])]);
                    }
                } elseif ($i == 2 && $user['package_amount'] >= '1000') {
                    $percent = 0.005;
                    if ($user['incomeLimit2'] > $user['incomeLimit']) {
                        $totalCredit = $user['incomeLimit'] + $amount * $percent;
                        if ($totalCredit < $user['incomeLimit2']) {
                            $leadership_bonus = $amount * $percent;
                        } else {
                            $leadership_bonus = $user['incomeLimit2'] - $user['incomeLimit'];
                        }
                        $incomeArr = array(
                            'user_id' => $user['user_id'],
                            'amount' => $leadership_bonus,
                            'type' => 'leadership_bonus',
                            'description' => 'Leadership Bonus From ' . $sender_id . ' at level ' . $i,
                        );
                        add('tbl_income_wallet', $incomeArr);
                        update('tbl_users', ['user_id' => $user['user_id']], ['incomeLimit' => ($user['incomeLimit'] + $incomeArr['amount'])]);
                    }
                } elseif ($i == 3 && $user['package_amount'] >= '2000') {
                    $percent = 0.005;
                    if ($user['incomeLimit2'] > $user['incomeLimit']) {
                        $totalCredit = $user['incomeLimit'] + $amount * $percent;
                        if ($totalCredit < $user['incomeLimit2']) {
                            $leadership_bonus = $amount * $percent;
                        } else {
                            $leadership_bonus = $user['incomeLimit2'] - $user['incomeLimit'];
                        }
                        $incomeArr = array(
                            'user_id' => $user['user_id'],
                            'amount' => $leadership_bonus,
                            'type' => 'leadership_bonus',
                            'description' => 'Leadership Bonus From ' . $sender_id . ' at level ' . $i,
                        );
                        add('tbl_income_wallet', $incomeArr);
                        update('tbl_users', ['user_id' => $user['user_id']], ['incomeLimit' => ($user['incomeLimit'] + $incomeArr['amount'])]);
                    }
                } elseif ($i == 4 && $user['package_amount'] >= '2000') {
                    if ($user['package_amount'] == '2000' || $user['package_amount'] == '2500') :
                        $percent = 0.005;
                    else :
                        $percent = 0.005;
                    endif;
                    if ($user['incomeLimit2'] > $user['incomeLimit']) {
                        $totalCredit = $user['incomeLimit'] + $amount * $percent;
                        if ($totalCredit < $user['incomeLimit2']) {
                            $leadership_bonus = $amount * $percent;
                        } else {
                            $leadership_bonus = $user['incomeLimit2'] - $user['incomeLimit'];
                        }
                        $incomeArr = array(
                            'user_id' => $user['user_id'],
                            'amount' => $leadership_bonus,
                            'type' => 'leadership_bonus',
                            'description' => 'Leadership Bonus From ' . $sender_id . ' at level ' . $i,
                        );
                        add('tbl_income_wallet', $incomeArr);
                        update('tbl_users', ['user_id' => $user['user_id']], ['incomeLimit' => ($user['incomeLimit'] + $incomeArr['amount'])]);
                    }
                } elseif ($i == 5 && $user['package_amount'] == '10000') {
                    $percent = 0.005;
                    if ($user['incomeLimit2'] > $user['incomeLimit']) {
                        $totalCredit = $user['incomeLimit'] + $amount * $percent;
                        if ($totalCredit < $user['incomeLimit2']) {
                            $leadership_bonus = $amount * $percent;
                        } else {
                            $leadership_bonus = $user['incomeLimit2'] - $user['incomeLimit'];
                        }
                        $incomeArr = array(
                            'user_id' => $user['user_id'],
                            'amount' => $leadership_bonus,
                            'type' => 'leadership_bonus',
                            'description' => 'Leadership Bonus From ' . $sender_id . ' at level ' . $i,
                        );
                        add('tbl_income_wallet', $incomeArr);
                        update('tbl_users', ['user_id' => $user['user_id']], ['incomeLimit' => ($user['incomeLimit'] + $incomeArr['amount'])]);
                    }
                }
                $leadership_bonus = 0;
                $user_id = $user['sponser_id'];
            }
        }
    }


    private function levelIncome($user_id, $linkedID)
    {
        $direct = 0;
        for ($i = 1; $i <= 20; $i++) :
            if ($i % 2 != 0) {
                $direct += 1;
            }
            $incomeArr[$i] = ['amount' => 10, 'direct' => $direct];
        endfor;
        foreach ($incomeArr as $key => $income) :
            $userinfo = get_single_record('tbl_users', ['user_id' => $user_id], 'user_id,sponser_id,directs');
            if (!empty($userinfo['user_id'])) :
                if ($userinfo['directs'] >= $income['direct']) :
                    $incomeArr = array(
                        'user_id' => $userinfo['user_id'],
                        'amount' => $income['amount'],
                        'type' => 'booster_level_income',
                        'description' => 'Booster Level Income From User ' . $linkedID,
                    );
                    pr($incomeArr);
                    add('tbl_income_wallet', $incomeArr);
                endif;
                $user_id = $userinfo['sponser_id'];
            endif;
        endforeach;
    }

    public function deactiveUser()
    {
        $users = get_records('tbl_users', ['user_id !=' => 'T11111', 'paid_status' => 1], 'user_id,package_id,package_amount,topup_date');
        foreach ($users as $user) :
            $date1 = date('Y-m-d');
            $date2 = date('Y-m-d', strtotime($user['topup_date'] . ' + 20 days'));
            $diff = strtotime($date1) - strtotime($date2);
            if ($diff > 0) {
                $topupData = [
                    'paid_status' => 0,
                    'package_id' => 0,
                    'package_amount' => 0,
                    'topup_date' => '0000-00-00 00:00:00',
                    'retopup' => 1,
                ];
                update('tbl_users', ['user_id' => $user['user_id']], $topupData);
            }
        endforeach;
    }

    public function rewardCron()
    {
        $rewards = [
            1 => ['business' => 5000, 'amount' => 111, 'rank' => 'STAR'],
            2 => ['business' => 20000, 'amount' => 333, 'rank' => 'BRONZE '],
            3 => ['business' => 70000, 'amount' => 1000, 'rank' => 'SILVER'],
            4 => ['business' => 220000, 'amount' => 3000, 'rank' => 'GOLD'],
            5 => ['business' => 720000, 'amount' => 3000, 'rank' => 'PLATINUME'],
            6 => ['business' => 2220000, 'amount' => 100000, 'rank' => 'PEAR '],
            7 => ['business' => 7220000, 'amount' => 300000, 'rank' => 'RUBY '],
            8 => ['business' => 22220000, 'amount' => 1000000, 'rank' => 'DIAMOND'],
            9 => ['business' => 72220000, 'amount' => 3000000, 'rank' => 'BLUE DIAMOND'],
            10 => ['business' => 222220000, 'amount' => 10000000, 'rank' => 'WHITE DIAMOND'],
        ];
        foreach ($rewards as $key => $reward) {
            // $users = $this->Main_model->getBusiness($reward['business']);
            $users = get_records('tbl_users', ['leftPower >=' => $reward['business'], 'rightPower >=' => $reward['business']], 'user_id');
            //pr($users,true);
            foreach ($users as $key2 => $user) {
                $check = get_single_record('tbl_rewards', ['award_id' => $key, 'user_id' => $user['user_id']], '*');
                if (empty($check)) {
                    // $position_directs = $this->Main_model->count_position_directs($user['user_id']);
                    // if(!empty($position_directs) && count($position_directs) == 2){
                    // pr($user);
                    // if($key > 5){
                    //     $d = 2;
                    //     $direct2 = get_single_record('tbl_users',['sponser_id' => $user['user_id'],'rewardLevel' => ($key - 1)],'count(id) as direct');
                    // } else {
                    //     $direct2 = 0;
                    //     $d = 0;
                    // }
                    //if($direct2['direct'] >= $d){
                    $rewardData = [
                        'user_id' => $user['user_id'],
                        'amount' => $reward['amount'],
                        'rank' => $reward['rank'],
                        'award_id' => $key,
                    ];
                    add('tbl_rewards', $rewardData);
                    pr($rewardData);
                    $IncomeData = [
                        'user_id' => $user['user_id'],
                        'amount' => $reward['amount'],
                        'type' => 'reward_income',
                        'description' => 'You have Achieved your ' . $key . ' Reward Income ',
                    ];
                    pr($IncomeData);
                    add('tbl_reward_wallet', $IncomeData);
                    update('tbl_users', ['user_id' => $user['user_id']], ['rewardLevel' => $key]);
                    //}
                    //}
                }
            }
        }
    }

    public function resetDailyLimit()
    {
        $date = date('Y-m-d');
        $cron = get_single_record('tbl_cron', ['date' => $date, 'cron_name' => 'resetDailyLimit'], '*');
        if (empty($cron)) {
            update('tbl_users', ['incomeLimit >' => 0], ['incomeLimit' => 0]);
            add('tbl_cron', ['cron_name' => 'resetDailyLimit', 'date' => $date]);
        } else {
            echo 'Today daily limit reset done';
        }
    }

    public function resetPackageLimit()
    {
        $date = date('Y-m-d');
        $users = get_records('tbl_users', ['paid_status' => 1, 'retopup' => 0], 'user_id,package_amount,retopup_count');
        foreach ($users as $user) {
            $checkBalance = get_single_record('tbl_income_wallet', ['amount >' => 0, 'user_id' => $user['user_id']], 'ifnull(sum(amount),0) as balance');
            $totalBalance = $checkBalance['balance'];
            if ($totalBalance >= ($user['package_amount'] * 5)) {
                pr($user);
                update('tbl_users', ['user_id' => $user['user_id']], ['retopup' => 1, 'package_amount' => 0, 'topup_date' => '0000-00-00 00:00:00', 'retopup_count' => ($user['retopup_count'] + 1)]);
            }
        }
    }

    public function IncomesSet()
    {
        $users = get_records('tbl_users', ['paid_status' => 1], '*');
        foreach ($users as $user) {
            $checkUser = get_single_record('tbl_income_wallet', ['user_id' => $user['user_id']], '*');
            $direct_income = get_single_record('tbl_income_wallet', ['amount >' => 0, 'user_id' => $user['user_id'], 'type' => 'direct_income'], 'ifnull(sum(amount),0) as balance');
            $level_income = get_single_record('tbl_income_wallet', ['amount >' => 0, 'user_id' => $user['user_id'], 'type' => 'level_income'], 'ifnull(sum(amount),0) as balance');
            if ($checkUser) {
                $updateData = array(
                    'direct_income' => $direct_income['balance'],
                    'level_income' => $level_income['balance'],
                );
                pr($updateData);
                update('tbl_incomes', ['user_id' => $user['user_id']], $updateData);
            } else {
                $addData = array(
                    'user_id' => $user['user_id'],
                    'direct_income' => $direct_income['balance'],
                    'level_income' => $level_income['balance'],
                );
                pr($addData);
                add('tbl_incomes', $addData);
            }
        }
    }

    public function approveFund()
    {
        $request = get_records('tbl_payment_request', array('status' => 0), '*');
        foreach ($request as $key => $req) {
            if ($req['status'] == 0) {
                $walletData = array(
                    'user_id' => $req['user_id'],
                    'amount' => $req['amount'],
                    'sender_id' => $req['user_id'],
                    'type' => 'auto_fund',
                    'remark' => 'Auto Fund Deposit',
                );
                pr($walletData);
                add('tbl_wallet', $walletData);
                update('tbl_payment_request', ['id' => $req['id']], ['status' => 1]);
            }
        }
    }

    public function WithdrawCron()
    {
        $date = date('Y-m-d');
        // $cron = get_single_record('tbl_cron',"cron_name = 'withdraw_cron' and date = '".$date."'",'*');
        // if(empty($cron)):
        $users = $this->Main_model->withdraw_users(200);
        pr($users);
        foreach ($users as $key => $user) {
            $checkKYC = get_single_record('tbl_bank_details', ['user_id' => $user['user_id'], 'kyc_status' => 2], '*');
            $userinfo = get_single_record('tbl_users', ['user_id' => $user['user_id']], '*');
            if (!empty($checkKYC['bank_account_number'])) :
                $DirectIncome = array(
                    'user_id' => $user['user_id'],
                    'amount' => -$user['total_amount'],
                    'type' => 'withdraw_request',
                    'description' => 'Withdraw Request',
                );
                add('tbl_income_wallet', $DirectIncome);
                $withdrawArr = array(
                    'user_id' => $user['user_id'],
                    'amount' => $user['total_amount'],
                    'type' => 'withdraw_request',
                    'tds' => $user['total_amount'] * 5 / 100,
                    'admin_charges' => $user['total_amount']  * 5 / 100,
                    'fund_conversion' => 0,
                    'zil_address' => $userinfo['eth_address'],
                    'payable_amount' => $user['total_amount'] * 90 / 100
                );
                add('tbl_withdraw', $withdrawArr);
            endif;
        }
        redirect('Admin/Management');
        // add('tbl_cron',['cron_name' => 'withdraw_cron','date' => $date]);
        // else:
        //     echo 'Today Cron already run';
        // endif;
    }

    public function updateTokenValue()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.vindax.com/api/v1/ticker/24hr?symbol=MPYUSDT',
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
        $jsonData = json_decode($response, true);
        pr($jsonData['lastPrice']);
        update('tbl_token_value', ['id' => 1], ['amount' => $jsonData['lastPrice'], 'sellValue' => $jsonData['lastPrice']]);
    }

    public function test_node_api()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://18.216.195.54:3490/',
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
        $jsonData = json_decode($response, true);
        pr($jsonData);
    }

    // public function TimeCron(){
    //     $tokenValue = get_single_record('tbl_token_value',['id' => 1],'*');
    //     $date1 = date('Y-m-d');
    //     $date2 = date('Y-m-d',strtotime($tokenValue['created_at'].' + 7 days'));
    //     $diff = strtotime($date1) - strtotime($date2);
    //     if($diff > 0){
    //         $topupData = [
    //             'amount' => $tokenValue['sellValue'],
    //             'sellValue' => 0.00,
    //             'topup_date' => $date2;,
    //         ];
    //         update('tbl_token_value',['id' => 1],$topupData);
    //     }
    // }

    public function boosterIncome()
    {
        $booster_users = get_records('tbl_boosting', array('type' => 'boosting_transfer'), '*');
        foreach ($booster_users as $key => $user) {
            $UserCheck = get_single_record('tbl_boosting', ['user_id' => $user['user_id'], 'id > ' => $user['id']], 'count(id) as ids,user_id');
            if ($UserCheck['ids'] >= 40) {
                if ($user['level'] == 1 && $user['level'] == 2) {
                    $incomeArr = array(
                        'user_id' => $user['user_id'],
                        'amount' => $user['roi_amount'],
                        'type' => 'booster_income',
                        'description' => 'Booster Income at ' . $user['package_id'] . ' Package',
                    );
                    pr($incomeArr);
                    add('tbl_income_wallet', $incomeArr);
                    update('tbl_boosting', array('id' => $user['id']), array('status' => 1));
                } else {
                    $check = get_single_record('tbl_boosting', 'user_id = "' . $user['user_id'] . '" and status = "1" and level != "1" and level != "2"', 'count(id) as ids');
                    if ($check['ids'] >= 1) {
                        $Directs = get_single_record('tbl_users', ['sponser_id' => $user['user_id'], 'paid_status' => 1], 'count(id) as ids');
                        if ($Directs['ids'] >= 1) {
                            $incomeArr = array(
                                'user_id' => $user['user_id'],
                                'amount' => $user['roi_amount'],
                                'type' => 'booster_income',
                                'description' => 'Booster Income at ' . $user['package_id'] . ' Package',
                            );
                            pr($incomeArr);
                            add('tbl_income_wallet', $incomeArr);
                            update('tbl_boosting', array('id' => $user['id']), array('status' => 1));
                        }
                    } else {
                        $incomeArr = array(
                            'user_id' => $user['user_id'],
                            'amount' => $user['roi_amount'],
                            'type' => 'booster_income',
                            'description' => 'Booster Income at ' . $user['package_id'] . ' Package',
                        );
                        pr($incomeArr);
                        add('tbl_income_wallet', $incomeArr);
                        update('tbl_boosting', array('id' => $user['id']), array('status' => 1));
                    }
                }
            }
        }
    }

    public function fornightlyCron()
    {
        $cron = get_single_record('tbl_cron', '  date(created_at) = date(now()) and cron_name = "fortnightly_divined_income"', '*');
        $dividend = get_single_record_desc('tbl_dividend_income', [], 'fortnightly_income');

        if (empty($cron)) {
            $currentmonth = date('m');
            $lastDateOfMonth = $this->getLastDateOfMonth($currentmonth);
            if ($lastDateOfMonth == 31) {
                $minusDays = 16;
                $minusDays2 = 15;
            } else {
                $minusDays = 15;
                $minusDays2 = 15;
            }
            // echo $minusDays;
            // echo '<br>';
            $date1 = '2023-08-01'; //date('Y-m-d');
            $date2 = date('Y-m-d', strtotime($date1 . '-' . $minusDays . ' days'));
            //    echo $date2 ;
            $total_business = get_single_record('tbl_activation_details', ['date(created_at) >=' => $date2, 'date(created_at) <' => $date1], 'ifnull(sum(amount),0) as total_business');
            // echo '<br>';
            // echo $total_business['total_business'];

            //get users for distributions//
            $previousDate = $date2;
            $distributionDate = date('Y-m-d', strtotime($previousDate . '-' . $minusDays2 . ' days'));
            $wokringUsers = get_records('tbl_users', ['date(topup_date) >=' => $distributionDate, 'date(topup_date) <' => $previousDate, 'directs >=' => 1], 'user_id');
            $notwokringUsers = get_records('tbl_users', ['date(topup_date) >=' => $distributionDate, 'date(topup_date) <' => $previousDate], 'user_id');

            $all_users = count($wokringUsers);
            $notworkusers = count($notwokringUsers);

            echo '<br>';
            echo $distributionDate;
            echo '<br>';
            echo $all_users;
            if ($total_business['total_business'] > 0 && !empty($wokringUsers)) {
                $cal = $total_business['total_business'] * $dividend['fortnightly_income'];
                // $cal = $total_business['total_business'] * 0.075;
                $perID = $cal / $all_users;
                foreach ($wokringUsers as $w => $wu) {
                    $workIncome = [
                        'user_id' =>   $wu['user_id'],
                        'amount' =>   $perID,
                        'type' =>   'fortnightly_divined_income',
                        'description' =>   'Fortnightly Divined Working Income',

                    ];
                    pr($workIncome);

                    add('tbl_income_wallet', $workIncome);
                }
            }
            if ($total_business['total_business'] > 0 && !empty($notwokringUsers)) {
                $secondCal = $total_business['total_business'] * $dividend['fortnightly_income'];
                $perUsers = $secondCal / $notworkusers;

                foreach ($notwokringUsers as $n => $nwu) {
                    $notworkIncome = [
                        'user_id' =>   $nwu['user_id'],
                        'amount' =>   $perUsers,
                        'type' =>   'fortnightly_divined_income',
                        'description' =>   'Fortnightly Divined Not Wokring Income',

                    ];
                    pr($notworkIncome);
                    add('tbl_income_wallet', $notworkIncome);
                }
            }
            add('tbl_cron', array('cron_name' => 'fortnightly_divined_income'));
        } else {
            echo 'Income Already Distributed!';
        }
    }


    public function BoosterAchiever()
    {
        $date = date('Y-m-d');
        if (date('D') == 'Sun' || date('D') == 'Sat') {
            die('its weekend');
        }
        $cron = get_single_record('tbl_cron', ['date' => $date, 'cron_name' => 'booster'], '*');
        if (empty($cron)) {
            add('tbl_cron', ['cron_name' => 'booster', 'date' => $date]);
            $users = get_records('tbl_users', ['booster_achiever' => 1], 'user_id,total_limit,pending_limit');
            foreach ($users as $key => $boost) {
                $package = get_records('tbl_activation_details', 'user_id ="' . $boost['user_id'] . '" order by id ASC Limit 1', 'package');
                if ($sponser['total_limit'] > $sponser['pending_limit']) {
                    $totalCredit = $boost['pending_limit'] + ($package * 0.02);
                    if ($totalCredit < $boost['total_limit']) {
                        $booster_income = ($package * 0.02);
                    } else {
                        $booster_income = $sponser['total_limit'] - $boost['pending_limit'];
                    }
                    $BoostIncome = array(
                        'user_id' => $boost['user_id'],
                        'amount' => $booster_income,
                        'type' => 'booster_income',
                        'description' => " Booster Income",
                    );
                    add('tbl_income_wallet', $BoostIncome);
                    update('tbl_users', ['user_id' => $boost['user_id']], ['pending_limit' => ($boost['pending_limit'] + $BoostIncome['amount'])]);
                }
            }
        } else {
            echo "today cron run ";
        }
    }


    public function businessCalculationReward()
    {
        $rewards = $this->config->item('rewards');
        foreach ($rewards as $rkey => $reward) {
            $users = get_records('tbl_users', ['paid_status >' => 0], '*');
            foreach ($users as $key => $user) {
                $getDirects = get_records('tbl_users', ['sponser_id' => $user['user_id']], 'user_id');
                $directArr = [];
                foreach ($getDirects as $key2 => $gd) {
                    $selfBusiness = get_single_record('tbl_users', ['user_id' => $gd['user_id']], 'total_package');
                    $getBusiness = $this->Main_model->getTeamBusiness($gd['user_id']);
                    $directArr[$key2] = [
                        'user_id' => $gd['user_id'],
                        'downline_id' => $getBusiness['downline_id'],

                        'business' => $getBusiness['business'] + $selfBusiness['total_package'],
                        'directBusiness' => $selfBusiness['total_package'],
                    ];
                    // pr($directArr[$key2],true);
                }
                $columns = array_column($directArr, 'business');
                array_multisort($columns, SORT_DESC, $directArr);
                $teamA = 0;
                $teamB = 0;
                $secondLeg = 0;
                $thirdLeg = 0;
                $directBusiness = 0;

                // $fourthLeg = 0;
                foreach ($directArr as $dkey => $da) {
                    $directBusiness += $da['directBusiness'];
                    if ($dkey == 0) {
                        $teamA = $da['business'];
                    } else {
                        $teamB += $da['business'];
                        if ($dkey == 1) {
                            $secondLeg = $da['business'];
                        }
                        if ($dkey == 2) {
                            $thirdLeg += $da['business'];
                        }
                        // if($dkey == 4){
                        //     $fourthLeg = $da['business'];
                        // }
                    }
                }

                $response = [
                    'user_id' => $user['user_id'],
                    // 'teamBusiness' => $teamA,
                    'directBusiness' => $directBusiness,
                    'firstLeg' => $teamA,
                    'secondLeg' => $secondLeg,
                    'thirdLeg' => $thirdLeg,
                    // 'fourthLeg' => $fourthLeg,
                ];
                pr($response);
                if ($response['firstLeg']  >= ($reward['team_business'] * 0.40) && $response['secondLeg'] >= ($reward['team_business'] * 0.30) && $response['thirdLeg'] >= ($reward['team_business'] * 0.30)) {
                    $check = get_single_record('tbl_rewards', ['award_id' => $rkey, 'user_id' => $user['user_id']], '*');
                    $rewardCheck = get_single_record('tbl_users', ['user_id' => $user['user_id']], 'reward_income');
                    if ($rewardCheck['reward_income'] == 0) {
                        if (empty($check)) {
                            $rewardData = [
                                'user_id' => $user['user_id'],
                                'amount' => $reward['bonus'],
                                'award_id' => $rkey,
                            ];
                            add('tbl_rewards', $rewardData);
                            echo '<p style="color:green;"> Reward Credited....</p>';
                            pr($rewardData);
                        }
                    }
                }
            }
        }
    }
}
