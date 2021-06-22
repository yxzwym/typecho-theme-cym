<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="col-mb-12 col-8" id="main" role="main">
    <article class="post blur" itemscope itemtype="http://schema.org/BlogPosting">
        <h1 class="post-title" itemprop="name headline"><a itemprop="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h1>
        <ul class="post-meta">
            <li><?php $this->date('Y/m/d H:i'); ?></li>
            <li><?php $this->commentsNum('评论(0)', '评论(1)', '评论(%d)'); ?></li>
            <li>阅读(<?php getPostCount($this)?>)</li>
        </ul>
        <div class="post-content" itemprop="articleBody">
            <!-- 替换成灯箱图片 -->
            <?php
                $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
                $replacement = '<a href="$1" data-fancybox="gallery" /><img src="' . $this->options->themeUrl . "/img/loading.gif" . '" data-original="$1" alt="'.$this->title.'" title="点击放大图片"></a>';
                $content = preg_replace($pattern, $replacement, $this->content);
                echo $content;
            ?>
        </div>
        <p itemprop="keywords" class="tags"><?php _e('标签: '); ?><?php $this->tags(', ', true, 'none'); ?></p>
    </article>

    <?php $this->need('comments.php'); ?>

    <ul class="post-near blur">
        <li>上一篇: <?php $this->thePrev('%s','没有了'); ?></li>
        <li>下一篇: <?php $this->theNext('%s','没有了'); ?></li>
    </ul>
</div><!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
