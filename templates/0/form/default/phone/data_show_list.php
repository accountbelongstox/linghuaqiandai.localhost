<script>
	$.post("<?php echo $module['action_url'];?>&act=getCodeImg",{
		url:window.location.href,
		path:window.location.search.split('?')[1].split('&').join('_')
	},function(data){
		console.log(data);
	})
</script>
<div id=<?php echo $module['module_name'];?>  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
    <style>
    html,body{ height:100%; margin:0; padding:0;} 
    #<?php echo $module['module_name'];?>{margin: 0 auto;}
    #<?php echo $module['module_name'];?> .sequence{ width:30px;}
    #<?php echo $module['module_name'];?> #search_filter{ width:50%;}
    #<?php echo $module['module_name'];?> .map{ display:inline-block; width:30px; }
    #<?php echo $module['module_name'];?> .filter_label{  padding-right:3px;    }
    [user_color='container'] [cloud-module] select{
        width: auto;
        display: inline-block;
    }
    .result_tablename{
        color: #333;
        border: 1px solid #ddd;
        width: 240px;
        margin: 0 auto;
        padding-left: 30px;
        font-size: 16px;
        line-height: 26px;
        background: #f7f7f7 url(/images/icon/pulldown.png) no-repeat 7px 10px;

    }
    .result{
        width: 270px;
        margin: 0 auto 50px;
        background: url("/images/icon/line.jpg") repeat-y 10px 0;

    }
    .result .c.a0{
        background: url("/images/icon/verify_sucess.png") no-repeat 2px 20px;

    }
    .result .c.a1{
        background: url("/images/icon/verify_sucess.png") no-repeat 2px 20px;

    }
    .result .c.a2{
        background: url("/images/icon/verify_sucess.png") no-repeat 2px 20px;

    }
    .result .c.a3{
        background: url("/images/icon/no.png") no-repeat 2px 20px;
        
    }
    .result .c.un{
        background: url("/images/icon/mailstate_refuseForever.png") no-repeat 4px 20px;
        
    }
    .result .c{
        padding: 20px 30px;
        line-height: 16px;   

    }

    .result .c .t{
        line-height: 16px;
        font-size: 16px;

    }

    .result .c .t a{
        color: #1E90FF;
    }
    .result .c .c_p{
        font-size: 12px;
        color: #B8B8B9;
        line-height: 18px;

    }

    </style>

    <div id="<?php echo $module['module_name'];?>_html"  cloud-table=1>
    <?php echo $module['search'];?>

    <div class="result"></div>
    </div>
</div>
<?php require("./include/return_data/js/data_show_list.php");?>