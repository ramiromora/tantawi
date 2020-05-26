CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		'/',
		{ name: 'clipboard', groups: [ 'undo', 'clipboard' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] },
		'/'
	];

	config.removeButtons = 'Source,Save,NewPage,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Form,CreateDiv,Language,Link,Unlink,Anchor,Flash,Iframe,About,Table,Image,PageBreak,Smiley,Preview';
};