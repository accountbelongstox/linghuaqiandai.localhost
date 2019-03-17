<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		var state=get_param('state');
		if(state!=''){$("#state").prop('value',state);}
    });
    
    
    
    function cloud_table_filter(id){
            if($("#"+id).prop("value")!=-1){
                key=id.replace("_filter","");
                url=window.location.href;
                url=replace_get(url,key,$("#"+id).prop("value"));
                if(key!="search"){url=replace_get(url,"search","");}else{url=replace_get(url,"current_page","1");url=replace_get(url,"state","");}
                //cloud_alert(url);
                window.location.href=url;	
            }
    }
    
    
    
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//cloud_alert(data);
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
        return false; 
    }
    
    
    
    
    
    function del_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
        idss=ids;
        ids=ids.split("|");	
        for(id in ids){
            if(ids[id]!=''){$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
        }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                if(v.state=='success'){
                //cloud_alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                   //cloud_alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                        $("#tr_"+ids[id]).css('display','none');
                    }else{
                        $("#state_"+ids[id]).html("<?php echo self::$language['fail'];?>");	
                    }	
                }
                }
            });
        }	
        return false; 	
    }    
    </script>
	<style>    
	#<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_table .title{width:280px; display:inline-block; overflow:hidden;}
    #<?php echo $module['module_name'];?> #index_admin_site_msg_table a:hover{ text-decoration:underline; }
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?>_table .sender{width:250px; display:inline-block; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .addressee{width:150px; display:inline-block; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .state{width:80px;}
    /*±íµ¥Éè¼ÆCSSÔØÈë*/
    <?php require("./include/return_data/css/form_data_admin.php");?>
</style>
<?php
    require("./include/return_data/css/admin_site_msg.php");
?>


<div id="<?php echo $module['module_name'];?>_html" class="<?php echo $module['module_name'];?>_html" cloud-table="1">
    
    <div class="portlet-title" style="height:260px;margin-bottom: 20px;">
    <div class="" style="width: 100%;float: :left;height: 36px;">
        <div class="caption">短信管理中心</div>
 </div>

    <div class="u_main_right>" style="font-size:14px; color:#666">
           <div class="m-floor1 clearfix i-scope">
        <!--左半部分-->
        <div class="fl m-f1-l">
            <!--信息-->
            <div class="m-f1-l-d">
                <div class="d-m">
                    <div class="d-m-con clearfix">
                        <div class="fl" style="font-size:14px;">
                            <span class="i-binding">登录用户：个人信息不完善</span>
                            <span></span>
                        </div>
                        <div class="fl" style="margin-left:15px;">
                            <span>用户类型：</span>
                            <span class="i-binding"><i class="iconfont"><a href="/center/certify"><font color="#999"></font></a></i><a href="#"><span>点击认证</span></a></span>
                        </div>
                    </div>    
                    <div class="d-m-spend clearfix">
                        <div class="fl">
                            <div class="s-frame">
                                <div>
                                    <p class="s-b"><span class="i-binding"><a href="/center/mydata" class="js-statisc" dataindex="0"><?php echo $module['msg_money'];?></a></span> 条</p>
                                    <p class="s-font">剩余短信条数<a href="javascript:;" onclick="buy_sms();" style="color: red;"> >购买</a></p>
                                </div>
                            </div>
                            <div class="clearfix" style="margin-top: 18px;">
                                <p class="s-font">
                                    昨日累计消费金额&nbsp;&nbsp;<span style="font-size:18px;" class="js-statisc i-binding" dataindex="2">-</span>&nbsp;&nbsp;元
                                </p>
                            </div>
                        </div>
                        <div class="fl">
                            <div class="s-frame">
                                <div>
                                    <p class="s-b"><span class="js-statisc i-binding" dataindex="1">-</span> 次</p>
                                    <p class="s-font">昨日总发送</p>
                                </div>
                            </div>
                            <div class="clearfix" style=" margin-top:18px;">
                                <p class="s-font">
                                    昨日累计消费笔数&nbsp;&nbsp;<span style="font-size:18px;" class="js-statisc i-binding" dataindex="3">-</span>&nbsp;&nbsp;笔
                                </p>
                            </div>
                        </div>
                        <div class="fl">
                            <div class="s-frame">
                                <div>
                                    <p class="s-b">
                                    <span i-show="consumeYestMxb.mxb!=null" class="i-binding">100%</span>
                                    </p><p class="s-font" style="margin-top:2px;">昨日成功率</p>
                                </div>
                            </div>
                        </div>
                        <div class="fl m-f1-r">
                            <div class="r-b">
                                <p class="yuan i-binding"><font color="#666666">余额&nbsp;</font><span class="coins" style="font-size:28px; font-weight:normal; font-family:Tahoma, Geneva, sans-serif" id="balanceSpan"><?php echo $module['money'];?></span>&nbsp;元&nbsp;</p>
                                <!-- <a class="l-pay">
                                    <span>充 值</span>
                                </a> -->
                                <p class="total-m">昨日累计充值金额（元）<span class="js-statisc i-binding" dataindex="4">0</span></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
  </div>



    </div>

    <div class=table_scroll>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="api_tb">
      <tbody><tr>
        <td style="font-family:'Microsoft Yahei'">
        <div class="table_msg_len">
        <span>模板内容：【</span><input type="text" max="67" class="userinfo-input" style="height: 20px;line-height: 20px;margin-top: 5px;width:120px; text-indent:1em; font-family:'幼圆'" placeholder="好好数据" name="Signature" id="Signature" datatype="*2-20" nullmsg="签名内容不能为空" errormsg="签名内容范围在6~67字符之间" value=""><span>】</span></div>
        <div class="table_msg_len">
        <span>*发送内容&nbsp;</span><input type="text" placeholder="您的验证码为#code#" max="500" class="userinfo-input" style="margin-left: 15px;text-indent:1em; width:600px; font-family:'幼圆'" name="TContent" id="TContent" datatype="*10-500" nullmsg="模板内容不能为空" errormsg="模板内容范围在10~500字符之间" value=""></div>
        <div class="table_msg_len"><input type="submit" value="提交审核" class="btn mse_tab_button" onclick="update_msg()" id="infoBtn" >&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#F00" id="msgdemo2"></span></div></td>
      </tr>
      <tr>
        <td style="color:#333;color: #333;font-size: 12px;line-height: 22px;padding-bottom: 10px;padding-top: 10px;" >
        *新增的自定义模板，需要审核通过后方能通过API发送短信，正常情况下审核时间为5-30分钟，每条短信不能超过67个字符。<a href="#" target="_blank">详细教程&gt;&gt;</a>
         <br>
         <span style="color:red;"> *为了提高发送到达率和对同一号码的发送频率,<br>第一，信签名一定要固定，不要带变量。<br>第二，内容中禁止出现【】。<br>第三，不要发送营销类的内容，如果需要发送营销类内容请走营销通道</span>
        </td>
         
      </tr>
    </tbody>
    </table>

    <table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
    <?php echo $module["thead"]?>

        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table>
    </div>
    <?php echo $module['page']?>
    </div>
</div>
<script type="text/javascript">
        function update_msg(){
            var msgtitle=$("#Signature").val();
            if(msgtitle.length < 2 || msgtitle.length > 66){
                alert("签名太短,请填写3-67字符之间");
                return false;
            }
            var msgcontent=$("#TContent").val();
            if(msgcontent.length < 10 || msgcontent.length > 500){
                alert("短信内容太短,内容在10-500字之间");
                return false;
            }
            var obj={
                msgtitle:msgtitle,
                msgcontent:msgcontent
            }

            $("#msgdemo2").html("正在为您提交审核..");
            $.get('<?php echo $module['action_url'];?>&act=update_msg',obj, function(data){
                $("#msgdemo2").html("");
                if(data="ok"){
                    alert("提交成功")
                    window.location.reload();
                }else{
                    alert("提交失败,请重新提交.")

                }

            });
        }


    $(".edit_select").change(function(){

            if($(this).val()=="操作" || $(this).val()==""){
                return false;
            }

            $(".edit_select_op").show();
            $(".edit_select_op").css({
                top:$(this).offset().top+($(this).height()/2)-($(".edit_select_op").height()/2),
                left:$(this).offset().left+$(this).width()+5
            });
            var id=$(this).attr("data-id");
            if($(this).val()=="不通过"){

                 $(".edit_select_op input").attr({
                    "placeholder":"请填写拒绝原因"
                 });
                $("#causeedit").attr({
                    "data-type":"no",
                    "data-id":id
                })
                return false;
            }
            //return false;
            //通过
             $(".edit_select_op input").attr({
                    "placeholder":"请填写短信模板ID,id从短信发送平台获取"
             });
            $("#causeedit").attr({
                "data-type":"yes",
                "data-id":id
            })
            
        return false; 
    })

    function causeedit(e){
            var type=$(e).attr("data-type");
            var id=$(e).attr("data-id");
            var value=$("#cause").val()
            if(type == '' || id == '' || value == ''){
               // $(this).parent().hide();
                alert("没有数据提交")
                return false
            }

            var obj={
                id:id,
                type:type,
                value:value
            }

            $.get('<?php echo $module['action_url'];?>&act=edit',obj, function(data){
                if(data="ok"){
                    alert("提交成功")
                    window.location.reload();
                }else{
                    alert("提交失败,请重新提交.")

                }

                $(".edit_select_op").hide();
                $("#causeedit").attr({
                    "data-type":"",
                    "data-id":""
                })

            });


    }
    function buy_sms(){
        $(".buy_sms").show();
        $(".buy_sms_ul li").eq(0).trigger("click");

    }
</script>
<div class="edit_select_op"><input type="text" placeholder="" name="cause" id="cause"/><a style="margin-right: 5px" data-id="" data-type="" id="causeedit" onclick="causeedit(this)">确认</a> <a onclick="$(this).parent().hide();">关闭</a></div>
<div class="buy_sms" style="display: none;">
    <ul class="buy_sms_ul clearfix">
    <li class="buy_sms_li"><a href="javascript:;" data-number="500" data-money="<?php echo $module['sms500'];?>" title="500条<?php echo $module['sms500'];?>">500条=<?php echo $module['sms500'];?>元</a></li>
    <li class="buy_sms_li"><a href="javascript:;" data-number="1000" data-money="<?php echo $module['sms1000'];?>" title="1000条<?php echo $module['sms500'];?>">1000条=<?php echo $module['sms1000'];?>元</a></li>
    <li class="buy_sms_li"><a href="javascript:;" data-number="5000" data-money="<?php echo $module['sms5000'];?>" title="5000条<?php echo $module['sms500'];?>">5000条=<?php echo $module['sms5000'];?>元</a></li>
    <li class="buy_sms_li"><a href="javascript:;" data-number="10000" data-money="<?php echo $module['sms10000'];?>" title="1000条<?php echo $module['sms500'];?>">10000条=<?php echo $module['sms10000'];?>元</a></li>
  </ul>

  <div class="portlet-title" style="text-align: center; padding: 0; width: 267px;margin:20px auto 0; background: 0;">
      <div class="click" style="margin-right: 50px;" id="buy_sms_confim" data-number="" onclick="buy_sms_confim(this);">立即购买</div>
      <div class="click" onclick="$(this).parent().parent().hide();">关闭</div>
  </div>
</div>
<script type="text/javascript">
    $(".buy_sms_ul li").click(function(){
        $(".buy_sms_ul li").removeClass("active");
        $(this).addClass("active");
        var buy_sms_confim=$(this).find("a").eq(0).attr("data-number");
        var money=$(this).find("a").eq(0).attr("data-money");
        $("#buy_sms_confim").attr({
            "data-number":buy_sms_confim,
            "data-money":money
        })
    })
    function buy_sms_confim(e){
        var buy_sms_confim=$(e).attr("data-number");
        if(buy_sms_confim == ''){
            alert("请选选择套餐")
            $(".buy_sms_ul li").eq(0).trigger("click");
            return;
        }
        if(parseInt($("#balanceSpan").html()) < $(e).attr("data-money")){
            alert("余额不足,请先充值");
            window.location.href="/index.php?cloud=index.recharge&n="+$(e).attr("data-money");
            return;
        }


        $.get('<?php echo $module['action_url'];?>&act=buy_sms',{number:buy_sms_confim}, function(data){
            console.log(data);
            if(data == 'ok'){
                alert("购买成功");
                window.location.reload();
            }else{
                alert("购买失败,请刷新后再试!")
            }
        })


    }
</script>
