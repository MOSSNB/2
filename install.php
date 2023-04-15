<?php

if (!file_exists(dirname(__FILE__) . '/config.inc.php')) {
    // site root path
    define('__TYPECHO_ROOT_DIR__', dirname(__FILE__));

    // plugin directory (relative path)
    define('__TYPECHO_PLUGIN_DIR__', '/usr/plugins');

    // theme directory (relative path)
    define('__TYPECHO_THEME_DIR__', '/usr/themes');

    // admin directory (relative path)
    define('__TYPECHO_ADMIN_DIR__', '/admin/');

    // register autoload
    require_once __TYPECHO_ROOT_DIR__ . '/var/Typecho/Common.php';

    // init
    \Typecho\Common::init();
} else {
    require_once dirname(__FILE__) . '/config.inc.php';
    $installDb = \Typecho\Db::get();
}

/**
 * get lang
 *
 * @return string
 */
function install_get_lang(): string
{
    $serverLang = \Typecho\Request::getInstance()->getServer('TYPECHO_LANG');

    if (!empty($serverLang)) {
        return $serverLang;
    } else {
        $lang = 'zh_CN';
        $request = \Typecho\Request::getInstance();

        if ($request->is('lang')) {
            $lang = $request->get('lang');
            \Typecho\Cookie::set('lang', $lang);
        }

        return \Typecho\Cookie::get('lang', $lang);
    }
}

/**
 * get site url
 *
 * @return string
 */
function install_get_site_url(): string
{
    $request = \Typecho\Request::getInstance();
    return install_is_cli() ? $request->getServer('TYPECHO_SITE_URL', 'http://localhost') : $request->getRequestRoot();
}

/**
 * detect cli mode
 *
 * @return bool
 */
function install_is_cli(): bool
{
    return \Typecho\Request::getInstance()->isCli();
}

/**
 * get default router
 *
 * @return string[][]
 */
function install_get_default_routers(): array
{
    return [
        'index'              =>
            [
                'url'    => '/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'archive'            =>
            [
                'url'    => '/blog/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'do'                 =>
            [
                'url'    => '/action/[action:alpha]',
                'widget' => '\Widget\Action',
                'action' => 'action',
            ],
        'post'               =>
            [
                'url'    => '/archives/[cid:digital]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'attachment'         =>
            [
                'url'    => '/attachment/[cid:digital]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'category'           =>
            [
                'url'    => '/category/[slug]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'tag'                =>
            [
                'url'    => '/tag/[slug]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'author'             =>
            [
                'url'    => '/author/[uid:digital]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'search'             =>
            [
                'url'    => '/search/[keywords]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'index_page'         =>
            [
                'url'    => '/page/[page:digital]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'archive_page'       =>
            [
                'url'    => '/blog/page/[page:digital]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'category_page'      =>
            [
                'url'    => '/category/[slug]/[page:digital]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'tag_page'           =>
            [
                'url'    => '/tag/[slug]/[page:digital]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'author_page'        =>
            [
                'url'    => '/author/[uid:digital]/[page:digital]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'search_page'        =>
            [
                'url'    => '/search/[keywords]/[page:digital]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'archive_year'       =>
            [
                'url'    => '/[year:digital:4]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'archive_month'      =>
            [
                'url'    => '/[year:digital:4]/[month:digital:2]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'archive_day'        =>
            [
                'url'    => '/[year:digital:4]/[month:digital:2]/[day:digital:2]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'archive_year_page'  =>
            [
                'url'    => '/[year:digital:4]/page/[page:digital]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'archive_month_page' =>
            [
                'url'    => '/[year:digital:4]/[month:digital:2]/page/[page:digital]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'archive_day_page'   =>
            [
                'url'    => '/[year:digital:4]/[month:digital:2]/[day:digital:2]/page/[page:digital]/',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'comment_page'       =>
            [
                'url'    => '[permalink:string]/comment-page-[commentPage:digital]',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
        'feed'               =>
            [
                'url'    => '/feed[feed:string:0]',
                'widget' => '\Widget\Archive',
                'action' => 'feed',
            ],
        'feedback'           =>
            [
                'url'    => '[permalink:string]/[type:alpha]',
                'widget' => '\Widget\Feedback',
                'action' => 'action',
            ],
        'page'               =>
            [
                'url'    => '/[slug].html',
                'widget' => '\Widget\Archive',
                'action' => 'render',
            ],
    ];
}

/**
 * list all default options
 *
 * @return array
 */
function install_get_default_options(): array
{
    static $options;

    if (empty($options)) {
        $options = [
            'theme' => 'default',
            'theme:default' => 'a:2:{s:7:"logoUrl";N;s:12:"sidebarBlock";a:5:{i:0;s:15:"ShowRecentPosts";i:1;s:18:"ShowRecentComments";i:2;s:12:"ShowCategory";i:3;s:11:"ShowArchive";i:4;s:9:"ShowOther";}}',
            'timezone' => '28800',
            'lang' => install_get_lang(),
            'charset' => 'UTF-8',
            'contentType' => 'text/html',
            'gzip' => 0,
            'generator' => 'Typecho ' . \Typecho\Common::VERSION,
            'title' => 'Hello World',
            'description' => 'Your description here.',
            'keywords' => 'typecho,php,blog',
            'rewrite' => 0,
            'frontPage' => 'recent',
            'frontArchive' => 0,
            'commentsRequireMail' => 1,
            'commentsWhitelist' => 0,
            'commentsRequireURL' => 0,
            'commentsRequireModeration' => 0,
            'plugins' => 'a:0:{}',
            'commentDateFormat' => 'F jS, Y \a\t h:i a',
            'siteUrl' => install_get_site_url(),
            'defaultCategory' => 1,
            'allowRegister' => 0,
            'defaultAllowComment' => 1,
            'defaultAllowPing' => 1,
            'defaultAllowFeed' => 1,
            'pageSize' => 5,
            'postsListSize' => 10,
            'commentsListSize' => 10,
            'commentsHTMLTagAllowed' => null,
            'postDateFormat' => 'Y-m-d',
            'feedFullText' => 1,
            'editorSize' => 350,
            'autoSave' => 0,
            'markdown' => 1,
            'xmlrpcMarkdown' => 0,
            'commentsMaxNestingLevels' => 5,
            'commentsPostTimeout' => 24 * 3600 * 30,
            'commentsUrlNofollow' => 1,
            'commentsShowUrl' => 1,
            'commentsMarkdown' => 0,
            'commentsPageBreak' => 0,
            'commentsThreaded' => 1,
            'commentsPageSize' => 20,
            'commentsPageDisplay' => 'last',
            'commentsOrder' => 'ASC',
            'commentsCheckReferer' => 1,
            'commentsAutoClose' => 0,
            'commentsPostIntervalEnable' => 1,
            'commentsPostInterval' => 60,
            'commentsShowCommentOnly' => 0,
            'commentsAvatar' => 1,
            'commentsAvatarRating' => 'G',
            'commentsAntiSpam' => 1,
            'routingTable' => serialize(install_get_default_routers()),
            'actionTable' => 'a:0:{}',
            'panelTable' => 'a:0:{}',
            'attachmentTypes' => '@image@',
            'secret' => \Typecho\Common::randString(32, true),
            'installed' => 0,
            'allowXmlRpc' => 2
        ];
    }

    return $options;
}

/**
 * get database driver type
 *
 * @param string $driver
 * @return string
 */
function install_get_db_type(string $driver): string
{
    $parts = explode('_', $driver);
    return $driver == 'Mysqli' ? 'Mysql' : array_pop($parts);
}

/**
 * list all available database drivers
 *
 * @return array
 */
function install_get_d
