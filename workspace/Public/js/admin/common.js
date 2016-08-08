/**
 * 添加按钮操作
 */
$("#button-add").click(function(){
    var url = SCOPE.add_url;
    window.location.href=url;
});
/**
 * 提交from表单操作
 */
$("#singcms-button-submit").click(function(){
    //表单中的数据
    var data = $('#singcms-form').serializeArray();
    var postData={};
    $(data).each(function (){
        postData[this.name] = this.value;
    });
    //将获取到的数据post给服务器
    var url = SCOPE.save_url;
    $.post(url,postData,function(result){
            if(result.status==0){
                dialog.error(result.message);
            }
            if(result.status==1){
                
            }
    },'JSON');
});