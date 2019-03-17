<style type="text/css">
/*login*/
	#<?php echo $module['module_name'];?>{
		ine-height: 2rem;
    width: 100%;
    height: 100%;
    font-size: 16px;
    font-family: "Microsoft YaHei";
    background: #F1F1F1;
    color: #676a6c;
	}
	#<?php echo $module['module_name'];?>_html{ height:100%; }
	#<?php echo $module['module_name'];?>_html .form_div{    
		width: 350px;
    text-align: left;
    overflow: hidden;
    margin: 0 auto;
    }
	#<?php echo $module['module_name'];?>_html .form_div .f_body{ padding:1rem;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login_logo_div{     
	text-align: center;
    font-weight: bold;
    margin-bottom: 20px;
    font-size: 16px;
		}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login_logo_div img{ width:100%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div{  }
	#<?php echo $module['module_name'];?>_html .form_div .f_body  input{ border:none; outline-width:0px;  width:85%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body  input:focus{  border:none; outline-width:0px; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .username_div{ 
	margin-bottom:1rem;
	border: 1px solid #ccc;
	overflow:hidden;
    background: #fff;
}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .username_div:before{ font: normal normal normal 1.2rem/1 FontAwesome; content:'\f007';   border-radius:50%;  display:inline-block; width:2rem; height:2rem; line-height:2rem; text-align:center;color:#ccc; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .password_div{ 
		
		margin-bottom:1rem;
		border: 1px solid #ccc;
		 overflow:hidden;
    background: #fff;
		}
#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .password_div,#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .username_div{
	border-radius:1rem; 
	}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .password_div:before{font: normal normal normal 1.2rem/1 FontAwesome; content:'\f084';   border-radius:50%;  display:inline-block; width:2rem; height:2rem; line-height:2rem; text-align:center;color:#ccc;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div{ text-align:left;margin-top:1rem; white-space:nowrap; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div #authcode_div{ display:inline-block; vertical-align:top;  border-radius:1rem; margin-bottom:1rem;border: 1px solid #ccc; overflow:hidden; width:50%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div #authcode_div input{ width:60%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div #authcode_div:before{font: normal normal normal 1rem/1 FontAwesome; content:'\f14a';   border-radius:50%;  display:inline-block; width:2rem; height:2rem; line-height:2rem; text-align:center;color:#ccc;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div .authcode_img_a{display:inline-block; padding-left:1rem; vertical-align:top; width:40%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div .authcode_img_a img{ height:2.5rem; }
	
	
	
	#<?php echo $module['module_name'];?>_html .form_div .f_body #get_password{
		display: inline-block;
    color: #337ab7;
    vertical-align: top;
    width: 30%;
    text-align: right;
    font-size: 14px;
    border-right: 1px solid #DEDCEA;
    padding-right: 10px;
		}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login{    
		display: block;
    width: 100%;
    margin: auto;
    text-align: center;
    margin-top: 1rem;
    margin-bottom: 1rem;
    border-radius: 8px;
    color: #ffffff !important;
    background-color: #7266ba;
    border-color: #7266ba;
    height: 30px;
    line-height: 30px;
    border: none;
    padding: 0;
	}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .form_div #register{   
	display: inline-block;
    vertical-align: top;
    width: 40%;
    text-align: left;
    color: #337ab7;
    font-size: 13px;
    padding-left: 10px;
		}
	#<?php echo $module['module_name'];?>_html .form_div #register:hover{}
	
	#<?php echo $module['module_name'];?>_html .oauth_div { text-align:center;}
	#<?php echo $module['module_name'];?>_html .oauth_div .oauth_switch{ color:#ccc; font-size:0.9rem; } 
	#<?php echo $module['module_name'];?>_html .oauth_div .oauth_switch:after{ display:none; }
  	#<?php echo $module['module_name'];?>_html .oauth_div .icons{  }
  	#<?php echo $module['module_name'];?>_html .oauth_div .icons a{ margin:0.3rem;}
  	#<?php echo $module['module_name'];?>_html .oauth_div .icons a img{ width:2rem; height:2rem;}
  	#<?php echo $module['module_name'];?>_html .oauth_div .icons a img:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html #submit_state{ display:block; color:red;  text-align:center;}
	#<?php echo $module['module_name'];?>_html  #login_div{ text-align:center;}
  	.page-footer{
  		display: none;
  	}
#login_logo_div h1 {
    color: #e6e6e6;
    font-size: 180px;
    letter-spacing: -10px;
    margin-bottom: 0px;
}
#input_div input[type=text] .form_div .f_body,	#<?php echo $module['module_name'];?>_html input{
	line-height: 30px;
	height: 30px;
    padding: 0;
    margin: 0;		
    border-radius:8px; 
		border: 1px solid #ccc;
}
  </style>
  
  