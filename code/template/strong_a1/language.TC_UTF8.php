<?php

/*
 *   strong 2017.04.11
 *
 * 我們致力於為每壹位用戶, 打造獨立個性的產品, 提升用戶體驗, 讓妳的網站更加的接近 Web 2.0 標準.
 *
 * QQ:  695023684
 * Email: 695023684@qq.com
 * Http://www.365jiqiao.com/demo/say

 *
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}



//語言, 如修改註意標點符號

$lang = array(    
	'guide_digest' => '最新精華',
	'guide_new' => '最新回復',
	'guide_newthread' => '最新發布',
	'guide_hot'=>'熱門',
    'post'=>'發帖',
    'sorry'=>'抱歉',
	'find'=>'發現',
    'triumph'=>'獲&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;勝',
    'selectforum'=>'選擇發帖版塊',
	'credit' =>'積分',
	'home' => '首頁',
	'forum' => '論壇',
	'group' => '群組',    
	'guide' => '導讀',
    'message'=>'消息',
    'new_message'=>'新消息',    
    'my'=>'我的',
	'mygroup' => '我的群組',
	'joingroup'=> '加入群組',
	'group_exit'=>'退出群組',
	'mygroup'=>'我的群組',
	'nogroup'=>'您還沒有創建過群組，請用電腦訪問創建',
	'nojoingroup' => '您需要加入該群組才能正常訪問',
	'jianjie'=>'簡介',
	'chengyuan'=>'成員',
	'paiming'=>'排名',
    'loading'=>'加載中...',
    'loadingend'=>'已經到底了',
	'shequjiaodian' => '社區焦點',
	'rementupian' => '熱門圖片',
	'zuixinfabu' => '最新發布',
	'zuixinhuifu' => '最新回復',
	'zuixinremen' => '最新熱門',
	'jingcaituijian' => '精彩推薦',
	'searchgroupt'=>'搜索帖子',
	'pic' => '美圖',
    'selectimg'=>'選擇圖片',
	'classify' =>'分類信息',
	'mdoing' => '記錄',
	'mfollow' => '廣播',
	'mfriend' => '好友',
    'tafriend'=>'Ta的好友',
    'taposts'=>'Ta的帖子',
    'tareply'=>'Ta的回復',
    'taprofile'=>'Ta的資料',
	'pindao' => '頻道',
	'mfriendall' => '全部',
	'latest' => '最新',
	'order_heats' => '熱門',
	'hot_thread' => '熱帖',
	'digest_posts' => '精華',
    'special_top'=>'置頂',
    'special_digest'=>'精華',
    'special_activity'=>'活動',
    'special_pic'=>'有圖',
    'special_poll'=>'投票',
    'special_reward'=>'懸賞',
    'special_trade'=>'商品',
	'gengduo' => '更多',
	'shouqi' => '收起',
	'stop'=>'↑',
	'mfriendol' => '在線好友',
	'mfriendbl' => '黑名單',
	'mfriendrq' => '好友請求',
	'mfriendprofile' => '資料',
	'mfriendgroup' => '分組',
	'mblog' => '日誌',
	'mfeed' => '動態',
	'photo' => '相冊',
	'more' => '更多',
	'fup' => '上級',
	'flist' => '列表',
	'plist' => '所在頻道',
	'res' => '刷新',
	'scroll_top'=>'▲',
	'load' => '加載更多...',
	'load_pic' => '拼命加載中...',
	'load_nopic' => '沒有更多內容了',
	'newth' => '新帖',
	'dfth' => '默認',
	'subfrm' => '子版塊',
	'thtys' => '分類',
	'othtys' => '展開分類',
	'pta' => '發表於',
	'reply' => '發表回復',
	'srp' => '查看回復',
	'rcom' => '發表評論',
	'acom' => '查看評論',
    'activity_endtime'=>'結束時間',
	'opt' => '選填',
	'od' => '條',
	'de' => '的',
	'tt' => '共有',
    'today'=>'今日',
    'nocomment'=>'暫無評論',
	'thread' => '主題',        
	'posts'=>'貼數',
	'reply' => '回復',
	'replyta'=>'回復TA',
	'views' => '查看',
	'chakanziliao'=>'查看資料',
	'tianjiahaoyou'=>'添加好友',
	'faxiaoxi'=>'發消息',
	'tietu' => '貼圖',
	'mods' => '管理',
	'nomessage' => '此貼無文字內容',
	'mthread' => '帖子',
	'mforum' => '版塊',
	'profile' => '個人資料',
	'mycenter' => '個人中心',
	'tuchuang' => '圖床',
	'profilet' => '資料',
	'bankuaishoucang' => '板塊收藏',
	'chakanxiaoxi' => '查看消息',
	'wodezhuti' => '我的主題',
	'favorite' => '我的收藏',
	'mypm' => '我的消息',
	'psubject' => '帖子標題',
	'arc' => '文章',
	'lz' => '樓主',
    'lou'=>'樓',
    'rzg'=>'人贊過',
	'kanlouzhu' => '只看樓主',
	'kanquanbu' => '看全部',
	'cldate' => '日期格式:2010-12-01 10:50',
	'pcf' => '重復',
	'back' => '返回',
	'search' => $_GET['mod']=='portal' ? '搜索文章' : ($_GET['mod']=='forum' ? '搜索帖子' : '搜索'),
	'searchtext' => '輸入搜索的關鍵字',
    'search_forum'=>'搜索帖子',
    'search_portal'=>'搜索文章',
	'wenzhangshoucang' => '收藏文章',
	'4hr' => '4小時',
	'24hr' => '24小時',
	'168hr' => '壹周',
	'720hr' => '壹月',
	'new_remind' => '有新提醒',
	'remind' => '提醒',
	'xiaoxi' => '消息',
	'new_xiaoxi' => '有新消息',
	'gerenzhongxin' => '個人中心', 
	'mefriend_doing' => '我和好友',
	'tishi'=> '提示',
	'friend_feed' => '好友動態',
	'wenzhang' => '門戶',
	'tupianqiang' => '圖片瀑布流',
	'wodezhuti' => '我的主題',
	'zhutishouchang' => '主題收藏',
	'wodezilaio' => '我的資料',
	'wodexiaoxi' => '我的消息',
	'wodehaoyou' => '我的好友',
	'nuwcomment' => '最新評論',
	'qiangshafa' => '搶沙發',
	'fanhuidingbu' => '返回頂部↑',
	'fanhuiliebiao' => '返回列表',
	'postnewthread'=>'發布新帖',
	'biaoqian' => '標簽',
	'dengru' => '登入',
	'qqdengru' => 'QQ登入',
	'dengruzhongxin' => '登入中心',
	'tuichu' => '退出',
	'zuixin' => '最新',
	'remen' => '熱門',
	'retie' => '熱帖',
	'jinghua' => '精華',
	'zuixinremen' => '最新熱門',
	'zuixinjinghua' => '最新精華',
	'zuixinfabu' => '最新發布',
	'fabuyu' => '發布於',
	'touch' => '觸屏版',
	'tthread' => '正文',
	'butubukuai' => '不吐不快！',
	'kuaijie' => '快捷>>',
    'title'=>'標題',
	'zhutil' => '主題：',
	'paimingl' => '排名：',
	'zhengxu' =>'正序',
	'daoxu' => '倒序',
	'loginaq' => '安全提問?',
	'nosearch' => '暫無',
	'gohome' => '返回首頁',
	'regmes' => '原因',
	'upload_pic' => '上傳圖片',
	'reg' => '註冊',
	'zhucezhongxin' =>'註冊中心',
	'qq' => '登錄',
	'noid' => '沒有賬號?',
	'yesid' => '已有賬號?',
	'yuehot' => '本月熱帖',
	'zhuohot' => '本周熱帖',
	'shoucang' => '收藏',
	'paixu' => '排序',
	'hotforum' => '熱門板塊',
	'hottz' => '熱門帖子',
	'username' => '賬號',
	'jingcaituijian' => '推薦主題',
	'zuixinfabu' =>'最新發布',
	'pc'=>'電腦板',
	'gonggao'=> '公告：',
	'querenshangpin'=> '確認商品',
	'xinwen' => '新聞',
	'guonei' => '國內',
	'guoji' => '國際',
	'shishi' => '實事',
	'shequ' => '社區',	
	'jinrupindao' => '進入頻道',
	'shequjiaodian' => '社區焦點',
	'rementupian' => '熱門圖片',
	'zuixinfabu' => '最新發布',
	'zhutituijian' => '主題推薦',
	'tuijianbankuai' => '板塊推薦',
	'shijian'=>'時間',
	'jieshushijian'=>'結束時間',
	'qzzlsrbt' => '請輸入標題',
	'qzzlsrnr' => '請輸入內容',
	'bitianxiangmumeiyoutianxie'=>'必填項目沒有填寫',
	'tianxiedexiangmuchangduguochang'=>'填寫項目長度過長',
	'shuzitianxiebuzhengque'=>'數字填寫不正確',
	'dayushezhidezuidazhi'=>'大於設置最大值',
	'xiaoyushezhidezuidazhi'=>'小於設置最小值',
	'youjiangeshibuzhengque'=>'郵件地址不正確',
	'urlbuzhengque'=>'請正確填寫以http://開頭的URL地址',
	'qingxuanzexiayiji'=>'請選擇下壹級',
	'qingxuanze'=>'請選擇',
	'fxdpyq' => '請點擊微信右上角分享到朋友圈',
	'weixin' => '微信',
	'share' => '分享',
	'shangyizhuti'=>'上壹主題',
	'xiayizhuti'=>'下壹主題',
	'huifuchenggong'=>'回復成功',
	'xiaoxifasongchenggong'=>'消息發送成功',
	'haoyouliebiao'=>'好友列表',
	'zaixiandehaoyou'=>'在線好友',
	'zaixianyonghu'=>'在線用戶',
	'haoyouqingqiu'=>'好友請求',
	'shanchuhaoyou'=>'刪除好友',
	'tadepengyou'=>'TA的朋友',
	'tadezhuti'=>'TA的主題',
	'tadeziliao'=>'TA的資料',
    'space_threadthread'=>'的帖子',
    'space_threadreply'=>'的回復',
    'space_profile'=>'的資料',
    'space_friend'=>'的好友',
    'myspace_threadthread'=>'我的帖子',
    'myspace_threadreply'=>'我的回復',
    'myspace_profile'=>'我的資料',
    'myspace_friend'=>'我的好友',
    'mythread'=>'我的帖子',
    'myreply'=>'我的回復',
    'myprofile'=>'我的資料',
    'myfriend'=>'我的好友',    
	'xiaoxiliebiao'=>'消息列表',
	'xiaoxixiangqing'=>'消息詳情',
	'fuyan'=>'附言',
	'zaixian'=>'[在線]',
	'zhiding'=>'置頂',
    'setanswer'=>'您確認要把該回復選為“最佳答案”嗎？',
	'Scorereasons' => '填寫評分理由',
	'all_comment' => '全部評論',
	'tourist_nopermission_login' => '<div style="margin:10px 0;border: 1px dashed #DDDDC2; background: #FFFFDC;font-size: 13px;
    padding: 13px;"><p style="color: #8CA226; font-size: 15px; display: block;    
    margin-bottom: 8px;">您需要<a href="member.php?mod=logging&action=login" style=" color: #3e86ce;margin: 0 7px;">登錄</a>才可以下載或查看附件。</div>',
   'search_result_keyword'=>"壹共$index[num]條結果",
   'cancel_share'=>'取消分享',
   'weixin_share_text1'=>'打開瀏覽器分享功能，點[微信好友]<br>分享給妳的好友'

    );



?>
