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
use think\Db;
use think\console\Input;
use think\console\Output;
use think\console\Command;
use think\Log;

class AutoRenew extends command
{
    protected function configure()
    {
        $this->setName('auto-renew')->setDescription('每天定时扫描自动续费');
    }

    protected function execute(Input $input, Output $output)
    {

        $setMeal = input('get.money_left');

        while (1 == 1) {
            $list = User::where('auto_renew',1)->find();
            if (!empty($list)) {

                $sql_kf = Db::execute("SELECT id WHERE auto_renew=1 and money_left<'.$setMeal.'");
                if (!empty($sql_kf)) {
                    Log::write('用户账户余额不足！');
                    break;
                } else {
                    // 执行扣取相关费业务
                    foreach ($numbers as $value) {
                        $sql = Db::execute("UPDATE pa_user SET money_left=money_left-'.$setMeal.'");
                    }
                }
                // 执行下一个扣费任务

                $number = 0;
                Log::write('number:');
                if ($number === false) {
                    Log::write('读取数据user表ID失败1');
                    break;
                } elseif ($number == 0) {
                    Log::write('读取数据user表ID成功1:');
                    break;
                } else {
                    $output->writeln("执行2");
                }
            }}}}

while (1==1) {
    $day = 1;
    $beginTime=mktime(0,0,0,date('m',strtotime("-".$day." day")),date("d",strtotime("-".$day." day")),date('Y',strtotime("-".$day." day")));

    $user=Db::query("select * from pa_user where auto_renew=1");
    foreach ($user as $row){

        $user['id']= $row[0]['id'];
        $user['group_id']= $row[0]['group_id'];

    }

    if($autoRenew){
        $user =  Db::query("select * from pa_user where auto_renew='.$autoRenew.'");

        if($begingTime>=$endTime&&$moneyLeft>=$group_price){
            //1.会员账户余额-套餐费
            //(0pa_user.money_left)-taocanfei
            $userId=null;
            $num='';
            $sql="update pa_user set money_left=money_left-:price where id='.$userId.' and group_id=:num";
            if ($group_id == "group1"){
                switch ($longtimeselect){
                    case "1":
                        Db::execute($sql,['price'=>29.99]);
                        break;
                    case "6":
                        Db::execute("update pa_user set money_left=money_left-158.35 where id=".$userId." and group_id=1");
                        $reason_detail = '续费6个月基础版套餐';
                        break;
                    case "12":
                        Db::execute("update pa_user set money_left=money_left-298.7 where id=".$userId." and group_id=1");
                        $reason_detail = '续费1年基础版套餐';
                        break;
                    case "24":
                        Db::execute("update pa_user set money_left=money_left-503.83 where id=".$userId." and group_id=1");
                        $reason_detail = '续费2年基础版套餐';
                        break;
                    case "36":
                        Db::execute("update pa_user set money_left=money_left-539.82,end_time=end_time+:usertime where id=".$userId." and group_id=1");
                        $reason_detail = '续费3年基础版套餐';
                        break;
                    default:
                        $price = 0;
                }
            } elseif ($group_id == "group2"){
                switch ($longtimeselect){
                    case "1":
                        $price = config('group_price.group_2_price_1');
                        $reason_detail = '续费1个月高级版套餐';
                        break;
                    case "6":
                        $price = config('group_price.group_2_price_6');
                        $reason_detail = '续费6个月高级版套餐';
                        break;
                    case "12":
                        $price = config('group_price.group_2_price_12');
                        $reason_detail = '续费1年高级版套餐';
                        break;
                    case "24":
                        $price = config('group_price.group_2_price_24');
                        $reason_detail = '续费2年高级版套餐';
                        break;
                    case "36":
                        $price = config('group_price.group_2_price_36');
                        $reason_detail = '续费3年高级版套餐';
                        break;
                    default:
                        $price = 0;
                }
            } elseif ($group_id == "group3"){
                switch ($longtimeselect){
                    case "1":
                        $price = config('group_price.group_3_price_1');
                        $reason_detail = '续费1个月专业版套餐';
                        break;
                    case "6":
                        $price = config('group_price.group_3_price_6');
                        $reason_detail = '续费6个月专业版套餐';
                        break;
                    case "12":
                        $price = config('group_price.group_3_price_12');
                        $reason_detail = '续费1年专业版套餐';
                        break;
                    case "24":
                        $price = config('group_price.group_3_price_24');
                        $reason_detail = '续费2年专业版套餐';
                        break;
                    case "36":
                        $price = config('group_price.group_3_price_36');
                        $reason_detail = '续费3年专业版套餐';
                        break;
                    default:
                        $price = 0;
                }
            }

            //2.使用时间加续费时间（group_time）
            //useTime+?month(user.end_time+1month)


                   //3.(pa_moneyhistory[create_time][old_money_left][new_money_left][reason][reason_detail])
                }

    }else{

        Log::write('无需续费1');
        break;
    }
}

