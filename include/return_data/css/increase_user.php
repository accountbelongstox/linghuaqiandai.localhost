
<style>
#<?php echo $module['module_name'];?>{ }
#<?php echo $module['module_name'];?>_html{ }

#<?php echo $module['module_name'];?> .input{
	border: none;
    line-height: 36px;
    height: 36px;
    background: none;
}

#<?php echo $module['module_name'];?> .line .input{
	overflow: visible;
}

#<?php echo $module['module_name'];?> .input:hover{
	border: none;
    line-height: 36px;
    height: 36px;
    background: none;
}



#<?php echo $module['module_name'];?> input[type=text],#<?php echo $module['module_name'];?> input[type=password]{
	width:60%;
}


#<?php echo $module['module_name'];?> .submit{
	width:60%;
	padding:0;
    line-height: 36px;
    height: 36px;
    color: #fff;
    text-align: center;
}

@media(max-width:687px){
	#<?php echo $module['module_name'];?> input[type=text],#<?php echo $module['module_name'];?> input[type=password]{
	width:100%;
}

}

</style>