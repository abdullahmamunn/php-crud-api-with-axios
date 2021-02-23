<?php
$conn = new mysqli('localhost','root','','test_api');
if($conn->connect_errno)
{
    die('database connection error');
}

$action  = "read";
$response = [
  "error" => false
];

if(isset($_GET['action'])){
     $action = $_GET['action'];
}
if($action === "read")
{
    $users = array();
   $read = $conn->query('select * from users');
   while( $row = $read->fetch_assoc())
   {
       array_push($users,$row);
   }
   $response['users'] = $users;
}
elseif ($action === "create")
{
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $skill = $_POST['skill'];
    $create = $conn->query("INSERT INTO users(name, email, skill) VALUES ('$name','$email','$skill')");
    if($create)
    {
        $response["message"] = "data save success";
    }
    else{
        $response["error"] = true;
        $response["message"] = "data save failed";
    }
}
elseif ($action === "update")
{
    $id = $_POST['id'];
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $skill = $_POST['skill'];
    $update = $conn->query("UPDATE users SET name='$name', email='$email', skill='$skill' WHERE id='$id'");
    if($update){
        $response['message'] = "Data update success";
    }else{
        $response['error'] = true;
        $response['message'] = "Data update fail";
    }
}
elseif ($action === "delete")
{
    $id  = $_POST['id'];
    $delete = $conn->query("DELETE FROM users WHERE id = $id");
    if($delete)
    {
        $response["message"] = "data deleted success";
    }
    else{
        $response["error"] = true;
        $response["message"] = "data delete failed";
    }
}
else{
    echo "invalid action";
}
header('content-type: application/json');
echo json_encode($response);



?>