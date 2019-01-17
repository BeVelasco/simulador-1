/**======================================================================
 * Función Menu principal
 * @author Jaime Vazquez Dic 2018
 * ======================================================================
 */
$(function () {
	//Taken from http://ionden.com/a/plugins/ion.rangeSlider/demo.html
	$(".ion-range").ionRangeSlider({
		skin: "modern",
		min: 0,
		max: 100,
		from_fixed: true,  // fix position of FROM handle
		to_fixed: true,
		min_interval: null,
		max_interval: null,
		onStart: function (data) {
			var id=data.input[0].id;
			var $span=data.slider[0];
			if(data.from<60){
				$($span).find(".irs-single").addClass("red");
				$($span).find(".irs-bar").addClass("red");
			}
			else if(data.from<99){
				$($span).find(".irs-single").addClass("yellow");
				$($span).find(".irs-bar").addClass("yellow");
			}
			else{
				$($span).find(".irs-single").addClass("green");
				$($span).find(".irs-bar").addClass("green");
			}					
				
		},
	});
	
	/*$('.chart').easyPieChart({
		easing: 'easeInOut',
		barColor: function (percent) {
		   return (percent < 50 ? '#ea0d0d' : percent < 99 ? '#ead90d' : '#20b426');
		},
		size: 150,
		scaleLength: 7,
		trackWidth: 5,
		lineWidth: 5,

		onStep: function (from, to, percent) {
		   $(this.el).find('.percent').text(Math.round(percent));
		}
	});
	var chart = window.chart = $('.chart').data('easyPieChart');
	$('.js_update').on('click', function() {
		chart.update(Math.random()*200-100);
	});*/
	$('#waterBall1').createWaterBall({
		csv_config:{
			width:$('#waterBall1').width(),
			height:$('#waterBall1').height()
		},
		wave_config:{
			waveWidth:0.02,
			waveHeight:5
		},
		data_range:[60,99,100],
		textColorRange:['#999','#fff','#fff'],
		targetRange:80
	});
	$('#waterBall2').createWaterBall({
		csv_config:{
			width:$('#waterBall2').width(),
			height:$('#waterBall2').height()
		},
		wave_config:{
			waveWidth:0.02,
			waveHeight:5
		},
		data_range:[60,99,100],
		textColorRange:['#999','#fff','#fff'],
		targetRange:40
	});
	$('#waterBall3').createWaterBall({
		csv_config:{
			width:$('#waterBall3').width(),
			height:$('#waterBall3').height()
		},
		wave_config:{
			waveWidth:0.02,
			waveHeight:5
		},
		data_range:[60,99,100],
		textColorRange:['#999','#fff','#fff'],
		targetRange:100
	});
	
	/* ultimas actividades */
	$(".timeline").timeline({
		data:   [
		{date: new Date(2018,2,12), type: "someType", title: "Registro 1", description: "Registro de datos"},
		{date: new Date(2018,2,15), type: "someType", title: "Registro 2", description: "Registro de datos"},
		{date: new Date(2018,3,5), type: "someType", title: "Registro 3", description: "Registro de datos"},
		{date: new Date(2018,4,2), type: "someType", title: "Registro 4", description: "Registro de datos"},
		{date: new Date(2018,4,9), type: "someType", title: "Registro 5", description: "Registro de datos"},
		{date: new Date(2018,3,23), type: "someType", title: "Registro 6", description: "Registro de datos"},
		{date: new Date(2018,5,20), type: "someType", title: "Registro 7", description: "Registro de datos"}
		],
		height: 600
	});
	
	
});

/* time line */
$.widget('pi.timeline', {
	options: {
		data:   [
		{date: new Date(), type:"Type1", title:"Title1", description:"Description1"},
		{date: new Date(), type:"Type2", title:"Title2", description:"Description2"}
		],
		types:  [
		{name:"Type1", color:"#00ff00"},
		{name:"Type2", color:"#0000ff"}
		],
		display: "auto",
		height: 600
	},
	_create: function(){
		this._refresh();
	},
	_refresh: function(){
		var miliConstant = 86400000
		var firstDate = this.options.data[0].date;
		var lastDate = this.options.data[0].date;
		for (i=0;i<this.options.data.length;i++) {
			if (this.options.data[i].date > lastDate) { lastDate = this.options.data[i].date; }
			else if (this.options.data[i].date < firstDate) { firstDate = this.options.data[i].date; }
		}
		var dayRange = (lastDate - firstDate) / miliConstant;
		var segSpace = Math.floor(this.options.height / (dayRange / 7));
		var segLength = 7;
		if (segSpace < 80) {
			var segSpace = Math.floor(this.options.height / (dayRange / 14));
			segLength = 14;
		}
		if (segSpace < 80) {
			var segSpace = Math.floor(this.options.height / (dayRange / 28));
			segLength = 28;
		}
		if (segSpace < 80) {
			var segSpace = Math.floor(this.options.height / (dayRange / 56));
			segLength = 56;
		}
		if (segSpace < 80) {
			var segSpace = Math.floor(this.options.height / (dayRange / 112));
			segLength = 112;
		}

		var majorCount = Math.floor(this.options.height / segSpace) + 1;

		//Empty Current Element
		this.element.empty();

		//Draw TimeLine
		this.element.append("<div class='tlLine' style='height: " + this.options.height + "px;'></div>")

		//Draw Major Markers
		var tempDate = new Date(firstDate.getTime());
		for (i=0;i<majorCount;i++) {
			this.element.append("<div class='tlMajor' style='top: " + ((segSpace * i) +7) + "px;'></div>");
			this.element.append("<span class='tlDateLabel' style='top: " + ((segSpace * i) +7) + "px;'>" +  $.datepicker.formatDate( "d M y", tempDate) + "</span>");
			tempDate.setDate(tempDate.getDate() + segLength);
		}

		//draw event markers
		for (i=0;i<this.options.data.length;i++) {
			var dayPixels = ((this.options.data[i].date - firstDate) / (lastDate - firstDate)) * this.options.height;
			//alert((this.options.data[i].date - firstDate) + ", " + (lastDate - firstDate) + ", " +dayPixels);
			this.element.append("<div class='tlDateDot' style='top: " + (dayPixels - 0) + "px;'></div>");
			this.element.append("<div class='tlEventFlag' style='height:21px; top: " + (dayPixels - 0) + "px;'>" + this.options.data[i].title + "</div>");
			this.element.append("<div class='tlEventExpand' style='top: " + (dayPixels - 0) + "px;'><p><b>" + this.options.data[i].date + "</b></p><p>" + this.options.data[i].description +  "<p></div>");
		}

		$(".tlEventExpand").hide();

		//$(".tlEventExpand").hide();
		$(".tlEventFlag").click(function(){
		var tempThis = $(this);
		$(".tlEventExpand").hide();
		$(".tlEventFlag").animate({width:'100px'}, 200);
		if (tempThis.hasClass('active')) {
			tempThis.removeClass('active');
		} else {
			$(".tlEventFlag").removeClass('active');
			tempThis.addClass('active');
			tempThis.animate({width:'120px'}, 200, function(){
				tempThis.next('div').show();
			});
		}
		});
	},
	_destroy: function() {},
	_setOptions: function() {}
});
		