<?php

$sql = "DROP TABLE IF EXISTS `" . OW_DB_PREFIX . "restapi_tokens`";

OW::getDbo()->query($sql);