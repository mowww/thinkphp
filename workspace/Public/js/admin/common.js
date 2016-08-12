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
    var jump_url = SCOPE.jump_url;
    $.post(url,postData,function(result){
            if(result.status==0){
                return dialog.error(result.message);
            }
            if(result.status==1){
                return dialog.success(result.message,jump_url);
            }
    },'JSON');
});
/**
 * 编辑模型页跳转
 */
$('.singcms-table #singcms-edit').on('click',function (){
    var id = $(this).attr('attr-id');
    var url = SCOPE.edit_url+"&id="+id;
    window.location.href=url;
});
/**
 * 删除菜单操作
 */
$(".singcms-table #singcms-delete").on('click',function (){
     //无需跳转到指定页面的确认弹出层
    
    var id = $(this).attr('attr-id');
    var url = SCOPE.set_status_url;
    var data={'id':id,'status':-1};
    var message =  $(this).attr('attr-message');
    layer.open({
                title : '是否提交？',
                icon:3,
                btn : ['yes','no'],
                closeBtn:2,
               
                content:"是否确定"+message,
                yes : function(){
                         //执行相关操作,外部函数防止闭环
                       todelete(url,data);
                },

            });
    
});
function todelete(url,data){
        $.post(url,data,function(result){
                                if(result.status==0){
                                    return dialog.error(result.message);
                                }
                                if(result.status==1){
                                    return dialog.success(result.message,'');
                                }
                        },'JSON');
}
/**
 * 排序操作
 */
$("#button-listorder").click(function(){
    //表单中的数据
    var data = $('#singcms-listorder').serializeArray();
    var postData={};
    $(data).each(function (i){
        postData[this.name] = this.value;
    });
    //将获取到的数据post给服务器
    var url = SCOPE.listorder_url;
    $.post(url,postData,function(result){
            if(result.status==0){
                return dialog.error(result.message);
            }
            if(result.status==1){
                return dialog.success(result.message,window.location.href);
            }
    },'JSON');
});
/**
 * 修改状态(文章的状态：正常1关闭0)
 */
$('.singcms-table #singcms-on-off').on('click', function(){

    var id = $(this).attr('attr-id');
    var status = $(this).attr("attr-status");
    var url = SCOPE.set_status_url;

    data = {};
    data['id'] = id;
    data['status'] = status;

    layer.open({
        type : 0,
        title : '是否提交？',
        btn: ['yes', 'no'],
        icon : 3,
        closeBtn : 2,
        content: "是否确定更改状态",
        scrollbar: true,
        yes: function(){
            // 执行相关跳转
            todelete(url, data);
        },

    });

});
/**
 * 推送JS相关
 */
$('#singcms-push').on('click',function(){
    var id = $('#select-push').val();
    if(!id){
        return dialog.error('请选择推荐位');
    }
    push={};
    postData={};
    $("input[name='pushcheck']:checked").each(function(i){
        push[i] = $(this).val();
    });
     postData['push']= push;
     postData['position_id']=id;
     //将获取到的数据post给服务器
    var url = SCOPE.push_url;
    $.post(url,postData,function(result){
            if(result.status==0){
                return dialog.error(result.message);
            }
            if(result.status==1){
                return dialog.success(result.message,window.location.href);
            }
    },'JSON');
});
