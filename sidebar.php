<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="col-mb-12 col-offset-1 col-3 kit-hidden-tb" id="secondary" role="complementary">

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowSearch', $this->options->sidebarBlock)): ?>
    <!-- 搜索框 -->
    <section class="widget blur">
        <form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
            <label for="s" class="sr-only"><?php _e('搜索关键字'); ?></label>
            <input type="text" id="s" name="s" class="text" placeholder="<?php _e('输入关键字搜索'); ?>" />
            <button type="submit" class="submit"><?php _e('搜索'); ?></button>
        </form>
    </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowStats', $this->options->sidebarBlock)): ?>
    <!-- 统计框 -->
    <section class="widget blur">
        <?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
		<h3 class="widget-title"><?php _e('统计'); ?></h3>
        <ul class="widget-list">
            <li><span class="sidebar-left">文章数目</span><span class="sidebar-right"><?php $stat->publishedPostsNum(); ?></span></li>
            <li><span class="sidebar-left">评论数目</span><span class="sidebar-right"><?php $stat->publishedCommentsNum(); ?></span></li>
            <li><span class="sidebar-left">阅读总数</span><span class="sidebar-right"><?php getAllPostCount(); ?></span></li>
            <li><span class="sidebar-left">运行时长</span><span class="sidebar-right"><?php getBuildTime($this->options->runTime); ?></span></li>
            <li><span class="sidebar-left">最后活动</span><span class="sidebar-right"><?php getLastPostTime(); ?></span></li>
            <li><span class="sidebar-left">加载耗时</span><span class="sidebar-right"><?php getTimerEnd(); ?></span></li>
        </ul>
    </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
    <!-- 分类框 -->
    <section class="widget blur">
		<h3 class="widget-title"><?php _e('分类'); ?></h3>
        <ul class="widget-list">
            <?php $this->widget('Widget_Metas_Category_List')
            ->parse('<li><span class="sidebar-left"><a href="{permalink}">{name}</a></span><span class="sidebar-right">{count}</span></li>'); ?>
        </ul>
	</section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowArchive', $this->options->sidebarBlock)): ?>
    <!-- 归档框 -->
    <section class="widget blur">
		<h3 class="widget-title"><?php _e('归档'); ?></h3>
        <ul class="widget-list">
            <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y年n月')
            ->parse('<li><span class="sidebar-left"><a href="{permalink}">{date}</a></span><span class="sidebar-right">{count}</span></li>'); ?>
        </ul>
	</section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
    <section class="widget blur">
		<h3 class="widget-title"><?php _e('最新文章'); ?></h3>
        <ul class="widget-list">
            <?php $this->widget('Widget_Contents_Post_Recent')
            ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
        </ul>
    </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
    <section class="widget blur">
		<h3 class="widget-title"><?php _e('最近回复'); ?></h3>
        <ul class="widget-list">
        <?php $this->widget('Widget_Comments_Recent')->to($comments); ?>
        <?php while($comments->next()): ?>
            <li><a href="<?php $comments->permalink(); ?>"><?php $comments->author(false); ?></a>: <?php $comments->excerpt(35, '...'); ?></li>
        <?php endwhile; ?>
        </ul>
    </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowOther', $this->options->sidebarBlock)): ?>
	<section class="widget blur">
		<h3 class="widget-title"><?php _e('其它'); ?></h3>
        <ul class="widget-list">
            <li><a href="<?php $this->options->feedUrl(); ?>"><?php _e('文章 RSS'); ?></a></li>
            <li><a href="<?php $this->options->commentsFeedUrl(); ?>"><?php _e('评论 RSS'); ?></a></li>
        </ul>
	</section>
    <?php endif; ?>

</div><!-- end #sidebar -->
