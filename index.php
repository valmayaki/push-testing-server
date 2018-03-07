<?php

require_once __DIR__."/vendor/autoload.php";

$subscription = json_decode(file_get_contents('php://input'), true);
if (empty($subscription)){
    file_put_contents('user-subscription.json',"");
    return "Removed Subscriptions";
}
// if (!isset($subscription['endpoint'])) {
//     echo 'Error: not a subscription';
//     return;
// }
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        echo "Server is alive";
        break;
    case 'POST':
        // create a new subscription entry in your database (endpoint is unique)
        $subs = json_decode(file_get_contents(__DIR__.'/user-subscription.json'));
        if (isset($subs) && !empty($subs) && is_array($subs)) {
            array_push($subs, $subscription);
    } else {
        $subs = [];
        array_push($subs, $subscription);
    }
    file_put_contents('user-subscription.json', json_encode($subs));
    if (!isset($subscription['endpoint'])) {
        http_response_code(404);
        echo 'Error: not a subscription';
        return;
    }
    header("Content-Type", "application/json");
    echo json_encode(["message" => "succesfully saved", "" => $subscription]);
    break;
case 'PUT':
    // update the key and token of subscription corresponding to the endpoint
    break;
case 'DELETE':
    // delete the subscription corresponding to the endpoint
    break;
default:
    echo "Error: method not handled";
    return;
}
exit();