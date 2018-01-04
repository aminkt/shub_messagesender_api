<?php

/**
 * Class RESTAPI_CLASS_Response
 * Handle rest api responses.
 *
 * @author Amin Keshavarz <amin@keshavarz.pro>
 */
class RESTAPI_CLASS_Response
{
    /** @var array $httpStatuses HTTP Rsponse statuses. */
    public static $httpStatuses = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        118 => 'Connection timed out',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        210 => 'Content Different',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        310 => 'Too many Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested range unsatisfiable',
        417 => 'Expectation failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable entity',
        423 => 'Locked',
        424 => 'Method failure',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        449 => 'Retry With',
        450 => 'Blocked by Windows Parental Controls',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway or Proxy Error',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        507 => 'Insufficient storage',
        508 => 'Loop Detected',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];
    public $data;
    public $statusCode;
    public $message;

    /**
     * Set response message
     *
     * @param string $message Response message.
     *
     * @return self
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Return error to user.
     *
     * @param integer $code    Error code.
     * @param string  $message Error message.
     *
     * @return array
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function error($code, $message)
    {
        $this->setStatusCode($code);
        $this->message = $message;
        return $this->render();
    }

    /**
     * Set response status code.
     *
     * @param integer $code
     *
     * @return self
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        return $this;
    }

    /**
     * Render response for user.
     *
     * @return array    Json encoded.
     *
     * @author   Amin Keshavarz <amin@keshavarz.pro>
     */
    public function render()
    {
        $res = [];
        $res['status'] = self::getStatusMessage($this->statusCode);
        $res['code'] = $this->statusCode;
        if ($this->data) {
            $res['data'] = $this->data;
        }
        if ($this->message) {
            $res['message'] = $this->message;
        }

        $this->prepareHeaders();
        echo json_encode($res);
        exit;
    }

    /**
     * Return status message.
     *
     * @param integer $code
     *
     * @return string
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public static function getStatusMessage($code)
    {
        if (key_exists($code, self::$httpStatuses)) {
            return self::$httpStatuses[$code];
        } else {
            return "Unknown status";
        }
    }

    /**
     * Set http requests headers.
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function prepareHeaders()
    {
        header("Content-Type: application/json");

        $sapi_type = php_sapi_name();
        $status = $this->statusCode . " " . self::getStatusMessage($this->statusCode);
        if (substr($sapi_type, 0, 3) == 'cgi')
            header("Status: $status");
        else
            header("HTTP/1.1 $status");
    }

    /**
     * Return success response to user.
     *
     * @param array $data Data section of response.
     *
     * @return array
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function success($data)
    {
        $this->setStatusCode(200);
        $this->setData($data);
        return $this->render();
    }

    /**
     * Set data into response
     *
     * @param array $data Data section of output
     *
     * @return self
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function setData($data)
    {
        if (!is_array($data)) {
            throw new InvalidArgumentException("Param data should be in array");
        }
        $this->data = $data;
        return $this;
    }


}