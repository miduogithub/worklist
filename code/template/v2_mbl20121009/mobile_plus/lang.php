<?php

/**
 * 
 * �ݸ��ɳ�Ʒ ������Ʒ
 * �ݸ���Դ����̳ ȫ���׷� http://www.Caogen8.Co
 * ��л֧�֣�����֧�����������Ķ���������������ر�վ������Դ��
 * ��ӭ������û�����¸��µ�������Դ������VIP��ɫ��Դ���ݴ������
 * �ݸ����û�����Ⱥ: ��Ⱥ306115775
 * ����������http://www.cgzz8.com/ (���ղر���!)
 * 
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

//����, ���޸�ע�������
function m_lang($f) {	
$m_lang = array(
	'home' => '��ҳ',
	'forum' => '��̳',
	'pic' => '��ͼ',
	'guide' => '����',
	'mdoing' => '��¼',
	'mfollow' => '�㲥',
	'mfriend' => '����',
	'mfriendall' => 'ȫ��',
	'mfriendol' => '���ߺ���',
	'mfriendbl' => '������',
	'mfriendrq' => '��������',
	'mfriendprofile' => '����',
	'mfriendgroup' => '����',
	'mefriend_doing' => '�Һͺ���',
	'friend_feed' => '���Ѷ�̬',
	'mblog' => '��־',
	'mfeed' => '��̬',
	'photo' => '���',
	'subfrm' => '�Ӱ��',
	'thtys' => '����',
	'pta' => '������',
	'acom' => '�鿴����',
	'od' => '��',
	'tt' => '����',
	'mthread' => '����',
	'mforum' => '���',
	'profile' => '��������',
	'favorite' => '�ҵ��ղ�',
	'mypm' => '�ҵ���Ϣ',
	'arc' => '����',	
	'back' => '����',
	'search' => '����',
	'searchportal' => '��������',
	'new_remind' => '��������',	
	'tthread' => '����',
	'noid' => 'û���˺�?',
	'yesid' => '�����˺�?',	
	'load' => '���ظ���',
	'load_photo' => '����ˬ, ����һ��',
	'load_pic' => '������...',
	'ucspeed' => '��ر�UC������ļ���ģʽ��<br />�ٳ���ˢ�´�ҳ��',			
    );
	if($m_lang[$f]) $f = $m_lang[$f]; 
	if(CHARSET =='gbk'){
		return $f;
	}else{
		return diconv($f,'GBK',CHARSET);
	}
}

?>