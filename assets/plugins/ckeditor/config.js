/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */
CKEDITOR.editorConfig = function (config) {
	config.toolbarGroups = [{
			name: 'document',
			groups: ['mode', 'document', 'doctools']
		},
		{
			name: 'clipboard',
			groups: ['clipboard', 'undo']
		},
		{
			name: 'editing',
			groups: ['find', 'selection', 'spellchecker', 'editing']
		},
		{
			name: 'forms',
			groups: ['forms']
		},
		{
			name: 'insert',
			groups: ['insert']
		},
		{
			name: 'colors',
			groups: ['colors']
		},
		{
			name: 'tools',
			groups: ['tools']
		},
		{
			name: 'links',
			groups: ['links']
		},
		'/',
		{
			name: 'basicstyles',
			groups: ['basicstyles', 'cleanup']
		},
		{
			name: 'paragraph',
			groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']
		},
		{
			name: 'styles',
			groups: ['styles']
		},
		{
			name: 'others',
			groups: ['others']
		},
		{
			name: 'about',
			groups: ['about']
		}
	];

	config.removeButtons = 'Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Find,Replace,SelectAll,Save,NewPage,ExportPdf,Preview,Print,Templates,CopyFormatting,RemoveFormat,CreateDiv,BidiLtr,BidiRtl,Language,Flash,PageBreak,Iframe,ShowBlocks,About';
};