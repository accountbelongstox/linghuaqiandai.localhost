<script src="/plugin/datePicker/index.php"></script>
<link rel="stylesheet" media="screen" href="/css/tata_admin.css"/>
<style>
    /*表单设计CSS载入*/
    <?php require("./include/return_data/css/form_data_admin.php");?>
</style>
<?php require("./include/return_data/css/data_admin.php");?>
 <div class="content-section" id="form_submit_authority">
   <div class="section-header">
    <span class="title">表单详情<i class="help-document-tooltip gd-icon-help-circle-o tooltipstered" ></i></span>
   
   <div class="clear"></div>
   </div>
   <div class="section-body section-body_n">
   <div class="section-content-ajax" style="height:200px;">

	</div>
   </div>
   
<div class="section-body">
   <div class="content-sub-section submit-field">
	<table id="show_button_table" style="background: #FFF;margin-right: 10px;color: #009AFF;display: inline-block; height: 30px;line-height: 30px;float: left;">
        <tbody>
        <tr class="show_button_tr" id="show_button_tr">
        </tr>
        </tbody>
    </table>
     <input type="submit" style="display:none;" name="commit" value="保存设置" class="gd-btn gd-btn-primary" >
     <input type="submit" onclick="GetDatas(this,'pev');" data-id="" data-href="" id="commit_pr" name="commit_pr" value="<" class="gd-btn gd-btn-primary" >
     <input type="submit" onclick="GetDatas(this,'nex');" data-id="" data-href="" id="commit_nex" name="commit_nex" value=">" class="gd-btn gd-btn-primary" >
     <input type="button" onclick="close_parent(this);" value="关闭窗口" class="gd-btn gd-btn-info" style="  border: 1px solid red;">

   <div class="clear"></div>
       <div id="vive_remark_div"></div>
   </div>
   <div class="clear"></div>
</div>
   <div class="clear"></div>
 </div>
<div class="form_data_show">
    <div class="form_data_head">数据详情</div>
    <div class="form_data_content">
        <div class="form_data_contentleft"></div>
        <div class="form_data_contentright"></div>
    </div>
    <div class="form_data_contentbottom"><a href="javascript:;">修改</a><a href="javascript:;">删除</a></div>
</div>
<div class="show_input_text" style="display: none;">
	<div class="solse_a"><a class="colse" herf="javascript:void(0);" onclick="close_show_input(this);">关闭</a></div>
    <div class="show_input_sms"><p class="p_sms_a"><input onchange="show_sms_p(this);" type="checkbox" name="is_sms" id="is_sms" class="publish input_checkbox" value="0">发送短信 <span style="color:red;">剩余(<span id="sms_money">0</span>)</span></p>
	<p class="p_sms_b p_sms_mobile" style="display:none;"><input type="text" name="data-phone-tive" class="data-phone-tive" id="data-phone-tive"></p>
	<p class="p_sms_b" style="width:160px;padding:0 10px;"  style="display:none;">内容</p>
	</div>
	<div class="show_input_content" style="font-size:18px;margin-top:10px;display:block;"></div>
    <div class="div_shortcut" >
        <?php echo $module['shortcut'];?>
        <div class="clear"></div>
    </div>
    <div class="defind_a"><a class="defined_sublime" onclick="defined_sublime(this);" href="javascript:;">自定义</a>
        <input type="text" id="defined_shortcut" name="defined_shortcut" onblur="defined_inpu(this);" style="display: none;width: 85%;margin-top: 8px;">
        <div class="clear"></div>
    </div>
	<div class="show_input_submit"><a id="show_a_submit" href="javascript:;" onclick="submit_join_input(this);">提交</a>
	<div class="clear"></div>
    </div> 
	<div class="clear"></div>
</div>
<div id="shadow_text" style="display: none;"><b class="s_ico">审核成功！</b><br /><span>已向用户发送了短信！</span></div>
<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
	<style>
    #<?php echo $module['module_name'];?>{}
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
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"></div></div>
        
    
    <div class="filter">
        <?php echo $module['filter']?> 
         <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
        
        <br /><br /><input type="text" name="search_filter" id="search_filter" placeholder="<?php echo $module['search_placeholder']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> 
       &nbsp;  <a href="/index.php?cloud=form.data_add&table_id=<?php echo $_GET['table_id'];?>" target="_blank" class="add"><?php echo self::$language['add']?><?php echo self::$language['data']?></a> 
       &nbsp;  <?php echo $module['export'];?>
       <?php echo $module['export_div'];?>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td  style="width:16px;text-align:center;padding: 0"><span class=operation_icon>&nbsp;</span>管理</td>
                <?php echo $module['head_field'];?>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table>
    </div>
    <?php echo $module['page']?>
    </div>
</div>
<div><span class="success_alert" id="success_state" style="display: none;">成功</span></div>
<div class="show_img" style="display:none;">
    <a class="colse" herf="javascript:void(0);" onclick="close_show_img(this);">关闭</a>
    <a class="display_img" href="#" target="_blank"><img src="/images/0.gif" class="img" /><img onerror="$(this).prev().show();$(this).hide();showImgHW();" style="display: none" src=""></a>
</div>
<?php require("./include/return_data/js/data_admin.php");?>
