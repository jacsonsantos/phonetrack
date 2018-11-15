<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 13/11/18
 * Time: 00:02
 */

namespace App\Src\Http\HttpRequest;

class Request
{
    private $fields;

    public static function singleton()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Request();
        }
        return $inst;
    }

    function __construct()
    {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf()
    {
        foreach($_SERVER as $key => $value)
        {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    private function toCamelCase($string)
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach($matches[0] as $match)
        {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }
        return $result;
    }

    public function all()
    {
        return $this->getBody();
    }

    public function get($name)
    {
        $this->getBody();
        return $this->fields[$name];
    }

    public function has($name)
    {
        $this->getBody();
        return in_array($name,$this->fields);
    }

    public function put($name, $value)
    {
        $this->fields[$name] = $value;
    }

    public function is_ajax()
    {
        return isset($this->httpXRequestedWtih) && strtolower($this->httpXRequestedWtih) == 'xmlhttprequest';
    }

    /**
     * @param $body
     * @return mixed
     */
    private function getBody($body = [])
    {
        if ($this->requestMethod === "GET") {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->requestMethod == "POST") {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $this->fields = $body;
    }
}