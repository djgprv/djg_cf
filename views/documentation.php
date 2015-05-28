<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008-2010 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

/**
 *
 * Note: to use the settings and documentation pages, you will first need to enable
 * the plugin!
 *
 * @package Plugins
 * @subpackage djg_i18n_generator
 *
 * @author Michał Uchnast <djgprv@gmail.com>,
 * @copyright kreacjawww.pl
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
?>
<h1><?php echo __('Djg Contact Form Documentation'); ?></h1>
<p>Djg Contact Form is very easy and usefull component. Contact form that works without having to reload the page. It works based on jquery and ajax.</p>
<p><strong>Instalation</strong></p>
<ol style="list-style: decimal inside none;">
<li>Enter the admin page installation and activate the plugin.</li>
<li>Insert in page content: <br /><code><span style="color:red;">&lt;?php</span> if (Plugin::isEnabled('djg_cf'))djg_cf(); <span style="color:red;">?&gt;</span></code></li>
<li>Required - <i style="color:red;">jQuery in fronted</i><br /><code>&lt;script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"&gt;&lt;/script&gt;</code></li>
</ol>

<p><strong>History version</strong></p>
<ul style="list-style: square inside none;">
<li>1.0.2 - first official - wolf 0.6.x</li>
<li>1.0.3 - add russion translation (thanks for Konstantin Baev)</li>
<li>1.0.4 - add antyspam filter, add uninstall script - wolf 0.7.3 only</li>
<li>1.1.0 - new validate (jQuery Validation Plugin 1.9.0), captcha refresh on click, form W3C Validate, add update_urll</li>
<li>1.1.1 - automatic append css to head in fronted, cleanurl and ? compatible</li>
<li>1.1.3 - subject as value not subject id (thanks for David)</li>
</ul>

<p><strong>Translations</strong></p>
<ul style="list-style: square inside none;">
<li>Russian translation by Konstantin Baev &lt;konstantin.baev@gmail.com&gt;</li>
</ul>

<p><strong>If You have problem send me mail: djgprv@gmail.com</strong></p>