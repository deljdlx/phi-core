Bienvenue.Module.RichEdit=function(workspace, url)
{
	this.__construct(workspace, url);
};






Bienvenue.Module.RichEdit.prototype.run=function() {

	this.loadView('test.html', function(viewData) {

		this.workspace.setMainContent(viewData);

		loadComponent('RichEdit', function() {
			var editor=new Bienvenue.Component.RichEdit();
			editor.renderDemo('.richEdit');
			editor.focus();

		}.bind(this));


		loadComponent('Tree', function() {
			var tree=new Bienvenue.Component.Tree();
			tree.renderAjaxDemo('.leftPanel');

		}.bind(this));



	}.bind(this));
};



//inherit(Bienvenue.Module.RichEdit, Bienvenue.Module);