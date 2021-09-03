<?php

$rMethod  = isset($_SERVER['REQUEST_METHOD'])? $_SERVER['REQUEST_METHOD']: '';
$bodyData =	file_get_contents("php://input");

$formData = [];
if($bodyData)
{
	$formData = json_decode($bodyData, true);
	if(!$formData)
	{
		$formData = [];
	}
}

if(empty($formData) && $rMethod == 'POST')
{
	$formData = $_POST;
}

$data = [
			[
				'id' => 1,
				'name' => 'Amsify42'
			]
		];

if($rMethod == 'POST')
{
	$data = $formData;
	$data['id'] = 2;
}
else if($rMethod == 'PUT')
{
	$data = $formData;
}
else if($rMethod == 'DELETE')
{
	$data = ['id' => isset($formData['id'])? $formData['id']: null];
}

$responseData = ['status' => 'success', 'data' => $data];

header('Content-Type: application/json');
echo json_encode($responseData);