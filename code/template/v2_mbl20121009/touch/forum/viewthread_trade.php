<?php exit;?>
<!--{if !$post['message'] && (($_G['forum']['ismoderator'] && $_G['group']['alloweditpost'] && (!in_array($post['adminid'], array(1, 2, 3)) || $_G['adminid'] <= $post['adminid'])) || ($_G['forum']['alloweditpost'] && $_G['uid'] && $post['authorid'] == $_G['uid']))}-->
<div class="QGV0nMQQtF">
    <a href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]&page=$page">
    <span>{lang post_add_aboutcounter}</span>
    </a>
</div>
<!--{else}-->
 <div class="IeEaWCrC27">
 $post[message]
 </div>
<!--{/if}-->


<!--{if count($trades) > 1 || ($_G['uid'] == $_G['forum_thread']['authorid'] || $_G['group']['allowedittrade'])}-->
	<div class="QGV0nMQQtF">
		<em>{lang post_trade_totalnumber}: $tradenum</em>
		<!--{if !$_G['forum_thread']['is_archived'] && ($_G['uid'] == $_G['forum_thread']['authorid'] || $_G['group']['allowedittrade'])}-->
			<span class="D2lReDdK6D">{lang trade_mod}</span>
		<!--{/if}-->
	</div>
<!--{/if}-->
<!--{if $tradenum}-->
	<!--{if $trades}-->
        <!--{loop $trades $key $trade}-->
            <div id="trade$trade[pid]" class="QGV0nMQQtF">
                <div>
                    <!--{if $trade['displayorder'] > 0}--><em class="sNCxiKSiNE">{lang post_trade_sticklist}</em><!--{/if}-->
                    <!--{if $trade['thumb']}-->
                        <img src="$trade[thumb]" width="{if $trade[width] > 90}90{else}$trade[width]{/if}" _width="90" _height="90" alt="$trade[subject]" />
                    <!--{else}-->
                        <img src="{IMGDIR}/nophotosmall.gif" width="90" height="90" alt="$trade[subject]" />
                    <!--{/if}-->
                </div>
                <div>
                    <h4>$trade[subject]</h4>
                    <dl>
                        <dt>{lang trade_type_viewthread}:
                            <!--{if $trade['quality'] == 1}-->{lang trade_new}<!--{/if}-->
                            <!--{if $trade['quality'] == 2}-->{lang trade_old}<!--{/if}-->
                            {lang trade_type_buy}
                        </dt>
                        <dt>{lang trade_remaindays}:
                        <!--{if $trade[closed]}-->
                            <em>{lang trade_timeout}</em>
                        <!--{elseif $trade[expiration] > 0}-->
                            {$trade[expiration]}{lang days}{$trade[expirationhour]}{lang trade_hour}
                        <!--{elseif $trade[expiration] == -1}-->
                            <em>{lang trade_timeout}</em>
                        <!--{else}-->
                            &nbsp;
                        <!--{/if}-->
                        </dt>
                    </dl>
                    <div>
                        <!--{if $trade[price] > 0}-->
                            <strong>$trade[price]</strong>&nbsp;{lang payment_unit}&nbsp;&nbsp;
                        <!--{/if}-->
                        <!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade[credit]}-->
                            <!--{if $trade['price'] > 0}-->{lang trade_additional} <!--{/if}--><strong>$trade[credit]</strong>&nbsp;{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][5]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][5]][title]}
                        <!--{/if}-->
                        <p class="0GJVCDXl4J">
                            <!--{if $trade['costprice'] > 0}-->
                                <del>$trade[costprice] {lang payment_unit}</del>
                            <!--{/if}-->
                            <!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade['costcredit'] > 0}-->
                                <del><!--{if $trade['costprice'] > 0}-->{lang trade_additional} <!--{/if}-->$trade[costcredit] {$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}</del>
                            <!--{/if}-->
                        </p>
                    </div>
                </div>
            </div>
        <!--{/loop}-->
	<!--{/if}-->
<div id="postmessage_$post[pid]">$post[counterdesc]</div>
<!--{else}-->
	<div class="WKm95Umxvk">{lang trade_nogoods}</div>
<!--{/if}-->
