<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 2018/5/5
 * Time: 12:42
 */

namespace app\timertask\command;


use app\account\model\User;
use think\console\Input;
use think\console\Output;
use think\console\Command;
use think\Db;
use think\Log;

class AutoRenew1 extends command
{
    protected function configure()
    {
        $this->setName('e')->setDescription('每天定时扫描自动续费');
    }

    protected function execute(Input $input, Output $output)
    {
        ignore_user_abort();
        set_time_limit(0);
        $interval = 5;

        // while 条件为真，执行语句块
         do {
             $day = 0;
             $beginTime = mktime(0, 0, 0, date('m', strtotime("-".$day."day")), date("d", strtotime("-".$day."day")), date('Y', strtotime("-".$day ."day")));
             $user = Db::query("select * from pa_user where auto_renew=1 and group_id>0 and end_time>'.$beginTime.' limit 1000");//and end_time<='.$beginTime.'
             if (!$user) {
                 $output->writeln("没有可续费的订单!");
             } elseif ($user) {
                 foreach ($user as $key => $value) {
//                        dump($value['realname']);
                     // continue;
                     $id = $value['id'];
                     $value_1 = $value['group_id'];
                     $value_2 = $value['money_left'];
                    // var_dump('id+++id：'.$valueId);var_dump('zhi1+++group_id：'.$value_1);var_dump('zhi2+++money_left：'.$value_2);
                     //判断套餐类型
                     if ($value_1==1) {  //标准版用户$value[$i]['group_id']
                         if ($value_2>2999) {  //用户余额大于套餐余额$value[$i]['money_left']
                             //扣费并延长到期时间
//                             Db::execute("update pa_user set money_left=money_left-2999 where id='.$valueId.'");//$value[$i]['id']
//                             Db::execute("update pa_user set end_time=end_time+2678400 where id='.$valueId.'");
//                             var_dump("11++：".$result_1);
//                             var_dump("22++：".$result_2);
                             $cost=2999;
                             User::where("id",$id)->update([
                                 'money_left'=>['exp','money_left-'.$cost]
                             ]);
                             var_dump('ssssss:'.User::getLastSql());
                             Log::write('标准版套餐自动续费成功！');
                         } else {
                             Log::write('标准版套餐自动续费失败，余额不足！');
                         }
                     } elseif ($value_1==2) {  //高级版用户$value[$i]['group_id']
                         if ($value_2>5999) {  //用户余额大于套餐余额$value[$i]['money_left']
                             //扣费并延长到期时间
//                             Db::execute("update pa_user set money_left=money_left-5999 where id='.$valueId.'");
//                             Db::execute("update pa_user set end_time=end_time+2678400 where id='.$valueId.'");
                             $cost=5999;
                             User::where("id",$id)->update([
                                 'money_left'=>['exp','money_left-'.$cost]
                             ]);
                            var_dump(User::getLastSql());
//                             var_dump("33++：".$result_3);
//                             var_dump("44++：".$valueId);
                             Log::write('高级版套餐自动续费成功！');
                         } else {
                             Log::write('高级版套餐自动续费失败，余额不足！');
                         }
                     } elseif ($value_1==3) {  //专业版用户$value[$i]['group_id']
                         if ($value_2>9999) {  //用户余额大于套餐余额$value[$i]['money_left']
                             //扣费并延长到期时间Db::execute("update pa_user set money_left=money_left-9999 where id='.$valueId.'");
                             $cost=9999;
                             User::where("id",$id)->update([
                                 'money_left'=>['exp','money_left-'.$cost]
                             ]);
                            var_dump(User::getLastSql());
                             //Db::execute("update pa_user set end_time=end_time+2678400 where id='.$valueId.'");
//                             var_dump("55++:".$result_5);
//                             var_dump("66++:".$result_6);
                             Log::write('专业版套餐自动续费成功！');
                         } else {
                             Log::write('专业版套餐自动续费失败，余额不足！');
                         }
                     }
                 }

                     }
                     }while (0) ;
                sleep($interval);
             // 执行完毕，输出提示信息
             $output->writeln("执行完成!");

         }
    }

