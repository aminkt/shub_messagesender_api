<?php
/**
 * @author Amin Keshvarz <amin@keshavarz.pro>
 * @since  2017
 */

OW::getRouter()->addRoute(new OW_Route('restapi.index', 'rest/api/v1', "RESTAPI_CTRL_Api", 'index'));
OW::getRouter()->addRoute(new OW_Route('restapi.token.revoke', 'rest/api/v1/token/revoke.json', "RESTAPI_CTRL_Api", 'revokeToken'));


/**
 * Admin panel links
 */
OW::getRouter()->addRoute(new OW_Route('restapi.admin', 'admin/plugins/restapi', "RESTAPI_CTRL_Admin", 'index'));