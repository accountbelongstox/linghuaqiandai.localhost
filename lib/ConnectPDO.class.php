<?php
class ConnectPDO extends PDO{
	private $host='121.196.224.192';
	private $port='3306';
	//private $user='haohaodata';
	//private $password='7Ih2BZ^%KdOTo1Lv';
	private $user='admin_user';
	private $password='fQI29^r4';
	private $dbname='admin_user';
	public $sys_pre='cloud_';
	public $index_pre='cloud_index_';
	public $table_pre='cloud_form_';
	public $usercreate_pre='cloud_form_zusercreate_';

	function __construct(){
		try{
			if(!defined('PDO::MYSQL_ATTR_INIT_COMMAND')){exit('pdo_mysql not exist');}
			$driver_opts=array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES'UTF8'",PDO::MYSQL_ATTR_USE_BUFFERED_QUERY=>true);
			parent::__construct("mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=UTF8",$this->user,$this->password,$driver_opts);
		}catch(PDOException $e){
			if(is_file('./install_cloud.php') && !isset($_GET['act'])){
				//header("location:./install_cloud.php");
				exit('<script>window.location.href="/install_cloud.php"</script>');
			}else{
				echo "<br />database connect err：".$e->getMessage();exit;	
			}	
		}
		
	}
	function __toString(){
		return '';
    }
	
}

?>