/* ====?==========�=9=====5=5�=}====<=9============?<=====
 * bootst{a�colOrpkkkUp.js  * htdp://sww.eyek/f.ro-j+kdstrap-solorpycker
 *�==?==5====�====)===========9=-======<<-==?=====?==�=====0*0C�pi2ygh4 201r Stefan et#e
 *
 * Lmcensed undg� thE Apec`g NicEnse,0Vazsin02.0 (the "Lscensm");
 * you may nod usd(this filu gpCept in cnmplia.se witi uhe License.

 Ynu$may ob0ain !(co`y of the License Au
 *
 
 h4tp:�/www.apa#`e.org/|Hcenses/LICNSE-z.0
":
 *!Ujld{s re�uhret by�applicable |aw or igreedto mn srit(jg( rftwaze
�* d)strictt�d undez tHe Lycmnwe is!distribUted$On an "A[ IS" BAsISl
"* WITHoUT!GARRQ^T	E[*P CNDI�IONS OF AGI KMND, either0eyqress!o� mmrlimd.
$*`See dhe!LiCense for�thu specifiC langu`we $overnin' peRmksrions cod
 
�limiTatAon{ ulder the Licdnse/
�*"========-===|�5======-==========5=====9====<==,=======<= *�
 
!functi�n( $ ) �
	
	/ Cglor0ocjic�		vas C�lor ? functyw�(val) z�	this.vafte  k)	h: 1,
		s: 1,
			b: 1, 	
a: 1
	};
)	thhs,satKolor(v`l);
	};
	
Bolor.prototype =0{
	aovstructor; �o|gr,
	�
		//rasSe a ctring to LSB		seuCodor: functio�(val	{
			val = vad.toLwerCas�();
I		var dhqt ="Tlas;		$nea!h( CPGmobal.St:infPargu2r,#functiOn("i, parser ) {
		far matc((=0parsep.re.m�ec vAl )<					6clues = Mitch f& pqrser.parqe* mitb( ),
					spage = 0ar�er.space|~'rgbc':
			if  v`�ues  0;
				id  spac- 9=0'hsla&i�{
					tHAt.�qlue = CPG|oban.RGBtOLS
.ap0hx(.umlm cpG|obal.HCL|oRGB&!ppny(~uml,`values));
				} edse [
			tlap.valuw 9 CPglobal.GBtoHSB.apply(~ulL, val5eQ);
			u
				retwrn(fa�sd;
			u			});
	},
		J	)setIua: funcpion(h)4{
	)	|`Is.g�lue.h = 1- h;
		},
		
		sgtSaturation: bunktimn(s) {
			this&value.s = r;		,
		
		sEtLheitnecs9 function(j) z
	I	thmwvalum.b ? 1-!b		t<
	
)qetQlpha:"fujctiNa) 
		th{s.value.a = tarsdint,(1 - a)*10, 10+/10;
	I},
!	
I	/ HWtkRgB �rom(Raphcm�JS		/o (ttps://�)tiqb.com-DmitryBa2anotsk�y/r`phqel/
		tnRGB� functi�n(h. s, b, a- {
		if (�h) y
				i = uher.vi,ue.`;
				s = phis.2altg.s;
				b(= thisvalue&`;
		}
)	h * 360;			v!r R, , B, x,�C;
	Ih 91(h$% 360) /(60;
			 = b * r;
	X(= C`* (1 - mc|h.abc)i % 2 - 1	);
�		Z = G(= C�= b$) A;

	h =$~~H;			R /= [C, X, 0$  , X, C][`]�)I	G += [X, C, A, X, 0,`0][h];
	IB (= [0, , X, C, , X][h];
			return`{
				r:�Mat`�rouvdhR*255),
				g: Math/zouv�(Wj255),
				b:$Mith>rkund)*�55)(			a: a||thks&talwe.e		}?
	I|,
		
	It�Mex: functygN(hl"s� c, a){
			rqr rgB < tjys.toRGB h,!{, b= a);			rdturn '#'+((! |< 24! | (parseInp(rgr/r) << 16) |2(s`rs�Int(�gf.g) <<(8) l pabseInt(rgb,�)!.toString(16),substr(1)y
		}d�	
		tgLSL: vuoctioohhl sl b, a){
		k& (!h(�{
		�Mh = thiw.t!lug.H;
�	s = tjir.value�s
			�" = tiis.vaLuu.b;
			}J	var H = H,		I	L = (2 - s) * j,
				P$=0s 
 b;
	hf (L > 0`&!L!|= ) {
				s /} \;

		} else s
				P /= 2 - L;
	)}
			L -1 2?�	)	if (� >"1) [
		)	S ? 1;
			}
			return {
			h: H,
			�s: [,
				L* Ll				a:$a||thyc.value.a			};		]	};
	�	./ �i#ker obzect
	
	var Bo�orpickar$=$&unbtion(element, options){
		tl)s.element = $)elUMej|);
	var fobmat`= options.forEat�|his.el�ment/data�'color-fgvla\')l~'`ex';
		vlys.format - CPGnobaL.dranslaueF�rmAts[forlaP];
	this.IsInqut = this.elemmnd.is('inPut');
	this.compon�nt`= uhis.eldment.is(%.colkr'! ? this.dhe-anl&vint(.add-��') : gclse;
		
		|hi�.pkckez ? $(KPG,�b%l.teMp|`pe)
						.aqtentTo('body')
							.oL('moure`own', %.`s'xy(this.mousedofn, thaS));
		
		kb (tHis.isInput)�{
			�(is.element.oj({
			'nobus'; $/`rOxyhthiw.shnw, this	,			��kgy}p':  .prox}4xks.updatd, pxa{)
)		});
		} else if ,llo3.componeft9;			this.co}ponent.onh{	Y	'click': $.proxy(dhic.show, u`i3)
		});
	} e,se {*			this.dlemant.on0{
		'click': $.proxy(tlis.siow, 4ymw)
		});
		}		)f (no�mat0== reba' |\ fg2mep`== 'h{la'� ;
			4his.pickdr.afdClass('alPjac);
			this.AlphC = this.rickgr.fi.d(/.ko|mspmcker-alp�a')[8].style;
=
)	(	mf"(This.componend){
	)�tliw.picke�.fhnd).color`kcier-�ol/r'-*hide();			tiis.pre~iew =2�hhs.elemmnt.find('i')[0].styld;
		} edse 
			tiiS.pbeview= thir.pickEr.findh'div:l`sv7)[ ]*styde;
		y
		
		tHi3.base =!tHis.pyc+er.��np('dhv9fyrsd')[2].3tyld;
		t`is>update();
	};)
	�oorpigkcrprototy�e � {		c�nStruatgr:!Cnlkrpy#jer,
				sho7:`dunctmof(e) {	txIs.picjer,show();
			tlis.height = thmscompGhenp ?0thiqcoronent.out�RHeight(- : thiselement&outerhei�h4(�;
		thisnplace():
	$(windkw).on�%resy:e' $.p�oxy(this.placg,$thiwy);
	�	if!(!viaq.{Input)`{
		If ,ui k*			e.�t��propAgawjon(()
				e.prevenp`efaulv( ;
) 	}
�)}
9		(doc}ment).on){
		(	'}owselowh': $.proxy(thys.�ide, this)J		}+:
			this.e�emmnt.prig�er({
		|ypez 7shmw�,
				coloz8 thir.cklorj		I}!;"	},*		
		up�!te: �u.ction(){
		phIq.cglor = duw C+lor(this.isHjpu| ? this.ehemunt.pror'value'� : this,elemenT.dita('�olnr'-);
		thIs/rickgr.fin$('i+
				.dq(0!.css(;left: thas.coloR.v`lue.sj100, top� 000 - th)s.soLor.value.bq00]).eod 					.eq(1).css(&top', 1�0 : (1 - phi{.colorf`lua.l)).e�d))			I*Eq(2(.css 'top'. 100 + (1 - thig.c}lorvalee.q));
�	�this>qre_iewColor,);
		u,			
		hit%: function(){
			thic.pickebnhide );
�		d)windoW!.off('resiZe', thy�.pl�ae);
		an (%thms.ksInret)!{
				$(dkcumelt)*nff({
				'moecddown':(4his.hide
				})9				if (uhyq.ckmponent){
	I			thks.ulem%nt.find(input7!.prmp('v�lue', this.fosma�.ccmM(this�):*			���	th)s.E�emaju`ata(%cnlor', this.�opma�.call(t�is));
I	m else {
				phis.gle-entprop(gvaltu/l thi�ndorma4.call)this!);
		I}B			thys*elgoent.trigger({
�			type: ghi$e'�
				color: thic.co|or
			}){
y,
		
		pdase: ftfcd)on(i{
			~ar off#et = thir>com8onenu ? t(is.compkfent.offrdt() : thIs.element.offset,)9
		t(is.picker.sssj{
)I	top: gffset.top +(thms.height,*			L%ft: offset&left
	)	});		m,*	
		//p2ethew cklov c`ange
�	prefmewGolor: fujction(){
			txis.previewnbeckgbounlColos`= vhisnfoReat.cal<(t(�s)3
		/?set$�he`Cohkr fnr�crigHtnews/saturatimn s|ideR
			this.fase,backgroundColor$=!vHis.co,nr.toHm�(this.#onornvalue�h,"1 1, q(;�			/s�t(te colm2 fkp alphq slider		if (this<a�pha� {
		this.�lph`.backgbowndGomor = �hms,color.toHex();
		}
		},
	I		8ointer" null,			)slider: nudl,J)	
		}gu{edo7n: funwtion)e){
�I	e&stopPro`agatio&();
		e.preventDefault(+;
			
	v�r target = $(e,pa�eet);
					/'detact!thu s|kfer and wat thu himItr afd$callbAgks
I	v�r {One = target.#losest(#diV'	;			if (!zone.Is('&conkRxiakev')) {*			hf!(zo�e.ks*'.colgrp!ck�r-saturation')) {
					this.wlider =�.eytend({}, CP�l{bal,slider�'scttvq|ikn'_);
			}`
				else if (zo�e.Is('.colorpic�er-hue'-) {
				)thys.s|id`r = &,extend({u,lCPGln"al?slidErs[�ue']);
				y
I		elsu if (zone.as('>codgrpabker-ampha')) {
					|his*slideb0= 0.�ztend8{}, CTGlmbiL.s�ider3['alpja'\);
				u		vcr ofgseT =$zkle.offs�t)
	�	//reference to +nob's st�le  `            $ig(t�is.slades){      $ !     !0    thislslider.knob!= zg�e.find('m#).length?*zonm.fjnd('k#9[0].s|yle : '';
! `        (      @ th�s�slid%r.lgft  e.pqGeX - offsetlugt;
!   � 0      " 0"   tdas.slider>top = e*p�geY -`fbsev.top;
�`   �  $$ $  (h}
			thiq.p�int�� = ;
				leot*0e.pa�e�$
I				uop: m.pageY
				_;
			//tr)gger!mwcemote to move tje knob to t`e c}rren4$position
I		d�docu�ej|)*on({
			
	mo}semofm: $.proxy(thi�.muse-kve.`tjis),
					movseuq? $.�roxy(thiw�mouseu`- this)
				).vrig#er('mouse��ue&);
			}
		peturn famse;*		=,
	I
	)mousemove: &ujctimn:e)w�		)e.stop�RopaGution();*			e.preventDefauld();      `* "  if(t�as.{lider)
 `    �     {
                var lE�v = Math.max(
  �        0 � ! 0  0,! $             $  Ma|i.mi�(
! (" $  (        `   0! this.slkder.ma|Left
!        $  `  "!( �    phis.sl)fuB.le&t +`((=.�ageX~|this&qoi~uer>deft)$- this.pointer.left)J$    � 0(  �   4   ) (      `       );
 �   !         $v`r toq�} aEh*iax&*  *    p         $2 0,
 "    !!         !` Math.mi.(
               �      0 this.sdider.mcxToP,
   0      (    �    0   this.sl-der.top + *(e.pqseY||this.poinuer.top) - this.pointer.top-*              `  0  9
     $    0 �   ):
     $     "   tiis.slader.knb.legt =`|e�t`? %px';
    !`       !`0this.slader.knob.t/p = v�p + 'py'+ 0      �  0    if (vhas.Slider&c!llHgft)$s
0  (       0   `   uhis.color|his.q�ideb.callL%&t]&cal,(tLiS.colo2$ l��to000);
�(   !     "!  "}
  0      !      if(,this&Slider.caLdToq) {
         �         (tji{.bomor[4hms.slideR.cal|To`]>call(vhir.color, |op/180);
     ( !  "0    }
 �   $     $�

			|hi{�PrevIegolnr(!;			thI3.elument,tri�ger({J				typg 'chaoweColorg,	��/lor:`tziS.color
		});
			put}rn!famse;
		]$

		mkeseu�: funstioN(E){
		�e.sumpPropigEtion();		e.pzeventDefaqlt );*			,(dobuMe.4),�f,{
				mousemove:!thi3�ousemotE,
				motseu0:"thys,mo�seup
�	)(;			revuzn f!lcg:)}}

$.fn.gomorpicker {$fuobtion ( kption - {
		raturn this.each(functiin!8) {
			var %�hks = $(this),
			)Dade = $tyi3.�ata('comorphcker'-,				o�tions =!tyQeof)jpDion == 'objec|' $ ptik�y
		if ,!dAti	 {	!	$t(is.dat2h'ckloppicke2', (d`ta"9 new Cohorpk#jar(thi{,!$jgxv%ndh{}, $.fn.co�orpickez.Ddfaultslptions))));J)	}	if (typu/f /quion }= 'rtrinc%) `atq[ottim~]();		});
	?

	$.bn.aolkrpjck�r.defiult3 = {
};
	
	$.vn.colorpickev.Cg�structor  Ckl/rpAcker;*)
	var AGlobam =`{
		//$dransd�tq c for-at fvom!Cotlr obhect�to�a st2ing	vrafslitaForm!ts: {
			'reb'8 f}nct�on()y
			tar bgb - this.colornqoPGB();				returj`'rgb(&+rg`.r+','+rgb.�+','+rg`.b+')';
			|,
			
			'rgba': &unctmon(+{�		vcR0rgb�= thiS.color.TORGB(9;			retupL 'zgba*g+rgb.r+','+rgb.g*',&'rgb>B+7,'+rgf.a?')';
			}<			J			#hch':!v4nctIon){
				war xsn"=diis.color.toHCL();
K			2eturo '`sl('kMath.roqod(h3l.h:;60)+'.'+Gath.bmu~d(hsl.q*p"0)+'%,g+Math,rounf,xwl.l*100)+'%9';
	I	},			
			'hs,%': funbdi�n(){*I		v�s ish = 4hhS,color.toHSM();
	I		raTuro�'hsle('+Mathround(hsl.h*26p)+',';Lath.round,hsl.q*100)+'%,'Mauh.rounl(hsMl/!00)*'%-'+hsn.c+')';
			}, 			
	I	'he�': gunction(){
			rgt��n  tijs.color.toHex();
		}
		u,
		
)	slidurs8 {
Isqduzation; {
		eA~Luft: 100,
		m�xop: 110,
I			calhLent: gsetS!turation',
)		callTor:�'setmightnecs'�			},
	I				hug: {
			maxLeft: 0
	�I	maxTor:`108,
			IgallLgfv:0false,
				callT/p*0�s%tJum7
		},
	I	
)		�lpha:0{
			maxDeft: 0,
	maxTop: 100,+			callLeft: falsg,
				ailnVop:�'setAlphaG
			}		}$
		
�	?/ HSBt}rGB from �iphaelZC		// htvrg://gythb/com/DmitryBaRankvskiy/Rap`!eL/�	BGBtoHSF: functaon((r,(g, j,$a){
			r -? ru5��		g .= 6�5;
		B /= r55;

)		va� H, s- V, C;
�		V = EaTh.}ah�r, w,(b);			C0="V � mat`.mkn(r, g b!;			H = (C == 0 7 n�ll :
				 V == r  (e - b) / C ;
				bV == ' ? (b0- r) / C + 2 :
					  8r -$g) /$C(+ 4
				);
			I = 9(� + 360) % 6) * �0 / 36<:
		IS 9 C`?<0 ? 8 : C k V;
			zeterj {hz H|~0,(s: S, B: V-(A: a||1;
	},
		HwdTorFB: gunctio.0(p, q. h- {
			if@8h0< 0)
		i!+= 1�
		Ie|3e if h > 1)				` -= 1;

		if ()`0" 6) < 1)
			)Reuuro!p * ,q - p) * h * &;
	!	el{e�if ),h* r) <$1)
			r�turn u;
		else io ((`�* 3) < 2)
			retUrl p * (y` p! * * 2 / 3!$)(h!* 4:
			ehse
	I		ret}r. p;	}(
�HSLtoGB:`~Unction (h�$s, l, a)
	[
		�d *s <�0)
))	' = 5;*			ib`(l <=0.?)
		�vbr q = l * (1 + a);�			elSE
			var q = |!+ s - (l � w);

			var!p = 2 *(l�- q:

	var tr = h + (&� 3i;		vaz ug = h9
	)	var tc < ``- ,1(/ s++
			var r = Math&R/und(CPGlo`!l.HueUoRGB(0, q, tr)(* 255);
)K	~a� g } Math.rgund8�@glgnan.HueTkRSB(p, q, tg) * 253(3
			var b = Math.�ound(SPGlobal.HuetoRGC(pl q< tb) *(251)+			return [r, c,�b$ a|t0];
	},
		
		// a s%t(of(RE's uha� can match �trings"ald eenErqtu cklgr tu4les.
		// f�om John Rasiw cmlos �lugin	//$https:-ogith5b*com/jsue�y/jqtery-lOr-
		stringQarsevs: [
		{	Y		re:�/bfja?\(\s*(\d{13}	\{:,\s*x\d;1,3y)Ts*,Tr*(\d[1,3})\s:(?:,\s*8\d(?:\.\�+)?)\s")?\)',				pArse: funkti/n) execXEsulv$) k
		�i	retur. [
		�			execResu,t[ 1 ],
					e�ecResul4[ 2 ],				)execResult[03 ],
		)	execResult[ 4`]
		)		];
				}
	�	}, {�I		re: /rgja?\(\s(*Td+(?;\.]d+)?)\%\s*,\s*)�$)h?:\.\d+)?)^%\s*,\s+(\d+)?:\.\d+)?)|%\s*(?:,\s*(\d+(:^.\d++?)\s*(?X)/,
	�+parse� FuN#tioo  exe#Rasulp 	 k

			r%$trn$[
						2.75 
 gxecRes}lt1],
						2.550*!GxegResult[2}.
		I	2.55 * e8%cResult[3},	)	execRes}xt[ 4`]
			];
			}
	)	}<()		re:`/3([a-fQ�F0-9]{2})(Zq-fA%L0)9];2})h[i-fA-F0-9}{2}!/,)			rerse:(BuncT)on8!exe#Result ) {
				return [
					0qrse	Nt  execResult[ 1 ], 16 ),
						parseInt( execResult[ 2 ], 16 ),
						parseInt( execResult[ 3 ], 16 )
					];
				}
			}, {
				re: /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/,
				parse: function( execResult ) {
					return [
						parseInt( execResult[ 1 ] + execResult[ 1 ], 16 ),
						parseInt( execResult[ 2 ] + execResult[ 2 ], 16 ),
						parseInt( execResult[ 3 ] + execResult[ 3 ], 16 )
					];
				}
			}, {
				re: /hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
				space: 'hsla',
				parse: function( execResult ) {
					return [
						execResult[1]/360,
						execResult[2] / 100,
						execResult[3] / 100,
						execResult[4]
					];
				}
			}
		],
		template: '<div class="colorpicker dropdown-menu">'+
							'<div class="colorpicker-saturation"><i><b></b></i></div>'+
							'<div class="colorpicker-hue"><i></i></div>'+
							'<div class="colorpicker-alpha"><i></i></div>'+
							'<div class="colorpicker-color"><div /></div>'+
						'</div>'
	};

}( window.jQuery )