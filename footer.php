<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

        </div><!-- end .row -->
    </div>
</div><!-- end #body -->

</div><!-- end #pjax -->

<footer id="footer" role="contentinfo" class="blur">
    &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.
    Powered by <a href="http://www.typecho.org" target="_blank">Typecho</a>.
    Theme by <a href="https://github.com/AmineTsai/TypechoCym" target="_blank">cym</a>
    <?php if ($this->options->beianText): ?>    
    <br/>
    <a href="<?php $this->options->beianUrl() ?>" target="_blank"><?php $this->options->beianText() ?></a>
    <?php endif; ?>
</footer><!-- end #footer -->

<?php $this->footer(); ?>

<!-- jQuery -->
<script src="https://cdn.staticfile.org/jquery/3.5.1/jquery.min.js"></script>
<!-- 代码高亮 -->
<script src="<?php $this->options->themeUrl('js/prism.js'); ?>"></script>
<link rel="stylesheet" href="<?php $this->options->themeUrl('css/coy.css'); ?>" />
<!-- 灯箱 -->
<link rel="stylesheet" href="https://cdn.staticfile.org/fancybox/3.5.7/jquery.fancybox.min.css">
<script src="https://cdn.staticfile.org/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<!-- 图片懒加载 -->
<script src="https://cdn.staticfile.org/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>
<?php if (!empty($this->options->cymBlock) && in_array('SmoothScroll', $this->options->cymBlock)): ?>
<!-- 平滑滚动 -->
<script src="https://cdn.staticfile.org/smoothscroll/1.4.9/SmoothScroll.min.js"></script>
<?php endif; ?>
<?php if (!empty($this->options->cymBlock) && in_array('ShowAcg', $this->options->cymBlock)): ?>
<!-- 塑料玩具小人 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css"/>
<script src="https://cdn.jsdelivr.net/gh/stevenjoezhang/live2d-widget/autoload.js"></script>
<?php endif; ?>
<!-- 加载进度条 -->
<?php if (!empty($this->options->cymBlock) && in_array('ShowLoading', $this->options->cymBlock)): ?>
<script src='https://cdn.staticfile.org/nprogress/0.2.0/nprogress.min.js'></script>
<link rel='stylesheet' href='https://cdn.staticfile.org/nprogress/0.2.0/nprogress.min.css'/>
<script>
    $(document).on('pjax:start', function() { NProgress.start(); });
    $(document).on('pjax:end',   function() { NProgress.done();  });
</script>
<?php endif; ?>
<!-- pjax -->
<script src="https://cdn.staticfile.org/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
<script>
    // pjax加载完之后的刷新操作
    $(document).on('pjax:complete', function() {
        // 重载代码显示插件
        if (typeof Prism !== 'undefined') {
            // 显示行号
            showCodeLineRowNum()
            // 高亮代码
            Prism.highlightAll(true,null)
        }
        // 图片懒加载
        $("img").lazyload({
            threshold: 100,
            effect: "fadeIn"
        })
    })

    // 点击a标签
    $(document).pjax('a', {
        container: '#pjax',
        fragment: '#pjax',
        timeout: 6000
    })
    
    // 表单使用pjax
    $(document).on('submit', 'form', function(event) {
        $.pjax.submit(event, '#pjax', {
            fragment:'#pjax', timeout:6000
        })
    })
</script>

<?php if (!empty($this->options->cymBlock) && in_array('ShowRandomBg', $this->options->cymBlock)): ?>
<!-- 背景 -->
<div id="body-background-1" class="body-background"></div>
<div id="body-background-2" class="body-background"></div>
<!-- 背景自动更换 -->
<script>
    // 手机省流量，不加载背景
    var ua = navigator.userAgent
    var ipad = ua.match(/(iPad).*OS\s([\d_]+)/)
    var isIphone =!ipad && ua.match(/(iPhone\sOS)\s([\d_]+)/)
    var isAndroid = ua.match(/(Android)\s+([\d.]+)/)
    var isMobile = isIphone || isAndroid

    // if (false) {
    if (!isMobile) {
        
        var opacity = 0.3// 透明度，越低越看不见图片
        var flag = 0

        // 两张背景淡入淡出切换
        function fadeBackground() {
            $("#body-background-1").css("opacity", flag? opacity : "0")
            $("#body-background-2").css("opacity", flag? "0" : opacity)
            flag = +!flag
        }

        // 提前预加载另一张图片
        function changeBackground() {
            $.ajax({
                url: 'https://api.btstu.cn/sjbz/?lx=dongman&format=json',
                method: 'get',
                success: function(res) {
                    console.log(res.imgurl)
                    if (flag == 0) {
                        $("#body-background-2").css("background", "url(" + res.imgurl + ")")
                    } else {
                        $("#body-background-1").css("background", "url(" + res.imgurl + ")")
                    }
                }
            })
        }

        var bg_interval_1 = setInterval(fadeBackground, 10000)
        var bg_interval_2
        var bg_timeout = setTimeout(function() {
            bg_interval_2 = setInterval(changeBackground, 10000)
            changeBackground()
        }, 5000);// 这个;不能省略

        // 第一次一打开加载第一张图
        (function() {
            $.ajax({
                url: 'https://api.btstu.cn/sjbz/?lx=dongman&format=json',
                method: 'get',
                success: function(res) {
                    console.log(res.imgurl)
                    $("#body-background-1").css("background", "url(" + res.imgurl + ")")
                    $("#body-background-1").css("opacity", opacity)
                    $("#body-background-2").css("opacity", "0")
                }
            })
        })()

        // 省流量，标签进入后台后，停止背景的加载
        document.addEventListener('visibilitychange', function() {
            // 先清掉之前的计时，防止触发多次导致切换背景变快
            clearInterval(bg_interval_1)
            clearInterval(bg_interval_2)
            clearTimeout(bg_timeout)

            var isHidden = document.hidden
            if (!isHidden) {
                // 从后台回来后，重新加载背景
                bg_interval_1 = setInterval(fadeBackground, 10000)
                bg_timeout = setTimeout(function() {
                    bg_interval_2 = setInterval(changeBackground, 10000)
                    changeBackground()
                }, 5000)
            }
        })
    }
</script>
<?php endif; ?>

<script type="text/javascript">
    /**
     * 显示行号
     */
    function showCodeLineRowNum() {
        var pres = document.querySelectorAll('pre')
        var lineNumberClassName = 'line-numbers'
        for (var i = 0; i < pres.length; i++) {
            pres[i].className = pres[i].className == '' ? lineNumberClassName : pres[i].className + ' ' + lineNumberClassName
        }
    }
	showCodeLineRowNum();
</script>

<!-- 灯箱 -->
<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox();
    });
</script>

<!-- 图片懒加载 -->
<script type="text/javascript">
    $("img").lazyload({
        threshold: 100,
        effect: "fadeIn"
    });
</script>

<?php if (!empty($this->options->cymBlock) && in_array('ShowTop', $this->options->cymBlock)): ?>
<!-- 返回顶部 -->
<div id="back-to-top"></div>
<script>
    $(function() {
        $(window).scroll(function() {
            if ($(window).scrollTop() > 500) {
                $('#back-to-top').css('top', '-100px')
            } else {
                $('#back-to-top').css('top', '-800px')
            }
        })
        $('#back-to-top').click(function() {
            $('body,html').animate({
                scrollTop: 0
            }, 600);
        })
    })
</script>
<?php endif; ?>

</body>
</html>
