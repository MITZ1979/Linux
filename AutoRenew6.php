<?php

namespace app\timertask\command;

use think\Db;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Log;


class AutoRenew extends Command
{
    protected function configure()
    {
        $this->setName("a")->setDescription("自动续费套餐");
    }

    /*protected function execute(Input $input, Output $output)
    {
        //每个一段时间执行，单位秒
        $sleep_time=3;
        while (1) {
            Db::execute("update pa_user set money_left=money_left+1 where realname like '虞姬'");
            $output->writeln("money+1");
            sleep($sleep_time);
        }

        $output->writeln("over");
    }*/
    protected function execute(Input $input, Output $output)
    {

        set_time_limit(0);
        $interval=86400;
        while(1){
            $day=0;
            $beginTime=mktime(0,0,0,date('m',strtotime("-".$day." day")),date("d",strtotime("-".$day." day")),date('Y',strtotime("-".$day." day")));

            //查询满足自动续费条件的用户
            $user[]=Db::query("select * from pa_user where auto_renew=1 and group_id>0 and end_time<='.$beginTime.' limit 1000");
            Log::write('user:'.$user);

            if(empty($user)){  //没有查到满足条件的用户
                Log::write('没有需要自动续费的用户！');
            }elseif ($user){
                //计数并循环查出的用户（循环次数即查询出的用户数）
                for ($i=0;$i<=count($user);$i++){
                    foreach($user as $valu){
                        $valueId=$valu[$i]['id'];
                        $value_1=$valu[$i]['group_id'];
                        $value_2=[$i]['money_left'];
                        //判断套餐类型
                        if ($value_1==1) {  //标准版用户$value[$i]['group_id']
                            if ($value_2>2999) {  //用户余额大于套餐余额$value[$i]['money_left']
                                //扣费并延长到期时间
                                Db::execute("update pa_user set money_left=money_left-2999 where id like '.$valueId.'");//$value[$i]['id']
                                Db::execute("update pa_user set end_time=money_left+2678400 where id like '.$valueId.'");
                                Log::write('标准版套餐自动续费成功！');
                            }else{
                                Log::write('标准版套餐自动续费失败，余额不足！');
                            }
                        }elseif ($value_1==2) {  //高级版用户$value[$i]['group_id']
                            if ($value_2>5999) {  //用户余额大于套餐余额$value[$i]['money_left']
                                //扣费并延长到期时间
                                Db::execute("update pa_user set money_left=money_left-5999 where id like '.$valueId.'");
                                Db::execute("update pa_user set end_time=money_left+2678400 where id like '.$valueId.'");
                                Log::write('高级版套餐自动续费成功！');
                            }else{
                                Log::write('高级版套餐自动续费失败，余额不足！');
                            }
                        }elseif ($value_1==3) {  //专业版用户$value[$i]['group_id']
                            if ($value_2>9999) {  //用户余额大于套餐余额$value[$i]['money_left']
                                //扣费并延长到期时间
                                Db::execute("update pa_user set money_left=money_left-9999 where id like '.$valueId.'");
                                Db::execute("update pa_user set end_time=money_left+2678400 where id like '.$valueId.'");
                                Log::write('专业版套餐自动续费成功！');
                            }else{
                                Log::write('专业版套餐自动续费失败，余额不足！');
                            }
                        }
                    }
                }
            }
            sleep($interval);
        };
        // 执行完毕，输出提示信息
        $output->writeln("over!");
    }
}