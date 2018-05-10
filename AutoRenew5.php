<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 2018/5/5
 * Time: 12:42
 */

namespace app\timertask\command;


use app\account\model\User;
use app\my\model\Moneyhistory;
use think\console\Input;
use think\console\Output;
use think\console\Command;
use think\Log;

class AutoRenew5 extends command
{
    protected function configure()
    {
        $this->setName('e')->setDescription('每天定时扫描自动续费');
    }

    protected function execute(Input $input, Output $output)
    {

        // 设置变量
        $price_1=config('group_price.group_1_price_1');
        $price_2=config('group_price.group_2_price_1');
        $price_3=config('group_price.group_3_price_1');
        $success = 0;
        // while 条件为真，执行语句块
        do {
            // 设置扣费区间
            $day = 1;
            $beginTime = mktime(0, 0, 0, date('m', strtotime("-" . $day . "day")), date("d", strtotime("-" . $day . "day")), date('Y', strtotime("-" . $day . "day")));
            $endTime = mktime(23, 59, 59, date('m', strtotime("+" . $day . "day")), date("d", strtotime("+" . $day . "day")), date('Y', strtotime("+" . $day . "day")));
            $addTime=31*24*60*60;
            // 设置续费用户
            $users = User::where("auto_renew",1)
                        ->where("group_id", ">", 0)
                        ->where("end_time", ">=", $beginTime)
                        ->where("end_time", "<=", $endTime)
                        ->limit(1000)->select();
            // 需续费人数
            $count = count($users);
            Log::write("有".$count."条数据！");
            $fail = 0;
            // 无订单处理
            if (!$users) {
                $output->writeln("没有可续费的订单!");
                Log::write("没有可续费的订单!");
                break;
            } elseif ($users) {
                // 遍历续费用户
                foreach ($users as $key => $value) {
                    $uid = $value['id'];
                    $group_id = $value['group_id'];
                    $money_left = $value['money_left'];
                    //判断套餐类型
                    if ($group_id == 1) {  //标准版用户
                        if ($money_left >= $price_1) {  //用户余额大于套餐余额
                            //扣费并延长到期时
                            $group1 = User::where("id", $uid)->update([
                                'money_left' => ['exp', 'money_left-'.$price_1*100],
                                'end_time' => ['exp', 'end_time+'.$addTime]
                            ]);
                            if ($group1) {
                                $success++;
                            }
                            Log::write('标准版套餐自动续费成功！ID:'.$uid.'套餐费:'.$price_1);
                        } else {
                            Log::write('标准版套餐自动续费失败，余额不足！ID:'.$uid);
                        }
                    } elseif ($group_id == 2) {
                        // 高级版套餐
                        if ($money_left >= $price_2) {
                            //扣费并延长到期时间
                            User::where("id", $uid)->update([
                                'money_left' => ['exp', 'money_left-'.$price_2*100],
                                'end_time' => ['exp', 'end_time+'.$addTime]
                            ]);
                            //资金变动记录
                            $new_moneyleft=$money_left-$price_2*100;
                            var_dump("sss:".$new_moneyleft);

                            Moneyhistory::create([
                                'uid'     => $uid,  // 将
                                'orderid'  => '',
                                'cost'  => $newprice,
                                'isincome'      => 2,//商家支出
                                'old_moneyleft'    => $money_left,
                                'new_moneyleft'    => $new_moneyleft,
                                'reason'    => '套餐续费',
                                'reason_detail' => $reason_detail
                            ]);
//                            Moneyhistory::where('id',$id)->create([
//                                'money_left' => ['exp', 'money_left-'.$price_2],
//                                'end_time' => ['exp', 'end_time+'.$addTime]
//                            ]);
                            Log::write('高级版套餐自动续费成功！ID：'.$uid.'套餐费:'.$price_2);
                        } else {
                            Log::write('高级版套餐自动续费失败，余额不足！用户ID：'.$uid);
                        }
                    } elseif ($group_id == 3) {
                        // 专业版套餐
                        if ($money_left >= $price_3*100) {
                            //扣费并延长到期时间
                            User::where("id", $uid)->update([
                                'money_left' => ['exp', 'money_left-'.$price_3*100],
                                'end_time' => ['exp', 'end_time+'.$addTime]
                            ]);
                            Log::write('专业版套餐自动续费成功！ID:'.$uid.'套餐费:'.$price_3);
                        } else {
                            Log::write('专业版套餐自动续费失败，余额不足！ID:'.$uid);
                        }
                    }

                }
            }
        } while (1);
        // 执行完毕，输出提示信息
        $output->writeln("执行完成!");
        Log::write("执行完成!共完成".$count);
    }
}

