Djg Contact Form Documentation
----
* Djg Contact Form is very easy and usefull component. Contact form that works without having to reload the page. It works based on jquery and ajax.


HISTORY VERSION
----
* 1.1.3c - documentation via README.md
* 1.1.3b - fix subject condition
* 1.1.3a - auto append jQuery validate function
* 1.1.3 - subject as value not subject id (thanks for David)
* 1.1.1 - automatic append css to head in fronted, cleanurl and ? compatible
* 1.1.0 - new validate (jQuery Validation Plugin 1.9.0), captcha refresh on click, form W3C Validate, add update_url
* 1.0.4 - add antyspam filter, add uninstall script - wolf 0.7.3 only
* 1.0.3 - add russion translation (thanks for Konstantin Baev)
* 1.0.2 - first official - wolf 0.6.x

HOW TO
----
##### Enter the admin page installation and activate the plugin.
##### Insert in page content: 
```sh
<?php if (Plugin::isEnabled('djg_cf'))djg_cf(); ?>

```
REQUIRED
----
##### jQuery in fronted
```sh
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js</script>

```
Translations
----
* Russian translation by Konstantin Baev konstantin.baev@gmail.com

License
----
* MIT