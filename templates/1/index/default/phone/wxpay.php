<script src="/plugin/datePicker/index.php"></script>
<div id=<?php echo $module['module_name'];?>  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .inquiry").click(function(){
			id=$(this).attr('href');
			$("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=inquiry',{id:id}, function(data){
				console.log(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#state_"+id).html(v.info);
				$("#tr_"+id+" .receive_state").html(v.receive_state);
				
			});
			return false;	
		});
		        
		
		$("#<?php echo $module['module_name'];?> .del").click(function(){
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
        	
    }  
		  
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{}
    
    #<?php echo $module['module_name'];?>_table .username{width:100px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:80px;display:inline-block;}
    #<?php echo $module['module_name'];?>_table .time a{  }
    #<?php echo $module['module_name'];?>_table .money{width:80px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .remark{width:400px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .payee{width:100px;display:inline-block;}
    #<?php echo $module['module_name'];?>_table .operation{width:150px;display:inline-block; text-align:left;}
    #<?php echo $module['module_name'];?>_table .operation_state{display:inline-block;}
	#<?php echo $module['module_name'];?> .open_icon{ height:30px; border-radius:3px; padding-right:3px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  cloud-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['cloud_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search" class="form-control"  placeholder="<?php echo self::$language['payee']?>/<?php echo self::$language['reason']?>" /></m_label></div></div></div>
    <table class=top_div width="100%">
    	<tr>
        	<td align="left"> 
        <span id=time_limit style="float:left;"><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
            </td>
            <td align="right">
            <?php echo self::$language['sum']?>:<?php echo $module['sum_all']?>
            </td>
        </tr>
    </table>
   
        

    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td width="4%"><input type="checkbox" group-checkable=1></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><?php echo self::$language['payee']?></td>
                <td ><?php echo self::$language['openid']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="type|desc" class="sorting"  asc="type|asc"><?php echo self::$language['type']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="money|desc" class="sorting"  asc="money|asc"><?php echo self::$language['money']?></a></td>
                <td ><?php echo self::$language['reason']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="send_state|desc" class="sorting"  asc="send_state|asc"><?php echo self::$language['send']?><?php echo self::$language['state']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="receive_state|desc" class="sorting"  asc="receive_state|asc"><?php echo self::$language['receive']?><?php echo self::$language['state']?></a></td>
                <td ><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
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
