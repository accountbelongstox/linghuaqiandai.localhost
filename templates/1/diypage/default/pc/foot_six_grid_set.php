<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .foot_six_grid_target").val($("#<?php echo $module['module_name'];?> .foot_six_grid_target").attr('cloud_value'));
		$("#<?php echo $module['module_name'];?> .foot_six_grid_target").change(function(){
			$("#<?php echo $module['module_name'];?> .foot_six_grid_target").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=target&foot_six_grid_target='+$(this).val(), function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .foot_six_grid_target").next().html(v.info);
			});
		});
		
		$("#<?php echo $module['module_name'];?> .type").change(function(){
		    if($(this).prop('value')=='diy'){
				$(this).parent().next().next().css('display','block');	
				$(this).parent().next().css('display','none');	
			}else{
				$(this).parent().next().css('display','block');
				$(this).parent().next().next().css('display','none');		
			}
		});
		
		$("#<?php echo $module['module_name'];?> .type").each(function(index, element) {
          	$(this).val($(this).attr('cloud_value'));
		    if($(this).attr('cloud_value')=='diy'){
				$(this).parent().next().next().css('display','block');	
			}else{
				$(this).parent().next().css('display','block');	
			}
        });
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			obj=new Object();
			$("#<?php echo $module['module_name'];?> .grid").each(function(index, element) {
               obj[$(this).attr('id')]=new Object();
			   obj[$(this).attr('id')]['type']=$(this).children('.type_div').children('.type').val();
			   obj[$(this).attr('id')]['max']=$(this).children('.max_div').children('.max').val();
			   obj[$(this).attr('id')]['content']=$(this).children('.content').val();
            });
			$.post('<?php echo $module['action_url'];?>&act=update',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
			});
			return false;
		});
    });
    
    </script>
<style>
    #<?php echo $module['module_name'];?>{padding-top:10px;}
    #<?php echo $module['module_name'];?> select{ display:block;}
    #<?php echo $module['module_name'];?> .out_div{white-space:nowrap;}
    #<?php echo $module['module_name'];?> .out_div .grid{  display:inline-block; vertical-align:top;width:180px; padding:10px; border-right: #999 dashed 1px; }
	 #<?php echo $module['module_name'];?> .out_div .grid .index{ text-align:center; font-weight:bold;}
	 #<?php echo $module['module_name'];?> .out_div .grid .content{display:none; width:90%; min-height:120px;}
	 #<?php echo $module['module_name'];?> .out_div .grid .max_div{display:none;}
	 #<?php echo $module['module_name'];?> .out_div .grid .max_div .max{ width:30px;}
	 #<?php echo $module['module_name'];?> .type{ margin-top:10px; margin-bottom:10px;}
</style>
	<div id="<?php echo $module['module_name'];?>_html">
    	<div class=out_div>
        <?php echo $module['html'];?>
        </div>
        <a href="#" class=submit><?php echo self::$language['submit']?></a> <span class=state></span>
        
       <br /><br /> <?php echo self::$language['target'];?>： <select class=foot_six_grid_target cloud_value=<?php echo $module['foot_six_grid_target']?>><?php echo $module['target_option'];?></select> <span class=state></span>
    </div>

</div>
