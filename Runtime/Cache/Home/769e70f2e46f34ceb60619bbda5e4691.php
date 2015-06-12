<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<title><?php echo C('WEB_SITE_TITLE');?></title>
	<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="/Public/Home/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/Public/Home/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="/Public/Home/css/ace-fonts.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="/Public/Home/css/ace.min.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="/Public/Home/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="/Public/Home/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="/Public/Home/css/ace-ie.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="/Public/Home/css/ace.onpage-help.css" />

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="/Public/Home/js/html5shiv.js"></script>
		<script src="/Public/Home/js/respond.min.js"></script>
		<![endif]-->
		<script type="text/javascript" src='/Public/Home/js/bootstrap.min.js'></script>
	</head>
<!--<![endif]-->
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body>
	<!-- 头部 -->
	<!-- 导航条
================================================== -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?php echo U('index/index');?>">OneThink</a>
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <?php $__NAV__ = M('Channel')->field(true)->where("status=1")->order("sort")->select(); if(is_array($__NAV__)): $i = 0; $__LIST__ = $__NAV__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i; if(($nav["pid"]) == "0"): ?><li>
                            <a href="<?php echo (get_nav_url($nav["url"])); ?>" target="<?php if(($nav["target"]) == "1"): ?>_blank<?php else: ?>_self<?php endif; ?>"><?php echo ($nav["title"]); ?></a>
                        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <div class="nav-collapse collapse pull-right">
                <?php if(is_login()): ?><ul class="nav" style="margin-right:0">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:0;padding-right:0"><?php echo get_username();?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo U('User/profile');?>">修改密码</a></li>
                                <li><a href="<?php echo U('User/logout');?>">退出</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul class="nav" style="margin-right:0">
                        <li>
                            <a href="<?php echo U('User/login');?>">登录</a>
                        </li>
                        <li>
                            <a href="<?php echo U('User/register');?>" style="padding-left:0;padding-right:0">注册</a>
                        </li>
                    </ul><?php endif; ?>
            </div>
        </div>
    </div>
</div>

	<!-- /头部 -->
	
	<!-- 主体 -->
	
    <header class="jumbotron subhead" id="overview">
        <div class="container">
            <h2>源自相同起点，演绎不同精彩！</h2>
            <p class="lead"></p>
        </div>
    </header>

<div id="main-container" class="container">
    <div class="row">
        
<!-- 左侧 nav
================================================== -->
    <div class="span3 bs-docs-sidebar">
        <ul class="nav nav-list bs-docs-sidenav">
            <?php echo W('Category/lists', array(1, true));?>
        </ul>
    </div>

        
    <div class="span9">
        <!-- Contents
        ================================================== -->
        <section id="contents">
            <?php $__CATE__ = D('Category')->getChildrenId(1);$__LIST__ = D('Document')->page(!empty($_GET["p"])?$_GET["p"]:1,10)->lists($__CATE__, '`level` DESC,`id` DESC', 1,true); if(is_array($__LIST__)): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$article): $mod = ($i % 2 );++$i;?><div class="">
                    <h3><a href="<?php echo U('Article/detail?id='.$article['id']);?>"><?php echo ($article["title"]); ?></a></h3>
                </div>
                <div>
                    <p class="lead"><?php echo ($article["description"]); ?></p>
                </div>
                <div>
                    <span><a href="<?php echo U('Article/detail?id='.$article['id']);?>">查看全文</a></span>
                    <span class="pull-right">
                        <span class="author"><?php echo (get_username($article["uid"])); ?></span>
                        <span>于 <?php echo (date('Y-m-d H:i',$article["create_time"])); ?></span> 发表在 <span>
                        <a href="<?php echo U('Article/lists?category='.get_category_name($article['category_id']));?>"><?php echo (get_category_title($article["category_id"])); ?></a></span> ( 阅读：<?php echo ($article["view"]); ?> )
                    </span>
                </div>
                <hr/><?php endforeach; endif; else: echo "" ;endif; ?>

        </section>
    </div>

    </div>
</div>

<script type="text/javascript">
    $(function(){
        $(window).resize(function(){
            $("#main-container").css("min-height", $(window).height() - 343);
        }).resize();
    })
</script>
	<!-- /主体 -->

	<!-- 底部 -->
	
    <!-- 底部
    ================================================== -->
    <footer class="footer">
      <div class="container">
          <p> 本站由 <strong><a href="http://www.onethink.cn" target="_blank">OneThink</a></strong> 强力驱动</p>
      </div>
    </footer>

<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "", //当前网站地址
		"APP"    : "/index.php?s=", //当前项目地址
		"PUBLIC" : "/Public", //项目公共目录地址
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
})();
</script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>

	<!-- /底部 -->
</body>
</html>