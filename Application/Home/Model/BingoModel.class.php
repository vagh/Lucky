<?php
namespace Home\Model;
use Think\Model;
class BingoModel extends Model {

    //获奖人数
    private $lotteryNum  = [1=>1,2=>6,3=>8,4=>15];

	protected $tableName = 'awards'; 

	/**
     *  抽奖功能模块
     *  ---------------------------------------------
     *  @return String 获奖人姓名
     *  ---------------------------------------------
     *  @author : lvpenglong
     *  @since  : 2015-10-12
     */
    public function draw($type = 1){
		
		$sql = "SELECT `name`, `year`, `depart` FROM `luck_awards`
        WHERE depart IN (SELECT `dname` FROM `luck_depart` WHERE num != prize)
        AND flag = '0'";

        $list = $this->query($sql);

        // 按工作年限提高中奖率
        if ( empty($list) ) return [];
        foreach ($list as $item) {
        	$year = date('Y',time()) - date('Y',strtotime($item['year']));
            if( $year == 1 ) continue;
            $node = $year;
            while ( $node != 1 ) {
                array_push($list, $item);
                $node--;
            }
        }

        // 获取种子节点
        $max  = count($list) - 1;
        $seed = $max > 0 ? mt_rand(0, $max) : 0;

       	$name = $list[$seed]['name'];
        $this->where(['name'=>$name])->save(['flag'=>1,'type'=>$type]);

        $dname = $list[$seed]['depart'];
        M('Depart')->where(['dname'=>$dname])->setInc('prize');

        return $list[$seed]['name'];
    }

    /**
     * 获取前端动画展示列表
     * ---------------------------------------------
     * @param  [type]  $type  [description]
     * @param  boolean $field [description]
     * @return [type]         [description]
     * ---------------------------------------------
     * @author yuzhihao <yu@vagh.cn>
     * @since  2015-01-04
     */
    public function getList($type,$field = true){
        //检查此类名额是否达到指定数量
        $num = $this->where(['type'=>$type])->count();
        if( $num >= $this->lotteryNum[$type] ){
            $this->error = '中奖人数已达上限';
            return false;
        }
        //获取相关人员列表
        $lists = $this->where(['flag'=>'0','type'=>'0'])->field($field)->select();
        //打乱列表
        shuffle($lists);

        return $lists;
    }

    /**
     *  分配各部门中奖个数
     *  ---------------------------------------------
     *  @param Array $args 中奖个数
     *  
     *  @return String 部门分组状态
     *  ---------------------------------------------
     *  @author : lvpenglong
     *  @since  : 2015-12-16
     */
    public function depart($num = 1){
    	$depart = M('Depart');
        // 生成前先清空
        $sql = "TRUNCATE TABLE `luck_depart`";
        $depart->execute($sql);

        $count = $this->count();
        $ratio = $num / $count;
        $dlist = $this->field('COUNT(*) AS c,depart')->group('depart')->select();
        foreach ($dlist as $item) {
            $people = ceil( $item['c'] * $ratio );
            $arr = [
            	'dname' => $item['depart'],
            	'num'   => $people,
            	'prize' => 0
            ];
            $depart->add($arr);
        }
    }

    /**
     * 获取中奖列表
     * ---------------------------------------------
     * @return [type] [description]
     * ---------------------------------------------
     * @since  2015-01-04
     * @author yuzhihao
     */
    public function showWinner(){
        $res  = $this->where(['flag'=>['gt',0],'type'=>['gt',0]])->select();
        $type = [];
        if( !empty($res) ){
            foreach ($res as $value) {
                $type[$value['type']][] = $value;
            }
        }
        return $type;
    }
}