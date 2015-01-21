<?php
//require_once('splClassLoader.php');
ini_set('date.timezone','UTC');
//$load = new splClassLoader(null,__DIR__.'/PushBullet');
//$load->setFileExtension('.class.php');
//$load->register();
class ClassAutoLoader {
	public function __construct() {
		spl_autoload_register(array($this,'loader'));
	}
	private function loader($className) {
		require $className . '.php';
	}
}

function tryLock($lock_file)
{
        if(@symlink('/proc/'.getmypid(),$lock_file) !== FALSE)
                return true;
        if(is_link($lock_file) && !is_dir($lock_file))
        {
                unlink($lock_file);
                return tryLock($lock_file);
        }
        return false;
}
function CheckLock($filename,$logFileName)
{
        $lock_file = '/tmp/'.basename($filename).'.lock';
        if(!tryLock($lock_file))
        {
                error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' '.basename($filename).' is running'."\n",3,$logFileName);
                error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' '.basename($filename).' is running'."\n");
                exit;
        }
        register_shutdown_function('unlink',$lock_file);
}

$autoload = new ClassAutoLoader();
$ini_array = parse_ini_file("db.ini",true);
$version_info = $ini_array['VERSION'];
$debug = $version_info['DEBUG'];
if(!$debug)
	$DB = $ini_array['LIBRICK_DB'];
else
	$DB = $ini_array['DB'];
if(!file_exists('./log/'))
        mkdir('./log/',0777);
?>
