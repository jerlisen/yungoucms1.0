<?php 
defined('G_IN_SYSTEM')or exit('No permission resources.');
System::load_app_class('base','member','no');
System::load_app_fun('my','go');
System::load_app_fun('user','go');

class us extends base{
	public function __construct() {	
		
	}
	public function uname(){
		$mysql_model=System::load_sys_class('model');
		$title="个人主页";
		$index=intval($this->segment(4));
		if($index > 1000000000)$index = $index-1000000000;
		$tab=$this->segment(3);
		$member=$mysql_model->GetOne("select * from `@#_member` where uid='$index'");
			
		if($member){
			$membergo=$mysql_model->GetList("select * from `@#_member_go_record` where uid='$index'");	
			include templates("us","index");
		}else{
			_message("页面错误",WEB_PATH,3);
		}
	}
	public function userbuy(){
		$mysql_model=System::load_sys_class('model');
		$title="云购记录";
		$index=intval($this->segment(4));
		if($index > 1000000000)$index = $index-1000000000;
		$tab=$this->segment(3);
		$member=$mysql_model->GetOne("select * from `@#_member` where uid='$index'");
		
		if($member){
			$membergo=$mysql_model->GetList("select * from `@#_member_go_record` where uid='$index'");		
			include templates("us","userbuy");
		}else{
			_message("页面错误",WEB_PATH,3);
		}
	}
	public function userraffle(){
		$mysql_model=System::load_sys_class('model');
		$title="获得的商品";
		$index=intval($this->segment(4));
		if($index > 1000000000)$index = $index-1000000000;
		$tab=$this->segment(3);
		$member=$mysql_model->GetOne("select * from `@#_member` where uid='$index'");
		$memberhuode=$mysql_model->GetList("select * from `@#_member_go_record` where uid='$index' and `huode` > '10000000'");		
		if($member){
			include templates("us","userraffle");
		}else{
			_message("页面错误",WEB_PATH,3);
		}
	}
}

?>