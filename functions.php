<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点 logo 地址'), _t('网站logo，如：/usr/themes/cym/img/logo.png'));
    $form->addInput($logoUrl);

    $faviconUrl = new Typecho_Widget_Helper_Form_Element_Text('faviconUrl', NULL, '/usr/themes/cym/img/favicon.ico', _t('站点 Favicon 地址'), _t('网站Favicon，如：/usr/themes/cym/img/favicon.ico'));
    $form->addInput($faviconUrl);

    $beianText = new Typecho_Widget_Helper_Form_Element_Text('beianText', NULL, NULL, _t('备案文本'), _t('备案文本，如：淦ICP备12345678号-3'));
    $form->addInput($beianText);
    $beianUrl = new Typecho_Widget_Helper_Form_Element_Text('beianUrl', NULL, NULL, _t('备案Url'), _t('点击备案号跳转到哪里，前面要加http，如：https://www.baidu.com'));
    $form->addInput($beianUrl);

    $runTime = new Typecho_Widget_Helper_Form_Element_Text('runTime', NULL, '2020-05-24 00:00:00', _t('站点建立时间'), _t('请按照时间格式修改：2020-05-24 00:00:00'));
    $form->addInput($runTime);
    
    // $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock', 
    // array('ShowRecentPosts' => _t('显示最新文章'),
    // 'ShowRecentComments' => _t('显示最近回复'),
    // 'ShowCategory' => _t('显示分类'),
    // 'ShowArchive' => _t('显示归档'),
    // 'ShowOther' => _t('显示其它杂项')),
    // array('ShowRecentPosts', 'ShowRecentComments', 'ShowCategory', 'ShowArchive', 'ShowOther'), _t('侧边栏显示'));
    // $form->addInput($sidebarBlock->multiMode());

    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock', 
    array(
        'ShowSearch' => _t('显示搜索框'),
        'ShowStats' => _t('显示统计框'),
        'ShowArchive' => _t('显示归档'),
        'ShowCategory' => _t('显示分类'),
        'ShowRecentPosts' => _t('显示最新文章'),
        'ShowRecentComments' => _t('显示最近回复'),
        'ShowOther' => _t('显示其它杂项')
    ),
    array('ShowSearch', 'ShowStats', 'ShowArchive', 'ShowCategory', 'ShowRecentPosts', 'ShowRecentComments'),
    _t('侧边栏显示'));
    $form->addInput($sidebarBlock->multiMode());

    $cymBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('cymBlock',
    array(
        'ShowRandomBg' => _t('显示随机动漫背景'),
        'ShowAcg' => _t('显示塑料玩具小人'),
        'SmoothScroll' => _t('页面平滑滚动'),
        'ShowTop' => _t('右侧显示返回顶部'),
        'ShowLoading' => _t('显示加载进度条'),
        'ForceHttps' => _t('强制HTTPS')
    ),
    array('ShowRandomBg', 'ShowAcg', 'SmoothScroll', 'ShowTop', 'ShowLoading', 'ForceHttps'),
    _t('主题配置'));
    $form->addInput($cymBlock->multiMode());
}

/**
 * 获取网站距今过了多久
 */
function getBuildTime($runTime) {
    $site_create_time = strtotime($runTime);
    $time = time() - $site_create_time;
    if (is_numeric($time)) {
        $value = array(
            "years" => 0, "days" => 0, "hours" => 0,
            "minutes" => 0, "seconds" => 0,
        );
        if ($time >= 31556926) {
            $value["years"] = floor($time / 31556926);
            $time = ($time % 31556926);
        }
        if ($time >= 86400) {
            $value["days"] = floor($time / 86400);
            $time = ($time % 86400);
        }
        if ($time >= 3600) {
            $value["hours"] = floor($time / 3600);
            $time = ($time % 3600);
        }
        if ($time >= 60) {
            $value["minutes"] = floor($time / 60);
            $time = ($time % 60);
        }
        $value["seconds"] = floor($time);

        echo (($value['years'] > 0) ? ($value['years'].'年') : '')
        .$value['days'].'天'
        //.$value['hours'].'小时'
        //.$value['minutes'].'分'
        ;
    } else {
        echo '';
    }
}

/**
 * 获取上次活跃时间
 */
function getLastPostTime() {
    $db = Typecho_Db::get();
    $create = $db->fetchRow($db->select('created')->from('table.contents')->limit(1)->order('created', Typecho_Db::SORT_DESC));
    // $update = $db->fetchRow($db->select('modified')->from('table.contents')->limit(1)->order('modified', Typecho_Db::SORT_DESC));
    
    echo Typecho_I18n::dateWord($create['created'], time());
    // echo Typecho_I18n::dateWord($update['modified'], time());
}

/**
 * 获取阅读次数
 */
function getPostCount($archive) {
    $cid    = $archive->cid;
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
        if (empty($views)) {
            $views = array();
        } else {
            $views = explode(',', $views);
        }
        if(!in_array($cid,$views)){
            $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views);

            $row['views']++;
        }
    }
    echo $row['views'];
}

/**
 * 获取阅读总数
 */
function getAllPostCount() {
    $db = Typecho_Db::get();
    $row = $db->fetchRow($db->select('sum(views) as s')->from('table.contents'));
    echo $row['s'];
}

/**
 * 页面加载开始计时
 */
function getTimerStart() {
	global $timestart;
	$mtime = explode(' ', microtime());
	$timestart = $mtime[1] + $mtime[0];
	return true;
}
getTimerStart();

/**
 * 获取页面加载耗时
 */
function getTimerEnd($precision = 3) {
	global $timestart, $timeend;
	$mtime     = explode( ' ', microtime() );
	$timeend   = $mtime[1] + $mtime[0];
	$timetotal = number_format($timeend - $timestart, $precision);
	$r = $timetotal < 1 ? $timetotal * 1000 . " ms" : $timetotal . " s";
	echo $r;
}