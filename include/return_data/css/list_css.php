/*文章列表CSS，则PHP返回*/
#<?php echo $module['module_name'];?>{ padding:0px; display:block;vertical-align:top; overflow:hidden;font-size:16px;}
#<?php echo $module['module_name'];?>_html{ 
font-family: "Microsoft YaHei";  
background: #fff;
min-height: 300px;
border:1px solid #f2f2f2;
font-size:16px;
}
#<?php echo $module['module_name'];?>_html .module_title,#<?php echo $module['module_name'];?>_html .type .parent{
    line-height: 18px;
    padding: 20px 0 20px 45px;
    background: url(/public/images/add-icon.png) 25px center no-repeat;
    font-size: 18px;
    color: #1A83DF;
    text-align: left;
	
}
#<?php echo $module['module_name'];?>_html .list a,#<?php echo $module['module_name'];?>_html .type .article_type_deep_1 a{
    display: inline-block;
    width: 100%;
    text-align: center;
    height: 40px;
    line-height: 40px;
    padding-left: 30px;
    font-size: 16px;
    color: #333;
    text-align: left;
    cursor: pointer;
}
	

#<?php echo $module['module_name'];?>_html .list a:hover,#<?php echo $module['module_name'];?>_html .type .article_type_deep_1 a:hover{background:#333333;color:#fff; }
#<?php echo $module['module_name'];?>_html .list img:hover{ opacity:0.8;}
#<?php echo $module['module_name'];?>_html .list .current_page{ font-weight:bolder;}
#<?php echo $module['module_name'];?>_html .list img{   vertical-align:middle;height:<?php echo $module['image_height'];?>;max-width:<?php echo $module['image_height'];?>; margin:0.5rem; margin-bottom:0px;}
#<?php echo $module['module_name'];?>_html .list span{     display: block;
    line-height: 2.14rem;
    padding: 20px;
    font-size: 15px;}
#<?php echo $module['module_name'];?>_html .list .title{ 
display:block; font-size:1.1rem; height:2.14rem; line-height:2.14rem; display:block; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list div{}
#<?php echo $module['module_name'];?>_html .time .time_symbol{display:inline-block;  display:none;}
#<?php echo $module['module_name'];?>_html .list .time{ display:inline-block; float:left; padding-left:10px; }
#<?php echo $module['module_name'];?>_html .visit .visit_symbol{display:inline-block; width:2.14rem height:1.42rem;  line-height:1.42rem;}
#<?php echo $module['module_name'];?>_html .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0a6"; opacity:0.6;}
#<?php echo $module['module_name'];?>_html .list .visit{display:inline-block; float:right; padding-right:10px;}
#<?php echo $module['module_name'];?>_html .list span .m_label{ display: inline-block;}



#<?php echo $module['module_name'];?>_html .list .current_page{ font-weight:bolder;}
#<?php echo $module['module_name'];?>_html .list .text{ display:inline-block; padding:5px; vertical-align:middle; width: 85%;margin-right: 10px;}
#<?php echo $module['module_name'];?>_html .list .text span{ display:block;}
#<?php echo $module['module_name'];?>_html .list .text span .m_label{ display: inline-block;}
#<?php echo $module['module_name'];?>_html .list .text .title{ font-weight:bold;line-height:2.14rem; margin-left:5px; margin-right:0.71rem; overflow:hidden; text-overflow: ellipsis; }
#<?php echo $module['module_name'];?>_html .list .text .content{ font-size:0.86rem; line-height:1.85rem; text-indent:1.78rem; margin-left:5px; overflow:hidden; text-overflow:ellipsis;}
#<?php echo $module['module_name'];?>_html .list .text .time{display:inline-block;font-size:0.86rem; width:65%;line-height:1.42rem; margin-left:5px; float:left; }

#<?php echo $module['module_name'];?>_html .list .text .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:1.42rem;text-align:right; float:right;}
#<?php echo $module['module_name'];?>_html .list .text .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
#<?php echo $module['module_name'];?>_html .list .text .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0a6"; opacity:0.6;}

#<?php echo $module['module_name'];?>_html .list .img{ display:inline-block; vertical-align:middle;padding:5px; text-align:right;overflow:hidden;  border:0px;}
#<?php echo $module['module_name'];?>_html .list .img img{ float:right; display:none; }


/*文章显示页*/

#<?php echo $module['module_name'];?> .title{
    font-size: 20px;
    font-family: "SimHei";
    text-align: center;
    height: 50px;
    line-height: 50px;
    overflow: hidden;
    color: #111;
}
#<?php echo $module['module_name'];?> .tag{ text-align:center; line-height:3.57rem; }
#<?php echo $module['module_name'];?> .tag span{ display:inline-block; padding-right:3.57rem;}
#<?php echo $module['module_name'];?> .content{
    padding: 2rem;
    font-size: 14px;
    color: #999;
    line-height: 24px;
}
#<?php echo $module['module_name'];?> .content img{max-width:100%;}
#<?php echo $module['module_name'];?> .img img{max-width:100%;}

/*type_css 列表页*/
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html .type{}
#<?php echo $module['module_name'];?>_html .type a{  display:block;}
#<?php echo $module['module_name'];?>_html .type a .show_sub{ display:inline-block; width:2.85rem; height:2.85rem; line-height:2.85rem; background-repeat:no-repeat;}
#<?php echo $module['module_name'];?>_html .type a .show_sub:before{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da"; opacity:0.5;}
#<?php echo $module['module_name'];?>_html .type a .show_sub:hover{}
#<?php echo $module['module_name'];?>_html .type .article_type_deep_1{}
#<?php echo $module['module_name'];?>_html .type a .hide_sub{ display:inline-block; width:2.85rem; height:2.85rem; line-height:2.85rem;}
#<?php echo $module['module_name'];?>_html .type a .hide_sub:before{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0d7";opacity:0.5;}
#<?php echo $module['module_name'];?>_html .type a .hide_sub:hover{ }
#<?php echo $module['module_name'];?>_html .type .current_type{ }
#<?php echo $module['module_name'];?>_html .type .current_type:after{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da"; }
#<?php echo $module['module_name'];?>_html .type .article_type_deep_2{display:block;}
#<?php echo $module['module_name'];?>_html .type .article_type_deep_3{display:block;}

#<?php echo $module['module_name'];?>_html .type .article_type_deep_2 a{ padding-left:65px;
    background: #333;
    color: #fff;
}
#<?php echo $module['module_name'];?>_html .type .article_type_deep_2 a:hover{
	background:#fff;
	color:#333;
}
#<?php echo $module['module_name'];?>_html .type .article_type_deep_2 a:hover{}
#<?php echo $module['module_name'];?>_html .type .article_type_deep_3 a{ padding-left:105px;}
#<?php echo $module['module_name'];?>_html .type .article_type_deep_3 a:hover{}
