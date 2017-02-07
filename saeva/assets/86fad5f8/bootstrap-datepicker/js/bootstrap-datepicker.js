/* =========================================================
 * bootstrap-datepicker.js
 * http://www.eyecon.ro/bootstrap-datepicker
 * =========================================================
 * Copyright 2012 Stefan Petre
 * Improvements by Andrew Rowls
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

(function( $ ) {

	var $window = $(window);

	function UTCDate(){
		return new Date(Date.UTC.apply(Date, arguments));
	}
	function UTCToday(){
		var today = new Date();
		return UTCDate(today.getUTCFullYear(), today.getUTCMonth(), today.getUTCDate());
	}


	// Picker object

	var Datepicker = function(element, options) {
		var that = this;

		this._process_options(options);

		this.element = $(element);
		this.isInline = false;
		this.isInput = this.element.is('input');
		this.component = this.element.is('.date') ? this.element.find('.add-on, .btn') : false;
		this.hasInput = this.component && this.element.find('input').length;
		if(this.component && this.component.length === 0)
			this.component = false;

		this.picker = $(DPGlobal.template);
		this._buildEvents();
		this._attachEvents();

		if(this.isInline) {
			this.picker.addClass('datepicker-inline').appendTo(this.element);
		} else {
			this.picker.addClass('datepicker-dropdown dropdown-menu');
		}

		if (this.o.rtl){
			this.picker.addClass('datepicker-rtl');
			this.picker.find('.prev i, .next i')
						.toggleClass('icon-arrow-left icon-arrow-right');
		}


		this.viewMode = this.o.startView;

		if (this.o.calendarWeeks)
			this.picker.find('tfoot th.today')
						.attr('colspan', function(i, val){
							return parseInt(val) + 1;
						});

		this._allow_update = false;

		this.setStartDate(this._o.startDate);
		this.setEndDate(this._o.endDate);
		this.setDaysOfWeekDisabled(this.o.daysOfWeekDisabled);

		this.fillDow();
		this.fillMonths();

		this._allow_update = true;

		this.update();
		this.showMode();

		if(this.isInline) {
			this.show();
		}
	};

	Datepicker.prototype = {
		constructor: Datepicker,

		_process_options: function(opts){
			// Store raw options for reference
			this._o = $.extend({}, this._o, opts);
			// Processed options
			var o = this.o = $.extend({}, this._o);

			// Check if "de-DE" style date is available, if not language should
			// fallback to 2 letter code eg "de"
			var lang = o.language;
			if (!dates[lang]) {
				lang = lang.split('-')[0];
				if (!dates[lang])
					lang = defaults.language;
			}
			o.language = lang;

			switch(o.startView){
				case 2:
				case 'decade':
					o.startView = 2;
					break;
				case 1:
				case 'year':
					o.startView = 1;
					break;
				default:
					o.startView = 0;
			}

			switch (o.minViewMode) {
				case 1:
				case 'months':
					o.minViewMode = 1;
					break;
				case 2:
				case 'years':
					o.minViewMode = 2;
					break;
				default:
					o.minViewMode = 0;
			}

			o.startView = Math.max(o.startView, o.minViewMode);

			o.weekStart %= 7;
			o.weekEnd = ((o.weekStart + 6) % 7);

			var format = DPGlobal.parseFormat(o.format);
			if (o.startDate !== -Infinity) {
				if (!!o.startDate) {
					if (o.startDate instanceof Date)
						o.startDate = this._local_to_utc(this._zero_time(o.startDate));
					else
						o.startDate = DPGlobal.parseDate(o.startDate, format, o.language);
				} else {
					o.startDate = -Infinity;
				}
			}
			if (o.endDate !== Infinity) {
				if (!!o.endDate) {
					if (o.endDate instanceof Date)
						o.endDate = this._local_to_utc(this._zero_time(o.endDate));
					else
						o.endDate = DPGlobal.parseDate(o.endDate, format, o.language);
				} else {
					o.endDate = Infinity;
				}
			}

			o.daysOfWeekDisabled = o.daysOfWeekDisabled||[];
			if (!$.isArray(o.daysOfWeekDisabled))
				o.daysOfWeekDisabled = o.daysOfWeekDisabled.split(/[,\s]*/);
			o.daysOfWeekDisabled = $.map(o.daysOfWeekDisabled, function (d) {
				return parseInt(d, 10);
			});

			var plc = String(o.orientation).toLowerCase().split(/\s+/g),
				_plc = o.orientation.toLowerCase();
			plc = $.grep(plc, function(word){
				return (/^auto|left|right|top|bottom$/).test(word);
			});
			o.orientation = {x: 'auto', y: 'auto'};
			if (!_plc || _plc === 'auto')
				; // no action
			else if (plc.length === 1){
				switch(plc[0]){
					case 'top':
					case 'bottom':
						o.orientation.y = plc[0];
						break;
					case 'left':
					case 'right':
						o.orientation.x = plc[0];
						break;
				}
			}
			else {
				_plc = $.grep(plc, function(word){
					return (/^left|right$/).test(word);
				});
				o.orientation.x = _plc[0] || 'auto';

				_plc = $.grep(plc, function(word){
					return (/^top|bottom$/).test(word);
				});
				o.orientation.y = _plc[0] || 'auto';
			}
		},
		_events: [],
		_secondaryEvents: [],
		_applyEvents: function(evs){
			for (var i=0, el, ev; i<evs.length; i++){
				el = evs[i][0];
				ev = evs[i][1];
				el.on(ev);
			}
		},
		_unapplyEvents: function(evs){
			for (var i=0, el, ev; i<evs.length; i++){
				el = evs[i][0];
				ev = evs[i][1];
				el.off(ev);
			}
		},
		_buildEvents: function(){
			if (this.isInput) { // single input
				this._events = [
					[this.element, {
						focus: $.proxy(this.show, this),
						keyup: $.proxy(this.update, this),
						keydown: $.proxy(this.keydown, this)
					}]
				];
			}
			else if (this.component && this.hasInput){ // component: input + button
				this._events = [
					// For components that are not readonly, allow keyboard nav
					[this.element.find('input'), {
						focus: $.proxy(this.show, this),
						keyup: $.proxy(this.update, this),
						keydown: $.proxy(this.keydown, this)
					}],
					[this.component, {
						click: $.proxy(this.show, this)
					}]
				];
			}
			else if (this.element.is('div')) {  // inline datepicker
				this.isInline = true;
			}
			else {
				this._events = [
					[this.element, {
						click: $.proxy(this.show, this)
					}]
				];
			}

			this._secondaryEvents = [
				[this.picker, {
					click: $.proxy(this.click, this)
				}],
				[$(window), {
					resize: $.proxy(this.place, this)
				}],
				[$(document), {
					mousedown: $.proxy(function (e) {
						// Clicked outside the datepicker, hide it
						if (!(
							this.element.is(e.target) ||
							this.element.find(e.target).length ||
							this.picker.is(e.target) ||
							this.picker.find(e.target).length
						)) {
							this.hide();
						}
					}, this)
				}]
			];
		},
		_attachEvents: function(){
			this._detachEvents();
			this._applyEvents(this._events);
		},
		_detachEvents: function(){
			this._unapplyEvents(this._events);
		},
		_attachSecondaryEvents: function(){
			this._detachSecondaryEvents();
			this._applyEvents(this._secondaryEvents);
		},
		_detachSecondaryEvents: function(){
			this._unapplyEvents(this._secondaryEvents);
		},
		_trigger: function(event, altdate){
			var date = altdate || this.date,
				local_date = this._utc_to_local(date);

			this.element.trigger({
				type: event,
				date: local_date,
				format: $.proxy(function(altformat){
					var format = altformat || this.o.format;
					return DPGlobal.formatDate(date, format, this.o.language);
				}, this)
			});
		},

		show: function(e) {
			if (!this.isInline)
				this.picker.appendTo('body');
			this.picker.show();
			this.height = this.component ? this.component.outerHeight() : this.element.outerHeight();
			this.place();
			this._attachSecondaryEvents();
			if (e) {
				e.preventDefault();
			}
			this._trigger('show');
		},

		hide: function(e){
			if(this.isInline) return;
			if (!this.picker.is(':visible')) return;
			this.picker.hide().detach();
			this._detachSecondaryEvents();
			this.viewMode = this.o.startView;
			this.showMode();

			if (
				this.o.forceParse &&
				(
					this.isInput && this.element.val() ||
					this.hasInput && this.element.find('input').val()
				)
			)
				this.setValue();
			this._trigger('hide');
		},

		remove: function() {
			this.hide();
			this._detachEvents();
			this._detachSecondaryEvents();
			this.picker.remove();
			delete this.element.data().datepicker;
			if (!this.isInput) {
				delete this.element.data().date;
			}
		},

		_utc_to_local: function(utc){
			return new Date(utc.getTime() + (utc.getTimezoneOffset()*60000));
		},
		_local_to_utc: function(local){
			return new Date(local.getTime() - (local.getTimezoneOffset()*60000));
		},
		_zero_time: function(local){
			return new Date(local.getFullYear(), local.getMonth(), local.getDate());
		},
		_zero_utc_time: function(utc){
			return new Date(Date.UTC(utc.getUTCFullYear(), utc.getUTCMonth(), utc.getUTCDate()));
		},

		getDate: function() {
			return this._utc_to_local(this.getUTCDate());
		},

		getUTCDate: function() {
			return this.date;
		},

		setDate: function(d) {
			this.setUTCDate(this._local_to_utc(d));
		},

		setUTCDate: function(d) {
			this.date = d;
			this.setValue();
		},

		setValue: function() {
			var formatted = this.getFormattedDate();
			if (!this.isInput) {
				if (this.component){
					this.element.find('input').val(formatted).change();
				}
			} else {
				this.element.val(formatted).change();
			}
		},

		getFormattedDate: function(format) {
			if (format === undefined)
				format = this.o.format;
			return DPGlobal.formatDate(this.date, format, this.o.language);
		},

		setStartDate: function(startDate){
			this._process_options({startDate: startDate});
			this.update();
			this.updateNavArrows();
		},

		setEndDate: function(endDate){
			this._process_options({endDate: endDate});
			this.update();
			this.updateNavArrows();
		},

		setDaysOfWeekDisabled: function(daysOfWeekDisabled){
			this._process_options({daysOfWeekDisabled: daysOfWeekDisabled});
			this.update();
			this.updateNavArrows();
		},

		place: function(){
						if(this.isInline) return;
			var calendarWidth = this.picker.outerWidth(),
				calendarHeight = this.picker.outerHeight(),
				visualPadding = 10,
				windowWidth = $window.width(),
				windowHeight = $window.height(),
				scrollTop = $window.scrollTop();

			var zIndex = parseInt(this.element.parents().filter(function() {
							return $(this).css('z-index') != 'auto';
						}).first().css('z-index'))+10;
			var offset = this.component ? this.component.parent().offset() : this.element.offset();
			var height = this.component ? this.component.outerHeight(true) : this.element.outerHeight(false);
			var width = this.component ? this.component.outerWidth(true) : this.element.outerWidth(false);
			var left = offset.left,
				top = offset.top;

			this.picker.removeClass(
				'datepicker-orient-top datepicker-orient-bottom '+
				'datepicker-orient-right datepicker-orient-left'
			);

			if (this.o.orientation.x !== 'auto') {
				this.picker.addClass('datepicker-orient-' + this.o.orientation.x);
				if (this.o.orientation.x === 'right')
					left -= calendarWidth - width;
			}
			// auto x orientation is best-placement: if it crosses a window
			// edge, fudge it sideways
			else {
				// Default to left
				this.picker.addClass('datepicker-orient-left');
				if (offset.left < 0)
					left -= offset.left - visualPadding;
				else if (offset.left + calendarWidth > windowWidth)
					left = windowWidth - calendarWidth - visualPadding;
			}

			// auto y orientation is best-situation: top or bottom, no fudging,
			// decision based on which shows more of the calendar
			var yorient = this.o.orientation.y,
				top_overflow, bottom_overflow;
			if (yorient === 'auto') {
				top_overflow = -scrollTop + offset.top - calendarHeight;
				bottom_overflow = scrollTop + windowHeight - (offset.top + height + calendarHeight);
				if (Math.max(top_overflow, bottom_overflow) === bottom_overflow)
					yorient = 'top';
				else
					yorient = 'bottom';
			}
			this.picker.addClass('datepicker-orient-g + qorke.p);
		if((yorient =9= 'top')				top ;=(jeiglt;J			els$
		I4/p -=(cAlenDarHekgjt + p`pseInt(thi3.`icker"css(epeddIbg=Tox/((ª

			thhs/pickerÆcsr({à	to2 ¸op¨
				,eft: left,
)		zindÂxx {Indep
		):
		}
ä	_adhnw_update; tÚue,
		u`|ate: gunctyOn(){
Iâif (!vhir._alloW_Update) retırn9

			var nlƒDate } new$Date(thisÆdate©,
â			tate$$Froiabgs`= fclÒ%ì			if(!rgueents && ArgumenTw&mangth && (tipenf a2gumgntÛ[0]!9== 'striÓÁ' || aRguoent{_0] instanbgof(Dave)) {
	Iâ	date = argumuntsK0];
			if (date inst!*c}of Late)	H	date†Ω |his*^loca|◊toNttB(``te·;
				frnmArgs =$True;Z		= e,sd0{J			ga4 = this.isInpuv ?0this.element.val(-$: thiseLEmaNtÆ‰at`($date') ||0thic.mleoeNt.find('inxuu').vil(9+
		)delete thisÆ%leme>d.`ata().datu;â		}
			this.eate!- DTGLoca|.passedate*date,(this.o.format, this.o.languafu)3		if (fromAÚgq) [
			)// setting daÙe by cli„kkn7
				thisosetValıe();	)	}!else Ib (‰·t%)`{
				?/ sdttmŒg date @y t9zinw
			if (gldDaue.Áe|Time*! !== thic.date.getTimeh)	
â	 	this._trigwer('changeDate'	;
)		}!eh3e {			/Ø clearing date
			4his*triggez('ClearDate');N		}
J		)if (this.eate > p8is.n.sÙarpDate) 
	I	this.ˆig˜DAte =$new`Date(Ùh)s>m.stcrtD·um);
	I		tiis.date = new Datg(this&o.stcrtDa4e);
		}†e¨se if (vhms.ladd > this.k>endÑate) {
				d¯)r.viewDate = new Data*t8is.oÆe.dDate);	!		Ùhis.dbte = new$Date(thisÆo.eÓdWqte);
		I} else0{
		âthiÛ.viewD`te 50nmw`Deta(thiudatM©;
		this.date = new DaTepjis.dauei;*			}
)		thiq.fmll(©;
	},J
fillDow: n}nction(){
			v·r dÁwClt$= this.o&welkSuazt,
			html = ß.tr>';
	Iif(this.o.cal}ndarWeeks©z
				var cell25 '>t` Class9"cu">&nbwp;</ph>';
			Html += kell;*	I)thysÆpicker.fknd(.Date`i„ke2-days vhead tr:f	Rst-cxInd'©.prıPand(selÏ);
			}
H	while (dowSnt 4 t(Is.o.weekStapT†#‡7) ˚
				htmm /= '<th clcss9"Dow2>'kdatEs[thÈs,o.lanouage].l`ysEin[(towClt++)%7]+/</th>';
			}	)	html!+= '</4r>';
		thiw.phgker.fiff ',dAt%picÎer-dayq vheadg)'apr%~d(Htmh);
		|,

	ÊIllEonths:`funcuhkn(){
			var htll = '',*)		i"= 09			`ile (m < 12	†{
		â	`tml += '<rpcn clacs="mgnth">'+dct%s[tIhs.l.langqage].lonthsShosTSh++]+'/stan>';
		|*			thIs.picjgr.fInd'.datÂpkcker-mojtjs td').htel(`t]l);:	i,
		smtRange: fuoction(range){â	hf (!ranga ||! ringe.mengtb)
			delete this,raoga;
		else				this.range = $.Mat™range, funcvion,D	{`return`&.dal}eOr()3!])9)		|his.fil,¨)ª
		},
		getlassNelÂ3: functimn)da4d){
	Ivas chs = []
		)	yeaÛ`Ω tx)s.vi%wDapE.getUT√FullYear(),
				Month = This>vÈewDaTe.getUTCMontx()>
â			currentTatı$5 this.date.valueOf(!,
	)tÔeay = new Date(+:
			if (date.getWT√FulNYeaÚ() < yeer || tQtd.eetUTCFuelYaar(i =5 yuar && date.getUTCMÓntl() < mo‚th)) {
				cls.puqh('kle');
â		}0else if (dAteÆ'eˆUUCFllYeas() > ygar || (dat%>cetU‘CVull]earh	 ==@year(&f dave.geˆU\CIo~eH®) > month)) ˚
				c,s.esh('~Âw7);
			}
		//0Com`are iNt%rfCl UDC dkte witl†Lgcal!today, nOT UTC toda}
		âif (thiÛ.o.todayHighlight ¶&
	â		da4%>getUTKFullYaar() =5 todax.getDul|Yecr() '&
				dete.wEtUDCMonth*)2== tldayjceu-/Nth(- "¶
			Ilate.u'TUTGDate() = todai.geÙDatE()) {
			sls.`uSh(gtday')?
	}*		if (bUrreÓvEie`&& da|e.ˆalueOg() == aurrmntDite !_
	)		cls.push(/CcÙyvE');
	â	}*	if (late.v`lumOf(- º this./.stqztDate || daPm.valu%Of()†> tjÈ{o,e~dDatm |<			$/inAr2ay†date.getUTCDAy(), vhis.o.daysœfW%gkDisAbddd) != -3) {
â		ãcls.pUsn('‰isabled');
		}
			if (this.rqnga){
			ib (date0& this.range[1] .& date º th)3.range[tikc.RaNfe.le.cth-1]){
	Icls.pısh('rqng%');ä				}
			i& ($.ynArray®D`te,val}oOf(©) this.renga)!!= -0){
			âcls*pts`('selectef'9;
				}
			y			rePurn cls;
		ml

	)fi<h: functiof(i4{	)IvAr d = nEW0Date this.v)ewDatd)<
				{ear$= d.ÁetUTCF4l,YuAr(),
				oÔn4h = `.wetUTCMonth(©,
				sÙartYeab"µ†thIsÆo.startDate !=- -Infinity > thisoSvartƒate.gdtUUCFu lYgas 9 2 /Infinit9-
				StartMonuh = This.O.s4a2tDatg !=; -Infinity ? pxis.o.sdartDatg/getUTCMonth() :†-Infhnity.
)		eNdYeAr } thiso.gjdDate !== An6inity ? this,ˇ.undDite&gevUTSFulle·r() : IÓbinity,
		ââel`Montb ="thiw.o.ezlDatu = Infinity ? this.o.endDate.gevPtCMonth() z Infinm4y-				currtntDAte = this.dcde`&6 tXis.e!ue.vadaeOf((,
			voolemp;
			thi{.pic+er.find('>datephCkar-‰qys0t`eAd`tl.datÂpmcker-ssa4cjg9
					.texu(datew[tHhs.o.langıage].monvhs[lontË]+'0'+year);J	âthÈs&picker.find('tfoo| thntodaY'-
					.text8d·tec[uhis>o.languagg]&today)
			â	.togcle(thisæo.dodayBtn != false);
			th)s.picker,gind,'tdkot th.clea6&)
					teht(‰aves[thi3.m.language].bmeaR)
	 )	>t„ggle(this*o.cleabBtn = falsE);
â	4hisupdateNavArrowr();
			thas/fihlEonthc(m;*			var0qrwvMolvË } UTCDate)yeaz, }Oth-1, r8,0<0,0,0-,
	)		d·y = DPGlobk|ngmtEaysIlMo.th(prerMÔnth*getUTCFılmYear(), ra6Month>getUTCMonth()	;
		pr'fEÔnth.SdtUDDate(daq);ã	K)pbevMonth.seuUTCDAte`ay -!(prevMontl.g%tUTCD!y() - txIs.k.wÂkSta2t +`7)%w!;
			var`naxtMnth = new†Dcte)xravMinth®;
		naxtMk.ph.setUTDave(nextMondh.getUTCDave() +"4(;
			ne¯tMondx = nextLondh.valueOf(+;
			vaR htmh = [];
	~ar clsName:			whIde*prevMont`éVAlueOf®)$< nexuMknth {
		if (prevMÔnth.getUTCDay() =ù$t(Is.o.weekStavv) {
	â			htÌl.push('<tp>');
	â		if(thas,o.gelenda2WeakS({
					// ISO (641: Gisst"wmei cont`ins f˘pr4 thursday/
			/+$IS^ qlsO sta|es week 3tarus on Monday, rut tg bin be moru0abstract†heÚe.
				A	f·r
							// Star| of „Urrent week<``ased o~ ˜emKstar|/cuzreo40datE
I				ws"="new Date(+prEfMont( +∞®¸iisno.weakS4`rt - prevMontË.GedUtC@ay()$) 7( ! 7 * 864e5©l
	X			)	// Thtrsdai of this week				th 5 New Daue(+ws -  7*+!4 - ws.gEtQTBDay*)) %†5 * 864e5)<
â					./`Firs\ Thussdqy of year, ygar FrÆl(tËursday
				yth 5 nes Data(+(yth = UT√Date(uh&ge4UTCFulmYaar(©, p( !9 + ®W + 4`- yth.getE\CDay®))%7*864d5-,
					/ AalendAr weei: ms betw≈En thurslayq, di~ ls per dAy, div 7 days
		9				calWeek = !)th - yth)"/"864d5 /$7 + 1;
					hv˝f.pusl(otd class="sw">'+ aalWeEk +#</t$:')3
			â}
			}ä				clsName"= this.getChcSsNamgs(4revMonth);
I			clsName.ush('day');

				if((thhs.o.beg/rmS owDa} !== .nokp){			var `efgse = this.o&bıfNreShowDay(this*_uuc_to_locan(pre~MnÓth));*				if hbefnRm$=== undefined≠
			Iâbefore = {m:
)				else(Èf 8typeoÊ(before) =o= 'bogleal'	*			K		befope = {e~abled: befora;J			edse`id¢(vy`uof(befgre)$==-!strkng',
)	II		befove†= {glasses{ before}:
				yf ("eforg.eDabldd }=="faÏrÂ)
				âCÏwN·meÆpush('disabled')?*	I			if$(j'fore.#lassec)
				âclsN!me < clsNamenbodsat(jefkrG.cnasses.sPlat(.sii;
					iÊ (befÔze.tooltip)
â					tooltÈp = ‚efore.t/o,tip;		]

			clsNama= $.uniQuE(clsNamd)?			Ëtil.puch(&<td class<!/´clsName.join®7 ')+'"'(k (tool$ia 7(' Ùytle=*'+d/ontI0´'"'†: %') + 'º'+prevMgnÙx.getUTCDcpe()†; '</td>');			in (rrerMontË.getTTBDayh° == tjiÛÆo.weekEnd) {
			hvml.pu1h('|/tr>'){
				}
	I		ppevMonth>ÛetUTCDatE(xevMontH.getUTCD`dE(©+5);
		|
			this.pacoer.fihd®'.datepacker-days tboƒy')mMpˆy().Apreod(htmlzcin(''));
			tAR$cuprejtI5ar } this.daTm && tË)s.dave.g!tUDSfu|lY%ar();

	)	~ar monthqË= dhis.pMkkEr.fine,'.datepÈ%kmrmMoltlS')
		)	â.find('th;eq(1)')		â		.te|t(year)
				)	,en`()
-è				.bi~d8'wpan#!.reiOve√laSs('Active');
			iv (CurrentYEqr"'& ctrrentYear ?= Ye!s) {
				months*eq(tlis.daÙe.wutUTSIonth()).afFCLass('actIse/);
			}
	if (year < cuirtYeer \x(year > enlYEcr) 
			mOndhs>adDClcsS('diqa`ned');
			}
		if (year == s|artYair)0{
				mÔnt`s.slicE®0l suaztMoÓt`)nald√l!ss('disQbled');*	
			{f (yeav 9="endaar)0{
		I	months.slicE(ejdÕonTh+1).addCn`ss)'d9sabled');
			}

	(tml 5 7'
)	Iyeas$= qarseK.4hxÁer/14, 10) * 10;+			ˆar yÂazCOnt =0th)w.xycker&fmnd(ß.dqteziskeR-kears')
	ã						.find(ßth:eq*3))
	â					.te¯t(y!ar + g-# ) (q%ar +(9))								.enf()
							nFind(7td/);		ye·r == 1:
			for (v·r0i = -1; i < 11? i++) {J				`vml += '<cp! class="yuar'+(È -= -3!?  old : i <9 10 = /0new' :!'')+(currenpYe#r -= }eaR(ø`' agtive' :('')+(ear < startYdar ||`year(> en‰Iear ? ' disablÂf' :$''k+'">&kYeis+'</sPan>'?				yebb +="1;
			}
			yeazC/.t*hdml(h4mm);
	},

		utea4eNavArroWs: functioo(i c
		)if`(!This._·llow_updAte),re|upl˚
			rAr d <`ndW Datd®thiw*vimwDate),			âyuaz(= d.ÁEtUtCFullYuar(),
I			mOjth = d.getUTCMoŒtz(+;:I	Switch  tx)s.vi%wMode) y
				cAÛ% 0:		
	Iin (4hYs.o.rtarTD·te†!== -Knfinitq && Ÿehr ==t`I{no,stastDate.GetTV«FullQear()4& }knth =< this.o.rtarTDqte$getUTKLooti())${
					thks*pikkÂr.find(ß>pqe6%).gss({risi"mlitª 'hiddeng});
â	I		} }lse†s			t(is.picker.fifd('.prdb').csc({visiboli0y: 'vjSib|e'}i;
	}
				iÊ (thms.o.en‰Date !== Infinhti$&&`yecr z9 thiS.o&endDateÆgoDQTCFullYear®) && month >- th)s.o,endDat%ÆgutUTCMon4h()) {
I				)thispic{er.fhnd('.oext'(,css(k6i3KbmlIty"'hid$en'e);
			] e,sE†{
				ât(iÒ.pickEr.Find('Ænmxt'9Ncss({visiBkËit˘:('fisible'm);
				}
				âbreak;				ca3Â 1>
		casÂ 2:
			)	af (thms.o.startdave!0?< 'YÓfinity ¢4†˘e·v >5 txis.o.startDAte.getTKFu,lYear,)) {
				this.0ackÂr.find)'Æprev')css(svi3ibqlyty< '(iddeÓ%\)+
		= elge {
					tiisnpicker.fiJd*.pre6').ssc({visi‚ility: 7visibl%'=9;
					]
				Iif *thiS.onendDate"!=="IjfinitY(.&!}ear >= thir>oøendFaue>guTUTCFulÌYÂa2()) {*					txis.pi„kes.bind('nfaxt').gss(svisibklity: 'hiddln'}i;
			âI}(Else {
						thsnpicker.Fknd$g.next'!.css({vicibiLitqz ß6ismble'=);				}		I	bZeak;
			}J	I},

c|kcK: fu~ction,e) {
		e.pre^eftFefiUlt();*	+	vcr targed 9 $(e.targeT)>#dosest,'spqn( td, vh')
			iF((t`rget.ldngÙh4== 1+ {
			sw)tch®tiÚget[0]/noleNaÌe.tooerCcse,i©"{
		I	cae #~h'∫
	)		ckdch(tapve4[2].klassa˝e© {
		I			cas% 'datepicKgr-swivsh':
							thys.ShouMode(1):ä			M)	break;
						casm 'prevg:
							ca3e 'next':Ç								var dIr =`DPWÏobaÏ.modes[this>viewmode]&l·vStep * (target[0].s,assName == 'xbet/ = -) : 1-;
								sw+tcht©es.ˆidwMolu){
						)	casg 0;
						H			this.viewDate = tiis.mgvuMo.th(thiq.viewTave, dkr);
							thisN_trigÁe2('changemonth'$ 4his.tiewD%Te){
				bReak
							)c!se q:
)				cese02*
									Ùhis*viegDate0= this.loveYar(this.viesDatu, dir);
			)	I			if (vhis.vaewMo`e === 9)
		ç						Ùhis._tÚIgger('b(angeYeire, this.viewDate)?
										bseak/
						)	m							this*fkll();
			)			rreik;ä				â)	ccse 'tod!x':	I			ver"dbpe = nÂw DaTe();
							date = UTCDate(daTegetFullYeer()."$ate.getMonth(), date.getDatg(9, 0,(0 0);
							Ithis.showModE-2+;
							var which$= tliwno.|dayBtn == 'linJgd' > nul\ :0'6iew%;
â!					this._{etƒate(date, w`ich);
			â		bzeak;
	â				)casg gcleaz%:
				çâ	f!r element;
…		I	ã	if (txis.hsInpqd)
			â				eneient ? thi7.ml%oent;J	!		Ielse!kd *this.compoÓent)
								e,ement = this.elemenv.bifd,'ynpu');
		)		â		if (alement+
							eÏeMenu.6il("")&„hanwe(i					…I	th)s.^trigwe2('ch!ngeDate'-9
âI			this.ıpdatm()
					K	if$hthisÆ.autoclose)
							tiis.hÌde /:	â				brdak;
				}
						Bre·{;					case 'spen&:
)				kf (!tavÁe|is('.disAb,ed7)	 s
						vhis.~iesLate.setUUCDade();
						)f (tarcel.Is('.MojtH')	 {
							var day Ω 1;
						â	va2 eojdh$= thr'gˆ&0aÚent()*finl('scng).inLeh(target);							v!r year = thir.viewDhte.gEtUCCıllYear®);
								uh/s.viewDcte.sepUVCMontj)monthi;
	ã					txa˚._tRigour('changeMOoth', thÈs.wiewD!te);
			â		iv (this.o.mifVhgw]ode =}= 1) {é									t˙is.[se|LAte(UTADate(year, mgnTh( dayl0<0$8,0)){
						}						<†elsa {
				varYear4= ÒarseKnt(4prgev*text(), 10)||4;
						taR day =$1;
								var mEdvh = 0;								uhi3ÆviewDatE.sgtUVCFul,Year(year);
					iâtbis._tryggeÚ'ch`n#aYear, 4Lis.Vi%wDate-;)				iÊ" thks.mminViawModd === 2) {
								this._seuD!tÂ(UTCdate(year, month,$day,0,01,∞)!;
							}
							}						This.sjmwModm,-3);
						this.fill*-?
A					]		))		freak;
					aaSa .td':
				âif(tcrget.is('.d!yß) & !pasget/is('.dic`bled')i{
				I	var day = par{eint(target.pext(), 7 !||1;						var yÂar < this.viawDate.getUTCFUllYearh),					))	month = this>viewDqtu.getUTCmnn4h(-;*	I				if (tasget.is('*ÁLf/)) {
					iÊ (mojth"=}= 0) {							monTh = ±1;
							yÂar <`1+	I				}!eDse {
					Imonth <Ω 0;		)				y
						m %nsg@if (taÛgetnis,'.new')) {
							mÓ (eÔnth == 30)`{
							montj = 0;
)			â			year #?11;
							u Âlsu0[								month,+5 q;
						}
						}
					)	v`iw._3etdatu(UTCD·Ùe(year, mmlth, tay,0,,8, ));
				I}
						break;
I)	}
			}
		},
		_setDate fujction(date, whic(1{J		if (!which || which"==!date#i
			this.datm = neg Data(dame)9
			if (#wich || wniah  == 7v)ew')		tHis.v(egƒata = new"Date(date);é	I	dhis.fill
);
		4»is.seÙValue(){
		pjms._trigger('changÂEatg'9;
))	var eleme.tª
			iF (this.isInput) {
	I	Kglement!= Thms.element;
			} else id (thiscompone~t){*			element = this.elementnfand®'inrtt');
		}
			id†(elemanU	 {
			eLement.cHange(©3
			}*			if (thas.o.autoclose && (!vhici ||(whibh == 'date/)) {
			t(iÛÆ)ide,):
		}
		},
ä	-nveMonth: func}ion(date, dir){
		if†(!dir	 returo†date:
		˜as new_lata†= new Date(date.valuuOv()),
)			day < new_fateÆoetUTCDape (,
I			moÓth = new_dite.getUTKMnth(9,
				mag = Math.abs(dÈr	,
				ne˜_month, xgwt;
			dir = dir000 ? 1 :"-1;
			if 8mag =-01)
				td3t = div 9= -1ã			//(IÊ goÈnf ‚ask ÔoÂ mondh, eake sure month iS not Current month
				+/ (eg¨ ]ar 350-> FEb 31"=Ω Feb 2, nt Mar p2)
					ø vunction({ pÂturn ~mw_Ù‡tg&getUTCMonth()"==†lonth;(}
					// I‰ gmijg forwqrd kne mooth. make wuÚ% month Is$as expebted
				// (eg, J`N$31 ->`Feb #1 9? Gab 28, not Mav$02(
				I: functiof(){ 2eturn nmw_dape.getUTCMonth() = new_mnntH;0};
			naw_moNÙh 5 mnnth ; ‰iv;
			new_date.cu4’tCMonth(nev_month):ä		// Dec$=>!Jin ©12) oz(Jan -> Dec (-1)"--"limit!expe#teT d`te to 0m1q
		if 8new_Ìooth< 0 || new_mgnvj > q1)
			~ew_eonÚh = (ndw_mgnth†+ 12+ % 12;
I		} eLse!{
				// Fgr mignÈ‰1dms >1,0mo6g one month at†a†time.>.
				for  var i=0; i<mag i++)
					// ...uhignamight aecrease t`e dey!eg. J!n 31†to Deb 08, ets)...
…			new_late <(this.miv%on4h(new_date, dir)ª
	//b...then"reset the0day,jeÂ0lng it in Ùhg new month
				new_iodth = new_dite.getUTCMMnuh(){
		Ineg_date/setUTCFatehda{);				tgst!= fu.ctiol(){ peturn Óe_month != new_dave.getUTCM}nth(); };
			}
	â// Common fa4Â-resettIng ,Ôp!-- If date ir bEygnd!End of month, maiÌ"it
			// enf ov†monph
	 	whild (te{t()	{
			~aw_da|EÆsetUTCDqte(,faY);
				fmw_dateÆVetUTCMonth(newWMnnth);
		}
	ârmtwrn ne7d!t%9
		}$
		movdYgarz fung4ion*detel tir){
		9rmdupn"thksmoreXo.th(dAte, dir*12);
		},

deveWithinRa~ge: functikn(datey{
IâvetUrnqdite`>=†uhis.o&startDate && ``t! <Ω this.o.endDAte;	}l

		ke{fown: function(e)
			qf$(uxis.picigr.is(':nmt(:visi"me8%))˚
			if†(eæKeyCode == 27( // almow`escape 4o hi&e And re=show``ycjer
					thiÛ.rhow(;;
				zetuRn;
			}
		fkr dateCh!nged = falsel
			Dir( day( month,			newDete$ oewViegDate;
			Swivch(e*keyCÔde){
â			casu"27:!// ercapeé				)tni3.lide();
			e.prevu.tF'fau,t();
					brEak;
			gase 37: //†left
		!„Asw 3)2 /Ø(right
					if h!tjiq./.ke9boarlNavigataon) `reA{;
		)	dyb = e.keyCode == 37 ? -1 : 1;
				âiF (e.ctrLKe˘){
			)	newDate!Ω tiiÛ.moveYear(thIs.date, tir(;
)			)	n%7viuwDa|e†= this.moveYear(thIs&~iewLa|e,"diR);
			…thiwÆ_tricger('changeYear', thi#>viewDatm);
		â	} elseÄin (e.shiftÀ-y)s	H				New`te 9 |his.moveOontË(thic.datm,(fir);
					ngwViewDate(= tiir.moveL/nth(this.viewDi4m, §is);
			I		this_tr9goer*'chanfeLo^th#, this.~ievDave);)			} dl{e ;
		)			newDate  ne DatG(this.$ate+;
	-	â		newƒade*setUTCDate(tihs.date.GepUTCDatm(	 ; dIr);
					negViewDate = lew Dgte(thhs.vie@atd){
						newTiewDate.setUTCDate(this.viewDaTe.we4UTCDate()0/`dhri;				}
				âif HtxiÛ.fate◊ithinSanOe®negDate)){
			âthis,da|e ? newDate;
M					Ùj)3&fiewDavg = newViewƒate;
						this.setVaLue()?
			à	tËis.update(9;					e.preven4@dfault*);
I			datehanggD =0trum;
)			=
	I			jreaÈ;
â			kase 38:(+≠ ut 			c·se 40+ /o Down
					if (!uhiso.+EyboardNavig!=io.9 b2e!k;
					dÈq = e.aeyCoDm = 30 ? ≠1 :":					hf!)a.ctRlKey©{
					zefDate ? this.move[ear th)s.date¨ dir);
					ldwViewDaue =0thismÔ6eYeaz(thisÆp)ÂwDqte, fyr);					tjyS._tzigferh'chaogeYeaR', thm{.viewDate);ä	ô)	} ense if (ÂÆs`iftKey){ä						newDate = thÈc.moveMoNt((phkÛ.Date,1dir);					~%wViawDate`= this.moveMonta(th·s.vÈe7Date, dis)+
â					this.Otrigger('chengEMontË', dhis.~iewDate);J					}¢else [
						newDatÂ®= ne7 Date(thirdate){		I		∆ewDate.setUTKDate(THÈ”.dave/getUDCDiue(- ´$dir *(7);
						newRiewDatE = ne_ Datm(this.vkewDctÂ);
	â		newVies@ate.retUTCDate(|hIs.viewDate.getUTCDate() + dir * 7);
					}
					if (this.dateWithinRange(newDate)){
						this.date = newDate;
						this.viewDate = newViewDate;
						this.setValue();
						this.update();
						e.preventDefault();
						dateChanged = true;
					}
					break;
				case 13: // enter
					this.hide();
					e.preventDefault();
					break;
				case 9: // tab
					this.hide();
					break;
			}
			if (dateChanged){
				this._trigger('changeDate');
				var element;
				if (this.isInput) {
					element = this.element;
				} else if (this.component){
					element = this.element.find('input');
				}
				if (element) {
					element.change();
				}
			}
		},

		showMode: function(dir) {
			if (dir) {
				this.viewMode = Math.max(this.o.minViewMode, Math.min(2, this.viewMode + dir));
			}
			/*
				vitalets: fixing bug of very special conditions:
				jquery 1.7.1 + webkit + show inline datepicker in bootstrap popover.
				Method show() does not set display css correctly and datepicker is not shown.
				Changed to .css('display', 'block') solve the problem.
				See https://github.com/vitalets/x-editable/issues/37

				In jquery 1.7.2+ everything works fine.
			*/
			//this.picker.find('>div').hide().filter('.datepicker-'+DPGlobal.modes[this.viewMode].clsName).show();
			this.picker.find('>div').hide().filter('.datepicker-'+DPGlobal.modes[this.viewMode].clsName).css('display', 'block');
			this.updateNavArrows();
		}
	};

	var DateRangePicker = function(element, options){
		this.element = $(element);
		this.inputs = $.map(options.inputs, function(i){ return i.jquery ? i[0] : i; });
		delete options.inputs;

		$(this.inputs)
			.datepicker(options)
			.bind('changeDate', $.proxy(this.dateUpdated, this));

		this.pickers = $.map(this.inputs, function(i){ return $(i).data('datepicker'); });
		this.updateDates();
	};
	DateRangePicker.prototype = {
		updateDates: function(){
			this.dates = $.map(this.pickers, function(i){ return i.date; });
			this.updateRanges();
		},
		updateRanges: function(){
			var range = $.map(this.dates, function(d){ return d.valueOf(); });
			$.each(this.pickers, function(i, p){
				p.setRange(range);
			});
		},
		dateUpdated: function(e){
			var dp = $(e.target).data('datepicker'),
				new_date = dp.getUTCDate(),
				i = $.inArray(e.target, this.inputs),
				l = this.inputs.length;
			if (i == -1) return;

			if (new_date < this.dates[i]){
				// Date being moved earlier/left
				while (i>=0 && new_date < this.dates[i]){
					this.pickers[i--].setUTCDate(new_date);
				}
			}
			else if (new_date > this.dates[i]){
				// Date being moved later/right
				while (i<l && new_date > this.dates[i]){
					this.pickers[i++].setUTCDate(new_date);
				}
			}
			this.updateDates();
		},
		remove: function(){
			$.map(this.pickers, function(p){ p.remove(); });
			delete this.element.data().datepicker;
		}
	};

	function opts_from_el(el, prefix){
		// Derive options from element data-attrs
		var data = $(el).data(),
			out = {}, inkey,
			replace = new RegExp('^' + prefix.toLowerCase() + '([A-Z])'),
			prefix = new RegExp('^' + prefix.toLowerCase());
		for (var key in data)
			if (prefix.test(key)){
				inkey = key.replace(replace, function(_,a){ return a.toLowerCase(); });
				out[inkey] = data[key];
			}
		return out;
	}

	function opts_from_locale(lang){
		// Derive options from locale plugins
		var out = {};
		// Check if "de-DE" style date is available, if not language should
		// fallback to 2 letter code eg "de"
		if (!dates[lang]) {
			lang = lang.split('-')[0]
			if (!dates[lang])
				return;
		}
		var d = dates[lang];
		$.each(locale_opts, function(i,k){
			if (k in d)
				out[k] = d[k];
		});
		return out;
	}

	var old = $.fn.datepicker;
	$.fn.datepicker = function ( option ) {
		var args = Array.apply(null, arguments);
		args.shift();
		var internal_return,
			this_return;
		this.each(function () {
			var $this = $(this),
				data = $this.data('datepicker'),
				options = typeof option == 'object' && option;
			if (!data) {
				var elopts = opts_from_el(this, 'date'),
					// Preliminary otions
					xopts = $.extend({}, defaults, elopts, options),
					locopts = opts_from_locale(xopts.language),
					// Options priority: js args, data-attrs, locales, defaults
					opts = $.extend({}, defaults, locopts, elopts, options);
				if ($this.is('.input-daterange') || opts.inputs){
					var ropts = {
						inputs: opts.inputs || $this.find('input').toArray()
					};
					$this.data('datepicker', (data = new DateRangePicker(this, $.extend(opts, ropts))));
				}
				else{
					$this.data('datepicker', (data = new Datepicker(this, opts)));
				}
			}
			if (typeof option == 'string' && typeof data[option] == 'function') {
				internal_return = data[option].apply(data, args);
				if (internal_return !== undefined)
					return false;
			}
		});
		if (internal_return !== undefined)
			return internal_return;
		else
			return this;
	};

	var defaults = $.fn.datepicker.defaults = {
		autoclose: false,
		beforeShowDay: $.noop,
		calendarWeeks: false,
		clearBtn: false,
		daysOfWeekDisabled: [],
		endDate: Infinity,
		forceParse: true,
		format: 'mm/dd/yyyy',
		keyboardNavigation: true,
		language: 'en',
		minViewMode: 0,
		orientation: "auto",
		rtl: false,
		startDate: -Infinity,
		startView: 0,
		todayBtn: false,
		todayHighlight: false,
		weekStart: 0
	};
	var locale_opts = $.fn.datepicker.locale_opts = [
		'format',
		'rtl',
		'weekStart'
	];
	$.fn.datepicker.Constructor = Datepicker;
	var dates = $.fn.datepicker.dates = {
		en: {
			days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
			daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
			daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
			months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
			monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			today: "Today",
			clear: "Clear"
		}
	};

	var DPGlobal = {
		modes: [
			{
				clsName: 'days',
				navFnc: 'Month',
				navStep: 1
			},
			{
				clsName: 'months',
				navFnc: 'FullYear',
				navStep: 1
			},
			{
				clsName: 'years',
				navFnc: 'FullYear',
				navStep: 10
		}],
		isLeapYear: function (year) {
			return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
		},
		getDaysInMonth: function (year, month) {
			return [31, (DPGlobal.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
		},
		validParts: /dd?|DD?|mm?|MM?|yy(?:yy)?/g,
		nonpunctuation: /[^ -\/:-@\[\u3400-\u9fff-`{-~\t\n\r]+/g,
		parseFormat: function(format){
			// IE treats \0 as a string end in inputs (truncating the value),
			// so it's a bad format delimiter, anyway
			var separators = format.replace(this.validParts, '\0').split('\0'),
				parts = format.match(this.validParts);
			if (!separators || !separators.length || !parts || parts.length === 0){
				throw new Error("Invalid date format.");
			}
			return {separators: separators, parts: parts};
		},
		parseDate: function(date, format, language) {
			if (date instanceof Date) return date;
			if (typeof format === 'string')
				format = DPGlobal.parseFormat(format);
			if (/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/.test(date)) {
				var part_re = /([\-+]\d+)([dmwy])/,
					parts = date.match(/([\-+]\d+)([dmwy])/g),
					part, dir;
				date = new Date();
				for (var i=0; i<parts.length; i++) {
					part = part_re.exec(parts[i]);
					dir = parseInt(part[1]);
					switch(part[2]){
						case 'd':
							date.setUTCDate(date.getUTCDate() + dir);
							break;
						case 'm':
							date = Datepicker.prototype.moveMonth.call(Datepicker.prototype, date, dir);
							break;
						case 'w':
							date.setUTCDate(date.getUTCDate() + dir * 7);
							break;
						case 'y':
							date = Datepicker.prototype.moveYear.call(Datepicker.prototype, date, dir);
							break;
					}
				}
				return UTCDate(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), 0, 0, 0);
			}
			var parts = date && date.match(this.nonpunctuation) || [],
				date = new Date(),
				parsed = {},
				setters_order = ['yyyy', 'yy', 'M', 'MM', 'm', 'mm', 'd', 'dd'],
				setters_map = {
					yyyy: function(d,v){ return d.setUTCFullYear(v); },
					yy: function(d,v){ return d.setUTCFullYear(2000+v); },
					m: function(d,v){
						if (isNaN(d))
							return d;
						v -= 1;
						while (v<0) v += 12;
						v %= 12;
						d.setUTCMonth(v);
						while (d.getUTCMonth() != v)
							d.setUTCDate(d.getUTCDate()-1);
						return d;
					},
					d: function(d,v){ return d.setUTCDate(v); }
				},
				val, filtered, part;
			setters_map['M'] = setters_map['MM'] = setters_map['mm'] = setters_map['m'];
			setters_map['dd'] = setters_map['d'];
			date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);
			var fparts = format.parts.slice();
			// Remove noop parts
			if (parts.length != fparts.length) {
				fparts = $(fparts).filter(function(i,p){
					return $.inArray(p, setters_order) !== -1;
				}).toArray();
			}
			// Process remainder
			if (parts.length == fparts.length) {
				for (var i=0, cnt = fparts.length; i < cnt; i++) {
					val = parseInt(parts[i], 10);
					part = fparts[i];
					if (isNaN(val)) {
						switch(part) {
							case 'MM':
								filtered = $(dates[language].months).filter(function(){
									var m = this.slice(0, parts[i].length),
										p = parts[i].slice(0, m.length);
									return m == p;
								});
								val = $.inArray(filtered[0], dates[language].months) + 1;
								break;
							case 'M':
								filtered = $(dates[language].monthsShort).filter(function(){
									var m = this.slice(0, parts[i].length),
										p = parts[i].slice(0, m.length);
									return m == p;
								});
								val = $.inArray(filtered[0], dates[language].monthsShort) + 1;
								break;
						}
					}
					parsed[part] = val;
				}
				for (var i=0, _date, s; i<setters_order.length; i++){
					s = setters_order[i];
					if (s in parsed && !isNaN(parsed[s])){
						_date = new Date(date);
						setters_map[s](_date, parsed[s]);
						if (!isNaN(_date))
							date = _date;
					}
				}
			}
			return date;
		},
		formatDate: function(date, format, language){
			if (typeof format === 'string')
				format = DPGlobal.parseFormat(format);
			var val = {
				d: date.getUTCDate(),
				D: dates[language].daysShort[date.getUTCDay()],
				DD: dates[language].days[date.getUTCDay()],
				m: date.getUTCMonth() + 1,
				M: dates[language].monthsShort[date.getUTCMonth()],
				MM: dates[language].months[date.getUTCMonth()],
				yy: date.getUTCFullYear().toString().substring(2),
				yyyy: date.getUTCFullYear()
			};
			val.dd = (val.d < 10 ? '0' : '') + val.d;
			val.mm = (val.m < 10 ? '0' : '') + val.m;
			var date = [],
				seps = $.extend([], format.separators);
			for (var i=0, cnt = format.parts.length; i <= cnt; i++) {
				if (seps.length)
					date.push(seps.shift());
				date.push(val[format.parts[i]]);
			}
			return date.join('');
		},
		headTemplate: '<thead>'+
							'<tr>'+
								'<th class="prev">&laquo;</th>'+
								'<th colspan="5" class="datepicker-switch"></th>'+
								'<th class="next">&raquo;</th>'+
							'</tr>'+
						'</thead>',
		contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
		footTemplate: '<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'
	};
	DPGlobal.template = '<div class="datepicker">'+
							'<div class="datepicker-days">'+
								'<table class=" table-condensed">'+
									DPGlobal.headTemplate+
									'<tbody></tbody>'+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-months">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-years">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
						'</div>';

	$.fn.datepicker.DPGlobal = DPGlobal;


	/* DATEPICKER NO CONFLICT
	* =================== */

	$.fn.datepicker.noConflict = function(){
		$.fn.datepicker = old;
		return this;
	};


	/* DATEPICKER DATA-API
	* ================== */

	$(document).on(
		'focus.datepicker.data-api click.datepicker.data-api',
		'[data-provide="datepicker"]',
		function(e){
			var $this = $(this);
			if ($this.data('datepicker')) return;
			e.preventDefault();
			// component click requires us to explicitly show it
			$this.datepicker('show');
		}
	);
	$(function(){
		$('[data-provide="datepicker-inline"]').datepicker();
	});

}( window.jQuery ));
