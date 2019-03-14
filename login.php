<?php
require("include/connect.php");


$username = $_GET['username'];
$password = $_GET['password'];


$sql = "SELECT * FROM tb_users  WHERE username = '$username' AND password = '$password'";
$result = $con->query($sql);

if($result->num_rows > 0 ){
    
    $row = $result->fetch_assoc();
    $token = generateToken($username,$row['id']);
    echo json_encode(["token" => $token]);

}else{
    echo json_encode(array("message"=>"Authorization Error"));
}


function generateToken($username,$id){
    //header
$header = json_encode(['typ'=> 'JWT' , 'alg' => 'HS256']);
$base64Header = str_replace(['+','/','='],['-','_'],base64_encode($header));

//payload
$payload = json_encode(['username' => $username, "id" => $id]);
$base64Payload = str_replace(['+','/','='],['-','_'],base64_encode($payload));

//signature
$signature = hash_hmac('sha256', $base64Header . "." . $base64Payload, 'sad',true);
$base64Signature = str_replace(['+','/','='],['-','_'],base64_encode($signature));

//token
    $token = $base64Header.".". $base64Payload.".". $base64Signature;
    return $token;
}

?>  