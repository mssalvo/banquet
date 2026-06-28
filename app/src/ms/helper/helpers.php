<?php
 

function app()
{
    if(!isset($GLOBALS['app'])) {
      $GLOBALS['app'] = new \Banquet\Core\Container();
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
