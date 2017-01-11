;(function(window) {

	'use strict';

	// taken from mo.js demos
	function isIOSSafari() {
		var userAgent;
		userAgent = window.navigator.userAgent;
		return userAgent.match(/iPad/i) || userAgent.match(/iPhone/i);
	};

	// taken from mo.js demos
	function isTouch() {
		var isIETouch;
		isIETouch = navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0;
		return [].indexOf.call(window, 'ontouchstart') >= 0 || isIETouch;
	};
	
	// taken from mo.js demos
	var isIOS = isIOSSafari(),
		clickHandler = isIOS || isTouch() ? 'touchstart' : 'click';

	function extend( a, b ) {
		for( var key in b ) { 
			if( b.hasOwnProperty( key ) ) {
				a[key] = b[key];
			}
		}
		return a;
	}

	function Animocon(el, options) {
		this.el = el;
		this.options = extend( {}, this.options );
		extend( this.options, options );

		this.checked = false;

		this.timeline = new mojs.Timeline();
		
		for(var i = 0, len = this.options.tweens.length; i < len; ++i) {
			this.timeline.add(this.options.tweens[i]);
		}

		var self = this;
		this.el.addEventListener(clickHandler, function() {
			if( self.checked ) {
				self.options.onUnCheck();
			}
			else {
				self.options.onCheck();
				self.timeline.start();
			}
			self.checked = !self.checked;
		});
	}

	Animocon.prototype.options = {
		tweens : [
			new mojs.Burst({
				shape : 'circle',
				isRunLess: true
			})
		],
		onCheck : function() { return false; },
		onUnCheck : function() { return false; }
	};

	// grid items:
	var items = [].slice.call(document.querySelectorAll('ol.grid > .grid__item'));

	function init() {
	 
		var el7 = items[0].querySelector('button.icobutton'), el7span = el7.querySelector('span');
		new Animocon(el7, {
			tweens : [
				// burst animation
				new mojs.Burst({
					parent: el7,
					duration: 1200,
					delay: 200,
					shape : 'circle',
					fill: '#988ADE',
					x: '50%',
					y: '50%',
					opacity: 0.6,
					childOptions: { radius: {'rand(20,5)':0} },
					radius: {90:150},
					count: 18,
					isSwirl: true,
					swirlSize: 15,
					isRunLess: true,
					easing: mojs.easing.bezier(0.1, 1, 0.3, 1)
				}),
				// ring animation
				new mojs.Transit({
					parent: el7,
					duration: 1500,
					type: 'circle',
					radius: {30: 100},
					fill: 'transparent',
					stroke: '#988ADE',
					strokeWidth: {30:0},
					opacity: 0.6,
					x: '50%',     
					y: '50%',
					isRunLess: true,
					easing: mojs.easing.bezier(0.1, 1, 0.3, 1)
				}),
				new mojs.Transit({
					parent: el7,
					duration: 1600,
					delay: 320,
					type: 'circle',
					radius: {30: 80},
					fill: 'transparent',
					stroke: '#988ADE',
					strokeWidth: {20:0},
					opacity: 0.3,
					x: '50%',     
					y: '50%',
					isRunLess: true,
					easing: mojs.easing.bezier(0.1, 1, 0.3, 1)
				}),
				// icon scale animation
				new mojs.Tween({
					duration : 1000,
					onUpdate: function(progress) {
						if(progress > 0.3) {
							var elasticOutProgress = mojs.easing.elastic.out(1.43*progress-0.43);
							el7span.style.WebkitTransform = el7span.style.transform = 'scale3d(' + elasticOutProgress + ',' + elasticOutProgress + ',1)';
						}
						else {
							el7span.style.WebkitTransform = el7span.style.transform = 'scale3d(0,0,1)';
						}
					}
				})
			],
			onCheck : function() {
				el7.style.color = '#988ADE';
			},
			onUnCheck : function() {
				el7.style.color = '#C0C1C3';	
			}
		});
	 
		 
	}
	
	init();

})(window);