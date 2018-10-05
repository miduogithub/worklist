<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

    $strongset = $_G['cache']['plugin']['strong_a1'];    
    $tid = $_GET[tid];


    
if($_GET['action'] == 'add') {
    
    
   	if(empty($_G['uid']) and !$wechatformatset[ontourist3]) {
		showmessage('to_login', null, array(), array('showmsg' => true, 'login' => 1));
	}    
    
    if(empty($_GET['hash']) || $_GET['hash'] != formhash()) {
		showmessage('submit_invalid');
	}
    if(!C::t('forum_thread')->fetch($_G[tid])){
        showmessage(lang('plugin/strong_wechat_format','text4'));
    }
    
    if(!$_G['uid'] and $wechatformatset[ontourist3] and $_G["cookie"]["strong_recommend_tid_".$_G[tid]]){
        showmessage('recommend_duplicate', '', array('recommendc' => $thread['recommends']), array('msgtype' => 3));
    }else{
    	if(C::t('forum_memberrecommend')->fetch_by_recommenduid_tid($_G['uid'], $_G['tid'])) {
    		showmessage('recommend_duplicate', '', array('recommendc' => $thread['recommends']), array('msgtype' => 3));
    	}
    }

	
	$fieldarr = array();
	
	$heatadd = 'recommend_add=recommend_add+1';
	$fieldarr['recommend_add'] = 1;
    $fieldarr['heats'] = 0;
	$fieldarr['recommends'] = 1;
	C::t('forum_thread')->increase($_G['tid'], $fieldarr);
	C::t('forum_thread')->update($_G['tid'], array('lastpost' => TIMESTAMP));
    if($_G['uid']){
	C::t('forum_memberrecommend')->insert(array('tid'=>$_G['tid'], 'recommenduid'=>$_G['uid'], 'dateline'=>$_G['timestamp']));
    }
    if($wechatformatset[ontourist3] and !$_G['uid']){dsetcookie('strong_recommend_tid_'.$_G[tid], 1, 31536000); }
    showmessage('recommend_succeed', 'href="forum.php?mod=viewthread&tid='.$_G[tid], array('praise'=>'recommend','tid'=>$_G[tid])); 

	
}else{
    loadcache('usergroups');
    $page = intval($_GET['page']);
	$perpage = 10;
	$page = $page ? $page : 1;
	$pageurl= 'plugin.php?id=strong_a1:praise&tid='.$tid;
	$maxpages = 1000;
	$start = ($page-1)*$perpage;
	if($start<0) $start = 0;
    $praiselist = DB::fetch_all('SELECT * FROM %t WHERE tid=%d order by dateline asc '.DB::limit($start, $perpage), array('forum_memberrecommend',$tid));
    foreach($praiselist as $key => $praise){  
        $praiselist[$key][dateline] = dgmdate($praise['dateline']);
        $praiselist[$key][profile] = getuserbyuid($praise['recommenduid']);
    }
    
    $count = DB::result_first('SELECT COUNT(*) FROM %t WHERE tid=%d', array('forum_memberrecommend',$tid));
    $multis = multi($count, $perpage, $page, $pageurl, $maxpages);
  
    include template('strong_a1:praise');
    
}




?>
