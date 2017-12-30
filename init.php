<?php
/**
 * @author Amin Keshvarz <amin@keshavarz.pro>
 * @since  2017
 */

OW::getRouter()->addRoute(new OW_Route('pvApi.index', 'api', "API_MESSAGE_TO_USERS_PV_CTRL_Api", 'index'));