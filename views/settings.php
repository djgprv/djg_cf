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

 * @author Micha³ Uchnast <djgprv@gmail.com>,
 * @copyright kreacjawww.pl
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
 
?>
<h1><?php echo __('Settings'); ?></h1>
<form action="<?php echo get_url('plugin/djg_cf/save'); ?>" method="post">
    <fieldset style="padding: 0.5em;">
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="label"><label for="email"><?php echo __('E-mail adress'); ?>: </label></td>
                <td class="field">
				<input type="text" id="email" name="settings[emailAdress]" value="<?php echo $settings['emailAdress']; ?>"/>
				</td>
                <td class="help"><?php echo __('Your e-mail adress'); ?></td>
            </tr>
            <tr>
                <td class="label"><label for="prefix"><?php echo __('Subject prefix'); ?>: </label></td>
                <td class="field">
				<input type="text" id="prefix" name="settings[subjectPrefix]" value="<?php echo $settings['subjectPrefix']; ?>"/>
				</td>
                <td class="help"><?php echo __('Subject prefix <br />for example: <strong>"Message frow www, topic: "</strong>'); ?></td>
            </tr>
			<tr>
                <td class="label"><label for="appendCss"><?php echo __('Auto append css'); ?>: </label></td>
                <td class="field">
					<select id="append" name="settings[appendCss]">
						<option value="1" <?php if($settings['appendCss'] == "1") echo 'selected="selected"' ?>><?php echo __('Yes'); ?></option>
						<option value="0" <?php if($settings['appendCss'] == "0") echo 'selected="selected"' ?>><?php echo __('No'); ?></option>
					</select>	
				</td>
				 <td class="help"><?php echo __('Choose yes if you want to automatically append <br />example css file to <strong>HEAD</strong> after init.<br /><code>:fl</code>',array(':fl'=>PLUGINS_URI.'djg_cf'.DS.'css'.DS.'djg_cf_fronted.css')); ?></td>
			</tr>
			<tr>
                <td class="label"><label for="captcha"><?php echo __('Use captcha'); ?>: </label></td>
                <td class="field">
					<select id="captcha" name="settings[captcha]">
						<option value="1" <?php if($settings['captcha'] == "1") echo 'selected="selected"' ?>><?php echo __('Yes'); ?></option>
						<option value="0" <?php if($settings['captcha'] == "0") echo 'selected="selected"' ?>><?php echo __('No'); ?></option>
					</select>	
				</td>
				 <td class="help"><?php echo __('Choose yes if you want to use a captcha to protect yourself against spammers.'); ?></td>
			</tr>
			<tr>
                <td class="label"><label for="subject"><?php echo __('Use subject'); ?>: </label></td>
                <td class="field">
					<select id="subject" name="settings[subject]">
						<option value="1" <?php if($settings['subject'] == "1") echo 'selected="selected"' ?>><?php echo __('Yes'); ?></option>
						<option value="0" <?php if($settings['subject'] == "0") echo 'selected="selected"' ?>><?php echo __('No'); ?></option>
					</select>	
				</td>
				 <td class="help"><?php echo __('Choose yes if you want to use a subjects in your form.'); ?></td>
			</tr>
            <tr class="subjects_area">
                <td class="label">
					<?php echo __('Subjects'); ?>
					<a href="#" class="add_topic"><img src="<?php echo URL_PUBLIC; ?>wolf/plugins/djg_cf/images/16_add.png" alt="<?php echo __('add subject'); ?>" title="<?php echo __('add subject'); ?>" /></a>
				</td>
                <td class="field">
				<ul class="project_images">
				<?php $arr = explode('#',$subjects); ?>
				<?php foreach ($arr as &$value) : ?>
				<li><input name="subjects[]" type="text" value="<?php echo $value; ?>" />
                <a href="#" class="remove_topic">
				<img src="<?php echo URL_PUBLIC; ?>wolf/plugins/djg_cf/images/16_remove.png" alt="<?php echo __('remove subject'); ?>" title="<?php echo __('remove subject'); ?>" /></a>
                </li>
				<?php endforeach; ?>
				</ul>
				</td>
                <td class="help"><?php echo __('List of all avalible subjects of message. <br />Blanks inputs will be skipped.'); ?></td>
            </tr>
        </table>
    </fieldset>
    <br/>
    <p class="buttons">
        <input class="button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save'); ?>" />
    </p>
</form>
<script type="text/javascript">
// <![CDATA[
    function setConfirmUnload(on, msg) {
        window.onbeforeunload = (on) ? unloadMessage : null;
        return true;
    }

    function unloadMessage() {
        return '<?php echo __('You have modified this page.  If you navigate away from this page without first saving your data, the changes will be lost.'); ?>';
    }

    $(document).ready(function() {
        // Prevent accidentally navigating away
        $(':input').bind('change', function() { setConfirmUnload(true); });
        $('form').submit(function() { setConfirmUnload(false); return true; });
    });

	$(document).ready(function() {
		if($('#subject').val()=='1'){$('.subjects_area').show();}else if($('#subject').val()=='0'){$('.subjects_area').hide();}
		$('#subject').change(function() { $('.subjects_area').toggle();});
		$('.add_topic').click(function() {
		$(".project_images").append('<li>'
								  + '<input name="subjects[]" type="input" /> \r\n'
								  + '<a href="#" class="remove_topic" border="2"> \r\n'
								  + '<img src="<?php echo URL_PUBLIC; ?>wolf/plugins/djg_cf/images/16_remove.png" alt="<?php echo __('remove subject'); ?>" title="<?php echo __('remove subject'); ?>" /> \r\n'
								  + '</li>');
		return false;
	});

	$('.remove_topic').live('click', function() {
		$(this).parent().remove();return false;
	});

});
// ]]>
</script>