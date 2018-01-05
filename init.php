<?php
/**
 * @author Amin Keshvarz <amin@keshavarz.pro>
 * @since  2017
 */

OW::getRouter()->addRoute(new OW_Route('restapi.token.revoke', 'rest/api/v1/token/revoke.json', "RESTAPI_CTRL_Api", 'revokeToken'));
OW::getRouter()->addRoute(new OW_Route('restapi.sendMessage', 'rest/api/v1/sendMessage.json', "RESTAPI_CTRL_Api", 'sendMessage'));


/**
 * Admin panel links
 */
OW::getRouter()->addRoute(new OW_Route('restapi.admin', 'admin/plugins/restapi', "RESTAPI_CTRL_Admin", 'index'));