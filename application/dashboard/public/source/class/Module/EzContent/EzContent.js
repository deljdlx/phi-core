Bienvenue.Module.EzContent=function(workspace, url)
{
	this.__construct(workspace, url);
};



Bienvenue.Module.EzContent.prototype.run=function() {
	this.workspace.setMainContent('Hello world');
};