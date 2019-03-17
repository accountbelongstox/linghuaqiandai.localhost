<link rel="stylesheet" type="text/css" href="/css/jing_data.css">
<style>
    <?php require("./include/return_data/css/form_data_admin.php");?>
</style>
<?php require("./include/return_data/css/table_admin.php");?>
<link rel="stylesheet" type="text/css" href="/css/table_admin.css">
<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
<div id="<?php echo $module['module_name'];?>_html" class="<?php echo $module['module_name'];?>_html" cloud-table="1" class="<?php echo $module['module_name'];?>_html">
<div class="fexid_css">
    <div class="portlet-title">
        <div class="div_css1" style="display: inline-block;float:left">
            <a data-href="/index.php?cloud=form.table_add" href="/index.php?cloud=form.table_add"  class="add_table_admin "><i class="fa-table"></i> 添加表单</a>
            <a href="javascript:void(0);" class="add_table_folder "><i class="fa-folder-o"></i> 添加文件夹</a>
            <a href="javascript:void(0);" class="copy_table_span"><i class="fa-paste"></i> 复制表单</a>
        </div>
        </div>
    <div class="filter_div" style="height: 40px;">
        <?php echo $module["showtypehtml"];?>
        <div class="admin_table_list_right">
        <input type="text" style="width:400px;" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['name']?>/<?php echo self::$language['table_name']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> 
        <div class="clear"></div>
        </div>
    </div>
</div>
    <div class=table_scroll>
        <?php echo $module["re_html_head"];?>
        <div class="row" style="margin-left:0;margin-right: 0">
            <?php echo $module['list']?>
        </div>
    </div>
    <?php echo $module['page']?>
</div>
<div class="categories pull-left col_css_div" id="categories_col" style="display: none">
    <div class="copy_table" style="padding: 0;"><a href="javascript:;" data-n="2" class="css_close" ><i class="fa-remove"></i> </a></div>
    <div class="copy_table"><span class="icon-arrow-right">选择表:</span><select class="copy_table_select" style=""><option data-id="0" value="default">请选择</option><?php echo $module['tablename_option'];?></select></div>
    <div class="copy_table"><span class="icon-arrow-right">新表名:</span><input type="text" name="copy_table_name" class="copy_table_name" id="copy_table_name" /></div>
    <div class="copy_table"><a href="javascript:;" data-activeUrl="<?php echo $module['action_url'];?>" class="copy_submit" >&nbsp;确认复制</a></div>
    <div class="copy_table">
        <p>说明:</p>
        <p>. 复制表时并不同时复制数据.</p>
        <p>. 只能复制本人创建的表.</p>
    </div>
</div>
<div class="tooltipster-base gd-tooltip-light gd-tooltip-menu-over tooltipster-fade tooltipster-fade-show" style="pointer-events: auto; top:60px;left:80px;transition-duration: 10ms; animation-duration: 10ms;display: none;"><div class="tooltipster-content" style="max-height: 801.9px;">
        <div class="setting-details" id="setting_details_folder">
            <a data-save-folder-path="/form_folders" data-save-folder-method="post" class="form-folder-save-link gd-hide" href="javascript:void(0)"></a>
            <div class="content dashboard-edit-form-folder">
                <div class="header">
                    <div class="header-content">
                        <a class="back-to-settings" href="javascript:void(0)">
                            <i class="gd-icon-angle-left"></i>
                            返回
                        </a>




                        <span class="setting-title">创建新文件夹</span>
                        <a class="setting-action" href="javascript:void(0)" onclick="create_folder(this);">确认创建</a>
                        <a href="javascript:;" data-n="6" class="css_close" ><i class="fa-remove"></i> </a>
                    </div>
                    <div class="error-message gd-hide"></div>
                </div>
                <div class="folder-name-container">
    <span class="input-with-enter-container">
  <input type="text" class="form-folder-name" placeholder="文件夹名称" value="">
  <i class="gd-icon-enter input-enter-icon"></i>
</span>
                </div>
                <div class="symbol-details">
                    <ul class="color-boxes clearfix">
                        <li class="color-box form-color-1" data-index="1" data-value="#4D9FFF">
                            <i class="fa-check active-icon"></i>
                        </li>
                        <li class="color-box form-color-2 active" data-index="2" data-value="#FFB54D">
                            <i class="fa-check active-icon"></i>
                        </li>
                        <li class="color-box form-color-3" data-index="3" data-value="#54C7FC">
                            <i class="fa-check active-icon"></i>
                        </li>
                        <li class="color-box form-color-4" data-index="4" data-value="#FF6885">
                            <i class="fa-check active-icon"></i>
                        </li>
                        <li class="color-box form-color-5" data-index="5" data-value="#44DB5E">
                            <i class="fa-check active-icon"></i>
                        </li>
                    </ul>


                    <ul class="icon-boxes clearfix form-color-2">
                        <li class="form-icon-box" data-value="fa-pencil">
                            <i class="fa-pencil"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-book">
                            <i class="fa-book"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-music">
                            <i class="fa-music"></i>
                        </li>
                        <li class="form-icon-box active" data-value="fa-photo">
                            <i class="fa-photo"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-user">
                            <i class="fa-user"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-shop">
                            <i class="fa-star"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-comment">
                            <i class="fa-comment"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-thumbs-up">
                            <i class="fa-thumbs-up"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-panel">
                            <i class="fa-circle"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-flag">
                            <i class="fa-flag"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-work">
                            <i class="fa-tag"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-sound">
                            <i class="fa-magic"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-plane">
                            <i class="fa-plane"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-globe">
                            <i class="fa-globe"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-money">
                            <i class="fa-money"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-truck">
                            <i class="fa-truck"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-coffee">
                            <i class="fa-coffee"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-heart">
                            <i class="fa-heart"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-leaf">
                            <i class="fa-leaf"></i>
                        </li>
                        <li class="form-icon-box" data-value="fa-chart">
                            <i class="fa-fire"></i>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </div>
</div>
<?php require("./include/return_data/js/table_admin.php");/*JS*/?>