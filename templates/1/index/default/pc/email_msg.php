<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
<style>
    #<?php echo $module['module_name'];?>_html{ }
    #<?php echo $module['module_name'];?> .ke-container{ border-radius:3px;}
    #<?php echo $module['module_name'];?> #title{ width:600px;}
    #<?php echo $module['module_name'];?> #content{}
</style>
    
<div id="<?php echo $module['module_name'];?>_html">
    <div class="portlet-title">
        <div class="caption"><?php echo $module['cloud_table_name']?></div>
    </div>
    <form id="cloud_form" name="cloud_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
      <?php echo self::$language['addressee'];?>(<?php echo self::$language['email'];?>)：<a href='/index.php?cloud=index.admin_users'><?php echo self::$language['select_please'];?></a><br />
      <textarea name="addressee" id="addressee" style=" height:90px;width:99%;"><?php echo @$_POST['data']?></textarea>
         <?php echo self::$language['addressee'];?><?php echo self::$language['separated_by_commas'];?>
<br /><br />
      <?php echo self::$language['title'];?>：<br />
      <input type="text" name="title" id="title" style="width:99%;" /><br /><br />
	  <?php echo self::$language['content'];?>：<br />
      
    <textarea name="content" id="content" style="display:none; width:99%; height:400px;"></textarea>
      <br /><input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span>
    </form>
    </div>
</div>
<?php require("./include/return_data/js/email_msg.php");?>

