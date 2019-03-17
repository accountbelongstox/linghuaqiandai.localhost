
<script type="text/javascript">
    function search_schedule(a,b){
    	$('.result').html('');
        /*a=提交按钮*/
        /*b=内容*/
        var a=$(a);
        var b=$(b);
        var reg=new RegExp(a.attr('data-reg').slice(1,-1));
        //var reg=a.attr('data-reg');
        var value=$(b).val();
        if(value != ''){
            if(reg.test(value)){
                /*get提交*/
                    var condition=$(a).attr('data-condition');/*查询条件*/
                    var tablename=$(a).attr('data-tablename');
                    var table_id=$(a).attr("data-id"); 
                var obj={
                    value:value,
                    condition:condition,/*查询条件*/
                    table_id:table_id
                }
                $.post("<?php echo $module['action_url'];?>&act=search_schedule",obj,function(data){
                	if(data && data.length > 1 ){
                		data=data.split('null').join('""');
                	}
                	var j=$.parseJSON(data);
                	$(j).each(function(a,b){
                		if(!b[condition]){
                			var html='<div class="result_tablename">'+b.description+'</div>';
                			$('.result').html($('.result').html()+html);
                			create_queryHTML(b,class_[4],4);
                			var html='<div class="clear"></div>';
                			$('.result').html($('.result').html()+html);
                		}
                		if(b[condition]){/*查询得到结果*/
                			var examined=parseInt(b.examined);
                			var html='<div class="result_tablename">'+b.description+'</div>';
                			$('.result').html($('.result').html()+html);
                			var for_examined=examined+1;
                			for (var i=0;i<for_examined;i++) {
                				b['examined_txt']=alert_txt[i];
                				switch(parseInt(b.callback)){
                					case 1://数据库callback=1则显示 微信二维码
                					if(i==examined){
                						b['examined_txt']+=b.weixin;
                					}
                					break;
                					default:
                					break;
                				}
                				if(for_examined == 4 && i == 2){//如果已经被拒绝,同时又要经过第3项已经审核,则直接跳过.
                							
                				}else{
                					create_queryHTML(b,class_[i],i);
                				}
                			}
                			var html='<div class="clear"></div>';
                			$('.result').html($('.result').html()+html);
                		}
                	})
                });
            }else{
                alert($(a).attr('data-name')+'输入不正确');
            }
        }else{
            alert($(b).attr('placeholder'));
        }
    }
    
    
	var class_=['a0','a1','a2','a3','un'];/*配套读取class*/
	var alert_txt=['申请成功,审核中','复审中','已通过','未通过'];/*配套读取class*/
    function create_queryHTML(obj,class_,n){
    	n=parseInt(n);
    	var rite_time='';
    	var examined_txt='';
    	switch(n){
    		case 0:
    		rite_time=unix_to_datetime(obj.write_time);
    		examined_txt=obj.examined_txt;
    		break;
    		case 1:
    		rite_time='新动态';
    		examined_txt=obj.examined_txt;
    		break;
    		case 2:
    		rite_time='新动态';
    		examined_txt=obj.examined_txt;
    		break;
    		case 3:
    		rite_time='动态';
    		examined_txt=obj.examined_txt;
    		break;
    		default:
    		rite_time='-';
    		examined_txt='您还未申请<a href="/index.php?cloud=form.data_add&amp;table_id=79"> &gt;&gt;立即申请</a>';
    		break;
    	}
        var html="";
        html+='<div class="c '+class_+'">';
        html+='<p class="t">'+examined_txt+'</p>';
        html+='<p class="c_p">'+rite_time+'</p>';
        html+='</div>';
        $('.result').html($('.result').html()+html);
    }
    function unix_to_datetime(unix) {
        var now = new Date(parseInt(unix) * 1000);
        var year = now.getFullYear();
        var month = now.getMonth() + 1;
        var date = now.getDate();
        var hour = now.getHours();
        var m = now.getMinutes();
        var s = now.getSeconds();
        return year + "年" + month + "月" + date + "日 " ;
    }
</script>
