<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>汇通天下2016年 年会抽奖</title>
	<meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="Public/dist/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="Public/dist/css/flat-ui.css" rel="stylesheet">
    <link href="Public/docs/assets/css/demo.css" rel="stylesheet">
    <link rel="stylesheet" href="Public/css/luck.css" />
	<script type="text/javascript" src="http://youzikuwebfont.oss-cn-beijing.aliyuncs.com/api.lib.min.js"></script>
	</head>
	<body>
		<div class="snow-container"></div>
		<h1 class="text-center" id="id1">汇通天下2016年 年会抽奖</h1>

		<div id="roll">点击按钮开始抽奖</div>
		<input type="hidden" id="mid" value=""> 
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-md-offset-3">
					<input type="button" class="btn btn-large btn-block btn-primary" id="start" value="开始">
				</div>
				<div class="col-md-3">
					<input type="button" class="btn btn-large btn-block btn-danger" id="stop" value="停止" disabled="disabled">
				</div>
			</div>
		</div>
		<div id="result"></div>

		<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	    <script src="Public/dist/js/vendor/video.js"></script>
	    <script src="Public/dist/js/flat-ui.min.js"></script>
		<script type="text/javascript" src="Public/js/snow.js"></script>
		<script type="text/javascript">
			$youzikuapi.asyncLoad("http://api.youziku.com/webfont/FastJS/yzk_C40EC541D643F304", function () {
				$youziku.load("#id1", "5c2ab606ac374bedafa7b77d41418cd9", "STXingkai");
				$youziku.draw();
			})
			var resource  = '<?php echo U("Index/getList");?>';
			var selectone = '<?php echo U("Index/getOne");?>';
		</script>
		<script src="Public/js/app.js"></script>
	</body>
</html>