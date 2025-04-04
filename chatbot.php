<?php  
$envPath = __DIR__ . '/.env';

$envContent = file_get_contents($envPath);
if (preg_match('/^API_KEY\s*=\s*(.+)$/m', $envContent, $matches)) {
    $api_key = trim($matches[1]); 
} else {
    die(json_encode(['error' => 'API key not found in .env file']));
}

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$api_key";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);

if (!$input || !isset($input['message'])) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

// Trim the user's messaged
$user_message = trim($input['message']);

// Define the AI's role or context
$ai_role = "Você é um assistente de IA chamado AstraAI que ajuda os usuários na sua superaçao e recuperaçao contra os vícios.
 Forneça respostas claras, com carisma, concisas e úteis. Sempre tentando ajudar na estimulaçao da dopamina sem os vicios.
 Caso a pessoa tenha vícios, você deverá fornecer respostas que ajudem a superação do vício.
 Sem citar que vai elevar a autoestima da pessoa.";

// Combine the AI role with the user's message
$prompt = $ai_role . "\n\nUser: " . $user_message;

$data = [
    "contents" => [
        [
            "parts" => [
                ['text' => $prompt]
            ]
        ]
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    echo json_encode(['error' => 'Google Gemini API error']);
    exit;
}

$response_data = json_decode($response, true);

if (!isset($response_data['candidates'][0]['content']['parts'][0]['text'])) {
    echo json_encode(['error' => 'Unexpected API response format']);
    exit;
}

$ai_response = trim($response_data['candidates'][0]['content']['parts'][0]['text']);
echo json_encode(['response' => $ai_response]);