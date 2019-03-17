<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $module['map_api'];?>"></script>
<div id="<?php echo $module['module_name'];?>"  class="portlet light form_data_add_page" cloud-module="<?php echo $module['module_name'];?>" align=left >
    <script src="/plugin/datePicker/index.php"></script>
	<?php echo $module['data']['css_diy']?>
	<style>
	<?php echo $module['data']['bg_css']?>
    <?php echo $module['data']['defind_style'] /*用户自定义css*/?>
    </style>
    <?php require ("./include/return_data/css/data_add.php");/*用户自定义css*/?>
	<div class="form_title_div form_title_background" data-background-image="<?php echo $module['data']['form_title_background'];?>">
        <div class="formLogo titlebackgroundlogo" >
            <img id="formLogo_SRC" border="0" alt="<?php echo $module['data']['description']?>" src="<?php echo $module['data']['titlebackgroundlogo'];?>" style="<?php echo $module['data']['titlebackgroundlogo_sryle'];?>">
        </div>
        <div class="title_f_text" style="display: none;" >
            <div class=form_title><?php echo $module['data']['description']?></div>
            <div class="desfontcolor" ><?php echo $module['data']['describe']?></div>
        </div>
        <div class="clear"></div>
    </div>
    <div id="<?php echo $module['module_name'];?>_html" class="form_data_add">  
    <div class="Header_Bj" style="display: none;" >以下内容需为申请人真实有效信息。
      <br>若填写虚假信息，会影响您的审批结果。
      <div class="gb_click">X</div>
    </div>
    <script type="text/javascript">
        $(".gb_click").click(function(){
            $(".Header_Bj").hide();
        })
    </script>
    <?php echo $module['fields'];?>
	<?php echo $module['add_submit'];?> 
    </div>
</div>
<div class="data_add_footer"><a href="/" class="fs_powerby" target="_blank">由 <img width="100" src="/images/form_bottom_logo.png">金融云提供</a></div>
<div class="f_share_container">
    <div class="f_share_main">
        <div class="f_share" style="overflow: hidden; width: 30px;"><img src="/images/icon/qrcodeIcon.png" class="qrcode"><span class="share_info">表单-二维码</span></div>
    </div>
</div>

<div class="tbox" id="code_box" style="position: fixed;opacity: 1; display: none;">
    <div class="tinner" id="weixinshare" style="width: 210px; background-image: none;"><div class="tcontent" style="display: block;">
            <div class="popwin_content" style="margin-top:0;">
                <img onerror="ReLoadImg(this,'submit',<?php echo $module['table_id'];?> );" class="sharecode" src="<?php echo $module['data']['submit-code'];?>"><div class="share_des">微信“扫一扫”分享给好友</div>
                <?php echo $module['data']['publish_condition'];?>
            </div>
        </div>
        </div>
</div>
<?php require ("./include/return_data/js/data_add.php");/*用户自定义js*/?>