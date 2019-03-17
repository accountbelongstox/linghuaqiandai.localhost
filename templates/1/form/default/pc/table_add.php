<link rel="stylesheet" type="text/css" href="/css/formBuilder.css">
<link rel="stylesheet" type="text/css" href="/css/formCreate.css">
<style>
    ol, ul, li {
        list-style: none;
    }
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html div{ line-height:60px;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; width:150px; text-align:right; padding-right:10px; }
    /*表单设计CSS载入*/
    <?php require("./include/return_data/css/form_data_admin.php");?>
</style>
<?php require("./include/return_data/css/table_add.php");?>
<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
<!--////////////////////////////////////////////////////////////////////////////////////-->
<div id="wrapper">
    <div class="globalLoading"  data-html="载入中..." style="display: none;">
        <div class="info" data-html="载入中...">
            载入中...
        </div>
    </div>
    <div id="main">
        <div class="formBuilder_step">
            <p class="formBuilder_title"><span>1</span>选择模板</p>
            <p class="formBuilder_line"></p>
            <p class="formBuilder_title formBuilder_title_active"><span>2</span>设计表</p>
            <p class="formBuilder_line"></p>
            <p class="formBuilder_title"><span>3</span>生成表单</p>
        </div>
        <div class="formBuilder_show formBuilder_step2_show">
            <!-- 表单示例 -->
            <div class="formBuilder_example_all">
                <!-- <a class="open_logic logic_btn">逻辑编辑</a> -->
                <div class="formBuilder_interim"></div>
                <!-- <div class="formBuilder_main_container"> -->
                <!-- <div class="formBuilder_main_content"> -->
                <div class="formBuilder_example" data-delete-id="" data-table-id="0" data-table-name="" tabindex="5000" style="overflow-y: hidden; outline: none;display: block;background-position: center top;">
                    <div class="formBuilder_example_form">
                        <div class="formBuilder_main">
                            <div class="form_title" finishform="" type="0" sendtoemail="" sendtoname="" sendtosms="" paymenttype="" paymentonly="" titlebackgroundimg="">
                                <div class="formLogo" style="display: none;">
                                    <img id="face" border="" alt="" src="" style="display: none;">
                                </div>
                                <div class="title">
                                    <h2 id="data-table-description">新的表单</h2>
                                    <div id="data-remark">从头开始创建您的表单</div>
                                </div>
                                <div class="clearB"></div>
                            </div>
                            <ul class="form_component ui-sortable" id="ui-sortable" data-zIndes="10" ></ul>
                        </div>
                    </div>
                </div>
                <div class="formBuilder_example_use">
                    <a class="btn btn-primary btn_example_toStep1" onclick="alert('此功能即将上线');" style="margin-left:20px;margin-right:20px;float:left;background: #000;border: none;">重新选择模板</a>
                    <a class="btn btn-primary btn_example_save" data-action_url="<?php echo $module['action_url'];?>">保存表单</a>
                    <a class="btn_example_preview" style="display: none;" target="_blank"></a>
                    <a class="btn btn-primary btn_example_generate" style="float:right;margin-right:20px;"> <img src="/images/icon/yesWhite.png"><span>生成表单</span> </a>
                </div>
            </div>
            <!-- step2 -->
            <div class="formBuilder_step2">
                <div class="formBuilder_interim">
                    <div class="form_edit_titlefield">
                        <p class="formBuilder_interim_edit formBuilder_interim_edit_active"> 表单设置 </p>
                        <p class="formBuilder_interim_edit"> 添加组件 </p>
                        <p class="formBuilder_interim_edit"> 编辑组件 </p>
                        <p class="formBuilder_interim_edit formBuilder_interim_edit_color"> 配色方案 </p>
                    </div>
                    <div class="form_edit_schemefield">
                        <p class="formBuilder_interim_color"> <img src="/images/icon/editBlue.png"> 配色方案 </p>
                    </div>
                </div>
                <!-- 表单设置 -->
                <div class="formBuilder_edit formBuilder_edit_hidden" tabindex="5001" style="overflow: auto; outline: none; display: block;">
                    <div class="form_edit_expand form_expand">
                        <p class="form_edit_expand_title">表单外观<img class="pullicon" src="/images/icon/pullupBlue.png"></p>
                        <div class="form_appearance form_expand_show form_edit_expand_container">
                            <div class="formBuilder_edit_filed">
                                <p class="formBuilder_edit_describe">标题</p>
                                <input class="input formBuilder_edit_input formName_input">
                            </div>
                            <div class="formBuilder_edit_filed">
                                <p class="formBuilder_edit_describe">副标题</p>
                                <input class="input formBuilder_edit_input formDescribe_input">
                            </div>
                            <div class="formBuilder_edit_filed">
                                <p class="formBuilder_edit_describe">备注(仅后台显示)</p>
                                <input class="input formBuilder_edit_input formInstruct_input">
                            </div>
                        </div>
                    </div>
                    <div class="form_edit_expand form_expand">
                        <p class="form_edit_expand_title">填写限制<img class="pullicon" src="/images/icon/pullupBlue.png"></p>
                        <div class="form_start_end form_edit_expand_container form_expand_show" style="display: inline-block;">


                            <div class="formBuilder_edit_filed">
                                <div class="input_checkbox formBuilder_edit_item">
                                    <input checked="checked" type="checkbox" id="data-write_state" class="fll"><label for="data-write_state">表单开启</label>
                                </div>
                            </div>
                            <div class="formBuilder_edit_filed">
                                <div class="input_checkbox formBuilder_edit_item">
                                    <input type="checkbox" id="data-authcode" class="fll"><label for="data-authcode">是否验证码</label>
                                </div>
                            </div>

                            <div class="formBuilder_edit_filed">
                                <div class="input_checkbox formBuilder_edit_item">
                                    <input type="checkbox" id="data-uniqueness" data-uniqueness="" data-uniqueness_name="" class="fll data_uniqueness_sel">
                                    <label for="data-uniqueness">不允许重复提交数据</label>
                                    <div class="uniqueness" id="val-uniqueness">
                                        <label class="radio"><input type="radio" name="formuniqueness" value="phone" checked="checked">手机号判断</label>
                                        <label class="radio"><input type="radio" name="formuniqueness" value="email" >email判断</label>
                                        <label class="radio"><input type="radio" name="formuniqueness" value="qq" >QQ判断</label>
                                    </div>
                                </div>
                            </div>

                            <div class="formBuilder_edit_filed">
                                <div class="input_checkbox formBuilder_edit_item">
                                    <input type="checkbox" id="is_weixin" class="fll">
                                    <label for="is_weixin">只能微信提交</label>
                                </div>
                            </div>


                            <div class="formBuilder_edit_filed">
                                <div class="input_checkbox formBuilder_edit_item checked">
                                    <input type="checkbox"  data-publish_condition='' id="publish_condition" class="fll" ><label for="publish_condition">用户查询进度</label>
                                </div><br>
                                <div class="formEndTime_field" id="publish_condition_div" style="display: none">
                                    <!-- checked="checked" INPUT选中. -->
                                    <div class="formEnd_time">
                                        <span>查询条件：</span>
                                        <div  class="input-append date">
                                            <select data-publish_condition='<?php echo $module['publish_condition'];?>' class="select-date-picker data-read_state" id="publish_condition_select" value="" style="width:140px;">
                                                <option value="" data-value="">请选择</option>
                                            </select>
                                            <span class="add-on"><i class="icon-hand-down"></i></span>
                                            <a data-txt="用户可以输入预设的条件.查询数据的状态. 状态由管理员在后台更改. 如:审核通过.等.." class="wiki_faq_help random_wiki_faq" style="top: 7px;left: 5px;" ref="javascript:;" onclick="help(this);"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form_edit_expand form_expand">
                        <p class="form_edit_expand_title">高级管理<img class="pullicon" src="/images/icon/pullupBlue.png"></p>
                        <div class="form_submit form_expand_show form_edit_expand_container">

                            <div class="formBuilder_edit_filed">
                                <div class="input_checkbox formBuilder_edit_item checked">
                                    <input type="hidden" data-admin-username="" data-edit-username="" data-read-username="" data-invite-admin-phone="" data-invite-edit-phone="" data-invite-read-phone="" data-invite-admin-email="" data-invite-edit-email="" data-invite-read-email="" id="Member_ADDPower_check" class="fll" checked="checked"><label for="Member_ADDPower_check">团队协作</label>
                                    <a class="wiki_faq_help random_wiki_faq" data-txt="允许团队进行合作<br />1:表管理员:拥有和您一样的权限,可以对表进行修改.<br />2:数据维护:可以修改数据,操作状态等.<br />3:数据查看:可以查阅数据.<br />请注意设置,对已经离职的团队成员请尽快删除处理." style="top: 4px;left: 5px;" ref="javascript:;" onclick="help(this);"></a>
                                </div>
                                <div><input type="checkbox" id="table_admin_is_edit"> 表管理同时维护数据</div>
                                <div class="formMember_ADDPower_field" id="formMember_ADDPower_field">
                                    <!--团队协作
                                    -->
                                </div>

                                <div class="formEnd_addContcat">
                                    <div class="input-append date table_join">
                                        <a class="add-on" id="add-enterprise-contact">添加或邀请成员 <i class="fa-group"></i></a>
                                        <a class="wiki_faq_help random_wiki_faq" style="top: 7px;left: 5px;"  data-txt="添加团队的成员账号.<br />请先在联系人中添加成员账号." ref="javascript:;" onclick="help(this);"></a>
                                    </div>

                                </div>
                            </div>

                            <!--短信功能-->
                            <div class="formBuilder_edit_filed">
                                <div class="input_checkbox formBuilder_edit_item checked">
                                    <input type="checkbox" id="data-table_sms" class="fll"><label for="data-table_sms">数据维护时短信通知用户</label>
                                    <a class="wiki_faq_help random_wiki_faq" data-txt="当管理员或数据维护员操作表时.<br />发送短信到用户手机.<br />可以指定那种状态才给用户发送短信." style="top: 3px;left: 5px;" ref="javascript:;" onclick="help(this);"></a>
                                </div><br>
                                    <div class="dropdown_wrapper dropdown_group" style="display:none;" class="data-table_join" id="data-table_join">
                                       <ul class="dropdown_operate group_operate saveToGroup saveToGroup" id="data-table_join_detail" style="">
                                           <li class="group_firstLi" style="display: block;"><div class="fll">选择通知状态：</div><div class="clearB"></div></li>
                                           <li class="group_firstLi group_last_Li" style="display: block;"><a onclick="add_group_firstLi($(this).attr('data-v'),$(this).attr('data-str'),'click');" data-v="0" data-str="新添加" class="fll group_last_li"><i class="fa-plus"></i></a><div class="clearB"></div></li>
                                        </ul>
                                    </div>
                            </div>
                            <div class="formBuilder_edit_filed">
                                <ul class="dropdown_operate group_operate saveToGroup saveToGroup" id="data-table_shortcut" style="display:block;margin-top:0;">
                                    <li class="group_firstLi" style="display: block;">
                                        <div class="fll">数据维护快捷短语：<a class="add_fih" href="javascript:void(0);" onclick="add_firstLi(this);">添加</a></div>
                                        <div class="fll" style="width: 100%;"><input class="input_add_firstLi" onblur="input_add_firstLi(this.value);" type="text" style="width: 100%;line-height: 18px; height: 18px;display: none;"></div>
                                        <div class="clearB"></div>
                                    </li>
                                    <li class="data-shortcut">

                                    </li>
                                </ul>
                            </div>
                            <div class="formBuilder_edit_filed">
                                <p class="formBuilder_edit_describe">用户提交表单后</p>
                                <div class="aftersubmit">
                                    <input type="checkbox" name="formBuilder_callback" id="formBuilder_callback" value="showtext" checked="checked">显示二维码
                                </div><!--<input type="radio" name="formBuilder_edit_afterSubmit" value="showtext" checked="checked"> 原代码-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 添加组件 -->
                <div class="formBuilder_edit formBuilder_edit_hidden" style="overflow: auto; outline: none; display: none;" tabindex="5002">
                    <!-- 添加组件 -->
                    <ul class="utilityCol utilityColFirst">
                        <li class="utility ui-draggable" id="id_text" data-title="点击选择或拖动到左侧"><span class="title">单行文本</span><span class="formOption formOption_text"></span></li>
                        <li class="utility ui-draggable" id="id_textarea" data-title="点击选择或拖动到左侧"><span class="title">多行文本</span><span class="formOption formOption_multiple"></span></li>
                        <li class="utility ui-draggable" id="id_number" data-title="点击选择或拖动到左侧"><span class="title">数字</span><span class="formOption formOption_number"></span></li>
                        <li class="utility ui-draggable" id="id_editor" data-title="点击选择或拖动到左侧"><span class="title">编辑器</span><span class="formOption formOption_section"></span></li>
                        <li class="utility ui-draggable" id="id_select" data-title="点击选择或拖动到左侧"><span class="title">下拉框</span><span class="formOption formOption_dropDown"></span></li>
                        <li class="utility ui-draggable" id="id_radio" data-title="点击选择或拖动到左侧"><span class="title">单选</span><span class="formOption formOption_radio"></span></li>
                        <li class="utility ui-draggable" id="id_checkbox" data-title="点击选择或拖动到左侧"><span class="title">多选</span><span class="formOption formOption_checkbox"></span></li>
                        <li class="utility ui-draggable" id="id_img" data-title="点击选择或拖动到左侧"><span class="title">图片</span><span class="formOption formOption_pictureRadio"></span></li>
                        <li class="utility ui-draggable" id="id_imgs" data-title="点击选择或拖动到左侧"><span class="title">多图片</span><span class="formOption formOption_picturecheckbox"></span></li>
                        <li class="utility ui-draggable" id="id_file" data-title="点击选择或拖动到左侧"><span class="title">文件上传</span><span class="formOption formOption_fileUpload"></span></li>
                        <li class="utility ui-draggable" id="id_files" data-title="点击选择或拖动到左侧"><span class="title">多文件上传</span><span class="formOption formOption_fileUpload"></span></li>
                        <li class="utility ui-draggable" id="id_time" data-title="点击选择或拖动到左侧"><span class="title">日期</span><span class="formOption formOption_data"></span></li>
                        <li class="utility ui-draggable" id="id_map" data-title="点击选择或拖动到左侧"><span class="title">地图坐标</span><span class="formOption formOption_star"></span></li>
                        <li class="utility ui-draggable" id="id_area" data-title="点击选择或拖动到左侧"><span class="title">地区选择框</span><span class="formOption formOption_section"></span></li>
                        <li class="utility ui-draggable" id="id_page" data-title="点击选择或拖动到左侧"><span class="title">分页</span><span class="formOption formOption_page"></span></li>
                        <li class="clearB"></li>
                    </ul>
                    <ul class="utilityCol contactsUtility">
                        <hr>
                        <li class="utility_describe" data-title="点击选择或拖动到左侧">联系人组件　<span>用户在组件中填写的内容，会自动成为联系人的信息项</span></li>
                        <li class="utility ui-draggable" id="name" data-title="点击选择或拖动到左侧"><span class="title">姓名</span></li>
                        <li class="utility ui-draggable" id="company" data-title="点击选择或拖动到左侧"><span class="title">公司</span></li>
                        <li class="utility ui-draggable" id="job" data-title="点击选择或拖动到左侧"><span class="title">职位</span></li>
                        <li class="utility ui-draggable" id="address" data-title="点击选择或拖动到左侧"><span class="title">通讯地址</span></li>
                        <li class="utility ui-draggable" id="phone" data-title="点击选择或拖动到左侧"><span class="title">手机</span></li>
                        <li class="utility ui-draggable" id="email" data-title="点击选择或拖动到左侧"><span class="title">E-mail</span></li>
                        <li class="utility ui-draggable" id="qq" data-title="点击选择或拖动到左侧"><span class="title">QQ</span></li>
                        <li class="utility ui-draggable" id="weixin" data-title="点击选择或拖动到左侧"><span class="title">微信</span></li>
                        <li class="utility ui-draggable" id="gender" data-title="点击选择或拖动到左侧"><span class="title">性别</span></li>
                        <li class="utility ui-draggable" id="city" data-title="点击选择或拖动到左侧"><span class="title">城市</span></li>
                        <li class="utility ui-draggable" id="fixedphone" data-title="点击选择或拖动到左侧"><span class="title">固话</span></li>
                        <li class="utility ui-draggable" id="fax" data-title="点击选择或拖动到左侧"><span class="title">传真</span></li>
                        <li class="utility ui-draggable" id="website" data-title="点击选择或拖动到左侧"><span class="title">网址</span></li>
                        <li class="utility ui-draggable" id="birthday" data-title="点击选择或拖动到左侧"><span class="title">生日</span></li>
                        <li class="utility ui-draggable" id="note" data-title="点击选择或拖动到左侧"><span class="title">备注</span></li>
                        <li class="clearB"></li>
                    </ul>
                </div>
                <!-- 编辑组件 -->
                <div class="formBuilder_edit formBuilder_edit_hidden" style="padding-top:25px;overflow: auto; outline: none; display: none;" tabindex="5003">
                    <p class="form_componentEdit_tips">请先选择组件</p>
                    <div class="form_edit" id="form_edit_prev_page" style="display: none;">
                        <p class="form_eit_describe"><label>表单分页设置</label></p>
                        <div style="margin-top:10px;margin-left:18px;">
                            <label for="prev_page_radio_limit"><input type="checkbox" name="radio_limit" id="prev_page_radio_limit">  禁止返回上一页</label>
                        </div>
                    </div>
                    <div style="display: none">
                        <span class="m_label form_lable_width"><span class="required_item">*</span>字段名称</span><span class="input_span"><input type="text" id="description"><span></span></span>
                    </div>
                    <div id="args_div">
                        <div id="args_text" class="args" style="display: none;">
                            <div><span class="m_label form_lable_width">最大长度</span><span class="input_span"><input type="text" id="text_length"><span></span></span></div>
                            <div><span class="m_label form_lable_width">默认值</span><span class="input_span"><input type="text" id="text_default_value"><span></span></span></div>
                        </div>
                        <div id="args_textarea" class="args" style="display: none;">
                            <div><span class="m_label form_lable_width">宽</span><span class="input_span"><input type="text" id="textarea_width"><span></span></span></div>
                            <div><span class="m_label form_lable_width">高</span><span class="input_span"><input type="text" id="textarea_height"><span></span></span></div>
                            <div><span class="m_label form_lable_width">默认值</span><span class="input_span"><textarea id="textarea_default_value"></textarea><span></span></span></div>
                            <div><span class="m_label form_lable_width">允许Html</span><span class="input_span"><select id="textarea_allow_html"><option value="0">否</option><option value="1">是</option></select><span></span></span></div>
                        </div>
                        <div id="args_editor" class="args" style="display: none;">
                            <div><span class="m_label form_lable_width">高</span><span class="input_span"><input type="text" id="editor_height"><span></span></span></div>
                            <div><span class="m_label form_lable_width">默认值</span><span class="input_span"><textarea id="editor_default_value"></textarea><span></span></span></div>
                            <div><span class="m_label form_lable_width">开启图片水印</span><span class="input_span"><select id="editor_open_image_mark"><option value="0">否</option><option value="1">是</option></select><span></span></span></div>
                        </div>
                        <div id="args_select" class="args" style="display: none;">
                            <div><span class="m_label form_lable_width">选项列表</span><span class="input_span"><textarea id="select_option">男/女</textarea><span></span></span></div>
                            <div><span class="m_label form_lable_width">默认值</span><span class="input_span"><input type="text" id="select_default_value"><span></span></span></div>
                        </div>
                        <div id="args_radio" class="args" style="display: none;">
                            <div><span class="m_label form_lable_width">选项列表</span><span class="input_span"><textarea id="radio_option">男/女</textarea><span></span></span></div>
                            <div><span class="m_label form_lable_width">默认值</span><span class="input_span"><input type="text" id="radio_default_value"><span></span></span></div>
                            <div><span class="m_label form_lable_width">样式</span><span class="input_span"><select type="text" class="input_style_select" id="radio_style">
                                        <option value="0">默认</option>
                                        <option value="1">列表</option>
                                    </select><span></span></span></div>
                        </div>
                        <div id="args_checkbox" class="args" style="display: none;">
                            <div><span class="m_label form_lable_width">选项列表</span><span class="input_span"><textarea id="checkbox_option">男/女</textarea><span></span></span></div>
                            <div><span class="m_label form_lable_width">默认值</span><span class="input_span"><input type="text" id="checkbox_default_value"><span></span></span></div>
                        </div>
                        <div id="args_img" class="args" style="display: none;">
                            <div><span class="m_label form_lable_width">允许图片类型</span><span class="input_span"><input type="text" id="img_allow_image_type" value="bmp,jpg,jpeg,tiff,gif,pcx,tga,exif,fpx,svg,psd,cdr,pcd,dxf,ufo,eps,ai,raw,WMF"><span></span></span></div>
                            <div><span class="m_label form_lable_width">开启图片水印</span><span class="input_span"><select id="img_open_image_mark"><option value="0">否</option><option value="1">是</option></select><span></span></span></div>
                            <div><span class="m_label form_lable_width">缩略图宽</span><span class="input_span"><input type="text" id="img_width"><span></span></span></div>
                            <div><span class="m_label form_lable_width">缩略图高</span><span class="input_span"><input type="text" id="img_height"><span></span></span></div>
                        </div>
                        <div id="args_imgs" class="args" style="display: none;">
                            <div><span class="m_label form_lable_width">允许图片类型</span><span class="input_span"><input type="text" id="imgs_allow_image_type" value="bmp,jpg,jpeg,tiff,gif,pcx,tga,exif,fpx,svg,psd,cdr,pcd,dxf,ufo,eps,ai,raw,WMF"><span></span></span></div>
                            <div><span class="m_label form_lable_width">开启图片水印</span><span class="input_span"><select id="imgs_open_image_mark"><option value="0">否</option><option value="1">是</option></select><span></span></span></div>
                            <div><span class="m_label form_lable_width">缩略图宽</span><span class="input_span"><input type="text" id="imgs_width"><span></span></span></div>
                            <div><span class="m_label form_lable_width">缩略图高</span><span class="input_span"><input type="text" id="imgs_height"><span></span></span></div>
                        </div>
                        <div id="args_file" class="args" style="display: none;">
                            <div><span class="m_label form_lable_width">允许文件类型</span><span class="input_span"><input type="text" id="file_allow_file_type" value="rar,zip,doc,docx"><span></span></span></div>
                        </div>
                        <div id="args_files" class="args" style="display: none;">
                            <div><span class="m_label form_lable_width">允许文件类型</span><span class="input_span"><input type="text" id="files_allow_file_type" value="rar,zip,doc,docx"><span></span></span></div>
                        </div>
                        <div id="args_number" class="args" style="display: none;">
                            <div><span class="m_label form_lable_width">取值范围</span><span class="input_span"><input type="text" id="number_min" value="0">-<input type="text" id="number_max"><span></span></span></div>
                            <div><span class="m_label form_lable_width">小数位数</span><span class="input_span"><select id="number_decimal_places"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select><span></span></span></div>
                            <div><span class="m_label form_lable_width">默认值</span><span class="input_span"><input type="text" id="number_default_value"><span></span></span></div>
                        </div>
                        <div id="args_time" class="args" style="display: none;">
                            <div><span class="m_label form_lable_width">时间格式</span><span class="input_span"><select id="time_style"><option value="Y-m-d">年月日</option><option value="Y-m-d H:i:s">年月日 时分秒</option></select><span></span></span></div>
                        </div>
                    </div>
                    <div style="display: none"><span class="m_label form_lable_width">字段提示</span><span class="input_span"><input type="text" id="placeholder"><span></span></span></div>
                    <div style="display: none"><span class="m_label form_lable_width">匹配规则</span><span class="input_span"><input type="text" id="reg"><span></span>
        <select id="set_reg">
        	<option value="">自定义</option>
        	<option value="/^[0-9.-]+$/">数字</option>
        	<option value="/^[0-9-]+$/">整数</option>
        	<option value="/^[a-z]+$/i">字母</option>
        	<option value="/^[0-9a-z]+$/i">字母+数字</option>
        	<option value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/">E-mail</option>
        	<option value="/^[0-9]{5,20}$/">QQ</option>
        	<option value="/^http:\/\//">网址链接</option>
        	<option value="/^(1)[0-9]{10}$/">中国手机号码</option>
        	<option value="/^[0-9-]{6,13}$/">中国电话号码</option>
        	<option value="/^[0-9]{6}$/">中国邮政编码</option>
        </select>
                        </span>
                    </div>
                    <div style="display: none"><span class="m_label form_lable_width">用户必填</span><span class="input_span"><select id="data-required"><option value="0">否</option><option value="1">是</option></select><span></span></span></div>
                    <div style="display: none"><span class="m_label form_lable_width">可搜索</span><span class="input_span"><select id="search_able"><option value="1">是</option><option value="0">否</option></select><span></span></span></div>
                    <div style="display: none"><span class="m_label form_lable_width">值唯一</span><span class="input_span"><select id="unique"><option value="0">否</option><option value="1">是</option></select><span></span></span></div>
                    <!-- end -->
                </div>
                <!-- 配色方案 -->
                <!-- <div class="formBuilder_edit formBuilder_color" style='display:none;'>
                          <div class="style_pad">
                              <p style="padding-top:20px;text-align:center;">载入中...</p>
                          </div>
                          <div class="style_design_pad">
                              <span class="sdp_name">样式设置</span><span class="sdp_save">保存样式</span>
                              <div class="clearB"></div>
                          </div>
                          <div class="style_design">
                              <div class="style_design_pad">
                                  <span class="sdp_name">样式设置</span><span class="sdp_save">保存样式</span>
                                  <div class="clearB"></div>
                              </div>
                              <div class="style_design_item"></div>
                          </div>
                      </div> -->
                <div class="formBuilder_color formBuilder_color_outer">
                    <div class="style_pad" tabindex="5004" style="overflow: auto; outline: none; bottom: 62%;">
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,336699,000000,,,,,6699CC,000000,,,FFFFFF,000000,7C7C7C,FFF8DC,000000">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="336699" t="000000" style="background-color:#336699;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="6699cc" t="000000" style="background-color:#6699cc;color:#000000;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="FFFFFF" t="000000" style="background-color:#FFFFFF;color:#000000;">
                                    <p class="csb_stitle" style="background-color:#000000;color:#000000;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="7C7C7C" style="background-color:#7C7C7C;color:#7C7C7C;"></p>
                                    <p class="csb_highlight csbs" bk="FFF8DC" t="000000" style-name="formBuilder_color_highlight" style="background:#FFF8DC;color:#000000"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,FFFFFF,000000,,,,,669ACC,FFFFFF,,,FFFFFF,000000,7C7C7C,FFF8DC,000000">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="FFFFFF" t="000000" style="background-color:#FFFFFF;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="669ACC" t="FFFFFF" style="background-color:#669ACC;color:#FFFFFF;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="FFFFFF" t="000000" style="background-color:#FFFFFF;color:#000000;">
                                    <p class="csb_stitle" style="background-color:#000000;color:#000000;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="7C7C7C" style="background-color:#7C7C7C;color:#7C7C7C;"></p>
                                    <p class="csb_highlight csbs" bk="FFF8DC" t="000000" style-name="formBuilder_color_highlight" style="background:#FFF8DC;color:#000000"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,677E52,000000,,,,,B7CA79,000000,,,F6E8B1,000000,666666,CBBC84,000000">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="677E52" t="000000" style="background-color:#677E52;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="B7CA79" t="000000" style="background-color:#B7CA79;color:#000000;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="F6E8B1" t="000000" style="background-color:#F6E8B1;color:#000000;">
                                    <p class="csb_stitle" style="background-color:#000000;color:#000000;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="666666" style="background-color:#666666;color:#666666;"></p>
                                    <p class="csb_highlight csbs" bk="CBBC84" t="000000" style-name="formBuilder_color_highlight" style="background:#CBBC84;color:#000000"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,193441,000000,,,,,6990A2,FFFFFF,,,FCFFF5,000000,7C7C7C,D0D6C0,000000">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="193441" t="000000" style="background-color:#193441;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="6990A2" t="FFFFFF" style="background-color:#6990A2;color:#FFFFFF;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="FCFFF5" t="000000" style="background-color:#FCFFF5;color:#000000;">
                                    <p class="csb_stitle" style="background-color:#000000;color:#000000;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="7C7C7C" style="background-color:#7C7C7C;color:#7C7C7C;"></p>
                                    <p class="csb_highlight csbs" bk="D0D6C0" t="000000" style-name="formBuilder_color_highlight" style="background:#D0D6C0;color:#000000"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,F0E14C,000000,,,,,E85305,FFFFFF,,,FFF79F,000000,7C7C7C,D6CE77,000000">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="F0E14C" t="000000" style="background-color:#F0E14C;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="E85305" t="FFFFFF" style="background-color:#E85305;color:#FFFFFF;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="FFF79F" t="000000" style="background-color:#FFF79F;color:#000000;">
                                    <p class="csb_stitle" style="background-color:#000000;color:#000000;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="7C7C7C" style="background-color:#7C7C7C;color:#7C7C7C;"></p>
                                    <p class="csb_highlight csbs" bk="D6CE77" t="000000" style-name="formBuilder_color_highlight" style="background:#D6CE77;color:#000000"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,76C48A,000000,,,,,018079,FFFFFF,,,D4E9D8,018079,666666,A6D4AF,018079">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="76c48a" t="000000" style="background-color:#76c48a;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="018079" t="ffffff" style="background-color:#018079;color:#ffffff;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="d4e9d8" t="018079" style="background-color:#d4e9d8;color:#018079;">
                                    <p class="csb_stitle" style="background-color:#018079;color:#018079;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="666666" style="background-color:#666666;color:#666666;"></p>
                                    <p class="csb_highlight csbs" bk="a6d4af" t="018079" style-name="formBuilder_color_highlight" style="background:#a6d4af;color:#018079"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,CC679F,000000,,,,,6D0D64,FFFFFF,,,F5D5E4,5C0B54,CC5E9B,DFADC5,5C0B54">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="cc679f" t="000000" style="background-color:#cc679f;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="6d0d64" t="ffffff" style="background-color:#6d0d64;color:#ffffff;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="f5d5e4" t="5c0b54" style="background-color:#f5d5e4;color:#5c0b54;">
                                    <p class="csb_stitle" style="background-color:#5c0b54;color:#5c0b54;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="cc5e9b" style="background-color:#cc5e9b;color:#cc5e9b;"></p>
                                    <p class="csb_highlight csbs" bk="dfadc5" t="5c0b54" style-name="formBuilder_color_highlight" style="background:#dfadc5;color:#5c0b54"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,143777,000000,,,,,315BA7,FFFFFF,,,CADFF4,315BA7,666666,9DC2E7,315BA7">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="143777" t="000000" style="background-color:#143777;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="315ba7" t="ffffff" style="background-color:#315ba7;color:#ffffff;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="cadff4" t="315ba7" style="background-color:#cadff4;color:#315ba7;">
                                    <p class="csb_stitle" style="background-color:#315ba7;color:#315ba7;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="666666" style="background-color:#666666;color:#666666;"></p>
                                    <p class="csb_highlight csbs" bk="9dc2e7" t="315ba7" style-name="formBuilder_color_highlight" style="background:#9dc2e7;color:#315ba7"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,210408,000000,,,,,6D1B27,FFFFFF,,,AF9296,210408,6D1B27,96696F,210408">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="210408" t="000000" style="background-color:#210408;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="6d1b27" t="ffffff" style="background-color:#6d1b27;color:#ffffff;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="af9296" t="210408" style="background-color:#af9296;color:#210408;">
                                    <p class="csb_stitle" style="background-color:#210408;color:#210408;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="6d1b27" style="background-color:#6d1b27;color:#6d1b27;"></p>
                                    <p class="csb_highlight csbs" bk="96696f" t="210408" style-name="formBuilder_color_highlight" style="background:#96696f;color:#210408"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,624C37,000000,,,,,301E12,FFFFFF,,,C7B7A5,301E12,624C37,AD9478,624C37">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="624c37" t="000000" style="background-color:#624c37;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="301e12" t="ffffff" style="background-color:#301e12;color:#ffffff;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="c7b7a5" t="301e12" style="background-color:#c7b7a5;color:#301e12;">
                                    <p class="csb_stitle" style="background-color:#301e12;color:#301e12;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="624c37" style="background-color:#624c37;color:#624c37;"></p>
                                    <p class="csb_highlight csbs" bk="ad9478" t="624c37" style-name="formBuilder_color_highlight" style="background:#ad9478;color:#624c37"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,785F98,000000,,,,,2D2846,FFFFFF,,,B9B4CF,2D2846,785F98,988FC2,2D2846">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="785f98" t="000000" style="background-color:#785f98;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="2d2846" t="ffffff" style="background-color:#2d2846;color:#ffffff;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="b9b4cf" t="2d2846" style="background-color:#b9b4cf;color:#2d2846;">
                                    <p class="csb_stitle" style="background-color:#2d2846;color:#2d2846;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="785f98" style="background-color:#785f98;color:#785f98;"></p>
                                    <p class="csb_highlight csbs" bk="988fc2" t="2d2846" style-name="formBuilder_color_highlight" style="background:#988fc2;color:#2d2846"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,D6623D,000000,,,,,8E2800,FEF3BE,,,FEF3BE,752100,B3542E,EDC78C,752100">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="d6623d" t="000000" style="background-color:#d6623d;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="8e2800" t="fef3be" style="background-color:#8e2800;color:#fef3be;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="fef3be" t="752100" style="background-color:#fef3be;color:#752100;">
                                    <p class="csb_stitle" style="background-color:#752100;color:#752100;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="b3542e" style="background-color:#b3542e;color:#b3542e;"></p>
                                    <p class="csb_highlight csbs" bk="edc78c" t="752100" style-name="formBuilder_color_highlight" style="background:#edc78c;color:#752100"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,677E52,000000,,,,,92B377,FFFFFF,,,E2F4D3,4B5D3A,92B377,AFCA98,4B5D3A">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="677e52" t="000000" style="background-color:#677e52;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="92b377" t="ffffff" style="background-color:#92b377;color:#ffffff;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="e2f4d3" t="4b5d3a" style="background-color:#e2f4d3;color:#4b5d3a;">
                                    <p class="csb_stitle" style="background-color:#4b5d3a;color:#4b5d3a;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="92b377" style="background-color:#92b377;color:#92b377;"></p>
                                    <p class="csb_highlight csbs" bk="afca98" t="4b5d3a" style-name="formBuilder_color_highlight" style="background:#afca98;color:#4b5d3a"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,A52D2D,000000,,,,,871110,FFFFFF,,,F7C4BC,8B0201,9D5453,E59689,8B0201">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="a52d2d" t="000000" style="background-color:#a52d2d;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="871110" t="ffffff" style="background-color:#871110;color:#ffffff;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="f7c4bc" t="8b0201" style="background-color:#f7c4bc;color:#8b0201;">
                                    <p class="csb_stitle" style="background-color:#8b0201;color:#8b0201;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="9d5453" style="background-color:#9d5453;color:#9d5453;"></p>
                                    <p class="csb_highlight csbs" bk="e59689" t="8b0201" style-name="formBuilder_color_highlight" style="background:#e59689;color:#8b0201"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,1C2742,000000,,,,,3C91C7,FFFFFF,,,E0EEFB,1C2742,808B9B,9FC2E3,1C2742">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="1c2742" t="000000" style="background-color:#1c2742;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="3c91c7" t="ffffff" style="background-color:#3c91c7;color:#ffffff;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="e0eefb" t="1c2742" style="background-color:#e0eefb;color:#1c2742;">
                                    <p class="csb_stitle" style="background-color:#1c2742;color:#1c2742;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="808b9b" style="background-color:#808b9b;color:#808b9b;"></p>
                                    <p class="csb_highlight csbs" bk="9fc2e3" t="1c2742" style-name="formBuilder_color_highlight" style="background:#9fc2e3;color:#1c2742"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,252523,000000,,,,,3E3E3C,FFFFFF,,,D4D3CF,252523,767676,A3A3A1,252523">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="252523" t="000000" style="background-color:#252523;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="3e3e3c" t="ffffff" style="background-color:#3e3e3c;color:#ffffff;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="d4d3cf" t="252523" style="background-color:#d4d3cf;color:#252523;">
                                    <p class="csb_stitle" style="background-color:#252523;color:#252523;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="767676" style="background-color:#767676;color:#767676;"></p>
                                    <p class="csb_highlight csbs" bk="a3a3a1" t="252523" style-name="formBuilder_color_highlight" style="background:#a3a3a1;color:#252523"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,032950,000000,,,,,11406C,FFFFFF,,,8AABCA,032950,DFEAF4,5682AB,032950">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="032950" t="000000" style="background-color:#032950;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="11406c" t="ffffff" style="background-color:#11406c;color:#ffffff;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="8aabca" t="032950" style="background-color:#8aabca;color:#032950;">
                                    <p class="csb_stitle" style="background-color:#032950;color:#032950;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="dfeaf4" style="background-color:#dfeaf4;color:#dfeaf4;"></p>
                                    <p class="csb_highlight csbs" bk="5682ab" t="032950" style-name="formBuilder_color_highlight" style="background:#5682ab;color:#032950"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,AE7AC5,000000,,,,,9553B1,FFFFFF,,,F9EEFE,7C4593,AE7AC5,E8C8F6,7C4593">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="ae7ac5" t="000000" style="background-color:#ae7ac5;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="9553b1" t="ffffff" style="background-color:#9553b1;color:#ffffff;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="f9eefe" t="7c4593" style="background-color:#f9eefe;color:#7c4593;">
                                    <p class="csb_stitle" style="background-color:#7c4593;color:#7c4593;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="ae7ac5" style="background-color:#ae7ac5;color:#ae7ac5;"></p>
                                    <p class="csb_highlight csbs" bk="e8c8f6" t="7c4593" style-name="formBuilder_color_highlight" style="background:#e8c8f6;color:#7c4593"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items active_color" schemeinfo="640PX,16PX,25PX,F4F5F0,000000,,,,,FFFFFF,000000,,,FFFFFF,000000,7C7C7C,FFF8DC,000000">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="F4F5F0" t="000000" style="background-color:#F4F5F0;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="FFFFFF" t="000000" style="background-color:#FFFFFF;color:#000000;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="FFFFFF" t="000000" style="background-color:#FFFFFF;color:#000000;">
                                    <p class="csb_stitle" style="background-color:#000000;color:#000000;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="7C7C7C" style="background-color:#7C7C7C;color:#7C7C7C;"></p>
                                    <p class="csb_highlight csbs" bk="FFF8DC" t="000000" style-name="formBuilder_color_highlight" style="background:#FFF8DC;color:#000000"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,F4F5F0,000000,,,,,998DBD,000000,,,FFFFFF,000000,7C7C7C,FFF8DC,000000">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="F4F5F0" t="000000" style="background-color:#F4F5F0;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="998DBD" t="000000" style="background-color:#998DBD;color:#000000;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="FFFFFF" t="000000" style="background-color:#FFFFFF;color:#000000;">
                                    <p class="csb_stitle" style="background-color:#000000;color:#000000;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="7C7C7C" style="background-color:#7C7C7C;color:#7C7C7C;"></p>
                                    <p class="csb_highlight csbs" bk="FFF8DC" t="000000" style-name="formBuilder_color_highlight" style="background:#FFF8DC;color:#000000"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,F4F5F0,000000,,,,,C783A7,000000,,,FFFFFF,000000,7C7C7C,FFF8DC,000000">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="F4F5F0" t="000000" style="background-color:#F4F5F0;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="C783A7" t="000000" style="background-color:#C783A7;color:#000000;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="FFFFFF" t="000000" style="background-color:#FFFFFF;color:#000000;">
                                    <p class="csb_stitle" style="background-color:#000000;color:#000000;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="7C7C7C" style="background-color:#7C7C7C;color:#7C7C7C;"></p>
                                    <p class="csb_highlight csbs" bk="FFF8DC" t="000000" style-name="formBuilder_color_highlight" style="background:#FFF8DC;color:#000000"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,F4F5F0,000000,,,,,CE827B,000000,,,FFFFFF,000000,7C7C7C,FFF8DC,000000">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="F4F5F0" t="000000" style="background-color:#F4F5F0;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="CE827B" t="000000" style="background-color:#CE827B;color:#000000;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="FFFFFF" t="000000" style="background-color:#FFFFFF;color:#000000;">
                                    <p class="csb_stitle" style="background-color:#000000;color:#000000;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="7C7C7C" style="background-color:#7C7C7C;color:#7C7C7C;"></p>
                                    <p class="csb_highlight csbs" bk="FFF8DC" t="000000" style-name="formBuilder_color_highlight" style="background:#FFF8DC;color:#000000"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,F4F5F0,000000,,,,,CCC472,000000,,,FFFFFF,000000,7C7C7C,FFF8DC,000000">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="F4F5F0" t="000000" style="background-color:#F4F5F0;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="CCC472" t="000000" style="background-color:#CCC472;color:#000000;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="FFFFFF" t="000000" style="background-color:#FFFFFF;color:#000000;">
                                    <p class="csb_stitle" style="background-color:#000000;color:#000000;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="7C7C7C" style="background-color:#7C7C7C;color:#7C7C7C;"></p>
                                    <p class="csb_highlight csbs" bk="FFF8DC" t="000000" style-name="formBuilder_color_highlight" style="background:#FFF8DC;color:#000000"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,F4F5F0,000000,,,,,8BBF7F,000000,,,FFFFFF,000000,7C7C7C,FFF8DC,000000">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="F4F5F0" t="000000" style="background-color:#F4F5F0;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="8BBF7F" t="000000" style="background-color:#8BBF7F;color:#000000;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="FFFFFF" t="000000" style="background-color:#FFFFFF;color:#000000;">
                                    <p class="csb_stitle" style="background-color:#000000;color:#000000;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="7C7C7C" style="background-color:#7C7C7C;color:#7C7C7C;"></p>
                                    <p class="csb_highlight csbs" bk="FFF8DC" t="000000" style-name="formBuilder_color_highlight" style="background:#FFF8DC;color:#000000"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,BAE3F9,000000,,,,,65AADD,FFFFFF,,,FFFFFF,000000,758894,FFF8DC,000000">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="bae3f9" t="000000" style="background-color:#bae3f9;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="65aadd" t="FFFFFF" style="background-color:#65aadd;color:#FFFFFF;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="FFFFFF" t="000000" style="background-color:#FFFFFF;color:#000000;">
                                    <p class="csb_stitle" style="background-color:#000000;color:#000000;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="758894" style="background-color:#758894;color:#758894;"></p>
                                    <p class="csb_highlight csbs" bk="FFF8DC" t="000000" style-name="formBuilder_color_highlight" style="background:#FFF8DC;color:#000000"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,F7CF68,000000,,,,,9C694E,333333,,,F6E8B1,231A15,564B85,CBBC84,231A15">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="f7cf68" t="000000" style="background-color:#f7cf68;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="9c694e" t="333333" style="background-color:#9c694e;color:#333333;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="F6E8B1" t="231a15" style="background-color:#F6E8B1;color:#231a15;">
                                    <p class="csb_stitle" style="background-color:#231a15;color:#231a15;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="564b85" style="background-color:#564b85;color:#564b85;"></p>
                                    <p class="csb_highlight csbs" bk="CBBC84" t="231a15" style-name="formBuilder_color_highlight" style="background:#CBBC84;color:#231a15"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,284907,000000,,,,,5C832F,382513,,,FCFAE1,363942,363942,D1CEAD,363942">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="284907" t="000000" style="background-color:#284907;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="5c832f" t="382513" style="background-color:#5c832f;color:#382513;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="fcfae1" t="363942" style="background-color:#fcfae1;color:#363942;">
                                    <p class="csb_stitle" style="background-color:#363942;color:#363942;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="363942" style="background-color:#363942;color:#363942;"></p>
                                    <p class="csb_highlight csbs" bk="D1CEAD" t="363942" style-name="formBuilder_color_highlight" style="background:#D1CEAD;color:#363942"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,4C1B1B,000000,,,,,B9121B,FCFAE1,,,FCFAE1,4C1B1B,BD8D46,D1CEAD,4C1B1B">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="4c1b1b" t="000000" style="background-color:#4c1b1b;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="b9121b" t="fcfae1" style="background-color:#b9121b;color:#fcfae1;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="fcfae1" t="4c1b1b" style="background-color:#fcfae1;color:#4c1b1b;">
                                    <p class="csb_stitle" style="background-color:#4c1b1b;color:#4c1b1b;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="bd8d46" style="background-color:#bd8d46;color:#bd8d46;"></p>
                                    <p class="csb_highlight csbs" bk="D1CEAD" t="4c1b1b" style-name="formBuilder_color_highlight" style="background:#D1CEAD;color:#4c1b1b"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,40627C,000000,,,,,D0A825,333333,,,FFFAE4,26393D,7C7C7C,D6CEB1,26393D">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="40627c" t="000000" style="background-color:#40627c;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="d0a825" t="333333" style="background-color:#d0a825;color:#333333;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="fffae4" t="26393d" style="background-color:#fffae4;color:#26393d;">
                                    <p class="csb_stitle" style="background-color:#26393d;color:#26393d;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="7C7C7C" style="background-color:#7C7C7C;color:#7C7C7C;"></p>
                                    <p class="csb_highlight csbs" bk="D6CEB1" t="26393d" style-name="formBuilder_color_highlight" style="background:#D6CEB1;color:#26393d"></p>
                                </div>
                            </div>
                        </div>
                        <div class="formBuilder_color_items" schemeinfo="640PX,16PX,25PX,010712,000000,,,,,961227,010712,,,1C1F26,918285,43454B,3A3E47,918285">
                            <div class="color_show_block csbs" style-name="formBuilder_color_wallpaper" bk="010712" t="000000" style="background-color:#010712;color:#000000">
                                <div class="csb_title csbs" style-name="formBuilder_color_title" bk="961227" t="010712" style="background-color:#961227;color:#010712;">
                                    表单
                                </div>
                                <div class="csb_contect csbs" style-name="formBuilder_color_form" bk="1c1f26" t="918285" style="background-color:#1c1f26;color:#918285;">
                                    <p class="csb_stitle" style="background-color:#918285;color:#918285;"></p>
                                    <p class="csb_des csbs" style-name="formBuilder_color_instruction" t="43454b" style="background-color:#43454b;color:#43454b;"></p>
                                    <p class="csb_highlight csbs" bk="3A3E47" t="918285" style-name="formBuilder_color_highlight" style="background:#3A3E47;color:#918285"></p>
                                </div>
                            </div>
                        </div>
                        <div class="clearB"></div>
                    </div>
                    <div class="style_design" style="height: 62%;">
                        <div class="style_design_pad" data-click="0">
                            <span class="sdp_arrow"><img src="/images/icon/pulldownBlue.png"></span>
                            <span class="sdp_name">样式设置</span>
                            <span class="sdp_color sdp_color_wb">&nbsp;</span>
                            <span class="sdp_color sdp_color_lb">&nbsp;</span>
                            <span class="sdp_color sdp_color_ft">&nbsp;</span>
                            <span class="sdp_color sdp_color_fb">&nbsp;</span>
                            <span class="sdp_color sdp_color_lt">&nbsp;</span>
                            <span class="sdp_color sdp_color_it">&nbsp;</span>
                            <div class="clearB"></div>
                        </div>
                        <div class="style_design_item" tabindex="5005" style="overflow: auto;overflow-x: hidden; outline: none; display: block;">
                            <div class="sdi_color">
                                <div class="sdi_block sdi_backgroundcolor" gt="wb">
                                    <div class="in_title">
                                        背景颜色
                                    </div>
                                    <div class="in_color" style="background-color:#f4f5f0"></div>
                                </div>
                                <div class="sdi_block sdi_titlebackgroundcolor" gt="lb">
                                    <div class="in_title">
                                        表头底色
                                    </div>
                                    <div class="in_color" style="background-color:#ffffff"></div>
                                </div>
                                <div class="sdi_block sdi_font sdi_mainfontcolor" gt="ft">
                                    <div class="in_title">
                                        题目文字
                                    </div>
                                    <div class="in_color" style="color:#000000;">
                                        Aa
                                    </div>
                                </div>
                                <div class="sdi_block sdi_mainbackgroundcolor" gt="fb">
                                    <div class="in_title">
                                        内容底色
                                    </div>
                                    <div class="in_color" style="background-color:#ffffff"></div>
                                </div>
                                <div class="sdi_block sdi_font sdi_titlefontcolor" gt="lt">
                                    <div class="in_title">
                                        表头文字
                                    </div>
                                    <div class="in_color" style="color:#000000;">
                                        Aa
                                    </div>
                                </div>
                                <div class="sdi_block sdi_font sdi_desfontcolor" gt="it">
                                    <div class="in_title">
                                        描述文字
                                    </div>
                                    <div class="in_color" style="color:#7c7c7c;">
                                        Aa
                                    </div>
                                </div>
                                <div class="clearB"></div>
                            </div>
                            <div class="sdi_image">
                                <div class="sdi_item sdi_backgroundImg">
                                    <div class="sdi_input_checkbox input_checkbox">
                                        <input type="checkbox" id="form_background" class="fll">
                                        <label for="form_background">页面背景图片</label>
                                    </div>
                                    <div class="operation" style="display: none;">
                                        <div class="uploadfield upload_background_image">
                                            <div class="background_setfield form_background_upload">
                                                <div class="upload_file">
                                                    <?php echo $module['backgroundimage'];?>
                                                    <p>请选择2M内的jpg、png图片</p>
                                                    <img src="/images/icon/importFileAdd.png">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="stylecontroller upload_background_image_style">
                                            <span class="sdi_stateBtn fll"> <a class="stateBtn" chose-info="left">居左</a><a class="stateBtn active" chose-info="center">居中</a><a class="stateBtn stateBtn_last" chose-info="right">居右</a> </span>
                                            <div class="sdi_input_checkbox input_checkbox rll checked">
                                                <input type="checkbox" class="fll" id="background_repeat" checked="checked">
                                                <label for="background_repeat">重复</label>
                                            </div>
                                            <div class="sdi_input_checkbox input_checkbox rll">
                                                <input type="checkbox" class="fll" id="background_fix">
                                                <label for="background_fix">固定</label>
                                            </div>
                                            <div class="clearB"></div>
                                        </div>
                                        <div class="clearB"></div>
                                    </div>
                                </div>
                                <div class="sdi_item sdi_TitlebackgroundImg">
                                    <div class="sdi_input_checkbox input_checkbox">
                                        <input type="checkbox" id="form_title_background" class="fll">
                                        <label for="form_title_background">表头背景图片</label>
                                    </div>
                                    <div class="operation" style="display: none;">
                                        <div class="uploadfield">
                                            <div class="background_setfield form_titlebackground_upload">
                                                <div class="upload_file">
                                                    <?php echo $module['titlebackgroundimage'];?>
                                                    <p>请选择2M内的jpg、png图片</p>
                                                    <img src="/images/icon/importFileAdd.png">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearB"></div>
                                    </div>
                                </div>
                                <div class="sdi_item sdi_logobackgroundImg">
                                    <div class="sdi_input_checkbox input_checkbox">
                                        <input type="checkbox" id="form_changelogo" class="fll">
                                        <label for="form_changelogo">表头LOGO</label>
                                    </div>
                                    <div class="operation" style="display: none;">
                                        <div class="uploadfield">
                                            <div class="background_setfield form_logo_upload">
                                                <div class="upload_file">
                                                    <?php echo $module['titlebackgroundlogo'];?>
                                                    <p>请选择2M内的jpg、png图片</p>
                                                    <img src="/images/icon/importFileAdd.png">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearB"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="sdi_contentstyle" style="display:none;">
                                <div class="sdi_item sdi_formwidth">
                                    <span class="sdi_title fll">表单宽度：</span>
                                    <span class="sdi_stateBtn fll"> <a class="stateBtn" chose-info="570px">较窄</a><a class="stateBtn active" chose-info="640px">普通</a><a class="stateBtn stateBtn_last" chose-info="750px">较宽</a> </span>
                                    <div class="clearB"></div>
                                </div>
                                <div class="sdi_item sdi_formfontsize">
                                    <span class="sdi_title fll">内容字号：</span>
                                    <span class="sdi_stateBtn fll"> <a class="stateBtn" chose-info="14px">较小</a><a class="stateBtn active" chose-info="16px">中等</a><a class="stateBtn stateBtn_last" chose-info="18px">较大</a> </span>
                                    <div class="clearB"></div>
                                </div>
                                <div class="sdi_item sdi_formlineheight">
                                    <span class="sdi_title fll">行间距：</span>
                                    <span class="sdi_stateBtn fll"> <a class="stateBtn" chose-info="20px">紧凑</a><a class="stateBtn active" chose-info="25px">普通</a><a class="stateBtn stateBtn_last" chose-info="30px">宽松</a> </span>
                                    <div class="clearB"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/table_add.js"></script>
<!--////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
</div>
<div id="shadow_div" style="display: none;"></div>
<div class="shadow_title" style="display: none;"><p><img src="/images/icon/preload.gif"></p><p>正在为您执行..</p></div>
<div id="add_role_modal" class="modal light in" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog " style="top: 10%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">添加或邀请成员</h4>
            </div>
            <div class="modal-body clearfix" style="max-height: 559.6px;">
                <div class="message"></div>
                <p>您可以填写<font style="color:#0066A8">[邮箱]</font>或<font style="color:#0066A8">[手机号]</font>来添加成员，尚未注册的成员将会收到邀请函，多个请用逗号隔开。</p>
                <div class="add-roles-container">
                    <input data-value="" type="text" name="authority[emails]" onblur="get_usernames(this);" id="authority_emails" class="pull-left" placeholder="邮箱/手机号" />
                    <select name="cooperator_role" id="cooperator_role" class="role pull-right">
                        <option value="admin">表管理员</option>
                        <option selected="selected" value="edit">数据维护</option>
                        <option value="read">数据查看</option>
                    </select>
                </div>
                <div class="invite_info" id="invite_info"></div>
                <div class="selectable-cooperators">
                    <p>或者从以往联系人中选择</p>
                    <table class="gd-table gd-table-bordered gd-table-hover gd-table-head">
                        <thead>
                        <tr>
                            <th class="c-checkbox">&nbsp;</th>
                            <th class="c-nickname">联系人</th>
                            <th class="c-email">邮箱</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="table-container" id="table-container">
                        <table class="gd-table gd-table-bordered gd-table-hover">
                            <tbody id="table-container-tbody">
                            <tr class="remove_tr"><td class="c-checkbox">您还没有团队成员, <a href="/index.php?cloud=index.increase_user" target="_blank">点此添加</a></td></tr>
                            </tbody>
                        </table>
                        <!--ajax获取数据-->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="add-role-button gd-btn gd-btn-primary" data-disabled-with="提交中..." onclick="confirm_add(this);" data-enabled-with="确认添加" href="javascript:void(0);">确认添加</a>
                &nbsp;&nbsp;<a data-dismiss="modal" class="gd-btn gd-btn-info" onclick="add_member__close(this);" href="javascript:void(0)">关闭</a>
            </div>
        </div>
    </div>
</div>
<?php
    require("./include/return_data/js/table_add.php");
    require("./include/return_data/js/table_add_edit.php");
?>