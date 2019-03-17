<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"   class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
            
    });
    </script>
    

    <style>
    #<?php echo $module['module_name'];?>{ padding:1rem;}
    #<?php echo $module['module_name'];?> .type_a{ display:inline-block; vertical-align:top; width:47%; overflow:hidden; margin-bottom:1rem;  }
    #<?php echo $module['module_name'];?> .type_a .icon_div{ display:block; text-align:center;}
    #<?php echo $module['module_name'];?> .type_a .icon_div:hover{ font-weight:bold;}
    #<?php echo $module['module_name'];?> .type_a .icon_div img{width:60%; box-shadow:1px 1px 8px 0px rgba(0,0,0,.3); border-radius:20px; border:2px solid #fff; margin:5px;background:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['background']?>;}
    #<?php echo $module['module_name'];?> .type_a .icon_div .name{ font-weight:bold;}
    #<?php echo $module['module_name'];?> .type_a .sum_div{display:block; text-align:center;}
    #<?php echo $module['module_name'];?> .type_a .sum_div .day_title_sum{ line-height:2rem;}
    #<?php echo $module['module_name'];?> .type_a .sum_div .day_title_sum_span{ display:inline-block; width:3rem; white-space: nowrap;}
    #<?php echo $module['module_name'];?> .type_a .sum_div .day_title_sum .v{ display: inline-block; line-height:1.6rem;   border-radius:5px; min-width:2rem; padding-left:1rem; padding-right:1rem;background:<?php echo $_POST['cloud_user_color_set']['nv_3_hover']['background']?>; color:<?php echo $_POST['cloud_user_color_set']['nv_3_hover']['text']?>;}
    #<?php echo $module['module_name'];?> .type_a .sum_div .day_title_sum:before{ padding-left:5px;font: normal normal normal 1.2rem/1 FontAwesome; content:"\f0d9";  margin-right:-1px;color:<?php echo $_POST['cloud_user_color_set']['nv_3_hover']['background']?>;}
	
    #<?php echo $module['module_name'];?> .type_a .sum_div .title_sum{ line-height:34px;}
    #<?php echo $module['module_name'];?> .type_a .sum_div .title_sum_span{display:inline-block; width:3rem; white-space: nowrap;}
    #<?php echo $module['module_name'];?> .type_a .sum_div .title_sum .v{ display: inline-block; line-height:1.6rem;   border-radius:5px; min-width:2rem; padding-left:1rem; padding-right:1rem;background:<?php echo $_POST['cloud_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['cloud_user_color_set']['nv_2_hover']['text']?>;}
    #<?php echo $module['module_name'];?> .type_a .sum_div .title_sum:before{ padding-left:5px;font: normal normal normal 1.2rem/1 FontAwesome; content:"\f0d9";  margin-right:-1px;color:<?php echo $_POST['cloud_user_color_set']['nv_2_hover']['background']?>;}
	
	
    #<?php echo $module['module_name'];?> .type_a .sum_div .content_sum{ line-height:34px;}
    #<?php echo $module['module_name'];?> .type_a .sum_div .content_sum_span{display:inline-block; width:3rem; white-space: nowrap;}
    #<?php echo $module['module_name'];?> .type_a .sum_div .content_sum .v{ display: inline-block; line-height:1.6rem;   border-radius:5px; min-width:2rem; padding-left:1rem; padding-right:1rem;background:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['text']?>;}
    #<?php echo $module['module_name'];?> .type_a .sum_div .content_sum:before{ padding-left:5px;font: normal normal normal 1.2rem/1 FontAwesome; content:"\f0d9";  margin-right:-1px;color:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['background']?>;}
	
    
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
      <?php echo $module['list']?>
    </div>
</div>