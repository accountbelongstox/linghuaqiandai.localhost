<?php
$editor=isset($_GET['editor'])?$_GET['editor']:'editor';
?>
        var <?php echo $editor;?>;
        KindEditor.ready(function(K) {
            <?php echo $editor;?> = K.create('textarea[name="<?php echo @$_GET['id'];?>"]', {
                <?php if(@$_GET['designMode']=='false'){echo 'designMode : false,';}?>
			   	newlineTag:'br',
			   	urlType:'relative',
                <?php
                if(is_file("lang/".$_GET['language'].".js")){$language=$_GET['language'];}else{$language='en';}
				?>
                langType : '<?php echo $language;?>',
				extraFileUploadParams : {
                     program :"<?php echo @$_GET['program'];?>"
               	}
			});
			

		});	