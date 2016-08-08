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

		//styleTags: ['p.copyright', 'blockquote', 'pre'],





		addclass: {
			debug: false,
			//classTags: [{title:"Button",value:"btn btn-success"},"jumbotron", "lead","img-rounded","img-circle", "img-responsive","btn", "btn btn-success","btn btn-danger","text-muted", "text-primary", "text-warning", "text-danger", "text-success", "table-bordered", "table-responsive", "alert", "alert alert-success", "alert alert-info", "alert alert-warning", "alert alert-danger", "visible-sm", "hidden-xs", "hidden-md", "hidden-lg", "hidden-print"]
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
			['style', ['addclass', 'bold', 'italic', 'underline', 'clear']],
			['object', ['picture', 'link', 'table', 'hr']],
			['font', ['superscript']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],

			['action', ['save']],
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


