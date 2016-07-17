Bienvenue.Component.LeftNavigationBar = React.createClass({

	//displayName: 'TodoApp',

	getInitialState: function getInitialState() {
		return {
			html:''
		};
	},


	tick: function tick() {
		/*
		$.get('source/class/Component/LeftNavigationBar/nav-left.php').done(function(data) {
			//console.debug(data);
			this.setState({
				html: data
			});
			$('#side-menu').metisMenu();
			$.material.init();
			console.debug(this.state)
		}.bind(this));
		*/

	},
	componentWillUnmount: function componentWillUnmount() {
		clearInterval(this.interval);
	},


	componentDidMount: function() {

		//this.interval = setInterval(this.tick, 1000);

		$.get('source/class/Component/LeftNavigationBar/nav-left.php').done(function(data) {
			//console.debug(data);
			this.setState({
				html: data
			});

			$('#side-menu').metisMenu();
			$.material.init();
		}.bind(this));
	},



	onClick: function(event) {
		console.debug(event);
		console.debug(this.state);
	},



	render: function render() {

		//var md = new Remarkable();
		return React.createElement("div", {
			className: "content",
			dangerouslySetInnerHTML: { __html: this.state.html },
			onClick: this.onClick, value: this.state
		})
	}
});
