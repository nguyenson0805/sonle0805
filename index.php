<?php 
include 'system/autoload.php';
$controllername =isset($_GET['controller']) && $_GET['controller']? $_GET['controller'].'controller':'systemcontroller';
$actionname = isset($_GET['action']) && $_GET['action']? $_GET['action']:'trangchu';
if(class_exists($controllername)){
	$controller = new $controllername();
	if(method_exists($controller,$actionname))
		$controller->$actionname();
	else{
		//include_once 'controller/systemcontroller.php';
		$controller = new systemcontroller();
		$controller->_404();
	}
}else
{
	//include 'controller/systemcontroller.php';
	$controller = new systemcontroller();
	$controller->_404();
}
ob_end_flush();
?>