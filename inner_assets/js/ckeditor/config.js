/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.

	config.allowedContent = true; 
	config.disableNativeSpellChecker = false;
	config.enterMode = CKEDITOR.ENTER_BR;  
	config.shiftEnterMode = CKEDITOR.ENTER_P; 
	config.autoParagraph = true;
	config.fillEmptyBlocks = false;
	config.pasteFromWordCleanupFile = false;
	config.scayt_autoStartup = true;
	config.scayt_sLang = 'en_GB';

	
	config.toolbarGroups = 
	[
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] }, 
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'align'},
		{ name: 'styles' },
		{ name: 'colors' }
	];
	
	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'About,Link,Anchor,Image,Source';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	config.extraPlugins = 'simage,justify,pastefromword,scayt';
	config.height = 100;     // 500 pixels wide.
	config.width = '100%';   // CSS unit (percent).
};
	CKEDITOR.config.imageUploadURL = $("#directionBaseURL").val() + 'downloads/upload_image_ckeditor';
	CKEDITOR.config.dataParser = function(data){return data['url'];};
