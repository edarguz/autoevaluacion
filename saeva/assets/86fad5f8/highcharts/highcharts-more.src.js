// ==ClosureCompiler==
// @compilation_level SIMPLE_OPTIMIZATIONS

/**
 * @license Highcharts JS v3.0.6 (2013-10-04)
 *
 * (c) 2009-2013 Torstein Hønsi
 *
 * License: www.highcharts.com/license
 */

// JSLint options:
/*global Highcharts, HighchartsAdapter, document, window, navigator, setInterval, clearInterval, clearTimeout, setTimeout, location, jQuery, $, console */

(function (Highcharts, UNDEFINED) {
var arrayMin = Highcharts.arrayMin,
	arrayMax = Highcharts.arrayMax,
	each = Highcharts.each,
	extend = Highcharts.extend,
	merge = Highcharts.merge,
	map = Highcharts.map,
	pick = Highcharts.pick,
	pInt = Highcharts.pInt,
	defaultPlotOptions = Highcharts.getOptions().plotOptions,
	seriesTypes = Highcharts.seriesTypes,
	extendClass = Highcharts.extendClass,
	splat = Highcharts.splat,
	wrap = Highcharts.wrap,
	Axis = Highcharts.Axis,
	Tick = Highcharts.Tick,
	Series = Highcharts.Series,
	colProto = seriesTypes.column.prototype,
	math = Math,
	mathRound = math.round,
	mathFloor = math.floor,
	mathMax = math.max,
	noop = function () {};/**
 * The Pane object allows options that are common to a set of X and Y axes.
 * 
 * In the future, this can be extended to basic Highcharts and Highstock.
 */
function Pane(options, chart, firstAxis) {
	this.init.call(this, options, chart, firstAxis);
}

// Extend the Pane prototype
extend(Pane.prototype, {
	
	/**
	 * Initiate the Pane object
	 */
	init: function (options, chart, firstAxis) {
		var pane = this,
			backgroundOption,
			defaultOptions = pane.defaultOptions;
		
		pane.chart = chart;
		
		// Set options
		if (chart.angular) { // gauges
			defaultOptions.background = {}; // gets extended by this.defaultBackgroundOptions
		}
		pane.options = options = merge(defaultOptions, options);
		
		backgroundOption = options.background;
		
		// To avoid having weighty logic to place, update and remove the backgrounds,
		// push them to the first axis' plot bands and borrow the existing logic there.
		if (backgroundOption) {
			each([].concat(splat(backgroundOption)).reverse(), function (config) {
				var backgroundColor = config.backgroundColor; // if defined, replace the old one (specific for gradients)
				config = merge(pane.defaultBackgroundOptions, config);
				if (backgroundColor) {
					config.backgroundColor = backgroundColor;
				}
				config.color = config.backgroundColor; // due to naming in plotBands
				firstAxis.options.plotBands.unshift(config);
			});
		}
	},
	
	/**
	 * The default options object
	 */
	defaultOptions: {
		// background: {conditional},
		center: ['50%', '50%'],
		size: '85%',
		startAngle: 0
		//endAngle: startAngle + 360
	},	
	
	/**
	 * The default background options
	 */
	defaultBackgroundOptions: {
		shape: 'circle',
		borderWidth: 1,
		borderColor: 'silver',
		backgroundColor: {
			linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
			stops: [
				[0, '#FFF'],
				[1, '#DDD']
			]
		},
		from: Number.MIN_VALUE, // corrected to axis min
		innerRadius: 0,
		to: Number.MAX_VALUE, // corrected to axis max
		outerRadius: '105%'
	}
	
});
var axisProto = Axis.prototype,
	tickProto = Tick.prototype;
	
/**
 * Augmented methods for the x axis in order to hide it completely, used for the X axis in gauges
 */
var hiddenAxisMixin = {
	getOffset: noop,
	redraw: function () {
		this.isDirty = false; // prevent setting Y axis dirty
	},
	render: function () {
		this.isDirty = false; // prevent setting Y axis dirty
	},
	setScale: noop,
	setCategories: noop,
	setTitle: noop
};

/**
 * Augmented methods for the value axis
 */
/*jslint unparam: true*/
var radialAxisMixin = {
	isRadial: true,
	
	/**
	 * The default options extend defaultYAxisOptions
	 */
	defaultRadialGaugeOptions: {
		labels: {
			align: 'center',
			x: 0,
			y: null // auto
		},
		minorGridLineWidth: 0,
		minorTickInterval: 'auto',
		minorTickLength: 10,
		minorTickPosition: 'inside',
		minorTickWidth: 1,
		plotBands: [],
		tickLength: 10,
		tickPosition: 'inside',
		tickWidth: 2,
		title: {
			rotation: 0
		},
		zIndex: 2 // behind dials, points in the series group
	},
	
	// Circular axis around the perimeter of a polar chart
	defaultRadialXOptions: {
		gridLineWidth: 1, // spokes
		labels: {
			align: null, // auto
			distance: 15,
			x: 0,
			y: null // auto
		},
		maxPadding: 0,
		minPadding: 0,
		plotBands: [],
		showLastLabel: false, 
		tickLength: 0
	},
	
	// Radial axis, like a spoke in a polar chart
	defaultRadialYOptions: {
		gridLineInterpolation: 'circle',
		labels: {
			align: 'right',
			x: -3,
			y: -2
		},
		plotBands: [],
		showLastLabel: false,
		title: {
			x: 4,
			text: null,
			rotation: 90
		}
	},
	
	/**
	 * Merge and set options
	 */
	setOptions: function (userOptions) {
		
		this.options = merge(
			this.defaultOptions,
			this.defaultRadialOptions,
			userOptions
		);
		
	},
	
	/**
	 * Wrap the getOffset method to return zero offset for title or labels in a radial 
	 * axis
	 */
	getOffset: function () {
		// Call the Axis prototype method (the method we're in now is on the instance)
		axisProto.getOffset.call(this);
		
		// Title or label offsets are not counted
		this.chart.axisOffset[this.side] = 0;
	},


	/**
	 * Get the path for the axis line. This method is also referenced in the getPlotLinePath
	 * method.
	 */
	getLinePath: function (lineWidth, radius) {
		var center = this.center;
		radius = pick(radius, center[2] / 2 - this.offset);
		
		return this.chart.renderer.symbols.arc(
			this.left + center[0],
			this.top + center[1],
			radius,
			radius, 
			{
				start: this.startAngleRad,
				end: this.endAngleRad,
				open: true,
				innerR: 0
			}
		);
	},

	/**
	 * Override setAxisTranslation by setting the translation to the difference
	 * in rotation. This allows the translate method to return angle for 
	 * any given value.
	 */
	setAxisTranslation: function () {
		
		// Call uber method		
		axisProto.setAxisTranslation.call(this);
			
		// Set transA and minPixelPadding
		if (this.center) { // it's not defined the first time
			if (this.isCircular) {
				
				this.transA = (this.endAngleRad - this.startAngleRad) / 
					((this.max - this.min) || 1);
					
				
			} else { 
				this.transA = (this.center[2] / 2) / ((this.max - this.min) || 1);
			}
			
			if (this.isXAxis) {
				this.minPixelPadding = this.transA * this.minPointOffset +
					(this.reversed ? (this.endAngleRad - this.startAngleRad) / 4 : 0); // ???
			}
		}
	},
	
	/**
	 * In case of auto connect, add one closestPointRange to the max value right before
	 * tickPositions are computed, so that ticks will extend passed the real max.
	 */
	beforeSetTickPositions: function () {
		if (this.autoConnect) {
			this.max += (this.categories && 1) || this.pointRange || this.closestPointRange || 0; // #1197, #2260
		}
	},
	
	/**
	 * Override the setAxisSize method to use the arc's circumference as length. This
	 * allows tickPixelInterval to apply to pixel lengths along the perimeter
	 */
	setAxisSize: function () {
		
		axisProto.setAxisSize.call(this);

		if (this.isRadial) {

			// Set the center array
			this.center = this.pane.center = seriesTypes.pie.prototype.getCenter.call(this.pane);
			
			this.len = this.width = this.height = this.isCircular ?
				this.center[2] * (this.endAngleRad - this.startAngleRad) / 2 :
				this.center[2] / 2;
		}
	},
	
	/**
	 * Returns the x, y coordinate of a point given by a value and a pixel distance
	 * from center
	 */
	getPosition: function (value, length) {
		if (!this.isCircular) {
			length = this.translate(value);
			value = this.min;	
		}
		
		return this.postTranslate(
			this.translate(value),
			pick(length, this.center[2] / 2) - this.offset
		);		
	},
	
	/**
	 * Translate from intermediate plotX (angle), plotY (axis.len - radius) to final chart coordinates. 
	 */
	postTranslate: function (angle, radius) {
		
		var chart = this.chart,
			center = this.center;
			
		angle = this.startAngleRad + angle;
		
		return {
			x: chart.plotLeft + center[0] + Math.cos(angle) * radius,
			y: chart.plotTop + center[1] + Math.sin(angle) * radius
		}; 
		
	},
	
	/**
	 * Find the path for plot bands along the radial axis
	 */
	getPlotBandPath: function (from, to, options) {
		var center = this.center,
			startAngleRad = this.startAngleRad,
			fullRadius = center[2] / 2,
			radii = [
				pick(options.outerRadius, '100%'),
				options.innerRadius,
				pick(options.thickness, 10)
			],
			percentRegex = /%$/,
			start,
			end,
			open,
			isCircular = this.isCircular, // X axis in a polar chart
			ret;
			
		// Polygonal plot bands
		if (this.options.gridLineInterpolation === 'polygon') {
			ret = this.getPlotLinePath(from).concat(this.getPlotLinePath(to, true));
		
		// Circular grid bands
		} else {
			
			// Plot bands on Y axis (radial axis) - inner and outer radius depend on to and from
			if (!isCircular) {
				radii[0] = this.translate(from);
				radii[1] = this.translate(to);
			}
			
			// Convert percentages to pixel values
			radii = map(radii, function (radius) {
				if (percentRegex.test(radius)) {
					radius = (pInt(radius, 10) * fullRadius) / 100;
				}
				return radius;
			});
			
			// Handle full circle
			if (options.shape === 'circle' || !isCircular) {
				start = -Math.PI / 2;
				end = Math.PI * 1.5;
				open = true;
			} else {
				start = startAngleRad + this.translate(from);
				end = startAngleRad + this.translate(to);
			}
		
		
			ret = this.chart.renderer.symbols.arc(
				this.left + center[0],
				this.top + center[1],
				radii[0],
				radii[0],
				{
					start: start,
					end: end,
					innerR: pick(radii[1], radii[0] - radii[2]),
					open: open
				}
			);
		}
		 
		return ret;
	},
	
	/**
	 * Find the path for plot lines perpendicular to the radial axis.
	 */
	getPlotLinePath: function (value, reverse) {
		var axis = this,
			center = axis.center,
			chart = axis.chart,
			end = axis.getPosition(value),
			xAxis,
			xy,
			tickPositions,
			ret;
		
		// Spokes
		if (axis.isCircular) {
			ret = ['M', center[0] + chart.plotLeft, center[1] + chart.plotTop, 'L', end.x, end.y];
		
		// Concentric circles			
		} else if (axis.options.gridLineInterpolation === 'circle') {
			value = axis.translate(value);
			if (value) { // a value of 0 is in the center
				ret = axis.getLinePath(0, value);
			}
		// Concentric polygons 
		} else {
			xAxis = chart.xAxis[0];
			ret = [];
			value = axis.translate(value);
			tickPositions = xAxis.tickPositions;
			if (xAxis.autoConnect) {
				tickPositions = tickPositions.concat([tickPositions[0]]);
			}
			// Reverse the positions for concatenation of polygonal plot bands
			if (reverse) {
				tickPositions = [].concat(tickPositions).reverse();
			}
				
			each(tickPositions, function (pos, i) {
				xy = xAxis.getPosition(pos, value);
				ret.push(i ? 'L' : 'M', xy.x, xy.y);
			});
			
		}
		return ret;
	},
	
	/**
	 * Find the position for the axis title, by default inside the gauge
	 */
	getTitlePosition: function () {
		var center = this.center,
			chart = this.chart,
			titleOptions = this.options.title;
		
		return { 
			x: chart.plotLeft + center[0] + (titleOptions.x || 0), 
			y: chart.plotTop + center[1] - ({ high: 0.5, middle: 0.25, low: 0 }[titleOptions.align] * 
				center[2]) + (titleOptions.y || 0)  
		};
	}
	
};
/*jslint unparam: false*/

/**
 * Override axisProto.init to mix in special axis instance functions and function overrides
 */
wrap(axisProto, 'init', function (proceed, chart, userOptions) {
	var axis = this,
		angular = chart.angular,
		polar = chart.polar,
		isX = userOptions.isX,
		isHidden = angular && isX,
		isCircular,
		startAngleRad,
		endAngleRad,
		options,
		chartOptions = chart.options,
		paneIndex = userOptions.pane || 0,
		pane,
		paneOptions;
		
	// Before prototype.init
	if (angular) {
		extend(this, isHidden ? hiddenAxisMixin : radialAxisMixin);
		isCircular =  !isX;
		if (isCircular) {
			this.defaultRadialOptions = this.defaultRadialGaugeOptions;
		}
		
	} else if (polar) {
		//extend(this, userOptions.isX ? radialAxisMixin : radialAxisMixin);
		extend(this, radialAxisMixin);
		isCircular = isX;
		this.defaultRadialOptions = isX ? this.defaultRadialXOptions : merge(this.defaultYAxisOptions, this.defaultRadialYOptions);
		
	}
	
	// Run prototype.init
	proceed.call(this, chart, userOptions);
	
	if (!isHidden && (angular || polar)) {
		options = this.options;
		
		// Create the pane and set the pane options.
		if (!chart.panes) {
			chart.panes = [];
		}
		this.pane = pane = chart.panes[paneIndex] = chart.panes[paneIndex] || new Pane(
			splat(chartOptions.pane)[paneIndex],
			chart,
			axis
		);
		paneOptions = pane.options;
		
			
		// Disable certain features on angular and polar axes
		chart.inverted = false;
		chartOptions.chart.zoomType = null;
		
		// Start and end angle options are
		// given in degrees relative to top, while internal computations are
		// in radians relative to right (like SVG).
		this.startAngleRad = startAngleRad = (paneOptions.startAngle - 90) * Math.PI / 180;
		this.endAngleRad = endAngleRad = (pick(paneOptions.endAngle, paneOptions.startAngle + 360)  - 90) * Math.PI / 180;
		this.offset = options.offset || 0;
		
		this.isCircular = isCircular;
		
		// Automatically connect grid lines?
		if (isCircular && userOptions.max === UNDEFINED && endAngleRad - startAngleRad === 2 * Math.PI) {
			this.autoConnect = true;
		}
	}
	
});

/**
 * Add special cases within the Tick class' methods for radial axes.
 */	
wrap(tickProto, 'getPosition', function (proceed, horiz, pos, tickmarkOffset, old) {
	var axis = this.axis;
	
	return axis.getPosition ? 
		axis.getPosition(pos) :
		proceed.call(this, horiz, pos, tickmarkOffset, old);	
});

/**
 * Wrap the getLabelPosition function to find the center position of the label
 * based on the distance option
 */	
wrap(tickProto, 'getLabelPosition', function (proceed, x, y, label, horiz, labelOptions, tickmarkOffset, index, step) {
	var axis = this.axis,
		optionsY = labelOptions.y,
		ret,
		align = labelOptions.align,
		angle = ((axis.translate(this.pos) + axis.startAngleRad + Math.PI / 2) / Math.PI * 180) % 360;
	
	if (axis.isRadial) {
		ret = axis.getPosition(this.pos, (axis.center[2] / 2) + pick(labelOptions.distance, -25));
		
		// Automatically rotated
		if (labelOptions.rotation === 'auto') {
			label.attr({ 
				rotation: angle
			});
		
		// Vertically centered
		} else if (optionsY === null) {
			optionsY = pInt(label.styles.lineHeight) * 0.9 - label.getBBox().height / 2;
		
		}
		
		// Automatic alignment
		if (align === null) {
			if (axis.isCircular) {
				if (angle > 20 && angle < 160) {
					align = 'left'; // right hemisphere
				} else if (angle > 200 && angle < 340) {
					align = 'right'; // left hemisphere
				} else {
					align = 'center'; // top or bottom
				}
			} else {
				align = 'center';
			}
			label.attr({
				align: align
			});
		}
		
		ret.x += labelOptions.x;
		ret.y += optionsY;
		
	} else {
		ret = proceed.call(this, x, y, label, horiz, labelOptions, tickmarkOffset, index, step);
	}
	return ret;
});

/**
 * Wrap the getMarkPath function to return the path of the radial marker
 */
wrap(tickProto, 'getMarkPath', function (proceed, x, y, tickLength, tickWidth, horiz, renderer) {
	var axis = this.axis,
		endPoint,
		ret;
		
	if (axis.isRadial) {
		endPoint = axis.getPosition(this.pos, axis.center[2] / 2 + tickLength);
		ret = [
			'M',
			x,
			y,
			'L',
			endPoint.x,
			endPoint.y
		];
	} else {
		ret = proceed.call(this, x, y, tickLength, tickWidth, horiz, renderer);
	}
	return ret;
});/* 
 * The AreaRangeSeries class
 * 
 */

/**
 * Extend the default options with map options
 */
defaultPlotOptions.arearange = merge(defaultPlotOptions.area, {
	lineWidth: 1,
	marker: null,
	threshold: null,
	tooltip: {
		pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.low}</b> - <b>{point.high}</b><br/>' 
	},
	trackByArea: true,
	dataLabels: {
		verticalAlign: null,
		xLow: 0,
		xHigh: 0,
		yLow: 0,
		yHigh: 0	
	}
});

/**
 * Add the series type
 */
seriesTypes.arearange = Highcharts.extendClass(seriesTypes.area, {
	type: 'arearange',
	pointArrayMap: ['low', 'high'],
	toYData: function (point) {
		return [point.low, point.high];
	},
	pointValKey: 'low',
	
	/**
	 * Extend getSegments to force null points if the higher value is null. #1703.
	 */
	getSegments: function () {
		var series = this;

		each(series.points, function (point) {
			if (!series.options.connectNulls && (point.low === null || point.high === null)) {
				point.y = null;
			} else if (point.low === null && point.high !== null) {
				point.y = point.high;
			}
		});
		Series.prototype.getSegments.call(this);
	},
	
	/**
	 * Translate data points from raw values x and y to plotX and plotY
	 */
	translate: function () {
		var series = this,
			yAxis = series.yAxis;

		seriesTypes.area.prototype.translate.apply(series);

		// Set plotLow and plotHigh
		each(series.points, function (point) {

			var low = point.low,
				high = point.high,
				plotY = point.plotY;

			if (high === null && low === null) {
				point.y = null;
			} else if (low === null) {
				point.plotLow = point.plotY = null;
				point.plotHigh = yAxis.translate(high, 0, 1, 0, 1);
			} else if (high === null) {
				point.plotLow = plotY;
				point.plotHigh = null;
			} else {
				point.plotLow = plotY;
				point.plotHigh = yAxis.translate(high, 0, 1, 0, 1);
			}
		});
	},
	
	/**
	 * Extend the line series' getSegmentPath method by applying the segment
	 * path to both lower and higher values of the range
	 */
	getSegmentPath: function (segment) {
		
		var lowSegment,
			highSegment = [],
			i = segment.length,
			baseGetSegmentPath = Series.prototype.getSegmentPath,
			point,
			linePath,
			lowerPath,
			options = this.options,
			step = options.step,
			higherPath;
			
		// Remove nulls from low segment
		lowSegment = HighchartsAdapter.grep(segment, function (point) {
			return point.plotLow !== null;
		});
		
		// Make a segment with plotX and plotY for the top values
		while (i--) {
			point = segment[i];
			if (point.plotHigh !== null) {
				highSegment.push({
					plotX: point.plotX,
					plotY: point.plotHigh
				});
			}
		}
		
		// Get the paths
		lowerPath = baseGetSegmentPath.call(this, lowSegment);
		if (step) {
			if (step === true) {
				step = 'left';
			}
			options.step = { left: 'right', center: 'center', right: 'left' }[step]; // swap for reading in getSegmentPath
		}
		higherPath = baseGetSegmentPath.call(this, highSegment);
		options.step = step;
		
		// Create a line on both top and bottom of the range
		linePath = [].concat(lowerPath, higherPath);
		
		// For the area path, we need to change the 'move' statement into 'lineTo' or 'curveTo'
		higherPath[0] = 'L'; // this probably doesn't work for spline			
		this.areaPath = this.areaPath.concat(lowerPath, higherPath);
		
		return linePath;
	},
	
	/**
	 * Extend the basic drawDataLabels method by running it for both lower and higher
	 * values.
	 */
	drawDataLabels: function () {
		
		var data = this.data,
			length = data.length,
			i,
			originalDataLabels = [],
			seriesProto = Series.prototype,
			dataLabelOptions = this.options.dataLabels,
			point,
			inverted = this.chart.inverted;
			
		if (dataLabelOptions.enabled || this._hasPointLabels) {
			
			// Step 1: set preliminary values for plotY and dataLabel and draw the upper labels
			i = length;
			while (i--) {
				point = data[i];
				
				// Set preliminary values
				point.y = point.high;
				point.plotY = point.plotHigh;
				
				// Store original data labels and set preliminary label objects to be picked up 
				// in the uber method
				originalDataLabels[i] = point.dataLabel;
				point.dataLabel = point.dataLabelUpper;
				
				// Set the default offset
				point.below = false;
				if (inverted) {
					dataLabelOptions.align = 'left';
					dataLabelOptions.x = dataLabelOptions.xHigh;								
				} else {
					dataLabelOptions.y = dataLabelOptions.yHigh;
				}
			}
			seriesProto.drawDataLabels.apply(this, arguments); // #1209
			
			// Step 2: reorganize and handle data labels for the lower values
			i = length;
			while (i--) {
				point = data[i];
				
				// Move the generated labels from step 1, and reassign the original data labels
				point.dataLabelUpper = point.dataLabel;
				point.dataLabel = originalDataLabels[i];
				
				// Reset values
				point.y = point.low;
				point.plotY = point.plotLow;
				
				// Set the default offset
				point.below = true;
				if (inverted) {
					dataLabelOptions.align = 'right';
					dataLabelOptions.x = dataLabelOptions.xLow;
				} else {
					dataLabelOptions.y = dataLabelOptions.yLow;
				}
			}
			seriesProto.drawDataLabels.apply(this, arguments);
		}
	
	},
	
	alignDataLabel: seriesTypes.column.prototype.alignDataLabel,
	
	getSymbol: seriesTypes.column.prototype.getSymbol,
	
	drawPoints: noop
});/**
 * The AreaSplineRangeSeries class
 */

defaultPlotOptions.areasplinerange = merge(defaultPlotOptions.arearange);

/**
 * AreaSplineRangeSeries object
 */
seriesTypes.areasplinerange = extendClass(seriesTypes.arearange, {
	type: 'areasplinerange',
	getPointSpline: seriesTypes.spline.prototype.getPointSpline
});/**
 * The ColumnRangeSeries class
 */
defaultPlotOptions.columnrange = merge(defaultPlotOptions.column, defaultPlotOptions.arearange, {
	lineWidth: 1,
	pointRange: null
});

/**
 * ColumnRangeSeries object
 */
seriesTypes.columnrange = extendClass(seriesTypes.arearange, {
	type: 'columnrange',
	/**
	 * Translate data points from raw values x and y to plotX and plotY
	 */
	translate: function () {
		var series = this,
			yAxis = series.yAxis,
			plotHigh;

		colProto.translate.apply(series);

		// Set plotLow and plotHigh
		each(series.points, function (point) {
			var shapeArgs = point.shapeArgs,
				minPointLength = series.options.minPointLength,
				heightDifference,
				height,
				y;

			point.plotHigh = plotHigh = yAxis.translate(point.high, 0, 1, 0, 1);
			point.plotLow = point.plotY;

			// adjust shape
			y = plotHigh;
			height = point.plotY - plotHigh;

			if (height < minPointLength) {
				heightDifference = (minPointLength - height);
				height += heightDifference;
				y -= heightDifference / 2;
			}
			shapeArgs.height = height;
			shapeArgs.y = y;
		});
	},
	trackerGroups: ['group', 'dataLabels'],
	drawGraph: noop,
	pointAttrToOptions: colProto.pointAttrToOptions,
	drawPoints: colProto.drawPoints,
	drawTracker: colProto.drawTracker,
	animate: colProto.animate,
	getColumnMetrics: colProto.getColumnMetrics
});
/* 
 * The GaugeSeries class
 */



/**
 * Extend the default options
 */
defaultPlotOptions.gauge = merge(defaultPlotOptions.line, {
	dataLabels: {
		enabled: true,
		y: 15,
		borderWidth: 1,
		borderColor: 'silver',
		borderRadius: 3,
		style: {
			fontWeight: 'bold'
		},
		verticalAlign: 'top',
		zIndex: 2
	},
	dial: {
		// radius: '80%',
		// backgroundColor: 'black',
		// borderColor: 'silver',
		// borderWidth: 0,
		// baseWidth: 3,
		// topWidth: 1,
		// baseLength: '70%' // of radius
		// rearLength: '10%'
	},
	pivot: {
		//radius: 5,
		//borderWidth: 0
		//borderColor: 'silver',
		//backgroundColor: 'black'
	},
	tooltip: {
		headerFormat: ''
	},
	showInLegend: false
});

/**
 * Extend the point object
 */
var GaugePoint = Highcharts.extendClass(Highcharts.Point, {
	/**
	 * Don't do any hover colors or anything
	 */
	setState: function (state) {
		this.state = state;
	}
});


/**
 * Add the series type
 */
var GaugeSeries = {
	type: 'gauge',
	pointClass: GaugePoint,
	
	// chart.angular will be set to true when a gauge series is present, and this will
	// be used on the axes
	angular: true, 
	drawGraph: noop,
	fixedBox: true,
	trackerGroups: ['group', 'dataLabels'],
	
	/**
	 * Calculate paths etc
	 */
	translate: function () {
		
		var series = this,
			yAxis = series.yAxis,
			options = series.options,
			center = yAxis.center;
			
		series.generatePoints();
		
		each(series.points, function (point) {
			
			var dialOptions = merge(options.dial, point.dial),
				radius = (pInt(pick(dialOptions.radius, 80)) * center[2]) / 200,
				baseLength = (pInt(pick(dialOptions.baseLength, 70)) * radius) / 100,
				rearLength = (pInt(pick(dialOptions.rearLength, 10)) * radius) / 100,
				baseWidth = dialOptions.baseWidth || 3,
				topWidth = dialOptions.topWidth || 1,
				rotation = yAxis.startAngleRad + yAxis.translate(point.y, null, null, null, true);

			// Handle the wrap option
			if (options.wrap === false) {
				rotation = Math.max(yAxis.startAngleRad, Math.min(yAxis.endAngleRad, rotation));
			}
			rotation = rotation * 180 / Math.PI;
				
			point.shapeType = 'path';
			point.shapeArgs = {
				d: dialOptions.path || [
					'M', 
					-rearLength, -baseWidth / 2, 
					'L', 
					baseLength, -baseWidth / 2,
					radius, -topWidth / 2,
					radius, topWidth / 2,
					baseLength, baseWidth / 2,
					-rearLength, baseWidth / 2,
					'z'
				],
				translateX: center[0],
				translateY: center[1],
				rotation: rotation
			};
			
			// Positions for data label
			point.plotX = center[0];
			point.plotY = center[1];
		});
	},
	
	/**
	 * Draw the points where each point is one needle
	 */
	drawPoints: function () {
		
		var series = this,
			center = series.yAxis.center,
			pivot = series.pivot,
			options = series.options,
			pivotOptions = options.pivot,
			renderer = series.chart.renderer;
		
		each(series.points, function (point) {
			
			var graphic = point.graphic,
				shapeArgs = point.shapeArgs,
				d = shapeArgs.d,
				dialOptions = merge(options.dial, point.dial); // #1233
			
			if (graphic) {
				graphic.animate(shapeArgs);
				shapeArgs.d = d; // animate alters it
			} else {
				point.graphic = renderer[point.shapeType](shapeArgs)
					.attr({
						stroke: dialOptions.borderColor || 'none',
						'stroke-width': dialOptions.borderWidth || 0,
						fill: dialOptions.backgroundColor || 'black',
						rotation: shapeArgs.rotation // required by VML when animation is false
					})
					.add(series.group);
			}
		});
		
		// Add or move the pivot
		if (pivot) {
			pivot.animate({ // #1235
				translateX: center[0],
				translateY: center[1]
			});
		} else {
			series.pivot = renderer.circle(0, 0, pick(pivotOptions.radius, 5))
				.attr({
					'stroke-width': pivotOptions.borderWidth || 0,
					stroke: pivotOptions.borderColor || 'silver',
					fill: pivotOptions.backgroundColor || 'black'
				})
				.translate(center[0], center[1])
				.add(series.group);
		}
	},
	
	/**
	 * Animate the arrow up from startAngle
	 */
	animate: function (init) {
		var series = this;

		if (!init) {
			each(series.points, function (point) {
				var graphic = point.graphic;

				if (graphic) {
					// start value
					graphic.attr({
						rotation: series.yAxis.startAngleRad * 180 / Math.PI
					});

					// animate
					graphic.animate({
						rotation: point.shapeArgs.rotation
					}, series.options.animation);
				}
			});

			// delete this function to allow it only once
			series.animate = null;
		}
	},
	
	render: function () {
		this.group = this.plotGroup(
			'group', 
			'series', 
			this.visible ? 'visible' : 'hidden', 
			this.options.zIndex, 
			this.chart.seriesGroup
		);
		seriesTypes.pie.prototype.render.call(this);
		this.group.clip(this.chart.clipRect);
	},
	
	setData: seriesTypes.pie.prototype.setData,
	drawTracker: seriesTypes.column.prototype.drawTracker
};
seriesTypes.gauge = Highcharts.extendClass(seriesTypes.line, GaugeSeries);/* ****************************************************************************
 * Start Box plot series code											      *
 *****************************************************************************/

// Set default options
defaultPlotOptions.boxplot = merge(defaultPlotOptions.column, {
	fillColor: '#FFFFFF',
	lineWidth: 1,
	//medianColor: null,
	medianWidth: 2,
	states: {
		hover: {
			brightness: -0.3
		}
	},
	//stemColor: null,
	//stemDashStyle: 'solid'
	//stemWidth: null,
	threshold: null,
	tooltip: {
		pointFormat: '<span style="color:{series.color};font-weight:bold">{series.name}</span><br/>' +
			'Maximum: {point.high}<br/>' +
			'Upper quartile: {point.q3}<br/>' +
			'Median: {point.median}<br/>' +
			'Lower quartile: {point.q1}<br/>' +
			'Minimum: {point.low}<br/>'
			
	},
	//whiskerColor: null,
	whiskerLength: '50%',
	whiskerWidth: 2
});

// Create the series object
seriesTypes.boxplot = extendClass(seriesTypes.column, {
	type: 'boxplot',
	pointArrayMap: ['low', 'q1', 'median', 'q3', 'high'], // array point configs are mapped to this
	toYData: function (point) { // return a plain array for speedy calculation
		return [point.low, point.q1, point.median, point.q3, point.high];
	},
	pointValKey: 'high', // defines the top of the tracker
	
	/**
	 * One-to-one mapping from options to SVG attributes
	 */
	pointAttrToOptions: { // mapping between SVG attributes and the corresponding options
		fill: 'fillColor',
		stroke: 'color',
		'stroke-width': 'lineWidth'
	},
	
	/**
	 * Disable data labels for box plot
	 */
	drawDataLabels: noop,

	/**
	 * Translate data points from raw values x and y to plotX and plotY
	 */
	translate: function () {
		var series = this,
			yAxis = series.yAxis,
			pointArrayMap = series.pointArrayMap;

		seriesTypes.column.prototype.translate.apply(series);

		// do the translation on each point dimension
		each(series.points, function (point) {
			each(pointArrayMap, function (key) {
				if (point[key] !== null) {
					point[key + 'Plot'] = yAxis.translate(point[key], 0, 1, 0, 1);
				}
			});
		});
	},

	/**
	 * Draw the data points
	 */
	drawPoints: function () {
		var series = this,  //state = series.state,
			points = series.points,
			options = series.options,
			chart = series.chart,
			renderer = chart.renderer,
			pointAttr,
			q1Plot,
			q3Plot,
			highPlot,
			lowPlot,
			medianPlot,
			crispCorr,
			crispX,
			graphic,
			stemPath,
			stemAttr,
			boxPath,
			whiskersPath,
			whiskersAttr,
			medianPath,
			medianAttr,
			width,
			left,
			right,
			halfWidth,
			shapeArgs,
			color,
			doQuartiles = series.doQuartiles !== false, // error bar inherits this series type but doesn't do quartiles
			whiskerLength = parseInt(series.options.whiskerLength, 10) / 100;


		each(points, function (point) {

			graphic = point.graphic;
			shapeArgs = point.shapeArgs; // the box
			stemAttr = {};
			whiskersAttr = {};
			medianAttr = {};
			color = point.color || series.color;
			
			if (point.plotY !== UNDEFINED) {

				pointAttr = point.pointAttr[point.selected ? 'selected' : ''];

				// crisp vector coordinates
				width = shapeArgs.width;
				left = mathFloor(shapeArgs.x);
				right = left + width;
				halfWidth = mathRound(width / 2);
				//crispX = mathRound(left + halfWidth) + crispCorr;
				q1Plot = mathFloor(doQuartiles ? point.q1Plot : point.lowPlot);// + crispCorr;
				q3Plot = mathFloor(doQuartiles ? point.q3Plot : point.lowPlot);// + crispCorr;
				highPlot = mathFloor(point.highPlot);// + crispCorr;
				lowPlot = mathFloor(point.lowPlot);// + crispCorr;
				
				// Stem attributes
				stemAttr.stroke = point.stemColor || options.stemColor || color;
				stemAttr['stroke-width'] = pick(point.stemWidth, options.stemWidth, options.lineWidth);
				stemAttr.dashstyle = point.stemDashStyle || options.stemDashStyle;
				
				// Whiskers attributes
				whiskersAttr.stroke = point.whiskerColor || options.whiskerColor || color;
				whiskersAttr['stroke-width'] = pick(point.whiskerWidth, options.whiskerWidth, options.lineWidth);
				
				// Median attributes
				medianAttr.stroke = point.medianColor || options.medianColor || color;
				medianAttr['stroke-width'] = pick(point.medianWidth, options.medianWidth, options.lineWidth);
				
				
				// The stem
				crispCorr = (stemAttr['stroke-width'] % 2) / 2;
				crispX = left + halfWidth + crispCorr;				
				stemPath = [
					// stem up
					'M',
					crispX, q3Plot,
					'L',
					crispX, highPlot,
					
					// stem down
					'M',
					crispX, q1Plot,
					'L',
					crispX, lowPlot,
					'z'
				];
				
				// The box
				if (doQuartiles) {
					crispCorr = (pointAttr['stroke-width'] % 2) / 2;
					crispX = mathFloor(crispX) + crispCorr;
					q1Plot = mathFloor(q1Plot) + crispCorr;
					q3Plot = mathFloor(q3Plot) + crispCorr;
					left += crispCorr;
					right += crispCorr;
					boxPath = [
						'M',
						left, q3Plot,
						'L',
						left, q1Plot,
						'L',
						right, q1Plot,
						'L',
						right, q3Plot,
						'L',
						left, q3Plot,
						'z'
					];
				}
				
				// The whiskers
				if (whiskerLength) {
					crispCorr = (whiskersAttr['stroke-width'] % 2) / 2;
					highPlot = highPlot + crispCorr;
					lowPlot = lowPlot + crispCorr;
					whiskersPath = [
						// High whisker
						'M',
						crispX - halfWidth * whiskerLength, 
						iighPlot,
						'L',
					)crhs�X!+$halfWidth * vhisoerLength, 
					high�lgt$�	��						I	/ Lw wh)sker
	I			&M'<)	�			csi{pX -0halfWhdph0* whiskazLenGth,$
					lowPdot.
				'L',	) �#rispX +�halfWidth * whiSierLen��h( 
				l/wPlot
				];				}
				
	/o Uhe medhan
				sRiwpCorr = (medianAetr�'wTRoke�widtx'] % 2) /`2;			
				MedianPlot =�mathRound(PoiNumedicnPlmt	!* crispCors;
	I		med)anPatj$= [
				gM',
			�	left,!
)	medianPlmt,
			+	'L'(
�				raghr� 		5edialPlot(
					'3'
			]8
		)	
			// Srecte o2 qpdate$thu`graphics
				af ,gR)phkc) {0+/ updAte
			�	
	)			roi�tsteM.animatg({ e: stemPaTh })3			if (w|isker\e~gth) {
						point>whisj�rs.qnieqte({��: �has�ErsPa�h }-;
�			)y
					if (doQuartileS) {
					point.bgy&ankoate(� d: boxP�$h"!;
)				]
		I		pointm�diinShaPg.animate({$D: medianPath )?�				
		I)} }lsd k / crdq6o��m
					@oi~t&gzaphic = graphkg  fendebeR.f*)
					.add(kerieS.g�otp){
				
			toint.weel = randerer/xat�(staoPa4(�				.`tt"(steeAtts)	�I	I.abd(frephac);
					
					if (whaskezDEngth)�z
)�				poi~d.wh)ske2s = r%nderer.p�th(w�is�evSPAt�)
						.iTt�(whisker{Attr�*							.adl grapHic9;
		K	y
					yd0(doqqartimdw- {				pmi.t.box = re�derep?Path(boxP�th)
	�				>attr(poIftAvtr)
�						,id$(grap`Ic);
					}	
			pohfd.m�dmanShape"= renderer.pat9 mediqn�ath!
				.qt4r(mefianAt4r)
	�				.add(eraphma)+
		}			}
		u)?
	}J�
m);
 g* ***�******;j*b*******(*"+******8***.****
*******�******(****+************:*
 * Eld Bop(plot serye{0c`eI									*
 :(***********+**�****(j*j*�*******&***.*
"************j*****j**N**:**�****+**'
/*"*******
*****�*****.*
*(********(****"***.j.*.�*:*�********Jk****(****�
*(**
 * [tapt errmr bar!ser�ts Smde( `  �  )      "   (,     �*   %$0      0   "  *
 **
********.**�**��*.***+.**.***j********.***********
*�*�***.****:**********/

/ 1 - {ut defa}l| opt)on;
defkultPhotOptions.errovbaz = merge(defquluTmodOptionq.fpplot.0{	color: g# 00004#,
g�oupinG8 f!Lse,
linke�\o: '2pzevious',
	too)tkp: {
		poaNuFOvmat8 defag,tPlmtMrpiofs.crea2`�oe.4ooltip.tOiNtFkrmatJ	},)5his+erWietH: juml
});
//02 � C2e�te!the se�ie" bbect
serimsPxpes*grrorbas =extEldGlArs(SerYesPypus.bopplot, {
	ty�e; '%prOsbar',
	aoindA2rqYM`p: Y'|ow, 'hIgh'],(// ar*!y0pgint�confiws e2G �appgd 4o tjis
	toYData:$fu~�thon!(pOint) {#// re|u�la plaif afraq!dor {peedy cilc}�ation
	�eturf$Zpoint.no, point.h�ghU+
	u,
	POI.tValKeq:!'hioh', /? defijes th'0top!of vje tzac{mr	eoPucbpiles:falsu,
�?**
	 * Ge} tie w!dth0!nd X nfnsat, either on0dop of the linked$su69ey columf
	 * ov sta�dalgne
	 */
	g%|COlwmn]Etribs: fu�Ctinn () {		re4�r.((thir&li�kedParent!&& vhhr.lifaedrarant/cnlumnMevr-sS) ||�
		wdrlesTypE�/column�prototype.g%tColumnMetrics.sqll(this);	|
});
/* ******j*:*******(**********:
***
*+********:***j(*****:*****�(************(* *
Enf mrrz0bav seriec kode  "    �    !! !"         �   0$$               �* ******j****�+****"****�*.*******j**"2**.*******+*:****h*
.*"**"*�***:********/
.* **:***(.:***(
*****+*++*(**j**�******J********j*****�(**b*
***********"***** j �t`bt Water"anl�Ser)eq�cod� ( $    $0   "                      �  ��     � *
 *******+*******j**
*(zj�****
****(*****
*:****(*********************"**:*j.*/

+/ 1 - set devAwlt option3defAultPd|Kqli�nslwaterf�Ln = merge*defauluPlotOptiOnq.o/ltmn< {�	dineWydth2 1,
	lineolor: '#33',
	tashStYle:�'dod',)bwpderCm<�r:"'#733
}):

/- 2"- Cpe!te$t(e serims oBnectJser)esyxe{.uaterFall$= m8tenfSlQss(7erieqtypes.column( [
	type: �watervahl',

	}pGolmrProp� 'filh# 

	po	ntCrsiym!p: ['low' '1'},

|o�ntValKey> 'Y'��
�**
	 * Init!7eh�rfqll serhesl for�e stickinw
	 */
	hnit: funct�on`(khart, mptmons) {
	o/ force cTqcking
		opvi�ns>qtacking <(tpwe;
		sdrIes\ytes.clum~�protO|ype*mnit.caln(this, Cjagt�"ortions);
	},
	
	/**
 * TrAowlave fita pin4s from ra70values
	 ./
)transla|e2 �unction`() {
	Varseri�q } this.
		opt)ons < {e�ieS*oQtions,
	C	axIs)} sevims.9A|is,�	I	xeb,
		h,
			poifts-
�pgiNd,
			sh`eA�'sl
		{vC"c,�		y,
	)	prevIoUsY,			stackRoint
			thb�sh/ld  optinns.thresxold,
			criwxCorr =!(opti'n�.jozd�vWhtth % 2) / 7;
)	+? rujdcolumf0se2ies transl!te
�	sgrim�typec&�olwmnprtotyPe.eza.qla|e.aPpLy(qlia);		prev�ousY =athreshold;		Poind{ = weries.pints;

		for 8x = p len "p�in4cn�ength9 i$< den; �+) {
		// cqkhe c�rrent point kcject
		poift�= poin�s[i];
		M{haxeEvgs!= pninu.s�apeA�gs;
			/� get cuprent {v!c{
H		stack = qeries.g%tStaCkmK;		stackPoint)< stcck.royntS[sdriec>)|dex];	I)'/`ove2bhde pomnv val�e��or�suesH	if (asNqN(poiNu.y)( {
	�		point�y(= series.yEiTaSi};			}

'/"tx p/I^dS
�		9 = oethmax*zreViousY,�previousY + poijtNy +)sta�kXoinv{0Y;� 		kjcpaArgc*y = axic.translite y, 2, 5-9


		&/ sum0pointcJ			iD hpoi�t>isSum ||2p�ynt.isInteRmediate�u-)!{
			3hapeArGs.9(= axis.tRgo3la0e(wtA#kPlind[0]( 0, 1);
		s(apeArfs.`emgxt = axis.trans|itu(sd`ckPoi~t[0], 0,(1) / ch�xe@raw.Y+��			// if!it'3 not �he sue Pol�t, uptatE0psevious stacm cn$ pos�dio.
		}`edS� {
		pr%viousI(+= qtack,total;
�		}

			//)ne�aTive p�inus
	�	iF (ship�A2gs.height$4 0) {			#�!p-Ar's.y += QhipeA�gs&Leigh|9
		�	qhapeAreS.height *� -1?
		I}
		toint.xdotY!?$shaxgArgs.y = methRound(shapeArG".y) - cricpCorvz
�		shapeArg3<he)ght =`oa|hR�tnd(shap%Args.heyghT);
		poi.t/yBo|4om -(sh�peAz'si +"s�ap�A�gs.xg)ght;
		}
	}J	/**
	`h Call defaumt ppocgSsData txdl o�errkdm(yDita$to reflect wape"f`lm%s �xtremes�on qAxis
	 */
ProcessDatq fungtioo  fmr'e) {*		Tar series =(tlis,
		)optiojs  seri!s,optinS,
I	yDita = sebims.mData,
			pon�s = weriew.points,�		point,	M	d`taLeneth$=!yD`ta.lengqh,
	)dxrashold  /ptinS.t�rusxold(|| 0=J			subSqm,
			sum8
		taua]in,
			dataMa�,
		y,*		�	:

		qum ="subSue"= d1taM	n = $a|aLax`= threshodd;

		for (i = 03 i" da�aLelgth;!i+#9 {
I	y"=(yData[i];
I	poinv 9 �giNts && points[h]!? poinfSZi] :$k};
			ib ,y�-== �Sum* || poi�t.iqSum)!z*	I		yData{i] = u�3
			}!alsa if (y(<=? �k.te�medi`ugSum || pinthsIftErmE|iateSum	 {
			)yD`|a[I] 5 sqbSum;�		!	subSuo =`t�resholds
	-t#udq%"k
X			stm += y[
				swBSuo #= {{
			}
		�dataMin = Ma�h&ein(sum,�dgtaMin);
�		dadiMix = ath.max(cum, dqtaMix);
		}
K		Seri%s.prototype.processBqta.call,tnis, fn�Cd);
	)//Rucmr$ e8tremgr
	�epies.dataMIn�= dataMmn;
		3%R)ds.dataMay =�dctaMax3
	m,
�	/**
I 
 Re|urn y palue!oj string hf!poift is sum
 *.
	toQDCti� vunceioJ h�t	 {
		if (pt.asR}m)`{
I	veturn "sum";
		} elsd )f (pt.isInueroediataSq}) ;
)�	returl "hndermed9cv%Sum";
	}
		reTur� 0t.y;
	},
	/**
	`+ @mstpsoce{s mapping bevgeel optyon3 a~d SVO$`4tribu�eqJ :/
getAt�r�bs*0Dunc�ienp,) {		ruritsTi0as.co�ymn>pvototypa.ge|Qvtrhbs.ap ly(this, �rfUm�~ts)

		vav`qezyes = t`�s,
			ottYons!< sdrhes*options,
		stateoptikn� = orTi+ns�state{,
		}pColor  optigns.qpCOlor || cevIer*oolor(				hovezSOlor = mgjchasts*CNlor�tpColov(brighten(0.1).get(+,*			se2iesDowjoijtAttr =$merge(sebie{�tninttt�),
		up#oloRTpop = s!riew.upColorProp;*
	IseziesTownQoINdAttr['?MKupBolobProx]�= w�Co|or;		sEviesDunP/mntAp|r.`over_upAo,orP�op] = qtatdOp|i/ns-h?ver.qpColor0\|$ho~erKolor;
		qurIesDoGnPoyFuAttv.sel%gt�upColopPr�q] = staqTOptikNr.sele"t>UpColor || upCo,nr{

	mach(qerhes.po)kt�,�Fulctkon (pOyntk {
			af )pn)~t.Y > 0 &$ !pMi.t.color)$[�				poin|/poin4�ttr = ser)uSE�wnPoIlvAt|r;
			pomNt.color =0upColoR;
			}
		});
	m=

	/**
	 . DrawcoluMf3�`connectoz L`~es
	 �/
	getrapjPAth: fe.c�ioo () {
		w�r data!= vhiq.tata,
		length = dati.lengtj,			line7idtI = this.oppiona.|ineWidth + this.gptions.bkrderWidtl, 		~ormali^er`= mat`Roune(|)ngWi th) %!2$' 2,
			0k|h = []l
			]"=�'MG$
		La=`'L�,	 	prevQR's,
			po)n4Irgs,
	�Iif
			d;
	fmr!(i09 0; y < length; i+�) {		pointArgs - dat@Ki.{h#qe�cS;Z			xrefArgs0=�dauaKi - 1]>sha�w�rgs;

			d�= [
			Md�	I		prgvIres.x  yr-vArgs.wqdth( �ruvAvgs.y + ^osMali:ER,
		�	L�
�			pointCrgs�z$pRevAres,y + norM�li{erj	)	U;		9id 8(ata_k(� 1].y� ) {
			d�2] += prevArgs.hemght+
		)	d[] +} p2erCrgs.h�igh|;		}*
I		path"=$ra�h.kon�at(d);
)	}*
		return pa�h	},
	/j*
	 * Uptremes arg re�obddd0in trocessD!ta
 "/
	'etExtrem-s: nOox�*
I/**Z� " Return sTac+!foz"give. index
	 �/	gEtS|aao:�function( k){
	vaj �xis =$vhis.5Exis,
		Hstasks = @XM�.stqck1,�	)ke}�= this.qackKe9;

	if ,tHis.rrkcersedKDc4��i] < thiB.opuinns.thre{hold) {
K	k�y`= '-'  ieq+
	}
		return stabksSkey][i];
	�
	frawFv`ph:`Sevius&pRototqpe.drAwGs!th
}):

/* **
*+j***�******.*/***�*(+*"*+*********
*************+**(***
*(*
"******(�**
 *0End wa|`rtall serKes!�odg    0    "    `      $  (     ` !               ( *
 j:******"**(**+********
*******:*(***********.***
******(*************b**�j**//* *****.**"*:**+***.******(*(*"*+****:**(*(�**+:*
*
*****"***"�**j***
******�� �p[tart Bucrmu 3ebius 'odu								�		 8 $ 0    *
 "***:*.******:*.*******�**:**..***"(********j:***"*j******(*j**.***********(+

//!1 - s%d devault }ptions
ddfaultP\ntOption�.fubblE�= meroe(defaultPlouOptions.scatter< {
	eapAlabelr: {
		inride:04pum<
		stile: {
		color: #xite',B			teytShadOw:$'0pT 0px 3rx b,agk'	)}$v`rtibalA�ign:$7mid`lg'
}-
)/*`di3p|cyNew�4(te: ur}e,
	maroer: y
		// fYLl_paci4y8 0.5,
		lineCOmor:$lul|, /o0iniaryd`from sebie�.#olkrhioeWid4H: 1
	}�
	minSmjd:08,
maxCizez`#24%',
�-� negatireGo|or> null(*	tmnltip: {
	x'intFor}at: '({toin�.xu, {rg�nt.9}), Wize: {point.z}
	},	turboThreshohd: �,
	zThbewhold: 4
}9;

/. 2 ) Create!the series ojject
{erIesTypms.�uBblg =$extan�Alass(ser�isTypes.ScatteR, {	typu: 'bUbble',
	q/intArr�9Map: ['y',!'z']<
	tRaskerOro}xw8 ['�ro5p7, 'dataLab%lsgsoup'},

	/+"
� .pMqpping between STGattributes And 0he corvwrpooDins ox|-/fs	"*�
	po	ntQttRToGpti�nc; {"
	strok�:"wlineColor',
	'strkke-�idT`':�'lineWydth#,
		fi,l: 'filhCol/v'
},			/+*
	 ( App�y 4ha villOpacitY $o aml fill`posmtionS	 */
	appl}pa��ty: dqnctign (fill)8{	var eiskerOptimnq = t@is*optio~s.marcer,
			filmOpa#idy = �i�k(earjavO0tmkns�fil|OPa�ity, �.1);
	�
	// Whe. called fr/m Leggnd.3oloryreItm, the *Ild0hsn&t treddfine`
		&inl } fanl |< mavkgr�ptio&s-f�,lColoR || thas.co,o�; 
�
	)kf (filLOxa�itY )}= 1)${
�		fill � Highcharus.C��or(fil,).SgtO`acity(tilLMpa�yty).gev('jgbA%);
		}J	�etupn"vyll;
	},
	
	/**
	 * EXtend0The coNvetvAttriBc metlod by!applyi�g o|a#ity to the nilf
	 */
	kojVurtattrics: ft~ction �) {		vab obj ="S%ries.xr/to4ipe.sonvertAttribs.appl} thi3, apguoants);
		
I)o�j.fill = t(isapplyO`acity(obj.fihL)
�	
K	seturF o"j?
	},N
-/**
	 j Get the sadyus go� m�ch point pesedon@txe minSaz%, maxSi:e`a�d d!ch$poiNt'{ � value."T(i�
	 * muq�`be tone priob to"Sepies.tr�nslate`becays� the axis$nuedS to i%d xadeing in 
	 * ack_rdalce with!|le:pnint w�zes.
 */
	weRadki: functhon (zMif("zM`xl man�k�m,`maxSize) {
+var len,
)		i,
			pmr,K			zData =$thMs>zDatc,
		ra$iI = [],J			ZRa.ge;				// Sep the shQpe tyxe`and0a�E5muntc t- be tic{dd u0 in draWPoknP{
	foz`8i2=4l len ="zDap`.l%ngth; i�4(l�n; i++),{
			zRaNge = zMa� -�zMiN;)		pos = �R!nge > 0 ?0// r�la4ine 3i�u� i2jtmbe� fdtwe�n 0 anF 1
				(zda�aKi] - ~mi.) - (zM`x!- ~Min)<: �I		0n5;
	I	radiK.push(�ath>gdyh8minSi�g + p/s + hmcxSize - miNSize)�(/ 2)8
		}
	thhs/radai  radii;
	},
H
	/*
�	 ( P'rform`animatin0on |he bubrles	 */	anim�tm: f}ncd*/l inIp) {
		vyr �nimation0� this.Iptions.animaTion;
		
		if (!ilip) ; '/ ru. txe ani}�4ion
		each(thhs.pokntr, funqtion (point- {
			var fr`phic =0pi�t.grqp`)c,
	)	qhatuArgr =+point.chepeArgs;
			id!8grap�ic && shapEAvgs) s				// start values
				graphig.att6(gr', 1-;

		I/ �ni}qte
					graqhis.animatE{)			)r: s�ateAr�r.z
		M	}, an)LAtin)3
	�Iu
	I});�
			// dglet� uhhs fu�ction |m alLnw i4 /nly"on�e	)uhi3+aj�mAte = null;
	}}.
	
/*

 * Extefd the `as%`Translate method!t((qjdme(bubble siZE
	!*/
	t2a(slqte: f�nction () {
		
		v`r i,d�te = this.data,
			poknv$
		�Radiusl
			radi� ?0this.radiI;
		
		// Pun(tha u�~end0-ethoe		SeriesTyqe�.scatter.prototy�e.|ranslate.call*4(is);
	-		// Se4 uje(siape�ty�e and avgumgnts!to be2pigked"up0i� $zawPoinTs
		i } da�a.length;
			whaleay-%) {
		tomnT  data[i];*			radyu�$= radii ? 2a�ii[iY :00�$// '17#7J
		// Flag fOr legativeC/mor 5o0ce appliEd(��0Ser)g�.jq		point.��gat)ve  t{	nt.z < (t8ir.optionS.zThreslold <l p);
		
			�F((radius!>= this.mioXxSize / 2)([
	�/-!Shape argu�ents
	I	pyNt.3hapeType = 'cipcle';
				poin4.chapeARgs0< {
)-�	x2dpoint.Plot],				i: point.p\otY,					r2 ra$ius
			m;
				
			// AliGnoen box for 4be dat! nabel			poyot.dlBox ="{
			)	x: xo)nu.pnotX!- radius(
)		y poant�plot� -(radi5s�
			wi%th: 1 * padYus,
			`aighf: 2 * radi�s
				�7
		 e�sm0{ // bglow {threshomd�			po��t.shapeQ�gs = poi.t.zL/dY = pint.�lox ="UNEFINED /o #1v99		
		}
	=
	
	/**
 * Ge| the${erias' symbml mn ple legeo�
	 * 
	 * @pcram {Obneg4}"Legend Lhe lev%nf o�ject
	 * @par`m"{Objuct} item Thd series (tHis) op$xoint
	 (/	drawLegen�[ym�oL: bunctIN (l�ge�l,()t$i)!y�	var rada�s ? pIn2(legenditemStyLe.fo.pSyz�) +�2;
		
		item.legenf[ymbgn = this.chapv.be�dM�mr/civcLe�
			radiu3,
		�legend.`aseline / rqdius,
		radyus
		).aTtr,{�		zI~de�: 3	I).afd(mtem&l`fendGbOup�;
		item.legendSyobml.esOarker  �r5e;	
)	
	}
	
�dra�POifts: s��iecTypec.aoltmn.qrot�t9te.drawPoin�q-
	ilkgnDat`M�be|: sezimrTyPer�columNjprototype.alignadaLabeh
|);

k**
 � Add lngic to!paf eag( exas with t�e imownt on�`ixe,s
 * nec!s�ary t� avoid(u�e bub`des t/ overfmou
 */
Axis.protitype.�eforea�`iFg = funcTion () {var ayiQ(=(This.�		axi{Lengt` � thIs.lmf(	cjart = 4hhs.chart$
	pxMin = 0, 	txM!x = �xh{Leoth,
		i�Xaxis =�this.isXA�is,
		dauaKey = isYAxis ? 'xData' :`/yD�t�',J		Min ? t(iz>M{N,
		extrem%s(="{},
		smadlestSize � math.mi�(bhart.xlotWimth, khcrt.p�ot@eighu)
		zOin = Numbd0.mAX_TALUE,
		�Max`= -Fumber.MAX_VALUE,		Range$= t`is.iax ) -l�,J�	uralsA = axisLengtz ' Ranga,
		astk~eSezieq = []{	// H#np<e"padding oL the secnn� xassl"or oo!rddraw
	mf (thi�.tacj@osidimnsi {
	ea�h(this>ses`%s,!fUnction (serygs) {
		war!ser{asGptkons = suvie3.opVimfs,
			{D`ta;

		ib (series>type =9=0'bubble' 7&�se�i'svi�iblui {

				//!GorrgctiOf dor #1673
				axh�.allowZomOutsed% = tue:
*	A	/?!cache(it
				activgSeries.pu{h(rerieS)�

)		af (isXAxish � / `eciu�� X Axis Is gvaluatqe`fipst
				
	�		//!For eAbh sepyes, t0ansL!te the!size E8tr�}eS$to pixml$valqes*					%Ach(['minSiz�',�'maxRize-]� fwoctmon$(0rop) {
)		)	var laneth =`seri�sOptkoos[prop\$
 )	)	ysPgrcent = /%$/.tecd(lungthi;
				
				le~g|h = pYjt(lejgth);
			exdrames[rrnq] = isPavcent ?
					sma|lestYize * lengti / 900 :
					lenWth;
						
			�	y);
					wermes��inPxShz% = extreme�&minQize;
		�		�					?? i�� txe mIn andma| ^
			zD`ta 5(sgrims:�D`td;
		�		ib (jFata.length) {�//$#5735*		)			jOhn 50Mad(.min(
(					z|in,			-	ma|x/max(
				�I	arRayMin(zD`ta)� 			I			sdrimsOpt�ons.displ`yNecati6e =9=Falcg ?�seriesOttions.zThveqHmld : -Nu-ber.MAX_VALUE*							)
			�	));
					ZLAp!= -ath�m�x(zMax, abr`yM!x(zEata-);				}
			}
		�		})

I	e!ch(actm~emriesl functaOn (se0ies)`{

 		vap dati ? sdziesd!tq[ey]&
			i = Data,lcfgt�(
		r�dius;

)	if�(is^@xiw) {
				series.getRcii(zMin. rMax, extremes.minSy~e, extveme3.maxSize);
�}
I		
	I	xf!(range�> 0� {
				while 8h--) �
					Rqdi�s$= suviey>radii[iU;�					ppMkn0= M`th.m)j8((Dapa[i] -!mhn)0*!t2ansA) M padhts$ pxMin(;
					pxMaz ="Math.max�(dqtiZi]�- min) * trafsA( + radius, pxMap);	)		
			u
		});
�	
		af (acuiveSeriesnleno�(%&' ra~ge = 0 &&!xick(this.optionc.�io, tHar�usErmYn),==} UNDEFNET b& xicK(thiq.optmons.max thirousdrMa0)(=== UNDEFM�ET)!{
			pxMax ,= ax-rLenG$h;*		tranSA *=$(aX�wLenet� +(pxm)n - pxMyx)0 a|iqLfngt(;
			�hiS.mib += pxMin / t�anr9
		t`iw.m�| ;= p|Max '!transA�+		]
	}
};

�* *******************�*********j*.�.*******:***j*****j**********j**.*********a*(Und"Bubb�e seryes cofe $ �$    ! ( `    �0!  �  p0       "     $         ``*
 j************;:****(j********+:****.*(*:*:+*j

�*
.�(*2#"�:*:*j*.

*:*******(//**
 ��Extensigns bos p/�a{(c`#rvs.0AdditiOnahd�, mush(of$|le Geometry required foz �ol}p4chazts hs
 * Gath�z�& an R`dkqlAxes.zs.� 
 � */

ter ser�esProto�9 S�rieq.prototypf,pointerQrOuo ? Hi�hkHarts�pointer��soto4yre;



%**
 ( D2aNcliue a point's ploVH ane$plot[ fr~m the indernad anele qjf radi5s ieu�ure3 t� 
!: tbue pnkt�`pdovY co�rdinates
 */
rgp�esProto.4oHY = vunction$)pJint)`{
	vAp`xy
chart = this.sHept,J		plouX = poiov.tl�tX,
		plot� 5 point.plotY;
	
	// Save rectangular plotX, plotY for later computation
	point.rectPlotX = plotX;
	point.rectPlotY = plotY;
	
	// Record the angle in degrees for use in tooltip
	point.clientX = ((plotX / Math.PI * 180) + this.xAxis.pane.options.startAngle) % 360;
	
	// Find the polar plotX and plotY
	xy = this.xAxis.postTranslate(point.plotX, this.yAxis.len - plotY);
	point.plotX = point.polarPlotX = xy.x - chart.plotLeft;
	point.plotY = point.polarPlotY = xy.y - chart.plotTop;
};

/** 
 * Order the tooltip points to get the mouse capture ranges correct. #1915. 
 */
seriesProto.orderTooltipPoints = function (points) {
	if (this.chart.polar) {
		points.sort(function (a, b) {
			return a.clientX - b.clientX;
		});

		// Wrap mouse tracking around to capture movement on the segment to the left
		// of the north point (#1469, #2093).
		if (points[0]) {
			points[0].wrappedClientX = points[0].clientX + 360;
			points.push(points[0]);
		}
	}
};


/**
 * Add some special init logic to areas and areasplines
 */
function initArea(proceed, chart, options) {
	proceed.call(this, chart, options);
	if (this.chart.polar) {
		
		/**
		 * Overridden method to close a segment path. While in a cartesian plane the area 
		 * goes down to the threshold, in the polar chart it goes to the center.
		 */
		this.closeSegment = function (path) {
			var center = this.xAxis.center;
			path.push(
				'L',
				center[0],
				center[1]
			);			
		};
		
		// Instead of complicated logic to draw an area around the inner area in a stack,
		// just draw it behind
		this.closedStacks = true;
	}
}
wrap(seriesTypes.area.prototype, 'init', initArea);
wrap(seriesTypes.areaspline.prototype, 'init', initArea);
		

/**
 * Overridden method for calculating a spline from one point to the next
 */
wrap(seriesTypes.spline.prototype, 'getPointSpline', function (proceed, segment, point, i) {
	
	var ret,
		smoothing = 1.5, // 1 means control points midway between points, 2 means 1/3 from the point, 3 is 1/4 etc;
		denom = smoothing + 1,
		plotX, 
		plotY,
		lastPoint,
		nextPoint,
		lastX,
		lastY,
		nextX,
		nextY,
		leftContX,
		leftContY,
		rightContX,
		rightContY,
		distanceLeftControlPoint,
		distanceRightControlPoint,
		leftContAngle,
		rightContAngle,
		jointAngle;
		
		
	if (this.chart.polar) {
		
		plotX = point.plotX;
		plotY = point.plotY;
		lastPoint = segment[i - 1];
		nextPoint = segment[i + 1];
			
		// Connect ends
		if (this.connectEnds) {
			if (!lastPoint) {
				lastPoint = segment[segment.length - 2]; // not the last but the second last, because the segment is already connected
			}
			if (!nextPoint) {
				nextPoint = segment[1];
			}	
		}

		// find control points
		if (lastPoint && nextPoint) {
		
			lastX = lastPoint.plotX;
			lastY = lastPoint.plotY;
			nextX = nextPoint.plotX;
			nextY = nextPoint.plotY;
			leftContX = (smoothing * plotX + lastX) / denom;
			leftContY = (smoothing * plotY + lastY) / denom;
			rightContX = (smoothing * plotX + nextX) / denom;
			rightContY = (smoothing * plotY + nextY) / denom;
			distanceLeftControlPoint = Math.sqrt(Math.pow(leftContX - plotX, 2) + Math.pow(leftContY - plotY, 2));
			distanceRightControlPoint = Math.sqrt(Math.pow(rightContX - plotX, 2) + Math.pow(rightContY - plotY, 2));
			leftContAngle = Math.atan2(leftContY - plotY, leftContX - plotX);
			rightContAngle = Math.atan2(rightContY - plotY, rightContX - plotX);
			jointAngle = (Math.PI / 2) + ((leftContAngle + rightContAngle) / 2);
				
				
			// Ensure the right direction, jointAngle should be in the same quadrant as leftContAngle
			if (Math.abs(leftContAngle - jointAngle) > Math.PI / 2) {
				jointAngle -= Math.PI;
			}
			
			// Find the corrected control points for a spline straight through the point
			leftContX = plotX + Math.cos(jointAngle) * distanceLeftControlPoint;
			leftContY = plotY + Math.sin(jointAngle) * distanceLeftControlPoint;
			rightContX = plotX + Math.cos(Math.PI + jointAngle) * distanceRightControlPoint;
			rightContY = plotY + Math.sin(Math.PI + jointAngle) * distanceRightControlPoint;
			
			// Record for drawing in next point
			point.rightContX = rightContX;
			point.rightContY = rightContY;

		}
		
		
		// moveTo or lineTo
		if (!i) {
			ret = ['M', plotX, plotY];
		} else { // curve from last point to this
			ret = [
				'C',
				lastPoint.rightContX || lastPoint.plotX,
				lastPoint.rightContY || lastPoint.plotY,
				leftContX || plotX,
				leftContY || plotY,
				plotX,
				plotY
			];
			lastPoint.rightContX = lastPoint.rightContY = null; // reset for updating series later
		}
		
		
	} else {
		ret = proceed.call(this, segment, point, i);
	}
	return ret;
});

/**
 * Extend translate. The plotX and plotY values are computed as if the polar chart were a
 * cartesian plane, where plotX denotes the angle in radians and (yAxis.len - plotY) is the pixel distance from
 * center. 
 */
wrap(seriesProto, 'translate', function (proceed) {
		
	// Run uber method
	proceed.call(this);
	
	// Postprocess plot coordinates
	if (this.chart.polar && !this.preventPostTranslate) {
		var points = this.points,
			i = points.length;
		while (i--) {
			// Translate plotX, plotY from angle and radius to true plot coordinates
			this.toXY(points[i]);
		}
	}
});

/** 
 * Extend getSegmentPath to allow connecting ends across 0 to provide a closed circle in 
 * line-like series.
 */
wrap(seriesProto, 'getSegmentPath', function (proceed, segment) {
		
	var points = this.points;
	
	// Connect the path
	if (this.chart.polar && this.options.connectEnds !== false && 
			segment[segment.length - 1] === points[points.length - 1] && points[0].y !== null) {
		this.connectEnds = true; // re-used in splines
		segment = [].concat(segment, [points[0]]);
	}
	
	// Run uber method
	return proceed.call(this, segment);
	
});


function polarAnimate(proceed, init) {
	var chart = this.chart,
		animation = this.options.animation,
		group = this.group,
		markerGroup = this.markerGroup,
		center = this.xAxis.center,
		plotLeft = chart.plotLeft,
		plotTop = chart.plotTop,
		attribs;

	// Specific animation for polar charts
	if (chart.polar) {
		
		// Enable animation on polar charts only in SVG. In VML, the scaling is different, plus animation
		// would be so slow it would't matter.
		if (chart.renderer.isSVG) {

			if (animation === true) {
				animation = {};
			}
	
			// Initialize the animation
			if (init) {
				
				// Scale down the group and place it in the center
				attribs = {
					translateX: center[0] + plotLeft,
					translateY: center[1] + plotTop,
					scaleX: 0.001, // #1499
					scaleY: 0.001
				};
					
				group.attr(attribs);
				if (markerGroup) {
					markerGroup.attrSetters = group.attrSetters;
					markerGroup.attr(attribs);
				}
				
			// Run the animation
			} else {
				attribs = {
					translateX: plotLeft,
					translateY: plotTop,
					scaleX: 1,
					scaleY: 1
				};
				group.animate(attribs, animation);
				if (markerGroup) {
					markerGroup.animate(attribs, animation);
				}
				
				// Delete this function to allow it only once
				this.animate = null;
			}
		}
	
	// For non-polar charts, revert to the basic animation
	} else {
		proceed.call(this, init);
	} 
}

// Define the animate method for both regular series and column series and their derivatives
wrap(seriesProto, 'animate', polarAnimate);
wrap(colProto, 'animate', polarAnimate);


/**
 * Throw in a couple of properties to let setTooltipPoints know we're indexing the points
 * in degrees (0-360), not plot pixel width.
 */
wrap(seriesProto, 'setTooltipPoints', function (proceed, renew) {
		
	if (this.chart.polar) {
		extend(this.xAxis, {
			tooltipLen: 360 // degrees are the resolution unit of the tooltipPoints array
		});	
	}
	
	// Run uber method
	return proceed.call(this, renew);
});


/**
 * Extend the column prototype's translate method
 */
wrap(colProto, 'translate', function (proceed) {
		
	var xAxis = this.xAxis,
		len = this.yAxis.len,
		center = xAxis.center,
		startAngleRad = xAxis.startAngleRad,
		renderer = this.chart.renderer,
		start,
		points,
		point,
		i;
	
	this.preventPostTranslate = true;
	
	// Run uber method
	proceed.call(this);
	
	// Postprocess plot coordinates
	if (xAxis.isRadial) {
		points = this.points;
		i = points.length;
		while (i--) {
			point = points[i];
			start = point.barX + startAngleRad;
			point.shapeType = 'path';
			point.shapeArgs = {
				d: renderer.symbols.arc(
					center[0],
					center[1],
					len - point.plotY,
					null, 
					{
						start: start,
						end: start + point.pointWidth,
						innerR: len - pick(point.yBottom, len)
					}
				)
			};
			this.toXY(point); // provide correct plotX, plotY for tooltip
		}
	}
});


/**
 * Align column data labels outside the columns. #1199.
 */
wrap(colProto, 'alignDataLabel', function (proceed, point, dataLabel, options, alignTo, isNew) {
	
	if (this.chart.polar) {
		var angle = point.rectPlotX / Math.PI * 180,
			align,
			verticalAlign;
		
		// Align nicely outside the perimeter of the columns
		if (options.align === null) {
			if (angle > 20 && angle < 160) {
				align = 'left'; // right hemisphere
			} else if (angle > 200 && angle < 340) {
				align = 'right'; // left hemisphere
			} else {
				align = 'center'; // top or bottom
			}
			options.align = align;
		}
		if (options.verticalAlign === null) {
			if (angle < 45 || angle > 315) {
				verticalAlign = 'bottom'; // top part
			} else if (angle > 135 && angle < 225) {
				verticalAlign = 'top'; // bottom part
			} else {
				verticalAlign = 'middle'; // left or right
			}
			options.verticalAlign = verticalAlign;
		}
		
		seriesProto.alignDataLabel.call(this, point, dataLabel, options, alignTo, isNew);
	} else {
		proceed.call(this, point, dataLabel, options, alignTo, isNew);
	}
	
});

/**
 * Extend the mouse tracker to return the tooltip position index in terms of
 * degrees rather than pixels
 */
wrap(pointerProto, 'getIndex', function (proceed, e) {
	var ret,
		chart = this.chart,
		center,
		x,
		y;
	
	if (chart.polar) {
		center = chart.xAxis[0].center;
		x = e.chartX - center[0] - chart.plotLeft;
		y = e.chartY - center[1] - chart.plotTop;
		
		ret = 180 - Math.round(Math.atan2(x, y) / Math.PI * 180);
	
	} else {
	
		// Run uber method
		ret = proceed.call(this, e);
	}
	return ret;
});

/**
 * Extend getCoordinates to prepare for polar axis values
 */
wrap(pointerProto, 'getCoordinates', function (proceed, e) {
	var chart = this.chart,
		ret = {
			xAxis: [],
			yAxis: []
		};
	
	if (chart.polar) {	

		each(chart.axes, function (axis) {
			var isXAxis = axis.isXAxis,
				center = axis.center,
				x = e.chartX - center[0] - chart.plotLeft,
				y = e.chartY - center[1] - chart.plotTop;
			
			ret[isXAxis ? 'xAxis' : 'yAxis'].push({
				axis: axis,
				value: axis.translate(
					isXAxis ?
						Math.PI - Math.atan2(x, y) : // angle 
						Math.sqrt(Math.pow(x, 2) + Math.pow(y, 2)), // distance from center
					true
				)
			});
		});
		
	} else {
		ret = proceed.call(this, e);
	}
	
	return ret;
});
}(Highcharts));
