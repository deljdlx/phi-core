





Bienvenue.Component.RichEdit=function()
{
	this.__construct();
	this.containerElement=null;
	this.selector=null;

	var self=this;


	var HelloButton = function (context) {
		var ui = $.summernote.ui;
		// create button
		var button = ui.button({
			contents: '<i class="fa fa-commenting-o"/>',
			tooltip: 'Hello',
			click: function () {
				// invoke insertText method with 'hello' on editor module.
				context.invoke('editor.insertText', 'hello');
			}
		});
		return button.render();   // return button as jquery object
	}




	var PopupButton = function (context) {
		var ui = $.summernote.ui;
		// create button
		var button = ui.button({
			contents: '<i class="fa fa-floppy-o"/>',
			tooltip: 'Sauver',
			click: function () {

				self.saveRange();

				self.openDialog('<div>Test : <input class="injectContent form-control"/>', 'Test', function() {
					self.insertHTML('<img src="'+$('.injectContent').val()+'"/>');
				})
			}
		});
		return button.render();   // return button as jquery object
	};





	this.defaultOptions={
		lang: 'fr-FR',
		height: '500',




		imageTitle: {
			specificAltField: true,
		},
		popover: {
			image: [
				['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
				['float', ['floatLeft', 'floatRight', 'floatNone']],
				['remove', ['removeMedia']],
				['custom', ['imageTitle']],
			],

			link: [
				['link', ['linkDialogShow', 'unlink']]
			],
		},


		/*
		modules: {
			'foobar': Foobar
		},
		*/




		//styleTags: ['p.copyright', 'blockquote', 'pre'],

		addclass: {
			debug: false,
			classTags: [
				{title:"Normal",value:"normal", tag: 'p'},
				{title:"Copyright",value:"copyright", tag: 'p'},
				{title:"Citation",value:"", tag: 'blockquote'},


				{title:"Titre 1",value:"", tag: 'h1'},
				{title:"Titre 2",value:"", tag: 'h2'},
				{title:"Titre 3",value:"", tag: 'h3'},
				{title:"Titre 4",value:"", tag: 'h4'},
				{title:"Titre 5",value:"", tag: 'h5'},
				{title:"Titre 6",value:"", tag: 'h6'},
			]
		},

		toolbar: [
			// [groupName, [list of button]]
			['style', ['video', 'style', 'addclass', 'bold', 'italic', 'underline', 'clear']],
			['object', ['picture', 'link', 'table', 'hr']],
			['font', ['superscript']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],

			['action', ['fontIcon', 'hello', 'popup', 'codeview']],
			//['height', ['height']]
		],
		buttons: {
			hello: HelloButton,
			popup: PopupButton
		},
		callbacks: {
			onInit: function() {

			}.bind(this)
		}
	};


	this.loadCSS([
		'asset/richedit.css'
	]);
};


Bienvenue.Component.RichEdit.prototype.saveRange=function() {
	this.context.invoke('saveRange');
};

Bienvenue.Component.RichEdit.prototype.restoreRange=function() {
	this.context.invoke('restoreRange');
};



Bienvenue.Component.RichEdit.prototype.insertHTML=function(html) {

	this.restoreRange();
	this.focus();
	this.context.invoke('editor.pasteHTML', html);

};


Bienvenue.Component.RichEdit.prototype.openDialog=function(content, title, validationCallback) {
	var dialog=$(
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


	var validate=$(
		'<button type="button" class="btn btn-primary" data-dismiss="modal">Valider</button>'
	);

	validate.click(function() {
		validationCallback(this)
	}.bind(this));



	var dismiss=$(
		'<button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>'
	);


	dialog.find('.modal-footer').append(validate);
	dialog.find('.modal-footer').append(dismiss);

	dialog.modal();

	dialog.on('hidden.bs.modal', function () {
		//alert(1);
		dialog.remove();
	});



};


Bienvenue.Component.RichEdit.prototype.computeHeight=function() {



	//var toolbar=this.containerElement.parent().find('.note-toolbar');
	//var mainPanel=this.containerElement.parent().find('.bienvenue-panel-main');


	if(!isset(this.toolbar)) {
		this.toolbar=this.containerElement.parent().find('.note-toolbar');
	}
	if(!isset(this.mainPanel)) {
		this.mainPanel=this.containerElement.parent().find('.bienvenue-panel-main');
	}



	if($(this.containerElement).height()+this.toolbar.height()>this.mainPanel.height()) {

		var height=$('.bienvenue-panel-main').height()-this.toolbar.height()-48;
		$('.note-editable').height(height);

	}

};


Bienvenue.Component.RichEdit.prototype.renderDemo=function(selector) {


	this.selector=selector;
	if($(selector).length) {

		this.containerElement=$(selector);



		//this.toolbarElement=$(this.containerElement).find('.note-toolbar');


		this.defaultOptions.height=$(selector).get(0).offsetHeight;




		this.editor=this.containerElement.summernote(this.defaultOptions);
		this.context=this.editor.data('summernote');



		this.adaptHeightInterval=setInterval(function() {
			this.computeHeight();
		}.bind(this), 300);





		return true;
	}
	else {
		return false;
	}
}



Bienvenue.Component.RichEdit.prototype.focus=function() {
	this.containerElement.summernote('focus');
}


