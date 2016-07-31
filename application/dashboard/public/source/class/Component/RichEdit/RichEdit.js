Bienvenue.Component.RichEdit=function()
{
	this.__construct();
	this.containerElement=null;
	this.selector=null;


	var SaveButton = function (context) {
		var ui = $.summernote.ui;
		// create button
		var button = ui.button({
			contents: '<i class="fa fa-floppy-o"/>',
			tooltip: 'Sauver',
			click: function () {
				// invoke insertText method with 'hello' on editor module.
				context.invoke('editor.insertText', 'hello');
			}
		});
		return button.render();   // return button as jquery object
	}



	this.defaultOptions={
		lang: 'fr-FR',
		height: '500',
		toolbar: [
			// [groupName, [list of button]]
			//['style', ['bold', 'italic', 'underline', 'clear']],
			['object', ['save', 'picture', 'link', 'table', 'hr']],
			['font', ['superscript']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['style', 'ul', 'ol', 'paragraph']],
			//['height', ['height']]
		],
		buttons: {
			save: SaveButton
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

		var height=$('.bienvenue-panel-main').height()-this.toolbar.height()-16;

		$('.note-editable').height(height);

	}

};


Bienvenue.Component.RichEdit.prototype.renderDemo=function(selector) {


	this.selector=selector;
	if($(selector).length) {

		this.containerElement=$(selector);



		//this.toolbarElement=$(this.containerElement).find('.note-toolbar');


		this.defaultOptions.height=$(selector).get(0).offsetHeight;
		this.containerElement.summernote(this.defaultOptions);

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


