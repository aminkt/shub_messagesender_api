<?php

/**
 * Class CONTACTUS_CTRL_Api
 *
 * @author Amin Keshavarz <amin@keshavarz.pro>
 */
class RESTAPI_CTRL_Admin extends ADMIN_CTRL_Abstract
{
    public function index()
    {
        $this->setPageTitle("مدیریت وب سرویس");
        $this->setPageHeading("مدیریت توکن ها");

        $tokensList = array();
        $deleteUrls = array();
        $revokeUrls = array();
        $tokens = RESTAPI_BOL_Service::getInstance()->getTokensList();
        foreach ($tokens as $token) {
            $tokensList[$token->id]['id'] = $token->id;
            $tokensList[$token->id]['name'] = $token->name;
            $tokensList[$token->id]['updateAt'] = $token->updateAt;
            $tokensList[$token->id]['createAt'] = $token->createAt;
            $deleteUrls[$token->id] = OW::getRouter()->urlFor(__CLASS__, 'delete', array('id' => $token->id));
            $revokeUrls[$token->id] = OW::getRouter()->urlFor(__CLASS__, 'revoke', array('id' => $token->id));
        }

        if (OW::getSession()->isKeySet('resapi.admin.token')) {
            $token = OW::getSession()->get('resapi.admin.token');
            OW::getSession()->delete('resapi.admin.token');
            $this->assign('token', $token);
        }

        $this->assign('tokenList', $tokensList);
        $this->assign('deleteUrls', $deleteUrls);
        $this->assign('revokeUrls', $revokeUrls);

        $form = new Form('add_token_form');
        $this->addForm($form);

        $name = new TextField('name');
        $name->setRequired();
        $name->setInvitation("نام سرویس");
        $name->setHasInvitation(true);
        $name->setLabel("نام");
        $form->addElement($name);


        $submit = new Submit('submit');
        $submit->setValue("ایجاد توکن جدید");
        $form->addElement($submit);

        if (OW::getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $data = $form->getValues();
                $token = RESTAPI_BOL_Service::getInstance()->addToken($data['name']);
                OW::getSession()->set('resapi.admin.token', $token);
                $this->redirect();
            }
        }
    }

    public function delete($params)
    {
        if (isset($params['id'])) {
            RESTAPI_BOL_Service::getInstance()->deleteToken((int)$params['id']);
        }
        $this->redirect(OW::getRouter()->urlForRoute('restapi.admin'));
    }

    public function revoke($params)
    {
        if (isset($params['id'])) {
            $token = RESTAPI_BOL_Service::getInstance()->revokeToken((int)$params['id']);
            OW::getSession()->set('resapi.admin.token', $token);
        }
        $this->redirect(OW::getRouter()->urlForRoute('restapi.admin'));
    }
}