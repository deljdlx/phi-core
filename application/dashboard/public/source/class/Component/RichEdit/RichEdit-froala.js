Bienvenue.Component.RichEdit=function()
{
	this.__construct();
	this.containerElement=null;
	this.selector=null;



	this.defaultOptions={

		toolbarButtons: [

			'clearFormatting', 'bold', 'italic', 'underline' ,
			'fontSize', '|', 'color', /*  'fullscreen', 'subscript', 'superscript',, 'fontFamily', 'strikeThrough', 'emoticons', 'inlineStyle', 'paragraphStyle','paragraphFormat', 'selectAll', 'outdent', 'indent', */ '|',
			'align', 'formatOL', 'formatUL', 'insertHR', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', 'undo', 'redo',
			'quote', 'custom_paragraph',
			'html',
		],

		htmlAllowedTags: [
			'a', 'abbr', 'address', 'area', 'article', 'aside', 'audio', 'b', 'base', 'bdi', 'bdo', 'blockquote',
			'br', 'button', 'canvas', 'caption', 'cite', 'code', 'col', 'colgroup', 'datalist', 'dd', 'del', 'details',
			'dfn', 'dialog', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'figcaption', 'figure', 'footer', 'form',
			'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'header', 'hgroup', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'kbd',
			'keygen', 'label', 'legend', 'li', 'link', 'main', 'map', 'mark', 'menu', 'menuitem', 'meter', 'nav',
			'noscript', 'object', 'ol', 'optgroup', 'option', 'output', 'p', 'param', 'pre', 'progress', 'queue',
			'rp', 'rt', 'ruby', 's', 'samp', 'script', 'style', 'section', 'select', 'small', 'source', 'span', 'strike',
			'strong', 'sub', 'summary', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'time',
			'title', 'tr', 'track', 'u', 'ul', 'var', 'video', 'wbr', 'meta', 'script',
			'bidule'
		],
		htmlRemoveTags: [],
		htmlAllowedAttrs: [
			'accept', 'accept-charset', 'accesskey', 'action', 'align', 'alt', 'async', 'autocomplete', 'autofocus',
			'autoplay', 'autosave', 'background', 'bgcolor', 'border', 'charset', 'cellpadding', 'cellspacing',
			'checked', 'cite', 'class', 'color', 'cols', 'colspan', 'content', 'contenteditable', 'contextmenu',
			'controls', 'coords', 'data', 'data-.*', 'datetime', 'default', 'defer', 'dir', 'dirname', 'disabled',
			'download', 'draggable', 'dropzone', 'enctype', 'for', 'form', 'formaction', 'headers', 'height',
			'hidden', 'high', 'href', 'hreflang', 'http-equiv', 'icon', 'id', 'ismap', 'itemprop', 'keytype', 'kind',
			'label', 'lang', 'language', 'list', 'loop', 'low', 'max', 'maxlength', 'media', 'method', 'min', 'multiple',
			'name', 'novalidate', 'open', 'optimum', 'pattern', 'ping', 'placeholder', 'poster', 'preload', 'pubdate',
			'radiogroup', 'readonly', 'rel', 'required', 'reversed', 'rows', 'rowspan', 'sandbox', 'scope', 'scoped',
			'scrolling', 'seamless', 'selected', 'shape', 'size', 'sizes', 'span', 'src', 'srcdoc', 'srclang', 'srcset',
			'start', 'step', 'summary', 'spellcheck', 'style', 'tabindex', 'target', 'title', 'type', 'translate', 'usemap',
			'value', 'valign', 'width', 'wrap'
		],

		htmlDoNotWrapTags: ['aside', 'script', 'style', 'img', 'bidule'],

		width: '100%',
		height: 'calc(100% - 80px)'		//80, taille de la toolbar par défaut
	};

	this.loadCSS([
		'asset/richedit.css'
	]);
};


Bienvenue.Component.RichEdit.prototype.saveSelection=function() {
	this.editor.froalaEditor('selection.save');
};

Bienvenue.Component.RichEdit.prototype.restoreSelection=function() {
	this.editor.froalaEditor('selection.restore');
};



Bienvenue.Component.RichEdit.prototype.insertHTML=function(html) {
	this.editor.froalaEditor('events.focus');
	this.editor.froalaEditor('html.insert', html);
};



Bienvenue.Component.RichEdit.prototype.initializeFroala=function() {
	$.FroalaEditor.DefineIcon('custom_paragraph', {NAME: 'paragraph'});
	$.FroalaEditor.RegisterCommand('custom_paragraph', {
		title: 'Advanced options',
		type: 'dropdown',
		focus: false,
		undo: false,
		refreshAfterCallback: true,

		/*
		options: {
			'v1': 'Option 1',
			'v2': 'Option 2'
		},
		*/

		html: function() {

			var options=[
				{caption: 'Normal',		tag: 'p',		className:''},
				{caption: 'Titre 1',		tag: 'h1',		className:''},
				{caption: 'Titre 2',		tag: 'h2',		className:''},
				{caption: 'Copyright',		tag: 'p',		className:'copyright'},
				{caption: 'Chapo',		tag: 'p',		className:'chapo'},
			];


			var html='<ul class="fr-dropdown-list">';

			for(var i=0; i<options.length; i++) {
				var option=options[i];

				html+='<li><a class="fr-command" data-cmd="custom_paragraph" data-param1="'+options[i].tag+'" data-param2="'+options[i].className+'" title="Option 1">'+options[i].caption+' </a></li>';
			}

			html+='</ul>';

			return html;
		},



		callback: function (cmd, tag, className) {

			//this.html.insert('Some Custom HTML.');

			this.paragraphFormat.apply(tag);


			var currentParagraph=this.selection.element();
			currentParagraph.className='';
			this.paragraphStyle.apply(className);
		},
		// Callback on refresh.
		refresh: function ($btn) {
			console.log ('do refresh');
		},
		// Callback on dropdown show.
		refreshOnShow: function ($btn, $dropdown) {
			console.log ('do refresh when show');
		}
	});

}




Bienvenue.Component.RichEdit.prototype.renderDemo=function(selector) {

	this.selector=selector;


	if($(selector).length) {

		this.containerElement=$(selector);

		this.initializeFroala();
		this.editor=$(this.selector).froalaEditor(this.defaultOptions);
		this.focus();


		//this.insertHTML('<div style="color:red">hello world</div>');



		return true;
	}
	else {
		return false;
	}
}


Bienvenue.Component.RichEdit.prototype.focus=function() {
	this.editor.froalaEditor('events.focus');
}




















Bienvenue.Module.RichEdit.Dialog=function(content, title)
{

	this.content=content;
	this.title=title;

	this.dialog=$(
		'<div id="complete-dialog" class="modal fade in" tabindex="-1" style="display: block; padding-right: 16px;">'+
			'<div class="modal-dialog">'+
				'<div class="modal-content">'+
					'<div class="modal-header">'+
						'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'+
						'<h4 class="modal-title">'+title+'</h4>'+
					'</div>'+

					'<div class="modal-body">'+
						content+
					'</div>'+
					'<div class="modal-footer">'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>'
	);

	this.dialog.on('hidden.bs.modal', function () {
		this.destroy();
	}.bind(this));
};

Bienvenue.Module.RichEdit.Dialog.prototype.destroy=function() {
	this.dialog.remove();
};



Bienvenue.Module.RichEdit.Dialog.prototype.addButton=function(label, callback) {
	var button=$(
		'<button type="button" class="btn btn-primary" data-dismiss="modal">'+label+'</button>'
	);


	if(callback) {
		button.click(function() {
			callback(this)
		}.bind(this));
	}


	alert(label);

	this.dialog.find('.modal-footer').append(button);
};



Bienvenue.Module.RichEdit.Dialog.prototype.addCancelButton=function(label, callback) {

	if(!label) {
		label= "Annuler";
	}

	alert(3);
	this.addButton(label, callback);

};



Bienvenue.Module.RichEdit.Dialog.prototype.display=function() {
	this.dialog.modal();
};



































