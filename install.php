<?php
/**
 * @author Amin Keshvarz <amin@keshavarz.pro>
 * @since 2017
 */
BOL_LanguageService::getInstance()->addPrefix('restapi', 'وب سرویس ارسال پیام به کاربران');

$sql = "DROP TABLE IF EXISTS `" . OW_DB_PREFIX . "restapi_tokens`";
OW::getDbo()->query($sql);

$sql = "
CREATE TABLE `" . OW_DB_PREFIX . "restapi_tokens` (
  `id` int(11) NOT NULL,
  `name` varchar(191) CHARACTER SET ucs2 COLLATE ucs2_roman_ci NOT NULL,
  `token` varchar(191) NOT NULL,
  `updateAt` datetime,
  `createAt` datetime
) ENGINE=MyISAM DEFAULT CHARSET=utf16;

ALTER TABLE `" . OW_DB_PREFIX . "restapi_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique` (`token`);

ALTER TABLE `" . OW_DB_PREFIX . "restapi_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
";

OW::getDbo()->query($sql);