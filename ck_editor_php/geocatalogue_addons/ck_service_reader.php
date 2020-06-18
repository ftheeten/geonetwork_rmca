<?php
header('Content-Type: application/json');
try 
{
	
	$host="localhost";
	$database="****";
	$user="****";
	$pwd="****";

	$page=$_REQUEST["page"];
	
	if(strlen($page)>0 )
	{
		
		$pdo = new PDO('pgsql:host='.$host.';dbname='.$database, $user, $pwd);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$data = [
			
			'page' => urldecode($page)
		];
		$sql = "SELECT content FROM page_content WHERE web_page=:page;";
		$stmt= $pdo->prepare($sql);
		$stmt->execute($data);
		print(json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)));
	}
	
	
	
}
catch(Exception $e) 
{
	  
	print(json_encode(array("error"=>$e->getMessage())));
		
}
?>
