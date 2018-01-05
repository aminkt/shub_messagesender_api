<?php

class RESTAPI_BOL_Service
{
    /**
     * Singleton instance.
     *
     * @var RESTAPI_BOL_Service
     */
    private static $classInstance;

    private function __construct()
    {

    }

    /**
     * Returns an instance of class (singleton pattern implementation).
     *
     * @return RESTAPI_BOL_Service
     */
    public static function getInstance()
    {
        if (self::$classInstance === null) {
            self::$classInstance = new self();
        }

        return self::$classInstance;
    }

    /**
     * Save token into database.
     *
     * @param string $name Token name.
     *
     * @return string   Token value.
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function addToken($name)
    {
        $token = new RESTAPI_BOL_Token();
        $token->name = $name;
        $randomToken = sha1(md5("0ek" . time() . "g7X9" . rand(0, 999) . "68S"));
        $token->token = $randomToken;
        $token->updateAt = date("Y-m-d H:i:s");
        $token->createAt = date("Y-m-d H:i:s");
        RESTAPI_BOL_TokenDao::getInstance()->save($token);
        return $token->token;
    }

    /**
     * Delete token from database by id.
     *
     * @param integer $id
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function deleteToken($id)
    {
        $id = (int)$id;
        if ($id > 0) {
            RESTAPI_BOL_TokenDao::getInstance()->deleteById($id);
        }
    }

    /**
     * Revoke token from database by id.
     *
     * @param integer $id
     *
     * @return null|string
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function revokeToken($id)
    {
        $id = (int)$id;
        if ($id > 0) {
            /** @var \RESTAPI_BOL_Token $token */
            $token = RESTAPI_BOL_TokenDao::getInstance()->findById($id);
            $randomToken = sha1(md5("0ek" . time() . "g7X9" . rand(0, 999) . "68S"));
            $token->token = $randomToken;
            $token->updateAt = date("Y-m-d H:i:s");
            RESTAPI_BOL_TokenDao::getInstance()->save($token);
            return $token->token;
        }
        return null;
    }

    /**
     * Return tokens models.
     *
     * @return \RESTAPI_BOL_Token[]
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function getTokensList()
    {
        return RESTAPI_BOL_TokenDao::getInstance()->findAll();
    }

    /**
     * Check token that is valid or not.
     *
     * @return boolean|RESTAPI_BOL_Token
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function checkToken($token)
    {
        $ex = new OW_Example();
        $ex->andFieldEqual('token', $token);
        $model = RESTAPI_BOL_TokenDao::getInstance()->findListByExample($ex);

        if ($model) {
            return $model[0];
        }

        return false;
    }
}