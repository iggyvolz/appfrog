<?php
session_start();
define('url','http://fightmon.hp.af.cm/upload.php');
define('password', 'T5ESuguphetrumaq2druThACr8wrEqebahespazaSpEswUwEvaRECrUzUjeWReya');
define('local', 'http://localhost/fightmon/local/upload.php');
define('executables', serialize(array('php', 'php5', 'htaccess')));
if(!isset($_SESSION['appfrog_init']))
{
$_SESSION['appfrog_init']=TRUE;
/* source for function find_all_files http://www.php.net/manual/en/function.scandir.php#107117 */
function find_all_files($dir)
{
    $root = scandir($dir);
    foreach($root as $value)
    {
        if($value === '.' || $value === '..') {continue;}
        if(is_file("$dir/$value")) {$result[]="$dir/$value";continue;}
        foreach(find_all_files("$dir/$value") as $value)
        {
            $result[]=$value;
        }
    }
    return $result;
}
$_SESSION['files']=find_all_files('../remote');
}
$file=array_strip($_SESSION['files']);
$executables=unserialize(executables);
$executable=FALSE;
foreach($executables as $value)
{
if(last(explode('.',$file))===$value)
{
$executable=TRUE;
}
}
if($executable)
{
ob_start();
include $file;
$contents=ob_get_contents();
ob_end_clean();
}
else
{
$contents=file_get_contents($file);
}
?><HEAD><SCRIPT LANGUAGE="JavaScript">setTimeout('document.test.submit()',0);</SCRIPT></HEAD><BODY><form method="post" name="test" action="<?php echo url; ?>"><input type="hidden" name="contents" value="<?php echo $contents; ?>"></input><input type="hidden" name="mode" value="w"></input><input type="hidden" name="password" value="<?php echo password; ?>"></input><input type="hidden" name="return" value="<?php echo local; ?>"></input><input type="hidden" name="filename" value="<?php echo $file; ?>"></input></BODY><?php die; ?>
