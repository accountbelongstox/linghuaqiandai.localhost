<?php
App::uses('AppController', 'Controller');
/**
 * Admin Controller
 *
 * @property Admin $Admin
 */
class LnapiController extends AppController {
	
	public $layout = "default";
	public $components = array('RequestHandler');
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author apple
	 **/
	public function beforeFilter() {
		parent::beforeFilter();
		$this->loadModel('TPerson');
		$this->loadModel('WxWebchat');
		$this->loadModel('WxWcdata');
		$this->loadModel('WxSession');
		
		// Debug API
		$this->_debug();
	}
	
	/**
	 * Debug..
	 *
	 * @return void
	 * @author apple
	 **/
	function _debug() {
		// $wxid = $this->WxWebchat->getWxId("gh_552dce125e18");
		// $this->loadModel('WxSession');
		// 	
		// 	$this->WxSession->write('5320ba72-3d7c-44cf-8d7b-01b1352441c2', 'RWX.APPIDd', '564');
			// $this->WxSession->setWxId('5320ba72-3d7c-44cf-8d7b-01b1352441c2');
			// $this->WxSession->write('RWX.APPID', '23232');
			// $this->WxSession->write('RWX.APPID', '123222222222');exit;
			// $this->WxSession->delete('RWX.APPID');
	
		// $str = $this->WxWcdata->getMsg('lnbook55');
		// echo $str;exit;
		// $contentStr = $this->WxWebchat->getMsg('text', "0dfdf", 'gh_552dce125e18');
		// 	echo $contentStr;exit;
	}
	
	/**
	 * undocumented function
	 *
	 * @param string $id 
	 * @return void
	 * @author apple
	 */
	public function index($id) {
		$postStr = "php://input";
		$wx = new Wxauth($this->wxToken);		
		if (!empty($postStr)) {
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
			$msgType = $postObj->MsgType;
            $textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";   
					
			// WX Code..
			$wxid = $this->WxWebchat->getWxId($toUsername);
			if ($wxid) {
				$this->WxSession->setWxId($wxid);
				switch ($msgType) {
					case 'text':
						$keyExits = array('??????', '-1', '88', 'bye', '888', '??????');
						if (in_array($keyword, $keyExits)) {
							$this->WxSession->delete('RWX.APPID');
							$contentStr = "??????????????????????????????";
						}
						else
						{
							switch ($this->WxSession->read('RWX.APPID')) {
								case '1':
									$data = array(
										'answer' => array('??????????????????', '??????????????????'),
										'successMsg' => "???????????????????????????",
										'errorMsg' => "????????????????????????????????????"
									);
									$ansid = $this->WxSession->read('RWX.APPANS');
									if (count($data['answer']) == $ansid)
									{
										$cstr = $data['answer']['successMsg'];
									}
									$cstr = isset($data['answer'][$ansid]) ? $data['answer'][$ansid] : reset($data['answer']);
									$contentStr = $cstr;
									$this->WxSession->write('RWX.APPANS', $ansid + 1);
									break;
								case '2':
									$contentStr = "??????????????????";
									break;
								case '3':
									$contentStr = "????????????????????????";
									break;
								case '4':
									$contentStr = "?????????????????????";
									break;
								case '5':
									$contentStr = "?????????????????????";
									break;
								case '6':
									$contentStr = "?????????????????????";
									break;
								case '7':
									$contentStr = "????????????????????????";
									break;
								case '8':
									$contentStr = "????????????";
									break;
								default:
									if ($keyword == '1') {
										$this->WxSession->write('RWX.APPID', '1');
										$contentStr = "?????????????????????????????????";
									} else if ($keyword == '2') {
										$this->WxSession->write('RWX.APPID', '2');
										$contentStr = "?????????????????????????????????";
									} else if ($keyword == '3') {
										$this->WxSession->write('RWX.APPID', '3');
										$contentStr = "???????????????????????????????????????";
									} else if ($keyword == '4') {
										$this->WxSession->write('RWX.APPID', '4');
										$contentStr = "????????????????????????????????????";
									} else if ($keyword == '5') {
										$this->WxSession->write('RWX.APPID', '5');
										$contentStr = "????????????????????????????????????";
									} else if ($keyword == '6') {
										$this->WxSession->write('RWX.APPID', '6');
										$contentStr = "????????????????????????????????????";
									} else if ($keyword == '7') {
										$this->WxSession->write('RWX.APPID', '7');
										$contentStr = "???????????????????????????????????????";
									} else if ($keyword == '8') {
										$this->WxSession->write('RWX.APPID', '8');
										$contentStr = "???????????????";
									} else {
										$contentStr = $this->WxWebchat->getMsg('text', $keyword, $toUsername);
									}
							}
						}
						$msgType = "text";
		            	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		            	echo $resultStr;
						break;
					case 'event':
						$event = $postObj->Event;
						if ($event == 'subscribe') {
							$contentStr = $this->WxWebchat->getMsg('subscribe', $keyword, $toUsername);
							$msgType = "text";
			            	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			            	echo $resultStr;
						}
						break;
					default:
				}
			} else {
				echo '?????????????????????????????????????????????????????????';		// Check wxid
			}
		} else {
			$wx->wx_valid();
		}	
		$this->render('/Wx/api');
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author apple
	 */
	public function add() {
		if ($this->TPerson->validates()) {
			$pdata = $this->request->data['TPerson']; 
			$pdata = $this->arrayToObject($pdata);
			$edata = $this->request->data['TEducation'];
			$edata = $this->arrayToObject($edata);
			$uid = $this->TPerson->addPerson();
			$query = $this->TPerson->saveAndEduInfo($uid, $pdata, $edata, 1);
			if ($query) {
				$wx_avatar = file_get_contents($pdata->wx_avatar);
				$isAvatar = ClassRegistry::init('TPersonIcon')->addAvatar($uid, $wx_avatar);
				if ($isAvatar) {
					// ??????????????????
					$upyun = new Upcdn();
					$upyun->wtImage("{$uid}.jpg", $wx_avatar, 'avatar');
				}
				$user = $this->TPerson->getUserInfo($uid);
				$this->set('data', $user);
				$this->render('/Wx/success');
			}
		} else {
			$wx = new Wxauth();
			$data = $wx->getuserinfo();
			$this->set('data', $data);
			$this->render('/Wx/index');
		}
	}
	
	function arrayToObject($e) {
		if (gettype($e)!='array' ) return;
		foreach ($e as $k => $v) {
			if(gettype($v) =='array' || getType($v) =='object') {
				$e[$k] = (object)arrayToObject($v);
			}	
		}
		return (object)$e;
	}
}
