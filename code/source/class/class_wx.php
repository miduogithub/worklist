<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: class_member.php 34156 2013-10-25 01:10:00Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class Wechat_thinkphp {

	const MSGTYPE_TEXT = 'text';
	const MSGTYPE_IMAGE = 'image';
	const MSGTYPE_LOCATION = 'location';
	const MSGTYPE_LINK = 'link';
	const MSGTYPE_EVENT = 'event';
	const MSGTYPE_MUSIC = 'music';
	const MSGTYPE_NEWS = 'news';
	const MSGTYPE_VOICE = 'voice';
	const MSGTYPE_VIDEO = 'video';
	const MSGTYPE_SHORTVIDEO = 'shortvideo';
	const EVENT_SUBSCRIBE = 'subscribe';       //����
	const EVENT_UNSUBSCRIBE = 'unsubscribe';   //ȡ������
	const EVENT_SCAN = 'SCAN';                 //ɨ���������ά��
	const EVENT_LOCATION = 'LOCATION';         //�ϱ�����λ��
	const EVENT_MENU_VIEW = 'VIEW';                     //�˵� - ����˵���ת����
	const EVENT_MENU_CLICK = 'CLICK';                   //�˵� - ����˵���ȡ��Ϣ
	const EVENT_MENU_SCAN_PUSH = 'scancode_push';       //�˵� - ɨ�����¼�(�ͻ�����URL)
	const EVENT_MENU_SCAN_WAITMSG = 'scancode_waitmsg'; //�˵� - ɨ�����¼�(�ͻ��˲���URL)
	const EVENT_MENU_PIC_SYS = 'pic_sysphoto';          //�˵� - ����ϵͳ���շ�ͼ
	const EVENT_MENU_PIC_PHOTO = 'pic_photo_or_album';  //�˵� - �������ջ�����ᷢͼ
	const EVENT_MENU_PIC_WEIXIN = 'pic_weixin';         //�˵� - ����΢����ᷢͼ��
	const EVENT_MENU_LOCATION = 'location_select';      //�˵� - ��������λ��ѡ����
	const EVENT_SEND_MASS = 'MASSSENDJOBFINISH';        //���ͽ�� - �߼�Ⱥ�����
	const EVENT_SEND_TEMPLATE = 'TEMPLATESENDJOBFINISH';//���ͽ�� - ģ����Ϣ���ͽ��
	const EVENT_KF_SEESION_CREATE = 'kfcreatesession';  //��ͷ� - ����Ự
	const EVENT_KF_SEESION_CLOSE = 'kfclosesession';    //��ͷ� - �رջỰ
	const EVENT_KF_SEESION_SWITCH = 'kfswitchsession';  //��ͷ� - ת�ӻỰ
	const EVENT_CARD_PASS = 'card_pass_check';          //��ȯ - ���ͨ��
	const EVENT_CARD_NOTPASS = 'card_not_pass_check';   //��ȯ - ���δͨ��
	const EVENT_CARD_USER_GET = 'user_get_card';        //��ȯ - �û���ȡ��ȯ
	const EVENT_CARD_USER_DEL = 'user_del_card';        //��ȯ - �û�ɾ����ȯ
	const EVENT_MERCHANT_ORDER = 'merchant_order';        //΢��С�� - ��������֪ͨ
	const API_URL_PREFIX = 'https://api.weixin.qq.com/cgi-bin';
	const AUTH_URL = '/token?grant_type=client_credential&';
	const MENU_CREATE_URL = '/menu/create?';
	const MENU_GET_URL = '/menu/get?';
	const MENU_DELETE_URL = '/menu/delete?';
	const MENU_ADDCONDITIONAL_URL = '/menu/addconditional?';
	const MENU_DELCONDITIONAL_URL = '/menu/delconditional?';
	const MENU_TRYMATCH_URL = '/menu/trymatch?';
	const GET_TICKET_URL = '/ticket/getticket?';
	const CALLBACKSERVER_GET_URL = '/getcallbackip?';
	const QRCODE_CREATE_URL='/qrcode/create?';
	const QR_SCENE = 0;
	const QR_LIMIT_SCENE = 1;
	const QRCODE_IMG_URL='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=';
	const SHORT_URL='/shorturl?';
	const USER_GET_URL='/user/get?';
	const USER_INFO_URL='/user/info?';
	const USERS_INFO_URL='/user/info/batchget?';
	const USER_UPDATEREMARK_URL='/user/info/updateremark?';
	const GROUP_GET_URL='/groups/get?';
	const USER_GROUP_URL='/groups/getid?';
	const GROUP_CREATE_URL='/groups/create?';
	const GROUP_UPDATE_URL='/groups/update?';
	const GROUP_MEMBER_UPDATE_URL='/groups/members/update?';
	const GROUP_MEMBER_BATCHUPDATE_URL='/groups/members/batchupdate?';
	const CUSTOM_SEND_URL='/message/custom/send?';
	const MEDIA_UPLOADNEWS_URL = '/media/uploadnews?';
	const MASS_SEND_URL = '/message/mass/send?';
	const TEMPLATE_SET_INDUSTRY_URL = '/template/api_set_industry?';
	const TEMPLATE_ADD_TPL_URL = '/template/api_add_template?';
	const TEMPLATE_SEND_URL = '/message/template/send?';
	const MASS_SEND_GROUP_URL = '/message/mass/sendall?';
	const MASS_DELETE_URL = '/message/mass/delete?';
	const MASS_PREVIEW_URL = '/message/mass/preview?';
	const MASS_QUERY_URL = '/message/mass/get?';
	const UPLOAD_MEDIA_URL = 'http://file.api.weixin.qq.com/cgi-bin';
	const MEDIA_UPLOAD_URL = '/media/upload?';
	const MEDIA_UPLOADIMG_URL = '/media/uploadimg?';//ͼƬ�ϴ��ӿ�
	const MEDIA_GET_URL = '/media/get?';
	const MEDIA_VIDEO_UPLOAD = '/media/uploadvideo?';
    const MEDIA_FOREVER_UPLOAD_URL = '/material/add_material?';
    const MEDIA_FOREVER_NEWS_UPLOAD_URL = '/material/add_news?';
    const MEDIA_FOREVER_NEWS_UPDATE_URL = '/material/update_news?';
    const MEDIA_FOREVER_GET_URL = '/material/get_material?';
    const MEDIA_FOREVER_DEL_URL = '/material/del_material?';
    const MEDIA_FOREVER_COUNT_URL = '/material/get_materialcount?';
    const MEDIA_FOREVER_BATCHGET_URL = '/material/batchget_material?';
	const OAUTH_PREFIX = 'https://open.weixin.qq.com/connect/oauth2';
	const OAUTH_AUTHORIZE_URL = '/authorize?';
	///��ͷ���ص�ַ
	const CUSTOM_SERVICE_GET_RECORD = '/customservice/getrecord?';
	const CUSTOM_SERVICE_GET_KFLIST = '/customservice/getkflist?';
	const CUSTOM_SERVICE_GET_ONLINEKFLIST = '/customservice/getonlinekflist?';
	const API_BASE_URL_PREFIX = 'https://api.weixin.qq.com'; //����API�ӿ�URL��Ҫʹ�ô�ǰ׺
	const OAUTH_TOKEN_URL = '/sns/oauth2/access_token?';
	const OAUTH_REFRESH_URL = '/sns/oauth2/refresh_token?';
	const OAUTH_USERINFO_URL = '/sns/userinfo?';
	const OAUTH_AUTH_URL = '/sns/auth?';
	///��ͷ���ص�ַ
	const CUSTOM_SESSION_CREATE = '/customservice/kfsession/create?';
	const CUSTOM_SESSION_CLOSE = '/customservice/kfsession/close?';
	const CUSTOM_SESSION_SWITCH = '/customservice/kfsession/switch?';
	const CUSTOM_SESSION_GET = '/customservice/kfsession/getsession?';
	const CUSTOM_SESSION_GET_LIST = '/customservice/kfsession/getsessionlist?';
	const CUSTOM_SESSION_GET_WAIT = '/customservice/kfsession/getwaitcase?';
	const CS_KF_ACCOUNT_ADD_URL = '/customservice/kfaccount/add?';
	const CS_KF_ACCOUNT_UPDATE_URL = '/customservice/kfaccount/update?';
	const CS_KF_ACCOUNT_DEL_URL = '/customservice/kfaccount/del?';
	const CS_KF_ACCOUNT_UPLOAD_HEADIMG_URL = '/customservice/kfaccount/uploadheadimg?';
	///��ȯ��ص�ַ
	const CARD_CREATE                     = '/card/create?';
	const CARD_DELETE                     = '/card/delete?';
	const CARD_UPDATE                     = '/card/update?';
	const CARD_GET                        = '/card/get?';
        const CARD_USER_GETCARDLIST         = '/card/user/getcardlist?';
        const CARD_BATCHGET                   = '/card/batchget?';
	const CARD_MODIFY_STOCK               = '/card/modifystock?';
	const CARD_LOCATION_BATCHADD          = '/card/location/batchadd?';
	const CARD_LOCATION_BATCHGET          = '/card/location/batchget?';
	const CARD_GETCOLORS                  = '/card/getcolors?';
	const CARD_QRCODE_CREATE              = '/card/qrcode/create?';
	const CARD_CODE_CONSUME               = '/card/code/consume?';
	const CARD_CODE_DECRYPT               = '/card/code/decrypt?';
	const CARD_CODE_GET                   = '/card/code/get?';
	const CARD_CODE_UPDATE                = '/card/code/update?';
	const CARD_CODE_UNAVAILABLE           = '/card/code/unavailable?';
	const CARD_TESTWHILELIST_SET          = '/card/testwhitelist/set?';
	const CARD_MEETINGCARD_UPDATEUSER      = '/card/meetingticket/updateuser?';    //���»�����Ʊ
	const CARD_MEMBERCARD_ACTIVATE        = '/card/membercard/activate?';      //�����Ա��
	const CARD_MEMBERCARD_UPDATEUSER      = '/card/membercard/updateuser?';    //���»�Ա��
	const CARD_MOVIETICKET_UPDATEUSER     = '/card/movieticket/updateuser?';   //���µ�ӰƱ(δ�ӷ���)
	const CARD_BOARDINGPASS_CHECKIN       = '/card/boardingpass/checkin?';     //�ɻ�Ʊ-����ѡ��(δ�ӷ���)
	const CARD_LUCKYMONEY_UPDATE          = '/card/luckymoney/updateuserbalance?';     //���º�����
	const SEMANTIC_API_URL = '/semantic/semproxy/search?'; //�������
	///���ݷ����ӿ�
	static $DATACUBE_URL_ARR = array(        //�û�����
	        'user' => array(
	                'summary' => '/datacube/getusersummary?',		//��ȡ�û��������ݣ�getusersummary��
	                'cumulate' => '/datacube/getusercumulate?',		//��ȡ�ۼ��û����ݣ�getusercumulate��
	        ),
	        'article' => array(            //ͼ�ķ���
	                'summary' => '/datacube/getarticlesummary?',		//��ȡͼ��Ⱥ��ÿ�����ݣ�getarticlesummary��
	                'total' => '/datacube/getarticletotal?',		//��ȡͼ��Ⱥ�������ݣ�getarticletotal��
	                'read' => '/datacube/getuserread?',			//��ȡͼ��ͳ�����ݣ�getuserread��
	                'readhour' => '/datacube/getuserreadhour?',		//��ȡͼ��ͳ�Ʒ�ʱ���ݣ�getuserreadhour��
	                'share' => '/datacube/getusershare?',			//��ȡͼ�ķ���ת�����ݣ�getusershare��
	                'sharehour' => '/datacube/getusersharehour?',		//��ȡͼ�ķ���ת����ʱ���ݣ�getusersharehour��
	        ),
	        'upstreammsg' => array(        //��Ϣ����
	                'summary' => '/datacube/getupstreammsg?',		//��ȡ��Ϣ���͸ſ����ݣ�getupstreammsg��
					'hour' => '/datacube/getupstreammsghour?',	//��ȡ��Ϣ���ͷ�ʱ���ݣ�getupstreammsghour��
	                'week' => '/datacube/getupstreammsgweek?',	//��ȡ��Ϣ���������ݣ�getupstreammsgweek��
	                'month' => '/datacube/getupstreammsgmonth?',	//��ȡ��Ϣ���������ݣ�getupstreammsgmonth��
	                'dist' => '/datacube/getupstreammsgdist?',	//��ȡ��Ϣ���ͷֲ����ݣ�getupstreammsgdist��
	                'distweek' => '/datacube/getupstreammsgdistweek?',	//��ȡ��Ϣ���ͷֲ������ݣ�getupstreammsgdistweek��
	               	'distmonth' => '/datacube/getupstreammsgdistmonth?',	//��ȡ��Ϣ���ͷֲ������ݣ�getupstreammsgdistmonth��
	        ),
	        'interface' => array(        //�ӿڷ���
	                'summary' => '/datacube/getinterfacesummary?',	//��ȡ�ӿڷ������ݣ�getinterfacesummary��
	                'summaryhour' => '/datacube/getinterfacesummaryhour?',	//��ȡ�ӿڷ�����ʱ���ݣ�getinterfacesummaryhour��
	        )
	);
	///΢��ҡһҡ�ܱ�
	const SHAKEAROUND_DEVICE_APPLYID = '/shakearound/device/applyid?';//�����豸ID
    const SHAKEAROUND_DEVICE_UPDATE = '/shakearound/device/update?';//�༭�豸��Ϣ
	const SHAKEAROUND_DEVICE_SEARCH = '/shakearound/device/search?';//��ѯ�豸�б�
	const SHAKEAROUND_DEVICE_BINDLOCATION = '/shakearound/device/bindlocation?';//�����豸���ŵ�ID�Ĺ�ϵ
	const SHAKEAROUND_DEVICE_BINDPAGE = '/shakearound/device/bindpage?';//�����豸��ҳ��İ󶨹�ϵ
    const SHAKEAROUND_MATERIAL_ADD = '/shakearound/material/add?';//�ϴ�ҡһҡͼƬ�ز�
	const SHAKEAROUND_PAGE_ADD = '/shakearound/page/add?';//����ҳ��
	const SHAKEAROUND_PAGE_UPDATE = '/shakearound/page/update?';//�༭ҳ��
	const SHAKEAROUND_PAGE_SEARCH = '/shakearound/page/search?';//��ѯҳ���б�
	const SHAKEAROUND_PAGE_DELETE = '/shakearound/page/delete?';//ɾ��ҳ��
	const SHAKEAROUND_USER_GETSHAKEINFO = '/shakearound/user/getshakeinfo?';//��ȡҡ�ܱߵ��豸���û���Ϣ
	const SHAKEAROUND_STATISTICS_DEVICE = '/shakearound/statistics/device?';//���豸Ϊά�ȵ�����ͳ�ƽӿ�
    const SHAKEAROUND_STATISTICS_PAGE = '/shakearound/statistics/page?';//��ҳ��Ϊά�ȵ�����ͳ�ƽӿ�
	///΢��С����ؽӿ�
	const MERCHANT_ORDER_GETBYID = '/merchant/order/getbyid?';//���ݶ���ID��ȡ��������
	const MERCHANT_ORDER_GETBYFILTER = '/merchant/order/getbyfilter?';//���ݶ���״̬/����ʱ���ȡ��������
	const MERCHANT_ORDER_SETDELIVERY = '/merchant/order/setdelivery?';//���ö���������Ϣ
	const MERCHANT_ORDER_CLOSE = '/merchant/order/close?';//�رն���

	private $token;
	private $encodingAesKey;
	private $encrypt_type;
	private $appid;
	private $appsecret;
	private $access_token;
	private $jsapi_ticket;
	private $api_ticket;
	private $user_token;
	private $partnerid;
	private $partnerkey;
	private $paysignkey;
	private $postxml;
	private $_msg;
	private $_funcflag = false;
	private $_receive;
	private $_text_filter = true;
	public $debug =  false;
	public $errCode = 40001;
	public $errMsg = "no access";
	public $logcallback;

	public function __construct($options)
	{
		$this->token = isset($options['token'])?$options['token']:'';
		$this->encodingAesKey = isset($options['encodingaeskey'])?$options['encodingaeskey']:'';
		$this->appid = isset($options['appid'])?$options['appid']:'';
		$this->appsecret = isset($options['appsecret'])?$options['appsecret']:'';
		$this->debug = isset($options['debug'])?$options['debug']:false;
		$this->logcallback = isset($options['logcallback'])?$options['logcallback']:false;
	}

	/**
	 * For weixin server validation
	 */
	private function checkSignature($str='')
	{
        $signature = isset($_GET["signature"])?$_GET["signature"]:'';
	    $signature = isset($_GET["msg_signature"])?$_GET["msg_signature"]:$signature; //������ڼ�����֤���ü�����֤��
        $timestamp = isset($_GET["timestamp"])?$_GET["timestamp"]:'';
        $nonce = isset($_GET["nonce"])?$_GET["nonce"]:'';

		$token = $this->token;
		$tmpArr = array($token, $timestamp, $nonce,$str);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * For weixin server validation
	 * @param bool $return �Ƿ񷵻�
	 */
	public function valid($return=false)
    {
        $encryptStr="";
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $postStr = file_get_contents("php://input");
            $array = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->encrypt_type = isset($_GET["encrypt_type"]) ? $_GET["encrypt_type"]: '';
            if ($this->encrypt_type == 'aes') { //aes����
                $this->log($postStr);
            	$encryptStr = $array['Encrypt'];
            	$pc = new Prpcrypt($this->encodingAesKey);
            	$array = $pc->decrypt($encryptStr,$this->appid);
            	if (!isset($array[0]) || ($array[0] != 0)) {
            	    if (!$return) {
            	        die('decrypt error!');
            	    } else {
            	        return false;
            	    }
            	}
            	$this->postxml = $array[1];
            	if (!$this->appid)
            	    $this->appid = $array[2];//Ϊ��û��appid�Ķ��ĺš�
            } else {
                $this->postxml = $postStr;
            }
        } elseif (isset($_GET["echostr"])) {
        	$echoStr = $_GET["echostr"];
        	if ($return) {
        		if ($this->checkSignature())
        			return $echoStr;
        		else
        			return false;
        	} else {
        		if ($this->checkSignature())
        			die($echoStr);
        		else
        			die('no access');
        	}
        }

        if (!$this->checkSignature($encryptStr)) {
        	if ($return)
        		return false;
        	else
        		die('no access');
        }
        return true;
    }

	/**
	 * ���÷�����Ϣ
	 * @param array $msg ��Ϣ����
	 * @param bool $append �Ƿ���ԭ��Ϣ����׷��
	 */
    public function Message($msg = '',$append = false){
    		if (is_null($msg)) {
    			$this->_msg =array();
    		}elseif (is_array($msg)) {
    			if ($append)
    				$this->_msg = array_merge($this->_msg,$msg);
    			else
    				$this->_msg = $msg;
    			return $this->_msg;
    		} else {
    			return $this->_msg;
    		}
    }

    /**
     * ������Ϣ���Ǳ��־���ٷ���ȡ���Դ˹��ܵ�֧��
     */
    public function setFuncFlag($flag) {
    		$this->_funcflag = $flag;
    		return $this;
    }

    /**
     * ��־��¼���ɱ����ء�
     * @param mixed $log ������־
     * @return mixed
     */
    protected function log($log){
    		if ($this->debug && function_exists($this->logcallback)) {
    			if (is_array($log)) $log = print_r($log,true);
    			return call_user_func($this->logcallback,$log);
    		}
    }

    /**
     * ��ȡ΢�ŷ�������������Ϣ
     */
	public function getRev()
	{
		if ($this->_receive) return $this;
		$postStr = !empty($this->postxml)?$this->postxml:file_get_contents("php://input");
		//���ʹ�������ֲ������valid()���������
		$this->log($postStr);
		if (!empty($postStr)) {
			$this->_receive = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		}
		return $this;
	}

	/**
	 * ��ȡ΢�ŷ�������������Ϣ
	 */
	public function getRevData()
	{
		return $this->_receive;
	}

	/**
	 * ��ȡ��Ϣ������
	 */
	public function getRevFrom() {
		if (isset($this->_receive['FromUserName']))
			return $this->_receive['FromUserName'];
		else
			return false;
	}

	/**
	 * ��ȡ��Ϣ������
	 */
	public function getRevTo() {
		if (isset($this->_receive['ToUserName']))
			return $this->_receive['ToUserName'];
		else
			return false;
	}

	/**
	 * ��ȡ������Ϣ������
	 */
	public function getRevType() {
		if (isset($this->_receive['MsgType']))
			return $this->_receive['MsgType'];
		else
			return false;
	}

	/**
	 * ��ȡ��ϢID
	 */
	public function getRevID() {
		if (isset($this->_receive['MsgId']))
			return $this->_receive['MsgId'];
		else
			return false;
	}

	/**
	 * ��ȡ��Ϣ����ʱ��
	 */
	public function getRevCtime() {
		if (isset($this->_receive['CreateTime']))
			return $this->_receive['CreateTime'];
		else
			return false;
	}

	/**
	 * ��ȡ������Ϣ��������
	 */
	public function getRevContent(){
		if (isset($this->_receive['Content']))
			return $this->_receive['Content'];
		else if (isset($this->_receive['Recognition'])) //��ȡ����ʶ���������ݣ������뿪ͨ
			return $this->_receive['Recognition'];
		else
			return false;
	}

	/**
	 * ��ȡ������ϢͼƬ
	 */
	public function getRevPic(){
		if (isset($this->_receive['PicUrl']))
			return array(
				'mediaid'=>$this->_receive['MediaId'],
				'picurl'=>(string)$this->_receive['PicUrl'],    //��ֹpicurlΪ�յ��½�������
			);
		else
			return false;
	}

	/**
	 * ��ȡ������Ϣ����
	 */
	public function getRevLink(){
		if (isset($this->_receive['Url'])){
			return array(
				'url'=>$this->_receive['Url'],
				'title'=>$this->_receive['Title'],
				'description'=>$this->_receive['Description']
			);
		} else
			return false;
	}

	/**
	 * ��ȡ���յ���λ��
	 */
	public function getRevGeo(){
		if (isset($this->_receive['Location_X'])){
			return array(
				'x'=>$this->_receive['Location_X'],
				'y'=>$this->_receive['Location_Y'],
				'scale'=>$this->_receive['Scale'],
				'label'=>$this->_receive['Label']
			);
		} else
			return false;
	}

	/**
	 * ��ȡ�ϱ�����λ���¼�
	 */
	public function getRevEventGeo(){
        	if (isset($this->_receive['Latitude'])){
        		 return array(
				'x'=>$this->_receive['Latitude'],
				'y'=>$this->_receive['Longitude'],
				'precision'=>$this->_receive['Precision'],
			);
		} else
			return false;
	}

	/**
	 * ��ȡ�����¼�����
	 */
	public function getRevEvent(){
		if (isset($this->_receive['Event'])){
			$array['event'] = $this->_receive['Event'];
		}
		if (isset($this->_receive['EventKey'])){
			$array['key'] = $this->_receive['EventKey'];
		}
		if (isset($array) && count($array) > 0) {
			return $array;
		} else {
			return false;
		}
	}

	/**
	 * ��ȡ�Զ���˵���ɨ�����¼���Ϣ
	 *
	 * �¼�����Ϊ��������ʱ����ô˷�����Ч
	 * Event	 �¼����ͣ�scancode_push
	 * Event	 �¼����ͣ�scancode_waitmsg
	 *
	 * @return: array | false
	 * array (
	 *     'ScanType'=>'qrcode',
	 *     'ScanResult'=>'123123'
	 * )
	 */
	public function getRevScanInfo(){
		if (isset($this->_receive['ScanCodeInfo'])){
		    if (!is_array($this->_receive['ScanCodeInfo'])) {
		        $array=(array)$this->_receive['ScanCodeInfo'];
		        $this->_receive['ScanCodeInfo']=$array;
		    }else {
		        $array=$this->_receive['ScanCodeInfo'];
		    }
		}
		if (isset($array) && count($array) > 0) {
			return $array;
		} else {
			return false;
		}
	}

	/**
	 * ��ȡ�Զ���˵���ͼƬ�����¼���Ϣ
	 *
	 * �¼�����Ϊ��������ʱ����ô˷�����Ч
	 * Event	 �¼����ͣ�pic_sysphoto        ����ϵͳ���շ�ͼ���¼�����
	 * Event	 �¼����ͣ�pic_photo_or_album  �������ջ�����ᷢͼ���¼�����
	 * Event	 �¼����ͣ�pic_weixin          ����΢����ᷢͼ�����¼�����
	 *
	 * @return: array | false
	 * array (
	 *   'Count' => '2',
	 *   'PicList' =>array (
	 *         'item' =>array (
	 *             0 =>array ('PicMd5Sum' => 'aaae42617cf2a14342d96005af53624c'),
	 *             1 =>array ('PicMd5Sum' => '149bd39e296860a2adc2f1bb81616ff8'),
	 *         ),
	 *   ),
	 * )
	 *
	 */
	public function getRevSendPicsInfo(){
		if (isset($this->_receive['SendPicsInfo'])){
		    if (!is_array($this->_receive['SendPicsInfo'])) {
		        $array=(array)$this->_receive['SendPicsInfo'];
		        if (isset($array['PicList'])){
		            $array['PicList']=(array)$array['PicList'];
		            $item=$array['PicList']['item'];
		            $array['PicList']['item']=array();
		            foreach ( $item as $key => $value ){
		                $array['PicList']['item'][$key]=(array)$value;
		            }
		        }
		        $this->_receive['SendPicsInfo']=$array;
		    } else {
		        $array=$this->_receive['SendPicsInfo'];
		    }
		}
		if (isset($array) && count($array) > 0) {
			return $array;
		} else {
			return false;
		}
	}

	/**
	 * ��ȡ�Զ���˵��ĵ���λ��ѡ�����¼�����
	 *
	 * �¼�����Ϊ����ʱ����Ե��ô˷�����Ч
	 * Event	 �¼����ͣ�location_select        ��������λ��ѡ�������¼�����
	 *
	 * @return: array | false
	 * array (
	 *   'Location_X' => '33.731655000061',
	 *   'Location_Y' => '113.29955200008047',
	 *   'Scale' => '16',
	 *   'Label' => 'ĳĳ��ĳĳ��ĳĳ·',
	 *   'Poiname' => '',
	 * )
	 *
	 */
	public function getRevSendGeoInfo(){
	    if (isset($this->_receive['SendLocationInfo'])){
	        if (!is_array($this->_receive['SendLocationInfo'])) {
	            $array=(array)$this->_receive['SendLocationInfo'];
	            if (empty($array['Poiname'])) {
	                $array['Poiname']="";
	            }
	            if (empty($array['Label'])) {
	                $array['Label']="";
	            }
	            $this->_receive['SendLocationInfo']=$array;
	        } else {
	            $array=$this->_receive['SendLocationInfo'];
	        }
	    }
	    if (isset($array) && count($array) > 0) {
	        return $array;
	    } else {
	        return false;
	    }
	}

	/**
	 * ��ȡ������������
	 */
	public function getRevVoice(){
		if (isset($this->_receive['MediaId'])){
			return array(
				'mediaid'=>$this->_receive['MediaId'],
				'format'=>$this->_receive['Format'],
			);
		} else
			return false;
	}

	/**
	 * ��ȡ������Ƶ����
	 */
	public function getRevVideo(){
		if (isset($this->_receive['MediaId'])){
			return array(
					'mediaid'=>$this->_receive['MediaId'],
					'thumbmediaid'=>$this->_receive['ThumbMediaId']
			);
		} else
			return false;
	}

	/**
	 * ��ȡ����TICKET
	 */
	public function getRevTicket(){
		if (isset($this->_receive['Ticket'])){
			return $this->_receive['Ticket'];
		} else
			return false;
	}

	/**
	* ��ȡ��ά��ĳ���ֵ
	*/
	public function getRevSceneId (){
		if (isset($this->_receive['EventKey'])){
			return str_replace('qrscene_','',$this->_receive['EventKey']);
		} else{
			return false;
		}
	}

	/**
	* ��ȡ�������͵���ϢID
	* ������֤���������ͨ����ϢMsgId��һ��
	* ��EventΪ MASSSENDJOBFINISH �� TEMPLATESENDJOBFINISH
	*/
	public function getRevTplMsgID(){
		if (isset($this->_receive['MsgID'])){
			return $this->_receive['MsgID'];
		} else
			return false;
	}

	/**
	* ��ȡģ����Ϣ����״̬
	*/
	public function getRevStatus(){
		if (isset($this->_receive['Status'])){
			return $this->_receive['Status'];
		} else
			return false;
	}

	/**
	* ��ȡȺ����ģ����Ϣ���ͽ��
	* ��EventΪ MASSSENDJOBFINISH �� TEMPLATESENDJOBFINISH�����߼�Ⱥ��/ģ����Ϣ
	*/
	public function getRevResult(){
		if (isset($this->_receive['Status'])) //�����Ƿ�ɹ�������ķ���ֵ��ο� �߼�Ⱥ��/ģ����Ϣ ���¼�����˵��
			$array['Status'] = $this->_receive['Status'];
		if (isset($this->_receive['MsgID'])) //���͵���Ϣid
			$array['MsgID'] = $this->_receive['MsgID'];

		//���½���Ⱥ����Ϣʱ�Ż��е��¼�����
		if (isset($this->_receive['TotalCount']))     //�����openid�б��ڷ�˿����
			$array['TotalCount'] = $this->_receive['TotalCount'];
		if (isset($this->_receive['FilterCount']))    //���ˣ�������ָ�ض��������Ա�Ĺ��ˡ��û����þ��յĹ��ˣ��û������ѳ�4���Ĺ��ˣ���׼�����͵ķ�˿��
			$array['FilterCount'] = $this->_receive['FilterCount'];
		if (isset($this->_receive['SentCount']))     //���ͳɹ��ķ�˿��
			$array['SentCount'] = $this->_receive['SentCount'];
		if (isset($this->_receive['ErrorCount']))    //����ʧ�ܵķ�˿��
			$array['ErrorCount'] = $this->_receive['ErrorCount'];
		if (isset($array) && count($array) > 0) {
		    return $array;
		} else {
		    return false;
		}
	}

	/**
	 * ��ȡ��ͷ��Ự״̬�����¼� - ����Ự
	 * ��EventΪ kfcreatesession ������Ự
	 * @return string | boolean  ���ط��䵽�Ŀͷ�
	 */
	public function getRevKFCreate(){
		if (isset($this->_receive['KfAccount'])){
			return $this->_receive['KfAccount'];
		} else
			return false;
	}

	/**
	 * ��ȡ��ͷ��Ự״̬�����¼� - �رջỰ
	 * ��EventΪ kfclosesession ���رջỰ
	 * @return string | boolean  ���ط��䵽�Ŀͷ�
	 */
	public function getRevKFClose(){
	    if (isset($this->_receive['KfAccount'])){
	        return $this->_receive['KfAccount'];
	    } else
	        return false;
	}

	/**
	 * ��ȡ��ͷ��Ự״̬�����¼� - ת�ӻỰ
	 * ��EventΪ kfswitchsession ��ת�ӻỰ
	 * @return array | boolean  ���ط��䵽�Ŀͷ�
	 * {
	 *     'FromKfAccount' => '',      //ԭ����ͷ�
	 *     'ToKfAccount' => ''            //ת�ӵ��ͷ�
	 * }
	 */
	public function getRevKFSwitch(){
	    if (isset($this->_receive['FromKfAccount']))     //ԭ����ͷ�
	        $array['FromKfAccount'] = $this->_receive['FromKfAccount'];
	    if (isset($this->_receive['ToKfAccount']))    //ת�ӵ��ͷ�
	        $array['ToKfAccount'] = $this->_receive['ToKfAccount'];
	    if (isset($array) && count($array) > 0) {
	        return $array;
	    } else {
	        return false;
	    }
	}

	/**
	 * ��ȡ��ȯ�¼����� - ��������Ƿ�ͨ��
	 * ��EventΪ card_pass_check(���ͨ��) �� card_not_pass_check(δͨ��)
	 * @return string|boolean  ���ؿ�ȯID
	 */
	public function getRevCardPass(){
	    if (isset($this->_receive['CardId']))
	        return $this->_receive['CardId'];
	    else
	        return false;
	}

	/**
	 * ��ȡ��ȯ�¼����� - ��ȡ��ȯ
	 * ��EventΪ user_get_card(�û���ȡ��ȯ)
	 * @return array|boolean
	 */
	public function getRevCardGet(){
	    if (isset($this->_receive['CardId']))     //��ȯ ID
	        $array['CardId'] = $this->_receive['CardId'];
	    if (isset($this->_receive['IsGiveByFriend']))    //�Ƿ�Ϊת����1 �����ǣ�0 �����
	        $array['IsGiveByFriend'] = $this->_receive['IsGiveByFriend'];
	        $array['OldUserCardCode'] = $this->_receive['OldUserCardCode'];
	    if (isset($this->_receive['UserCardCode']) && !empty($this->_receive['UserCardCode'])) //code ���кš��Զ��� code �����Զ��� code�Ŀ�ȯ����ȡ��֧���¼����͡�
	        $array['UserCardCode'] = $this->_receive['UserCardCode'];
	    if (isset($array) && count($array) > 0) {
	        return $array;
	    } else {
	        return false;
	    }
	}

	/**
	 * ��ȡ��ȯ�¼����� - ɾ����ȯ
	 * ��EventΪ user_del_card(�û�ɾ����ȯ)
	 * @return array|boolean
	 */
	public function getRevCardDel(){
	    if (isset($this->_receive['CardId']))     //��ȯ ID
	        $array['CardId'] = $this->_receive['CardId'];
	    if (isset($this->_receive['UserCardCode']) && !empty($this->_receive['UserCardCode'])) //code ���кš��Զ��� code �����Զ��� code�Ŀ�ȯ����ȡ��֧���¼����͡�
	        $array['UserCardCode'] = $this->_receive['UserCardCode'];
	    if (isset($array) && count($array) > 0) {
	        return $array;
	    } else {
	        return false;
	    }
	}

	/**
	 * ��ȡ����ID - ��������֪ͨ
	 * ��EventΪ merchant_order(��������֪ͨ)
	 * @return orderId|boolean
	 */
	public function getRevOrderId(){
		if (isset($this->_receive['OrderId']))     //���� ID
			return $this->_receive['OrderId'];
		else
			return false;
	}

	public static function xmlSafeStr($str)
	{
		return '<![CDATA['.preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/",'',$str).']]>';
	}

	/**
	 * ����XML����
	 * @param mixed $data ����
	 * @return string
	 */
	public static function data_to_xml($data) {
	    $xml = '';
	    foreach ($data as $key => $val) {
	        is_numeric($key) && $key = "item id=\"$key\"";
	        $xml    .=  "<$key>";
	        $xml    .=  ( is_array($val) || is_object($val)) ? self::data_to_xml($val)  : self::xmlSafeStr($val);
	        list($key, ) = explode(' ', $key);
	        $xml    .=  "</$key>";
	    }
	    return $xml;
	}

	/**
	 * XML����
	 * @param mixed $data ����
	 * @param string $root ���ڵ���
	 * @param string $item �����������ӽڵ���
	 * @param string $attr ���ڵ�����
	 * @param string $id   ���������ӽڵ�keyת����������
	 * @param string $encoding ���ݱ���
	 * @return string
	*/
	public function xml_encode($data, $root='xml', $item='item', $attr='', $id='id', $encoding='utf-8') {
	    if(is_array($attr)){
	        $_attr = array();
	        foreach ($attr as $key => $value) {
	            $_attr[] = "{$key}=\"{$value}\"";
	        }
	        $attr = implode(' ', $_attr);
	    }
	    $attr   = trim($attr);
	    $attr   = empty($attr) ? '' : " {$attr}";
	    $xml   = "<{$root}{$attr}>";
	    $xml   .= self::data_to_xml($data, $item, $id);
	    $xml   .= "</{$root}>";
	    return $xml;
	}

	/**
	 * �������ֻظ�\r\n���з�
	 * @param string $text
	 * @return string|mixed
	 */
	private function _auto_text_filter($text) {
		if (!$this->_text_filter) return $text;
		return str_replace("\r\n", "\n", $text);
	}

	/**
	 * ���ûظ���Ϣ
	 * Example: $obj->text('hello')->reply();
	 * @param string $text
	 */
	public function text($text='')
	{
		$FuncFlag = $this->_funcflag ? 1 : 0;
		$msg = array(
			'ToUserName' => $this->getRevFrom(),
			'FromUserName'=>$this->getRevTo(),
			'MsgType'=>self::MSGTYPE_TEXT,
			'Content'=>$this->_auto_text_filter($text),
			'CreateTime'=>time(),
			'FuncFlag'=>$FuncFlag
		);
		$this->Message($msg);
		return $this;
	}
	/**
	 * ���ûظ���Ϣ
	 * Example: $obj->image('media_id')->reply();
	 * @param string $mediaid
	 */
	public function image($mediaid='')
	{
		$FuncFlag = $this->_funcflag ? 1 : 0;
		$msg = array(
			'ToUserName' => $this->getRevFrom(),
			'FromUserName'=>$this->getRevTo(),
			'MsgType'=>self::MSGTYPE_IMAGE,
			'Image'=>array('MediaId'=>$mediaid),
			'CreateTime'=>time(),
			'FuncFlag'=>$FuncFlag
		);
		$this->Message($msg);
		return $this;
	}

	/**
	 * ���ûظ���Ϣ
	 * Example: $obj->voice('media_id')->reply();
	 * @param string $mediaid
	 */
	public function voice($mediaid='')
	{
		$FuncFlag = $this->_funcflag ? 1 : 0;
		$msg = array(
			'ToUserName' => $this->getRevFrom(),
			'FromUserName'=>$this->getRevTo(),
			'MsgType'=>self::MSGTYPE_VOICE,
			'Voice'=>array('MediaId'=>$mediaid),
			'CreateTime'=>time(),
			'FuncFlag'=>$FuncFlag
		);
		$this->Message($msg);
		return $this;
	}

	/**
	 * ���ûظ���Ϣ
	 * Example: $obj->video('media_id','title','description')->reply();
	 * @param string $mediaid
	 */
	public function video($mediaid='',$title='',$description='')
	{
		$FuncFlag = $this->_funcflag ? 1 : 0;
		$msg = array(
			'ToUserName' => $this->getRevFrom(),
			'FromUserName'=>$this->getRevTo(),
			'MsgType'=>self::MSGTYPE_VIDEO,
			'Video'=>array(
			        'MediaId'=>$mediaid,
			        'Title'=>$title,
			        'Description'=>$description
			),
			'CreateTime'=>time(),
			'FuncFlag'=>$FuncFlag
		);
		$this->Message($msg);
		return $this;
	}

	/**
	 * ���ûظ�����
	 * @param string $title
	 * @param string $desc
	 * @param string $musicurl
	 * @param string $hgmusicurl
	 * @param string $thumbmediaid ����ͼƬ����ͼ��ý��id���Ǳ���
	 */
	public function music($title,$desc,$musicurl,$hgmusicurl='',$thumbmediaid='') {
		$FuncFlag = $this->_funcflag ? 1 : 0;
		$msg = array(
			'ToUserName' => $this->getRevFrom(),
			'FromUserName'=>$this->getRevTo(),
			'CreateTime'=>time(),
			'MsgType'=>self::MSGTYPE_MUSIC,
			'Music'=>array(
				'Title'=>$title,
				'Description'=>$desc,
				'MusicUrl'=>$musicurl,
				'HQMusicUrl'=>$hgmusicurl
			),
			'FuncFlag'=>$FuncFlag
		);
		if ($thumbmediaid) {
			$msg['Music']['ThumbMediaId'] = $thumbmediaid;
		}
		$this->Message($msg);
		return $this;
	}

	/**
	 * ���ûظ�ͼ��
	 * @param array $newsData
	 * ����ṹ:
	 *  array(
	 *  	"0"=>array(
	 *  		'Title'=>'msg title',
	 *  		'Description'=>'summary text',
	 *  		'PicUrl'=>'http://www.domain.com/1.jpg',
	 *  		'Url'=>'http://www.domain.com/1.html'
	 *  	),
	 *  	"1"=>....
	 *  )
	 */
	public function news($newsData=array())
	{
		$FuncFlag = $this->_funcflag ? 1 : 0;
		$count = count($newsData);

		$msg = array(
			'ToUserName' => $this->getRevFrom(),
			'FromUserName'=>$this->getRevTo(),
			'MsgType'=>self::MSGTYPE_NEWS,
			'CreateTime'=>time(),
			'ArticleCount'=>$count,
			'Articles'=>$newsData,
			'FuncFlag'=>$FuncFlag
		);
		$this->Message($msg);
		return $this;
	}

	/**
	 *
	 * �ظ�΢�ŷ�����, �˺���֧����ʽ����
	 * Example: $this->text('msg tips')->reply();
	 * @param string $msg Ҫ���͵���Ϣ, Ĭ��ȡ$this->_msg
	 * @param bool $return �Ƿ񷵻���Ϣ�����׳�������� Ĭ��:��
	 */
	public function reply($msg=array(),$return = false)
	{
		if (empty($msg)) {
		    if (empty($this->_msg))   //��ֹ�������ûظ����ݣ�ֱ�ӵ���reply���������쳣
		        return false;
			$msg = $this->_msg;
		}
		$xmldata=  $this->xml_encode($msg);
		$this->log($xmldata);
		if ($this->encrypt_type == 'aes') { //�����Դ��ϢΪ���ܷ�ʽ
		    $pc = new Prpcrypt($this->encodingAesKey);
		    $array = $pc->encrypt($xmldata, $this->appid);
		    $ret = $array[0];
		    if ($ret != 0) {
		        $this->log('encrypt err!');
		        return false;
		    }
		    $timestamp = time();
		    $nonce = rand(77,999)*rand(605,888)*rand(11,99);
		    $encrypt = $array[1];
		    $tmpArr = array($this->token, $timestamp, $nonce,$encrypt);//����ͨ����ƽ̨����һ�����ܵ�����
		    sort($tmpArr, SORT_STRING);
		    $signature = implode($tmpArr);
		    $signature = sha1($signature);
		    $xmldata = $this->generate($encrypt, $signature, $timestamp, $nonce);
		    $this->log($xmldata);
		}
		if ($return)
			return $xmldata;
		else
			echo $xmldata;
	}

    /**
     * xml��ʽ���ܣ�������Ϊ���ܷ�ʽʱ����
     */
	private function generate($encrypt, $signature, $timestamp, $nonce)
	{
	    //��ʽ��������Ϣ
	    $format = "<xml>
<Encrypt><![CDATA[%s]]></Encrypt>
<MsgSignature><![CDATA[%s]]></MsgSignature>
<TimeStamp>%s</TimeStamp>
<Nonce><![CDATA[%s]]></Nonce>
</xml>";
	    return sprintf($format, $encrypt, $signature, $timestamp, $nonce);
	}

	/**
	 * GET ����
	 * @param string $url
	 */
	private function http_get($url){
		$oCurl = curl_init();
		if(stripos($url,"https://")!==FALSE){
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
		}
		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if(intval($aStatus["http_code"])==200){
			return $sContent;
		}else{
			return false;
		}
	}

	/**
	 * POST ����
	 * @param string $url
	 * @param array $param
	 * @param boolean $post_file �Ƿ��ļ��ϴ�
	 * @return string content
	 */
	private function http_post($url,$param,$post_file=false){
		$oCurl = curl_init();
		if(stripos($url,"https://")!==FALSE){
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
		}
	        if (PHP_VERSION_ID >= 50500 && class_exists('\CURLFile')) {
	            	$is_curlFile = true;
	        } else {
	        	$is_curlFile = false;
	            	if (defined('CURLOPT_SAFE_UPLOAD')) {
	                	curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, false);
	            	}
	        }
		if (is_string($param)) {
	            	$strPOST = $param;
	        }elseif($post_file) {
	            	if($is_curlFile) {
		                foreach ($param as $key => $val) {
		                    	if (substr($val, 0, 1) == '@') {
		                        	$param[$key] = new \CURLFile(realpath(substr($val,1)));
		                    	}
		                }
	            	}
			$strPOST = $param;
		} else {
			$aPOST = array();
			foreach($param as $key=>$val){
				$aPOST[] = $key."=".urlencode($val);
			}
			$strPOST =  join("&", $aPOST);
		}
		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($oCurl, CURLOPT_POST,true);
		curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if(intval($aStatus["http_code"])==200){
			return $sContent;
		}else{
			return false;
		}
	}

	/**
	 * ���û��棬��������
	 * @param string $cachename
	 * @param mixed $value
	 * @param int $expired
	 * @return boolean
	 */
	protected function setCache($cachename,$value,$expired){
		//TODO: set cache implementation
		return false;
	}

	/**
	 * ��ȡ���棬��������
	 * @param string $cachename
	 * @return mixed
	 */
	protected function getCache($cachename){
		//TODO: get cache implementation
		return false;
	}

	/**
	 * ������棬��������
	 * @param string $cachename
	 * @return boolean
	 */
	protected function removeCache($cachename){
		//TODO: remove cache implementation
		return false;
	}

	/**
	 * ��ȡaccess_token
	 * @param string $appid �������ʼ��ʱ���ṩ�����Ϊ��
	 * @param string $appsecret �������ʼ��ʱ���ṩ�����Ϊ��
	 * @param string $token �ֶ�ָ��access_token���Ǳ�Ҫ�����������
	 */
	public function checkAuth($appid='',$appsecret='',$token=''){
		if (!$appid || !$appsecret) {
			$appid = $this->appid;
			$appsecret = $this->appsecret;
		}
		if ($token) { //�ֶ�ָ��token������ʹ��
		    $this->access_token=$token;
		    return $this->access_token;
		}

		$authname = 'wechat_access_token'.$appid;
		if ($rs = $this->getCache($authname))  {
			$this->access_token = $rs;
			return $rs;
		}

		$result = $this->http_get(self::API_URL_PREFIX.self::AUTH_URL.'appid='.$appid.'&secret='.$appsecret);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			$this->access_token = $json['access_token'];
			$expire = $json['expires_in'] ? intval($json['expires_in'])-100 : 3600;
			$this->setCache($authname,$this->access_token,$expire);
			return $this->access_token;
		}
		return false;
	}

	/**
	 * ɾ����֤����
	 * @param string $appid
	 */
	public function resetAuth($appid=''){
		if (!$appid) $appid = $this->appid;
		$this->access_token = '';
		$authname = 'wechat_access_token'.$appid;
		$this->removeCache($authname);
		return true;
	}

	/**
	 * ɾ��JSAPI��ȨTICKET
	 * @param string $appid ���ڶ��appidʱʹ��
	 */
	public function resetJsTicket($appid=''){
		if (!$appid) $appid = $this->appid;
		$this->jsapi_ticket = '';
		$authname = 'wechat_jsapi_ticket'.$appid;
		$this->removeCache($authname);
		return true;
	}

	/**
	 * ��ȡJSAPI��ȨTICKET
	 * @param string $appid ���ڶ��appidʱʹ��,�ɿ�
	 * @param string $jsapi_ticket �ֶ�ָ��jsapi_ticket���Ǳ�Ҫ�����������
	 */
	public function getJsTicket($appid='',$jsapi_ticket=''){
		if (!$this->access_token && !$this->checkAuth()) return false;
		if (!$appid) $appid = $this->appid;
		if ($jsapi_ticket) { //�ֶ�ָ��token������ʹ��
		    $this->jsapi_ticket = $jsapi_ticket;
		    return $this->jsapi_ticket;
		}
		$authname = 'wechat_jsapi_ticket'.$appid;
		if ($rs = $this->getCache($authname))  {
			$this->jsapi_ticket = $rs;
			return $rs;
		}
		$result = $this->http_get(self::API_URL_PREFIX.self::GET_TICKET_URL.'access_token='.$this->access_token.'&type=jsapi');
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			$this->jsapi_ticket = $json['ticket'];
			$expire = $json['expires_in'] ? intval($json['expires_in'])-100 : 3600;
			$this->setCache($authname,$this->jsapi_ticket,$expire);
			return $this->jsapi_ticket;
		}
		return false;
	}


	/**
	 * ��ȡJsApiʹ��ǩ��
	 * @param string $url ��ҳ��URL���Զ�����#������沿��
	 * @param string $timestamp ��ǰʱ��� (Ϊ�����Զ�����)
	 * @param string $noncestr ����� (Ϊ�����Զ�����)
	 * @param string $appid ���ڶ��appidʱʹ��,�ɿ�
	 * @return array|bool ����ǩ���ִ�
	 */
	public function getJsSign($url, $timestamp=0, $noncestr='', $appid=''){
	    if (!$this->jsapi_ticket && !$this->getJsTicket($appid) || !$url) return false;
	    if (!$timestamp)
	        $timestamp = time();
	    if (!$noncestr)
	        $noncestr = $this->generateNonceStr();
	    $ret = strpos($url,'#');
	    if ($ret)
	        $url = substr($url,0,$ret);
	    $url = trim($url);
	    if (empty($url))
	        return false;
	    $arrdata = array("timestamp" => $timestamp, "noncestr" => $noncestr, "url" => $url, "jsapi_ticket" => $this->jsapi_ticket);
	    $sign = $this->getSignature($arrdata);
	    if (!$sign)
	        return false;
	    $signPackage = array(
	            "appId"     => $this->appid,
	            "nonceStr"  => $noncestr,
	            "timestamp" => $timestamp,
	            "url"       => $url,
	            "signature" => $sign
	    );
	    return $signPackage;
	}

    /**
     * ��ȡ��ȯǩ��cardSign
     * @param string $card_type ��ȯ�����ͣ�����Ϊ�գ��ٷ�jssdk�ĵ�˵���ֵ�ɿգ���ǩ����֤�����ֱ������ֵ���ٷ��ĵ������ǿӣ�
     * @param string $card_id ��ȯ��ID���ɿ�
     * @param string $location_id ��ȯ�������ŵ�ID���ɿ�
     * @param string $timestamp ��ǰʱ��� (Ϊ�����Զ�����)
     * @param string $noncestr ����� (Ϊ�����Զ�����)
     * @param string $appid ���ڶ��appidʱʹ��,�ɿ�
     * @return array|bool ����ǩ���ִ�
     */
    public function getCardSign($card_type='',$card_id='',$code='',$location_id='',$timestamp=0, $noncestr='', $appid=''){
        if (!$this->api_ticket && !$this->getJsCardTicket($appid)) return false;
        if (!$timestamp)
            $timestamp = time();
        if (!$noncestr)
            $noncestr = $this->generateNonceStr();
        $arrdata = array("api_ticket" => $this->api_ticket,"app_id" => $this->appid,"card_id" => $card_id,"code" => $code,"card_type" => $card_type,"location_id" => $location_id,"timestamp" => $timestamp, "noncestr" => $noncestr );
        $sign = $this->getTicketSignature($arrdata);
        if (!$sign)
            return false;
        $signPackage = array(
            "cardType"     => $card_type,
            "cardId"       => $card_id,
            "shopId"       => $location_id,         //location_id����shopId
            "nonceStr"  => $noncestr,
            "timestamp" => $timestamp,
            "cardSign" => $sign
        );
        return $signPackage;
    }

	/**
	 * ΢��api��֧������ת���json�ṹ
	 * @param array $arr
	 */
	static function json_encode($arr) {
		if (count($arr) == 0) return "[]";
		$parts = array ();
		$is_list = false;
		//Find out if the given array is a numerical array
		$keys = array_keys ( $arr );
		$max_length = count ( $arr ) - 1;
		if (($keys [0] === 0) && ($keys [$max_length] === $max_length )) { //See if the first key is 0 and last key is length - 1
			$is_list = true;
			for($i = 0; $i < count ( $keys ); $i ++) { //See if each key correspondes to its position
				if ($i != $keys [$i]) { //A key fails at position check.
					$is_list = false; //It is an associative array.
					break;
				}
			}
		}
		foreach ( $arr as $key => $value ) {
			if (is_array ( $value )) { //Custom handling for arrays
				if ($is_list)
					$parts [] = self::json_encode ( $value ); /* :RECURSION: */
				else
					$parts [] = '"' . $key . '":' . self::json_encode ( $value ); /* :RECURSION: */
			} else {
				$str = '';
				if (! $is_list)
					$str = '"' . $key . '":';
				//Custom handling for multiple data types
				if (!is_string ( $value ) && is_numeric ( $value ) && $value<2000000000)
					$str .= $value; //Numbers
				elseif ($value === false)
				$str .= 'false'; //The booleans
				elseif ($value === true)
				$str .= 'true';
				else
					$str .= '"' . addslashes ( $value ) . '"'; //All other things
				// :TODO: Is there any more datatype we should be in the lookout for? (Object?)
				$parts [] = $str;
			}
		}
		$json = implode ( ',', $parts );
		if ($is_list)
			return '[' . $json . ']'; //Return numerical JSON
		return '{' . $json . '}'; //Return associative JSON
	}

	/**
	 * ��ȡǩ��
	 * @param array $arrdata ǩ������
	 * @param string $method ǩ������
	 * @return boolean|string ǩ��ֵ
	 */
	public function getSignature($arrdata,$method="sha1") {
		if (!function_exists($method)) return false;
		ksort($arrdata);
		$paramstring = "";
		foreach($arrdata as $key => $value)
		{
			if(strlen($paramstring) == 0)
				$paramstring .= $key . "=" . $value;
			else
				$paramstring .= "&" . $key . "=" . $value;
		}
		$Sign = $method($paramstring);
		return $Sign;
	}

	/**
	 * ��ȡ΢�ſ�ȯapi_ticket
	 * @param string $appid ���ڶ��appidʱʹ��,�ɿ�
	 * @param string $api_ticket �ֶ�ָ��api_ticket���Ǳ�Ҫ�����������
	 */
	public function getJsCardTicket($appid='',$api_ticket=''){
		if (!$this->access_token && !$this->checkAuth()) return false;
		if (!$appid) $appid = $this->appid;
		if ($api_ticket) { //�ֶ�ָ��token������ʹ��
		    $this->api_ticket = $api_ticket;
		    return $this->api_ticket;
		}
		$authname = 'wechat_api_ticket_wxcard'.$appid;
		if ($rs = $this->getCache($authname))  {
			$this->api_ticket = $rs;
			return $rs;
		}
		$result = $this->http_get(self::API_URL_PREFIX.self::GET_TICKET_URL.'access_token='.$this->access_token.'&type=wx_card');
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			$this->api_ticket = $json['ticket'];
			$expire = $json['expires_in'] ? intval($json['expires_in'])-100 : 3600;
			$this->setCache($authname,$this->api_ticket,$expire);
			return $this->api_ticket;
		}
		return false;
	}

	/**
	 * ��ȡ΢�ſ�ȯǩ��
	 * @param array $arrdata ǩ������
	 * @param string $method ǩ������
	 * @return boolean|string ǩ��ֵ
	 */
	public function getTicketSignature($arrdata,$method="sha1") {
		if (!function_exists($method)) return false;
		$newArray = array();
		foreach($arrdata as $key => $value)
		{
			array_push($newArray,(string)$value);
		}
		sort($newArray,SORT_STRING);
		return $method(implode($newArray));
	}

	/**
	 * ��������ִ�
	 * @param number $length ���ȣ�Ĭ��Ϊ16���Ϊ32�ֽ�
	 * @return string
	 */
	public function generateNonceStr($length=16){
		// �����ַ������������������Ҫ���ַ�
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for($i = 0; $i < $length; $i++)
		{
			$str .= $chars[mt_rand(0, strlen($chars) - 1)];
		}
		return $str;
	}

	/**
	 * ��ȡ΢�ŷ�����IP��ַ�б�
	 * @return array('127.0.0.1','127.0.0.1')
	 */
	public function getServerIp(){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::CALLBACKSERVER_GET_URL.'access_token='.$this->access_token);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json['ip_list'];
		}
		return false;
	}

	/**
	 * �����˵�(��֤��Ķ��ĺſ���)
	 * @param array $data �˵���������
	 * example:
     * 	array (
     * 	    'button' => array (
     * 	      0 => array (
     * 	        'name' => 'ɨ��',
     * 	        'sub_button' => array (
     * 	            0 => array (
     * 	              'type' => 'scancode_waitmsg',
     * 	              'name' => 'ɨ�����ʾ',
     * 	              'key' => 'rselfmenu_0_0',
     * 	            ),
     * 	            1 => array (
     * 	              'type' => 'scancode_push',
     * 	              'name' => 'ɨ�����¼�',
     * 	              'key' => 'rselfmenu_0_1',
     * 	            ),
     * 	        ),
     * 	      ),
     * 	      1 => array (
     * 	        'name' => '��ͼ',
     * 	        'sub_button' => array (
     * 	            0 => array (
     * 	              'type' => 'pic_sysphoto',
     * 	              'name' => 'ϵͳ���շ�ͼ',
     * 	              'key' => 'rselfmenu_1_0',
     * 	            ),
     * 	            1 => array (
     * 	              'type' => 'pic_photo_or_album',
     * 	              'name' => '���ջ�����ᷢͼ',
     * 	              'key' => 'rselfmenu_1_1',
     * 	            )
     * 	        ),
     * 	      ),
     * 	      2 => array (
     * 	        'type' => 'location_select',
     * 	        'name' => '����λ��',
     * 	        'key' => 'rselfmenu_2_0'
     * 	      ),
     * 	    ),
     * 	)
     * type����ѡ��Ϊ���¼��֣�����5-8�����յ��˵��¼����⣬���ᵥ���յ���Ӧ���͵���Ϣ��
     * 1��click��������¼�
     * 2��view����תURL
     * 3��scancode_push��ɨ�����¼�
     * 4��scancode_waitmsg��ɨ�����¼��ҵ�������Ϣ�����С���ʾ��
     * 5��pic_sysphoto������ϵͳ���շ�ͼ
     * 6��pic_photo_or_album���������ջ�����ᷢͼ
     * 7��pic_weixin������΢����ᷢͼ��
     * 8��location_select����������λ��ѡ����
	 */
	public function createMenu($data){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::MENU_CREATE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	 * ��ȡ�˵�(��֤��Ķ��ĺſ���)
	 * @return array('menu'=>array(....s))
	 */
	public function getMenu(){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::MENU_GET_URL.'access_token='.$this->access_token);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * ɾ���˵�(��֤��Ķ��ĺſ���)
	 * @return boolean
	 */
	public function deleteMenu(){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::MENU_DELETE_URL.'access_token='.$this->access_token);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	 * �������Ի��˵�(��֤��Ķ��ĺſ���)
	 * @param array $data
	 * @return bool
	 *
	 */
	public function addconditionalMenu($data){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::MENU_ADDCONDITIONAL_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	 * ɾ�����Ի��˵�(��֤��Ķ��ĺſ���)
	 * @param $data {"menuid":"208379533"}
	 *
	 * @return bool
	 */
	public function delconditionalMenu($data){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::MENU_DELCONDITIONAL_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	 * ���Ը��Ի��˵�ƥ����(��֤��Ķ��ĺſ���)
	 * @param $data {"user_id":"weixin"} user_id�����Ƿ�˿��OpenID��Ҳ�����Ƿ�˿��΢�ź�
	 *
	 * @return bool|array('button'=>array(....s))
	 */
	public function trymatchMenu($data){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::MENU_TRYMATCH_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * �ϴ���ʱ�زģ���Ч��Ϊ3��(��֤��Ķ��ĺſ���)
	 * ע�⣺�ϴ����ļ�ʱ������Ҫ�ȵ��� set_time_limit(0) ���ⳬʱ
	 * ע�⣺����ļ�ֵ���⣬���ļ���ǰ�����@��ʹ�õ������Ա��Ȿ��·��б�ܱ�ת��
     * ע�⣺��ʱ�زĵ�media_id�ǿɸ��õģ�
	 * @param array $data {"media":'@Path\filename.jpg'}
	 * @param type ���ͣ�ͼƬ:image ����:voice ��Ƶ:video ����ͼ:thumb
	 * @return boolean|array
	 */
	public function uploadMedia($data, $type){
		if (!$this->access_token && !$this->checkAuth()) return false;
		//ԭ�ȵ��ϴ���ý���ļ��ӿ�ʹ�� self::UPLOAD_MEDIA_URL ǰ׺
		$result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_UPLOAD_URL.'access_token='.$this->access_token.'&type='.$type,$data,true);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * ��ȡ��ʱ�ز�(��֤��Ķ��ĺſ���)
	 * @param string $media_id ý���ļ�id
	 * @param boolean $is_video �Ƿ�Ϊ��Ƶ�ļ���Ĭ��Ϊ��
	 * @return raw data
	 */
	public function getMedia($media_id,$is_video=false){
		if (!$this->access_token && !$this->checkAuth()) return false;
		//ԭ�ȵ��ϴ���ý���ļ��ӿ�ʹ�� self::UPLOAD_MEDIA_URL ǰ׺
		//���Ҫ��ȡ���ز�����Ƶ�ļ�ʱ������ʹ��httpsЭ�飬���������httpЭ��
		$url_prefix = $is_video?str_replace('https','http',self::API_URL_PREFIX):self::API_URL_PREFIX;
		$result = $this->http_get($url_prefix.self::MEDIA_GET_URL.'access_token='.$this->access_token.'&media_id='.$media_id);
		if ($result)
		{
            if (is_string($result)) {
                $json = json_decode($result,true);
                if (isset($json['errcode'])) {
                    $this->errCode = $json['errcode'];
                    $this->errMsg = $json['errmsg'];
                    return false;
                }
            }
			return $result;
		}
		return false;
	}

	/**
	 * �ϴ�ͼƬ�����ӿ����ϴ���ͼƬ��ռ�ù��ںŵ��زĿ���ͼƬ������5000�������ơ�ͼƬ��֧��jpg/png��ʽ����С������1MB���¡� (��֤��Ķ��ĺſ���)
	 * ע�⣺�ϴ����ļ�ʱ������Ҫ�ȵ��� set_time_limit(0) ���ⳬʱ
	 * ע�⣺����ļ�ֵ���⣬���ļ���ǰ�����@��ʹ�õ������Ա��Ȿ��·��б�ܱ�ת��      
	 * @param array $data {"media":'@Path\filename.jpg'}
	 * 
	 * @return boolean|array
	 */
	public function uploadImg($data){
		if (!$this->access_token && !$this->checkAuth()) return false;
		//ԭ�ȵ��ϴ���ý���ļ��ӿ�ʹ�� self::UPLOAD_MEDIA_URL ǰ׺
		$result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_UPLOADIMG_URL.'access_token='.$this->access_token,$data,true);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}


    /**
     * �ϴ������ز�(��֤��Ķ��ĺſ���)
     * �����������ز�Ҳ�����ڹ���ƽ̨�����زĹ���ģ���п���
     * ע�⣺�ϴ����ļ�ʱ������Ҫ�ȵ��� set_time_limit(0) ���ⳬʱ
     * ע�⣺����ļ�ֵ���⣬���ļ���ǰ�����@��ʹ�õ������Ա��Ȿ��·��б�ܱ�ת��
     * @param array $data {"media":'@Path\filename.jpg'}
     * @param type ���ͣ�ͼƬ:image ����:voice ��Ƶ:video ����ͼ:thumb
     * @param boolean $is_video �Ƿ�Ϊ��Ƶ�ļ���Ĭ��Ϊ��
     * @param array $video_info ��Ƶ��Ϣ���飬����Ƶ�زĲ���Ҫ�ṩ array('title'=>'��Ƶ����','introduction'=>'����')
     * @return boolean|array
     */
    public function uploadForeverMedia($data, $type,$is_video=false,$video_info=array()){
        if (!$this->access_token && !$this->checkAuth()) return false;
        //#TODO �ݲ�ȷ���˽ӿ��Ƿ���Ҫ����Ƶ�ļ���httpЭ��
        //���Ҫ��ȡ���ز�����Ƶ�ļ�ʱ������ʹ��httpsЭ�飬���������httpЭ��
        //$url_prefix = $is_video?str_replace('https','http',self::API_URL_PREFIX):self::API_URL_PREFIX;
        //���ϴ���Ƶ�ļ�ʱ��������Ƶ�ļ���Ϣ
        if ($is_video) $data['description'] = self::json_encode($video_info);
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_FOREVER_UPLOAD_URL.'access_token='.$this->access_token.'&type='.$type,$data,true);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �ϴ�����ͼ���ز�(��֤��Ķ��ĺſ���)
     * �����������ز�Ҳ�����ڹ���ƽ̨�����زĹ���ģ���п���
     * @param array $data ��Ϣ�ṹ{"articles":[{...}]}
     * @return boolean|array
     */
    public function uploadForeverArticles($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_FOREVER_NEWS_UPLOAD_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �޸�����ͼ���ز�(��֤��Ķ��ĺſ���)
     * �����ز�Ҳ�����ڹ���ƽ̨�����زĹ���ģ���п���
     * @param string $media_id ͼ���ز�id
     * @param array $data ��Ϣ�ṹ{"articles":[{...}]}
     * @param int $index ���µ�������ͼ���زĵ�λ�ã���һƪΪ0������ͼ��ʹ��
     * @return boolean|array
     */
    public function updateForeverArticles($media_id,$data,$index=0){
        if (!$this->access_token && !$this->checkAuth()) return false;
        if (!isset($data['media_id'])) $data['media_id'] = $media_id;
        if (!isset($data['index'])) $data['index'] = $index;
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_FOREVER_NEWS_UPDATE_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ�����ز�(��֤��Ķ��ĺſ���)
     * ����ͼ����Ϣ�������������ݣ�ʧ�ܷ���false
     * @param string $media_id ý���ļ�id
     * @param boolean $is_video �Ƿ�Ϊ��Ƶ�ļ���Ĭ��Ϊ��
     * @return boolean|array|raw data
     */
    public function getForeverMedia($media_id,$is_video=false){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array('media_id' => $media_id);
        //#TODO �ݲ�ȷ���˽ӿ��Ƿ���Ҫ����Ƶ�ļ���httpЭ��
        //���Ҫ��ȡ���ز�����Ƶ�ļ�ʱ������ʹ��httpsЭ�飬���������httpЭ��
        //$url_prefix = $is_video?str_replace('https','http',self::API_URL_PREFIX):self::API_URL_PREFIX;
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_FOREVER_GET_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            if (is_string($result)) {
                $json = json_decode($result,true);
                if ($json) {
                    if (isset($json['errcode'])) {
                        $this->errCode = $json['errcode'];
                        $this->errMsg = $json['errmsg'];
                        return false;
                    }
                    return $json;
                } else {
                    return $result;
                }
            }
            return $result;
        }
        return false;
    }

    /**
     * ɾ�������ز�(��֤��Ķ��ĺſ���)
     * @param string $media_id ý���ļ�id
     * @return boolean
     */
    public function delForeverMedia($media_id){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array('media_id' => $media_id);
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_FOREVER_DEL_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ��ȡ�����ز��б�(��֤��Ķ��ĺſ���)
     * @param string $type �زĵ�����,ͼƬ��image������Ƶ��video�������� ��voice����ͼ�ģ�news��
     * @param int $offset ȫ���زĵ�ƫ��λ�ã�0��ʾ�ӵ�һ���ز�
     * @param int $count �����زĵ�������ȡֵ��1��20֮��
     * @return boolean|array
     * ���������ʽ:
     * array(
     *  'total_count'=>0, //�����͵��زĵ�����
     *  'item_count'=>0,  //���ε��û�ȡ���زĵ�����
     *  'item'=>array()   //�ز��б����飬���ݶ�����ο��ٷ��ĵ�
     * )
     */
    public function getForeverList($type,$offset,$count){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'type' => $type,
            'offset' => $offset,
            'count' => $count,
        );
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_FOREVER_BATCHGET_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ�����ز�����(��֤��Ķ��ĺſ���)
     * @return boolean|array
     * ���������ʽ:
     * array(
     *  'voice_count'=>0, //����������
     *  'video_count'=>0, //��Ƶ������
     *  'image_count'=>0, //ͼƬ������
     *  'news_count'=>0   //ͼ��������
     * )
     */
    public function getForeverCount(){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_URL_PREFIX.self::MEDIA_FOREVER_COUNT_URL.'access_token='.$this->access_token);
        if ($result)
        {
            $json = json_decode($result,true);
            if (isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

	/**
	 * �ϴ�ͼ����Ϣ�زģ�����Ⱥ��(��֤��Ķ��ĺſ���)
	 * @param array $data ��Ϣ�ṹ{"articles":[{...}]}
	 * @return boolean|array
	 */
	public function uploadArticles($data){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_UPLOADNEWS_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * �ϴ���Ƶ�ز�(��֤��Ķ��ĺſ���)
	 * @param array $data ��Ϣ�ṹ
	 * {
	 *     "media_id"=>"",     //ͨ���ϴ�ý��ӿڵõ���MediaId
	 *     "title"=>"TITLE",    //��Ƶ����
	 *     "description"=>"Description"        //��Ƶ����
	 * }
	 * @return boolean|array
	 * {
	 *     "type":"video",
	 *     "media_id":"mediaid",
	 *     "created_at":1398848981
	 *  }
	 */
	public function uploadMpVideo($data){
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $result = $this->http_post(self::UPLOAD_MEDIA_URL.self::MEDIA_VIDEO_UPLOAD.'access_token='.$this->access_token,self::json_encode($data));
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json;
	    }
	    return false;
	}

	/**
	 * �߼�Ⱥ����Ϣ, ����OpenID�б�Ⱥ��ͼ����Ϣ(���ĺŲ�����)
	 * 	ע�⣺��Ƶ��Ҫ�ڵ���uploadMedia()��������ʹ�� uploadMpVideo() �������ɣ�
	 *             Ȼ���õ� mediaid ��������Ⱥ��������Ϣ����Ϊ mpvideo ���͡�
	 * @param array $data ��Ϣ�ṹ
	 * {
	 *     "touser"=>array(
	 *         "OPENID1",
	 *         "OPENID2"
	 *     ),
	 *      "msgtype"=>"mpvideo",
	 *      // ������5��������ѡ���Ӧ�Ĳ�������
	 *      // mpnews | voice | image | mpvideo => array( "media_id"=>"MediaId")
	 *      // text => array ( "content" => "hello")
	 * }
	 * @return boolean|array
	 */
	public function sendMassMessage($data){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::MASS_SEND_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * �߼�Ⱥ����Ϣ, ����Ⱥ��idȺ��ͼ����Ϣ(��֤��Ķ��ĺſ���)
	 * 	ע�⣺��Ƶ��Ҫ�ڵ���uploadMedia()��������ʹ�� uploadMpVideo() �������ɣ�
	 *             Ȼ���õ� mediaid ��������Ⱥ��������Ϣ����Ϊ mpvideo ���͡�
	 * @param array $data ��Ϣ�ṹ
	 * {
	 *     "filter"=>array(
	 *         "is_to_all"=>False,     //�Ƿ�Ⱥ���������û�.True���÷���id��False����д����id
	 *         "group_id"=>"2"     //Ⱥ���ķ���id
	 *     ),
	 *      "msgtype"=>"mpvideo",
	 *      // ������5��������ѡ���Ӧ�Ĳ�������
	 *      // mpnews | voice | image | mpvideo => array( "media_id"=>"MediaId")
	 *      // text => array ( "content" => "hello")
	 * }
	 * @return boolean|array
	 */
	public function sendGroupMassMessage($data){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::MASS_SEND_GROUP_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * �߼�Ⱥ����Ϣ, ɾ��Ⱥ��ͼ����Ϣ(��֤��Ķ��ĺſ���)
	 * @param int $msg_id ��Ϣid
	 * @return boolean|array
	 */
	public function deleteMassMessage($msg_id){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::MASS_DELETE_URL.'access_token='.$this->access_token,self::json_encode(array('msg_id'=>$msg_id)));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	 * �߼�Ⱥ����Ϣ, Ԥ��Ⱥ����Ϣ(��֤��Ķ��ĺſ���)
	 * 	ע�⣺��Ƶ��Ҫ�ڵ���uploadMedia()��������ʹ�� uploadMpVideo() �������ɣ�
	 *             Ȼ���õ� mediaid ��������Ⱥ��������Ϣ����Ϊ mpvideo ���͡�
	 * @param array $data ��Ϣ�ṹ
	 * {
	 *     "touser"=>"OPENID",
	 *      "msgtype"=>"mpvideo",
	 *      // ������5��������ѡ���Ӧ�Ĳ�������
	 *      // mpnews | voice | image | mpvideo => array( "media_id"=>"MediaId")
	 *      // text => array ( "content" => "hello")
	 * }
	 * @return boolean|array
	 */
	public function previewMassMessage($data){
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $result = $this->http_post(self::API_URL_PREFIX.self::MASS_PREVIEW_URL.'access_token='.$this->access_token,self::json_encode($data));
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json;
	    }
	    return false;
	}

	/**
	 * �߼�Ⱥ����Ϣ, ��ѯȺ����Ϣ����״̬(��֤��Ķ��ĺſ���)
	 * @param int $msg_id ��Ϣid
	 * @return boolean|array
	 * {
	 *     "msg_id":201053012,     //Ⱥ����Ϣ�󷵻ص���Ϣid
	 *     "msg_status":"SEND_SUCCESS" //��Ϣ���ͺ��״̬��SENDING��ʾ���ڷ��� SEND_SUCCESS��ʾ���ͳɹ�
	 * }
	 */
	public function queryMassMessage($msg_id){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::MASS_QUERY_URL.'access_token='.$this->access_token,self::json_encode(array('msg_id'=>$msg_id)));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * ������ά��ticket
	 * @param int|string $scene_id �Զ���׷��id,��ʱ��ά��ֻ������ֵ��
	 * @param int $type 0:��ʱ��ά�룻1:��ֵ�����ö�ά��(��ʱexpire������Ч)��2:�ַ��������ö�ά��(��ʱexpire������Ч)
	 * @param int $expire ��ʱ��ά����Ч�ڣ����Ϊ604800��
	 * @return array('ticket'=>'qrcode�ִ�','expire_seconds'=>604800,'url'=>'��ά��ͼƬ������ĵ�ַ')
	 */
	public function getQRCode($scene_id,$type=0,$expire=604800){
		if (!$this->access_token && !$this->checkAuth()) return false;
		if (!isset($scene_id)) return false;
		switch ($type) {
			case '0':
				if (!is_numeric($scene_id))
					return false;
				$action_name = 'QR_SCENE';
				$action_info = array('scene'=>(array('scene_id'=>$scene_id)));
				break;

			case '1':
				if (!is_numeric($scene_id))
					return false;
				$action_name = 'QR_LIMIT_SCENE';
				$action_info = array('scene'=>(array('scene_id'=>$scene_id)));
				break;

			case '2':
				if (!is_string($scene_id))
					return false;
				$action_name = 'QR_LIMIT_STR_SCENE';
				$action_info = array('scene'=>(array('scene_str'=>$scene_id)));
				break;

			default:
				return false;
		}

		$data = array(
			'action_name'    => $action_name,
			'expire_seconds' => $expire,
			'action_info'    => $action_info
		);
		if ($type) {
			unset($data['expire_seconds']);
		}

		$result = $this->http_post(self::API_URL_PREFIX.self::QRCODE_CREATE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result) {
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * ��ȡ��ά��ͼƬ
	 * @param string $ticket ������getQRCode�������ɵ�ticket����
	 * @return string url ����http��ַ
	 */
	public function getQRUrl($ticket) {
		return self::QRCODE_IMG_URL.urlencode($ticket);
	}

	/**
	 * ������ת�����ӽӿ�
	 * @param string $long_url ����Ҫת���ĳ�url
	 * @return boolean|string url �ɹ��򷵻�ת����Ķ�url
	 */
	public function getShortUrl($long_url){
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $data = array(
            'action'=>'long2short',
            'long_url'=>$long_url
	    );
	    $result = $this->http_post(self::API_URL_PREFIX.self::SHORT_URL.'access_token='.$this->access_token,self::json_encode($data));
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json['short_url'];
	    }
	    return false;
	}

	/**
	 * ��ȡͳ������
	 * @param string $type  ���ݷ���(user|article|upstreammsg|interface)�ֱ�Ϊ(�û�����|ͼ�ķ���|��Ϣ����|�ӿڷ���)
	 * @param string $subtype   �����ӷ��࣬�ο� DATACUBE_URL_ARR �������岿�� ����README.md˵���ĵ�
	 * @param string $begin_date ��ʼʱ��
	 * @param string $end_date   ����ʱ��
	 * @return boolean|array �ɹ����ز�ѯ������飬�䶨���뿴�ٷ��ĵ�
	 */
	public function getDatacube($type,$subtype,$begin_date,$end_date=''){
	    if (!$this->access_token && !$this->checkAuth()) return false;
		if (!isset(self::$DATACUBE_URL_ARR[$type]) || !isset(self::$DATACUBE_URL_ARR[$type][$subtype]))
			return false;
	    $data = array(
            'begin_date'=>$begin_date,
            'end_date'=>$end_date?$end_date:$begin_date
	    );
	    $result = $this->http_post(self::API_BASE_URL_PREFIX.self::$DATACUBE_URL_ARR[$type][$subtype].'access_token='.$this->access_token,self::json_encode($data));
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return isset($json['list'])?$json['list']:$json;
	    }
	    return false;
	}

	/**
	 * ������ȡ��ע�û��б�
	 * @param unknown $next_openid
	 */
	public function getUserList($next_openid=''){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::USER_GET_URL.'access_token='.$this->access_token.'&next_openid='.$next_openid);
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * ��ȡ��ע����ϸ��Ϣ
	 * @param string $openid
	 * @param string $lang ���ع��ҵ������԰汾��zh_CN ���壬zh_TW ���壬en Ӣ��
	 * @return array {subscribe,openid,nickname,sex,city,province,country,language,headimgurl,subscribe_time,[unionid]}
	 * ע�⣺unionid�ֶ� ֻ�����û������ںŰ󶨵�΢�ſ���ƽ̨�˺ź󣬲Ż���֡��������ǰ��isset()���һ��
	 */
	public function getUserInfo($openid, $lang = 'zh_CN'){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::USER_INFO_URL.'access_token='.$this->access_token.'&openid='.$openid.'&lang='.$lang);
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}
	/**
	 * ������ȡ��ע����ϸ��Ϣ
	 * @param array $openids user_list{{'openid:xxxxxx'},{},{}}
	 * @return array user_info_list{subscribe,openid,nickname,sex,city,province,country,language,headimgurl,subscribe_time,[unionid]}{}{}...
	 * ע�⣺unionid�ֶ� ֻ�����û������ںŰ󶨵�΢�ſ���ƽ̨�˺ź󣬲Ż���֡��������ǰ��isset()���һ��
	 */
	public function getUsersInfo($openids){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::USERS_INFO_URL.'access_token='.$this->access_token,json_encode($openids));
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * �����û���ע��
	 * @param string $openid
	 * @param string $remark ��ע��
	 * @return boolean|array
	 */
	public function updateUserRemark($openid,$remark){
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $data = array(
			'openid'=>$openid,
			'remark'=>$remark
	    );
	    $result = $this->http_post(self::API_URL_PREFIX.self::USER_UPDATEREMARK_URL.'access_token='.$this->access_token,self::json_encode($data));
	    if ($result)
	    {
	        $json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
	    }
	    return false;
	}

	/**
	 * ��ȡ�û������б�
	 * @return boolean|array
	 */
	public function getGroup(){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::GROUP_GET_URL.'access_token='.$this->access_token);
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * ��ȡ�û����ڷ���
	 * @param string $openid
	 * @return boolean|int �ɹ��򷵻��û�����id
	 */
	public function getUserGroup($openid){
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $data = array(
	            'openid'=>$openid
	    );
	    $result = $this->http_post(self::API_URL_PREFIX.self::USER_GROUP_URL.'access_token='.$this->access_token,self::json_encode($data));
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        } else
                if (isset($json['groupid'])) return $json['groupid'];
	    }
	    return false;
	}

	/**
	 * �����Զ�����
	 * @param string $name ��������
	 * @return boolean|array
	 */
	public function createGroup($name){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$data = array(
				'group'=>array('name'=>$name)
		);
		$result = $this->http_post(self::API_URL_PREFIX.self::GROUP_CREATE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * ���ķ�������
	 * @param int $groupid ����id
	 * @param string $name ��������
	 * @return boolean|array
	 */
	public function updateGroup($groupid,$name){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$data = array(
				'group'=>array('id'=>$groupid,'name'=>$name)
		);
		$result = $this->http_post(self::API_URL_PREFIX.self::GROUP_UPDATE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * �ƶ��û�����
	 * @param int $groupid ����id
	 * @param string $openid �û�openid
	 * @return boolean|array
	 */
	public function updateGroupMembers($groupid,$openid){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$data = array(
				'openid'=>$openid,
				'to_groupid'=>$groupid
		);
		$result = $this->http_post(self::API_URL_PREFIX.self::GROUP_MEMBER_UPDATE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * �����ƶ��û�����
	 * @param int $groupid ����id
	 * @param string $openid_list �û�openid����,һ�β��ܳ���50��
	 * @return boolean|array
	 */
	public function batchUpdateGroupMembers($groupid,$openid_list){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$data = array(
				'openid_list'=>$openid_list,
				'to_groupid'=>$groupid
		);
		$result = $this->http_post(self::API_URL_PREFIX.self::GROUP_MEMBER_BATCHUPDATE_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * ���Ϳͷ���Ϣ
	 * @param array $data ��Ϣ�ṹ{"touser":"OPENID","msgtype":"news","news":{...}}
	 * @return boolean|array
	 */
	public function sendCustomMessage($data){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::CUSTOM_SEND_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * oauth ��Ȩ��ת�ӿ�
	 * @param string $callback �ص�URI
	 * @return string
	 */
	public function getOauthRedirect($callback,$state='',$scope='snsapi_userinfo'){
		return self::OAUTH_PREFIX.self::OAUTH_AUTHORIZE_URL.'appid='.$this->appid.'&redirect_uri='.urlencode($callback).'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
	}

	/**
	 * ͨ��code��ȡAccess Token
	 * @return array {access_token,expires_in,refresh_token,openid,scope}
	 */
	public function getOauthAccessToken(){
		$code = isset($_GET['code'])?$_GET['code']:'';
		if (!$code) return false;
		$result = $this->http_get(self::API_BASE_URL_PREFIX.self::OAUTH_TOKEN_URL.'appid='.$this->appid.'&secret='.$this->appsecret.'&code='.$code.'&grant_type=authorization_code');
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			$this->user_token = $json['access_token'];
			return $json;
		}
		return false;
	}

	/**
	 * ˢ��access token������
	 * @param string $refresh_token
	 * @return boolean|mixed
	 */
	public function getOauthRefreshToken($refresh_token){
		$result = $this->http_get(self::API_BASE_URL_PREFIX.self::OAUTH_REFRESH_URL.'appid='.$this->appid.'&grant_type=refresh_token&refresh_token='.$refresh_token);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			$this->user_token = $json['access_token'];
			return $json;
		}
		return false;
	}

	/**
	 * ��ȡ��Ȩ����û�����
	 * @param string $access_token
	 * @param string $openid
	 * @return array {openid,nickname,sex,province,city,country,headimgurl,privilege,[unionid]}
	 * ע�⣺unionid�ֶ� ֻ�����û������ںŰ󶨵�΢�ſ���ƽ̨�˺ź󣬲Ż���֡��������ǰ��isset()���һ��
	 */
	public function getOauthUserinfo($access_token,$openid){
		$result = $this->http_get(self::API_BASE_URL_PREFIX.self::OAUTH_USERINFO_URL.'access_token='.$access_token.'&openid='.$openid);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * ������Ȩƾ֤�Ƿ���Ч
	 * @param string $access_token
	 * @param string $openid
	 * @return boolean �Ƿ���Ч
	 */
	public function getOauthAuth($access_token,$openid){
	    $result = $this->http_get(self::API_BASE_URL_PREFIX.self::OAUTH_AUTH_URL.'access_token='.$access_token.'&openid='.$openid);
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        } else
	          if ($json['errcode']==0) return true;
	    }
	    return false;
	}

	/**
	 * ģ����Ϣ ����������ҵ
	 * @param int $id1  ���ں�ģ����Ϣ������ҵ��ţ��ο��ٷ������ĵ� ��ҵ����
	 * @param int $id2  ͬ$id1�������ֻ��һ����ҵ���˲�����ʡ��
	 * @return boolean|array
	 */
	public function setTMIndustry($id1,$id2=''){
	    if ($id1) $data['industry_id1'] = $id1;
	    if ($id2) $data['industry_id2'] = $id2;
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $result = $this->http_post(self::API_URL_PREFIX.self::TEMPLATE_SET_INDUSTRY_URL.'access_token='.$this->access_token,self::json_encode($data));
	    if($result){
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json;
	    }
	    return false;
	}

	/**
	 * ģ����Ϣ �����Ϣģ��
	 * �ɹ�������Ϣģ��ĵ���id
	 * @param string $tpl_id ģ�����ģ��ı�ţ��С�TM**���͡�OPENTMTM**������ʽ
	 * @return boolean|string
	 */
	public function addTemplateMessage($tpl_id){
	    $data = array ('template_id_short' =>$tpl_id);
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $result = $this->http_post(self::API_URL_PREFIX.self::TEMPLATE_ADD_TPL_URL.'access_token='.$this->access_token,self::json_encode($data));
	    if($result){
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json['template_id'];
	    }
	    return false;
	}

	/**
	 * ����ģ����Ϣ
	 * @param array $data ��Ϣ�ṹ
	 * ��
			"touser":"OPENID",
			"template_id":"ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY",
			"url":"http://weixin.qq.com/download",
			"topcolor":"#FF0000",
			"data":{
				"������1": {
					"value":"����",
					"color":"#173177"	 //������ɫ
					},
				"Date":{
					"value":"06��07�� 19ʱ24��",
					"color":"#173177"
					},
				"CardNumber":{
					"value":"0426",
					"color":"#173177"
					},
				"Type":{
					"value":"����",
					"color":"#173177"
					}
			}
		}
	 * @return boolean|array
	 */
	public function sendTemplateMessage($data){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::TEMPLATE_SEND_URL.'access_token='.$this->access_token,self::json_encode($data));
		if($result){
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * ��ȡ��ͷ��Ự��¼
	 * @param array $data ���ݽṹ{"starttime":123456789,"endtime":987654321,"openid":"OPENID","pagesize":10,"pageindex":1,}
	 * @return boolean|array
	 */
	public function getCustomServiceMessage($data){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_URL_PREFIX.self::CUSTOM_SERVICE_GET_RECORD.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * ת����ͷ���Ϣ
	 * Example: $obj->transfer_customer_service($customer_account)->reply();
	 * @param string $customer_account ת����ָ���ͷ��ʺţ�test1@test
	 */
	public function transfer_customer_service($customer_account = '')
	{
		$msg = array(
			'ToUserName' => $this->getRevFrom(),
			'FromUserName'=>$this->getRevTo(),
			'CreateTime'=>time(),
			'MsgType'=>'transfer_customer_service',
		);
		if ($customer_account) {
			$msg['TransInfo'] = array('KfAccount'=>$customer_account);
		}
		$this->Message($msg);
		return $this;
	}

	/**
	 * ��ȡ��ͷ��ͷ�������Ϣ
	 *
	 * @return boolean|array
	 */
	public function getCustomServiceKFlist(){
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_get(self::API_URL_PREFIX.self::CUSTOM_SERVICE_GET_KFLIST.'access_token='.$this->access_token);
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * ��ȡ��ͷ����߿ͷ��Ӵ���Ϣ
	 *
	 * @return boolean|array {
	 "kf_online_list": [
	 {
	 "kf_account": "test1@test",	//�ͷ��˺�@΢�ű���
	 "status": 1,			//�ͷ�����״̬ 1��pc���ߣ�2���ֻ�����,��pc���ֻ�ͬʱ������Ϊ 1+2=3
	 "kf_id": "1001",		//�ͷ�����
	 "auto_accept": 0,		//�ͷ����õ�����Զ�������
	 "accepted_case": 1		//�ͷ���ǰ���ڽӴ��ĻỰ��
	 }
	 ]
	 }
	 */
	public function getCustomServiceOnlineKFlist(){
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $result = $this->http_get(self::API_URL_PREFIX.self::CUSTOM_SERVICE_GET_ONLINEKFLIST.'access_token='.$this->access_token);
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json;
	    }
	    return false;
	}

	/**
	 * ����ָ����ͷ��Ự
	 * @tutorial ���û��ѱ������ͷ��Ӵ���ָ���ͷ����������ʧ��
	 * @param string $openid           //�û�openid
	 * @param string $kf_account     //�ͷ��˺�
	 * @param string $text                 //������Ϣ���ı���չʾ�ڿͷ���Ա�Ķ�ͷ��ͻ��ˣ���Ϊ��
	 * @return boolean | array            //�ɹ�����json����
	 * {
	 *   "errcode": 0,
	 *   "errmsg": "ok",
	 * }
	 */
	public function createKFSession($openid,$kf_account,$text=''){
	    $data=array(
	    	"openid" =>$openid,
	        "kf_account" => $kf_account
	    );
	    if ($text) $data["text"] = $text;
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $result = $this->http_post(self::API_BASE_URL_PREFIX.self::CUSTOM_SESSION_CREATE.'access_token='.$this->access_token,self::json_encode($data));
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json;
	    }
	    return false;
	}

	/**
	 * �ر�ָ����ͷ��Ự
	 * @tutorial ���û��������ͷ��Ӵ�ʱ���ʧ��
	 * @param string $openid           //�û�openid
	 * @param string $kf_account     //�ͷ��˺�
	 * @param string $text                 //������Ϣ���ı���չʾ�ڿͷ���Ա�Ķ�ͷ��ͻ��ˣ���Ϊ��
	 * @return boolean | array            //�ɹ�����json����
	 * {
	 *   "errcode": 0,
	 *   "errmsg": "ok",
	 * }
	 */
	public function closeKFSession($openid,$kf_account,$text=''){
	    $data=array(
	    	"openid" =>$openid,
	        "kf_account" => $kf_account
	    );
	    if ($text) $data["text"] = $text;
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $result = $this->http_post(self::API_BASE_URL_PREFIX.self::CUSTOM_SESSION_CLOSE .'access_token='.$this->access_token,self::json_encode($data));
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json;
	    }
	    return false;
	}

	/**
	 * ��ȡ�û��Ự״̬
	 * @param string $openid           //�û�openid
	 * @return boolean | array            //�ɹ�����json����
	 * {
	 *     "errcode" : 0,
	 *     "errmsg" : "ok",
	 *     "kf_account" : "test1@test",    //���ڽӴ��Ŀͷ�
	 *     "createtime": 123456789,        //�Ự����ʱ��
	 *  }
	 */
	public function getKFSession($openid){
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $result = $this->http_get(self::API_BASE_URL_PREFIX.self::CUSTOM_SESSION_GET .'access_token='.$this->access_token.'&openid='.$openid);
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json;
	    }
	    return false;
	}

	/**
	 * ��ȡָ���ͷ��ĻỰ�б�
	 * @param string $openid           //�û�openid
	 * @return boolean | array            //�ɹ�����json����
	 *  array(
	 *     'sessionlist' => array (
	 *         array (
	 *             'openid'=>'OPENID',             //�ͻ� openid
	 *             'createtime'=>123456789,  //�Ự����ʱ�䣬UNIX ʱ���
	 *         ),
	 *         array (
	 *             'openid'=>'OPENID',             //�ͻ� openid
	 *             'createtime'=>123456789,  //�Ự����ʱ�䣬UNIX ʱ���
	 *         ),
	 *     )
	 *  )
	 */
	public function getKFSessionlist($kf_account){
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $result = $this->http_get(self::API_BASE_URL_PREFIX.self::CUSTOM_SESSION_GET_LIST .'access_token='.$this->access_token.'&kf_account='.$kf_account);
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json;
	    }
	    return false;
	}

	/**
	 * ��ȡδ����Ự�б�
	 * @param string $openid           //�û�openid
	 * @return boolean | array            //�ɹ�����json����
	 *  array (
	 *     'count' => 150 ,                            //δ����Ự����
	 *     'waitcaselist' => array (
	 *         array (
	 *             'openid'=>'OPENID',             //�ͻ� openid
	 *             'kf_account ' =>'',                   //ָ���Ӵ��Ŀͷ���Ϊ����δָ��
	 *             'createtime'=>123456789,  //�Ự����ʱ�䣬UNIX ʱ���
	 *         ),
	 *         array (
	 *             'openid'=>'OPENID',             //�ͻ� openid
	 *             'kf_account ' =>'',                   //ָ���Ӵ��Ŀͷ���Ϊ����δָ��
	 *             'createtime'=>123456789,  //�Ự����ʱ�䣬UNIX ʱ���
	 *         )
	 *     )
	 *  )
	 */
	public function getKFSessionWait(){
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $result = $this->http_get(self::API_BASE_URL_PREFIX.self::CUSTOM_SESSION_GET_WAIT .'access_token='.$this->access_token);
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json;
	    }
	    return false;
	}

	/**
	 * ��ӿͷ��˺�
	 *
	 * @param string $account      //�����ͷ��˺ţ���ʽΪ���˺�ǰ׺@���ں�΢�źţ��˺�ǰ׺���10���ַ���������Ӣ�Ļ��������ַ�
	 * @param string $nickname     //�ͷ��ǳƣ��6�����ֻ�12��Ӣ���ַ�
	 * @param string $password     //�ͷ��˺����ĵ�¼���룬���Զ�����
	 * @return boolean|array
	 * �ɹ����ؽ��
	 * {
	 *   "errcode": 0,
	 *   "errmsg": "ok",
	 * }
	 */
	public function addKFAccount($account,$nickname,$password){
	    $data=array(
	    	"kf_account" =>$account,
	        "nickname" => $nickname,
	        "password" => md5($password)
	    );
		if (!$this->access_token && !$this->checkAuth()) return false;
		$result = $this->http_post(self::API_BASE_URL_PREFIX.self::CS_KF_ACCOUNT_ADD_URL.'access_token='.$this->access_token,self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (!$json || !empty($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/**
	 * �޸Ŀͷ��˺���Ϣ
	 *
	 * @param string $account      //�����ͷ��˺ţ���ʽΪ���˺�ǰ׺@���ں�΢�źţ��˺�ǰ׺���10���ַ���������Ӣ�Ļ��������ַ�
	 * @param string $nickname     //�ͷ��ǳƣ��6�����ֻ�12��Ӣ���ַ�
	 * @param string $password     //�ͷ��˺����ĵ�¼���룬���Զ�����
	 * @return boolean|array
	 * �ɹ����ؽ��
	 * {
	 *   "errcode": 0,
	 *   "errmsg": "ok",
	 * }
	 */
	public function updateKFAccount($account,$nickname,$password){
	    $data=array(
	            "kf_account" =>$account,
	            "nickname" => $nickname,
	            "password" => md5($password)
	    );
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $result = $this->http_post(self::API_BASE_URL_PREFIX.self::CS_KF_ACCOUNT_UPDATE_URL.'access_token='.$this->access_token,self::json_encode($data));
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json;
	    }
	    return false;
	}

	/**
	 * ɾ���ͷ��˺�
	 *
	 * @param string $account      //�����ͷ��˺ţ���ʽΪ���˺�ǰ׺@���ں�΢�źţ��˺�ǰ׺���10���ַ���������Ӣ�Ļ��������ַ�
	 * @return boolean|array
	 * �ɹ����ؽ��
	 * {
	 *   "errcode": 0,
	 *   "errmsg": "ok",
	 * }
	 */
	public function deleteKFAccount($account){
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $result = $this->http_get(self::API_BASE_URL_PREFIX.self::CS_KF_ACCOUNT_DEL_URL.'access_token='.$this->access_token.'&kf_account='.$account);
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json;
	    }
	    return false;
	}

	/**
	 * �ϴ��ͷ�ͷ��
	 *
	 * @param string $account //�����ͷ��˺ţ���ʽΪ���˺�ǰ׺@���ں�΢�źţ��˺�ǰ׺���10���ַ���������Ӣ�Ļ��������ַ�
	 * @param string $imgfile //ͷ���ļ�����·��,�磺'D:\user.jpg'��ͷ���ļ�����JPG��ʽ�����ؽ���640*640
	 * @return boolean|array
	 * �ɹ����ؽ��
	 * {
	 *   "errcode": 0,
	 *   "errmsg": "ok",
	 * }
	 */
	public function setKFHeadImg($account,$imgfile){
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $result = $this->http_post(self::API_BASE_URL_PREFIX.self::CS_KF_ACCOUNT_UPLOAD_HEADIMG_URL.'access_token='.$this->access_token.'&kf_account='.$account,array('media'=>'@'.$imgfile),true);
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json;
	    }
	    return false;
	}

	/**
	 * �������ӿ�
	 * @param String $uid      �û�Ψһid���ǿ�����id�����û����ֹ��ں��µĲ�ͬ�û������������û�openid��
	 * @param String $query    �����ı���
	 * @param String $category ��Ҫʹ�õķ������ͣ�����á���������������Ϊ��
	 * @param Float $latitude  γ�����꣬�뾭��ͬʱ���룻����ж�ѡһ����
	 * @param Float $longitude �������꣬��γ��ͬʱ���룻����ж�ѡһ����
	 * @param String $city     �������ƣ��뾭γ�ȶ�ѡһ����
	 * @param String $region   �������ƣ��ڳ��д��ڵ�����¿�ʡ�ԣ��뾭γ�ȶ�ѡһ����
	 * @return boolean|array
	 */
	public function querySemantic($uid,$query,$category,$latitude=0,$longitude=0,$city="",$region=""){
	    if (!$this->access_token && !$this->checkAuth()) return false;
	    $data=array(
	            'query' => $query,
	            'category' => $category,
	            'appid' => $this->appid,
	            'uid' => ''
	    );
	    //���������������ƶ�ѡһ
	    if ($latitude) {
	        $data['latitude'] = $latitude;
	        $data['longitude'] = $longitude;
	    } elseif ($city) {
	        $data['city'] = $city;
	    } elseif ($region) {
	        $data['region'] = $region;
	    }
	    $result = $this->http_post(self::API_BASE_URL_PREFIX.self::SEMANTIC_API_URL.'access_token='.$this->access_token,self::json_encode($data));
	    if ($result)
	    {
	        $json = json_decode($result,true);
	        if (!$json || !empty($json['errcode'])) {
	            $this->errCode = $json['errcode'];
	            $this->errMsg = $json['errmsg'];
	            return false;
	        }
	        return $json;
	    }
	    return false;
	}

    /**
     * ������ȯ
     * @param Array $data      ��ȯ����
     * @return array|boolean ����������card_idΪ��ȯID
     */
    public function createCard($data) {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_CREATE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���Ŀ�ȯ��Ϣ
     * ���øýӿڸ�����Ϣ����������󣬿�ȯ״̬���Ϊ����ˡ��ѱ��û���ȡ�Ŀ�ȯ��ʵʱ����Ʊ����Ϣ��
     * @param string $data
     * @return boolean
     */
    public function updateCard($data) {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_UPDATE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ɾ����ȯ
     * �����̻�ɾ������һ�࿨ȯ��ɾ����ȯ�󣬸ÿ�ȯ��Ӧ�����ɵ���ȡ�ö�ά�롢��ӵ����� JS API ����ʧЧ��
     * ע�⣺ɾ����ȯ����ɾ���ѱ��û���ȡ��������΢�ſͻ����еĿ�ȯ������ȡ�Ŀ�ȯ������Ч��
     * @param string $card_id ��ȯID
     * @return boolean
     */
    public function delCard($card_id) {
        $data = array(
            'card_id' => $card_id,
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_DELETE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ��ѯ��ȯ����
     * @param string $card_id
     * @return boolean|array    ����������Ϣ�Ƚϸ��ӣ���ο���ȯ�ӿ��ĵ�
     */
    public function getCardInfo($card_id) {
        $data = array(
            'card_id' => $card_id,
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_GET . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ�û�����ȡ��ȯ�ӿ�
     * @param string $openid
     * @param string $card_id
     * @return boolean|array    ����������Ϣ�Ƚϸ��ӣ���ο���ȯ�ӿ��ĵ�
     * �ɹ����ؽ��
     *  {
     * "errcode":0,
     * "errmsg":"ok",
     * "card_list": [
     * {"code": "xxx1434079154", "card_id": "xxxxxxxxxx"},
     * {"code": "xxx1434079155", "card_id": "xxxxxxxxxx"}
     * ]
     * }
     */
    public function getUserCardList($openid,$card_id) {
        $data = array(
            'openid' => $openid,
            'card_id' => $card_id
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_USER_GETCARDLIST . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ��ɫ�б�
	 * ��ÿ�ȯ��������ɫ�б����ڴ�����ȯ
	 * @return boolean|array   ����������ο� ΢�ſ�ȯ�ӿ��ĵ� ��json��ʽ
     */
    public function getCardColors() {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_BASE_URL_PREFIX . self::CARD_GETCOLORS . 'access_token=' . $this->access_token);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ�ŵ��б�
	 * ��ȡ�ڹ���ƽ̨�����봴�����ŵ��б�
	 * @param int $offset  ��ʼ��ȡ��ƫ�ƣ�Ĭ��Ϊ0��ͷ��ʼ
	 * @param int $count   ��ȡ��������Ĭ��Ϊ0��ȡȫ��
	 * @return boolean|array   ����������ο� ΢�ſ�ȯ�ӿ��ĵ� ��json��ʽ
     */
    public function getCardLocations($offset=0,$count=0) {
	    $data=array(
	    	'offset'=>$offset,
	        'count'=>$count
	    );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_LOCATION_BATCHGET . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���������ŵ���Ϣ
	 * @tutorial ���ز�����ŵ�id�б��Զ��ŷָ�������в���ʧ�ܵģ���Ϊ-1�������к˲����ĸ�����ʧ��
	 * @param array $data    ������ʽ��json���ݣ��������ݽ϶࣬�������ݸ�ʽ��鿴 ΢�ſ�ȯ�ӿ��ĵ�
	 * @return boolean|string �ɹ����ز�����ŵ�id�б�
     */
    public function addCardLocations($data) {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_LOCATION_BATCHADD . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���ɿ�ȯ��ά��
	 * �ɹ���ֱ�ӷ���ticketֵ�������� getQRUrl($ticket) ��ȡ��ά��url
	 *
	 * @param string $cardid ��ȯID ����
	 * @param string $code ָ����ȯ code �룬ֻ�ܱ���һ�Ρ�use_custom_code �ֶ�Ϊ true �Ŀ�ȯ������д�����Զ��� code ������д��
	 * @param string $openid ָ����ȡ�ߵ� openid��ֻ�и��û�����ȡ��bind_openid �ֶ�Ϊ true �Ŀ�ȯ������д�����Զ��� openid ������д��
	 * @param int $expire_seconds ָ����ά�����Чʱ�䣬��Χ�� 60 ~ 1800 �롣����Ĭ��Ϊ������Ч��
	 * @param boolean $is_unique_code ָ���·���ά�룬���ɵĶ�ά���������һ�� code����ȡ�󲻿��ٴ�ɨ�衣��д true �� false��Ĭ�� false��
	 * @param string $balance ������Է�Ϊ��λ��������ͱ��LUCKY_MONEY����������ȯ���Ͳ��
     * @return boolean|string
     */
    public function createCardQrcode($card_id,$code='',$openid='',$expire_seconds=0,$is_unique_code=false,$balance='') {
        $card = array(
            'card_id' => $card_id
        );
        $data = array(
            'action_name' => "QR_CARD"
        );
        if ($code)
            $card['code'] = $code;
        if ($openid)
            $card['openid'] = $openid;
        if ($is_unique_code)
            $card['is_unique_code'] = $is_unique_code;
        if ($balance)
            $card['balance'] = $balance;
        if ($expire_seconds)
            $data['expire_seconds'] = $expire_seconds;
        $data['action_info'] = array('card' => $card);
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_QRCODE_CREATE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���� code
     * �Զ��� code��use_custom_code Ϊ true�����Ż�ȯ���� code ������ʱ��������ô˽ӿڡ�
     *
     * @param string $code Ҫ���ĵ����к�
     * @param string $card_id Ҫ�������к������� card_id��������ȯʱuse_custom_code ��д true ʱ���
     * @return boolean|array
     * {
     *  "errcode":0,
     *  "errmsg":"ok",
     *  "card":{"card_id":"pFS7Fjg8kV1IdDz01r4SQwMkuCKc"},
     *  "openid":"oFS7Fjl0WsZ9AMZqrI80nbIq8xrA"
     * }
     */
    public function consumeCardCode($code,$card_id='') {
        $data = array('code' => $code);
        if ($card_id)
            $data['card_id'] = $card_id;
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_CODE_CONSUME . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * code ����
     * @param string $encrypt_code ͨ�� choose_card_info ��ȡ�ļ����ַ���
     * @return boolean|array
     * {
     *  "errcode":0,
     *  "errmsg":"ok",
     *  "code":"751234212312"
     *  }
     */
    public function decryptCardCode($encrypt_code) {
        $data = array(
            'encrypt_code' => $encrypt_code,
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_CODE_DECRYPT . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ѯ code ����Ч�ԣ����Զ��� code��
     * @param string $code
     * @return boolean|array
     * {
     *  "errcode":0,
     *  "errmsg":"ok",
     *  "openid":"oFS7Fjl0WsZ9AMZqrI80nbIq8xrA",    //�û� openid
     *  "card":{
     *      "card_id":"pFS7Fjg8kV1IdDz01r4SQwMkuCKc",
     *      "begin_time": 1404205036,               //��ʼʹ��ʱ��
     *      "end_time": 1404205036,                 //����ʱ��
     *  }
     * }
     */
    public function checkCardCode($code) {
        $data = array(
            'code' => $code,
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_CODE_GET . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ������ѯ���б�
	 * @param $offset  ��ʼ��ȡ��ƫ�ƣ�Ĭ��Ϊ0��ͷ��ʼ
	 * @param $count   ��Ҫ��ѯ�Ŀ�Ƭ���������������50,Ĭ��50��
     * @return boolean|array
     * {
     *  "errcode":0,
     *  "errmsg":"ok",
     *  "card_id_list":["ph_gmt7cUVrlRk8swPwx7aDyF-pg"],    //�� id �б�
     *  "total_num":1                                       //���̻����� card_id ����
     * }
     */
    public function getCardIdList($offset=0,$count=50) {
        if ($count>50)
            $count = 50;
        $data = array(
            'offset' => $offset,
            'count'  => $count,
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_BATCHGET . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���� code
     * Ϊȷ��ת����İ�ȫ�ԣ�΢�������Զ���code���̻������·���code���и��ġ�
     * ע��Ϊ�����û��ɻ󣬽�����ڷ���ת����Ϊ�󣨷���ת����΢�Ż�ͨ���¼����͵ķ�ʽ��֪�̻���ת���Ŀ�ȯcode�����û���code���и��ġ�
     * @param string $code      ��ȯ�� code ����
     * @param string $card_id   ��ȯ ID
     * @param string $new_code  �µĿ�ȯ code ����
     * @return boolean
     */
    public function updateCardCode($code,$card_id,$new_code) {
        $data = array(
            'code' => $code,
            'card_id' => $card_id,
            'new_code' => $new_code,
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_CODE_UPDATE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ���ÿ�ȯʧЧ
     * ���ÿ�ȯʧЧ�Ĳ���������
     * @param string $code ��Ҫ����ΪʧЧ�� code
     * @param string $card_id �Զ��� code �Ŀ�ȯ������Զ��� code �Ŀ�ȯ���
     * @return boolean
     */
    public function unavailableCardCode($code,$card_id='') {
        $data = array(
            'code' => $code,
        );
        if ($card_id)
            $data['card_id'] = $card_id;
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_CODE_UNAVAILABLE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ����޸�
     * @param string $data
     * @return boolean
     */
    public function modifyCardStock($data) {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_MODIFY_STOCK . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ������Ʊ
     * @param string $data
     * @return boolean
     */
    public function updateMeetingCard($data) {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_MEETINGCARD_UPDATEUSER . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ����/�󶨻�Ա��
     * @param string $data ����ṹ��ο���ȯ�����ĵ�(6.1.1 ����/�󶨻�Ա��)�½�
     * @return boolean
     */
    public function activateMemberCard($data) {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_MEMBERCARD_ACTIVATE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ��Ա������
     * ��Ա�����׺�ÿ�λ��ּ��������ͨ���ӿ�֪ͨ΢�ţ����ں�����Ϣ֪ͨ��������չ���ܡ�
     * @param string $data ����ṹ��ο���ȯ�����ĵ�(6.1.2 ��Ա������)�½�
     * @return boolean|array
     */
    public function updateMemberCard($data) {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_MEMBERCARD_UPDATEUSER . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���º�����
     * @param string $code      ��������к�
     * @param $balance          ������
     * @param string $card_id   �Զ��� code �Ŀ�ȯ������Զ��� code �ɲ��
     * @return boolean|array
     */
    public function updateLuckyMoney($code,$balance,$card_id='') {
        $data = array(
                'code' => $code,
                'balance' => $balance
        );
        if ($card_id)
            $data['card_id'] = $card_id;
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_LUCKYMONEY_UPDATE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ���ÿ�ȯ���԰�����
     * @param string $openid    ���Ե� openid �б�
     * @param string $user      ���Ե�΢�ź��б�
     * @return boolean
     */
    public function setCardTestWhiteList($openid=array(),$user=array()) {
        $data = array();
        if (count($openid) > 0)
            $data['openid'] = $openid;
        if (count($user) > 0)
            $data['username'] = $user;
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_TESTWHILELIST_SET . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * �����豸ID
     * [applyShakeAroundDevice ���������豸�����UUID��Major��Minor��
     * ��������С��50%�����������豸�����������豸����500 ���������˹�������̡�
     * ���ͨ���󣬿���ކ�ص�����ID �á���ѯ�豸�б��ӿ���ȡ����������豸ID]
     * @param array $data
     * array(
     *      "quantity" => 3,         //������豸ID �����������������豸����500 ��,�����˹��������(����)
     *      "apply_reason" => "����",//��������(����)
     *      "comment" => "����ר��", //��ע(�Ǳ���)
     *      "poi_id" => 1234         //�豸�������ŵ�ID(�Ǳ���)
     * )
     * @return boolean|mixed
     * {
        "data": {
            "apply_id": 123,
            "device_identifiers":[
            {
            "device_id":10100,
            "uuid":"FDA50693-A4E2-4FB1-AFCF-C6EB07647825",
            "major":10001,
            "minor":10002
            }
            ]
        },
        "errcode": 0,
        "errmsg": "success."
        }

        apply_id:���������ID�������ڡ���ѯ�豸�б��ӿڰ����β�ѯ��������ɹ����豸ID
        device_identifiers:ָ�����豸ID �б�
        device_id:�豸���
        uuid��major��minor
        audit_status:���״̬��0�����δͨ����1������С�2�������ͨ������˻������������������
        audit_comment:��˱�ע��������˲�ͨ����ԭ��
     * @access public
     * @author polo<gao.bo168@gmail.com>
     * @version 2015-3-25 ����1:24:06
     * @copyright Show More
     */
    public function applyShakeAroundDevice($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::SHAKEAROUND_DEVICE_APPLYID . 'access_token=' . $this->access_token, self::json_encode($data));
        $this->log($result);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �༭�豸��Ϣ
     * [updateShakeAroundDevice �༭�豸�ı�ע��Ϣ�������豸ID��������UUID��Major��Minorָ���豸������ѡ��һ��]
     * @param array $data
     * array(
     *      "device_identifier" => array(
     *          		"device_id" => 10011,   //���ṩ��device_id����Ҫʹ��uuid��major��minor����֮��Ȼ
     *          		"uuid" => "FDA50693-A4E2-4FB1-AFCF-C6EB07647825",
     *          		"major" => 1002,
     *          		"minor" => 1223
     *      ),
     *      "comment" => "����ר��", //��ע(�Ǳ���)
     * )
     * {
        "data": {
        },
        "errcode": 0,
        "errmsg": "success."
       }
     * @return boolean
     * @author binsee<binsee@163.com>
     * @version 2015-4-20 23:45:00
     */
    public function updateShakeAroundDevice($data){
    	if (!$this->access_token && !$this->checkAuth()) return false;
    	$result = $this->http_post(self::API_BASE_URL_PREFIX . self::SHAKEAROUND_DEVICE_UPDATE . 'access_token=' . $this->access_token, self::json_encode($data));
    	$this->log($result);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ��ѯ�豸�б�
     * [searchShakeAroundDevice ��ѯ���е��豸ID��UUID��Major��Minor������״̬����ע��Ϣ�������ŵꡢ����ҳ�����Ϣ��
     * ��ָ���豸ID ��������UUID��Major��Minor ��ѯ��Ҳ��������ȡ�豸��Ϣ�б�]
     * @param array $data
     * $data ���ָ�ʽ:
     * �ٲ�ѯָ���豸ʱ��$data = array(
     *                              "device_identifiers" => array(
     *                                                          array(
     *                                                              "device_id" => 10100,
     *                                                              "uuid" => "FDA50693-A4E2-4FB1-AFCF-C6EB07647825",
     *                                                              "major" => 10001,
     *                                                              "minor" => 10002
     *                                                          )
     *                                                      )
     *                              );
     * device_identifiers:ָ�����豸
     * device_id:�豸��ţ�������UUID��major��minor����ɲ����豸��ţ������߶�������豸���Ϊ����
     * uuid��major��minor:������Ϣ����д�������������豸��ţ���ɲ������Ϣ
     * +-------------------------------------------------------------------------------------------------------------
     * ����Ҫ��ҳ��ѯ����ָ����Χ�ڵ��豸ʱ: $data = array(
     *                                                  "begin" => 0,
     *                                                  "count" => 3
     *                                               );
     * begin:�豸�б����ʼ����ֵ
     * count:����ѯ���豸����
     * +-------------------------------------------------------------------------------------------------------------
     * �۵���Ҫ��������ID ��ѯʱ: $data = array(
     *                                      "apply_id" => 1231,
     *                                      "begin" => 0,
     *                                      "count" => 3
     *                                    );
     * apply_id:����ID
     * +-------------------------------------------------------------------------------------------------------------
     * @return boolean|mixed
     *��ȷކ��JSON ����ʾ����
     *�ֶ�˵��
        {
            "data": {
                "devices": [          //ָ�����豸��Ϣ�б�
                    {
                        "comment": "", //�豸�ı�ע��Ϣ
                        "device_id": 10097, //�豸���
                        "major": 10001,
                        "minor": 12102,
                        "page_ids": "15369", //����豸������ҳ��ID �б��ö��Ÿ���
                        "status": 1, //����״̬��0��δ���1���Ѽ��������Ծ����2����Ծ
                        "poi_id": 0, //�ŵ�ID
                        "uuid": "FDA50693-A4E2-4FB1-AFCF-C6EB07647825"
                    },
                    {
                        "comment": "", //�豸�ı�ע��Ϣ
                        "device_id": 10098, //�豸���
                        "major": 10001,
                        "minor": 12103,
                        "page_ids": "15368", //����豸������ҳ��ID �б��ö��Ÿ���
                        "status": 1, //����״̬��0��δ���1���Ѽ��������Ծ����2����Ծ
                        "poi_id": 0, //�ŵ�ID
                        "uuid": "FDA50693-A4E2-4FB1-AFCF-C6EB07647825"
                    }
                ],
                "total_count": 151 //�̻����µ��豸����
            },
            "errcode": 0,
            "errmsg": "success."
        }
     * @access public
     * @author polo<gao.bo168@gmail.com>
     * @version 2015-3-25 ����1:45:42
     * @copyright Show More
     */
    public function searchShakeAroundDevice($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::SHAKEAROUND_DEVICE_SEARCH . 'access_token=' . $this->access_token, self::json_encode($data));
        $this->log($result);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * [bindLocationShakeAroundDevice �����豸���ŵ�Ĺ�����ϵ]
     * @param string $device_id �豸��ţ�������UUID��major��minor����ɲ����豸��ţ������߶�������豸���Ϊ����
     * @param int $poi_id ���������ŵ�ID
     * @param string $uuid UUID��major��minor��������Ϣ����д�������������豸��ţ���ɲ������Ϣ
     * @param int $major
     * @param int $minor
     * @return boolean|mixed
     * ��ȷ����JSON ����ʾ��:
     * {
        "data": {
        },
        "errcode": 0,
        "errmsg": "success."
       }
     * @access public
     * @author polo<gao.bo168@gmail.com>
     * @version 2015-4-21 00:14:00
     * @copyright Show More
     */
    public function bindLocationShakeAroundDevice($device_id,$poi_id,$uuid='',$major=0,$minor=0){
        if (!$this->access_token && !$this->checkAuth()) return false;
        if(!$device_id){
            if(!$uuid || !$major || !$minor){
                return false;
            }
            $device_identifier = array(
                'uuid' => $uuid,
                'major' => $major,
                'minor' => $minor
            );
        }else{
            $device_identifier = array(
                'device_id' => $device_id
            );
        }
        $data = array(
            'device_identifier' => $device_identifier,
            'poi_id' => $poi_id
        );
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::SHAKEAROUND_DEVICE_BINDLOCATION . 'access_token=' . $this->access_token, self::json_encode($data));
        $this->log($result);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json; //������Ը���Ϊ����true
        }
        return false;
    }

    /**
     * [bindPageShakeAroundDevice �����豸��ҳ��Ĺ�����ϵ��
     * ֧�ֽ�������������ϵ��Ҳ֧������ҳ��򸲸�ҳ��Ȳ�����
     * ������ɺ��ڴ��豸���źŷ�Χ�ڣ�����ҡ��������ҳ����Ϣ��
     * ���豸���ö��ҳ�棬���������ҳ����Ϣ]
     * @param string $device_id �豸��ţ�������UUID��major��minor����ɲ����豸��ţ������߶�������豸���Ϊ����
     * @param array $page_ids ��������ҳ���б�
     * @param number $bind ����������־λ�� 0 Ϊ���������ϵ��1 Ϊ����������ϵ
     * @param number $append ����������־λ�� 0 Ϊ���ǣ�1 Ϊ����
     * @param string $uuid UUID��major��minor��������Ϣ����д�������������豸��ţ���ɲ������Ϣ
     * @param int $major
     * @param int $minor
     * @return boolean|mixed
     * ��ȷ����JSON ����ʾ��:
     * {
        "data": {
        },
        "errcode": 0,
        "errmsg": "success."
       }
     * @access public
     * @author polo<gao.bo168@gmail.com>
     * @version 2015-4-21 00:31:00
     * @copyright Show More
     */
    public function bindPageShakeAroundDevice($device_id,$page_ids=array(),$bind=1,$append=1,$uuid='',$major=0,$minor=0){
        if (!$this->access_token && !$this->checkAuth()) return false;
        if(!$device_id){
            if(!$uuid || !$major || !$minor){
                return false;
            }
            $device_identifier = array(
                'uuid' => $uuid,
                'major' => $major,
                'minor' => $minor
            );
        }else{
            $device_identifier = array(
                'device_id' => $device_id
            );
        }
        $data = array(
            'device_identifier' => $device_identifier,
            'page_ids' => $page_ids,
            'bind' => $bind,
            'append' => $append
        );
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::SHAKEAROUND_DEVICE_BINDPAGE . 'access_token=' . $this->access_token, self::json_encode($data));
        $this->log($result);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �ϴ���ҡһҡҳ��չʾ��ͼƬ�ز�
     * ע�⣺����ļ�ֵ���⣬���ļ���ǰ�����@��ʹ�õ������Ա��Ȿ��·��б�ܱ�ת��
     * @param array $data {"media":'@Path\filename.jpg'} ��ʽ�޶�Ϊ��jpg,jpeg,png,gif��ͼƬ��С����120px*120 px�����Ʋ�����200 px *200 px��ͼƬ��Ϊ�����Ρ�
     * @return boolean|array
     * {
        "data": {
            "pic_url":"http://shp.qpic.cn/wechat_shakearound_pic/0/1428377032e9dd2797018cad79186e03e8c5aec8dc/120"
        },
            "errcode": 0,
            "errmsg": "success."
        }
       }
     * @author binsee<binsee@163.com>
     * @version 2015-4-21 00:51:00
     */
    public function uploadShakeAroundMedia($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX.self::SHAKEAROUND_MATERIAL_ADD.'access_token='.$this->access_token,$data,true);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * [addShakeAroundPage ����ҡһҡ������ҳ����Ϣ��������ҡһҡҳ����ֵ������⡢�����⡢ͼƬ�͵����ȥ�ĳ����ӡ�]
     * @param string $title ��ҡһҡҳ��չʾ�������⣬������6 ����
     * @param string $description ��ҡһҡҳ��չʾ�ĸ����⣬������7 ����
     * @param sting $icon_url ��ҡһҡҳ��չʾ��ͼƬ�� ��ʽ�޶�Ϊ��jpg,jpeg,png,gif; ����120*120 �� ���Ʋ�����200*200
     * @param string $page_url ��ת����
     * @param string $comment ҳ��ı�ע��Ϣ��������15 ����,�ɲ���
     * @return boolean|mixed
     * ��ȷ����JSON ����ʾ��:
     * {
        "data": {
            "page_id": 28840 //����ҳ���ҳ��id
        }
        "errcode": 0,
        "errmsg": "success."
       }
     * @access public
     * @author polo<gao.bo168@gmail.com>
     * @version 2015-3-25 ����2:57:09
     * @copyright Show More
     */
    public function addShakeAroundPage($title,$description,$icon_url,$page_url,$comment=''){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            "title" => $title,
            "description" => $description,
            "icon_url" => $icon_url,
            "page_url" => $page_url,
            "comment" => $comment
        );
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::SHAKEAROUND_PAGE_ADD . 'access_token=' . $this->access_token, self::json_encode($data));
        $this->log($result);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * [updateShakeAroundPage �༭ҡһҡ������ҳ����Ϣ��������ҡһҡҳ����ֵ������⡢�����⡢ͼƬ�͵����ȥ�ĳ����ӡ�]
     * @param int $page_id
     * @param string $title ��ҡһҡҳ��չʾ�������⣬������6 ����
     * @param string $description ��ҡһҡҳ��չʾ�ĸ����⣬������7 ����
     * @param sting $icon_url ��ҡһҡҳ��չʾ��ͼƬ�� ��ʽ�޶�Ϊ��jpg,jpeg,png,gif; ����120*120 �� ���Ʋ�����200*200
     * @param string $page_url ��ת����
     * @param string $comment ҳ��ı�ע��Ϣ��������15 ����,�ɲ���
     * @return boolean|mixed
     * ��ȷ����JSON ����ʾ��:
     * {
        "data": {
            "page_id": 28840 //�༭ҳ���ҳ��ID
        }
        "errcode": 0,
        "errmsg": "success."
       }
     * @access public
     * @author polo<gao.bo168@gmail.com>
     * @version 2015-3-25 ����3:02:51
     * @copyright Show More
     */
    public function updateShakeAroundPage($page_id,$title,$description,$icon_url,$page_url,$comment=''){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            "page_id" => $page_id,
            "title" => $title,
            "description" => $description,
            "icon_url" => $icon_url,
            "page_url" => $page_url,
            "comment" => $comment
        );
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::SHAKEAROUND_PAGE_UPDATE . 'access_token=' . $this->access_token, self::json_encode($data));
        $this->log($result);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * [searchShakeAroundPage ��ѯ���е�ҳ�棬������ҡһҡҳ����ֵ������⡢�����⡢ͼƬ�͵����ȥ�ĳ����ӡ�
     * �ṩ���ֲ�ѯ��ʽ���ٿ�ָ��ҳ��ID ��ѯ����Ҳ��������ȡҳ���б�]
     * @param array $page_ids
     * @param int $begin
     * @param int $count
     * ����Ҫ��ѯָ��ҳ��ʱ:
     * {
        "page_ids":[12345, 23456, 34567]
       }
     * +-------------------------------------------------------------------------------------------------------------
     * ����Ҫ��ҳ��ѯ����ָ����Χ�ڵ�ҳ��ʱ:
     * {
        "begin": 0,
        "count": 3
       }
     * +-------------------------------------------------------------------------------------------------------------
     * @return boolean|mixed
     * ��ȷ����JSON ����ʾ��:
        {
            "data": {
                "pages": [
                    {
                        "comment": "just for test",
                        "description": "test",
                        "icon_url": "https://www.baidu.com/img/bd_logo1.png",
                        "page_id": 28840,
                        "page_url": "http://xw.qq.com/testapi1",
                        "title": "����1"
                    },
                    {
                        "comment": "just for test",
                        "description": "test",
                        "icon_url": "https://www.baidu.com/img/bd_logo1.png",
                        "page_id": 28842,
                        "page_url": "http://xw.qq.com/testapi2",
                        "title": "����2"
                    }
                    ],
                "total_count": 2
            },
            "errcode": 0,
            "errmsg": "success."
        }
     *�ֶ�˵��:
     *total_count �̻����µ�ҳ������
     *page_id ҡ�ܱ�ҳ��ΨһID
     *title ��ҡһҡҳ��չʾ��������
     *description ��ҡһҡҳ��չʾ�ĸ�����
     *icon_url ��ҡһҡҳ��չʾ��ͼƬ
     *page_url ��ת����
     *comment ҳ��ı�ע��Ϣ
     * @access public
     * @author polo<gao.bo168@gmail.com>
     * @version 2015-3-25 ����3:12:17
     * @copyright Show More
     */
    public function searchShakeAroundPage($page_ids=array(),$begin=0,$count=1){
        if (!$this->access_token && !$this->checkAuth()) return false;
        if(!empty($page_ids)){
            $data = array(
                'page_ids' => $page_ids
            );
        }else{
            $data = array(
                'begin' => $begin,
                'count' => $count
            );
        }
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::SHAKEAROUND_PAGE_SEARCH . 'access_token=' . $this->access_token, self::json_encode($data));
        $this->log($result);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * [deleteShakeAroundPage ɾ�����е�ҳ�棬������ҡһҡҳ����ֵ������⡢�����⡢ͼƬ�͵����ȥ�ĳ����ӡ�
     * ֻ��ҳ�����豸û�й�����ϵʱ���ſɱ�ɾ����]
     * @param array $page_ids
     * {
        "page_ids":[12345,23456,34567]
       }
     * @return boolean|mixed
     * ��ȷ����JSON ����ʾ��:
     * {
        "data": {
        },
        "errcode": 0,
        "errmsg": "success."
       }
     * @access public
     * @author polo<gao.bo168@gmail.com>
     * @version 2015-3-25 ����3:23:00
     * @copyright Show More
     */
    public function deleteShakeAroundPage($page_ids=array()){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'page_ids' => $page_ids
        );
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::SHAKEAROUND_PAGE_DELETE . 'access_token=' . $this->access_token, self::json_encode($data));
        $this->log($result);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * [getShakeInfoShakeAroundUser ��ȡ�豸��Ϣ������UUID��major��minor���Լ����롢openID ����Ϣ��]
     * @param string $ticket ҡ�ܱ�ҵ���ticket������ҡ����URL �еõ���ticket��Чʱ��Ϊ30 ����
     * @return boolean|mixed
     * ��ȷ����JSON ����ʾ��:
     * {
        "data": {
            "page_id ": 14211,
            "beacon_info": {
                "distance": 55.00620700469034,
                "major": 10001,
                "minor": 19007,
                "uuid": "FDA50693-A4E2-4FB1-AFCF-C6EB07647825"
            },
            "openid": "oVDmXjp7y8aG2AlBuRpMZTb1-cmA"
        },
        "errcode": 0,
        "errmsg": "success."
       }
     * �ֶ�˵��:
     * beacon_info �豸��Ϣ������UUID��major��minor���Լ�����
     * UUID��major��minor UUID��major��minor
     * distance Beacon �ź����ֻ��ľ���
     * page_id ҡ�ܱ�ҳ��ΨһID
     * openid �̻�AppID ���û���Ψһ��ʶ
     * poi_id �ŵ�ID���еĻ��򷵻أ�û�еĻ�������JSON ��ʽ��
     * @access public
     * @author polo<gao.bo168@gmail.com>
     * @version 2015-3-25 ����3:28:20
     * @copyright Show More
     */
    public function getShakeInfoShakeAroundUser($ticket){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array('ticket' => $ticket);
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::SHAKEAROUND_USER_GETSHAKEINFO . 'access_token=' . $this->access_token, self::json_encode($data));
        $this->log($result);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * [deviceShakeAroundStatistics ���豸Ϊά�ȵ�����ͳ�ƽӿڡ�
     * ��ѯ�����豸����ҡ�ܱ߲��������������������ҡ�ܱ���Ϣ����������������ѯ���ʱ����Ϊ30�졣]
     * @param int $device_id �豸��ţ�������UUID��major��minor�����ɲ����豸��ţ�����ѡ��һ
     * @param int $begin_date ��ʼ����ʱ������ʱ����Ϊ30 ��
     * @param int $end_date ��������ʱ������ʱ����Ϊ30 ��
     * @param string $uuid UUID��major��minor��������Ϣ����д��ɣ��������豸�༭�����ɲ������Ϣ������ѡ��һ
     * @param int $major
     * @param int $minor
     * @return boolean|mixed
     * ��ȷ����JSON ����ʾ��:
     * {
        "data": [
            {
                "click_pv": 0,
                "click_uv": 0,
                "ftime": 1425052800,
                "shake_pv": 0,
                "shake_uv": 0
            },
            {
                "click_pv": 0,
                "click_uv": 0,
                "ftime": 1425139200,
                "shake_pv": 0,
                "shake_uv": 0
            }
        ],
        "errcode": 0,
        "errmsg": "success."
       }
     * �ֶ�˵��:
     * ftime ����0 ���Ӧ��ʱ���
     * click_pv ���ҡ�ܱ���Ϣ�Ĵ���
     * click_uv ���ҡ�ܱ���Ϣ������
     * shake_pv ҡ�ܱߵĴ���
     * shake_uv ҡ�ܱߵ�����
     * @access public
     * @author polo<gao.bo168@gmail.com>
     * @version 2015-4-21 00:39:00
     * @copyright Show More
     */
    public function deviceShakeAroundStatistics($device_id,$begin_date,$end_date,$uuid='',$major=0,$minor=0){
        if (!$this->access_token && !$this->checkAuth()) return false;
        if(!$device_id){
            if(!$uuid || !$major || !$minor){
                return false;
            }
            $device_identifier = array(
                'uuid' => $uuid,
                'major' => $major,
                'minor' => $minor
            );
        }else{
            $device_identifier = array(
                'device_id' => $device_id
            );
        }
        $data = array(
            'device_identifier' => $device_identifier,
            'begin_date' => $begin_date,
            'end_date' => $end_date
        );
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::SHAKEAROUND_STATISTICS_DEVICE . 'access_token=' . $this->access_token, self::json_encode($data));
        $this->log($result);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }


    /**
     * [pageShakeAroundStatistics ��ҳ��Ϊά�ȵ�����ͳ�ƽӿڡ�
     * ��ѯ����ҳ��ͨ��ҡ�ܱ�ҡ���������������������ҡ�ܱ�ҳ�����������������ѯ���ʱ����Ϊ30�졣]
     * @param int $page_id ָ��ҳ���ID
     * @param int $begin_date ��ʼ����ʱ������ʱ����Ϊ30 ��
     * @param int $end_date ��������ʱ������ʱ����Ϊ30 ��
     * @return boolean|mixed
     * ��ȷ����JSON ����ʾ��:
     * {
        "data": [
            {
                "click_pv": 0,
                "click_uv": 0,
                "ftime": 1425052800,
                "shake_pv": 0,
                "shake_uv": 0
            },
            {
                "click_pv": 0,
                "click_uv": 0,
                "ftime": 1425139200,
                "shake_pv": 0,
                "shake_uv": 0
            }
        ],
        "errcode": 0,
        "errmsg": "success."
       }
     * �ֶ�˵��:
     * ftime ����0 ���Ӧ��ʱ���
     * click_pv ���ҡ�ܱ���Ϣ�Ĵ���
     * click_uv ���ҡ�ܱ���Ϣ������
     * shake_pv ҡ�ܱߵĴ���
     * shake_uv ҡ�ܱߵ�����
     * @author binsee<binsee@163.com>
     * @version 2015-4-21 00:43:00
     */
    public function pageShakeAroundStatistics($page_id,$begin_date,$end_date){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'page_id' => $page_id,
            'begin_date' => $begin_date,
            'end_date' => $end_date
        );
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::SHAKEAROUND_STATISTICS_DEVICE . 'access_token=' . $this->access_token, self::json_encode($data));
        $this->log($result);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

	/**
	 * ���ݶ���ID��ȡ��������
	 * @param string $order_id ����ID
	 * @return order array|bool
	 */
	public function getOrderByID($order_id){
		if (!$this->access_token && !$this->checkAuth()) return false;
		if (!$order_id) return false;

		$data = array(
			'order_id'=>$order_id
		);
		$result = $this->http_post(self::API_BASE_URL_PREFIX.self::MERCHANT_ORDER_GETBYID.'access_token='.$this->access_token, self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode']) && $json['errcode']) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json['order'];
		}
		return false;
	}

	/**
	 * ���ݶ���״̬/����ʱ���ȡ��������
	 * @param int $status ����״̬(�������ֶ�-ȫ��״̬, 2-������, 3-�ѷ���, 5-�����, 8-άȨ��, )
	 * @param int $begintime ��������ʱ����ʼʱ��(�������ֶ��򲻰���ʱ����ɸѡ)
	 * @param int $endtime ��������ʱ����ֹʱ��(�������ֶ��򲻰���ʱ����ɸѡ)
	 * @return order list array|bool
	 */
	public function getOrderByFilter($status = null, $begintime = null, $endtime = null){
		if (!$this->access_token && !$this->checkAuth()) return false;

		$data = array();

		$valid_status = array(2, 3, 5, 8);
		if (is_numeric($status) && in_array($status, $valid_status)) {
			$data['status'] = $status;
		}

		if (is_numeric($begintime) && is_numeric($endtime)) {
			$data['begintime'] = $begintime;
			$data['endtime'] = $endtime;
		}
		$result = $this->http_post(self::API_BASE_URL_PREFIX.self::MERCHANT_ORDER_GETBYFILTER.'access_token='.$this->access_token, self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode']) && $json['errcode']) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json['order_list'];
		}
		return false;
	}

	/**
	 * ���ö���������Ϣ
	 * @param string $order_id ���� ID
	 * @param int $need_delivery ��Ʒ�Ƿ���Ҫ����(0-����Ҫ��1-��Ҫ)
	 * @param string $delivery_company ������˾ ID
	 * @param string $delivery_track_no �˵� ID
	 * @param int $is_others �Ƿ�Ϊ 6.4.5 ��֮�������������˾(0-��1-��)
	 * @return bool
	 */
	public function setOrderDelivery($order_id, $need_delivery = 0, $delivery_company = null, $delivery_track_no = null, $is_others = 0){
		if (!$this->access_token && !$this->checkAuth()) return false;
		if (!$order_id) return false;

		$data = array();
		$data['order_id'] = $order_id;
		if ($need_delivery) {
			$data['delivery_company'] = $delivery_company;
			$data['delivery_track_no'] = $delivery_track_no;
			$data['is_others'] = $is_others;
		}
		else {
			$data['need_delivery'] = $need_delivery;
		}

		$result = $this->http_post(self::API_BASE_URL_PREFIX.self::MERCHANT_ORDER_SETDELIVERY.'access_token='.$this->access_token, self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode']) && $json['errcode']) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	 * �رն���
	 * @param string $order_id ���� ID
	 * @return bool
	 */
	public function closeOrder($order_id){
		if (!$this->access_token && !$this->checkAuth()) return false;
		if (!$order_id) return false;

		$data = array(
			'order_id'=>$order_id
		);

		$result = $this->http_post(self::API_BASE_URL_PREFIX.self::MERCHANT_ORDER_CLOSE.'access_token='.$this->access_token, self::json_encode($data));
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode']) && $json['errcode']) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return true;
		}
		return false;
	}

	private function parseSkuInfo($skuInfo) {
		$skuInfo = str_replace("\$", "", $skuInfo);
		$matches = explode(";", $skuInfo);

		$result = array();
		foreach ($matches as $matche) {
			$arrs = explode(":", $matche);
			$result[$arrs[0]] = $arrs[1];
		}

		return $result;
	}

	/**
	 * ��ȡ����SkuInfo - ��������֪ͨ
	 * ��EventΪ merchant_order(��������֪ͨ)
	 * @return array|boolean
	 */
	public function getRevOrderSkuInfo(){
		if (isset($this->_receive['SkuInfo']))     //���� SkuInfo
			return $this->parseSkuInfo($this->_receive['SkuInfo']);
		else
			return false;
	}
}
/**
 * PKCS7Encoder class
 *
 * �ṩ����PKCS7�㷨�ļӽ��ܽӿ�.
 */
class PKCS7Encoder
{
    public static $block_size = 32;

    /**
     * ����Ҫ���ܵ����Ľ�����䲹λ
     * @param $text ��Ҫ������䲹λ����������
     * @return ���������ַ���
     */
    function encode($text)
    {
        $block_size = PKCS7Encoder::$block_size;
        $text_length = strlen($text);
        //������Ҫ����λ��
        $amount_to_pad = PKCS7Encoder::$block_size - ($text_length % PKCS7Encoder::$block_size);
        if ($amount_to_pad == 0) {
            $amount_to_pad = PKCS7Encoder::block_size;
        }
        //��ò�λ���õ��ַ�
        $pad_chr = chr($amount_to_pad);
        $tmp = "";
        for ($index = 0; $index < $amount_to_pad; $index++) {
            $tmp .= $pad_chr;
        }
        return $text . $tmp;
    }

    /**
     * �Խ��ܺ�����Ľ��в�λɾ��
     * @param decrypted ���ܺ������
     * @return ɾ����䲹λ�������
     */
    function decode($text)
    {

        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > PKCS7Encoder::$block_size) {
            $pad = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }

}
?>