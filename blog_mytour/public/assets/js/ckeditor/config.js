/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.enterMode = CKEDITOR.ENTER_BR;
    /* ckfinder */
    config.filebrowserBrowseUrl = location.protocol + '//' + location.host + '/assets/js/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = location.protocol + '//' + location.host + '/assets/js/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = location.protocol + '//' + location.host + '/assets/js/ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl = location.protocol + '//' + location.host + '/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = location.protocol + '//' + location.host + '/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = location.protocol + '//' + location.host + '/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

    /*config.filebrowserBrowseUrl = '../ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = '../ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = '../ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl = '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';*/
    /* ckfinder */
};
