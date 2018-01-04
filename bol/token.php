<?php

/**
 * Class RESTAPI_BOL_Token
 *
 * @property integer $id
 *
 * @author Amin Keshavarz <amin@keshavarz.pro>
 */
class RESTAPI_BOL_Token extends OW_Entity
{
    /** @property string $email */
    public $name;

    /** @property string $token */
    public $token;

    /** @property string $updateAt */
    public $updateAt;

    /** @property string $createAt */
    public $createAt;
}