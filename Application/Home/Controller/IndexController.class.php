<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    private $luckList = [1=>'一等奖',2=>'二等奖',3=>'三等奖',4=>'四等奖'];

    public function index(){
    	$Bingo = D('Bingo');
        // 防止页面刷新清除中奖历史
        $history = $Bingo->where(['type'=>['neq',0],'flat'=>['neq',0]])->field('name,type')->order('type DESC')->select();
        if( $history ){
            foreach ($history as &$value) {
                $value['typename'] = $this->luckList[$value['type']];
                $value['color']    = $this->_getBlockColor($value['type']);
            }
        }
        $this->assign('history',$history);
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

    private function _getBlockColor($type = 1){
        $colorList = [1=>'palette-pomegranate',2=>'palette-wisteria',3=>'palette-peter-river',4=>'palette-emerald'];
        return $colorList[$type];
    }

    /**
     * 抽取一个
     * @return [type] [description]
     */
    public function getOne(){
    	$Bingo = D('Bingo');
        $type  = I('type');
    	$res = $Bingo->draw($type);
    	$this->ajaxReturn(['name'=>$res,'typename'=>$this->luckList[$type],'type'=>$type]);
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