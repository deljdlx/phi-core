Bienvenue.Module.Blank=function(workspace, url)
{
	this.__construct(workspace, url);
};



Bienvenue.Module.Blank.prototype.run=function() {
	this.workspace.setMainContent('hello world');
};




