<?php
require 'vendor/autoload.php';

use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\TextInput;

function detect_intent_texts($projectId, $sessionId, $text, $languageCode = 'en-US') {
    $credentials = json_decode(file_get_contents('path/to/your-service-account-file.json'), true);

    $sessionsClient = new SessionsClient([
        'credentials' => $credentials
    ]);

    $session = $sessionsClient->sessionName($projectId, $sessionId);
    $textInput = new TextInput();
    $textInput->setText($text);
    $textInput->setLanguageCode($languageCode);

    $queryInput = new QueryInput();
    $queryInput->setText($textInput);

    $response = $sessionsClient->detectIntent($session, $queryInput);
    $queryResult = $response->getQueryResult();
    $fulfillmentText = $queryResult->getFulfillmentText();

    $sessionsClient->close();
    return $fulfillmentText;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $userMessage = $input['message'];
    $projectId = 'your-dialogflow-project-id';
    $sessionId = session_id();

    $botResponse = detect_intent_texts($projectId, $sessionId, $userMessage);
    echo json_encode(['response' => $botResponse]);
}
?>
