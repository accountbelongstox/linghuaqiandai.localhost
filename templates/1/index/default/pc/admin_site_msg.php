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
    /*????????????????CSS????????*/
    <?php require("./include/return_data/css/form_data_admin.php");?>
</style>
<?php
    require("./include/return_data/css/admin_site_msg.php");
?>


<div id="<?php echo $module['module_name'];?>_html" class="<?php echo $module['module_name'];?>_html" cloud-table="1">
    
    <div class="portlet-title" style="height:260px;margin-bottom: 20px;">
    <div class="" style="width: 100%;float: :left;height: 36px;">
        <div class="caption">??????????????????</div>
 </div>

    <div class="u_main_right>" style="font-size:14px; color:#666">
           <div class="m-floor1 clearfix i-scope">
        <!--????????????-->
        <div class="fl m-f1-l">
            <!--??????-->
            <div class="m-f1-l-d">
                <div class="d-m">
                    <div class="d-m-con clearfix">
                        <div class="fl" style="font-size:14px;">
                            <span class="i-binding">????????????????????????????????????</span>
                            <span></span>
                        </div>
                        <div class="fl" style="margin-left:15px;">
                            <span>???????????????</span>
                            <span class="i-binding"><i class="iconfont"><a href="/center/certify"><font color="#999">???</font></a></i><a href="#"><span>????????????</span></a></span>
                        </div>
                    </div>    
                    <div class="d-m-spend clearfix">
                        <div class="fl">
                            <div class="s-frame">
                                <div>
                                    <p class="s-b"><span class="i-binding"><a href="/center/mydata" class="js-statisc" dataindex="0"><?php echo $module['msg_money'];?></a></span> ???</p>
                                    <p class="s-font">??????????????????<a href="javascript:;" onclick="buy_sms();" style="color: red;"> >??????</a></p>
                                </div>
                            </div>
                            <div class="clearfix" style="margin-top: 18px;">
                                <p class="s-font">
                                    ????????????????????????&nbsp;&nbsp;<span style="font-size:18px;" class="js-statisc i-binding" dataindex="2">-</span>&nbsp;&nbsp;???
                                </p>
                            </div>
                        </div>
                        <div class="fl">
                            <div class="s-frame">
                                <div>
                                    <p class="s-b"><span class="js-statisc i-binding" dataindex="1">-</span> ???</p>
                                    <p class="s-font">???????????????</p>
                                </div>
                            </div>
                            <div class="clearfix" style=" margin-top:18px;">
                                <p class="s-font">
                                    ????????????????????????&nbsp;&nbsp;<span style="font-size:18px;" class="js-statisc i-binding" dataindex="3">-</span>&nbsp;&nbsp;???
                                </p>
                            </div>
                        </div>
                        <div class="fl">
                            <div class="s-frame">
                                <div>
                                    <p class="s-b">
                                    <span i-show="consumeYestMxb.mxb!=null" class="i-binding">100%</span>
                                    </p><p class="s-font" style="margin-top:2px;">???????????????</p>
                                </div>
                            </div>
                        </div>
                        <div class="fl m-f1-r">
                            <div class="r-b">
                                <p class="yuan i-binding"><font color="#666666">??????&nbsp;</font><span class="coins" style="font-size:28px; font-weight:normal; font-family:Tahoma, Geneva, sans-serif" id="balanceSpan"><?php echo $module['money'];?></span>&nbsp;???&nbsp;</p>
                                <!-- <a class="l-pay">
                                    <span>??? ???</span>
                                </a> -->
                                <p class="total-m">?????????????????????????????????<span class="js-statisc i-binding" dataindex="4">0</span></p>
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
        <span>??????????????????</span><input type="text" max="67" class="userinfo-input" style="height: 20px;line-height: 20px;margin-top: 5px;width:120px; text-indent:1em; font-family:'??????'" placeholder="????????????" name="Signature" id="Signature" datatype="*2-20" nullmsg="????????????????????????" errormsg="?????????????????????6~67????????????" value=""><span>???</span></div>
        <div class="table_msg_len">
        <span>*????????????&nbsp;</span><input type="text" placeholder="??????????????????#code#" max="500" class="userinfo-input" style="margin-left: 15px;text-indent:1em; width:600px; font-family:'??????'" name="TContent" id="TContent" datatype="*10-500" nullmsg="????????????????????????" errormsg="?????????????????????10~500????????????" value=""></div>
        <div class="table_msg_len"><input type="submit" value="????????????" class="btn mse_tab_button" onclick="update_msg()" id="infoBtn" >&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#F00" id="msgdemo2"></span></div></td>
      </tr>
      <tr>
        <td style="color:#333;color: #333;font-size: 12px;line-height: 22px;padding-bottom: 10px;padding-top: 10px;" >
        *????????????????????????????????????????????????????????????API?????????????????????????????????????????????5-30?????????????????????????????????67????????????<a href="#" target="_blank">????????????&gt;&gt;</a>
         <br>
         <span style="color:red;"> *????????????????????????????????????????????????????????????,<br>??????????????????????????????????????????????????????<br>???????????????????????????????????????<br>?????????????????????????????????????????????????????????????????????????????????????????????</span>
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
                alert("????????????,?????????3-67????????????");
                return false;
            }
            var msgcontent=$("#TContent").val();
            if(msgcontent.length < 10 || msgcontent.length > 500){
                alert("??????????????????,?????????10-500?????????");
                return false;
            }
            var obj={
                msgtitle:msgtitle,
                msgcontent:msgcontent
            }

            $("#msgdemo2").html("????????????????????????..");
            $.get('<?php echo $module['action_url'];?>&act=update_msg',obj, function(data){
                $("#msgdemo2").html("");
                if(data="ok"){
                    alert("????????????")
                    window.location.reload();
                }else{
                    alert("????????????,???????????????.")

                }

            });
        }


    $(".edit_select").change(function(){

            if($(this).val()=="??????" || $(this).val()==""){
                return false;
            }

            $(".edit_select_op").show();
            $(".edit_select_op").css({
                top:$(this).offset().top+($(this).height()/2)-($(".edit_select_op").height()/2),
                left:$(this).offset().left+$(this).width()+5
            });
            var id=$(this).attr("data-id");
            if($(this).val()=="?????????"){

                 $(".edit_select_op input").attr({
                    "placeholder":"?????????????????????"
                 });
                $("#causeedit").attr({
                    "data-type":"no",
                    "data-id":id
                })
                return false;
            }
            //return false;
            //??????
             $(".edit_select_op input").attr({
                    "placeholder":"?????????????????????ID,id???????????????????????????"
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
                alert("??????????????????")
                return false
            }

            var obj={
                id:id,
                type:type,
                value:value
            }

            $.get('<?php echo $module['action_url'];?>&act=edit',obj, function(data){
                if(data="ok"){
                    alert("????????????")
                    window.location.reload();
                }else{
                    alert("????????????,???????????????.")

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
<div class="edit_select_op"><input type="text" placeholder="" name="cause" id="cause"/><a style="margin-right: 5px" data-id="" data-type="" id="causeedit" onclick="causeedit(this)">??????</a> <a onclick="$(this).parent().hide();">??????</a></div>
<div class="buy_sms" style="display: none;">
    <ul class="buy_sms_ul clearfix">
    <li class="buy_sms_li"><a href="javascript:;" data-number="500" data-money="<?php echo $module['sms500'];?>" title="500???<?php echo $module['sms500'];?>">500???=<?php echo $module['sms500'];?>???</a></li>
    <li class="buy_sms_li"><a href="javascript:;" data-number="1000" data-money="<?php echo $module['sms1000'];?>" title="1000???<?php echo $module['sms500'];?>">1000???=<?php echo $module['sms1000'];?>???</a></li>
    <li class="buy_sms_li"><a href="javascript:;" data-number="5000" data-money="<?php echo $module['sms5000'];?>" title="5000???<?php echo $module['sms500'];?>">5000???=<?php echo $module['sms5000'];?>???</a></li>
    <li class="buy_sms_li"><a href="javascript:;" data-number="10000" data-money="<?php echo $module['sms10000'];?>" title="1000???<?php echo $module['sms500'];?>">10000???=<?php echo $module['sms10000'];?>???</a></li>
  </ul>

  <div class="portlet-title" style="text-align: center; padding: 0; width: 267px;margin:20px auto 0; background: 0;">
      <div class="click" style="margin-right: 50px;" id="buy_sms_confim" data-number="" onclick="buy_sms_confim(this);">????????????</div>
      <div class="click" onclick="$(this).parent().parent().hide();">??????</div>
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
            alert("??????????????????")
            $(".buy_sms_ul li").eq(0).trigger("click");
            return;
        }
        if(parseInt($("#balanceSpan").html()) < $(e).attr("data-money")){
            alert("????????????,????????????");
            window.location.href="/index.php?cloud=index.recharge&n="+$(e).attr("data-money");
            return;
        }


        $.get('<?php echo $module['action_url'];?>&act=buy_sms',{number:buy_sms_confim}, function(data){
            console.log(data);
            if(data == 'ok'){
                alert("????????????");
                window.location.reload();
            }else{
                alert("????????????,??????????????????!")
            }
        })


    }
</script>
