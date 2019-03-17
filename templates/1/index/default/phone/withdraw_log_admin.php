<script src="/plugin/datePicker/index.php"></script>

<div id=<?php echo $module['module_name'];?>  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#cloud_table_filter select").change(function(){
			cloud_table_filter($(this).attr('id'));	
		});
		$(".paid").click(function(){
			if(confirm("<?php echo self::$language['opration_confirm']?>")){
				id=$(this).attr('href');
				$("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=paid',{id:id}, function(data){
				try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#"+$("#state_"+id).parent().parent().attr('id')+" .state").html('<?php echo self::$language['withdraw_state'][3]?>');
					$("#state_"+id).parent().html(v.info+"<a class=refresh href='javascript:window.location.reload();'><?php echo self::$language['refresh'];?></a>");
					
				});
			}
			return false;	
		});
		$(".refuse").click(function(){
				id=$(this).attr('href');
				if($("#reason_"+id).val()=='' || $("#reason_"+id).val()=='<?php echo self::$language['reason']?>:'){$("#reason_"+id).css('display','inline-block');$("#reason_"+id).focus();return false;}
				var reason=$("#reason_"+id).val();				
				$("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=refuse',{id:id,reason:reason}, function(data){
					            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

					$("#state_"+id).html(v.info+"<a class=refresh href='javascript:window.location.reload();'><?php echo self::$language['refresh'];?></a>");
				});
			return false;	
		});
		$(".del").click(function(){
				id=$(this).attr('href');
				$("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
					            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

					$("#state_"+id).html(v.info);
					if(v.state=='success'){
					$("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
					}
				});
			return false;	
		});
		
		var state=get_param('state');
		if(state!=''){$("#state").prop('value',state);}
    });
    
    
    
    function cloud_table_filter(id){
            if($("#"+id).prop("value")!=-1){
                key=id.replace("_filter","");
                url=window.location.href;
                url=replace_get(url,key,$("#"+id).prop("value"));
                if(key!="search"){url=replace_get(url,"search","");}else{url=replace_get(url,"current_page","1");url=replace_get(url,"state","");}
                //cloud_alert(url);
                window.location.href=url;	
            }
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
    #<?php echo $module['module_name'];?>_html .refuse:hover{ }     
    #<?php echo $module['module_name'];?>_html .paid:hover{ }
    #<?php echo $module['module_name'];?>_table .reason{ }
    #<?php echo $module['module_name'];?>_table .reason_input{ width:150px;}
    #<?php echo $module['module_name'];?>_table .username{width:120px;display:inline-block;overflow:hidden;white-space:nowrap;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:60px;display:inline-block;}
    #<?php echo $module['module_name'];?>_table .money{width:60px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .billing_info{width:350px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .state{width:60px;display:inline-block;}
    #<?php echo $module['module_name'];?>_table .operation_state{display:inline-block;}
	#<?php echo $module['module_name'];?> .open_icon{ width:30px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  cloud-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['cloud_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"   placeholder="<?php echo self::$language['username']?>" value="<?php echo @$_GET['search'];?>"  class="form-control" ></m_label></div></div></div>
    
    <table class=top_div width="100%">
    	<tr>
        	<td align="left">
            <span id=cloud_table_filter>:
    <?php echo $module['filter']?></span>
        <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
            </td>
            <td align="right">
            <?php echo self::$language['sum']?><?php echo self::$language['success']?><?php echo self::$language['withdraw']?>:<?php echo $module['sum_all']?>
            </td>
        </tr>
    </table>
    
        

    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['username']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="money|desc" class="sorting"  asc="money|asc"><?php echo self::$language['amount']?></a></td>
                <td ><?php echo self::$language['withdraw_method']?></td>
                <td ><?php echo self::$language['billing_info']?></td>
                <td ><?php echo self::$language['state']?></td>
                <td style="width:250px;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <div class=batch_operation_div>
    			<span class="corner">&nbsp;</span>
    
                <a href="#" class="select_all" onclick="return select_all();"><?php echo self::$language['select_all']?></a>
                <a href="#" class="reverse_select" onclick="return reverse_select();"><?php echo self::$language['reverse_select']?></a>
                 <?php echo self::$language['selected']?>:
                 <a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a> 
                  <span id="state_select"></span>
                  </div>
    <?php echo $module['page']?>
    </div>
</div>
