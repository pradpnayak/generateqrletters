-- +--------------------------------------------------------------------+
-- | Copyright CiviCRM LLC. All rights reserved.                        |
-- |                                                                    |
-- | This work is published under the GNU AGPLv3 license with some      |
-- | permitted exceptions and without any warranty. For full license    |
-- | and copyright information, see https://civicrm.org/licensing       |
-- +--------------------------------------------------------------------+
--
-- Generated from schema.tpl
-- DO NOT EDIT.  Generated by CRM_Core_CodeGen
--
-- /*******************************************************
-- *
-- * Clean up the existing tables - this section generated from drop.tpl
-- *
-- *******************************************************/

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `civicrm_qr_letters_cache`;

SET FOREIGN_KEY_CHECKS=1;
-- /*******************************************************
-- *
-- * Create new tables
-- *
-- *******************************************************/

-- /*******************************************************
-- *
-- * civicrm_qr_letters_cache
-- *
-- * Generate QR Letters Cache
-- *
-- *******************************************************/
CREATE TABLE IF NOT EXISTS `civicrm_qr_letters_cache` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique Generate QR Letters Cache ID',
  `form_values` longtext COMMENT 'Submitted form values for this template',
  `html_message` longtext COMMENT 'html_message',
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
