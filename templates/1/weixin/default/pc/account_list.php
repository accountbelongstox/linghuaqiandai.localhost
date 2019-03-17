<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
<?php require("./include/return_data/css/weixin_account_list.php");?>
<div id="<?php echo $module['module_name'];?>_html" class="<?php echo $module['module_name'];?>_html" cloud-table="1" class="<?php echo $module['module_name'];?>_html">
<iframe frameborder="0" width="100%" height="100%" marginheight="0" marginwidth="0" scrolling="yes" src="<?php echo $module['url']?>"></iframe>
    <div id="select_div" style="display: none;">
        <div class="c_option active">总体</div>
        <div class="c_option">消息</div>
        <div class="c_option">图文</div>
        <div class="c_option">菜单</div>
        <div class="c_option">应用</div>
        <a href="javascript:;" data-href="index.php?cloud=<?php echo $module['class_name'];?>.account_add" onclick="return add_weixin_count(this);" class="add">添加微信号</a>
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['name']?>/<?php echo self::$language['weixin_account']?>/<?php echo self::$language['weixin_id']?>" value="<?php echo @$_GET['search']?>"  style="height: 24px; line-height: 24px;" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>

    </div>
    <div class=table_scroll>

        
        <div class="weixin_table_left">
            <div class="box-head">
                <h3>消息列表</h3>
                <div class="action">
                    <a class="view-past"></a>
                </div>
            </div>
            <div class="box-body">
                <div class="talker-on fn-clear">
                    已接入（<span class="current-talker-count">*</span>）
                    <a class="fn-right clear">清空</a>
                </div>
                <ul data-max-id="1164" style="height: 555px;">
                    <dl class="fn-clear current" data-openid="oFnRsvyq9rUFNfsEVkn0CBXoZ4J0" data-max-id="1164" data-subscribe="1">
                        <i></i>
                        <dd><img src="http://wx.qlogo.cn/mmopen/mOW261WJzibuzLERpbhKx4ZeZtUbK1qafF8oJTleljsgApWwLBbvpU1OxAdjoICs77OfbAfbAPqanImeIczl2Ok756pUl2ib24/0" width="35" height="35"></dd>
                        <dt><span class="nick">李      英   【军领国际】</span></dt>
                        </dl>
                    <dl class="fn-clear" data-openid="oFnRsv-mU_Fbeyc7E8OmZCdP9A1Q" data-max-id="1014" data-subscribe="1">
                        <i></i>	<dt><span class="nick">秋宏</span></dt>
                        <dd><img src="http://wx.qlogo.cn/mmopen/Bu6CcCUibLtyIxgslwbPFhP8IJSPm0eXCtq4tN3FZ2WnXOvGsf5wyiax1LXFHZzWs5B17yibCcSI0HI9hCIALgDmes4OPOicFbwh/0" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl><dl class="fn-clear" data-openid="oFnRsv-9DSwO4-XDAs8ZsvVvFkzo" data-max-id="993" data-subscribe="0">
                        <i></i>	<dt><span class="nick">未知用户</span></dt>
                        <dd><img src="http://wx-static.drip.im/img/member/single/dashboard/weixin-avatar.png" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl><dl class="fn-clear" data-openid="oFnRsv4a6nCXTQ4DhLI53ha79CmU" data-max-id="984" data-subscribe="0">
                        <i></i>	<dt><span class="nick">未知用户</span></dt>
                        <dd><img src="http://wx-static.drip.im/img/member/single/dashboard/weixin-avatar.png" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl><dl class="fn-clear" data-openid="oFnRsv8-1hRklQJ4vLDiyPQcm-N4" data-max-id="946" data-subscribe="1">
                        <i></i>	<dt><span class="nick">别在风雨来临时才想起我</span></dt>
                        <dd><img src="http://wx.qlogo.cn/mmopen/ajNVdqHZLLACNEUHzvWwNwFNRtYWhgZaWboYpgpicUrNWuHpbsk5eCX7KLsuibOm8lnRgAMTZtic5oJAb9s0zPtwQ/0" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl><dl class="fn-clear" data-openid="oFnRsv5lGNOd6jDtynopXX9RrODo" data-max-id="915" data-subscribe="0">
                        <i></i>	<dt><span class="nick">未知用户</span></dt>
                        <dd><img src="http://wx-static.drip.im/img/member/single/dashboard/weixin-av0atar.png" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl><dl class="fn-clear" data-openid="oFnRsv_Gl4w8VWpER84RiVsdAP6A" data-max-id="683" data-subscribe="0">
                        <i></i>	<dt><span class="nick">未知用户</span></dt>
                        <dd><img src="http://wx-static.drip.im/img/member/single/dashboard/weixin-avatar.png" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl><dl class="fn-clear" data-openid="oFnRsv3hO5VkLv1jTxRsWViIy-iw" data-max-id="633" data-subscribe="0">
                        <i></i>	<dt><span class="nick">未知用户</span></dt>
                        <dd><img src="http://wx-static.drip.im/img/member/single/dashboard/weixin-avatar.png" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl><dl class="fn-clear" data-openid="oFnRsv8lQa1BYR-iZxsj9ti3VjDI" data-max-id="613" data-subscribe="0">
                        <i></i>	<dt><span class="nick">未知用户</span></dt>
                        <dd><img src="http://wx-static.drip.im/img/member/single/dashboard/weixin-avatar.png" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl>
                    <dl class="fn-clear" data-openid="oFnRsv7_gJA-4N0SmWcNb3Ye8dls" data-max-id="562" data-subscribe="0">
                        <i></i>	<dt><span class="nick">未知用户</span></dt>
                        <dd><img src="http://wx-static.drip.im/img/member/single/dashboard/weixin-avatar.png" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl>
                    <dl class="fn-clear" data-openid="oFnRsv36MzPYFfz2Sa7ScKTS9oKw" data-max-id="560" data-subscribe="1">
                        <i></i>	<dt><span class="nick">万家便利店</span></dt>
                        <dd><img src="http://wx.qlogo.cn/mmopen/Rsa2E841ONpLHdjMZAIh2j44meCFKNhfnynQ2FIjmzYLPiaf3K25c49sRoPfv6KsBENgWSk5ribER53rzmzWbTkw/0" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl><dl class="fn-clear" data-openid="oFnRsv6GwZ8osxSI6l3PLizF-Mt8" data-max-id="506" data-subscribe="0">
                        <i></i>	<dt><span class="nick">未知用户</span></dt>
                        <dd><img src="http://wx-static.drip.im/img/member/single/dashboard/weixin-avatar.png" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl>
                    <dl class="fn-clear" data-openid="oFnRsv9Rz-M1iwegKIrvZTLOLJc8" data-max-id="466" data-subscribe="0">
                        <i></i>	<dt><span class="nick">未知用户</span></dt>
                        <dd><img src="http://wx-static.drip.im/img/member/single/dashboard/weixin-avatar.png" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl>
                    <dl class="fn-clear" data-openid="oFnRsv5XhYtSSEJ6nBRnKcnCtvFE" data-max-id="266" data-subscribe="0">
                        <i></i>	<dt><span class="nick">未知用户</span></dt>
                        <dd><img src="http://wx-static.drip.im/img/member/single/dashboard/weixin-avatar.png" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl>
                    <dl class="fn-clear" data-openid="oFnRsv-vSOSJukmDI4aG65HHSzeM" data-max-id="76" data-subscribe="1">
                        <i></i>	<dt><span class="nick">天下</span></dt>
                        <dd><img src="http://wx.qlogo.cn/mmopen/PiajxSqBRaEKuA7siabaDo3kkAicibtB0DlYKaQcc4dT1eMOBMvTZsyf07IEczBicewFic7eQXbBNfTZ8HpW8ibJJxY5w/0" width="35" height="35"></dd>
                        <em class="unread hidden">
                        </em>
                    </dl>
                </ul>
                <div class="talker-off fn-clear">
                    <span class="text">待接入</span><span class="unread-await">（<span class="await-count">0</span>）</span>
                    <em class="new-msg-tips-dot hidden"></em>
                    <a class="fn-right clear">清空</a>
                    <div class="load-tips">
				<span class="indicator">
					<em>15</em>
					待接入消息
				</span>
                        <span class="desc">
				消息列表中的对话已满，关闭列表对话才会自动接入待接入消息。
				</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="weixin_table_right">a </div>
        <table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%;margin-top: 72px;" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['qr_code']?></td>
                <td ><?php echo self::$language['info']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td  style=" width:570px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table>
    </div>
    <?php echo $module['page']?>
    </div>
    <div id="weixin_account_add_html" style="z-index: 9999;" style="display: none;"> 
    <h2>添加微信公众号</h2><a class="close" onclick="close__(this,1);">x 关闭</a>
    <div class="line_div"><span class="m_label">*微信名称</span><span class="input"><input data-required="required" type="text" name="name" id="name"></span></div>
    <div class="line_div"><span class="m_label">*微信号</span><span class="input"><input data-required="required" type="text" data-reg="^[a-zA-Z0-9_]{3,}$" name="account" id="account"></span></div>
    <div class="line_div"><span class="m_label">*微信号原始ID</span><span class="input"><input data-required="required" data-reg="^gh_[a-zA-Z0-9_]{11,20}$" type="text" name="wid" id="wid"></span></div>
    <div class="line_div"><span class="m_label">*token</span><span class="input"><input data-required="required" data-reg="[a-zA-Z0-9_]{3,15}" type="text" name="token" id="token"></span></div>
    <div class="line_div"><span class="m_label">AppId</span><span class="input"><input data-required="required" data-reg="[a-z0-9]{18}" type="text" name="AppId" id="AppId"></span></div>
    <div class="line_div"><span class="m_label">AppSecret</span><span class="input"><input data-required="required" data-reg="[a-z0-9]{32}" type="text" name="AppSecret" id="AppSecret"></span></div>
        <div class="line_div"><span class="m_label">备注</span><span class="input"><input type="text" name="keyword" id="keyword" value=" "></span></div>
    <div class="line_div"><a class="add_submit_a" onclick="return check_add_weixin(this);">添加微信</a></div>
    </div>
</div>
<div id="shadow_img" style="display: none;"></div>
<?php require("./include/return_data/js/weixin_account_list.php");?>
<script src="/js/weixin_admin.js" type="text/javascript"></script>