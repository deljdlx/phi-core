Bienvenue.Module=function(workspace, url)
{
};




Bienvenue.Module.prototype.__construct=function(workspace, url) {
	this.workspace=workspace;
	this.url=url;
	this.viewFolderName='view';
	this.views={};
}




Bienvenue.Module.prototype.loadView=function(viewName, callback) {

	if(isset(this.views[viewName])) {
		if(isFunction(callback)) {
			callback.call(this, this.views[viewName]);
		}
	}
	else {
		var viewURL=this.loadGetViewURL(viewName);
		this.workspace.ajax({
			url: viewURL,
			success: function(data) {
				this.workspace.log('View "'+viewURL+' loaded');
				this.views[viewName]=data;

				if(isFunction(callback)) {
					callback.call(this, data);
				}
			}.bind(this)
		});

	}

	return this;
};



Bienvenue.Module.prototype.afterRender=function() {
	return this;
};



Bienvenue.Module.prototype.loadGetViewURL=function(viewName) {
	return this.url+'/'+this.viewFolderName+'/'+viewName;

}



