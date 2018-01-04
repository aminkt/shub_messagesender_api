<?php
/**
 * @author Amin Keshvarz <amin@keshavarz.pro>
 * @since  2017
 */

OW::getRouter()->addRoute(new OW_Route('restapi.index', 'api', "RESTAPI_CTRL_Api", 'index'));
