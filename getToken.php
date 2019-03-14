<?php
require("include/connect.php");

$token = $_GET["token"];

$token_split = explode(".",$token);
$header = $token_split[0];
$payload = $token_split[1];
$signature = $token_split[2];


$decodedSignature = base64_decode($signature);
$decodedHeader = base64_decode($header);
$decodedPayload = base64_decode($payload);



$new_signature = hash_hmac('sha256', $header . "." . $payload, 'sad',true);
$new_signature = str_replace(['+','/','='],['-','_'],base64_encode($new_signature));

$new_signature = $new_signature;



$decodedPayload = json_decode($decodedPayload);
echo $decodedPayload->username;
$sql = "SELECT * FROM tb_users WHERE username = '$decodedPayload->username'";
$result = $con->query($sql);

if($result->num_rows > 0){
    if($new_signature == $signature){
        //True Token
        $sql2 = "SELECT * FROM tb_users WHERE id=$decodedPayload->id";
        $result2 = $con->query($sql2);
        if($result2->num_rows > 0){
            
        $row = $result->fetch_assoc();
        $response = array("id" => $row["id"],"username" => $row["username"],"information" => $row["extra"],"sample information" => $row["sample"]);
        echo json_encode($response);
        echo ($token);
    }

        
    }else{
        die(json_encode(array("message" => "Wrong jwt token")));
    }
    
}else{
    
    die(json_encode(array("message" => "No users with this token")));
}










?>