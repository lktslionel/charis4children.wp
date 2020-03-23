=== The GDPR Framework By Data443 ===
Contributors: codelight, indrek_k, data443
Tags: gdpr, compliance, security, privacy, wordpress gdpr, eu privacy directive, eu cookie law, california privacy law, regulations, privacy law, law, data, general data protection regulation, gdpr law
Requires at least: 4.7
Tested up to: 4.9.8
Requires PHP: 5.6.33
Stable tag: trunk
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

Easy to use tools to help make your website GDPR-compliant. Fully documented, extendable and developer-friendly.  Extensions to enterprise GDPR compliance coming - full active development and QA team.  Free, friendly support!

== Description ==

This plugin is a service of [Data443.com](https://www.data443.com) & ClassiDocs – and this latest release is our first rollup bug fix release - we hope you like the many changes!

Data443 is a Data Security and Compliance company traded on the OTCMarkets as [LDSR](https://www.otcmarkets.com/stock/LDSR/overview).  We have been providing leading GDPR compliance products such as [ClassiDocs](https://www.data443.com/classidocs-home/), Blockchain privace and enterprise cloud eDiscovery tools.

The GDPR regulation is a large and complex law.  Each member country is to ratify it into its own legilsation and language.  This makes it cumbersome to manage - but rest asssured - we have a full [Site Owners Guide](https://www.data443.com/wordpress-site-owners-guide-to-gdpr/) to help you learn and understand some of your requirements.

This product gives a simple and elegant interface to handle Data Subject Access Requests (DSARs).  In a few clicks, you can:

### Features
&#9745; Enable DSAR on one page - allow even those without an account to automatically view, export and delete their personal data;
&#9745; Configure the plugin to delete or anonymize personal data automatically or send a notification and allow admins to do it manually;
&#9745; Track, manage and withdraw consent;
&#9745; Generate a GDPR-compatible Privacy Policy template for your site;
&#9745; Use a helpful installation wizard to get you started quickly;
&#9745; Report on related data items within your WordPress installation;
&#9745; Significantly reduce your staff time efforts dealing with DSARs;
&#9745; Enable your larger organization to summarize and consolidate DSAR work;
&#9745; Report to management on DSAR status, volume and data requirements;


&#9745; We provide this fully documented;
&#9745; We are developer-friendly. Everything can be extended, every feature and template can be overridden.

## IMPORTANT
Please disable (or otherwise remove) caching capabilities from the plugin pages - as these are very dynamic and based on use interaction.

## Disclaimer
Using The GDPR Framework does NOT guarantee compliance to GDPR. This plugin gives you general information and tools, but is NOT meant to serve as complete compliance package. Compliance to GDPR is risk-based ongoing process that involves your whole business. Codelight is not eligible for any claim or action based on any information or functionality provided by this plugin.

### Documentation
Full documentation: [The WordPress Site Owner's Guide to GDPR](https://www.data443.com/wordpress-site-owners-guide-to-gdpr/)
For developers: [Developer Docs](https://www.data443.com/wordpress-gdpr-framework-developer-docs/)

### Coming up next
&#9744; Cookie solution
&#9744; Integration with WP & WooCommerce core tools
&#9744; Overhaul & improvements on the consent tracking mechanism, re-consent, etc.

GDPR is here to stay and we are just getting started. There's lots more to come!

### Plugin support:
The GDPR Framework currently works with the following plugins
&#9745; Contact Form 7 & Contact Form Flamingo
&#9745; Gravity Forms - [Download the GDPR add-on](https://wordpress.org/plugins/gdpr-for-gravity-forms/)
&#9745; Formidable Forms - [Download the GDPR add-on](https://wordpress.org/plugins/gdpr-for-formidable-forms/)
&#9745; WPML

Coming soon:
&#9744; WP Migrate DB
&#9744; WooCommerce (postponed until the launch of their own compliance toolkit)
&#9744; Easy Digital Downloads

We are happy to add support for other major plugins as well. If you have a request, get in touch! [SUPPORT](https://data443.atlassian.net/servicedesk/customer/portal/2)

== Installation ==
1. Upload the plugin files to the /wp-content/plugins, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the ‘Plugins’ screen in WordPress.
3. ‘The GDPR Framework’ will be managed at Tool>Privacy tab.
4. The page 'Privacy Tools' will be created after Setup Wizard. This page displays the form where visitors can submit their request.

== Frequently Asked Questions ==
= Help, the identification emails are not sent! =
The GDPR Framework uses the exact same mechanism for sending emails as the rest of your WordPress site. Please test if your site sends out emails at all using the Forgot Password form, for example.
If you get the forgot password email but not the identification email, please make a post in the support forums.

= Help, the link in the identification email doesn't work! =
Are you using SendGrid or another email delivery service? This might corrupt the link in the email.
In case you're using Sendgrid, make sure to turn off "click tracking". Otherwise, please post in the support forum!

= Help, the Privacy Tools page acts weirdly or always displays the "link expired" message! =
Check if you're using any caching plugins. If yes, then make sure the Privacy Tools page is excluded.
Also check if a server side cache is enabled by your web host.

= How is this plugin different from the tools in WordPress v4.9.6? =
WordPress 4.9.6 provides tools to allow administrators to manually handle GDPR requests. However, the GDPR framework allows visitors to automatically download and export data to reduce administrative work load.
In addition to that, we provide tools to manage and track custom consent types and also a privacy policy generator.
We are also planning to add other important privacy-related features missing from WordPress core over time.


== Changelog ==


= 1.0.14 =
* Make Cookie Popup Optional


= 1.0.13 =
* Proper update - upload failure on previous promo


= 1.0.12 =
* Change comment consent text
* Add english (canada) to supported languages
* change checkbox comment
* Added "cookie acceptance" pop up
* Recaptcha Removed
* Make default consent translatable

= 1.0.11 = 
Numerous backlog bug fixes including:
* comments checkbox reported to disappear with WPML active
* Can’t save on Consent tab
* Treat upper- and lowercase chars in visitor email addresses equally
* Captcha on privacy tools page
* Privacy Tools Delete text change
* Add locations outside of US and EU
* Ensure + symbol works in email addresses
* Privacy Policy: replace "[TODO]" with something that's not a shortcode format
* confirm "delete my data" when button is pushed
* can't leave any comments with GDPR activated
* add Polylang compatibility
* Validate functionality with most current WP version

= 1.0.10 =
* Fix fatal error caused by Flamingo integration

= 1.0.9 =
* Add support for Contact Form 7 Flamingo
* Remove nested the_content filter in the consent area editor to avoid potential conflicts with various plugins (Thanks Gary McPherson!)
* Fix some missing translation strings (Thanks trueqap!)
* Additional minor tweaks
* Update Italian translation (Thanks Rienzi Comunica!)

= 1.0.8 =
* Disable Privacy Tools page if not set via admin (fixes infinite redirect issue)
* Add additional admin notification if Privacy Tools page is not set
* Additional minor tweaks

= 1.0.7 =
* Update translation pot file
* Add partial Greek translations (Thanks @webace-creative-studio)

= 1.0.6 =
* Fix administrative roles not being able to comment via admin interface
* Fix trashed or spam comments not being deleted
* Minor usability tweaks everywhere
* Fix PHP5.6 not properly saving custom consent (Thanks @paulnewson!)
* Fix CF7 always showing as enabled in wizard
* In Tools > Privacy > Data Subjects, add the display of given consents
* Add warning about Sendgrid compatibility in the installer
* Fix issue with installer wizard not properly saving export action
* Add notice in case the settings are not properly configured
* Added Bulgarian translation (thanks Zankov Group!)
* Added partial Italian translation (thanks Matteo Bruno!)

= 1.0.5 =
* Fix installing consent tables and roles properly
* Add Spanish translations (Thanks @elarequi!)
* Add partial German translations (Thanks @knodderdachs!)
* Lower required PHP version to 5.6.0
* Re-add container alias for DataSubjectManager
* Fix for installer giving the option to add links to footer for unsupported themes
* Fix PHP notice in WPML module

= 1.0.4 =
* Fix translations, for real this time
* Add French translations (Thanks @datagitateur!)
* Fix PHP warning if WPML is activated
* Add filter around $headers array for all outgoing emails sent via this plugin

= 1.0.3 =
* Change text domain to 'gdpr-framework' to avoid conflict with other plugins
* Add Portuguese translation (Thanks @kativiti!)
* Add partial Estonian translation

= 1.0.2 =
* Fix T&C and Privacy Policy URLs on registration and comments forms
* Add basic styling and separate stylesheet for Privacy Tools page
* Allow disabling styles for Privacy Tools page via admin
* Add confirmation notice on deleting data via front-end Privacy Tools
* Change strings with 'gdpr-admin' domain back to 'gdpr'. Add context to all admin strings.

= 1.0.1 =
* Fix PHP notice on Privacy Tools frontend page if logged in as admin

= 1.0.0 =
* Initial release
