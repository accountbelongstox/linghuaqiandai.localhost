<div id=<?php echo $module['module_name'];?>  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$('#<?php echo $module['module_name'];?> #input_type_<?php echo $_GET['type'];?>').attr('class','current');
    });
    
    
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>_html{  margin-top:10px;}
    #<?php echo $module['module_name'];?>_html .m_label{ display:block; margin-bottom:1rem;}
    #<?php echo $module['module_name'];?>_html .input_span{ }
    #<?php echo $module['module_name'];?>_html #answer_input_div{ width:100%; min-height:200px; border:1px solid #CCC; border-radius:5px; overflow:hidden; white-space:nowrap;}
    #<?php echo $module['module_name'];?>_html #key{ width:50%;}
    #<?php echo $module['module_name'];?>_html #type_select_div{ background-color:#ccc; line-height:2.5rem;  }
    #<?php echo $module['module_name'];?>_html #type_select_div a{ display:inline-block; padding-left:0.3rem; padding-right:0.3rem;}
    #<?php echo $module['module_name'];?>_html #type_select_div .current{ background-color:#FFF; }
    #<?php echo $module['module_name'];?>_html #input_div{ padding:20px;}
	#<?php echo $module['module_name'];?>_html #input_type_text:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c2"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_image:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c5"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_voice:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c7"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_video:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c8"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_single_news:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c4"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_news:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f0f6"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_function:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c9"; padding-right:2px;}
	.submit_div{ text-align:right; padding-right:2%; line-height:60px;}
    </style>

<?php 
require("./include/return_data/css/weixin_css.php");
?>
    <div id="<?php echo $module['module_name'];?>_html"  cloud-table=1>
        	<div id=answer_input_div>
            	<div id=type_select_div><?php echo $module['input_select'];?></div>
            	<div id=input_div>
<!-----------------------------------------------------------------------------------answer_content_input_start-->
					<script>
                    $(document).ready(function(){
						
						for(i=0;i<10;i++){
							$('#img_'+i+'_ele').insertBefore($('#img_'+i+'_state'));
						}						
                        $("#<?php echo $module['module_name'];?> #submit").click(function(){
							$("#<?php echo $module['module_name'];?> #img_state").html('');
							$("#<?php echo $module['module_name'];?> #title_state").html('');
							$("#<?php echo $module['module_name'];?> #url_state").html('');
							$("#<?php echo $module['module_name'];?> #description_state").html('');
							

							var obj=new Object();
							for(i=0;i<10;i++){
                                if(!$("#tr_"+i).attr('del')){
									obj[i]=new Object();
									obj[i]['img']=$("#img_"+i).prop('value');
									obj[i]['url']=$("#url_"+i).prop('value');
									obj[i]['title']=$("#title_"+i).prop('value');
									obj[i]['sequence']=$("#sequence_"+i).prop('value');
								}
							}
																			
							$("#<?php echo $module['module_name'];?> #submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
							
							$.post('<?php echo $module['action_url'];?>',obj, function(data){
								//alert(data);
								try{v=eval("("+data+")");}catch(exception){alert(data);}
								
								
								if(v.state=='success'){
									$("#<?php echo $module['module_name'];?> #submit").css('display','none');
									$("#<?php echo $module['module_name'];?> #submit_state").html(v.info+'<a href=/index.php?cloud=weixin.dialog&wid=<?php echo @$_GET['wid'];?>&openid=<?php echo @$_GET['openid'];?> class=return_button><span class=b_start></span><span class=b_middle><?php echo self::$language['refresh'];?></a>');
								}else{
									if(v.id){
										$("#<?php echo $module['module_name'];?> #"+v.id+'_state').html(v.info);
									}
									$("#<?php echo $module['module_name'];?> #submit_state").html(v.info);
								}
							});
								
							return false; 
						});
                    });
                    
					function del(i){
						$("#tr_"+i+" td").animate({opacity:0},"slow",function(){$("#tr_"+i).css('display','none');});
						$("#tr_"+i).attr('del','1');	
						return false;
					}
                    
                    </script>
                    
                    <style>
                    #<?php echo $module['module_name'];?>_html #input_div{}
                    #<?php echo $module['module_name'];?>_html #title{width:80%;}
                    #<?php echo $module['module_name'];?>_html .sequence{ width:40px;}
                    #<?php echo $module['module_name'];?>_html .img_up_div{ width:380px; overflow:hidden; }

                    </style>

<?php 
require("./include/return_data/css/weixin_css.php");
?>
                    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <td ><?php echo self::$language['image']?></td>
                                <td ><?php echo self::$language['title']?></td>
                                <td ><?php echo self::$language['url']?></td>
                                <td ><?php echo self::$language['sequence']?></td>
               					<td  style=" width:100px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
                            </tr>
                        </thead>
                        <tbody>
                    <?php echo $module['list']?>
                        </tbody>
                    </table></div>
               		
<!-----------------------------------------------------------------------------------answer_content_input_end-->
                </div>
            </div>
            
            
       </div>
   	  <div class=submit_div>
        	<a href="#" class="submit" id=submit><?php echo self::$language['send']?></a> <span id=submit_state></span>	
        </div>
        
        
        
  </div>
</div>

