<?php
header('Content-Type: application/json');
try 
{
	//print($_SERVER['HTTP_REFERER']);
	$host="localhost";
	$database="****";
	$user="****";
	$pwd="****";

	$page=$_REQUEST["page"];
	$data=$_REQUEST["data"];
	if(strlen($page)>0 && strlen($data)>0&& strpos($_SERVER['HTTP_REFERER'], "/geonetwork/")!==false )
	{
		
		$pdo = new PDO('pgsql:host='.$host.';dbname='.$database, $user, $pwd);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$data = [
			'data' => urldecode($data),
			'page' => urldecode($page)
		];
		$sql = "INSERT INTO page_content (web_page, content) 
					VALUES (:page, :data) 
					ON CONFLICT (web_page) 
					DO
					UPDATE
						SET content=:data;";
		$stmt= $pdo->prepare($sql);
		$stmt->execute($data);
		print(json_encode(array("status"=>"done", "referer"=> $_SERVER['HTTP_REFERER'])));
	}
    else
    {
        print(json_encode(array("status"=>"uncommited", "referer"=> $_SERVER['HTTP_REFERER'])));
	
    }
	
	
	
}
catch(Exception $e) 
{
	  
	print(json_encode(array("error"=>$e->getMessage())));
		
}
?>
