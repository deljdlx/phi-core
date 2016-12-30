Khi.Request=function(url)
{


	this.url=url;
	this.getParameters=this.getRequestParameters(this.url)
	this.anchorParameters=this.getAnchorParameters(this.url);
}





Khi.Request.prototype.getAnchorParameters=function(buffer) {


	var customParameters={};

	if(!buffer.match(/#/)) {
		return customParameters;
	}


	var anchorString=buffer.replace(/.*?#(.*)/g, '$1');
	anchorString=anchorString.replace(/\?/g, '&');
	anchorString=anchorString.replace(/^&/, '');
	var parameterStrings=anchorString.split('&');

	if(parameterStrings.length) {
		for(var i=0; i<parameterStrings.length; i++) {
			var parametersData=parameterStrings[i].split('=');
			var parameterName=parametersData[0];
			var value=parametersData[1];
			customParameters[parameterName]=value;
		}
	}
	return customParameters;
}







Khi.Request.prototype.getRequestParameters=function(buffer) {


	var customParameters={};

	var url=buffer.replace(/(#.*)/g, '');

	if(url.match(/\?/)) {


		var queryString=url.replace(/.*?\?(.*)/, '$1');

		var parameterStrings=queryString.split('&');

		if(parameterStrings.length) {
			for(var i=0; i<parameterStrings.length; i++) {
				var parametersData=parameterStrings[i].split('=');
				var parameterName=parametersData[0];
				var value=parametersData[1];
				customParameters[parameterName]=value;
			}
		}
	}
	return  customParameters;
}

