$(function(){ 
    var _gogo; 
    var start_btn = $("#start"); 
    var stop_btn  = $("#stop");
    var rool      = $("#roll");
    start_btn.removeAttr('disabled');

    start_btn.on('click', function(){ 
        start_btn.attr('disabled','disabled');
        $.post(resource,function(json){ 
            if(json.list){
                var list= json.list;
                var len = list.length; 
                _gogo = setInterval(function(){ 
                    var num = Math.floor(Math.random()*len);//获取随机数 
                    var id = list[num]['id']; //随机id 
                    var v = list[num]['name']; //对应的随机号码 
                    rool.html(v); 
                    $("#mid").val(id); 
                },50); //每隔0.5秒执行一次
                stop_btn.removeAttr('disabled');
            }else{ 
                if( json.status < 0 ){
                    $("#roll").html(json.info); 
                }else{
                    $("#roll").html('系统找不到数据源，请先导入数据。'); 
                }
            } 
        }); 
    });
    
    stop_btn.on('click', function(){ 
        clearInterval(_gogo);
        rool.html('读取中');
        $.post(selectone,{type:1},function(data){ 
            if( data ){
                if( data.name != '' ){
                    rool.html(data.name);
                }else{
                    rool.html('都抽完啦');
                }
                // $("#result").append("<p>"+mobile+"</p>"); 
            }
            start_btn.removeAttr('disabled');
            stop_btn.attr('disabled','disabled');
        }); 
    });

}); 