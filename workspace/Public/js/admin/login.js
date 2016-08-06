/* 
*前端登录业务类
* @Author: wuweiwei
* @Date:   2016-08-06 17:12:37
* @Last Modified by:   wuweiwei
* @Last Modified time: 2016-08-06 17:52:21
*/

var login = {

    check: function (){
        //jq获取界面中的用户名、密码
        var username = $('input[name="username"]').val();
        var password = $('input[name="inputPassword"]').val();
        //执行异步请求
        var url="/index?m=Admin&c=index&a=login";
        var data={'username':username,password='password'} ;
        $.post(url,data,function(result){
                alert("11111");
        });
    }
}