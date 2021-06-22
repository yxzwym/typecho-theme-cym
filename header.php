<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- 设置语言为中文 -->
    <meta http-equiv="Content-Language" content="zh-CN" />
    <title>
    <?php
        if($this->is('index')) {
            $this->options->title();
        } else {
            $this->archiveTitle(array(
                'category'  =>  _t('分类 %s 下的文章'),
                'search'    =>  _t('包含关键字 %s 的文章'),
                'tag'       =>  _t('标签 %s 下的文章'),
                'author'    =>  _t('%s 发布的文章')
            ), '', '');
        }
    ?>
    </title>

    <!-- <?php $this->options->title(); ?> -->

    <!-- 使用url函数转换相关路径 -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('normalize.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('grid.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>">

    <!--[if lt IE 10]>
    <script src="https://cdn.staticfile.org/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header(); ?>

    <?php if (!empty($this->options->cymBlock) && in_array('ForceHttps', $this->options->cymBlock)): ?>
    <!-- 强制https -->
    <script>
        var targetProtocol = "https:"
        if (window.location.protocol != targetProtocol) {
            window.location.href = targetProtocol + window.location.href.substring(window.location.protocol.length)
        }
    </script>
    <?php endif; ?>

    <?php if ($this->options->faviconUrl): ?>        
    <!-- 设置favicon -->
    <link rel="shortcut icon" href="<?php $this->options->faviconUrl() ?>" type="image/x-icon" />
    <?php endif; ?>
    
</head>
<body>
<!--[if lt IE 10]>
    <div class="browsehappy" role="dialog"><?php _e('当前网页 <strong>不支持</strong> 你正在使用的浏览器. 至少需要 <strong>IE10</strong>. 为了正常的访问, 请使用 <a href="https://www.google.com/chrome/" target="_blank">Chrome</a> <a href="https://www.mozilla.org/zh-CN/firefox/new/?redirect_source=firefox-com" target="_blank">Firefox</a> <a href="https://www.microsoft.com/zh-cn/edge" target="_blank">Edge</a>'); ?>.</div>
<![endif]-->

<!-- #pjax -->
<div id="pjax">
<header id="header" class="clearfix blur">
    <div class="container">
        <!-- 站点logo -->
        <div id="site-name">
        <?php if ($this->options->logoUrl): ?>
            <a id="logo" href="<?php $this->options->siteUrl(); ?>">
                <img src="<?php $this->options->logoUrl() ?>" alt="<?php $this->options->title() ?>" />
            </a>
        <?php else: ?>
            <a id="logo" href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a>
            <!-- <p class="description"><?php $this->options->description() ?></p> -->
        <?php endif; ?>
        </div>
        <!-- 站点导航栏 -->
        <nav id="nav-menu">
            <a<?php if($this->is('index')): ?> class="current"<?php endif; ?> href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
            <?php while($pages->next()): ?>
            <a<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
            <?php endwhile; ?>
        </nav>
    </div>
</header><!-- end #header -->
<div id="body">
    <div class="container">
        <div class="row">

    
    
