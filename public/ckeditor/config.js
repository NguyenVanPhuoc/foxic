/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#FF7202';
	config.height = '600px';
	config.toolbar = [
	    { name: 'document', items: ['NewPage'] },
	    { name: 'clipboard', items: [ 'Cut', 'Copy', 'Undo', 'Redo' ] },	    
	    { name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
	    { name: 'insert', items: [ 'Image', 'Table' ] },
	];
	config.htmlEncodeOutput = false;
	config.entities = false;
};
