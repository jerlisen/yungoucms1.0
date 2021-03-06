<?php 

/**
*	发送用户手机认证码短信
*	mobile @用户手机号
*   uid    @用户的ID
*/

function send_mobile_reg_code($mobile=null,$uid=null){
		if(!$uid)_message("发送用户手机认证码,用户ID不能为空！");
		if(!$mobile)_message("发送用户手机认证码,手机号码不能为空!");
		
		$db=System::load_sys_class('model');
		$checkcodes=rand(100000,999999).'|'.time();//验证码
		$db->Query("UPDATE `@#_member` SET mobilecode='$checkcodes' where `uid`='$uid'");				
		$checkcodes = explode("|",$checkcodes);
		$template = $db->GetOne("select * from `@#_caches` where `key` = 'template_mobile_reg'");
	
		if(empty($template['value'])){
			$content =  "你在"._cfg("web_name")."的短信验证码是:".strtolower($checkcodes[0]);
		}else{
			if(strpos($template['value'],"000000") == true){
					$content= str_ireplace("000000",strtolower($checkcodes[0]),$template['value']);			
			}else{
					$content = $template['value'].strtolower($checkcodes[0]);					
			}
		}
		if(!$template){
			$content =  "你在"._cfg("web_name")."的短信验证码是:".strtolower($checkcodes[0]);
		}	
		
		return _sendmobile($mobile,$content);
}


/**
*	发送用户手机获奖短信
*	mobile @用户手机号
*   uid    @用户的ID
*	code   @中奖码
*/

function send_mobile_shop_code($mobile=null,$uid=null,$code=null){
		if(!$uid)_message("发送用户手机获奖短信,用户ID不能为空！");
		if(!$mobile)_message("发送用户手机获奖短信,手机号码不能为空!");
		if(!$mobile)_message("发送用户手机获奖短信,中奖码不能为空!");
		$db=System::load_sys_class('model');					
		$template = $db->GetOne("select * from `@#_caches` where `key` = 'template_mobile_shop'");
		if(empty($template['value'])){
			$content =  "你在"._cfg("web_name")."够买的商品已中奖,中奖码是:".$code;
		}else{
			if(strpos($template['value'],"00000000") == true){
					$content= str_ireplace("00000000",$code,$template['value']);
			}else{
					$content = $template['value'].$code;
			}
		}
		if(!$template){
			$template = array();
			$content =  "你在"._cfg("web_name")."够买的商品已中奖,中奖码是:".$code;
		}				
		return _sendmobile($mobile,$content);
}


/**
*	发送用户验证邮箱
*	email  @用户邮箱地址
*   uid    @用户的ID
*/

/**
*	发送用户验证邮箱
*	email  @用户邮箱地址
*   uid    @用户的ID
*/

function send_email_reg($email=null,$uid=null){
	$db=System::load_sys_class('model');
	$checkcode = _getcode(10);			
	$checkcode_sql = $checkcode['code'].'|'.$checkcode['time'];
	$check_code  = serialize(array("email"=>$email,"code"=>$checkcode['code'],"time"=>$checkcode['time']));
	$check_code_url  = _encrypt($check_code,"ENCODE",'',3600*24);

	$clickurl=WEB_PATH.'/member/user/emailok/'.$check_code_url;	
	$db->Query("UPDATE `@#_member` SET `emailcode`='$checkcode_sql' where `uid`='$uid'");
			
	$web_name = _cfg("web_name");
	$title = _cfg("web_name")."激活注册邮箱";
	$template = $db->GetOne("select * from `@#_caches` where `key` = 'template_email_reg'");
	$url = '<a href="';
	$url.= $clickurl.'">';
	$url.= $clickurl."</a>";		
	$template['value'] = str_ireplace("{地址}",$url,$template['value']);			
	return _sendemail($email,'',$title,$template['value']);
}

?>