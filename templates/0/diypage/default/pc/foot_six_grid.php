<div id=<?php echo $module['module_name'];?>  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .out_div .grid:last").css('border-right','none').css('padding-right','0px');
    });
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .out_div{white-space:nowrap; }
    #<?php echo $module['module_name'];?> .out_div .grid{   display:inline-block; vertical-align:top;width:16%;; padding:0.6%; border-right: #999 dashed 1px; white-space:normal;}
	#<?php echo $module['module_name'];?> .out_div .grid .title{ display:block; font-size:20px; line-height:30px; width:100%; overflow:hidden; }
	#<?php echo $module['module_name'];?> .out_div .grid .list{display:block; font-size:15px; line-height:22px;  width:100%; overflow:hidden;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
    	<div class=out_div>
        <?php echo $module['html'];?>
        </div>
    </div>

</div>
