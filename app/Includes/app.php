<?

require_once "../../vendor/autoload.php";

use App\Utils\View;
use App\Utils\Url;
use App\Utils\Environment;

Environment::load();

// echo getenv('DB_CONNECTION');
// die;

$url = new Url();

define('URL', $url->getUrl());

View::init([
    'URL' => URL
]);
