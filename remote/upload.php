<?php
if(getenval('appfrog_connect')==='true')
{
if(getenval('appfrog_password')===$_GET['password'])
{
$_SESSION['appfrog_auth']=TRUE;
}
die;
}
if($_SESSION['appfrog_auth']!==TRUE)
{
die;
}
?><HEAD><meta http-equiv="refresh" content="0;URL='<?php echo $_POST['return']; ?>'"><HEAD><?php
$handle=fopen($_POST['filename'], $_POST['mode']);
if($handle===FALSE)
{
write_error();
}
$content=fwrite($handle,$_POST['content']);
if($content===FALSE)
{
write_error();
}
fclose($handle);
function write_error()
{
$_SESSION['appfrog_error_logs'][]=print_r($_POST,true);
die;
}
