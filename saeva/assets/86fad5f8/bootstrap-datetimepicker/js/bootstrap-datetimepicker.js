/* =========================================================
 * bootstrap-datetimepicker.js
 * =========================================================
 * Copyright 2012 Stefan Petre
 * Improvements by Andrew Rowls
 * Improvements by S√©bastien Malot
 * Improvements by Yun Lai
 * Project URL : http://www.malot.fr/bootstrap-datetimepicker
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */

/*
 * Improvement by CuGBabyBeaR @ 2013-09-12
 * 
 * Make it work in bootstrap v3
 */

!function ($) {

	function UTCDate() {
		return new Date(Date.UTC.apply(Date, arguments));
	}

	function UTCToday() {
		var today = new Date();
		return UTCDate(today.getUTCFullYear(), today.getUTCMonth(), today.getUTCDate(), today.getUTCHours(), today.getUTCMinutes(), today.getUTCSeconds(), 0);
	}

	// Picker object

	var Datetimepicker = function (element, options) {
		var that = this;

		this.element = $(element);

		this.language = options.language || this.element.data('date-language') || "en";
		this.language = this.language in dates ? this.language : "en";
		this.isRTL = dates[this.language].rtl || false;
		this.formatType = options.formatType || this.element.data('format-type') || 'standard';
		this.format = DPGlobal.parseFormat(options.format || this.element.data('date-format') || dates[this.language].format || DPGlobal.getDefaultFormat(this.formatType, 'input'), this.formatType);
		this.isInline = false;
		this.isVisible = false;
		this.isInput = this.element.is('input');

		this.bootcssVer = this.isInput ? (this.element.is('.form-control') ? 3 : 2) : ( this.bootcssVer = this.element.is('.input-group') ? 3 : 2 );

		this.component = this.element.is('.date') ? ( this.bootcssVer == 3 ? this.element.find('.input-group-addon .glyphicon-th, .input-group-addon .glyphicon-time, .input-group-addon .glyphicon-calendar').parent() : this.element.find('.add-on .icon-th, .add-on .icon-time, .add-on .icon-calendar').parent()) : false;
		this.componentReset = this.element.is('.date') ? ( this.bootcssVer == 3 ? this.element.find('.input-group-addon .glyphicon-remove').parent() : this.element.find('.add-on .icon-remove').parent()) : false;
		this.hasInput = this.component && this.element.find('input').length;
		if (this.component && this.component.length === 0) {
			this.component = false;
		}
		this.linkField = options.linkField || this.element.data('link-field') || false;
		this.linkFormat = DPGlobal.parseFormat(options.linkFormat || this.element.data('link-format') || DPGlobal.getDefaultFormat(this.formatType, 'link'), this.formatType);
		this.minuteStep = options.minuteStep || this.element.data('minute-step') || 5;
		this.pickerPosition = options.pickerPosition || this.element.data('picker-position') || 'bottom-right';
		this.showMeridian = options.showMeridian || this.element.data('show-meridian') || false;
		this.initialDate = options.initialDate || new Date();

		this._attachEvents();

		this.formatViewType = "datetime";
		if ('formatViewType' in options) {
			this.formatViewType = options.formatViewType;
		} else if ('formatViewType' in this.element.data()) {
			this.formatViewType = this.element.data('formatViewType');
		}

		this.minView = 0;
		if ('minView' in options) {
			this.minView = options.minView;
		} else if ('minView' in this.element.data()) {
			this.minView = this.element.data('min-view');
		}
		this.minView = DPGlobal.convertViewMode(this.minView);

		this.maxView = DPGlobal.modes.length - 1;
		if ('maxView' in options) {
			this.maxView = options.maxView;
		} else if ('maxView' in this.element.data()) {
			this.maxView = this.element.data('max-view');
		}
		this.maxView = DPGlobal.convertViewMode(this.maxView);

		this.wheelViewModeNavigation = false;
		if ('wheelViewModeNavigation' in options) {
			this.wheelViewModeNavigation = options.wheelViewModeNavigation;
		} else if ('wheelViewModeNavigation' in this.element.data()) {
			this.wheelViewModeNavigation = this.element.data('view-mode-wheel-navigation');
		}

		this.wheelViewModeNavigationInverseDirection = false;

		if ('wheelViewModeNavigationInverseDirection' in options) {
			this.wheelViewModeNavigationInverseDirection = options.wheelViewModeNavigationInverseDirection;
		} else if ('wheelViewModeNavigationInverseDirection' in this.element.data()) {
			this.wheelViewModeNavigationInverseDirection = this.element.data('view-mode-wheel-navigation-inverse-dir');
		}

		this.wheelViewModeNavigationDelay = 100;
		if ('wheelViewModeNavigationDelay' in options) {
			this.wheelViewModeNavigationDelay = options.wheelViewModeNavigationDelay;
		} else if ('wheelViewModeNavigationDelay' in this.element.data()) {
			this.wheelViewModeNavigationDelay = this.element.data('view-mode-wheel-navigation-delay');
		}

		this.startViewMode = 2;
		if ('startView' in options) {
			this.startViewMode = options.startView;
		} else if ('startView' in this.element.data()) {
			this.startViewMode = this.element.data('start-view');
		}
		this.startViewMode = DPGlobal.convertViewMode(this.startViewMode);
		this.viewMode = this.startViewMode;

		this.viewSelect = this.minView;
		if ('viewSelect' in options) {
			this.viewSelect = options.viewSelect;
		} else if ('viewSelect' in this.element.data()) {
			this.viewSelect = this.element.data('view-select');
		}
		this.viewSelect = DPGlobal.convertViewMode(this.viewSelect);

		this.forceParse = true;
		if ('forceParse' in options) {
			this.forceParse = options.forceParse;
		} else if ('dateForceParse' in this.element.data()) {
			this.forceParse = this.element.data('date-force-parse');
		}

		this.picker = $((this.bootcssVer == 3) ? DPGlobal.templateV3 : DPGlobal.template)
			.appendTo(this.isInline ? this.element : 'body')
			.on({
				click:     $.proxy(this.click, this),
				mousedown: $.proxy(this.mousedown, this)
			});

		if (this.wheelViewModeNavigation) {
			if ($.fn.mousewheel) {
				this.picker.on({mousewheel: $.proxy(this.mousewheel, this)});
			} else {
				console.log("Mouse Wheel event is not supported. Please include the jQuery Mouse Wheel plugin before enabling this option");
			}
		}

		if (this.isInline) {
			this.picker.addClass('datetimepicker-inline');
		} else {
			this.picker.addClass('datetimepicker-dropdown-' + this.pickerPosition + ' dropdown-menu');
		}
		if (this.isRTL) {
			this.picker.addClass('datetimepicker-rtl');
			if (this.bootcssVer == 3) {
				this.picker.find('.prev span, .next span')
					.toggleClass('glyphicon-arrow-left glyphicon-arrow-right');
			} else {
				this.picker.find('.prev i, .next i')
					.toggleClass('icon-arrow-left icon-arrow-right');
			}
			;

		}
		$(document).on('mousedown', function (e) {
			// Clicked outside the datetimepicker, hide it
			if ($(e.target).closest('.datetimepicker').length === 0) {
				that.hide();
			}
		});

		this.autoclose = false;
		if ('autoclose' in options) {
			this.autoclose = options.autoclose;
		} else if ('dateAutoclose' in this.element.data()) {
			this.autoclose = this.element.data('date-autoclose');
		}

		this.keyboardNavigation = true;
		if ('keyboardNavigation' in options) {
			this.keyboardNavigation = options.keyboardNavigation;
		} else if ('dateKeyboardNavigation' in this.element.data()) {
			this.keyboardNavigation = this.element.data('date-keyboard-navigation');
		}

		this.todayBtn = (options.todayBtn || this.element.data('date-today-btn') || false);
		this.todayHighlight = (options.todayHighlight || this.element.data('date-today-highlight') || false);

		this.weekStart = ((options.weekStart || this.element.data('date-weekstart') || dates[this.language].weekStart || 0) % 7);
		this.weekEnd = ((this.weekStart + 6) % 7);
		this.startDate = -Infinity;
		this.endDate = Infinity;
		this.daysOfWeekDisabled = [];
		this.setStartDate(options.startDate || this.element.data('date-startdate'));
		this.setEndDate(options.endDate || this.element.data('date-enddate'));
		this.setDaysOfWeekDisabled(options.daysOfWeekDisabled || this.element.data('date-days-of-week-disabled'));
		this.fillDow();
		this.fillMonths();
		this.update();
		this.showMode();

		if (this.isInline) {
			this.show();
		}
	};

	Datetimepicker.prototype = {
		constructor: Datetimepicker,

		_events:       [],
		_attachEvents: function () {
			this._detachEvents();
			if (this.isInput) { // single input
				this._events = [
					[this.element, {
						focus:   $.proxy(this.show, this),
						keyup:   $.proxy(this.update, this),
						keydown: $.proxy(this.keydown, this)
					}]
				];
			}
			else if (this.component && this.hasInput) { // component: input + button
				this._events = [
					// For components that are not readonly, allow keyboard nav
					[this.element.find('input'), {
						focus:   $.proxy(this.show, this),
						keyup:   $.proxy(this.update, this),
						keydown: $.proxy(this.keydown, this)
					}],
					[this.component, {
						click: $.proxy(this.show, this)
					}]
				];
				if (this.componentReset) {
					this._events.push([
						this.componentReset,
						{click: $.proxy(this.reset, this)}
					]);
				}
			}
			else if (this.element.is('div')) {  // inline datetimepicker
				this.isInline = true;
			}
			else {
				this._events = [
					[this.element, {
						click: $.proxy(this.show, this)
					}]
				];
			}
			for (var i = 0, el, ev; i < this._events.length; i++) {
				el = this._events[i][0];
				ev = this._events[i][1];
				el.on(ev);
			}
		},

		_detachEvents: function () {
			for (var i = 0, el, ev; i < this._events.length; i++) {
				el = this._events[i][0];
				ev = this._events[i][1];
				el.off(ev);
			}
			this._events = [];
		},

		show: function (e) {
			this.picker.show();
			this.height = this.component ? this.component.outerHeight() : this.element.outerHeight();
			if (this.forceParse) {
				this.update();
			}
			this.place();
			$(window).on('resize', $.proxy(this.place, this));
			if (e) {
				e.stopPropagation();
				e.preventDefault();
			}
			this.isVisible = true;
			this.element.trigger({
				type: 'show',
				date: this.date
			});
		},

		hide: function (e) {
			if (!this.isVisible) return;
			if (this.isInline) return;
			this.picker.hide();
			$(window).off('resize', this.place);
			this.viewMode = this.startViewMode;
			this.showMode();
			if (!this.isInput) {
				$(document).off('mousedown', this.hide);
			}

			if (
				this.forceParse &&
					(
						this.isInput && this.element.val() ||
							this.hasInput && this.element.find('input').val()
						)
				)
				this.setValue();
			this.isVisible = false;
			this.element.trigger({
				type: 'hide',
				date: this.date
			});
		},

		remove: function () {
			this._detachEvents();
			this.picker.remove();
			delete this.picker;
			delete this.element.data().datetimepicker;
		},

		getDate: function () {
			var d = this.getUTCDate();
			return new Date(d.getTime() + (d.getTimezoneOffset() * 60000));
		},

		getUTCDate: function () {
			return this.date;
		},

		setDate: function (d) {
			this.setUTCDate(new Date(d.getTime() - (d.getTimezoneOffset() * 60000)));
		},

		setUTCDate: function (d) {
			if (d >= this.startDate && d <= this.endDate) {
				this.date = d;
				this.setValue();
				this.viewDate = this.date;
				this.fill();
			} else {
				this.element.trigger({
					type:      'outOfRange',
					date:      d,
					startDate: this.startDate,
					endDate:   this.endDate
				});
			}
		},

		setFormat: function (format) {
			this.format = DPGlobal.parseFormat(format, this.formatType);
			var element;
			if (this.isInput) {
				element = this.element;
			} else if (this.component) {
				element = this.element.find('input');
			}
			if (element && element.val()) {
				this.setValue();
			}
		},

		setValue: function () {
			var formatted = this.getFormattedDate();
			if (!this.isInput) {
				if (this.component) {
					this.element.find('input').val(formatted);
				}
				this.element.data('date', formatted);
			} else {
				this.element.val(formatted);
			}
			if (this.linkField) {
				$('#' + this.linkField).val(this.getFormattedDate(this.linkFormat));
			}
		},

		getFormattedDate: function (format) {
			if (format == undefined) format = this.format;
			return DPGlobal.formatDate(this.date, format, this.language, this.formatType);
		},

		setStartDate: function (startDate) {
			this.startDate = startDate || -Infinity;
			if (this.startDate !== -Infinity) {
				this.startDate = DPGlobal.parseDate(this.startDate, this.format, this.language, this.formatType);
			}
			this.update();
			this.updateNavArrows();
		},

		setEndDate: function (endDate) {
			this.endDate = endDate || Infinity;
			if (this.endDate !== Infinity) {
				this.endDate = DPGlobal.parseDate(this.endDate, this.format, this.language, this.formatType);
			}
			this.update();
			this.updateNavArrows();
		},

		setDaysOfWeekDisabled: function (daysOfWeekDisabled) {
			this.daysOfWeekDisabled = daysOfWeekDisabled || [];
			if (!$.isArray(this.daysOfWeekDisabled)) {
				this.daysOfWeekDisabled = this.daysOfWeekDisabled.split(/,\s*/);
			}
			this.daysOfWeekDisabled = $.map(this.daysOfWeekDisabled, function (d) {
				return parseInt(d, 10);
			});
			this.update();
			this.updateNavArrows();
		},

		place: function () {
			if (this.isInline) return;

			var index_highest = 0;
			$('div').each(function () {
				var index_current = parseInt($(this).css("zIndex"), 10);
				if (index_current > index_highest) {
					index_highest = index_current;
				}
			});
			var zIndex = index_highest + 10;

			var offset, top, left;
			if (this.component) {
				offset = this.component.offset();
				left = offset.left;
				if (this.pickerPosition == 'bottom-left' || this.pickerPosition == 'top-left') {
					left += this.component.outerWidth() - this.picker.outerWidth();
				}
			} else {
				offset = this.element.offset();
				left = offset.left;
			}
			if (this.pickerPosition == 'top-left' || this.pickerPosition == 'top-right') {
				top = offset.top - this.picker.outerHeight();
			} else {
				top = offset.top + this.height;
			}
			this.picker.css({
				top:    top,
				left:   left,
				zIndex: zIndex
			});
		},

		update: function () {
			var date, fromArgs = false;
			if (arguments && arguments.length && (typeof arguments[0] === 'string' || arguments[0] instanceof Date)) {
				date = arguments[0];
				fromArgs = true;
			} else {
				date = this.element.data('date') || (this.isInput ? this.element.val() : this.element.find('input').val()) || this.initialDate;
				if (typeof date == 'string' || date instanceof String) {
				  date = date.replace(/^\s+|\s+$/g,'');
				}
			}

			if (!date) {
				date = new Date();
				fromArgs = false;
			}

			this.date = DPGlobal.parseDate(date, this.format, this.language, this.formatType);

			if (fromArgs) this.setValue();

			if (this.date < this.startDate) {
				this.viewDate = new Date(this.startDate);
			} else if (this.date > this.endDate) {
				this.viewDate = new Date(this.endDate);
			} else {
				this.viewDate = new Date(this.date);
			}
			this.fill();
		},

		fillDow: function () {
			var dowCnt = this.weekStart,
				html = '<tr>';
			while (dowCnt < this.weekStart + 7) {
				html += '<th class="dow">' + dates[this.language].daysMin[(dowCnt++) % 7] + '</th>';
			}
			html += '</tr>';
			this.picker.find('.datetimepicker-days thead').append(html);
		},

		fillMonths: function () {
			var html = '',
				i = 0;
			while (i < 12) {
				html += '<span class="month">' + dates[this.language].monthsShort[i++] + '</span>';
			}
			this.picker.find('.datetimepicker-months td').html(html);
		},

		fill: function () {
			if (this.date == null || this.viewDate == null) {
				return;
			}
			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth(),
				dayMonth = d.getUTCDate(),
				hours = d.getUTCHours(),
				minutes = d.getUTCMinutes(),
				startYear = this.startDate !== -Infinity ? this.startDate.getUTCFullYear() : -Infinity,
				startMonth = this.startDate !== -Infinity ? this.startDate.getUTCMonth() : -Infinity,
				endYear = this.endDate !== Infinity ? this.endDate.getUTCFullYear() : Infinity,
				endMonth = this.endDate !== Infinity ? this.endDate.getUTCMonth() : Infinity,
				currentDate = (new UTCDate(this.date.getUTCFullYear(), this.date.getUTCMonth(), this.date.getUTCDate())).valueOf(),
				today = new Date();
			this.picker.find('.datetimepicker-days thead th:eq(1)')
				.text(dates[this.language].months[month] + ' ' + year);
			if (this.formatViewType == "time") {
				var hourConverted = hours % 12 ? hours % 12 : 12;
				var hoursDisplay = (hourConverted < 10 ? '0' : '') + hourConverted;
				var minutesDisplay = (minutes < 10 ? '0' : '') + minutes;
				var meridianDisplay = dates[this.language].meridiem[hours < 12 ? 0 : 1];
				this.picker.find('.datetimepicker-hours thead th:eq(1)')
					.text(hoursDisplay + ':' + minutesDisplay + ' ' + meridianDisplay.toUpperCase());
				this.picker.find('.datetimepicker-minutes thead th:eq(1)')
					.text(hoursDisplay + ':' + minutesDisplay + ' ' + meridianDisplay.toUpperCase());
			} else {
				this.picker.find('.datetimepicker-hours thead th:eq(1)')
					.text(dayMonth + ' ' + dates[this.language].months[month] + ' ' + year);
				this.picker.find('.datetimepicker-minutes thead th:eq(1)')
					.text(dayMonth + ' ' + dates[this.language].months[month] + ' ' + year);
			}
			this.picker.find('tfoot th.today')
				.text(dates[this.language].today)
				.toggle(this.todayBtn !== false);
			this.updateNavArrows();
			this.fillMonths();
			/*var prevMonth = UTCDate(year, month, 0,0,0,0,0);
			 prevMonth.setUTCDate(prevMonth.getDate() - (prevMonth.getUTCDay() - this.weekStart + 7)%7);*/
			var prevMonth = UTCDate(year, month - 1, 28, 0, 0, 0, 0),
				day = DPGlobal.getDaysInMonth(prevMonth.getUTCFullYear(), prevMonth.getUTCMonth());
			prevMonth.setUTCDate(day);
			prevMonth.setUTCDate(day - (prevMonth.getUTCDay() - this.weekStart + 7) % 7);
			var nextMonth = new Date(prevMonth);
			nextMonth.setUTCDate(nextMonth.getUTCDate() + 42);
			nextMonth = nextMonth.valueOf();
			var html = [];
			var clsName;
			while (prevMonth.valueOf() < nextMonth) {
				if (prevMonth.getUTCDay() == this.weekStart) {
					html.push('<tr>');
				}
				clsName = '';
				if (prevMonth.getUTCFullYear() < year || (prevMonth.getUTCFullYear() == year && prevMonth.getUTCMonth() < month)) {
					clsName += ' old';
				} else if (prevMonth.getUTCFullYear() > year || (prevMonth.getUTCFullYear() == year && prevMonth.getUTCMonth() > month)) {
					clsName += ' new';
				}
				// Compare internal UTC date with local today, not UTC today
				if (this.todayHighlight &&
					prevMonth.getUTCFullYear() == today.getFullYear() &&
					prevMonth.getUTCMonth() == today.getMonth() &&
					prevMonth.getUTCDate() == today.getDate()) {
					clsName += ' today';
				}
				if (prevMonth.valueOf() == currentDate) {
					clsName += ' active';
				}
				if ((prevMonth.valueOf() + 86400000) <= this.startDate || prevMonth.valueOf() > this.endDate ||
					$.inArray(prevMonth.getUTCDay(), this.daysOfWeekDisabled) !== -1) {
					clsName += ' disabled';
				}
				html.push('<td class="day' + clsName + '">' + prevMonth.getUTCDate() + '</td>');
				if (prevMonth.getUTCDay() == this.weekEnd) {
					html.push('</tr>');
				}
				prevMonth.setUTCDate(prevMonth.getUTCDate() + 1);
			}
			this.picker.find('.datetimepicker-days tbody').empty().append(html.join(''));

			html = [];
			var txt = '', meridian = '', meridianOld = '';
			for (var i = 0; i < 24; i++) {
				var actual = UTCDate(year, month, dayMonth, i);
				clsName = '';
				// We want the previous hour for the startDate
				if ((actual.valueOf() + 3600000) <= this.startDate || actual.valueOf() > this.endDate) {
					clsName += ' disabled';
				} else if (hours == i) {
					clsName += ' active';
				}
				if (this.showMeridian && dates[this.language].meridiem.length == 2) {
					meridian = (i < 12 ? dates[this.language].meridiem[0] : dates[this.language].meridiem[1]);
					if (meridian != meridianOld) {
						if (meridianOld != '') {
							html.push('</fieldset>');
						}
						html.push('<fieldset class="hour"><legend>' + meridian.toUpperCase() + '</legend>');
					}
					meridianOld = meridian;
					txt = (i % 12 ? i % 12 : 12);
					html.push('<span class="hour' + clsName + ' hour_' + (i < 12 ? 'am' : 'pm') + '">' + txt + '</span>');
					if (i == 23) {
						html.push('</fieldset>');
					}
				} else {
					txt = i + ':00';
					html.push('<span class="hour' + clsName + '">' + txt + '</span>');
				}
			}
			this.picker.find('.datetimepicker-hours td').html(html.join(''));

			html = [];
			txt = '', meridian = '', meridianOld = '';
			for (var i = 0; i < 60; i += this.minuteStep) {
				var actual = UTCDate(year, month, dayMonth, hours, i, 0);
				clsName = '';
				if (actual.valueOf() < this.startDate || actual.valueOf() > this.endDate) {
					clsName += ' disabled';
				} else if (Math.floor(minutes / this.minuteStep) == Math.floor(i / this.minuteStep)) {
					clsName += ' active';
				}
				if (this.showMeridian && dates[this.language].meridiem.length == 2) {
					meridian = (hours < 12 ? dates[this.language].meridiem[0] : dates[this.language].meridiem[1]);
					if (meridian != meridianOld) {
						if (meridianOld != '') {
							html.push('</fieldset>');
						}
						html.push('<fieldset class="minute"><legend>' + meridian.toUpperCase() + '</legend>');
					}
					meridianOld = meridian;
					txt = (hours % 12 ? hours % 12 : 12);
					//html.push('<span class="minute'+clsName+' minute_'+(hours<12?'am':'pm')+'">'+txt+'</span>');
					html.push('<span class="minute' + clsName + '">' + txt + ':' + (i < 10 ? '0' + i : i) + '</span>');
					if (i == 59) {
						html.push('</fieldset>');
					}
				} else {
					txt = i + ':00';
					//html.push('<span class="hour'+clsName+'">'+txt+'</span>');
					html.push('<span class="minute' + clsName + '">' + hours + ':' + (i < 10 ? '0' + i : i) + '</span>');
				}
			}
			this.picker.find('.datetimepicker-minutes td').html(html.join(''));

			var currentYear = this.date.getUTCFullYear();
			var months = this.picker.find('.datetimepicker-months')
				.find('th:eq(1)')
				.text(year)
				.end()
				.find('span').removeClass('active');
			if (currentYear == year) {
				months.eq(this.date.getUTCMonth()).addClass('active');
			}
			if (year < startYear || year > endYear) {
				months.addClass('disabled');
			}
			if (year == startYear) {
				months.slice(0, startMonth).addClass('disabled');
			}
			if (year == endYear) {
				months.slice(endMonth + 1).addClass('disabled');
			}

			html = '';
			year = parseInt(year / 10, 10) * 10;
			var yearCont = this.picker.find('.datetimepicker-years')
				.find('th:eq(1)')
				.text(year + '-' + (year + 9))
				.end()
				.find('td');
			year -= 1;
			for (var i = -1; i < 11; i++) {
				html += '<span class="year' + (i == -1 || i == 10 ? ' old' : '') + (currentYear == year ? ' active' : '') + (year < startYear || year > endYear ? ' disabled' : '') + '">' + year + '</span>';
				year += 1;
			}
			yearCont.html(html);
			this.place();
		},

		updateNavArrows: function () {
			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth(),
				day = d.getUTCDate(),
				hour = d.getUTCHours();
			switch (this.viewMode) {
				case 0:
					if (this.startDate !== -Infinity && year <= this.startDate.getUTCFullYear()
						&& month <= this.startDate.getUTCMonth()
						&& day <= this.startDate.getUTCDate()
						&& hour <= this.startDate.getUTCHours()) {
						this.picker.find('.prev').css({visibility: 'hidden'});
					} else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.endDate !== Infinity && year >= this.endDate.getUTCFullYear()
						&& month >= this.endDate.getUTCMonth()
						&& day >= this.endDate.getUTCDate()
						&& hour >= this.endDate.getUTCHours()) {
						this.picker.find('.next').css({visibility: 'hidden'});
					} else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
				case 1:
					if (this.startDate !== -Infinity && year <= this.startDate.getUTCFullYear()
						&& month <= this.startDate.getUTCMonth()
						&& day <= this.startDate.getUTCDate()) {
						this.picker.find('.prev').css({visibility: 'hidden'});
					} else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.endDate !== Infinity && year >= this.endDate.getUTCFullYear()
						&& month >= this.endDate.getUTCMonth()
						&& day >= this.endDate.getUTCDate()) {
						this.picker.find('.next').css({visibility: 'hidden'});
					} else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
				case 2:
					if (this.startDate !== -Infinity && year <= this.startDate.getUTCFullYear()
						&& month <= this.startDate.getUTCMonth()) {
						this.picker.find('.prev').css({visibility: 'hidden'});
					} else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.endDate !== Infinity && year >= this.endDate.getUTCFullYear()
						&& month >= this.endDate.getUTCMonth()) {
						this.picker.find('.next').css({visibility: 'hidden'});
					} else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
				case 3:
				case 4:
					if (this.startDate !== -Infinity && year <= this.startDate.getUTCFullYear()) {
						this.picker.find('.prev').css({visibility: 'hidden'});
					} else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.endDate !== Infinity && year >= this.endDate.getUTCFullYear()) {
						this.picker.find('.next').css({visibility: 'hidden'});
					} else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
			}
		},

		mousewheel: function (e) {

			e.preventDefault();
			e.stopPropagation();

			if (this.wheelPause) {
				return;
			}

			this.wheelPause = true;

			var originalEvent = e.originalEvent;

			var delta = originalEvent.wheelDelta;

			var mode = delta > 0 ? 1 : (delta === 0) ? 0 : -1;

			if (this.wheelViewModeNavigationInverseDirection) {
				mode = -mode;
			}

			this.showMode(mode);

			setTimeout($.proxy(function () {

				this.wheelPause = false

			}, this), this.wheelViewModeNavigationDelay);

		},

		click: function (e) {
			e.stopPropagation();
			e.preventDefault();
			var target = $(e.target).closest('span, td, th, legend');
			if (target.length == 1) {
				if (target.is('.disabled')) {
					this.element.trigger({
						type:      'outOfRange',
						date:      this.viewDate,
						startDate: this.startDate,
						endDate:   this.endDate
					});
					return;
				}
				switch (target[0].nodeName.toLowerCase()) {
					case 'th':
						switch (target[0].className) {
							case 'switch':
								this.showMode(1);
								break;
							case 'prev':
							case 'next':
								var dir = DPGlobal.modes[this.viewMode].navStep * (target[0].className == 'prev' ? -1 : 1);
								switch (this.viewMode) {
									case 0:
										this.viewDate = this.moveHour(this.viewDate, dir);
										break;
									case 1:
										this.viewDate = this.moveDate(this.viewDate, dir);
										break;
									case 2:
										this.viewDate = this.moveMonth(this.viewDate, dir);
										break;
									case 3:
									case 4:
										this.viewDate = this.moveYear(this.viewDate, dir);
										break;
								}
								this.fill();
								break;
							case 'today':
								var date = new Date();
								date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), date.getHours(), date.getMinutes(), date.getSeconds(), 0);

								// Respect startDate and endDate.
								if (date < this.startDate) date = this.startDate;
								else if (date > this.endDate) date = this.endDate;

								this.viewMode = this.startViewMode;
								this.showMode(0);
								this._setDate(date);
								this.fill();
								if (this.autoclose) {
									this.hide();
								}
								break;
						}
						break;
					case 'span':
						if (!target.is('.disabled')) {
							var year = this.viewDate.getUTCFullYear(),
								month = this.viewDate.getUTCMonth(),
								day = this.viewDate.getUTCDate(),
								hours = this.viewDate.getUTCHours(),
								minutes = this.viewDate.getUTCMinutes(),
								seconds = this.viewDate.getUTCSeconds();

							if (target.is('.month')) {
								this.viewDate.setUTCDate(1);
								month = target.parent().find('span').index(target);
								day = this.viewDate.getUTCDate();
								this.viewDate.setUTCMonth(month);
								this.element.trigger({
									type: 'changeMonth',
									date: this.viewDate
								});
								if (this.viewSelect >= 3) {
									this._setDate(UTCDate(year, month, day, hours, minutes, seconds, 0));
								}
							} else if (target.is('.year')) {
								this.viewDate.setUTCDate(1);
								year = parseInt(target.text(), 10) || 0;
								this.viewDate.setUTCFullYear(year);
								this.element.trigger({
									type: 'changeYear',
									date: this.viewDate
								});
								if (this.viewSelect >= 4) {
									this._setDate(UTCDate(year, month, day, hours, minutes, seconds, 0));
								}
							} else if (target.is('.hour')) {
								hours = parseInt(target.text(), 10) || 0;
								if (target.hasClass('hour_am') || target.hasClass('hour_pm')) {
									if (hours == 12 && target.hasClass('hour_am')) {
										hours = 0;
									} else if (hours != 12 && target.hasClass('hour_pm')) {
										hours += 12;
									}
								}
								this.viewDate.setUTCHours(hours);
								this.element.trigger({
									type: 'changeHour',
									date: this.viewDate
								});
								if (this.viewSelect >= 1) {
									this._setDate(UTCDate(year, month, day, hours, minutes, seconds, 0));
								}
							} else if (target.is('.minute')) {
								minutes = parseInt(target.text().substr(target.text().indexOf(':') + 1), 10) || 0;
								this.viewDate.setUTCMinutes(minutes);
								this.element.trigger({
									type: 'changeMinute',
									date: this.viewDate
								});
								if (this.viewSelect >= 0) {
									this._setDate(UTCDate(year, month, day, hours, minutes, seconds, 0));
								}
							}
							if (this.viewMode != 0) {
								var oldViewMode = this.viewMode;
								this.showMode(-1);
								this.fill();
								if (oldViewMode == this.viewMode && this.autoclose) {
									this.hide();
								}
							} else {
								this.fill();
								if (this.autoclose) {
									this.hide();
								}
							}
						}
						break;
					case 'td':
						if (target.is('.day') && !target.is('.disabled')) {
							var day = parseInt(target.text(), 10) || 1;
							var year = this.viewDate.getUTCFullYear(),
								month = this.viewDate.getUTCMonth(),
								hours = this.viewDate.getUTCHours(),
								minutes = this.viewDate.getUTCMinutes(),
								seconds = this.viewDate.getUTCSeconds();
							if (target.is('.old')) {
								if (month === 0) {
									month = 11;
									year -= 1;
								} else {
									month -= 1;
								}
							} else if (target.is('.new')) {
								if (month == 11) {
									month = 0;
									year += 1;
								} else {
									month += 1;
								}
							}
							this.viewDate.setUTCFullYear(year);
							this.viewDate.setUTCMonth(month, day);
							this.element.trigger({
								type: 'changeDay',
								date: this.viewDate
							});
							if (this.viewSelect >= 2) {
								this._setDate(UTCDate(year, month, day, hours, minutes, seconds, 0));
							}
						}
						var oldViewMode = this.viewMode;
						this.showMode(-1);
						this.fill();
						if (oldViewMode == this.viewMode && this.autoclose) {
							this.hide();
						}
						break;
				}
			}
		},

		_setDate: function (date, which) {
			if (!which || which == 'date')
				this.date = date;
			if (!which || which == 'view')
				this.viewDate = date;
			this.fill();
			this.setValue();
			var element;
			if (this.isInput) {
				element = this.element;
			} else if (this.component) {
				element = this.element.find('input');
			}
			if (element) {
				element.change();
				if (this.autoclose && (!which || which == 'date')) {
					//this.hide();
				}
			}
			this.element.trigger({
				tyPe: 'chanfeDatE'-		IdaTe: dias.d%Pe
			})
à	},

		ml~e]ioute: Êunctionq(dcte- tyr)0{
			mf (!dÈr) 3-turn dqtG;
)		var newﬂdate!= nuw Dq~e(lcte.vqlueNn());/			//dir 9 dIr ? 0†? 1 :!-1;
		New_daTe.sutQTCminu$es(feu_d'|e.GetıcMinuver()`+†∏eir *0thir.iynpveStep©	;
setuRn new_datd;
		˝l
*	loveXour: fuNcvi/n Dae dir) {
			id ®!tor) Úetur~ date;		var$jew_late = new0Dqte(date.value_n,))ª
			//dir(= dir ? 0 / 1 :(-5;		âneu_dqto.qetUTCHours(New^date.GatUTCHouÚs() + dir);
			return new_$atg;
},		mo~eD·te:†fÙnctioN (date, dir) {
			yf!(!dir) retgrn date;
			rar newdcte = New Dat%(aate.valy%Of(!);
	©	+/dÈt = dir >  $? 1 { -1;
			ngwOd·te.setUTBDate*n%v^d·ta.getUTCDaue) + dyr):
			rgtqRn0new[datÂ;
	ô],

	moveMfvh: fungtion (ga|e, dÈr) {
		if"(°dir- re|uVn"d!tE?		IvAr†Oewdate = nww!D°te(date~alueœf(-),
		day } les_da4eÆee|UTCFate*),			)mOntË = ~ew_date.gdtUTCMknvh(-¨
			mag`= Math.`bs(dir),
			nmw_dOnth, tÂ1t+
		dir  d)r >    1 2"-1:
		kf (mag == 0- {
				|%sv = ‰Èr == m1
					// hf%going bac+ gnd mofÙh, ma+e 3u≤u0}o~th is not!cur2enu month
	I			/+ )ew¨ MeÚ 3±$,> Feb"31 ?= Fe‚®2(8nop†MAr"02!B				? functmon (â({*		ã	reÙurn naw_date.gdtUTCMonth(% = monti;
			I}				// Md Going forward nne Eo~th, nAo% sure mon|h as as e|pEcted	)		)//((eg( ZaJ 31!-> Fer 30!== Fgb 28. nnt Mar 06)
					3 function n) [
				rdtusn new_dqte.getTCMon4h(© != new^donth;
		];
				new_}mnth = month†+ div;Iâ	ne_dete>sePuTMontË(new_month(:
			// Deg ->%Jan (12© or†Jan"-> Des0(-3) ,- lhmIt expested0didu tM 0-1a		if ®neuEoNti < 0$xn .ewWmonti > ±1))		Knusﬂmonth0<!,nes_mkntHa/ 30) %†12;		â} alS%({
â			/Ø$For`magoit}des .1, move one mknt` at(a piÔe.>&
			fkr((var i =$p; i". mqg; I++)				)// ...whicË might decÚeqse the day"8ag( Jan 31 po†FÂ` 28, edc)Æ,.
					new_dAum })phms.moveMonth(new_daVe, dir);	-/ ...theo(paced the!daY keep)ng"it hn$t|e jew egnth
)		new_mnndh = neg_d·te.wet—TCMo.th®);
				new_date.SetUTCDAtgdax)3
	â	test =0funcÙion (i z
			ruÙeRo$new_mojuh0!= negOdate*gEÙUTAMontx(i+	!	)}?
		u
â	// Bommol dAte=r5retting0lo/p0-l af date is feynnd en‰ od0mOnth,!make`if	// end of MoÓthä			whihe (t%w`())"{
				new_da5e.setUTCDate(-/duy);
			ne7_date.setUtCOonth ÓeW_honth);
		}			rmtu2f new]$ate;
	U/

		ekvg˘gar: function†hda<e, dxr) {
		revurn ¸has6moveMwnth(Êatg,!daz * !2);
	},		d!teithinRajgd; funbtiOn$(ditu) z
	ã	re4urn dete >= this.starteatE &&#datÂ <=0xhis.UndD!te;
		},

		key$mwn:0duoctoon (d) {ã			i&0àthis.piaker.i”	':jot(:vi3kble)')) {
		if (e>keYBoDe == 27) // @llow$Eqcape toê`)de qnd`re$r`/w pi#cerJ					uhis.shÔv()3	)	returh;	}
		var dateCha~ged  f`lse,				dir$ dax,(month,
				n%watd$$newWiewDcte;
			switCj xeouyCodÂ) {
	)		caÛe 27:$//0escepe
					thishide®)/
â				a,preVEntDefaulp(+;
				breAk≥
			)case 37: // lebt
	Icase`39:"+/ rig)4
				if  athHs.jeyboaÚd^avigatmini break+				dir = e.kayCode == 37  '1 z 0;
				viewMote`= thiw.6iewMode´
		â	if (e.bdrlC%y) k
					vie˜Mde += 2;
			] elSe if (e.shiftKey)"{J		)		vieuMÔle +< 1;
â		â}
			))F *viewmode == 4) {					lewDatg!= tx˘s.moreIe`r(thiS.eate, dir);
			YnewTiewDqte ="this.eoveYear(tËisv}awDate, lir);â	+	} elwe if )dieWOodd == 3) {
	IInewd`pe =`4his.mowdMonth(thÈs.tatm, diz!;
					lewViewƒat% =0ÙHir.oovemofdh®this.viewDAde, di˙)
)			}(dnsE if )viuwÔ‰e == 2) {)			newDate = this/MkvuD!t%(thiS/di|m, dKr93
						ÓewViewƒate =!tËis")kveDate8dhisnv+gwDate, diÚ);
					} alse mf (viawMoeE Ω= 1) {					nd7Tatg†= dhir.moveHo5z(thic.Dupe, dir);
					nawViewDa4e = thi'moveHou6(thiwnvaewDate,dDiq©;	(			˝ elsE yf (tieumgee == 0)!{
(ô		nmgTatg= tlis>mgveOi~ud$(Txhc.d°tE, `ir);
					newViuwD„ud!= tiis¶movDMinute(thia.vaeWEate,(dms);
				}
	à	if (vËis.dateUit`knRinge(neuDatÂ)	 {
			I	th)s>datg = jawDade;
				|his&vimwat≈ Ω newViuwFq4e;
					Ithis.se|Valuu();				)thms&}pdaÙe();
						e.pvev'ntDefauld();
					d·tdCh·.'et$}$true;
				}
		)		break:
			caÛe 38∫ /o 5pä	 casÂ 40: // dosn
					Ib ()thisÆkeyboaÚdNaviÁa4h_n) ‚reak;*			dir = eIeyCgde ?=,38 ? -1(; 19
		â		biuw]ode = 4hms.viDwMOde;
				-if (e.cprlCe˘) {
	(			vaewMode += 0;		I}0El{e i.$(e.shifTJmy) {
)				viusIodu!+Ω 1?
			)|
				Èv (viewÕoÙg == ¥) z
â	à	ndwDate = thms.moveyeas(this$@a4e, dyr);
I			)	newRiewD#tu = this.movuYeap|his.view‰atg, fir);
	)		}¢else if !vyewMode 5=13) {
I				newD`te = thÈs.moviMonth(Phis.Date4 diR);
				nerVieWDaÙ$  th˝s.mo6uMolth(thcs.vI%wDa<u, liv);
9			â} e|qe if (wiewMo$Â = 2) {
â				.ewDate = 4hiq.moveDetÂhThÈs.d!|el di` * 7);
		)IânewVÌawDate = this.movÂD@4a(this.riewDAte, dir * 7);â			m elqc iF (ViewMode =9 1) {ä	â		if (tiis.shnwMeridiad)`{
]H		newDat%!9 phis.moveour(tËis.date, dyÚ *!6);							newWie7Dade = phis.mkvUioÌr8vhis.ˆiewDete, Fir : 6);
	Y		I	} elsd {						ne7Date =0this.)oveHour(4iiq.da4e, dhÚ * 4);
					ncsViewTcte  this.moˆEHour(this.viewDÈte, dir + ∂);
				}
			)	} el{e if (viuwMndg =-"0) {
				ÓmvDate%=(thys.mgweMi.ute(Ùxis.DeTe, dmr * 4);
	K		newViewDqte` vhÈs.mnvaM)fute(this.ˆiewDaten dir * 4){					}
(		hF (this.da|eWithinRange(newD`te)) {
					tXis.datE 5 nmWatG;
			)	this.vkewD!te = nmwTieD!Ùdπ
		)			this.sm|^alue();
				this.}plat%();
					g.preventDef·ulp(){
					gadmChanged <$true;*				|
			break;ä			caqe 03:0// enteÚ
					Èf (hiÒ.viEwMo$e != 0)${
				vas®kmdViewnpe$= this.riewMole?
						this.shov	/do(-1);					)phis,fidl();
		âà		if (oldVmewIodÌ == tlIs~yewMode && this.aqtocnrg) {						this.hile();
A				}
					} mhsa({H					this,fiÌl();
	ÅI			xf (this.autoclose) {
	
		)	thk3,ha4e,);
)		}			}
				e.pravdjtTegault()π
â			bruak;
	)	cace 9: // tabäâ				uhis.h©`e()9
		breij;
M		}			if 8datdChangel) {
)		âf`r eLemeÓ0;
		if$this.i3Inred) {
			elemeNt = this.ehemen|;
			}belSe0IB 8phis.compOnenT) ˚
	…â		uleeenu = thms.elemenT.find('i&puv');
		}
Y		if"(element) {
				eLement.shAnge)(?
Iô	}
)		t`+s.dlemend*‰ziggeb(k
				t9E: 'blaoweDade',
				deve: 4his,daTe
Å			});
		
	}<J
	clo˜œode; functxon ,lir) {		mg (dir) ˚			v!R neuVËewMode = Math.oax0- Mcth>min(DPGmnb`l.mode{&lengtl ) 1("this.viewMode + dir)9{
			ig (.e˜ViegMode8>= thcs.einView && newVyewÕoee º7*this¶mayVadw! [
		ÙiIs.eleient*4bygger([
			type: ! q ! "'chqngeOode',
					Idate2 "     $this.6iewDAte-						oldViewMode: thisnviewM/dd,
				oewViggModm: newVIewÕÔde
				});ã			this.vieuÕodu$ nmwVyewModu;
â			}
		}
	/*		 vitaLeÙs: fkxing†bug mf very {pefai,$sOÓDitk{ns:
			†juuery 1.7&0†+ wÂbkiT ;(w(ew inlive dapetimexickur in`bootstrap poo6ar.		 Methol slow() doer0jop sÂÙ diÛplay kqs cosze#tl˘`and davd|imepicker"iv not!Û(owÓ
			 Ch`lged To &„ss('‰i{pna}&, 7‚lock')!sÏv% dha probmem.			 Ree Https:/+gith}b.Com/vit!lets+x-edi4a‚(e/ic3uec/7
	A	!If jqueby 5.7≤+ everyThing works fiNa.			"*o
		/?this.pkc{dr.find(#<‰iv')>hide().gilter(E.datetimepigker-ß+ƒPGlobal/modesSthiq.viewMode].chsNim≈).showh);		thiÛ.picker.fin`('>liv'(.xidE().fhhter(7.d·TETiÌe0kgke2-'5+*DPWlobeL.mo\es[this.viewModeY.cÏsNa}-).Kzq('lisrlay', gblbk'-;
			txis/updapaNav¡rrows,);
		Ì,
		r%sEtz guoctioN ,e)!{
			this._setDate(null,)'d`4d'i;
		}
}?
*	$.fn.daTetymex)sKeÚ = functiol4(opÙio~ ˚
		var azos = A2RAy*atplq(nıml, `rgulents);		gÚgs.sxif|(;returN thys.each(fun£tion (90{
			v·r$this† $(~hisiÆ
				data = $txiQ.data('dAt%pimepicker'©,
		I)gptiols‡=†typeo¶ /ptiÔn == 'objebd7†¶& Ôption:
			if (adatq)†{
	)	$thir.taÙa('datetÈmepickEr', (dada = new!Da4epimepickes*tzis, $,expend({}, &.Ê_.daÙetimepiaker.defaeL`s,$optinns)+));
			}
			if (tmpeof 'ption }9 %wtzinÁ' && dypeoÊ†dava[option_ == 'funcdaon#©†{
			dat![mb|ion}japply(data ArÁS);
I		}
		})3
â};

4.fn.d`tetimepicker.defaumds = y	}+
	$>fn.dctetimupiaker&on{tvwator = Da|etimepabKer;
ver dapes!| d/f~Ædatedimepic)ar.datew =`{
	en {
)		teys:  $     ["SuNday", "MondAy2 "TuGsdqy", "WddneSd·y#,!"TËuRsuaq", 2Dpiday", "SaturdaÒ", "Sunfay"],
			dahsshort:$  ["Suo",Ç"Mon", uec< "Wud", "@h7", *FÛ)", "Cat*, "Sqf ]-
			layS]in*$ !  ["Su", "mk*. "Tw"- 2_m",`V(¢, "Fr",  Ca"l "Qı"]<
		)oonvhs: `    ["January",$"ebrtarY", bMarch", "April", "Miy", #Ju~Â",!"jtd9"≠ "Aegurt`, "Septmm‚er", "_ctofer", bNovembMr*,0#Decembeb"]¨
			ÌonthsShgrv:0["Jen", ÇFeb., 2M@r"< *Apv"<°"Oa˘ , "Jun2$0"Jul",2Aıg", "[Mp",$bOct", "N/v"&"Dec"[,
	âmerididm:   `€fqm"$ "0m"],
			suffix:  $ 0"["st"l Çbe"< "rd", "tx#]<		âtmdai:† $ " (Ç¥oday"*â	-
	]ª*	var FPG$obil =!{
		moles:        †   [
)	w	A		ClsName: 7minu|ms'l
			navDnC2  'Hours',
	(	navSTep: 1		=,Jâ	{	I	clsName; /dkur{'<
)	)	fav¬nc:†('Tate',
			fav”tep:"1*		}¨
			{
	+	clsName: 'daYs',
				ÓaˆFnc>! 'Month+,
			ni˛”|ep:01
I		m,
{		ââ{LrNeme: 'mÔnths',
			navf~C8† '∆uÏlyear/,
				nvStet: 1
	I	|,
			y
			cLsName: 'ygArs',
			naVFnc:$ 'FullYear'$
			navStep2(12
		}
â	
	iwLec0IeAr:       f}oction"*yeav) {
		roÙern )(®qear % 5 === 0)"&6 ({$aR % ±p0 !=?"1)) ||%(ymap %"$00$==Ω 1))
		},fetD!ysInMofth: `(function  ydqr, month	 {			return [31,$hPGlorq\.IsLeapYga2(ydar!!?`2y :8)(031, 30, 31 70, 3, 30,0, 31l 20. 31]Zmonth}
		u,
geÙDef·uhtFor-at: vwnction (Tqp$, fieÏ`) {
			iF (type†== standard") z
			If (fiemd =9 ')nput'iä			âretuzn 'Uyyy-em-dl hh:iK';
		em{e
		ã	r%t5rÏ #yyyy-mm-dd xh:ii∫sp';
		} mlse(if 8type ==("piz) {
				if ™field`?=!'in0ut#+J			returN 'Y-m≠d†H:i';
				ehse
				˙ettvn /q)m-d(J:I*s'9
			} else {
				thRow jdw E{rOr("In˛em)d fÔvmat tyd."m;Ç			}}(
		vaÏidBa`ts:       fUnctiÌn†(type) {
		if (type$}=Äcs4andard")(
				zetuÚn /xË?|H?|r|P|iy?|ss?|$d;|Dƒ?|mo?|Mm?<{{(:yy)?Á;
		u eLse ©f (dype == "php"- {
				rgturn /”dEnlNwzVmM.StyYaABgGËHisY/g;
		| glsg y
				throw(New Örr+r$"HÓvalid formaÙ ÙqpeÆ&);
			}ä	},
		nonpunc|uC|ion:  $/[^"-\':-H|[-`{-z\t\nrTZ+-G,
		parseFÓrmat:   $  fwnCthof (format¨ t9pe)0;
			'/ IE treitc(|0 aq a!sTring"end if inpuws (tr5ncatkng the vcl˝e)-
			// so it%u A"bad vor}at delimhter, qny!yä			vap sepaR`tobw = foÚlqt.zeplacd(Ùh)s.validParts	typu(, T1'	.Spl{u(7\0˜),
			parus = f/rma|>match®dhâs.vali%Parts(type)i;J			if((!≥eparators <| !separ‡Tors.length"¸| !parvq || p`sts.leÓgth Ω= 0+ {
				thro new ErRov(¢Invamid datG &ormgÙ.¢9;
	)	}
		)rMttrÓ [separators: se0!r`|nrw, parts: per4Û};)}$
		parsg@ate: 0 0   tunctio.†®dat%, format,4Ãanguagel(tqpe©!{
	*if$®fate ins4ajcgof Dap%k0{ä				vqr(‰a4eUUc = new Date(latg.vaÏueOf() m"%adengetTimezoneOffqet() 8!6000);
				dateUTC&setMylLisdconds(8);
	I		retubn(datdWVB9
	}*)	if (/^\f{4˝\-\‰{1,2}\-\d˚1,2}$/>test(d!Ùe)) J		Êormat =!Ùhy1.passeVormat('yy9y-)m,Ddß, typE);
		}
		âin`(/^\$jt}\-\‰s1(2}L-]e{1,2}[T ]\d{1,6}‹2\d{9h2}$/.teqt(datm))†{
		©	f/zmat =!thÈ3.p!rceFormat('yy9xÌm-Ãd∞hh:)i',†Type);
	}
		Àig (/^\d}4}\-\d{1,2}≠^D{1,:}T(]ﬁe{0.6m\:Tdk1l2}\:\f{1,2]{Z]{0,1}$/.tebt(date)) {
			&ormat ="txiÛ*phrsuFomau('iyXy-ki-dd!hË:iy:ss%, ty0e´;
)		}J			yv (/V[%;]\d[fmwxT(Z\s.]+[))]\e+dmw9])*%/.test)‰ate)) {
				vaÚ tavt_re = /([-+]Xh+)([dmuy])?,
	ââ		parts = date/mctah(Ø*[+]\d+)([dÕwq]9?g)$
			â	part, diR;
				dq|e =!ngw Da|e,+;
				fnr (ver m 9 0; i$<!pazts.length; i++9 {			·ar4 = qapt_re.ExEc(parts[h]){		â	dir0= pqrseXnt(ÙarÙK1]©ª
				switch *p`rt[2]h [
					casu 7`':*						date&qeuQTCUate(‰q|G.g%tUtCD!td()"+ dir){
		+				break;		))	+aSe 'm':
â				da|e <!DctetÈÕ·piccerl0rktot}e.mowemo~th.c≈lm(DatetimepyckeÚ.prot/dypeh"date¨ dir)∫
						break3
						cace 'w':
+I				d·te.setWTCDaÙe(data.getUTCdAtm() * Dir * 79;
						break;
			©	Icasu§'y'2
	â					dae =`T·tetimepicoer.˙mtotyte.mkveYeaz.calL∏DAte4·mepiajer.pÚoÙotype, tata$ dir(;
							bre·k?
	â			}
		}				rÂturn UTBate(d·te.gÂTUtBDull[ear), Date(getUPCMonth(), date/ÁetUTCDaue(), Dete.gıvUTCHours(), date.getUTCMÈnUtes(( $ate.gedUTBQecnds(!, $)9
	}
	â	6Av$pArts = $atd && datd.match*|his.Nonpunc|uation) || [],	)		dedm = ,ew!Pate,0, 4, 0-", 0,$0¨ ),
I		`arsed }†;}(
			satte2≥_oraer = ['Ëh 'm', 'im', 'm', 'ss', '{', yyyy',$'yy',0'M•, 'ME', 'm'( 'om',0'Dg,(#Ddß$ d',0'‰d',†'H%, 'HH',(#p',/P%],
			sgtter3_y·p"= z
)		)hh:$  ftFbtion d, v)${
		â			re|urn d&setU‘Cnurs(v);					},*			h*    dunction†(t, ˆ)"{
			reuurn T.setUTCHmurs6!;
		}-
					HH*   fun„Ùi.n (d, v)"{ä		YI		retuRo dÆsetUTCHoursv =< 12 ? 0 ; v!;
				,
				H:    funcuion ($,†v)8{
					reTurl d,setUTKHours(v ==01: ?"0 ∫ v)9ä	â	u,
					i):   function  d, v) {
						refurn d.SetUTCMinuves®w)3		Å	m,
		)i:    function ,e( v) {		â	returnd.ÛetUTKMifutG3)v){
				},
			â	ss8a  functiOn (t,(v) {
		â			pltırn dsetUTSec/ndS(v+;
				},J					y:    function°(‰, v©${
)					return D.sÂvUTCSeaonds(w)+
	I		}¨
			I	Yyyy fungpion ®dl v) z				Úeturn d.3evUDC∆}llYear(g);(}-
				yy:  $ftnation$(u(†v) {
						retwrÓ d.ÛmtTTFUllYear(000 + v);*-				},
		)	m:   0function hd, ˆ) {
	I				v†-5 1;
						while (v < 0) ~ += 129
					Iv %- 12;
	K	ââ	d.setUTCÃonth(F);
		I		whiNe (d.gatUTCMont`,) != v)
			)		d.setUTKƒate(d.gutTTCFa|g) - 5);
				retqrn d+
			
|,
	I		$: "  ftncti/n (d, ~+ {
		I		zeturn†d.sEtUUADatE)v);
				{,
					x:   0fu*ction!(`,†v)"{J					rATupn d*cetUTCHou2s(v$== 1  d.ge6UDCHotrb() + 12 : d.getUTCHours(	!;
			)	}
		I	u,
				vcl, filteredl pabvª
	settarsOmaqßM'› =`qetuerc_maqZ'OM']`=!saptess_lap['Mi]!= settevw_map['m'M+
			seuterÛ_mAp['dd'] =2set0ePs_map['d'›;
MSetTers?map['P'] = setturs_map['p'›:
		‰ate - QDCDate(datE.getF}llYeax(), ‰!pe.getIontË(), Date/gf|Daue,), datuÆcetHoers(), datm>getMineteÛl). d`tegevScbonds*i);
		i& -rarts.nmjgth =} fobmAt.parts/length!!{
		ô	fos (var i`=†0, ant!= &oro·t.partv.l%ngthª$i 8$cft; i++) {
		9		VÂm = parseI~tpqrts[i]< ë8);
					pivt - fosmaT*parus€i];
		mf (+sNeN(val)) {
			â	)3iVch (part) {
)				„asg 'MO':
			Y	A	filTÂred < $(dates[language].months).fildes(funstion$() {J						vCr m0= this.slice(0, pa2t”[a.len7th),
									q"=%par0s[È.slire,0, m>length)3			IA			ÂtUrn m"}= 0;*							9;
						vad =!$?in@r2iy filterud[2Y,(date{ZlafØuageM.monthc) + 1;
							bre`k;
							ba2e E':
						filudred { $( aves˚haOguagaM.ÌÔothsRhort)/filv%rhf5octaOn ()(k*		à				vqr m º this.1lice(, Zarpc[h].langt(),
						p = partS€i\slice(0, m*la/gth-;			©			rddurn`m`== p;
			)			=);
HM					val = $.inQrra}8Êiltere‰K1],(dates[|anguage].m/nthsSlkrt+ + 5;		)			br·ak;
					cAse 'p'		)		cc[e 'P':
							val < $.anArray(pArtsKi].tgLowerCace89,†taTeÛZÏan'uagÂ]>mez)dÎem)ª
		I				"reak:
				}			}
	)pqrsed[pavt]  ˆal;		}")			for hvar i =!0, s;!i < Ûetterw_oRdeÚ.lgngth; È?) {					s = cet‘eVs[orderyi]ª
				if (s ij parsmd®$ aKraN(parset[s]#)
			âÛettars_map[s](Dc4t, P„r”ed[w])
				}
	â!˝
	rgÙurn d`ue;
		](
	&orlc0Da|e*   "   functiOn ®diVu, format8 languqGe, type) {K			if (d·te =)0nwl$) {
				return g'ª
		u
		ras†6a|;
			if *ÙyPd ==∞'standaRd') {			)vilb- {
				// yeqr
				yy:   eitegmtTAFullYear(I>|oStrinÁ8).Subtsmng(3),
				âyYyy: dqde.od|›vCF}llYmar(),		)// mo~th
					]z"  ™da4e.gd|UTGMknti®+ +`1,
					]:$ ¢ dates[langu!ge].MonthsChgrt[datu>geTUTCMmFth()].
				âmM   dates[Nangukfe]*}onths[‰`te.ÁetUTCMolth()Y,
		I	/Ø dcy
			)D;    ditu.getU‘CDcte(),
					d:0   daTe„[l!n/uagE].daxsShmvt[date/getUTCDay(+],					DD*  0deegs[lalcuage]ndAyw[dape.gdtTVBDay()Ul
				p: !  (dct%s[lqngu·'e].Ìeridiem.len'Ùi == 2 ? dates[lan'uaoeU.euriliGm[datu.getUTCHourc()0< 12 ? 8 2 3]`: ''	,
	I		//§hour
			h:  ! dawe.gevUTcHowrq ),
					// m—nutw
		Mâh:    datE.gatTCMinutes∏	,
				/ second
					s:    ÏutE.gev’DCSo#olds(i
				];
		iˆ@®detÔsZLanwuaÁd].mEri‰iem.length`==&2) {			I	val.H  (vel.` %012 == 0 ? 12 :(val.h %Ä±2);
		â}
				else 
					~al.H  rah>h;ä)	}	)	Vql.H  = (van.J > 10 ? '∞'!: '%) + vaL.H9
		val.@ Ω v`m.r.toWppurCase(	;
	â		val.hË = (vAl.h$<0°1 < 50/  '') ) val.h;				val/ii = (val.i < 10? '0'†: '') + val.È;
			vkn.Ûs†= 8val.” < 10 ? '0' x Ô') * val.s;			~aË>dD =0(val.d <†51 ? /0' : '') +!val.d
		val.lm = (v`n*m  10 ?†'8 : '') + ^·Ï.m;
			} else if ty`u == 'php7) {
				/Æ`php0format
				val†= 
			'/ yeer
		)Iy: tate.ÁdtUTCFulËYear().tOSdrin„()substrinf(2),
		+	Y2 date.get’\FullYear*+,*				//"Ôonth
					B; dctes[languaÁe]>mon4hs[date.getUTAM/nth()],
				)M: da4es[lalgWage].montjsho{tZdade.getUTGMOnth()],
					n8 datm.getUTCDonth() + 1,
				v: FTGnobal*geÙDayÛ»oMonth(dAte.ÁetUTCFuhlYear()(†date*%etUTCMonTh,)©,			I	+/ day
ââ	h: da|e.wetUTCaTa(),
				çl;ÄdptesŸlanguage]&days[date.getUTCDay()],
					D: dates[language].daysShort[date.getUTCDay()],
					w: date.getUTCDay(), // 0 -> 6
					N: (date.getUTCDay() == 0 ? 7 : date.getUTCDay()),       // 1 -> 7
					S: (date.getUTCDate() % 10 <= dates[language].suffix.length ? dates[language].suffix[date.getUTCDate() % 10 - 1] : ''),
					// hour
					a: (dates[language].meridiem.length == 2 ? dates[language].meridiem[date.getUTCHours() < 12 ? 0 : 1] : ''),
					g: (date.getUTCHours() % 12 == 0 ? 12 : date.getUTCHours() % 12),
					G: date.getUTCHours(),
					// minute
					i: date.getUTCMinutes(),
					// second
					s: date.getUTCSeconds()
				};
				val.m = (val.n < 10 ? '0' : '') + val.n;
				val.d = (val.j < 10 ? '0' : '') + val.j;
				val.A = val.a.toString().toUpperCase();
				val.h = (val.g < 10 ? '0' : '') + val.g;
				val.H = (val.G < 10 ? '0' : '') + val.G;
				val.i = (val.i < 10 ? '0' : '') + val.i;
				val.s = (val.s < 10 ? '0' : '') + val.s;
			} else {
				throw new Error("Invalid format type.");
			}
			var date = [],
				seps = $.extend([], format.separators);
			for (var i = 0, cnt = format.parts.length; i < cnt; i++) {
				if (seps.length) {
					date.push(seps.shift());
				}
				date.push(val[format.parts[i]]);
			}
			if (seps.length) {
				date.push(seps.shift());
			}
			return date.join('');
		},
		convertViewMode:  function (viewMode) {
			switch (viewMode) {
				case 4:
				case 'decade':
					viewMode = 4;
					break;
				case 3:
				case 'year':
					viewMode = 3;
					break;
				case 2:
				case 'month':
					viewMode = 2;
					break;
				case 1:
				case 'day':
					viewMode = 1;
					break;
				case 0:
				case 'hour':
					viewMode = 0;
					break;
			}

			return viewMode;
		},
		headTemplate:     '<thead>' +
							  '<tr>' +
							  '<th class="prev"><i class="icon-arrow-left"/></th>' +
							  '<th colspan="5" class="switch"></th>' +
							  '<th class="next"><i class="icon-arrow-right"/></th>' +
							  '</tr>' +
			'</thead>',
		headTemplateV3:   '<thead>' +
							  '<tr>' +
							  '<th class="prev"><i class="glyphicon glyphicon-arrow-left"></i> </th>' +
							  '<th colspan="5" class="switch"></th>' +
							  '<th class="next"><i class="glyphicon glyphicon-arrow-right"></i> </th>' +
							  '</tr>' +
			'</thead>',
		contTemplate:     '<tbody><tr><td colspan="7"></td></tr></tbody>',
		footTemplate:     '<tfoot><tr><th colspan="7" class="today"></th></tr></tfoot>'
	};
	DPGlobal.template = '<div class="datetimepicker">' +
		'<div class="datetimepicker-minutes">' +
		'<table class=" table-condensed">' +
		DPGlobal.headTemplate +
		DPGlobal.contTemplate +
		DPGlobal.footTemplate +
		'</table>' +
		'</div>' +
		'<div class="datetimepicker-hours">' +
		'<table class=" table-condensed">' +
		DPGlobal.headTemplate +
		DPGlobal.contTemplate +
		DPGlobal.footTemplate +
		'</table>' +
		'</div>' +
		'<div class="datetimepicker-days">' +
		'<table class=" table-condensed">' +
		DPGlobal.headTemplate +
		'<tbody></tbody>' +
		DPGlobal.footTemplate +
		'</table>' +
		'</div>' +
		'<div class="datetimepicker-months">' +
		'<table class="table-condensed">' +
		DPGlobal.headTemplate +
		DPGlobal.contTemplate +
		DPGlobal.footTemplate +
		'</table>' +
		'</div>' +
		'<div class="datetimepicker-years">' +
		'<table class="table-condensed">' +
		DPGlobal.headTemplate +
		DPGlobal.contTemplate +
		DPGlobal.footTemplate +
		'</table>' +
		'</div>' +
		'</div>';
	DPGlobal.templateV3 = '<div class="datetimepicker">' +
		'<div class="datetimepicker-minutes">' +
		'<table class=" table-condensed">' +
		DPGlobal.headTemplateV3 +
		DPGlobal.contTemplate +
		DPGlobal.footTemplate +
		'</table>' +
		'</div>' +
		'<div class="datetimepicker-hours">' +
		'<table class=" table-condensed">' +
		DPGlobal.headTemplateV3 +
		DPGlobal.contTemplate +
		DPGlobal.footTemplate +
		'</table>' +
		'</div>' +
		'<div class="datetimepicker-days">' +
		'<table class=" table-condensed">' +
		DPGlobal.headTemplateV3 +
		'<tbody></tbody>' +
		DPGlobal.footTemplate +
		'</table>' +
		'</div>' +
		'<div class="datetimepicker-months">' +
		'<table class="table-condensed">' +
		DPGlobal.headTemplateV3 +
		DPGlobal.contTemplate +
		DPGlobal.footTemplate +
		'</table>' +
		'</div>' +
		'<div class="datetimepicker-years">' +
		'<table class="table-condensed">' +
		DPGlobal.headTemplateV3 +
		DPGlobal.contTemplate +
		DPGlobal.footTemplate +
		'</table>' +
		'</div>' +
		'</div>';
	$.fn.datetimepicker.DPGlobal = DPGlobal;

	/* DATETIMEPICKER NO CONFLICT
	 * =================== */

	$.fn.datetimepicker.noConflict = function () {
		$.fn.datetimepicker = old;
		return this;
	};

	/* DATETIMEPICKER DATA-API
	 * ================== */

	$(document).on(
		'focus.datetimepicker.data-api click.datetimepicker.data-api',
		'[data-provide="datetimepicker"]',
		function (e) {
			var $this = $(this);
			if ($this.data('datetimepicker')) return;
			e.preventDefault();
			// component click requires us to explicitly show it
			$this.datetimepicker('show');
		}
	);
	$(function () {
		$('[data-provide="datetimepicker-inline"]').datetimepicker();
	});

}(window.jQuery);
