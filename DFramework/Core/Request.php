<?php
namespace DF\Core;

class Request
{
    /**
     * @var array
     */
    private $params;
    private $type;
    private static $needToChangeCsrf = false;

    const TYPE_GET = 'GET';
    const TYPE_PUT = 'PUT';
    const TYPE_POST = 'POST';
    const TYPE_DELETE = 'DELETE';
    const TYPE_STANDARD = 'GET|POST';

    public function __construct($params, $type = self::TYPE_GET)
    {
        $this->params = $params;
        $this->type = $type;
    }

    public static function handle()
    {
        $type = $_SERVER['REQUEST_METHOD'];
        $params = [];

        if(in_array($type, [self::TYPE_POST, self::TYPE_STANDARD, self::TYPE_PUT])) {
            foreach($_POST as $key => $value) {
                $params[$key] = $value;
            }

            self::$needToChangeCsrf = true;
        }

        return new Request($params, $type);
    }

    public function getType()
    {

        return $this->type;
    }

    public static function needToChangeCsrf()
    {
        return self::$needToChangeCsrf;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getParam($param)
    {
        return $this->params[$param];
    }
}