	<script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
    });    
    
    
    function create_html(e,n){
    	$('.center_content').html('');
    	var n=parseInt(n);
    	var type=["index",'table'];
    	if(n >= type.length){
    		return false;
    	}
        $.get('<?php echo $module['action_url'];?>&act=create_html&type='+type[n],obj,function(data){
        	n++;
        	$('.center_content').html($('.center_content').html()+'首页已经生成完毕..<br />');
        	get_tables(e,function(){
        		create_tables(e,0);
        	});
        });
    }
    
    function create_tables(e,n,arr,fn){
    	var num=$(e).attr("data-tablesnumber");
    		num=parseInt(num);
    	if(n >= num){
    		if(fn){
    			fn();
    		}
        	$('.center_content').html($('.center_content').html()+'全部生成完毕!<br />');
    		return false;
    	}
    		n=parseInt(n);
		var obj={
			id:arr[n]
		}
        $.get('<?php echo $module['action_url'];?>&act=create_html&type=table',obj,function(data){
        	$('.center_content').html($('.center_content').html()+'生成表单:'+(n+1)+'..<br />');
        	n++;
        	create_tables(e,n,arr,fn);
        });
    }
    function get_tables(e,fn){
    	$.get('<?php echo $module['action_url'];?>&act=get_tables',function(data){//得到全部表的数量 
    		if(data != ""){
    			var j=$.parseJSON(data);
    			var arr=new Array();
    			$(j).each(function(a,b){
    				if(b != ''){
    					b=parseInt(b);
    					arr.push(b);
    				}
    			})
    			var n=arr.length;
    			$(e).attr({
    				"data-tablesnumber":n
    			})
        		$('.center_content').html($('.center_content').html()+'表单数量'+n+'个,开始生成..<br />');
    			create_tables(e,0,arr,function(){
    				
    			});
    		}else{
    			console.log(data);
    		}
    		if(fn){
    			fn();
    		}
    	})
    }
    function update(id){
        var width=$("#width_"+id);
        var height=$("#height_"+id);
        var title=$("#title_"+id);	
        sequence=$("#sequence_"+id);
        if(title.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['title']?>');title.focus();return false;}	
        if(width.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['module_width']?>');width.focus();return false;}	
        if(height.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['module_height']?>');height.focus();return false;}	
        if(sequence.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
		width.val(check_module_size(width.val()));
		height.val(check_module_size(height.val()));

        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{width:width.prop('value'),height:height.prop('value'),title:title.prop('value'),sequence:sequence.prop('value'),id:id}, function(data){
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#state_"+id).html(v.info);
        });
        return false;	
        
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        return false;	
        
    }
    
    
    
    
    
    function subimt_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;return false;}
		$("#state_select").html('');
        ids=ids.split('|');
        var obj=new Object();
        for(id in ids){
            if(ids[id]!=''){
            obj[id]=new Object();
            obj[id]['id']=ids[id];
            obj[id]['width']=check_module_size($("#width_"+ids[id]).prop('value'));
            obj[id]['height']=check_module_size($("#height_"+ids[id]).prop('value'));
            obj[id]['title']=$("#title_"+ids[id]).prop('value');
            obj[id]['sequence']=$("#sequence_"+ids[id]).prop('value');
            //cloud_alert(obj[id]['visible']);
            $("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
            //cloud_alert(data);
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                //cloud_alert(ids);
                success=v.ids.split("|");
                for(id in ids){
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                    }else{
                        $("#state_"+ids[id]).html("<?php echo self::$language['fail'];?>");	
                    }	
                }
        });	
        
        
        
       return false;	
    }
    function del_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
        idss=ids;
        ids=ids.split("|");	
        for(id in ids){
            if(ids[id]!=''){$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
        }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                if(v.state=='success'){
                //cloud_alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                    //cloud_alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                        $("#tr_"+ids[id]).css('display','none');
                    }else{
                        $("#state_"+ids[id]).html("<?php echo self::$language['fail'];?>");	
                    }	
                }
                }
            });
        }	
        return false;	
    }
    
    
    </script>