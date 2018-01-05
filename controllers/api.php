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
    /** @var  \RESTAPI_CLASS_Request $request */
    private $request;


    /**
     * @inheritdoc
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function init()
    {
        parent::init();

        $this->response = new RESTAPI_CLASS_Response();
        $this->request = new RESTAPI_CLASS_Request();
    }

    /**
     * Send message from api to users in Shub
     *
     * @return array
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function sendMessage()
    {
        if (!RESTAPI_CLASS_Request::isPost()) {
            return $this->response->error(405, "Http method is not correct");
        }

        var_dump($_POST);
        exit;
        $this->request->authentication();

        $username = RESTAPI_CLASS_Request::post('username');
        $message = RESTAPI_CLASS_Request::post('message');

        if (!$username or !$message or !isset($message['text']) or !isset($message['subject'])) {
            return $this->response->error(400, "Inputs is not correct");
        }

        $user = $this->findUserByUsername($username);

        $result = RESTAPI_CLASS_Mailbox::sendMessage(1, $user->id, $message['subject'], $message['text']);

        if ($result) {
            return $this->response->success($result['lastMessageTimestamp']);
        }

        return $this->response->error(500, "Message not send.");
    }

    /**
     * Revoke api token.
     *
     * @return array
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    public function revokeToken()
    {
        if (!RESTAPI_CLASS_Request::isPost()) {
            return $this->response->error(405, "Http method is not correct");
        }

        $tokenModel = $this->request->authentication();
        $token = RESTAPI_BOL_Service::getInstance()->revokeToken((int)$tokenModel->id);
        return $this->response->success([
            'token' => $token,
        ]);
    }


    /**
     * Find user by user name.
     *
     * @param $username
     *
     * @return array
     *
     * @author Amin Keshavarz <amin@keshavarz.pro>
     */
    private function findUserByUsername($username)
    {
        $user = BOL_UserService::findByUsername($username);
        if (!$user) {
            return $this->response->error(404, "User not found");
        }
        return $user;
    }
}