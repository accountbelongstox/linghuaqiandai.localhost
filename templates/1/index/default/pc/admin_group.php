<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
    $(document).ready(function(){
        
    });
    
    function add(){
        var parentNew=$("#parent_new");
        var nameNew=$("#name_new");	
        var sequenceNew=$("#sequence_new");
        var creditsNew=$("#credits_new");

        if($("#reg_able_new").prop('checked')){
            var reg_able=1;
        }else{
            var reg_able=0;
        }
        if($("#is_admin").prop('checked')){
            var is_admin=1;
        }else{
            var is_admin=0;
        }
        if($("#require_check_new").prop('checked')){require_check=1;}else{require_check=0;}
        if($("#require_login_new").prop('checked')){require_login=1;}else{require_login=0;}
    
        if(parentNew.prop('value')<0){$("#state_new").html('<?php echo self::$language['please_select']?><?php echo self::$language['parent']?>');parentNew.focus();return false;}	
        if(nameNew.prop('value')==''){$("#state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(sequenceNew.prop('value')==''){$("#state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequenceNew.focus();return false;}	
        if(creditsNew.prop('value')==''){$("#state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['credits']?>');creditsNew.focus();return false;}	
        $("#state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');

        if(is_admin == 1){
            if(!confirm("你当前添加的是管理组,确定这么做?")){
                return false;
            }
        }

        $.get('<?php echo $module['action_url'];?>&act=add',{
            parent:parentNew.prop('value'),
            name:nameNew.prop('value'),
            sequence:sequenceNew.prop('value'),
            credits:creditsNew.prop('value'),
            require_login:require_login,
            is_admin:is_admin
        }, function(data){
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#state_new").html(v.info);
            if(v.state=='success'){
                $("#state_new").html($("#state_new").html()+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');
            }
            alert('操作成功');
            window.location.reload();
    
        });
        	
        return false;
    }
    
    
    function update(id){
        var name=$("#name_"+id);	
        sequence=$("#sequence_"+id);
        credits=$("#credits_"+id);
        if($("#reg_able_"+id).prop('checked')){reg_able=1;}else{reg_able=0;}
        console.log($("#reg_able_"+id).prop('checked'))
        if($("#require_check_"+id).prop('checked')){require_check=1;}else{require_check=0;}
        if($("#require_login_"+id).prop('checked')){require_login=1;}else{require_login=0;}
        if($("#is_admin_"+id).prop('checked')){var is_admin=1;}else{var is_admin=0;}
		
        if(name.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(sequence.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        if(credits.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['credits']?>');credits.focus();return false;}	
        
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		
		if(id == 1){
			alert("该组拒绝修改");
			return false;
		}
		if(is_admin == 1){
			if(!confirm("你当前修改为管理组?请确认操作?")){
				return false;
			}
		}
        $.get('<?php echo $module['action_url'];?>&act=update',{
			name:name.prop('value'),
			sequence:sequence.prop('value'),
			credits:credits.prop('value'),
			id:id,reg_able:reg_able,
			require_check:require_check,
			require_login:require_login,
			is_admin:is_admin
			}, function(data){
           //alert(data);
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
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        ids=ids.split('|');
        var obj=new Object();
        for(id in ids){
            if(ids[id]!=''){
            obj[id]=new Object();
            obj[id]['id']=ids[id];
            obj[id]['name']=$("#name_"+ids[id]).prop('value');
            obj[id]['sequence']=$("#sequence_"+ids[id]).prop('value');
            obj[id]['credits']=$("#credits_"+ids[id]).prop('value');
            obj[id]['reg_able']=$("#reg_able_"+ids[id]).prop('value');
            if($("#reg_able_"+ids[id]).prop('checked')){obj[id]['reg_able']=1;}else{obj[id]['reg_able']=0;}
            if($("#require_check_"+ids[id]).prop('checked')){obj[id]['require_check']=1;}else{obj[id]['require_check']=0;}
            if($("#require_login_"+ids[id]).prop('checked')){obj[id]['require_login']=1;}else{obj[id]['require_login']=0;}
            $("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                //cloud_alert(ids);
                success=v.ids.split("|");
                for(id in ids){
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                    }else{
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['executed'];?></span>");	
                    }	
                }
        });	
        
        
        return false;
        	
    }
    function del_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
        idss=ids;
        ids=ids.split("|");	
        for(id in ids){
            if(ids[id]!=''){$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
        }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
				//cloud_alert(data);
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
<style>
	#<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_table .id{float:left;margin-left:10px; width:20px;}
    #<?php echo $module['module_name'];?> #index_admin_group_table a:hover{ } 
    
    /*表单设计CSS载入*/
    <?php require("./include/return_data/css/form_data_admin.php");?>
</style>



<div id="<?php echo $module['module_name'];?>_html" class="<?php echo $module['module_name'];?>_html" cloud-table="1">
    <div class="portlet-title">
        <div class="caption"><?php echo $module['cloud_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                 <li><a href="#" onclick="return subimt_select();"><?php echo self::$language['submit']?></a></li>  
                 <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        

    
    
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td><?php echo self::$language['name']?></td>
                <td>总用户</td>
                <td><span style="color:red;">管理员组</span></td>
                <td>可注册</td>
                <td>须审核</td>
                <td>须登陆</td>
                <td><?php echo self::$language['sequence']?></td>
                <td><?php echo self::$language['upgrade']?><?php echo self::$language['credits']?></td>
                <td width="20%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </thead>
        <tbody>
        <?php echo $module['tbody'];?>
        <?php echo $module['list']?>
        </tbody>
    </table></div>
    
    </div>

</div>
