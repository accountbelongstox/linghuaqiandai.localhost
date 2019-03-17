	<script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
		$("#<?php echo $module['module_name'];?>_html .data_state").each(function(index, element) {
            $(this).val($(this).attr('cloud_value'));
        });
		$(".load_js_span").each(function(index, element) {
            $(this).load($(this).attr('src'));
        });
				
    });    
    function del(id){
        if(confirm("<?php echo self::$language['del_account_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        return false;	
        
    }
    function close__(e,n){
    	n=parseInt(n);
    	for (var i=0;i<n;i++) {
    		e=$(e).parent();
    	}
    	e.hide();
        $('#shelter').hide();
    }
    $("#select_div .c_option").click(function(){
    	$("#select_div .c_option").removeClass("active");
    	$(this).addClass("active");
    })
    
    function add_weixin_count(e){
        $('#shelter').show();
        $('#weixin_account_add_html').show();
        var obj={
        	name:'测试微信号',
        	account:'sudaiabshi2',
        	wid:'gh_5a12fc788357',
        	token:'cloud',
        	AppId:'wxd906d7884d69f037',
        	AppSecret:'0871049cf046fc17d47a9580d3e89c8d'
        }
        $("#weixin_account_add_html").find("input").each(function(a,b){
        	$(b).val(obj[$(b).attr("id")]);
        })
    }

    $('#shelter').click(function(){
        $('#weixin_account_add_html').hide();
        $('#shelter').hide();
    })
    
    function check_add_weixin(e){
    	var obj={};
    	var line_divs=$("#weixin_account_add_html .line_div");
    	for (var i=0;i<line_divs.length;i++){
    		var b=line_divs[i];
    		var input_=$(b).find("input");
    		if(input_.length > 0){
    			if(input_.attr("data-required")){/*判断是否必填*/
		    		if(input_.attr("data-required") == "required" && input_.val() == ""){
	    				show_success($(b).find(".m_label").html()+"不能为空","fail");
		    			input_.focus();
		    			return false;
		    		}
    			}
	    		if(input_.attr("data-reg")){
	    			var reg_test=new RegExp(input_.attr("data-reg"));
	    			var re=reg_test.test(input_.val())
	    			if(!re){
	    				input_.focus();
	    				show_success($(b).find(".m_label").html()+"填写不正确,请检查!","fail");
	    				return false;
	    			}
	    		}
	    		obj[input_.attr("id")]=input_.val();
    		}
    	}
    	$.post('<?php echo $module['action_url'];?>&act=account_add',obj, function(data){
    		if(data.length > 0){
    			var reg = new RegExp("'","g")
    			data=data.replace(reg,'"');
    			var j=$.parseJSON(data);
    			var id='';
    			if(j["id"]){
    				id=j["id"];
    			}
    			switch(j["state"]){
    				case "fail":
    				show_success(id+j["info"],"fail");
    				if(j["id"]){
    					$("#"+j["id"]).focus();
    				}
    				break;
    				case "success":
    				show_success(id+j["info"],"success");
    				break;
    			}
    			console.log(j);
    		}else{
    			show_success("失败,服务器没有应答!","fail");
    			return false;
    		}
    	})
    }
    get_weixin_info();
    function get_weixin_info(){
    	$.post('<?php echo $module['action_url'];?>&act=get_weixin_info', function(data){
    		if(data.length > 0){
    			var j=$.parseJSON(data);
    			$(".current-talker-count").html(j.length);
    			console.log(j);
    		}
    	})
    }
    </script>