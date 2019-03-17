	<style>
   Html,body{ height:100%; margin:0; padding:0;} 
   #<?php echo $module['module_name'];?>{margin: 0 auto;}
   #<?php echo $module['module_name'];?> .sequence{ width:30px;}
	#<?php echo $module['module_name'];?> #search_filter{ width:50%;}
	#<?php echo $module['module_name'];?> .map{ display:inline-block; width:30px; }
	#<?php echo $module['module_name'];?> .filter_label{  padding-right:3px;}
    [user_color='container'] [cloud-module] select{
        width: auto;
        display: inline-block;
    }
    .result_tablename{
        color: #333;
        border: 1px solid #ddd;
        margin: 0 auto 20px;
        padding-left: 30px;
        font-size: 16px;
        line-height: 26px;
        background: #f7f7f7 url(/images/icon/pulldown.png) no-repeat 7px 10px;

    }
    .result{
        margin: 0 auto 50px;
        width: 780px;
        background: url(/images/icon/line.jpg) repeat-x 0 55px;
        min-height: 120px;
        text-align: center;

    }
    .result .c.a0,.result .c.a1,.result .c.a2{
        background: url(/images/icon/verify_sucess.png) no-repeat top center;

    }
    .result .c.a3{
        background: url("/images/icon/no.png") no-repeat top center;
        
    }
    .result .c.un{
        background: url("/images/icon/mailstate_refuseForever.png") no-repeat top center;
            float: none;
    display: inline-block;
        
    }
    .result .c{    
    padding: 30px 30px 30px 30px;
    line-height: 16px;
    background: #fff;
    max-width: 200px;
    float: left;

    }

    .result .c .t{
    line-height: 16px;
    font-size: 16px;
    background: #fff;
    display: inline-block;
    padding: 0 5px;

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