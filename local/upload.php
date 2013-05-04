<?php
session_start();
define('url','http://mysite.af.cm/upload.php'); // Path to your upload.php
define('password', 'my_password'); // You password.  Put this as an environmental variable on your appfog site as "appfrog_password"
define('local', 'http://localhost/mysite/local/upload.php'); // Path to your local site
// Also, put an environmental variable of "appfrog_connect".  Make this true when starting the program.  Once you run upload.php, change this to false.
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
