<?php
 

function app()
{
    if(!isset($GLOBALS['app'])) {
      $GLOBALS['app'] = new \Banquet\Ms\Core\Container();
    }
    return $GLOBALS['app'];

}

/**
 * @throws Exception
 */
function resolve($class)
{
    return app()->get($class);
}


function e($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function resolveUrl($value)
{
    return htmlspecialchars(FOLDER_HOME . $value, ENT_QUOTES, 'UTF-8');
}

function slugify($text)
{
    $text = preg_replace('/[^a-zA-Z0-9]/', '-', $text);
    $text = strtolower($text);
    return trim($text, '-');
}

function csrf_token()
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf'];
}

function security_getClick()
{

    $tempo_limite = 15 * 60; // 15 minuti in secondi (900)

    
    if (!isset($_SESSION['_secutity_message']) || (time() - $_SESSION['_secutity_message']['_time']) > $tempo_limite) {
        $_SESSION['_secutity_message'] = [];
        $_SESSION['_secutity_message']['_count'] = 1;
        $_SESSION['_secutity_message']['_time'] = time();
    } else {
        
        $_SESSION['_secutity_message']['_count']++;
    }

    return $_SESSION['_secutity_message']['_count'];
}

function validate($data, $rules)
{
    $errors = [];

    foreach ($rules as $field => $rule) {

        if ($rule === 'required' && empty($data[$field])) {
            $errors[] = "$field obbligatorio";
        }
    }

    return $errors;
}

function redirect($url)
{
    header("Location: $url");
    exit;
}

function call_user_class_method($callable, ...$params) {
    return $callable(...$params);
}

function user()
{
    return $_SESSION['user_id'] ?? null;
}

function bodyJson(){
    return json_decode(file_get_contents('php://input'), true);
}

function sanitizePost($param,$filter_sanitize=FILTER_SANITIZE_SPECIAL_CHARS){
    return filter_input(INPUT_POST, $param, $filter_sanitize);
}

function sanitizeGet($param,$filter_sanitize=FILTER_SANITIZE_SPECIAL_CHARS){
    return filter_input(INPUT_GET, $param, $filter_sanitize);
}

function sanitizeVar($dato,$filter_sanitize=FILTER_SANITIZE_SPECIAL_CHARS){
    return filter_var($dato, $filter_sanitize);
}

function generateUrl($pattern, $params)
{
    foreach ($params as $key => $value) {
        $pattern = str_replace("{" . $key . "}", $value, $pattern);
    }
    return $pattern;
}
/*
echo generateUrl('/corso/{slug}-{id}', [
    'slug' => 'calcio-base',
    'id'   => 25
]);
*/
