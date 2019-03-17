<style>
    <?php require("./include/return_data/css/form_data_admin.php");?>
</style> 


<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
<div id="<?php echo $module['module_name'];?>_html" class="<?php echo $module['module_name'];?>_html" cloud-table="1" class="<?php echo $module['module_name'];?>_html">

<div class="formBuilder_step3" style="display: block;">
        <div class="form_interim">
            <div class="btnBox">
                <a class="btn btn-minor btn_step3_return" href="/index.php?cloud=form.table_add&edit=<?php echo $module['id'];?>">编辑表单</a>
                <a class="btn btn-minor btn_step3_preview" href="<?php echo $module['query-url'];?>" target="_blank">预览表单</a>
                <a class="btn btn-minor btn_step3_viewFormList" href="/index.php?cloud=form.table_admin">返回列表</a>
            </div>
        </div>
        <div class="formBuilder_step3_content" tabindex="5000">
            <div class="formRelease_item">
                <p class="formBuilder_step3_title">发布表单</p>

                <div class="shareForm_icon"><p>分享到：</p><div class="jiathis_style_24x24">
                <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>

                </div>
                </div>
                <div class="clearB"></div>

                <p class="formBuilder_step3_tip">你可以将下面的地址分享给好友，或者通过邮件的方式发送出去。</p>
                <p id="FormQRCode" style="float: right; margin-top: -90px; margin-right: -5px;"><img onerror="ReLoadImg(this,'submit',<?php echo $module['id'];?>);" src="<?php echo $module['submit-code'];?>" style="width: 115px; height: 115px;"></p>
                <input class="input formBuilder_step3_input form_url" readonly="true" value="<?php echo $module['submit-url'];?>">
                <a id="copyFormURL" class="btn btn-primary btn_step3_copyURL">复制表单地址</a>
                <a class="btn btn-primary btn_step3_view" href="<?php echo $module['submit-url'];?>" target="_blank">新窗口预览</a>
                </div>



            <div class="formRelease_item">
                <p class="formBuilder_step3_title">用户查询URL</p>
                <p class="formBuilder_step3_tip">将根据你设置的条件允许用户查询。</p>
                <p id="FormQuery" style="float: right; margin-top: -66px; margin-right: -5px;"><img onerror="ReLoadImg(this,'query',<?php echo $module['id'];?>);" src="<?php echo $module['query-code'];?>" style="width: 115px; height: 115px;"></p>
                <input class="input formBuilder_step3_input query_url" readonly="true" value="<?php echo $module['query-url'];?>">
                <a id="copyFormQqueryURL" class="btn btn-primary btn_step3_copyQqueryURL">复制查询URL</a>
                </div>



            <div class="formRelease_item">
                <p class="formBuilder_step3_title">嵌入式表单</p>
                
                <p class="formBuilder_step3_tip">将下面的代码加入到网页HTML代码中，让用户在浏览你的网站时填写表单。</p>
                <textarea readonly="true" spellcheck="false" class="textarea formBuilder_step3_textarea form_iframe"><iframe height="600" allowTransparency="true" style="width:100%;border:none;overflow:auto;" frameborder="0" src="<?php echo $module['submit-url'];?>"></iframe>
</textarea>
                <div class="formViewExample_embed"></div>
                <a id="copyFormIframe" class="btn btn-primary btn_step3_copyCode">复制代码</a>
                </div>
            <div class="formRelease_item">
                <p class="formBuilder_step3_title">悬浮式按钮</p>
                <p class="formBuilder_step3_tip">将下面的代码加入到网页HTML代码中，让用户在点击按钮时查看表单。</p>
                <textarea readonly="true" spellcheck="false" class="textarea formBuilder_step3_textarea form_btnForm"><a href="<?php echo $module['submit-url'];?>" style="position:fixed;z-index:999;right:-5px;bottom: 20px;display: inline-block;width: 20px;border-radius: 5px;color:white;font-size:14px;line-height:17px;background: #2476CE;box-shadow: 0 0 5px #666;word-wrap: break-word;padding: 10px 6px;border: 2px solid white;">查看表单</a></textarea>
                <div class="formViewExample_fixed"></div>
                <a id="btnFormIframe" class="btn btn-primary btn_step3_copyCode">复制代码</a>
                </div>
            <div class="formRelease_item formRelease_item_print" style="display: none">
                 <p class="formBuilder_step3_title">打印表单
                     <a class=" wiki_faq_help" style="top: 7px;left: 5px;" target="_blank" href="#"></a>
                 </p>
                 <span class="formBuilder_step3_tip">将表单打印成纸质文件进行填写。</span>
                 <a id="printForm" class="btn btn-primary" style="width: 68px; box-sizing: border-box; text-align: center;">打印</a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>


    </div>
    </div>
    <?php require("./include/return_data/js/field_add.php");?>