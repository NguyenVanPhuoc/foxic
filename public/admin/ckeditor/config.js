/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#FF7202';
	config.height = '500px';
	/*config.toolbar = [	    
	    { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
	    { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },	    
	    { name: 'basicstyles', items: [ 'Bold', 'Italic','Underline','CopyFormatting', 'RemoveFormat' ] },
	    { name: 'insert', items: [ 'Image'] },
	    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
	];*/
	config.htmlEncodeOutput = false;
	config.entities = false;

	// config.entities_greek = false;
	// config.entities_latin = false;
};