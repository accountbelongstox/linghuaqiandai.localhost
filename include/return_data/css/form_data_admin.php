
.search{
line-height:30px;
}

/*后台表单CSS*/
#<?php echo $module['module_name'];?>{}
#<?php echo $module['module_name'];?>_html{}

.<?php echo $module['module_name'];?>,.module_admin_user {
	position: absolute;
    bottom: 0;
    left: 60px;
    right: 0;
    top: 50px;
    background: #BEC4C5 url(/images/bg/BodyBg.png) repeat;
    margin-top: 0;
}

.<?php echo $module['module_name'];?>_html,.module_admin_user_html {    
	position: absolute;
    left: 10px;
    right: 10px;
    top: 10px;
    bottom: 10px;
    border: 1px solid #BBBCBC;
    border-radius: 5px;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
    background: #FFFFFF;
    overflow-y: auto;
	
}

#shadow_div{
    height: 100%;
    display: none;
    width: 100%;
    position: fixed;
    _position: absolute;
    top: 0;
    left: 0;
    z-index: 1000;
    opacity: 0.8;
    filter: alpha(opacity=80);
    background-color: #000;
    z-index: 9998;
}

.shadow_title{
    display: none;
    position: absolute;
    width: 20%;
    left: 40%;
    top: 40%;
    background: #fff;
    padding: 10px;
    -webkit-box-shadow: 0 0 10px rgba(0, 204, 204, .5);
    -moz-box-shadow: 0 0 10px rgba(0, 204, 204, .5);
    box-shadow: 0 0 10px rgba(0, 204, 204, .5);
    z-index: 9999;
    text-align: center;
}


/*表单管理头部*/

     .edit_none{ font-size:18px;}
     .sms_inform{ height:13px;}
     .email_inform{ height:13px;}
     .inform_user{ width:150px; display:block;}
     .operation_td{width:100px;
     max-width: 100px;
    }
     .operation_td br{ display:none;}
     .operation_td a{
         display: inline-block;
         width: 100px;
         overflow: hidden;
         text-align: center;
         line-height: 30px;
         height: 30px;
         padding: 0px;
         margin: 0px;
         max-width: 100px;
         float: left;
         padding: 0;
         }
       .table_setting_admin{
       width:265px;
       max-width:265px;
       }
     .filter_label{  padding-right:3px;    }



/*表单*/
.portlet-title,.m_row,.filter,.import_div,.top_div {
    background: #E4EAEB;
    -webkit-user-select: none;
    -moz-user-select: none;
}
.portlet-title input,.m_row input,.filter input,.import_div input,.top_div input,.portlet-title select,.m_row select,.filter select,.import_div select,.top_div select{
	background-color: white;
    border: 1px solid #BFBFBF;
    height: 30px;
    line-height: 30px;
}
.portlet-title .caption {
	padding: 0px 20px;
    text-align: center;
    color: #965708;
    border: 1px solid #E99B38;
    background: #FFEAC3;
    margin-top: 4px;
    margin-right: 15px;
    line-height: 32px;
    height: 32px;
}
.portlet-title .actions a,.portlet-title .actions .btn-group{
	float:left;
}

.portlet-title .actions a.import_switch,.portlet-title .actions a.user_map {
	 color: #333333;
    font-size: 14px;
    padding:0 28px;
    display: inline-block;
    cursor: pointer;
    vertical-align: middle;
    line-height: 14px;
    margin-top: 9px;
}
.portlet-title .actions a.add,.portlet-title .actions a.btn,.filter a.add,.<?php echo $module['module_name'];?>_html a.add{
	float: left;
    white-space: nowrap;
    padding: 0;
    padding: 0px 10px;
    line-height: 30px;
    height: 30px;
    display: block;
    border: none;
    color:#fff;
    background: #28b779;
	
}
.cloud_table_bulk_action_div,.page_row{ 
	padding:5px 50px
}
.table_scroll table tbody tr:nth-of-type(odd){
	background: #f6f6f6;
    color: #000000;
}
.table_scroll{
	    margin-left: 50px;
    margin-top: 10px;
}
.table_scroll table tbody tr:hover {
	color:#000000;background: #E5F3FA;
    border-left: 3px solid #2776A4;
}
.table_scroll table tr{
	border-left: 3px solid #FFF;
	
}
.table_scroll table tr td{
	padding-left: 8px;
    padding-top: 0;
    padding-bottom: 0;
    font-size: 12px;
    height: 50px;
    line-height: 14px;
    border-bottom: 1px solid #DCE7EF;
    z-index: 80;
    border-left: 1px solid #DCE7EF;
    vertical-align: middle;
    color: #2776A4;
	
}
.portlet-title .actions a.add,.filter a.add{
	margin-right:20px;
    background: #28b779;  
	
}
.portlet-title .actions a.btn{
    background: #2976A4;  
	
}
select.group_parent{
	width:200px;
}
.table_scroll td input[type=text]{
	width: 100%;
    border: 1px solid #BFBFBF;
    height: 26px;
    line-height: 26px;
    border-radius: 3px;
	text-align:left;
	text-indent:5px;
	font-size:13px;
}
.<?php echo $module['module_name'];?>_html #name_new,.group_parent{
	 margin-bottom: 5px;
    max-width: 180px;
    float: right;    background-color: white;
    border: 1px solid #BFBFBF;    height: 26px;
    line-height: 26px;
}
#new_td_first{
	line-height:26px;
}#new_td_first div {
	line-height:20px;
	margin-top:5px;
}
#new_td_first .pro_span{
	line-height:36px;float:left;
}
#new_td_first span,#is_admin{
	float:left;
}
 #index_admin_users_table a{  font-size:1rem; padding-left:5px; padding-right:5px; border-radius:3px; }
 #index_admin_users_table a:hover{opacity:0.8; filter:alpha(opacity=80); text-decoration:none; }
 .m_label{ width:140px; display:inline-block; text-align:left; padding-right:5px; margin-bottom:20px;}
 .option{ width:820px; display:inline-block;}
 #sequence_div{ text-align:left; padding:10px;}
 #sequence{ height:30px; 
	 line-height:30px;
	 float:left;    
	 background-color: white;
    border: 1px solid #BFBFBF;
	border-radius: 4px;
}

 .show_more_option{ margin-left:20px; font-size:12px; line-height:100%;   }
 .show_more_option:after{font: normal normal normal 1rem/1 FontAwesome; content:"\f103"; padding-left:3px;}
 .show_more_option_2:after{font: normal normal normal 1rem/1 FontAwesome; content:"\f102"; padding-left:3px;}
 .more_option{ display:none;}
#<?php echo $module['module_name'];?>_table .icon img{
	width: 40px;
    height: 40px;
    border-radius: 50%;
	}
#<?php echo $module['module_name'];?>_table .operation{ width:190px; overflow:hidden; text-align:left;}
 .change_group_selected{ }
 .change_manager_selected{ }
{box-shadow:none; padding:0px; margin:0px;}
 .more_option{ line-height:2rem;}
 .import_div{ text-align:right; border-bottom:1px solid #CCC; display:none;}
 .import_div #import_file_ele{ width:20rem !important; }
 .import_div .exe_import{ display:inline-block;   border-radius:0.5rem; padding:0.3rem;}
 .import_div .field_set{ width:20%;}
 .openid:before {font: normal normal normal 1rem/1 FontAwesome;margin-left:2px;content: "\f1d7"; color:green;}
 

.dataTables_filter{
	display:none;
}
	
.filter{
	line-height:30px;
    height: auto;
    min-height: 30px;
}
.filter .search{
	float:left;
	margin-right:200px;
}
.filter select{
	background-color: #fff;
    cursor: default;
    /* display: inline-block; */
    padding: 4px 10px;
    border-radius: 2px;
    font-size: 12px;
    width: 70px;
    float: left;
    margin-right: 10px;
    border: 1px dashed #C0C0C0;
}
#search_filter{
	max-width: 100%;
    width: 698px;
    outline: 0 none;
    border: 1px solid #D9D9D9;
    border-top-color: #AAAAAA;
    border-radius: 2px;
    transition-property: all;
    transition-duration: 200ms;
    transition-delay: 0;
    transition-timing-function: ease-in-out;
    -webkit-transition-property: all;
    -webkit-transition-duration: 200ms;
    -webkit-transition-delay: 0;
    -webkit-transition-timing-function: ease-in-out;
    -moz-transition-property: all;
    -moz-transition-duration: 200ms;
    -moz-transition-delay: 0;
    -moz-transition-timing-function: ease-in-out;
    -o-transition-property: all;
    -o-transition-duration: 200ms;
    -o-transition-delay: 0;
    -o-transition-timing-function: ease-in-out;
    height: 30px;
    line-height: 30px;
    float: left;
	margin-right:5px;
}

.portlet-title .actions .btn-group{
	
}
.portlet-title .actions a.import_switch{
    border-right: 1px #333 solid;
	
}
.portlet-title {
    padding: 10px 50px 0 50px;
}
.m_row,.import_div,.top_div{
    padding: 5px 50px;
}
.filter{
    padding: 5px 50px 20px 50px;
	
}
.top_div{
	padding-bottom:10px;
	border-bottom: 1px solid #D0D0D0;
	text-align: left;
    height: 42px;
	line-height:30px;
}
.add_and_copy{
	margin-right: 20px;
    background: #28b779;
    padding: 3px 10px;
    line-height: 18px;
    height: 18px;
    overflow: hidden;
    border: none;
    margin-top: 7px;

}
hr{
	margin:0;
	padding:0;
	border:none;
	background:none;
	display:none;
}
    .div_css1{

    float: left;
    line-height: 28px;
    height: 40px;
    }
select.copy_table_select{
	    height: 24px;
    line-height: 24px;
    border: none;
    background-color: #333745;
    color: #fff;
    border-radius: 0.3rem;
    display: block;
    width: 60%;
    padding: 0;
}
input.copy_table_name{
	  width: 60%;
    line-height: 20px;
    height: 20px;
    border: 1px solid #E99B38;
    background: #FFEAC3;
}
/*添加表单*/
.formBuilder_step3{
display:none;
}
.filter_div{
	height: auto;
    padding: 10px 50px;
    background: #E4EAEB;
    -webkit-user-select: none;
    -moz-user-select: none;
    border-bottom: 1px solid #D0D0D0;
}
/*  
*@Description: 页面布局  
*@Author:      Zhuyb 
*@Update:      Zhuyb(2012-10-23)  
*/ 
.clearB{
	clear:both;
}
.pointer{
	cursor:pointer;
}
.fll{
	float:left;
}
.flr{
	float: right;
}
.mgl10{
	margin-left:10px;
}
.mgt5{
	margin-top: 5px;
}
.mgl5{
	margin-left: 5px;
}
.mgr5{
	margin-right: 5px;
}
.padl10{
	padding-left:10px;
}
.label_bold{
	color:#848484;
	font-size:14px;
	font-weight:bold;
	text-shadow:1px 1px 0 rgba(255, 255, 255, 0.75);
}
.show{
	display: block;
}
.hide{
	display:none;
}

#header{
	background: #333 url(/images/bg/HeaderBg.png) repeat-x;
	height:40px;
	z-index: 510;
}

#sidebar{
	width:60px;
	position:absolute;
	left:0px;
	top:50px;
	bottom:0;
	background: #373737;
	border-right:1px solid #333333;
	z-index: 500;
}

#wrapper{
	position:absolute;
	bottom: 0;
	left:0px;
	right: 0;
	top:0px;
	background: #BEC4C5 url(/images/bg/BodyBg.png) repeat;
	overflow:hidden;
}

#main{
	position:absolute;
	left:10px;
	right:10px;
	top:10px;
	bottom:10px;
	border:1px solid #BBBCBC;
	border-radius:5px;
	box-shadow:0 0 2px rgba(0, 0, 0, 0.2);
	background:#FFFFFF;
}

/*表单验证错误样式*/
input.error { border:1px solid #7A3230; }
label.error {
	height: 20px;
	position: absolute;
	right: -5px;
	top: -34px;
	background: #7A3230;
	z-index: 10;
	color: #fff;
	font-size: 12px;
	padding: 4px 10px;
	text-align: center;
	border-radius: 3px;
	white-space: nowrap;
}
.error_img{
	display: inline-block;
	width: 16px;
	height: 26px;
	position: absolute;
	right: 5px;
	top: -6px;
	background: url(/images/icon/verify_false.png) no-repeat;
}
.checkRight .error_img{
	background: url(/images/icon/verify_sucess.png) 0 7px no-repeat;
}

/*弹窗*/
#bg{
	background-color: #000; 
	position: absolute; 
	left:0; 
	top:0;
	opacity: 0.4; /* Standards Compliant Browsers */
  	filter: alpha(opacity=50); /* IE 7 and Earlier */
	/* Next 2 lines IE8 */
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
	filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
}
#flagBox {
	position: absolute;
	border: 1px solid #B3B3B3;
	border-radius: 3px;
	box-shadow: 0 0 1px #000000;
	background: #FCFCFC;
	z-index:2000;
}
.popwin, .popwin_new{
	display: none;
	width: 414px;
	height: auto;
	border: 1px solid #B3B3B3;
	border-radius: 3px;
	box-shadow: 0 0 1px #000000;
	background: #FCFCFC;
	padding: 20px;
}
.popwin_title{
	/*width: 394px;*/
	height: 50px;
	text-align: left;
	font-size: 14px;
	color: #333;
	line-height: 50px;
	background: #F5F5F5;
	padding-left: 20px;
	border-top-left-radius: 3px;
	border-top-right-radius: 3px; 
	border-bottom: 1px solid #DDDDDD;
}
.popwin_close{
	float: right;
	margin-right: 20px;
	margin-top: 15px;
	cursor: pointer;
}
.popwin_content{
	/*width: 374px;*/
	height: auto;
	padding: 20px;
	text-align: center;
}
.popwin_tips{
	font-size: 16px;
	color: #2776A4;
	line-height: 30px;
	margin-bottom: 20px;
}
.popwin_tipsH1{
	font-size: 16px;
	color: #2776A4;
	margin-bottom: 10px;
}
.popwin_tipsH2{
	font-size: 12px;
	margin-bottom: 15px;
	color: #B35454;
}
.popwin_validateFail{
	visibility: hidden;
	font-size: 12px;
	color: #B35454;
}
.popwin_description{
	font-size: 12px;
	color: #65A25D;
	line-height: 25px;
	margin: 0 30px 20px 30px;
	background: #D5F5C3;
	border: 1px solid #B5D6B2;
	border-radius: 2px;
}
.popwin_error{
	display: none;
	font-size: 12px;
	color: #A25D5D;
	line-height: 25px;
	margin: 0 30px 10px 30px;
	background: #FFD3D3;
	border: 1px solid #D6B2B2;
	border-radius: 2px;
}
.popwin_confirm, .popwin_cancel,
.popwin_newForm_confirm, .popwin_newForm_cancel,
.popwin_newSms_confirm, .popwin_newSms_cancel,
.popwin_newMail_confirm, .popwin_newMail_cancel{
	margin: 0 20px;
}

.video_placeholder {
	display: block;
	height: 260px;
	width: 440px;
	background:url(/images/video_mail.png) no-repeat;
	margin: 40px auto;
}
.video_placeholder:hover {
	cursor: pointer;
}
.doing_p{
	font-size: 24px;
	font-weight: bold;
	text-align: center;
	margin-top: 60px;
	line-height: 50px;
}

.popwin_content .popwin_newForm_input,
.popwin_content .popwin_newSms_input,
.popwin_content .popwin_newMail_input{
	width: 300px;
	margin-bottom: 20px;
}



#blackmask{
	background: #000;
}
#frameless{
	padding:0;
}
.tmask {
	position:absolute; 
	display:none; 
	top: 0; 
	left: 0; 
	height:100%; 
	width:100%; 
	background:#000; 
	z-index:800;
}
.tbox {
	position:absolute; 
	display:none; 
	padding:14px 17px; 
	z-index:900;
}
.tinner {
	border-radius: 3px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.5);
	background: #FFFFFF;
	border: 1px solid #5C5C5C;
}
.tclose {
	position:absolute; 
	top:35px; 
	right:20px; 
	width:30px; 
	height:30px; 
	cursor:pointer; 
	background:url(/images/icon/popwin_close.png) no-repeat;
}
.tips_success{
	display: none;
}
.success_tip {
	color: #19691F;
	line-height: 30px;
	text-align: center;
	background: #E7FFCF; 
	border: 1px solid #B3E179;
	border-radius: 3px;
}

.registerFail{
	text-align: center;
	color: #999;
	font-size: 17px;
	font-weight: bold;
	margin-top: 50px;
}


/*新的表单的信息*/
.popwin_formtype {
	float: left;
	width: 159px;
	margin: 0 10px;
	padding: 20px 10px 10px 10px;
	height: 160px;
	border: 1px solid rgba(0,0,0,0);
	transition: all 260ms;
	-webkit-transition: all 260ms;
	-moz-transition: all 260ms;
	-o-transition: all 260ms;
	-moz-box-sizing: border-box;  /*Firefox3.5+*/
	-webkit-box-sizing: border-box; /*Safari3.2+*/
	-o-box-sizing: border-box; /*Opera9.6*/
	-ms-box-sizing: border-box; /*IE8*/
	box-sizing: border-box;
	cursor: pointer;
	font-size: 18px;
	font-weight: bold;
	line-height: 40px;
	margin-top: 10px;
	border-radius: 4px;
}

.popwin_formtype img {
	width: 80px;
	display: block;
	text-align: center;
	margin: 0 auto 4px auto;
}

.popwin_formtype_normal {
	color: #56779B;
}

.popwin_formtype_logic {
	color: #B4533A;
}

.popwin_formtype_normal:hover {
	border-color: #56779B;
}

.popwin_formtype_logic:hover {
	border-color: #B4533A;
}

.popwin_formNameContent,
.popwin_smsNameContent {
	display: none;
	margin-top: 24px;
}

.popwin_formTypeContent {
	width: 360px;
	margin-left: auto;
	margin-right: auto;
}
/*wiki faq*/
.wiki_faq_help{
    cursor: pointer;
    display: inline-block;
    width: 20px;
    height: 20px;
    background-image: url(/images/icon/wikiHelp_big.png);
    background-repeat: no-repeat;
    position: relative;
}
.wiki_faq_help:hover {
    background-image: url(/images/icon/wikiHelp_big_hover.png);
}




/*  
*@Description: ²àµ¼º½À¸
*@Author:      zhuyb  
*@Update:      zhuyb(2012-10-23)  
*/  


/*Important Start*/
.navItem{
	display:inline-block;
	width:1px;
	height:1px;
	margin:25px;	
}
/*Important End*/
.siderbar_iteam{	
	height: 100%;
	box-shadow: 0px 1px 0px #666666;
}
.navItem_box{
	position: absolute;
	left: 0;
	padding:0 11px;
	width: 38px;
	height: 54px;
	background-color: transparent;
	border-radius: 0px 3px 3px 0px;	
	overflow:  hidden;
	cursor: pointer;
	z-index: 300;
}
.nav_shareMike{
	bottom: 50px;
}
.nav_mikeWiki{
	bottom: 104px;
}
.nav_mikeWiki.active{width: 110px; background-color: rgb(58, 108, 146);  }

.messageFeedback{
	bottom: 158px;
}
.messageFeedback.active{width: 110px; background-color: rgb(58, 108, 146);  }

.userSurvey{
	bottom: 212px;
}
.navItem_box img{
	margin:13px 0;
	float: left;
}
.navItem_box a{
	margin-left:10px;
	font-size:13px;
	color:#ffffff;
	line-height:54px;
}
.chatOnline {
	margin-bottom:15px;
	text-align: right;
}
.chatOnline a {
	background: url(/images/icon/QQchat.png) 0 0 no-repeat;
	color: #666666;
	padding: 5px 0 6px 30px;
}
.chatOnline a:hover {
	background: url(/images/icon/QQchat.png) 0 -28px no-repeat;
}


.messagesTous{
	position: relative;
	width: 435px;
	overflow: scroll;
	margin: 20px 0;
	padding: 5px;
	text-align: left;
}
.messagePlaceHolder{
	position: absolute;
	top: 144px;
	left: 48px;
	color: #999999;
}
.tbox .popwin_inputError{
	border: 1px solid #7A3230;
}
input.message_email{
	width: 193px;
}
input.message_name{
	width: 80px;
}
input.message_phone{
	width: 130px;
}
.siderbar_name{
	margin-top: 60px;
}
.siderbar_name a{
	display: block;
	padding: 10px 0;
	margin:5px auto;
	text-align: center;
	color: #ffffff;
}
.siderbar_name a:hover{
	background: #3A6C92;
}


.shareMike_icon{
	margin: 15px auto;
	width: 260px;
	height: 40px;
}

.jiathis_style_32x32 a{
	width:38px;height:38px;overflow:hidden;
	margin:0px 5px;
}

.jiathis_style_32x32 .jiathis_button_tsina .jtico_tsina {
	width:38px;
	background: url(/images/shareMikeIcons.png) no-repeat 0 -38px;
	height: 38px !important;
}
.jiathis_style_32x32 .jiathis_button_weixin .jtico_weixin {
	width:38px;
	background: url(/images/shareMikeIcons.png) no-repeat -38px -38px;
	height: 38px !important;
}
.jiathis_style_32x32 .jiathis_button_douban .jtico_douban {
	width:38px;
	background: url(/images/shareMikeIcons.png) no-repeat -76px -38px;
	height: 38px !important;
}
.jiathis_style_32x32 .jiathis_button_cqq .jtico_cqq {
	width:38px;
	background: url(/images/shareMikeIcons.png) no-repeat -114px -38px;
	height: 38px !important;
}
.jiathis_style_32x32 .jiathis_button_renren .jtico_renren {
	width:38px;
	background: url(/images/shareMikeIcons.png) no-repeat -152px -38px;
	height: 38px !important;
}

.jiathis_style_32x32 .jiathis_button_tsina .jtico_tsina:hover {
	background: url(/images/shareMikeIcons.png) no-repeat 0 0;
}
.jiathis_style_32x32 .jiathis_button_weixin .jtico_weixin:hover {
	background: url(/images/shareMikeIcons.png) no-repeat -38px 0;
}
.jiathis_style_32x32 .jiathis_button_douban .jtico_douban:hover {
	background: url(/images/shareMikeIcons.png) no-repeat -76px 0;
}
.jiathis_style_32x32 .jiathis_button_cqq .jtico_cqq:hover {
	background: url(/images/shareMikeIcons.png) no-repeat -114px 0;
}
.jiathis_style_32x32 .jiathis_button_renren .jtico_renren:hover {
	background: url(/images/shareMikeIcons.png) no-repeat -152px 0;
}


/*.disableForm_switchBtn a{
	width: 60px;
	text-align: center;
}
.switchField, .enableField{
	width: 300px;
	text-align: left;
	margin: 20px auto;
}
.disable_time input, .disable_feedbackNum input, .enable_time input{
	width: 20px;
	text-align: center;
	font-weight: bold;
	border: 0;
	border-bottom: 1px solid #999;
	outline: none;
}
.disable_time .year, .enable_time .year{
	width: 32px;
}
.disable_time .time, .enable_time .time{
	width: 40px;
}
.current_time, .current_feedbackNum{
	line-height: 30px;
}
.current_time span, .current_feedbackNum span{
	font-weight: bold;
}
.popwin_disableForm_confirm, .popwin_EnableForm_confirm{
	margin-left: 70px;
	margin-right: 20px;
}
.disable_feedbackNum input{
	width: 50px;
}
.disableError, .enableError{
	width: 300px;
	color: white;
	font-size: 12px;
	line-height: 19px;
	text-align: center;
	background: #7A3230;
	border: 1px solid #7A3230;
	border-radius: 3px;
	visibility: hidden;
}*/

.welcomeMikeTable{
}
.welcomeMikeTable td{
	text-align: center;
}

.welcomeMikeTable .welcome_wiki_item{
	font-size: 16px;
	color: #333;
	background: center no-repeat;
	background-position: 28px 15px;
	padding-top: 110px;
	width: 143px;
	cursor: pointer;
	display: inline-block;
}

.welcomeMikeTable .welcome_wiki_item.icon_wiki{
	background-image:URL('/images/wiki_default.png');
}
.welcomeMikeTable .welcome_wiki_item.icon_wiki:hover{
	background-image:URL('/images/wiki_hover.png');
}

.welcomeMikeTable .welcome_wiki_item.icon_magicbook{
	background-image:URL('/images/magicbook_default.png');
}
.welcomeMikeTable .welcome_wiki_item.icon_magicbook:hover{
	background-image:URL('/images/magicbook_hover.png');
}

.welcomeMikeTable .welcome_wiki_item.icon_feedback{
	background-image:URL('/images/feedback_default.png');
}
.welcomeMikeTable .welcome_wiki_item.icon_feedback:hover{
	background-image:URL('/images/feedback_hover.png');
}

.welcomeMikeTable p{
	margin-top:5px;
	color:#9d9d9d;
	font-size:12px;
	line-height:20px;
	padding:2px 25px;
}











/*  
*@Description: 基本组件样式 
*@Author:      Zhuyb 
*@Update:      Zhuyb(2012-10-26)  
*/ 

/* Button */
.btn {
  display:inline-block;
  padding:4px 10px;
  border-radius:2px;
  font-size: 12px;
}
.btn img{
  margin-right: 5px;
  vertical-align: middle;
}
.btn .icon{
  float: left;
  width: 20px;
  height: 18px;
  background-image: url(../images/application/icons.png?m=20160122);
}
.btn .title{
  float: left;
  white-space: nowrap;
  line-height: 18px;
  margin: 0;
  padding: 0;
}

.btn-primary .form{
  background-position: -125px -99px;
}
.btn-primary .arrow_down{
  float: right;
  background-position: -22px -340px;
}

.btn .mailWhite{
  background-position: -125px -146px;
}
.btn-minor .group{
  background-position: -437px -52px;
}
.btn-minor .contact{
  background-position: -436px -4px;
}
.btn-minor .mail{
  background-position: -437px -148px;
}
.btn-minor .sms{
  background-position: -437px -195px;
}
.btn-minor .star{
  background-position: -126px -292px;
}
.btn-minor .arrow_down{
  float: right;
  background-position: 0 -340px;
}
.btn-minor:hover .arrow_down{
  background-position: -48px -340px;
}

.btn-disabled .group{
  background-position: -437px -52px;
}
.btn-disabled .contact{
  background-position: -436px -4px;
}
.btn-disabled .mail{
  background-position: -437px -148px;
}
.btn-disabled .sms{
  background-position: -437px -195px;
}
.btn-disabled .arrow_down{
  float: right;
  background-position: 0 -340px;
}



.btn-primary {
  color: white;
  background:#2976A4;
}
.btn-primary:hover {
  background:#3C8CBD;
}
.btn-primary:active{
  background:#255A7A;
}
.btn-primary:visited{
  color:#ffffff;
}
.btn-primary .title {
  color:#ffffff;
}

.btn-minor {
  background-color: white;
  border: 1px solid #BFBFBF;
}
.btn-minor .title {
  color: #666;
}
.btn-minor:hover{
  color: #4491C4;
}
.btn-minor:hover .title{
  color: #4491C4;
}
.btn-minor:active{
  background-color:#DEEBF3;
}
.btn-minor:visited .title{
  color: #666;
}

.btn-disabled {
  background-color: #F5F5F5;
  border: 1px solid #BFBFBF;
  cursor: default;
}
.btn-disabled .title {
  color: #999;
}
.btn-disabled:visited .title{
  color: #999;
}


.button{
  display: inline-block;
  padding: 0 20px;
  border: 1px solid #8D3836;
  box-shadow: 0 0 2px #ffffff inset;
  border-radius: 2px;
  color: #ffffff;
  font-size: 13px;
  text-align: center;
  line-height: 28px;
}
.button:visited{
  color: white;
}
.btn_red{ 
  background: #B94A48;  
  box-shadow: 0 1px 0 #EC9F9F inset;
}
.btn_red:hover{
  background: #B76666; 
}
.btn_red:active{
  background: #7A3230; 
}
.btn_green{
  background: #579658;
  border-color: #396F3A;
  box-shadow: 0 1px 0 #86B28A inset;
}
.btn_green:hover{
  background: #68AC68; 
}
.btn_green:active{
  background: #2F5930; 
}
.btn-mail_green {
  color: #fff;
  background: #28b779;
}
.btn-mail_green:hover {
  background: #2ccb86;
}
.btn-mail_green:active {
  color: #fff;
}
.btn-mail_green:visited {
  color: #fff;
}
.btn-icon_buy_quota {
  float: left;
  width: 16px;
  height: 15px;
  margin: 1px 4px 0 0;
  background: url(../images/icon/mail_quota_buy.png) no-repeat;
}
.btn_blue{
  background: #377FA3;
  border-color: #2C5E8B;
  box-shadow: 0 1px 0 #6D9ACC inset;
}
.btn_blue:hover{
  background: #62A6C4; 
}
.btn_blue:active{
  background: #235F78; 
}
.btn_orange{
  background: #FF7B00;
  border-color: #F55A00;
  box-shadow: 0 1px 0 #FFA204 inset;
}
.btn_gray{
  color: #555555;
  background: #E7E7E7;
  border-color: #AAAAAA;
  cursor: default;
}

/*input框*/
.input, .input_small, .textarea{
    outline:0 none;
    border:1px solid #D9D9D9;
    border-top-color:#AAAAAA;
    border-radius: 2px;
    padding:5px;
    transition-property: all;
    transition-duration: 200ms;
    transition-delay: 0;
    transition-timing-function: ease-in-out;
    -webkit-transition-property: all;
    -webkit-transition-duration: 200ms;
    -webkit-transition-delay: 0;
    -webkit-transition-timing-function: ease-in-out;
    -moz-transition-property: all;
    -moz-transition-duration: 200ms;
    -moz-transition-delay: 0;
    -moz-transition-timing-function: ease-in-out;
    -o-transition-property: all;
    -o-transition-duration: 200ms;
    -o-transition-delay: 0;
    -o-transition-timing-function: ease-in-out;
}
.textarea {
    /*overflow: hidden;*/
}
.input{
  height:18px;
}
.input_small{
  width:74px;
  height:18px;
}
.input:hover, .input_small:hover , .textarea:hover, .inputHover{
  background: #ffffff;
  border-color: #A6A6A6;
  border-top-color:#808080;
}
.input:focus, .input_small:focus, .textarea:focus, .inputFocus{
  background: #ffffff;
  border-color: #609ED2;
}
.input:invalid{
  border-color: #7A3230;
}
.input_val, .input_val .input{
  position: relative;
}
.input_val span{
  position: absolute;
  left: 5px;
  top: 0;
  color: #999999;
  cursor: text;
}

.form_lable_width{
	max-width:100px;
}
#number_min,#number_max{
	max-width:40px;
}
#set_reg{
	max-width:80px;
	
}



.mailManager_top {
    height: 60px;
    padding: 10px 50px;
    background: #E4EAEB;
}

.mailManager_top .btn-mail {
    margin-top: 20px;
}

.mailManager_sendNum {
    float: right;
    padding: 10px 20px;
    text-align: center;
    color: #965708;
    border: 1px solid #E99B38;
    background: #FFEAC3;
    margin-top: 14px;
    margin-right: 15px;
}
/*表单列表*/

.mailManager_detail {
    position: absolute;
    top: 80px;
    bottom: 10px;
    left: 0px;
    right: 0px;
    background: white;
    border-top: 1px solid #D0D0D0;
    overflow: hidden;
}

.mailDetail {
    border: 1px solid #D9D9D9;
    border-radius: 3px;
    background: #ffffff;
    margin: 20px 50px;
}

.noMail {
    background: url(../images/feedback_default.png) center no-repeat;
    width: 350px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 4%;
    color: #666;
    font-size: 14px;
    padding-top: 240px;
    text-align: center;
}

.noMail .btn-mail {
    margin-top: 20px;
}

.mailName_input {
    display: inline-block;
    line-height: 30px;
    font-size: 18px;
    color: #36853A;
    border: 1px solid transparent;
    border-radius: 2px;
    padding: 0 5px;
    margin: 10px 20px;
    outline: none;
}

.input_border {
    border: 1px solid #609ED2;
}

.btn_statistics {
    float: right;
    margin-right: 20px;
    margin-top: 15px;
}

.mail_state {
    float: right;
    margin-right: 20px;
    margin-top: 15px;
    line-height: 30px;
}

.mailSettings {
    line-height: 40px;
    background: #F5F5F5;
    font-size: 12px;
    border-top: 1px solid #D9D9D9;
}

.mailSettings a {
    display: inline-block;
    line-height: 17px;
    padding: 4px 10px 4px 30px;
    margin-right: 20px;
    color: #333;
}

.mailSettings a:first-child {
    margin-left: 20px;
}

.mailSettings a:hover {
    color: #36853A;
}

.mail_editName {
    background: white url(../images/icon/settingGreen.png) 10px center no-repeat;
}

.mail_edit {
    background: white url(../images/icon/editGreen.png) 10px center no-repeat;
}

.mail_send {
    background: white url(../images/icon/deriveGreen.png) 10px center no-repeat;
}

.mail_copy {
    margin-top: 8px;
    background: white url(../images/icon/copyGreen.png) 10px center no-repeat;
}

.mail_delete {
    margin-top: 8px;
    background: white url(../images/icon/crossGray.png) 10px center no-repeat;
}

.mail_show {
    background: #FFF url(../images/icon/showGreen.png) 10px center no-repeat;
}

.mm_detail {
			overflow: auto;
			position: absolute;
			top: 248px;
			left: 0;
			right: 0;
			bottom: 0;
			z-index: 999999;
}

.mailManager_detail {
    position: absolute;
    top: 80px;
    bottom: 0;
    left: 0px;
    right: 0px;
    background: #FFF;
    border-top: 1px solid #D0D0D0;
    overflow: auto;
}

.mailDetail {
    border: 1px solid #D9D9D9;
    border-radius: 3px;
    background: #FFF;
    margin: 20px 50px;
}

.mm_glance {
    position: relative;
    /*margin-top: 6px;*/
    
    height: 200px;
    background-color: #fffeff;
    text-align: center;
    overflow: hidden;
    padding: 0 50px;
    border-bottom: 1px solid #d0d0d0;
    /*margin-bottom: 4px;*/
}

.mm_glance .mg_glance_container {}

.mg_glance_container li {
    position: relative;
    float: left;
    width: 25%;
    line-height: 166px;
    box-sizing: border-box;
    background-color: #fff;
}

.info_warpper {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.mg_info_wrapper {
	display: none;
    position: absolute;
    top: 66px;
    right: 162px;
    bottom: 0;
    left: 0;
}

.mg_info {
    /*margin-right: 150px;*/
    
    background-color: #fff;
    height: 60px;
    line-height: 30px;
    white-space: nowrap;
    overflow: hidden;
}

.mg_info div {
    height: 40px;
    color: #aaa;
    margin-top: 20px;
    white-space: nowrap;
    overflow: hidden;
}
/*	.mg_info .mg_opened, .mg_info .mg_clicked, .mg_info .mg_unsub {
			margin-top: 15px;
		}*/

.mg_info div span {
    display: inline-block;
    height: 30px;
    float: right;
    padding: 0 4px;
}

.mg_info .mg_line {
    border-top: 1px solid #D9D9D9;
}

.mg_chart_container {
    float: right;
    width: 145px;
    height: 145px;
    margin: 30px 10px;
    transition-property: all;
    transition-duration: 100ms;
    transition-delay: 0;
    transition-timing-function: ease-in-out;
    -webkit-transition-property: all;
    -webkit-transition-duration: 100ms;
    -webkit-transition-delay: 0;
    -webkit-transition-timing-function: ease-in-out;
    -moz-transition-property: all;
    -moz-transition-duration: 100ms;
    -moz-transition-delay: 0;
    -moz-transition-timing-function: ease-in-out;
    -o-transition-property: all;
    -o-transition-duration: 100ms;
    -o-transition-delay: 0;
    -o-transition-timing-function: ease-in-out;
}
.mg_info_item .active {
	float: none;
    margin: 30px auto;
}

.mg_title {
    height: 40px;
    line-height: 40px;
    font-size: 18px;
    color: #333;
    background-color: #F5F5F5;
    text-align: left;
    border-bottom: 1px solid #d0d0d0;
}

.mg_title .title {
    margin-left: 50px;
    float: left;
}

.mg_title .wiki_help {
    float: left;
    margin-top: 13px;
    margin-left: 6px;
    cursor: pointer;
    display: inline-block;
    width: 20px;
    height: 20px;
    background-image: url(../images/icon/wikiHelp_big.png);
    background-repeat: no-repeat;
}

.mg_title .wiki_help:hover {
    background-image: url(../images/icon/wikiHelp_big_hover.png);
}

.mgd_number {
    font-size: 20px;
}

.mg_delivered_wrapper .mgd_number {
    color: #5ad3aa;
}

.mg_open_wrapper .mgd_number {
    color: #71c2df;
}

.mg_click_wrapper .mgd_number {
    color: #f0957a;
}

.mg_unsub_wrapper .mgd_number {
    color: #dfc666;
}

.mg_unsub_wrapper .mgd_number {
    cursor: pointer;
    border-bottom: 1px solid #dfc666;
}

.mailQuota {
    float: left;
    width: 20px;
    height: 18px;
    background-image: url(../images/icon/mail_quota.png);
    background-repeat: no-repeat;
}

.btn_mailQuota {
    float: right;
}

.mg_glance_container li {
    transition-property: all;
    transition-duration: 100ms;
    transition-delay: 0;
    transition-timing-function: ease-in-out;
    -webkit-transition-property: all;
    -webkit-transition-duration: 100ms;
    -webkit-transition-delay: 0;
    -webkit-transition-timing-function: ease-in-out;
    -moz-transition-property: all;
    -moz-transition-duration: 100ms;
    -moz-transition-delay: 0;
    -moz-transition-timing-function: ease-in-out;
    -o-transition-property: all;
    -o-transition-duration: 100ms;
    -o-transition-delay: 0;
    -o-transition-timing-function: ease-in-out;
}

/* 购买按钮 start */
.btn-mail_buyQuota {
    float: right;
    margin: 20px 15px 0 0;
}
