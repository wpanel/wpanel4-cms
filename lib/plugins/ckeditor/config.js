/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

// CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard'}, groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];
	// config.removeButtons = 'Templates,Save,Source,NewPage,Preview,Print,HiddenField,ImageButton,Button,Select,Textarea,TextField,Radio,Checkbox,Form,Flash,About,ShowBlocks,PasteFromWord,PasteText,Paste,Copy,Cut,Undo,Redo';

	config.removeButtons = 'Print,Preview,NewPage,Templates,Save,Source,BidiLtr,BidiRtl,Language,Flash,ShowBlocks,About,HiddenField,ImageButton,Button,Select,Textarea,TextField,Radio,Checkbox,Form,Scayt,SelectAll,Find,Replace,JustifyRight,Flash,PasteFromWord,PasteText,Paste,Copy,Cut,Undo,Redo';
};
