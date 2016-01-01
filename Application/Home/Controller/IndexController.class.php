<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){
    	$Bingo = D('Bingo');
    	$this->display();
    }

    /**
     * 获取符合条件的人员列表 仅供前端展示
     * @return [type] [description]
     */
    public function getList(){
    	$type = I('type',1);
    	$Bingo = D('Bingo');
    	$list = $Bingo->getList($type);
    	if( $list ){
    		$this->ajaxReturn(['list'=>$list,'staus'=>1]);
    	}else{
    		$this->ajaxReturn(['status'=>0,'info'=>$Bingo->getError()]);
    	}
    }

    /**
     * 抽取一个
     * @return [type] [description]
     */
    public function getOne(){
    	$Bingo = D('Bingo');
    	$res = $Bingo->draw();
    	$this->ajaxReturn(['name'=>$res]);
    }

    /**
     *  抽奖部门人数汇总
     *  ---------------------------------------------
     *  @return Void
     *  ---------------------------------------------
     *  @author : lvpenglong
     *  @since  : 2015-12-16
     */
    public function depart(){
    	$num = 30;
        $result = D('Bingo')->depart($num);
        var_dump($result);
    }
}