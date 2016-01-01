$(function(){ 
    var _gogo; 
    var start_btn = $("#start"); 
    var stop_btn  = $("#stop");
    var rool      = $("#roll");
    start_btn.removeAttr('disabled');

    start_btn.on('click', function(){ 
        start_btn.attr('disabled','disabled');
        var type = $('input[name="luckType"]:checked').val();
        $.post(resource,{type:type},function(json){ 
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
                if( json.status == 0 ){
                    $("#roll").html(json.info); 
                }else{
                    $("#roll").html('系统找不到数据源，请先导入数据。'); 
                }
                start_btn.removeAttr('disabled');
            } 
        }); 
    });
    
    stop_btn.on('click', function(){
        var type = $('input[name="luckType"]:checked').val();
        rool.html('读取中');
        clearInterval(_gogo);
        rool.html('读取中');
        $.post(selectone,{type:type},function(data){ 
            if( data ){
                if( data.name != '' ){
                    rool.html(data.name);
                }else{
                    rool.html('都抽完啦');
                }
                var html = pushStatusList(data.type,data.name);
                $("#result").append(html); 
            }
            start_btn.removeAttr('disabled');
            stop_btn.attr('disabled','disabled');
        }); 
    });
});

function pushStatusList(type,name){
    var html = '',color='',typename='';
    switch( type ){
        case '1':
            color = 'palette-pomegranate';
            typename = '一等奖';
        break;
        case '2':
            color = 'palette-wisteria';
            typename = '二等奖';
        break;
        case '3':
            color = 'palette-peter-river';
            typename = '三等奖';
        break;
        case '4':
            color = 'palette-emerald';
            typename = '四等奖';
        break;
    }

    html += '<div class="pallete-item rubberBand animated">';
    html += '    <dl class="palette '+ color +'">';
    html += '        <dt>' + typename + '</dt>';
    html += '        <dd>' + name + '</dd>';
    html += '    </dl>';
    html += '</div>';
    return html;
}