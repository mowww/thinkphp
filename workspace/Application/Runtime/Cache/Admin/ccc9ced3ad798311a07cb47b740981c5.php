<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>mowww后台管理平台</title>
    <!-- Bootstrap Core CSS -->
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/Public/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/Public/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/Public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/Public/css/sing/common.css" />
    <link rel="stylesheet" href="/Public/css/party/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/party/uploadify.css">

    <!-- jQuery -->
    <script src="/Public/js/jquery.js"></script>
    <script src="/Public/js/bootstrap.min.js"></script>
    <script src="/Public/js/dialog/layer.js"></script>
    <script src="/Public/js/dialog.js"></script>
    <script type="text/javascript" src="/Public/js/party/jquery.uploadify.js"></script>

</head>

    



<body>
<div id="wrapper">

  <?php
 $navs = D('Menu')->getAdminMenu(); $index = 'index'; ?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    
    <a class="navbar-brand" >mowwwcms内容管理平台</a>
  </div>
  <!-- Top Menu Items -->
  <ul class="nav navbar-right top-nav">
    
    
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo ($_SESSION['adminuser']['username']); ?> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li>
          <a href="/admin.php?c=admin&a=personal"><i class="fa fa-fw fa-user"></i> 个人中心</a>
        </li>
       
        <li class="divider"></li>
        <li>
          <a href="/admin.php?c=login&a=loginout"><i class="fa fa-fw fa-power-off"></i> 退出</a>
        </li>
      </ul>
    </li>
  </ul>
  <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav nav_list">

      <li <?php echo (getActive($index)); ?>>
        <a href="/admin.php"><i class="fa fa-fw fa-dashboard"></i> 首页</a>
      </li>
      <?php if(is_array($navs)): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><li <?php echo (getActive($nav["c"])); ?>>
            <a href="<?php echo (getAdminMenuUrl($nav)); ?>"><i class="fa fa-fw fa-bar-chart-o"></i><?php echo ($nav["name"]); ?></a>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
  </div>
  <!-- /.navbar-collapse -->
</nav>
  <div id="page-wrapper">

    <div class="container-fluid" >

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">

          <ol class="breadcrumb">
            <li>
              <i class="fa fa-dashboard"></i>  <a href="/admin.php?c=content">文章管理</a>
            </li>
            <li class="active">
              <i class="fa fa-table"></i>文章列表
            </li>
          </ol>
        </div>
      </div>
      <!-- /.row -->
      <div >
        <button  id="button-add" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>添加 </button>
      </div>
      <div class="row">
        <form action="/admin.php?c=content" method="get">
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-addon">栏目</span>
              <select class="form-control" name="catid">
                <option value='' >全部分类</option>
                <?php if(is_array($website)): $i = 0; $__LIST__ = $website;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><option value="<?php echo ($nav["menu_id"]); ?>" ><?php echo ($nav["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
            </div>
          </div>
          <input type="hidden" name="c" value="content"/>
          <input type="hidden" name="a" value="index"/>
          <div class="col-md-3">
            <div class="input-group">
              <input class="form-control" name="title" type="text" value="" placeholder="文章标题" />
                <span class="input-group-btn">
                  <button id="sub_data" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
          </div>
        </form>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <h3></h3>
          <div class="table-responsive">
            <form id="singcms-listorder">
              <table class="table table-bordered table-hover singcms-table">
                <thead >
                <tr >
                  <th id="singcms-checkbox-all" width="10" ><input type="checkbox"/></th>
                  <th width="14" class="text-center">排序</th>
                  <th class="text-center">id</th>
                  <th class="text-center">标题</th>
                  <th class="text-center">栏目</th>
                  <th class="text-center">来源</th>
                  <th class="text-center">封面图</th>
                  <th class="text-center">时间</th>
                  <th class="text-center">状态</th>
                  <th class="text-center">操作</th>
                </tr>
                </thead>
                <tbody class="text-center">
                  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$new): $mod = ($i % 2 );++$i;?><tr >
                        <td ><input type="checkbox" name="pushcheck" value="<?php echo ($new["news_id"]); ?>"></td>
                        <td><input size=4 type='text'  name='{listorder[<?php echo ($new["news_id"]); ?>]}' value="<?php echo ($new["listorder"]); ?>" class="text-center"/></td><!--6.7-->
                        <td ><?php echo ($new["news_id"]); ?></td>
                        <td><?php echo ($new["title"]); ?></td>
                        <td><?php echo (getCatName($website,$new["catid"])); ?></td>
                        <td><?php echo (getCopyFromById($new["copyfrom"])); ?></td>
                        <td>
                          <?php echo (isThumb($new["thumb"])); ?>
                        </td>
                        <td><?php echo (date("Y-m-d H:i",$new["create_time"])); ?></td>
                        <td><span  attr-status="<?php echo ($new["status"]); ?>"  attr-id="<?php echo ($new["status"]); ?>" class="sing_cursor singcms-on-off" id="singcms-on-off" ><?php echo (getNewStatus($new["status"])); ?></span></td>
                        <td><span class="sing_cursor glyphicon glyphicon-edit" aria-hidden="true" id="singcms-edit" attr-id="" ></span>
                          <a href="javascript:void(0)" id="singcms-delete"  attr-id=""  attr-message="删除">
                            <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                          </a>

                        </td>
                      </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                </tbody>
              </table>
              <nav>

              <ul >
                <?php echo ($pageRes); ?>
              </ul>

            </nav>
              <div>
                <button  id="button-listorder" type="button" class="btn btn-primary dropdown-toggle" ><span class="glyphicon glyphicon-resize-vertical" aria-hidden="true"></span>更新排序</button>
              </div>
            </form>
            <div class="input-group">
              <select class="form-control" name="position_id" id="select-push">
                <option value="0">请选择推荐位进行推送</option>
                <?php if(is_array($positions)): foreach($positions as $key=>$position): ?><option value="<?php echo ($position["id"]); ?>"><?php echo ($position["name"]); ?></option><?php endforeach; endif; ?>
              </select>
              <button id="singcms-push" type="button" class="btn btn-primary">推送</button>
            </div>

          </div>
        </div>

      </div>
      <!-- /.row -->



    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<script>
  var SCOPE = {
    'edit_url' : '/admin.php?c=content&a=edit',
    'add_url' : '/admin.php?c=content&a=add',
    'set_status_url' : '/admin.php?c=content&a=setStatus',
    'sing_news_view_url' : '/index.php?c=view',
    'listorder_url' : '/admin.php?c=content&a=listorder',
    'push_url' : '/admin.php?c=content&a=push',
  }
</script>
<script src="/Public/js/admin/common.js"></script>



</body>

</html>