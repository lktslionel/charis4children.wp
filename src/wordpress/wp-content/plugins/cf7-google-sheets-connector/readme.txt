=== CF7 Google Sheets Connector ===
Contributors: westerndeal
Donate link: https://www.paypal.me/WesternDeal
Author URL: https://www.gsheetconnector.com/
Tags: cf7, contact form 7, Contact Form 7 Integrations, contact forms, Google Sheets, Google Sheets Integrations, Google, Sheets
Requires at least: 3.6
Tested up to: 5.0.2
Stable tag: 2.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Send your Contact Form 7 data directly to your Google Sheets spreadsheet.

== Description ==

[Homepage](https://www.gsheetconnector.com/) | [Documentation](https://www.gsheetconnector.com/documentation) | [Support](https://www.gsheetconnector.com/support) | [Demo](https://cf7demo.gsheetconnector.com/) | [Premium Version](https://www.gsheetconnector.com/cf7-google-sheet-connector-pro?wp-repo)

This plugin is a bridge between your [WordPress](https://wordpress.org/) [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) forms and [Google Sheets](https://www.google.com/sheets/about/).

When a visitor submits his/her data on your website via a Contact Form 7 form, upon form submission, such data are also sent to Google Sheets.

Get rid of making mistakes while adding the sheet settings or adding the headers ( Mail Tags ) to the sheet column. We have Launched the <a href="https://www.gsheetconnector.com/cf7-google-sheet-connector-pro?wp-repo" target="_blank">Googlesheet Connector PRO version</a> with more automated features.

= Still haven't purchased ? <a href="https://www.gsheetconnector.com/cf7-google-sheet-connector-pro?wp-repo" target="_blank">Get it Now</a> =

= Check Live Demo =
Demo URL:&nbsp;<a href="https://cf7demo.gsheetconnector.com/" target="_blank">https://cf7demo.gsheetconnector.com/</a>

Google Sheet URL to Check submitted Data<br><a href="https://docs.google.com/spreadsheets/d/1ooBdX0cgtk155ww9MmdMTw8kDavIy5J1m76VwSrcTSs/" target="_blank">https://docs.google.com/spreadsheets/d/1ooBdX0cgtk155ww9MmdMTw8kDavIy5J1m76VwSrcTSs/</a>
				

= How to Use this Plugin =

*In Google Sheets*  
* Log into your Google Account and visit Google Sheets.  
* Create a new Sheet and name it.  
* Rename the tab on which you want to capture the data. 

*In WordPress Admin*  
* Create or Edit the Contact Form 7 form from which you want to capture the data. Set up the form as usual in the Form and Mail etc tabs. Thereafter, go to the new "Google Sheets" tab.  
* On the "Google Sheets" tab, copy-paste the Google Sheets sheet name and tab name into respective positions, and hit "Save".

*In Google Sheets*  
* In the Google sheets tab, provide column names in row 1. The first column should be "date". For each further column, copy paste mail tags from the Contact Form 7 form (e.g. "your-name", "your-email", "your-subject", "your-message", etc).  
* Test your form submit and verify that the data shows up in your Google Sheet.

= Important Notes = 

* You must pay very careful attention to your naming. This plugin will have unpredictable results if names and spellings do not match between your Google Sheets and form settings.

== Installation ==

1. Upload `cf7-google-sheets-connector` to the `/wp-content/plugins/` directory, OR `Site Admin > Plugins > New > Search > CF7 Google Sheets Connector > Install`.  
2. Activate the plugin through the 'Plugins' screen in WordPress.  
3. Use the `Admin Panel > Contact form 7 > Google Sheets` screen to connect to `Google Sheets` by entering the Access Code. You can get the Access Code by clicking the "Get Code" button. 
Enjoy!

== Screenshots ==

1. Installation step 3 - Google Sheets Connect Page.  
2. Edit form - Google Sheets tab. 
3. Google Sheet with special mail tags

== Frequently Asked Questions ==

= Why isn't the data send to spreadsheet? CF7 Submit is just Spinning. = 
Sometimes it can take a while of spinning before it goes through. But if the entries never show up in your Sheet then one of these things might be the reason:

1. Wrong access code ( Check debug log )
2. Wrong Sheet name or tab name
3. Wrong Column name mapping ( Column names are the contact form mail-tags. It cannot have underscore or any special characters )

Please double-check those items and hopefully getting them right will fix the issue.

= How do I get the Google Access Code required in step 3 of Installation? =

* On the `Admin Panel > Contact form 7 > Google Sheets` screen, click the "Get Code" button.
* In a popup Google will ask you to authorize the plugin to connect to your Google Sheets. Authorize it - you may have to log in to your Google account if you aren't already logged in. 
* On the next screen, you should receive the Access Code. Copy it. 
* Now you can paste this code back on the `Admin Panel > Contact form 7 > Google Sheets` screen. 

== Changelog ==

= 2.7 =
* Done UI changes.
* Fixed - Not to delete authentication data when upgrade to Pro Version.
* Changed few classes and functions name to not get conflict when upgrade to pro Version

= 2.6 =
* Done UI changes at Google Sheet Tab under Contact Form settings.

= 2.5 =
* Removed Limitation

= 2.4 =
* Fixed - Connections of Contact Forms with Google Sheet.
* Added limitation to connect first 5 Contact Forms to Google Sheet.

= 2.3.1 =
* Fixed images not being displayed.

= 2.3 =
* Fixed integration issues.
* Fixed the functionality issues of limitations as per the last update.

= 2.2 =
* Done few UI changes and solved few bugs.
* Added a limitation for contact form to be connected with the Google Sheet.

= 2.1 =
* Added Google Sheet Connector dashboard widget for quick access to the contact form connected with Google Sheet.
* Added option to clear logs.
* Fixed - Multisite plugin activation issue.

= 2.0 ( 11/06/2018 ) =
* Fixed - Bypassing of CF7 built-in data validation.

= 1.9 =
* Fixed - Not fetching contact form data to google sheet.

= 1.8 =
* Fixed the hijacking( loading issue front-end form ) of page after submit actions.
* Integrated New Special Mail Tags ( including flamingo serial number ) with Spread Sheet without (_) underscores(Refer screenshot).

= 1.7 (26/08/2017) =
* Integrated Special Mail Tags with Spread Sheet without (_)underscores(Refer screenshot).
* Fixed Date Format as per wordpress standards.

= 1.6 =
* Updated Google Spread Sheet Library
* Changed classes name for PHP Google Auth library.
* Delete all data on uninstallation of plugin.

= 1.5 =
* Fixed more class names due to conflict with other plugins.
* Fixed issue to send hidden fields via dynamic text extension.
* Added settings link on activation of plugin.

= 1.4 =
* Fixed 500 Internal Server Error if sheet name or tab name is not set.

= 1.3 =
* Added .pot file for easier translation.

= 1.2 =
* Updated plugin description etc.

= 1.1 =
* Fixed date format and display issues related to non-English dates. 
* Fixed the class name due to conflict with other plugins.

= 1.0 =
* First public release
* Integrated Contact form 7 with Google sheets.