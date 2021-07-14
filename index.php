<?php
/**
 * 使用Typecho默认主题修改的主题
 * 
 * @package cym
 * @author cym
 * @version 0.27
 * @link https://cym.cm
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php');
 ?>

<div class="col-mb-12 col-8" id="main" role="main">
	<?php while($this->next()): ?>
        <article class="post blur">
			<h2 class="post-title"><a href="<?php $this->permalink() ?>"><?php $this->sticky(); $this->title(); ?></a></h2>
			<ul class="post-meta">
				<li><?php $this->date('Y/m/d H:i'); ?></li>
				<li><?php $this->commentsNum('评论(0)', '评论(1)', '评论(%d)'); ?></li>
				<li>阅读(<?php getPostCount($this)?>)</li>
			</ul>
            <div class="post-content" itemprop="articleBody">
    			<?php $this->content('- 阅读全文 -'); ?>
            </div>
        </article>
	<?php endwhile; ?>

    <?php $this->pageNav('&laquo; 上一页', '下一页 &raquo;'); ?>
</div><!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
