<?php
	$this->extend('/Common/Admin/user');
	
	// load css
	$this->Html->css(array(
		// "login"
	), null, array('block' => "css_extra", 'inline' => false));
	
	// load script
	$this->Html->script(array(
	), array('block' => "script_extra", 'inline' => false));
?>
<div class="user">
	<h3 class="lighter block green">
		请完整填写以下信息：
	</h3>
<?php 
/*对接好好数据自动注册*/
$TPersonFMemberId='';/*账号*/
$TPersonFPassWord='';/*密码*/
$TPersonFullName='';/*姓名*/
$TPersonFMobileNumber='';/*手机*/
$TPersonFEMail='';/*邮箱*/
$TPersonFCity='';/*城市*/
$disabled_='';
if(isset($_GET["key"])){
	if($_GET["key"]="KeyHaohaodata2017"){
		$TPersonFMemberId=@$_GET["TPersonFMemberId"];
		$TPersonFPassWord=@$_GET["TPersonFPassWord"];
		$TPersonFullName=@$_GET["TPersonFullName"];
		$TPersonFMobileNumber=@$_GET["TPersonFMobileNumber"];
		$TPersonFEMail=@$_GET["TPersonFEMail"];
		$TPersonFCity=@$_GET["TPersonFCity"];
		$disabled_='disabled';
		echo '';
	}
}
echo $this->session->flash('auth');
$this->Form->inputDefaults(array('label' => true, 'div' => true));
echo $this->Form->create('TPerson', array('name' => "form1", 'role' => "form", 'class' => "form-horizontal")); 
echo $this->Main->formhr_input('FMemberId', array(
		'div' => "form-group", 
		'options' => array('0' => "文本", '1' => "图文", '2' => "图文集"),
		'label' => array('text' => "用户名：", 'class' => "col-sm-3 control-label no-padding-right"), 
		'type' => "text", 
		'placeholder' => "请输入账号", 
		'disabled' => $disabled_,
		'value' => $TPersonFMemberId,
		'class' => "col-xs-10 col-sm-5",
		'between' => "<div class='col-xs-12 col-sm-9'><div class='clearfix'>",
		'after' => "<span class='help-inline col-xs-12 col-sm-7'><span class='middle maroon'>*</span></span></div></div>",
		'error' => array('attributes' => array('wrap' => 'div', 'class' => 'help-block col-xs-12 col-md-offset-3'))
	));
echo $this->Main->formhr_input('FPassWord', array(
		'div' => "form-group", 
		'label' => array('text' => "密码：", 'class' => "col-sm-3 control-label no-padding-right"), 
		'type' => "password", 
		'disabled' => $disabled_,
		'placeholder' => "请输入密码", 
		'value' => $TPersonFPassWord,
		'class' => "col-xs-10 col-sm-5",
		'between' => "<div class='col-xs-12 col-sm-9'><div class='clearfix'>",
		'after' => "<span class='help-inline col-xs-12 col-sm-7'><span class='middle maroon'>*</span></span></div></div>",
		'error' => array('attributes' => array('wrap' => 'div', 'class' => 'help-block col-xs-12 col-md-offset-3'))
	));
echo $this->Main->formhr_input('FullName', array(
		'div' => "form-group", 
		'label' => array('text' => "姓名：", 'class' => "col-sm-3 control-label no-padding-right"), 
		'type' => "text", 
		'placeholder' => "", 
		'disabled' => $disabled_,
		'value' => $TPersonFullName,
		'class' => "col-xs-10 col-sm-5",
		'between' => "<div class='col-xs-12 col-sm-9'><div class='clearfix'>",
		'after' => "<span class='help-inline col-xs-12 col-sm-7'><span class='middle maroon'>*</span></span></div></div>",
		'error' => array('attributes' => array('wrap' => 'div', 'class' => 'help-block col-xs-12 col-md-offset-3'))
	));
echo $this->Main->formhr_input('FPhone', array(
		'div' => "form-group", 
		'label' => array('text' => "电话：", 'class' => "col-sm-3 control-label no-padding-right"), 
		'type' => "text", 
		'placeholder' => "", 
		'disabled' => $disabled_,
		'class' => "col-xs-10 col-sm-5",
		'between' => "<div class='col-xs-12 col-sm-9'><div class='clearfix'>",
		'after' => "<span class='help-inline col-xs-12 col-sm-7'><span class='middle maroon'></span></span></div></div>",
		'error' => array('attributes' => array('wrap' => 'div', 'class' => 'help-block col-xs-12 col-md-offset-3'))
	));
echo $this->Main->formhr_input('FMobileNumber', array(
		'div' => "form-group", 
		'label' => array('text' => "手机：", 'class' => "col-sm-3 control-label no-padding-right"), 
		'type' => "text", 
		'placeholder' => "", 
		'disabled' => $disabled_,
		'value' => $TPersonFMobileNumber,
		'class' => "col-xs-10 col-sm-5",
		'between' => "<div class='col-xs-12 col-sm-9'><div class='clearfix'>",
		'after' => "<span class='help-inline col-xs-12 col-sm-7'><span class='middle maroon'>*</span></span></div></div>",
		'error' => array('attributes' => array('wrap' => 'div', 'class' => 'help-block col-xs-12 col-md-offset-3'))
	));
echo $this->Main->formhr_input('FEMail', array(
		'div' => "form-group", 
		'label' => array('text' => "邮箱：", 'class' => "col-sm-3 control-label no-padding-right"), 
		'type' => "text", 
		'placeholder' => "", 
		'disabled' => $disabled_,
		'value' => $TPersonFEMail,
		'class' => "col-xs-10 col-sm-5",
		'between' => "<div class='col-xs-12 col-sm-9'><div class='clearfix'>",
		'after' => "<span class='help-inline col-xs-12 col-sm-7'><span class='middle maroon'>*</span></span></div></div>",
		'error' => array('attributes' => array('wrap' => 'div', 'class' => 'help-block col-xs-12 col-md-offset-3'))
	));
echo $this->Main->formhr_input('FCity', array(
		'div' => "form-group", 
		'label' => array('text' => "城市：", 'class' => "col-sm-3 control-label no-padding-right"), 
		'type' => "text", 
		'placeholder' => "",
		'disabled' => $disabled_,
		'value' => $TPersonFCity,
		'class' => "col-xs-10 col-sm-5",
		'between' => "<div class='col-xs-12 col-sm-9'><div class='clearfix'>",
		'after' => "<span class='help-inline col-xs-12 col-sm-7'><span class='middle maroon'>*</span></span></div></div>",
		'error' => array('attributes' => array('wrap' => 'div', 'class' => 'help-block col-xs-12 col-md-offset-3'))
	));
?>
	<div class="clearfix form-actions">
		<div class="col-sm-3 no-padding-right">
			<button class="btn btn-grey" type="button" onclick="location.href='<?php echo Router::url('/'); ?>'">
                <i class="icon-arrow-left bigger-110"></i>
                返回
            </button>
		</div>
		<div class="col-xs-12 col-sm-9">
            <button class="btn btn-info" type="submit">
                <i class="icon-ok bigger-110"></i>
                注册账号
            </button>
		</div>
	
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">

	
	 function getUrlParam(name) {/*获取GET值 */
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return unescape(r[2]); return null; //返回参数值
    }
</script>