<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$strongset = $_G['cache']['plugin']['strong_a1'];
if(!defined('STRONGDIR')){
    define('STRONGDIR', $_G['siteurl'] . 'template/strong_a1/');
}
$pageurl = $_G['siteurl'] . $_G['basefilename'] . '?' . $_SERVER['QUERY_STRING'];


function getpraiseuser(){
    global $_G;
    if($_G['tid'] and $_G['thread']['recommend_add']){
        $praises = DB::fetch_all('SELECT * FROM %t WHERE tid=%d order by dateline asc '.DB::limit(0, 4), array('forum_memberrecommend',$_G['tid']));
        return $praises;
    }
    
}

function tagsreplace($tid,$titledescribelen){
    $postmessage= DB::fetch_first('SELECT message FROM '.DB::table('forum_post').' WHERE tid = ' . $tid . ' and first = 1 ');
    require_once libfile('function/post');
    return messagecutstr($postmessage['message'],$titledescribelen);
}


function wei_sortpic($weiv){	
    return $weiv;
    if(strstr($weiv,'<a')!= false and strstr($weiv,'data/attachment') != false ){
        $weivs = explode('href="',$weiv);				
        $weivs = explode('" target="_blank"',$weivs[1]);	
        $weiv = '<img src="'.$weivs[0].'"style="max-width: 60%;max-height: 60%;">'; 
        return $weiv;
	}else if(strstr($weiv,'data/attachment') != false){
	   $weiv = '<img src="'.$weiv.'"style="max-width: 60%;max-height: 60%;">'; 
		return $weiv;	
	}			
	return $weiv;			
			
}


function returnforumstyle(){
    global $strongset;
    $forumstyle2 = $strongset[forum_style2];
    $forumstyle4 = $strongset[forum_style4];
    
    $forumstylearr2 = explode(',',$forumstyle2);
    $forumstylearr4 = explode(',',$forumstyle4);
    return array('style2'=>$forumstylearr2,'style4'=>$forumstylearr4);    
}

function returntypenmae($thread){
    global $_G;
    
    if($_GET[mod]=='index'){
        
        $forumname = DB::fetch_first("SELECT * FROM " . DB::table('forum_forum') . " WHERE fid = $thread[fid]");
        return $forumname[name];
        
    }elseif($thread[sortid]){
      
        return $_G['forum']['threadsorts']['types'][$thread['sortid']];
    }elseif($thread[typeid]){
      
        return $_G['forum']['threadtypes']['types'][$thread['typeid']];
    }
    return '';
}


function showlogo($type){
    global $lang,$strongset;;
    $logourl = '<img src="template/strong_a1/touch/images/logo.png">';
    $piclogoarr = dunserialize($strongset[piclogo]);
    
    switch($type){
        case 'portal':
            if(in_array(1,$piclogoarr)){
                return $logourl;  
                
            }else{
                return $lang[home];
            }
             
            break;
        case 'forum':
            if(in_array(2,$piclogoarr)){
                return $logourl;  
                
            }else{
                return $lang[forum];
            }
             
            break;
        case 'guide':
            if(in_array(3,$piclogoarr)){
                return $logourl;  
                
            }else{
                return $lang[guide];
            }
             
            break;        
    }
    
    
}


function pagereturn($page){
    global $_G;
    $referer = $_SERVER['HTTP_REFERER'];
    //if($referer == ''){return $_G['siteurl'];}
    //return $referer;
    /*
    switch($page){
        case 'viewthread':
            
            if(strstr($referer,'')){
                
                
            }
            
            break;
        
        //...

        
    } */
    
    
    return 'javascript:history.back();';    
}	
    
    	
function threadlist_format($list, $type = 'fid') {
    global $_G,$strongset;
    $language = 'language.'.currentlang().'.php';
    include ("./template/strong_a1/".$language);
    $style = 1;
    switch($type) {
        case 'fid':
            $onstyle4 = in_array($_G['fid'], dunserialize($strongset['forumstyle4']));
            $onstyle3 = in_array($_G['fid'], dunserialize($strongset['forumstyle3']));
            $onstyle2 = in_array($_G['fid'], dunserialize($strongset['forumstyle2']));
            if($onstyle4) {
                $style = 4;
            } elseif($onstyle3) {
                $style = 3;    
            } elseif($onstyle2) {
                $style = 2;
            }
            break;

        case 'guide':
            $style = 1;
            $onstyle = $strongset['guidestyle'];
            if($onstyle==1){
                $style = 2;
            } elseif($onstyle==2){
                $style = 3;
            } elseif($onstyle==3){ 
                $style = 4;
            }
            
            break;
        
        case 'index':
            $style = 4;
            break;               
        case 'homethread':        
            $style = 2;
            break;
        default:
            $style = 1;
            break;
    }


    include template('forum/threadlist_format_' . $style);

}

function page_format($totalpage, $perpage, $multipage, $type='fid') {
    global $_G, $pageurl, $lang, $strongset;
    $others = dunserialize($strongset['otherajaxpage']);
    $onajaxpage = 0;
    switch($type){
        case 'fid':
            $fidexist = in_array($_G['fid'], dunserialize($strongset['threadajaxpage']));
            if($fidexist){$onajaxpage = 1;}
            break;
        
        case 'catid':
            global $value;
            if(in_array($value[catid],explode(',',$strongset['articleajaxpage']))){$onajaxpage = 1;}
            
            break;    
        case 'guide':
            if(in_array('guide',$others)){$onajaxpage=1;}
            break;
            
        case 'praise':
            if(in_array('praise',$others)){$onajaxpage=1;}
            break;
            
        case 'index':
            $onajaxpage = 1;
            break;    
        
        default:
            $onajaxpage = 0;    
            break;    
    }    
    

    if($onajaxpage){
        $totalpage = ceil(($totalpage + 1) / $perpage);
        include template('forum/page_format');
    }else{
        echo $multipage;
    }
}


function getattachlist($tid,$pid){
        global $_G;
        $attachtableid = DB::fetch_first("SELECT * FROM " . DB::table('forum_attachment') . " WHERE tid = $tid");
        if($attachtableid and $attachtableid[tableid]!=127){
            $attachtableid = $attachtableid[tableid];
            $attachlist = DB::fetch_all("SELECT * FROM " . DB::table('forum_attachment_'.$attachtableid) . " WHERE tid = $tid and pid = $pid and uid = $_G[uid]");
            if($attachlist){
               $return = '';
               foreach($attachlist as $key=>$val){
                    $return .= "<li><span aid='".$val[aid]."' class='del'><a href='javascript:;'><img src='".$_G[staticurl]."/image/mobile/images/icon_del.png'></a></span><span class='p_img'><a href='javascript:;'><img style='height:54px;width:54px;' id='aimg_".$val[aid]."'  src='".$_G['setting']['attachurl']."forum/".$val[attachment]."' /></a></span></li>";
               }
               return $return;
            }else{
                return '';
            }
        }else{
            return '';
        }
       
}	
    
function get_threadpic($tid,$num,$width,$height){
    $attachtable = getattachtablebytid($tid); 
    $datalist = array();
    foreach(DB::fetch_all("SELECT * FROM %t WHERE tid = %d and width>=$width and isimage=1 LIMIT  0 , $num",array($attachtable,$tid)) as $attach){        
        $datalist[$attach['aid']] = getforumimg($attach['aid'],'0',$width,$height);  
        
    }
     
    return $datalist;
}

function get_forumicon($icon) {
    global $_G;
 
    $iconarr = DB::fetch_all("SELECT fid,icon FROM %t WHERE icon != ''",array('forum_forumfield'));
    foreach($iconarr as $key => $val){
        $returnarr[$val[fid]] = $_G['setting']['attachurl'].'common/'.$val[icon];
        
    }
    return $returnarr;
    
}

function get_indexthreadlist(){
    global $_G;
    $strongset = $_G['cache']['plugin']['strong_a1'];
    $forums = dunserialize($strongset[index_forums]);
    $where = '';
    if($forums[0]==''){
        $where .= ' 1';
    }else{    
        $i = 0;
        $where .= '(';
        foreach($forums as $k=>$forum){
            if($k == 0){ 
                $where .= "fid = $forum ";
            }else{                
                $where .= "OR fid = $forum ";
            }
            $i++;
        }
        $where .= ')';
    }
    if($strongset[index_digest]){
        
        $where .= ' AND digest=1';
        
    }
    if($strongset[index_replys]){
        
        $where .= " AND replies >= $strongset[index_replys]";
        
    }
    if($strongset[index_views]){
        
        $where .= " AND views >= $strongset[index_views]";
        
    }
    $where .=" AND isgroup = 0 AND displayorder != -1";
    switch($strongset['index_order']){
        case '1':
            $order = ' dateline asc';
            break;
            
        case '2':
            $order = ' dateline desc';
            break;  
            
        case '3':
            $order = ' lastpost asc';
            break;     
        
        case '4':
            $order = ' lastpost desc';
            break;
            
        default:    
            $order = ' dateline asc';
            break;        
    }
    
    
    
    $perpage = 10;  
    $data['perpage'] = $perpage;  
    $start = $data['perpage'] * ($_G['page'] - 1);      
    $threadlist = DB::fetch_all("SELECT * FROM %t WHERE $where order by $order",array('forum_thread'));
    $data['threadlist'] = DB::fetch_all("SELECT * FROM %t WHERE $where order by $order LIMIT $start,$perpage",array('forum_thread'));
    foreach($data['threadlist'] as $key=>$thread){
        $data['threadlist'][$key][dateline] = dgmdate($thread[dateline]);
    }
    $data['num'] = count($threadlist);
    $data['multipage'] = multi($data['num'], $perpage, $_G['page'], 'portal.php?mod=index');
    return $data;
}
?>
