<style>
#<?php echo $module['module_name'];?>{ }
#<?php echo $module['module_name'];?>_html{ }

/*以下为默认CSS*/
#<?php echo $module['module_name'];?>{
    border-radius: 5px;
    margin: auto;
    margin-top: 20px;
}
.container [user_color='button'], .submit, #submit, .add, .btn, .replace, .increase, #add{
    width:100%;
    max-width: 100%;
}
.form_title{
    font-size: 24px;
    font-weight: bold;
    line-height: 30px;
    text-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
}
.desfontcolor{/*表描述*/
    font-size: 16px;
    line-height: 26px;
    min-height: 26px;
}
@media (max-wiDth: 500px) {
    .form_title{
        font-size: 16px;
    }
    .desfontcolor{
        font-size: 14px;
        line-height: 18px;
    }
}

@media (max-width: 750px) {
    #<?php echo $module['module_name'];?>.portlet{
    	margin-top:0;
    }
	}

.f_share_container {
    position: fixed;
    top: 20px;
    left: 0;
    right: 0;
    height: 0;
    text-align: center;
}
div.f_share_main {
    width: 640px;
}
.f_share_main {
    width: 640px;
    /* height: 30px; */
    background-color: #345;
    position: relative;
    margin: 0 auto;
}div.f_share {
    left: 700px;
}
.f_share {
    text-align: right;
    position: absolute;
    cursor: pointer;
    width: 30px;
    height: 30px;
    background-color: rgba(255, 255, 255, 0.4);
    overflow: hidden;
    left: 640px;
    top: 0;
    margin-left: 8px;
    border-radius: 4px;
    white-space: nowrap;
    padding: 4px;
    color: #333;
}.share_info {    
	line-height: 30px;
    vertical-align: middle;
    float: left;
    width: 77px;
}img.qrcode {
    margin: 3px;
    opacity: 0.62;
    vertical-align: middle;
    width:24px;
    float: left;
}


.data_add_footer {
    height: 20px;
    margin-top: 20px;
    margin-bottom: 20px;
    text-align: center;
}.tbox {
    position: absolute;
    display: none;
    padding: 14px 17px;
    z-index: 1000;
}.tinner {
    border-radius: 3px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.5);
    background: #FFFFFF;
    border: 1px solid #5C5C5C;
}.popwin_content {
    height: auto;
    padding: 20px;
    text-align: center;
}
.popwin_content img{
    max-width: 100%;
	 }.share_des {
    text-align: center;
    color: #5A5A5A;
    margin-top: 4px;
}
.data_add_footer .fs_powerby {
    color: #EEE;
}
.form_title_div{
	width:100%;
	padding-bottom: 10px;
}
</style>