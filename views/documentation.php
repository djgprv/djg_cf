<?php

/**
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/**
	* The djg_cf plugin
	* @author Michał Uchnast <djgprv@gmail.com>,
	* @copyright kreacjawww.pl
	* @license http://www.gnu.org/licenses/gpl.html GPLv3 license
	* components used: jQuery Validation Plugin 1.9.0 - http://bassistance.de/jquery-plugins/jquery-plugin-validation/
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
</ul>


<p><strong>Translations</strong></p>
<ul style="list-style: square inside none;">
<li>Russian translation by Konstantin Baev &lt;konstantin.baev@gmail.com&gt;</li>
</ul>

<p><strong>If You have problem send me mail: djgprv@gmail.com</strong></p>