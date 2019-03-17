
<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .sequence{ width:40px;}
    /*表单设计CSS载入*/
    <?php require("./include/return_data/css/form_data_admin.php");?>
</style>


<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .data_state").each(function(index, element) {
            $(this).val($(this).attr('cloud_v'));
        });
		$("#<?php echo $module['module_name'];?> .write_able").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .read_able").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .fore_list_show").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .back_list_show").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
		
    });
    
    function update(id){
		write_able=($("#write_able_"+id).prop('checked'))?1:0;
		read_able=($("#read_able_"+id).prop('checked'))?1:0;
		fore_list_show=($("#fore_list_show_"+id).prop('checked'))?1:0;
		back_list_show=($("#back_list_show_"+id).prop('checked'))?1:0;
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{write_able:write_able,read_able:read_able,fore_list_show:fore_list_show,back_list_show:back_list_show,sequence:$("#sequence_"+id).val(),id:id}, function(data){
			//alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#state_"+id).html(v.info);
        });
        return false;	
        
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
            //alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        return false;	
        
    }
    
var theobject = null; //This gets a value as soon as a resize start
function resizeObject() {
    this.el        = null; //pointer to the object
    this.dir    = "";      //type of current resize (n, s, e, w, ne, nw, se, sw)
    this.grabx = null;     //Some useful values
    this.graby = null;
    this.width = null;
    this.height = null;
    this.left = null;
    this.top = null;
}
    

//Find out what kind of resize! Return a string inlcluding the directions
function getDirection(el) {
    var xPos, yPos, offset, dir;
    dir = "";

    xPos = window.event.offsetX;
    yPos = window.event.offsetY;

    offset = 8; //The distance from the edge in pixels

    if (yPos<offset) dir += "n";
    else if (yPos > el.offsetHeight-offset) dir += "s";
    if (xPos<offset) dir += "w";
    else if (xPos > el.offsetWidth-offset) dir += "e";

    return dir;
}


/*拖*/
    </script>




<div id="<?php echo $module['module_name'];?>_html" class="<?php echo $module['module_name'];?>_html" cloud-table="1" class="<?php echo $module['module_name'];?>_html">
    <div class="filter">
    <a href="/index.php?cloud=form.field_add&id=<?php echo $_GET['id'];?>"  class="add"><?php echo self::$language['add']?><?php echo self::$language['field']?></a>
    </div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td >表单分步</td>
                <td ><?php echo self::$language['name']?></td>
                <td ><?php echo self::$language['field_name']?></td>
                <td ><?php echo self::$language['type']?></td>
                <td ><?php echo self::$language['write_able']?></td>
                <td ><?php echo self::$language['read_able']?></td>
                <td ><?php echo self::$language['fore_list_show']?></td>
                <td ><?php echo self::$language['back_list_show']?></td>
                <td  style=" width:550px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody style="position: relative;">
        <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>
</div>
<script type="text/javascript">
   var sequences = $('.sequence');
   auto_give_sequences_class(sequences);
   function auto_give_sequences_class(sequences){
       sequences.each(function(index,ele){
            var n=parseInt($(ele).val());
            var c=['#5652F7','#6A6A6A'];
            switch(n){
                case 0:
                $(ele).parent().css({background:'#fff'});
                break;
                case 1:
                $(ele).parent().css({
                    background:c[n % c.length],
                    'text-align':'center'
                });
                break;
                case 2:
                $(ele).parent().css({
                    background:c[n % c.length],
                    'text-align':'center'
                });
                break;
                case 3:
                $(ele).parent().css({
                    background:c[n % c.length],
                    'text-align':'center'
                });
                break;
                case 4:
                $(ele).parent().css({
                    background:c[n % c.length],
                    'text-align':'center'
                });
                break;
                default:
                $(ele).parent().css({
                    background:c[n % c.length],
                    'text-align':'center'
                });
                break;
            }
       })  
   }
   sequences.change(function(){
        var val=$(this).val();
        if(val == ''){
            return false;
        }
        var val=parseInt(val);
        if(val == 0){
            $(this).val('1');
            return false;
        }
        $(this).parent().parent().find('.submit').trigger("click");
        auto_give_sequences_class(sequences);

        window.location.reload();

   })
</script>