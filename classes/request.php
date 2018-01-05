<?php

/**
 * Class RESTAPI_CLASS_Request
 *
 * @author Amin Keshavarz <amin@keshavarz.pro>
 */
class RESTAPI_CLASS_Request
{
    public $token;

    /**
     * Return post request
     *
     * @param string|null $key
     * @param mixed       $defaultValue
     *
     * @return null|mixed
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public static function post($key = null, $defaultValue = null)
    {
        if (!$key) {
            return $_POST;
        }

        if (!isset($_POST[$key])) {
            return $defaultValue;
        }

        return $_POST[$key];
    }

    /**
     * Check if request method is post or not.
     *
     * @return bool
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public static function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Check if request method is get or not.
     *
     * @return bool
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public static function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * Check your access by prepared token.
     *
     * @return array|\RESTAPI_BOL_Token
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function authentication()
    {
        $response = new RESTAPI_CLASS_Response();
        $headers = apache_request_headers();
        if (!isset($headers['Authorization'])) {
            return $response->error(401, "Token is not exist.");
        }

        $auth = explode(' ', $headers['Authorization']);
        if ($model = RESTAPI_BOL_Service::getInstance()->checkToken($auth[1])) {
            $this->token = $auth[1];
            return $model;
        } else {
            return $response->error(401, "Your access denied.");
        }
    }
}