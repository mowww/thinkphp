/* 
*前端登录业务类
* @Author: wuweiwei
* @Date:   2016-08-06 17:12:37
* @Last Modified by:   wuweiwei
* @Last Modified time: 2016-08-08 14:15:06
*/

var login = {

    check: function (){
        //jq获取界面中的用户名、密码
        var username = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();
        if(!username){
            dialog.error('用户名不能为空！');
        }
         if(!password){
            dialog.error('密码不能为空！');
        }
         //执行异步请求
        var url = "/admin.php?c=Login&a=Check";
        var data = {'username':username,'password':password} ;
        $.post(url,data,function(result){
            if(result.status==0){
                dialog.error(result.message);
            }
            else if(result.status==1){
                dialog.success('登录成功！','/admin.php?c=Login');
            }
        },'JSON');
            }

    }
