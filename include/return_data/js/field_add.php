<script type="text/javascript">
    $("#copyFormQqueryURL").zclip({
        path:'js/ZeroClipboard.swf',
        copy:$(".query_url").val(),
        afterCopy: function(){
            $("#copyFormQqueryURL").text("复制成功");
        }
    });
    $("#copyFormIframe").zclip({
        path:'js/ZeroClipboard.swf',
        copy:$(".form_iframe").val(),
        afterCopy: function(){
            $("#copyFormIframe").text("复制成功");
        }
    });
    $("#btnFormIframe").zclip({
        path:'js/ZeroClipboard.swf',
        copy:$(".form_btnForm").val(),
        afterCopy: function(){
            $("#btnFormIframe").text("复制成功");
        }
    });
    $("#copyFormURL").zclip({
        path:'js/ZeroClipboard.swf',
        copy:$(".form_url").val(),
        afterCopy: function(){
            // console.log("copy!");
            $("#copyFormURL").text("复制成功");
        }
    });
    //自动请求生成静态
    $.get('<?php echo $module['action_url'];?>&act=create_html&type=table',function(data){
    	console.log('发布成功!');
    });
    </script>