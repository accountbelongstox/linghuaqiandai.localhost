<style>
#<?php echo $module['module_name'];?>{ }
#<?php echo $module['module_name'];?>_html{
    
}
.operation_td .edit,.operation_td .del,.operation_td .view {    
	white-space: nowrap;
    font-size: 1rem;
    border-radius: 5px;
    padding: 0;
    margin: 0;
    width: 16px;
    float: left;
    display: block;
    height: 16px;
    line-height: 16px;
}
.table_scroll table tr td.operation_td,td.operation_td{
	<?php echo $module['operation_td_width'];?>
}
.div_shortcut{
    font-size: 18px;
    margin-top: 10px;
    display: block;
    padding: 0 10px;
    max-width:180px;
}
.span_shortcut{
    display: inline-block;
    border: 1px solid #BCD5F1;
    background: #E1F3FC;
    text-decoration: none;
    padding: 0 3px;
    margin: 2px;
    font-family: helvetica;
    line-height: 18px;
    height: 18px;
    font-size: 12px;
    float: left;
}
.show_input_submit{
	float:left;
    width: 100%;
}
.defind_a{
	    float: left;
    display: block;
    font-size: 12px;
    display: block;
    width: 100%;
    text-align: center;
    line-height: 22px;
    max-width: 200px;
}
.defined_sublime{
	    text-align: center;
    display: block;
    width: 100%;
    color: #337ab7;
}
.span_shortcut.active{
    border: 1px solid red;
    background: #fff;
}
.content-sub-section img{
	max-width:100%;
}
.table_scroll{
	margin-left:0;
}
</style>