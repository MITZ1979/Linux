<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/7
 * Time: 21:10
 */
namespace app\test\Controller;
use app\account\model\User;
use Phinx\Db\Table;
use think\Db;
use think\Request;

class Test
{
    public function test()
    {
        //$sql=Db::execute("SELECT * FROM pa_user WHERE auto_renew=1");
//        $id=User::all();
//        $id=User::where('auto_renew',1)->field('id','money_left')->find();

        $group_3=User::where('auto_renew',1)->where('money_left',">=",99.99)->find();
        $group_3=User::where('auto_renew',1)->where('money_left',">=",99.99)->find();

        $group_id[]=Db::query("select * from pa_user where auto_renew=1");
        $number=field('auto_renew')->select();
        foreach ($group_id as $row){
            $id=$group_it['id']= $row[0]['id'];
            $group_id1=$group_it['group_id']= $row[0]['group_id'];
        }

        //$id=User::where( 'auto_renew',1)->where('money_left',">",99.99)->select();
       // $list = User::where('id')->find();
        return printf($number);//($group_id);//
    }
}
