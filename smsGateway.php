<?php

require 'vendor/autoload.php';

use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;

include_once('config.php');

// Get API Token
$token = getTokenApi();

// Get DeviceId Sender
$deviceId = getDeviceId();


// Create connection
$conn = mysqlConnection();

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query
$sql = "SELECT `id`, `name`, `phone_number` FROM `contacts` "; // With LIMIT for testing
$result = $conn->query($sql);

// Close connection
closeConnection($conn);

// Configure client API SMS Gateway
$config = Configuration::getDefaultConfiguration();
$config->setSSLVerification(false); // add this line
$config->setApiKey('Authorization', $token);
$apiClient = new ApiClient($config);
$messageClient = new MessageApi($apiClient);


// Iterate result
while ($row = mysqli_fetch_assoc($result)) {
    printf("%s => %s (id : %s)\n", $row["name"], $row["phone_number"], $row["id"]);

    // Object with phone destination + message + deviceId sender
    $sendMessageRequest = new SendMessageRequest([
        'phoneNumber' => $row["phone_number"],

        'message' =>"HELLO FROM SMS",
        'deviceId' => $deviceId
    ]);
print_r($sendMessageRequest);
    // Sending sms ...
    $sendMessages = $messageClient->sendMessages([
        $sendMessageRequest
    ]);

    print_r("SENT\n");

    // Sleep for X seconds for not to be banned
    sleep(200);
}
