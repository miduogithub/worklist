<?php

/*
 *   strong 2017.04.11
 *
 * 我们致力于为每一位用户, 打造独立个性的产品, 提升用户体验, 让你的网站更加的接近 Web 2.0 标准.
 *
 * QQ:  695023684
 * Email: 695023684@qq.com
 * Http://www.365jiqiao.com/demo/say

 *
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}



//语言, 如修改注意标点符号

$lang = array(    
	'guide_digest' => '最新精华',
	'guide_new' => '最新回复',
	'guide_newthread' => '最新发布',
	'guide_hot'=>'热门',
    'post'=>'发帖',
    'sorry'=>'抱歉',
	'find'=>'发现',
    'triumph'=>'获&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;胜',
    'selectforum'=>'选择发帖版块',
	'credit' =>'积分',
	'home' => '首页',
	'forum' => '论坛',
	'group' => '群组',    
	'guide' => '导读',
    'message'=>'消息',
    'new_message'=>'新消息',    
    'my'=>'我的',
	'mygroup' => '我的群组',
	'joingroup'=> '加入群组',
	'group_exit'=>'退出群组',
	'mygroup'=>'我的群组',
	'nogroup'=>'您还没有创建过群组，请用电脑访问创建',
	'nojoingroup' => '您需要加入该群组才能正常访问',
	'jianjie'=>'简介',
	'chengyuan'=>'成员',
	'paiming'=>'排名',
    'loading'=>'加载中...',
    'loadingend'=>'已经到底了',
	'shequjiaodian' => '社区焦点',
	'rementupian' => '热门图片',
	'zuixinfabu' => '最新发布',
	'zuixinhuifu' => '最新回复',
	'zuixinremen' => '最新热门',
	'jingcaituijian' => '精彩推荐',
	'searchgroupt'=>'搜索帖子',
	'pic' => '美图',
    'selectimg'=>'选择图片',
	'classify' =>'分类信息',
	'mdoing' => '记录',
	'mfollow' => '广播',
	'mfriend' => '好友',
    'tafriend'=>'Ta的好友',
    'taposts'=>'Ta的帖子',
    'tareply'=>'Ta的回复',
    'taprofile'=>'Ta的资料',
	'pindao' => '频道',
	'mfriendall' => '全部',
	'latest' => '最新',
	'order_heats' => '热门',
	'hot_thread' => '热帖',
	'digest_posts' => '精华',
    'special_top'=>'置顶',
    'special_digest'=>'精华',
    'special_activity'=>'活动',
    'special_pic'=>'有图',
    'special_poll'=>'投票',
    'special_reward'=>'悬赏',
    'special_trade'=>'商品',
	'gengduo' => '更多',
	'shouqi' => '收起',
	'stop'=>'↑',
	'mfriendol' => '在线好友',
	'mfriendbl' => '黑名单',
	'mfriendrq' => '好友请求',
	'mfriendprofile' => '资料',
	'mfriendgroup' => '分组',
	'mblog' => '日志',
	'mfeed' => '动态',
	'photo' => '相册',
	'more' => '更多',
	'fup' => '上级',
	'flist' => '列表',
	'plist' => '所在频道',
	'res' => '刷新',
	'scroll_top'=>'▲',
	'load' => '加载更多...',
	'load_pic' => '拼命加载中...',
	'load_nopic' => '没有更多内容了',
	'newth' => '新帖',
	'dfth' => '默认',
	'subfrm' => '子版块',
	'thtys' => '分类',
	'othtys' => '展开分类',
	'pta' => '发表于',
	'reply' => '发表回复',
	'srp' => '查看回复',
	'rcom' => '发表评论',
	'acom' => '查看评论',
    'activity_endtime'=>'结束时间',
	'opt' => '选填',
	'od' => '条',
	'de' => '的',
	'tt' => '共有',
    'today'=>'今日',
    'nocomment'=>'暂无评论',
	'thread' => '主题',        
	'posts'=>'贴数',
	'reply' => '回复',
	'replyta'=>'回复TA',
	'views' => '查看',
	'chakanziliao'=>'查看资料',
	'tianjiahaoyou'=>'添加好友',
	'faxiaoxi'=>'发消息',
	'tietu' => '贴图',
	'mods' => '管理',
	'nomessage' => '此贴无文字内容',
	'mthread' => '帖子',
	'mforum' => '版块',
	'profile' => '个人资料',
	'mycenter' => '个人中心',
	'tuchuang' => '图床',
	'profilet' => '资料',
	'bankuaishoucang' => '板块收藏',
	'chakanxiaoxi' => '查看消息',
	'wodezhuti' => '我的主题',
	'favorite' => '我的收藏',
	'mypm' => '我的消息',
	'psubject' => '帖子标题',
	'arc' => '文章',
	'lz' => '楼主',
    'lou'=>'楼',
    'rzg'=>'人赞过',
	'kanlouzhu' => '只看楼主',
	'kanquanbu' => '看全部',
	'cldate' => '日期格式:2010-12-01 10:50',
	'pcf' => '重复',
	'back' => '返回',
	'search' => $_GET['mod']=='portal' ? '搜索文章' : ($_GET['mod']=='forum' ? '搜索帖子' : '搜索'),
	'searchtext' => '输入搜索的关键字',
    'search_forum'=>'搜索帖子',
    'search_portal'=>'搜索文章',
	'wenzhangshoucang' => '收藏文章',
	'4hr' => '4小时',
	'24hr' => '24小时',
	'168hr' => '一周',
	'720hr' => '一月',
	'new_remind' => '有新提醒',
	'remind' => '提醒',
	'xiaoxi' => '消息',
	'new_xiaoxi' => '有新消息',
	'gerenzhongxin' => '个人中心', 
	'mefriend_doing' => '我和好友',
	'tishi'=> '提示',
	'friend_feed' => '好友动态',
	'wenzhang' => '门户',
	'tupianqiang' => '图片瀑布流',
	'wodezhuti' => '我的主题',
	'zhutishouchang' => '主题收藏',
	'wodezilaio' => '我的资料',
	'wodexiaoxi' => '我的消息',
	'wodehaoyou' => '我的好友',
	'nuwcomment' => '最新评论',
	'qiangshafa' => '抢沙发',
	'fanhuidingbu' => '返回顶部↑',
	'fanhuiliebiao' => '返回列表',
	'postnewthread'=>'发布新帖',
	'biaoqian' => '标签',
	'dengru' => '登入',
	'qqdengru' => 'QQ登入',
	'dengruzhongxin' => '登入中心',
	'tuichu' => '退出',
	'zuixin' => '最新',
	'remen' => '热门',
	'retie' => '热帖',
	'jinghua' => '精华',
	'zuixinremen' => '最新热门',
	'zuixinjinghua' => '最新精华',
	'zuixinfabu' => '最新发布',
	'fabuyu' => '发布于',
	'touch' => '触屏版',
	'tthread' => '正文',
	'butubukuai' => '不吐不快！',
	'kuaijie' => '快捷>>',
    'title'=>'标题',
	'zhutil' => '主题：',
	'paimingl' => '排名：',
	'zhengxu' =>'正序',
	'daoxu' => '倒序',
	'loginaq' => '安全提问?',
	'nosearch' => '暂无',
	'gohome' => '返回首页',
	'regmes' => '原因',
	'upload_pic' => '上传图片',
	'reg' => '注册',
	'zhucezhongxin' =>'注册中心',
	'qq' => '登录',
	'noid' => '没有账号?',
	'yesid' => '已有账号?',
	'yuehot' => '本月热帖',
	'zhuohot' => '本周热帖',
	'shoucang' => '收藏',
	'paixu' => '排序',
	'hotforum' => '热门板块',
	'hottz' => '热门帖子',
	'username' => '账号',
	'jingcaituijian' => '推荐主题',
	'zuixinfabu' =>'最新发布',
	'pc'=>'电脑板',
	'gonggao'=> '公告：',
	'querenshangpin'=> '确认商品',
	'xinwen' => '新闻',
	'guonei' => '国内',
	'guoji' => '国际',
	'shishi' => '实事',
	'shequ' => '社区',	
	'jinrupindao' => '进入频道',
	'shequjiaodian' => '社区焦点',
	'rementupian' => '热门图片',
	'zuixinfabu' => '最新发布',
	'zhutituijian' => '主题推荐',
	'tuijianbankuai' => '板块推荐',
	'shijian'=>'时间',
	'jieshushijian'=>'结束时间',
	'qzzlsrbt' => '请输入标题',
	'qzzlsrnr' => '请输入内容',
	'bitianxiangmumeiyoutianxie'=>'必填项目没有填写',
	'tianxiedexiangmuchangduguochang'=>'填写项目长度过长',
	'shuzitianxiebuzhengque'=>'数字填写不正确',
	'dayushezhidezuidazhi'=>'大于设置最大值',
	'xiaoyushezhidezuidazhi'=>'小于设置最小值',
	'youjiangeshibuzhengque'=>'邮件地址不正确',
	'urlbuzhengque'=>'请正确填写以http://开头的URL地址',
	'qingxuanzexiayiji'=>'请选择下一级',
	'qingxuanze'=>'请选择',
	'fxdpyq' => '请点击微信右上角分享到朋友圈',
	'weixin' => '微信',
	'share' => '分享',
	'shangyizhuti'=>'上一主题',
	'xiayizhuti'=>'下一主题',
	'huifuchenggong'=>'回复成功',
	'xiaoxifasongchenggong'=>'消息发送成功',
	'haoyouliebiao'=>'好友列表',
	'zaixiandehaoyou'=>'在线好友',
	'zaixianyonghu'=>'在线用户',
	'haoyouqingqiu'=>'好友请求',
	'shanchuhaoyou'=>'删除好友',
	'tadepengyou'=>'TA的朋友',
	'tadezhuti'=>'TA的主题',
	'tadeziliao'=>'TA的资料',
    'space_threadthread'=>'的帖子',
    'space_threadreply'=>'的回复',
    'space_profile'=>'的资料',
    'space_friend'=>'的好友',
    'myspace_threadthread'=>'我的帖子',
    'myspace_threadreply'=>'我的回复',
    'myspace_profile'=>'我的资料',
    'myspace_friend'=>'我的好友',
    'mythread'=>'我的帖子',
    'myreply'=>'我的回复',
    'myprofile'=>'我的资料',
    'myfriend'=>'我的好友',    
	'xiaoxiliebiao'=>'消息列表',
	'xiaoxixiangqing'=>'消息详情',
	'fuyan'=>'附言',
	'zaixian'=>'[在线]',
	'zhiding'=>'置顶',
    'setanswer'=>'您确认要把该回复选为“最佳答案”吗？',
	'Scorereasons' => '填写评分理由',
	'all_comment' => '全部评论',
	'tourist_nopermission_login' => '<div style="margin:10px 0;border: 1px dashed #DDDDC2; background: #FFFFDC;font-size: 13px;
    padding: 13px;"><p style="color: #8CA226; font-size: 15px; display: block;    
    margin-bottom: 8px;">您需要<a href="member.php?mod=logging&action=login" style=" color: #3e86ce;margin: 0 7px;">登录</a>才可以下载或查看附件。</div>',
   'search_result_keyword'=>"一共$index[num]条结果",
   'cancel_share'=>'取消分享',
   'weixin_share_text1'=>'打开浏览器分享功能，点[微信好友]<br>分享给你的好友'

    );



?>
