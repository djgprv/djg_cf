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
*/

Plugin::setInfos(array(
    'id'			=> 'djg_cf',
    'title'			=> __('[djg] Contact form'),
    'description'	=> __('Ajax contact form'),
    'version'		=> '1.1.2',
   	'license'		=> 'GPL',
	'author'		=>	'Michał Uchnast',
	'website'		=>	'http://www.kreacjawww.pl/',
    'update_url'	=> 'http://kreacjawww.pl/public/wolf_plugins/plugin-versions.xml',
    'require_wolf_version' => '0.7.3',
	'type'			=> 'both'
));
	Plugin::addController('djg_cf', __('[djg] Contact form'), 'administrator', false);
	Dispatcher::addRoute(array(
	'/djg_cf_send_email.php' => '/plugin/djg_cf/djg_cf_send_email',
	'/djg_cf_sesja.php' => '/plugin/djg_cf/sesja'
));

function djg_cf()
{
	?><script type="text/javascript" src="<?php echo URL_PUBLIC; ?>wolf/plugins/djg_cf/js/jquery.validate.js"></script><?php
	$emailAdress = Plugin::getSetting('emailAdress', 'djg_cf');
	$subjectPrefix = Plugin::getSetting('subjectPrefix', 'djg_cf');
	$subjects = explode("#",Plugin::getSetting('subjects', 'djg_cf'));
	$appendCss = Plugin::getSetting('appendCss', 'djg_cf');
	$subject = Plugin::getSetting('subject', 'djg_cf');
	$captcha = Plugin::getSetting('captcha', 'djg_cf');
	?>
	<script type="text/javascript">
	$(document).ready(function() {
		<?php if($appendCss): ?> //appendexample fronted css to head on init
		$('<link rel="stylesheet" type="text/css" href="<?php echo URL_PUBLIC; ?>wolf/plugins/djg_cf/css/djg_cf_fronted.css" />').appendTo('head');
		<?php endif; ?>
		$('#djg_cf').show();
		$('#djg_cf_jq_test').hide();
		$('#djg_cf_captchaimage').attr("src", "<?php echo rtrim(URL_PUBLIC,'/').(USE_MOD_REWRITE ? '/': '/?/'); ?>wolf/plugins/djg_cf/captcha/image.php?" + new Date().getTime());
		$('#djg_cf_captchaimage').click(function() {$(this).attr("src", "<?php echo rtrim(URL_PUBLIC,'/').(USE_MOD_REWRITE ? '/': '/?/'); ?>wolf/plugins/djg_cf/captcha/image.php?" + new Date().getTime());});
		$("#djg_cf").validate({
			submitHandler: function() {
				var $form = $('#djg_cf');
				var data = $form.serialize();
				$.ajax({//type: "GET",
					data: data,
					dataType: "json", 
					cache: true, 
					url: '<?php echo rtrim(URL_PUBLIC,'/').(USE_MOD_REWRITE ? '/': '/?/'); ?>djg_cf_send_email.php', 
					timeout: 1000,
					contentType: "application/json; charset=utf-8", 
					beforeSend: function() { $('button').hide(); },
					error: function() { 
						$('.mail_fail').show();$('.mail_success').hide();$('button').show();
					}, 
					success: function(data) {
						if(data.error==0)
						{
							$('.mail_success').show();$('.mail_fail').hide();$('button').hide();
						}else{
							$('.mail_fail').show();$('.mail_success').hide();$('button').show();
						}
					},
					complete: function() { $("#preloader").hide();}
				});		
			},
			errorLabelContainer: ".djg_cf_messageBox",
			wrapper: "li",
			rules: {
					name: {required: true},
					email: {required: true, email:true},
					subject: {required: true},
					message: {required: true},
					captcha: {required: true, remote: '<?php echo rtrim(URL_PUBLIC,'/').(USE_MOD_REWRITE ? '/': '/?/'); ?>djg_cf_sesja.php'}		
				},
				messages: {
					name: "<?php echo __('I don\'t talk to strangers.');?>",
					email: "<?php echo __('You don\'t want me to answer?');?>",
					subject: "<?php echo __('What is the purpose of the contact?');?>",
					message: "<?php echo __('Forgot why you came here?');?>",
					captcha: "<?php echo __('Issue required.');?>"
					
				}
			});
	});
	</script>
	<div class="djg_cf_messageBox"></div>
	<form id="djg_cf" style="display:none;" method="post" action="#">
	<fieldset>
	<!-- name -->
	<label for="name"><?php echo __('Your Name:'); ?></label>
	<input id="name" type="text" name="name" tabindex="1" value="" autocomplete="off" title="<?php echo __('Your Name:'); ?>" />
	<!-- mail -->
	<label for="email"><?php echo __('Your Email:'); ?></label>
	<input id="email" type="text" name="email" tabindex="2" value="" autocomplete="off" title="<?php echo __('Your Email:'); ?>" />
	<!-- subjects -->
	<label for="subject"><?php echo __('The Subject:'); ?></label>
	<select name="subject" id="subject">
	<?php
	array_unshift($subjects, __('Select a subject'));
	foreach ($subjects as $subject_id => $subject_value):
      $selected = ($subject_id == $subject_value) ? ' selected="selected"' : '';
      echo '<option value="' . $subject_id . '"' . $selected . '>' . $subject_value . '</option>' . PHP_EOL;
    endforeach;
    ?>
	</select>
	<label for="message"><?php echo __('The Message:'); ?></label>
	<textarea id="message" tabindex="4" rows="4" cols="10" name="message"></textarea>
    <?php /* captcha */ 
	if($captcha == 1): ?>
	<label for="captcha"><?php echo __('The Captcha:'); ?></label>
	<input id="captcha" class="captcha" type="text" autocomplete="off"  tabindex="5" maxlength="6" name="captcha" />
	<img id="djg_cf_captchaimage" src="" alt="<?php echo __('captcha image'); ?>" title="<?php echo __('captcha image'); ?>" width="80" height="30" />
	<?php endif; ?>
	<label for="submit" style="clear: both;" ></label>
	<button type="submit" name="submit"><?php echo __('Send The Message'); ?></button>
	</fieldset>
	<div style="display:none;" class="mail_success msg_success"><?php echo __('Thank you. The mailman is on his way.'); ?></div>
	<div style="display:none;" class="mail_fail msg_error"><?php echo __('Sorry, don\'t know what happened. Try later.'); ?></div>
	</form>	
	<div id="djg_cf_jq_test" class="msg_error"><?php echo __('Probability JavaScript is disabled or You have not jQuery library.'); ?></div>

<?php } // end function ?>
