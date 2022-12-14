<script src="/plugin/datePicker/index.php"></script>

<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_cloud_iframe_div").css('display','none');
			$("img[src='"+replace_file+"']").attr('src',replace_file+"?&reflash="+Math.random());
			return false;
		});

		$(".pay_photo").click(function(){
			
			set_iframe_position($(window).width()-100,$(window).height()-200);
			$("#fade_div").css('display','block');
			$("#set_cloud_iframe_div").css('display','block');
			$("#cloud_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
		$(".pay_info").click(function(){
			alert($(this).attr('title'));
			return false;	
		});
		
		
		$("#cloud_table_filter select").change(function(){
			cloud_table_filter($(this).attr('id'));	
		});
		$(".set_success").click(function(){
			if(confirm("<?php echo self::$language['opration_confirm']?>")){
				id=$(this).attr('href');
				$("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=success',{id:id}, function(data){
					            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

					$("#state_"+id).html(v.info+"<a class=refresh href='javascript:window.location.reload();'><?php echo self::$language['refresh'];?></a>");
				});
			}
			return false;	
		});
		$(".set_fail").click(function(){
				id=$(this).attr('href');
				$("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=fail',{id:id}, function(data){
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
		var method=get_param('method');
		if(method!=''){$("#method").prop('value',method);}
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
    #<?php echo $module['module_name'];?>_html .pay_photo:before {font: normal normal normal 18px/1 FontAwesome;margin-right: 5px;content: "\f1c5";}
    #<?php echo $module['module_name'];?>_html .pay_photo:hover{ opacity:0.8;} 
    #<?php echo $module['module_name'];?>_html .pay_info:before {font: normal normal normal 18px/1 FontAwesome;margin-right: 5px;content: "\f0f6";}
    #<?php echo $module['module_name'];?>_html .pay_info:hover{ opacity:0.8;}
    #<?php echo $module['module_name'];?>_table .reason{width:250px;display:inline-block; text-align:left;}
    #<?php echo $module['module_name'];?>_table .operation{width:100px;display:inline-block; text-align:left;}
    #<?php echo $module['module_name'];?>_table .operation_state{display:inline-block;}
	.set_fail{display:block;}
    /*????????CSS????*/
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
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"   placeholder="<?php echo self::$language['username']?>" class="form-control" ></m_label></div></div></div>
    
    <table class=top_div width="100%">
    	<tr>
        	<td align="left">
            <span id=cloud_table_filter>:
    <?php echo $module['filter']?></span>
        <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
            </td>
            <td align="right">
            <?php echo self::$language['sum']?><?php echo self::$language['success']?><?php echo self::$language['recharge']?>:<?php echo $module['sum_all']?>
            </td>
        </tr>
    </table>
    
        

    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td >ID</td>
                <td ><?php echo self::$language['username']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><?php echo self::$language['pay_method']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="money|desc" class="sorting"  asc="money|asc"><?php echo self::$language['amount']?></a></td>
                <td ><?php echo self::$language['reason']?></td>
                <td ><?php echo self::$language['state']?></td>
                <td ><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
