Khi.Router=function()
{
	this.routeCheckInterval=100;

	this.rules={};
	this.rulesArray=[];

	this.requestParameters={};
	this.anchorParameters={};



	this.location=document.location.toString();
	this.lastLocation=null;



	this.addRule('catchAll', function(request) {
		return true;
	}, function(url) {
		console.debug(url);
	})

}



Khi.Router.prototype.run=function() {

	this.routeInterval=setInterval(
		this.check.bind(this),
		this.routeCheckInterval
	);

}




Khi.Router.prototype.getRequest=function() {
	var request=new Khi.Request(this.location);
	return request;
};


Khi.Router.prototype.addRule=function (name, validator, callback) {

	var rule=new Khi.RouterRule(validator, callback);
	this.rules[name]=rule;

	this.rulesArray.unshift(rule);

	return rule;
};






Khi.Router.prototype.check=function() {

	this.location=document.location.toString()

	if(this.location==this.lastLocation) {
		return false;
	};


	this.lastLocation=this.location;

	var request=this.getRequest();

	for(var i=0; i<this.rulesArray.length; i++) {
		if(this.rulesArray[i].check(request)) {
			this.rulesArray[i].execute(request);
			return true;
		}
	}

}

