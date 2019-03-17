<?php
class ConnectPDO_temp extends PDO{
	private $host='127.0.0.1';
	private $port='3306';
	//private $user='haohaodata';
	//private $password='QKZxi5nsw6zYGZsCKebr';
	private $user='haohaouser';
	private $password='QKZxi5nsw6zYGZsCKebr';
	private $dbname='haohaodata';
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
					
			}	
		}
		
	}
	function __toString(){
		return '';
		}
	
}

?>