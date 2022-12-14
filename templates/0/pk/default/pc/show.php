<div id=<?php echo $module['module_name'];?>  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		if(get_param('iframe')==1){
			$(".page-header,.page-footer,.fixed_right_div,#qiao-wrap").css('display','none');	
		}
		
		$("#<?php echo $module['module_name'];?> .iframe").click(function(){
			url=$(this).attr('href');
			if(url.substring(url.length-3,url.length)=='png' || url.substring(url.length-3,url.length)=='jpg'){
				$('#myModal').modal({  
				   backdrop:true,  
				   keyboard:true,  
				   show:true  
				});  
				$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/10);	
				
				$("#myModal .modal-body").html('<img src="'+url+'" width=100% />');
				$("#myModal .modal-title b").html($(this).html());
					 		
				return false;	
			}

			set_iframe_position($(window).width()-100,$(window).height()-100);
			//cloud_alert(replace_file);
			$("#cloud_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_cloud_iframe_div").css('display','block');
			$("#cloud_iframe").attr('src',$(this).attr('href'));
			
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .pk_checkbox").each(function(index, element) {
            if($(this).attr('cloud_value')==1){$(this).prop('checked',true);}
        });
		if(<?php echo $module['item_deep'];?>==3){
			td_max=3
			$("#<?php echo $module['module_name'];?> tbody tr").each(function(index, element) {
                td_max=Math.max(td_max,$(this).children('td').length);
            });
			$("#<?php echo $module['module_name'];?> tbody tr").each(function(index, element) {
               i=($(this).children('.object:first').index()-1);
			   if($(this).children('td:eq('+i+')').attr('class')=='level_2'){$(this).children('td:eq('+i+')').attr('colspan',2);}
			   if($(this).children('td:eq('+i+')').attr('class')=='level_1'){$(this).children('td:eq('+i+')').attr('colspan',3);}
            });
		}
		if(<?php echo $module['item_deep'];?>==2){
			td_max=3
			$("#<?php echo $module['module_name'];?> tbody tr").each(function(index, element) {
                td_max=Math.max(td_max,$(this).children('td').length);
            });
			$("#<?php echo $module['module_name'];?> tbody tr").each(function(index, element) {
               i=($(this).children('.object:first').index()-1);
			   if($(this).children('td:eq('+i+')').attr('class')=='level_2'){$(this).children('td:eq('+i+')').attr('colspan',1);}
			   if($(this).children('td:eq('+i+')').attr('class')=='level_1'){$(this).children('td:eq('+i+')').attr('colspan',2);}
            });
		}
		
		$.get("<?php echo $module['action_url']?>");
    });

    </script>
    
    <link rel="stylesheet" href="/css/main.css" type="text/css">
    <style>
	#qiao-wrap{ display:none !important;}
	#<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> .pk_power{ text-align:right; opacity:0.7;}
	#set_cloud_iframe_div{}
	#set_cloud_iframe_div img{width:100%;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  cloud-table=1>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr><?php echo $module['thead']?></tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>
	<div class=pk_power><?php echo self::$language['pk_power']?></div>
    
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" 
           aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                 <div class="modal-header">
                    <button type="button" class="close" 
                       data-dismiss="modal" aria-hidden="true">
                          &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                       <b></b>
                    </h4>
                 </div>
                 <div class="modal-body"></div>
              </div>
        </div>
      </div>          
          
    
</div>
