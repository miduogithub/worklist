<?php exit;?>
<!--{template common/header}-->
<!--{eval}-->
    $language = 'language.'.currentlang().'.php';
    include ("./template/strong_a1/".$language);
<!--{/eval}-->
<!--{if $comments}-->
	<h3 class="comment">{lang comments}</h3>
	<!--{if $totalcomment}--><div class="pstl">$totalcomment</div><!--{/if}-->
    <div class="threadcomment">
	<!--{loop $comments $comment}-->
		<div class="pstl xs1 cl">
			<div class="psta vm">
            	<a href="home.php?mod=space&uid=$comment[authorid]" c="1">$comment[avatar]</a>
           		<!--{if $comment['authorid']}-->
				<a href="home.php?mod=space&uid=$comment[authorid]" class="xi2 xw1">$comment[author]</a>
				<!--{else}-->
				{lang guest}
				<!--{/if}-->            
            </div>
			<div class="psti">				
				$comment[comment]&nbsp;
				<!--{if $comment[rpid]}-->
					<a href="forum.php?mod=redirect&goto=findpost&pid=$comment[rpid]&ptid=$_G[tid]" class="xi2">{lang detail}</a>
					<a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&reppost=$comment[rpid]&extra=$_GET[extra]&page=$page{if $_GET[from]}&from=$_GET[from]{/if}" class="xi2" onclick="showWindow('reply', this.href)">{lang reply}</a>
				<!--{/if}-->
				<span class="xg1">
					{lang poston} $comment[dateline]
					
					<!--{if $_G['forum']['ismoderator'] && $_G['group']['allowdelpost']}-->&nbsp;<a class="dialog delete" href="forum.php?mod=topicadmin&action=delcomment&fid={$_G[fid]}&tid={$_G[tid]}&topiclist[]=$comment[id]">{lang delete}</a><!--{/if}-->
				</span>
			</div>
		</div>
	<!--{/loop}-->
    </div>
   
    <div class="pgs mbm cl">
    	<div class="page">
    		<a href="<!--{if $page>1}-->forum.php?mod=misc&action=commentmore&tid=$_G[tid]&pid=$_GET[pid]&ajaxtarget=$_GET[ajaxtarget]&page=<!--{eval echo $page-1}--><!--{else}-->javascript:;<!--{/if}-->" class="ajaxdialog <!--{if $page<=1}-->grey<!--{/if}-->"  ajaxtarget="$_GET[ajaxtarget]">{echo $lang[prev]}</a>
       		 <a href="<!--{if $page>=ceil($count/$commentlimit)}-->javascript:;<!--{else}-->forum.php?mod=misc&action=commentmore&tid=$_G[tid]&pid=$_GET[pid]&ajaxtarget=$_GET[ajaxtarget]&page=<!--{eval echo $page+1}--><!--{/if}-->" class="ajaxdialog <!--{if $page>=ceil($count/$commentlimit)}-->grey<!--{/if}-->"  ajaxtarget="$_GET[ajaxtarget]">{echo $lang[next]}</a>
        </div>
    </div>
<!--{/if}-->
<!--{template common/footer}-->
