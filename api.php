<?php
/**
 * Funzioni per l'interazione con l'API Open Trivia Database
 * 
 * @package API
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.0.0
 * @link https://opentdb.com/api_config.php
 */

/**
 * Ottiene le categorie di quiz dall'API Open Trivia Database
 * 
 * @return array Array associativo di categorie (id => nome) ordinate per nome
 * @throws RuntimeException Se la richiesta API fallisce
 */
function ottieniCategorieAPI() {
    $api_url = 'https://opentdb.com/api_category.php';
    
    $options = [
        'http' => [
            'method' => 'GET',
            'timeout' => 5,
            'header' => "Accept-language: en\r\n"
        ]
    ];
    
    $context = stream_context_create($options);
    $response = @file_get_contents($api_url, false, $context);
    
    if ($response === false) {
        error_log("Failed to fetch categories from OTDB API");
        return [
            9 => 'General Knowledge',
            10 => 'Entertainment: Books',
            11 => 'Entertainment: Film',
            12 => 'Entertainment: Music',
            14 => 'Entertainment: Television',
            15 => 'Entertainment: Video Games',
            17 => 'Science & Nature',
            18 => 'Science: Computers',
            19 => 'Science: Mathematics',
            20 => 'Mythology',
            21 => 'Sports',
            22 => 'Geography',
            23 => 'History',
            24 => 'Politics',
            25 => 'Art',
            26 => 'Celebrities',
            27 => 'Animals',
            28 => 'Vehicles',
            29 => 'Entertainment: Comics',
            30 => 'Science: Gadgets',
            31 => 'Entertainment: Japanese Anime & Manga',
            32 => 'Entertainment: Cartoon & Animations'
        ];
    }
    
    $data = json_decode($response, true);
    
    if (!$data || !isset($data['trivia_categories'])) {
        error_log("Invalid categories API response");
        return [
            9 => 'General Knowledge',
            10 => 'Entertainment: Books',
            11 => 'Entertainment: Film',
            12 => 'Entertainment: Music',
            14 => 'Entertainment: Television',
            15 => 'Entertainment: Video Games',
            17 => 'Science & Nature',
            18 => 'Science: Computers',
            19 => 'Science: Mathematics',
            20 => 'Mythology',
            21 => 'Sports',
            22 => 'Geography',
            23 => 'History',
            24 => 'Politics',
            25 => 'Art',
            26 => 'Celebrities',
            27 => 'Animals',
            28 => 'Vehicles',
            29 => 'Entertainment: Comics',
            30 => 'Science: Gadgets',
            31 => 'Entertainment: Japanese Anime & Manga',
            32 => 'Entertainment: Cartoon & Animations'
        ];
    }
    
    $categories = [];
    foreach ($data['trivia_categories'] as $category) {
        $categories[$category['id']] = $category['name'];
    }

    asort($categories);
    
    return $categories;
}

/**
 * Ottiene un singolo enigma dall'API Open Trivia Database
 * 
 * @param int|null $category ID della categoria (opzionale)
 * @return array|null Dati dell'enigma o null in caso di errore
 * @throws InvalidArgumentException Se il parametro category non è valido
 */
function ottieniEnigmaAPI($category = null) {
    $api_url = 'https://opentdb.com/api.php?amount=1&type=multiple&encode=url3986';
    
    if ($category && is_numeric($category)) {
        $api_url .= "&category=$category";
    }
    
    $options = [
        'http' => [
            'method' => 'GET',
            'timeout' => 5,
            'header' => "Accept-language: en\r\n"
        ]
    ];
    
    $context = stream_context_create($options);
    $response = @file_get_contents($api_url, false, $context);
    
    if ($response === false) {
        error_log("Failed to fetch from OTDB API");
        return null;
    }
    
    $data = json_decode($response, true);
    
    if (!$data || $data['response_code'] !== 0 || empty($data['results'])) {
        error_log("Invalid API response: " . print_r($data, true));
        return null;
    }
    
    // Decodifica i valori URL-encoded
    $result = $data['results'][0];
    $decoded = [];
    
    foreach ($result as $key => $value) {
        if (is_array($value)) {
            $decoded[$key] = array_map('urldecode', $value);
        } else {
            $decoded[$key] = urldecode($value);
        }
    }
    
    return $decoded;
}
?>