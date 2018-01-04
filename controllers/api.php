<?php

/**
 * Class CONTACTUS_CTRL_Api
 *
 * @author Amin Keshavarz <amin@keshavarz.pro>
 */
class RESTAPI_CTRL_Api extends OW_ActionController
{
    /** @var  \RESTAPI_CLASS_Response $response */
    private $response;


    /**
     * @inheritdoc
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function init()
    {
        parent::init();

        $this->response = new RESTAPI_CLASS_Response();
    }

    public function index()
    {
        $this->setPageTitle("Contact Us");
        $this->setPageHeading("Contact Us");
        echo "sdfksmdfsf";
    }

    public function revokeToken()
    {
        $response = [
            'lastToken' => 'asd5asfas5f2f5f2f525af2a5f',
            'newToken' => 'ascasf562av61a2v56a2v52v5avd5av',
            'isAjax' => OW::getRequest()->isAjax()
        ];

        $this->response->setStatusCode(400)->setData($response)->setMessage("Revoke access token")->render();
    }
}