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
    'version'		=> '1.1.3d',
   	'license'		=> 'GPL',
	'author'		=>	'Michał Uchnast',
	'website'		=>	'http://www.kreacjawww.pl/',
	'update_url'  	=> 'https://raw.githubusercontent.com/djgprv/djg_cf/master/versions.xml',
    'require_wolf_version' => '0.7.3',
	'type'			=> 'both'
));
	//	load plugin classes into the system
	AutoLoader::addFolder(dirname(__FILE__) . '/models');

	Plugin::addController('djg_cf', __('[djg] Contact form'), 'administrator', false);
	Dispatcher::addRoute(array(
	'/djg_cf_send_email.php' => '/plugin/djg_cf/djg_cf_send_email',
	'/djg_cf_session.php' => '/plugin/djg_cf/session'
));

function djg_cf()
{
	$emailAdress = Plugin::getSetting('emailAdress', 'djg_cf');
	$subjectPrefix = Plugin::getSetting('subjectPrefix', 'djg_cf');
	$subjects = explode("#",Plugin::getSetting('subjects', 'djg_cf'));
	$appendCss = Plugin::getSetting('appendCss', 'djg_cf');
	$subject = Plugin::getSetting('subject', 'djg_cf');
	$captcha = Plugin::getSetting('captcha', 'djg_cf');
	?>
	<script type="text/javascript">
	$(document).ready(function() {
		/**
		 * jQuery Validation Plugin 1.9.0
		 *
		 * http://bassistance.de/jquery-plugins/jquery-plugin-validation/
		 * http://docs.jquery.com/Plugins/Validation
		 *
		 * Copyright (c) 2006 - 2011 Jörn Zaefferer
		 *
		 * Dual licensed under the MIT and GPL licenses:
		 *   http://www.opensource.org/licenses/mit-license.php
		 *   http://www.gnu.org/licenses/gpl.html
		 */
		$.isFunction($.fn.validate)?alert("jQuery validate function is required!"):(!function(t){t.extend(t.fn,{validate:function(e){if(!this.length)return void(e&&e.debug&&window.console&&console.warn("nothing selected, can't validate, returning nothing"));var i=t.data(this[0],"validator");if(i)return i;if(this.attr("novalidate","novalidate"),i=new t.validator(e,this[0]),t.data(this[0],"validator",i),i.settings.onsubmit){var s=this.find("input, button");s.filter(".cancel").click(function(){i.cancelSubmit=!0}),i.settings.submitHandler&&s.filter(":submit").click(function(){i.submitButton=this}),this.submit(function(e){function s(){if(i.settings.submitHandler){if(i.submitButton)var e=t("<input type='hidden'/>").attr("name",i.submitButton.name).val(i.submitButton.value).appendTo(i.currentForm);return i.settings.submitHandler.call(i,i.currentForm),i.submitButton&&e.remove(),!1}return!0}return i.settings.debug&&e.preventDefault(),i.cancelSubmit?(i.cancelSubmit=!1,s()):i.form()?i.pendingRequest?(i.formSubmitted=!0,!1):s():(i.focusInvalid(),!1)})}return i},valid:function(){if(t(this[0]).is("form"))return this.validate().form();var e=!0,i=t(this[0].form).validate();return this.each(function(){e&=i.element(this)}),e},removeAttrs:function(e){var i={},s=this;return t.each(e.split(/\s/),function(t,e){i[e]=s.attr(e),s.removeAttr(e)}),i},rules:function(e,i){var s=this[0];if(e){var n=t.data(s.form,"validator").settings,r=n.rules,a=t.validator.staticRules(s);switch(e){case"add":t.extend(a,t.validator.normalizeRule(i)),r[s.name]=a,i.messages&&(n.messages[s.name]=t.extend(n.messages[s.name],i.messages));break;case"remove":if(!i)return delete r[s.name],a;var u={};return t.each(i.split(/\s/),function(t,e){u[e]=a[e],delete a[e]}),u}}var o=t.validator.normalizeRules(t.extend({},t.validator.metadataRules(s),t.validator.classRules(s),t.validator.attributeRules(s),t.validator.staticRules(s)),s);if(o.required){var l=o.required;delete o.required,o=t.extend({required:l},o)}return o}}),t.extend(t.expr[":"],{blank:function(e){return!t.trim(""+e.value)},filled:function(e){return!!t.trim(""+e.value)},unchecked:function(t){return!t.checked}}),t.validator=function(e,i){this.settings=t.extend(!0,{},t.validator.defaults,e),this.currentForm=i,this.init()},t.validator.format=function(e,i){return 1==arguments.length?function(){var i=t.makeArray(arguments);return i.unshift(e),t.validator.format.apply(this,i)}:(arguments.length>2&&i.constructor!=Array&&(i=t.makeArray(arguments).slice(1)),i.constructor!=Array&&(i=[i]),t.each(i,function(t,i){e=e.replace(new RegExp("\\{"+t+"\\}","g"),i)}),e)},t.extend(t.validator,{defaults:{messages:{},groups:{},rules:{},errorClass:"error",validClass:"valid",errorElement:"label",focusInvalid:!0,errorContainer:t([]),errorLabelContainer:t([]),onsubmit:!0,ignore:":hidden",ignoreTitle:!1,onfocusin:function(t){this.lastActive=t,this.settings.focusCleanup&&!this.blockFocusCleanup&&(this.settings.unhighlight&&this.settings.unhighlight.call(this,t,this.settings.errorClass,this.settings.validClass),this.addWrapper(this.errorsFor(t)).hide())},onfocusout:function(t){this.checkable(t)||!(t.name in this.submitted)&&this.optional(t)||this.element(t)},onkeyup:function(t){(t.name in this.submitted||t==this.lastElement)&&this.element(t)},onclick:function(t){t.name in this.submitted?this.element(t):t.parentNode.name in this.submitted&&this.element(t.parentNode)},highlight:function(e,i,s){"radio"===e.type?this.findByName(e.name).addClass(i).removeClass(s):t(e).addClass(i).removeClass(s)},unhighlight:function(e,i,s){"radio"===e.type?this.findByName(e.name).removeClass(i).addClass(s):t(e).removeClass(i).addClass(s)}},setDefaults:function(e){t.extend(t.validator.defaults,e)},messages:{required:"This field is required.",remote:"Please fix this field.",email:"Please enter a valid email address.",url:"Please enter a valid URL.",date:"Please enter a valid date.",dateISO:"Please enter a valid date (ISO).",number:"Please enter a valid number.",digits:"Please enter only digits.",creditcard:"Please enter a valid credit card number.",equalTo:"Please enter the same value again.",accept:"Please enter a value with a valid extension.",maxlength:t.validator.format("Please enter no more than {0} characters."),minlength:t.validator.format("Please enter at least {0} characters."),rangelength:t.validator.format("Please enter a value between {0} and {1} characters long."),range:t.validator.format("Please enter a value between {0} and {1}."),max:t.validator.format("Please enter a value less than or equal to {0}."),min:t.validator.format("Please enter a value greater than or equal to {0}.")},autoCreateRanges:!1,prototype:{init:function(){function e(e){var i=t.data(this[0].form,"validator"),s="on"+e.type.replace(/^validate/,"");i.settings[s]&&i.settings[s].call(i,this[0],e)}this.labelContainer=t(this.settings.errorLabelContainer),this.errorContext=this.labelContainer.length&&this.labelContainer||t(this.currentForm),this.containers=t(this.settings.errorContainer).add(this.settings.errorLabelContainer),this.submitted={},this.valueCache={},this.pendingRequest=0,this.pending={},this.invalid={},this.reset();var i=this.groups={};t.each(this.settings.groups,function(e,s){t.each(s.split(/\s/),function(t,s){i[s]=e})});var s=this.settings.rules;t.each(s,function(e,i){s[e]=t.validator.normalizeRule(i)}),t(this.currentForm).validateDelegate("[type='text'], [type='password'], [type='file'], select, textarea, [type='number'], [type='search'] ,[type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'] ","focusin focusout keyup",e).validateDelegate("[type='radio'], [type='checkbox'], select, option","click",e),this.settings.invalidHandler&&t(this.currentForm).bind("invalid-form.validate",this.settings.invalidHandler)},form:function(){return this.checkForm(),t.extend(this.submitted,this.errorMap),this.invalid=t.extend({},this.errorMap),this.valid()||t(this.currentForm).triggerHandler("invalid-form",[this]),this.showErrors(),this.valid()},checkForm:function(){this.prepareForm();for(var t=0,e=this.currentElements=this.elements();e[t];t++)this.check(e[t]);return this.valid()},element:function(e){e=this.validationTargetFor(this.clean(e)),this.lastElement=e,this.prepareElement(e),this.currentElements=t(e);var i=this.check(e);return i?delete this.invalid[e.name]:this.invalid[e.name]=!0,this.numberOfInvalids()||(this.toHide=this.toHide.add(this.containers)),this.showErrors(),i},showErrors:function(e){if(e){t.extend(this.errorMap,e),this.errorList=[];for(var i in e)this.errorList.push({message:e[i],element:this.findByName(i)[0]});this.successList=t.grep(this.successList,function(t){return!(t.name in e)})}this.settings.showErrors?this.settings.showErrors.call(this,this.errorMap,this.errorList):this.defaultShowErrors()},resetForm:function(){t.fn.resetForm&&t(this.currentForm).resetForm(),this.submitted={},this.lastElement=null,this.prepareForm(),this.hideErrors(),this.elements().removeClass(this.settings.errorClass)},numberOfInvalids:function(){return this.objectLength(this.invalid)},objectLength:function(t){var e=0;for(var i in t)e++;return e},hideErrors:function(){this.addWrapper(this.toHide).hide()},valid:function(){return 0==this.size()},size:function(){return this.errorList.length},focusInvalid:function(){if(this.settings.focusInvalid)try{t(this.findLastActive()||this.errorList.length&&this.errorList[0].element||[]).filter(":visible").focus().trigger("focusin")}catch(e){}},findLastActive:function(){var e=this.lastActive;return e&&1==t.grep(this.errorList,function(t){return t.element.name==e.name}).length&&e},elements:function(){var e=this,i={};return t(this.currentForm).find("input, select, textarea").not(":submit, :reset, :image, [disabled]").not(this.settings.ignore).filter(function(){return!this.name&&e.settings.debug&&window.console&&console.error("%o has no name assigned",this),this.name in i||!e.objectLength(t(this).rules())?!1:(i[this.name]=!0,!0)})},clean:function(e){return t(e)[0]},errors:function(){return t(this.settings.errorElement+"."+this.settings.errorClass,this.errorContext)},reset:function(){this.successList=[],this.errorList=[],this.errorMap={},this.toShow=t([]),this.toHide=t([]),this.currentElements=t([])},prepareForm:function(){this.reset(),this.toHide=this.errors().add(this.containers)},prepareElement:function(t){this.reset(),this.toHide=this.errorsFor(t)},check:function(e){e=this.validationTargetFor(this.clean(e));var i=t(e).rules(),s=!1;for(var n in i){var r={method:n,parameters:i[n]};try{var a=t.validator.methods[n].call(this,e.value.replace(/\r/g,""),e,r.parameters);if("dependency-mismatch"==a){s=!0;continue}if(s=!1,"pending"==a)return void(this.toHide=this.toHide.not(this.errorsFor(e)));if(!a)return this.formatAndAdd(e,r),!1}catch(u){throw this.settings.debug&&window.console&&console.log("exception occured when checking element "+e.id+", check the '"+r.method+"' method",u),u}}return s?void 0:(this.objectLength(i)&&this.successList.push(e),!0)},customMetaMessage:function(e,i){if(t.metadata){var s=this.settings.meta?t(e).metadata()[this.settings.meta]:t(e).metadata();return s&&s.messages&&s.messages[i]}},customMessage:function(t,e){var i=this.settings.messages[t];return i&&(i.constructor==String?i:i[e])},findDefined:function(){for(var t=0;t<arguments.length;t++)if(void 0!==arguments[t])return arguments[t];return void 0},defaultMessage:function(e,i){return this.findDefined(this.customMessage(e.name,i),this.customMetaMessage(e,i),!this.settings.ignoreTitle&&e.title||void 0,t.validator.messages[i],"<strong>Warning: No message defined for "+e.name+"</strong>")},formatAndAdd:function(t,e){var i=this.defaultMessage(t,e.method),s=/\$?\{(\d+)\}/g;"function"==typeof i?i=i.call(this,e.parameters,t):s.test(i)&&(i=jQuery.format(i.replace(s,"{$1}"),e.parameters)),this.errorList.push({message:i,element:t}),this.errorMap[t.name]=i,this.submitted[t.name]=i},addWrapper:function(t){return this.settings.wrapper&&(t=t.add(t.parent(this.settings.wrapper))),t},defaultShowErrors:function(){for(var t=0;this.errorList[t];t++){var e=this.errorList[t];this.settings.highlight&&this.settings.highlight.call(this,e.element,this.settings.errorClass,this.settings.validClass),this.showLabel(e.element,e.message)}if(this.errorList.length&&(this.toShow=this.toShow.add(this.containers)),this.settings.success)for(var t=0;this.successList[t];t++)this.showLabel(this.successList[t]);if(this.settings.unhighlight)for(var t=0,i=this.validElements();i[t];t++)this.settings.unhighlight.call(this,i[t],this.settings.errorClass,this.settings.validClass);this.toHide=this.toHide.not(this.toShow),this.hideErrors(),this.addWrapper(this.toShow).show()},validElements:function(){return this.currentElements.not(this.invalidElements())},invalidElements:function(){return t(this.errorList).map(function(){return this.element})},showLabel:function(e,i){var s=this.errorsFor(e);s.length?(s.removeClass(this.settings.validClass).addClass(this.settings.errorClass),s.attr("generated")&&s.html(i)):(s=t("<"+this.settings.errorElement+"/>").attr({"for":this.idOrName(e),generated:!0}).addClass(this.settings.errorClass).html(i||""),this.settings.wrapper&&(s=s.hide().show().wrap("<"+this.settings.wrapper+"/>").parent()),this.labelContainer.append(s).length||(this.settings.errorPlacement?this.settings.errorPlacement(s,t(e)):s.insertAfter(e))),!i&&this.settings.success&&(s.text(""),"string"==typeof this.settings.success?s.addClass(this.settings.success):this.settings.success(s)),this.toShow=this.toShow.add(s)},errorsFor:function(e){var i=this.idOrName(e);return this.errors().filter(function(){return t(this).attr("for")==i})},idOrName:function(t){return this.groups[t.name]||(this.checkable(t)?t.name:t.id||t.name)},validationTargetFor:function(t){return this.checkable(t)&&(t=this.findByName(t.name).not(this.settings.ignore)[0]),t},checkable:function(t){return/radio|checkbox/i.test(t.type)},findByName:function(e){var i=this.currentForm;return t(document.getElementsByName(e)).map(function(t,s){return s.form==i&&s.name==e&&s||null})},getLength:function(e,i){switch(i.nodeName.toLowerCase()){case"select":return t("option:selected",i).length;case"input":if(this.checkable(i))return this.findByName(i.name).filter(":checked").length}return e.length},depend:function(t,e){return this.dependTypes[typeof t]?this.dependTypes[typeof t](t,e):!0},dependTypes:{"boolean":function(t){return t},string:function(e,i){return!!t(e,i.form).length},"function":function(t,e){return t(e)}},optional:function(e){return!t.validator.methods.required.call(this,t.trim(e.value),e)&&"dependency-mismatch"},startRequest:function(t){this.pending[t.name]||(this.pendingRequest++,this.pending[t.name]=!0)},stopRequest:function(e,i){this.pendingRequest--,this.pendingRequest<0&&(this.pendingRequest=0),delete this.pending[e.name],i&&0==this.pendingRequest&&this.formSubmitted&&this.form()?(t(this.currentForm).submit(),this.formSubmitted=!1):!i&&0==this.pendingRequest&&this.formSubmitted&&(t(this.currentForm).triggerHandler("invalid-form",[this]),this.formSubmitted=!1)},previousValue:function(e){return t.data(e,"previousValue")||t.data(e,"previousValue",{old:null,valid:!0,message:this.defaultMessage(e,"remote")})}},classRuleSettings:{required:{required:!0},email:{email:!0},url:{url:!0},date:{date:!0},dateISO:{dateISO:!0},dateDE:{dateDE:!0},number:{number:!0},numberDE:{numberDE:!0},digits:{digits:!0},creditcard:{creditcard:!0}},addClassRules:function(e,i){e.constructor==String?this.classRuleSettings[e]=i:t.extend(this.classRuleSettings,e)},classRules:function(e){var i={},s=t(e).attr("class");return s&&t.each(s.split(" "),function(){this in t.validator.classRuleSettings&&t.extend(i,t.validator.classRuleSettings[this])}),i},attributeRules:function(e){var i={},s=t(e);for(var n in t.validator.methods){var r;r="required"===n&&"function"==typeof t.fn.prop?s.prop(n):s.attr(n),r?i[n]=r:s[0].getAttribute("type")===n&&(i[n]=!0)}return i.maxlength&&/-1|2147483647|524288/.test(i.maxlength)&&delete i.maxlength,i},metadataRules:function(e){if(!t.metadata)return{};var i=t.data(e.form,"validator").settings.meta;return i?t(e).metadata()[i]:t(e).metadata()},staticRules:function(e){var i={},s=t.data(e.form,"validator");return s.settings.rules&&(i=t.validator.normalizeRule(s.settings.rules[e.name])||{}),i},normalizeRules:function(e,i){return t.each(e,function(s,n){if(n===!1)return void delete e[s];if(n.param||n.depends){var r=!0;switch(typeof n.depends){case"string":r=!!t(n.depends,i.form).length;break;case"function":r=n.depends.call(i,i)}r?e[s]=void 0!==n.param?n.param:!0:delete e[s]}}),t.each(e,function(s,n){e[s]=t.isFunction(n)?n(i):n}),t.each(["minlength","maxlength","min","max"],function(){e[this]&&(e[this]=Number(e[this]))}),t.each(["rangelength","range"],function(){e[this]&&(e[this]=[Number(e[this][0]),Number(e[this][1])])}),t.validator.autoCreateRanges&&(e.min&&e.max&&(e.range=[e.min,e.max],delete e.min,delete e.max),e.minlength&&e.maxlength&&(e.rangelength=[e.minlength,e.maxlength],delete e.minlength,delete e.maxlength)),e.messages&&delete e.messages,e},normalizeRule:function(e){if("string"==typeof e){var i={};t.each(e.split(/\s/),function(){i[this]=!0}),e=i}return e},addMethod:function(e,i,s){t.validator.methods[e]=i,t.validator.messages[e]=void 0!=s?s:t.validator.messages[e],i.length<3&&t.validator.addClassRules(e,t.validator.normalizeRule(e))},methods:{required:function(e,i,s){if(!this.depend(s,i))return"dependency-mismatch";switch(i.nodeName.toLowerCase()){case"select":var n=t(i).val();return n&&n.length>0;case"input":if(this.checkable(i))return this.getLength(e,i)>0;default:return t.trim(e).length>0}},remote:function(e,i,s){if(this.optional(i))return"dependency-mismatch";var n=this.previousValue(i);if(this.settings.messages[i.name]||(this.settings.messages[i.name]={}),n.originalMessage=this.settings.messages[i.name].remote,this.settings.messages[i.name].remote=n.message,s="string"==typeof s&&{url:s}||s,this.pending[i.name])return"pending";if(n.old===e)return n.valid;n.old=e;var r=this;this.startRequest(i);var a={};return a[i.name]=e,t.ajax(t.extend(!0,{url:s,mode:"abort",port:"validate"+i.name,dataType:"json",data:a,success:function(s){r.settings.messages[i.name].remote=n.originalMessage;var a=s===!0;if(a){var u=r.formSubmitted;r.prepareElement(i),r.formSubmitted=u,r.successList.push(i),r.showErrors()}else{var o={},l=s||r.defaultMessage(i,"remote");o[i.name]=n.message=t.isFunction(l)?l(e):l,r.showErrors(o)}n.valid=a,r.stopRequest(i,a)}},s)),"pending"},minlength:function(e,i,s){return this.optional(i)||this.getLength(t.trim(e),i)>=s},maxlength:function(e,i,s){return this.optional(i)||this.getLength(t.trim(e),i)<=s},rangelength:function(e,i,s){var n=this.getLength(t.trim(e),i);return this.optional(i)||n>=s[0]&&n<=s[1]},min:function(t,e,i){return this.optional(e)||t>=i},max:function(t,e,i){return this.optional(e)||i>=t},range:function(t,e,i){return this.optional(e)||t>=i[0]&&t<=i[1]},email:function(t,e){return this.optional(e)||/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(t)},url:function(t,e){return this.optional(e)||/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(t)},date:function(t,e){return this.optional(e)||!/Invalid|NaN/.test(new Date(t))},dateISO:function(t,e){return this.optional(e)||/^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/.test(t)},number:function(t,e){return this.optional(e)||/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(t)},digits:function(t,e){return this.optional(e)||/^\d+$/.test(t)},creditcard:function(t,e){if(this.optional(e))return"dependency-mismatch";if(/[^0-9 -]+/.test(t))return!1;var i=0,s=0,n=!1;t=t.replace(/\D/g,"");for(var r=t.length-1;r>=0;r--){var a=t.charAt(r),s=parseInt(a,10);n&&(s*=2)>9&&(s-=9),i+=s,n=!n}return i%10==0},accept:function(t,e,i){return i="string"==typeof i?i.replace(/,/g,"|"):"png|jpe?g|gif",this.optional(e)||t.match(new RegExp(".("+i+")$","i"))},equalTo:function(e,i,s){var n=t(s).unbind(".validate-equalTo").bind("blur.validate-equalTo",function(){t(i).valid()});return e==n.val()}}}),t.format=t.validator.format}(jQuery),function(t){var e={};if(t.ajaxPrefilter)t.ajaxPrefilter(function(t,i,s){var n=t.port;"abort"==t.mode&&(e[n]&&e[n].abort(),e[n]=s)});else{var i=t.ajax;t.ajax=function(s){var n=("mode"in s?s:t.ajaxSettings).mode,r=("port"in s?s:t.ajaxSettings).port;return"abort"==n?(e[r]&&e[r].abort(),e[r]=i.apply(this,arguments)):i.apply(this,arguments)}}}(jQuery),function(t){jQuery.event.special.focusin||jQuery.event.special.focusout||!document.addEventListener||t.each({focus:"focusin",blur:"focusout"},function(e,i){function s(e){return e=t.event.fix(e),e.type=i,t.event.handle.call(this,e)}t.event.special[i]={setup:function(){this.addEventListener(e,s,!0)},teardown:function(){this.removeEventListener(e,s,!0)},handler:function(e){return arguments[0]=t.event.fix(e),arguments[0].type=i,t.event.handle.apply(this,arguments)}}}),t.extend(t.fn,{validateDelegate:function(e,i,s){return this.bind(i,function(i){var n=t(i.target);return n.is(e)?s.apply(n,arguments):void 0})}})}(jQuery));

		<?php if($appendCss): ?> //appendexample fronted css to head on init
		$('<link rel="stylesheet" type="text/css" href="<?php echo URL_PUBLIC; ?>wolf/plugins/djg_cf/css/djg_cf_fronted.css" />').appendTo('head');
		<?php endif; ?>
		$('#djg_cf').show();
		$('#djg_cf_jq_test').hide();
		$('#djg_cf_captchaimage').attr("src", "<?php echo URL_PUBLIC; ?>wolf/plugins/djg_cf/captcha/image.php?" + new Date().getTime());
		$('#djg_cf_captchaimage').click(function() {$(this).attr("src", "<?php echo URL_PUBLIC; ?>wolf/plugins/djg_cf/captcha/image.php?" + new Date().getTime());});
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
					captcha: {required: true, remote: '<?php echo rtrim(URL_PUBLIC,'/').(USE_MOD_REWRITE ? '/': '/?/'); ?>djg_cf_session.php'}		
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
	<?php if($subject): ?>
	<label for="subject"><?php echo __('The Subject:'); ?></label>
	<select name="subject" id="subject">
	<?php
	array_unshift($subjects, __('Select a subject'));
	foreach ($subjects as $subject_id => $subject_value):
      //$selected = ($subject_id == $subject_value) ? ' selected="selected"' : '';
      echo '<option value="' . $subject_value . '"' . $selected . '>' . $subject_value . '</option>' . PHP_EOL;
    endforeach;
    ?>
	</select>
	<?php endif; ?>
	<label for="message"><?php echo __('The Message:'); ?></label>
	<textarea id="message" tabindex="4" rows="4" cols="10" name="message"></textarea>
    <?php /* captcha */ 
	if($captcha == 1): ?>
	<label for="captcha"><?php echo __('The Captcha:'); ?></label>
	<input id="captcha" class="captcha" type="text" autocomplete="off"  tabindex="5" maxlength="6" name="captcha" />
	<img id="djg_cf_captchaimage" src="<?php echo URL_PUBLIC; ?>wolf/plugins/djg_cf/captcha/image.php" alt="<?php echo __('captcha image'); ?>" title="<?php echo __('captcha image'); ?>" width="80" height="30">
	<?php endif; ?>
	</fieldset>
	<label for="submit" style="clear: both;" ></label>
	<button type="submit" name="submit"><?php echo __('Send The Message'); ?></button>
	<div style="display:none;" class="mail_success msg_success"><?php echo __('Thank you. The mailman is on his way.'); ?></div>
	<div style="display:none;" class="mail_fail msg_error"><?php echo __('Sorry, don\'t know what happened. Try later.'); ?></div>
	</form>	
	<div id="djg_cf_jq_test" class="msg_error"><?php echo __('Probability JavaScript is disabled or You have not jQuery library.'); ?></div>

<?php } // end function ?>
