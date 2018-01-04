<?php

class RESTAPI_BOL_TokenDao extends OW_BaseDao
{
    /**
     * Singleton instance.
     *
     * @var CONTACTUS_BOL_DepartmentDao
     */
    private static $classInstance;

    /**
     * Constructor.
     *
     */
    protected function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns an instance of class (singleton pattern implementation).
     *
     * @return CONTACTUS_BOL_DepartmentDao
     */
    public static function getInstance()
    {
        if (self::$classInstance === null) {
            self::$classInstance = new self();
        }

        return self::$classInstance;
    }

    /**
     * @see OW_BaseDao::getDtoClassName()
     *
     */
    public function getDtoClassName()
    {
        return 'RESTAPI_BOL_Token';
    }

    /**
     * @see OW_BaseDao::getTableName()
     *
     */
    public function getTableName()
    {
        return OW_DB_PREFIX . 'restapi_tokens';
    }
}