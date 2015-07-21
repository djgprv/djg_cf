<?php defined('IN_CMS') || exit();
if (Plugin::deleteAllSettings('djg_cf'))
    Flash::set('success', __('[djg] Contact form') . ' - ' . __('uninstalled.'));
else
    Flash::set('error', __('[djg] Contact form') . ' - ' . __('unable to remove stored settings!'));