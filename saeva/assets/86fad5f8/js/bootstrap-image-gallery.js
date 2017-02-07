/*
 * Bootstrap Image Gallery 2.10
 * https://github.com/blueimp/Bootstrap-Image-Gallery
 *
 * Copyright 2011, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint nomen: true, regexp: true */
/*global define, window, document, jQuery */

(function (factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        // Register as an anonymous AMD module:
        define([
            'jquery',
            'load-image',
            'bootstrap'
        ], factory);
    } else {
        // Browser globals:
        factory(
            window.jQuery,
            window.loadImage
        );
    }
}(function ($, loadImage) {
    'use strict';
    // Bootstrap Image Gallery is an extension to the Modal dialog of Twitter's
    // Bootstrap toolkit, to ease navigation between a set of gallery images.
    // It features transition effects, fullscreen mode and slideshow functionality.
    $.extend($.fn.modal.defaults, {
        // Delegate to search gallery links from, can be anything that
        // is accepted as parameter for $():
        delegate: document,
        // Selector for gallery links:
        selector: null,
        // The filter for the selected gallery links (e.g. set to ":odd" to
        // filter out label and thumbnail linking twice to the same image):
        filter: '*',
        // The index of the first gallery image to show:
        index: 0,
        // The href of the first gallery image to show (overrides index):
        href: null,
        // The range of images around the current one to preload:
        preloadRange: 2,
        // Offset of image width to viewport width:
        offsetWidth: 100,
        // Offset of image height to viewport height:
        offsetHeight: 200,
        // Set to true to display images as canvas elements:
        canvas: false,
        // Shows the next image after the given time in ms (0 = disabled):
        slideshow: 0,
        // Defines the image division for previous/next clicks:
        imageClickDivision: 0.5
    });
    var originalShow = $.fn.modal.Constructor.prototype.show,
        originalHide = $.fn.modal.Constructor.prototype.hide;
    $.extend($.fn.modal.Constructor.prototype, {
        initLinks: function () {
            var $this = this,
                options = this.options,
                selector = options.selector ||
                    'a[data-target=' + options.target + ']';
            this.$links = $(options.delegate).find(selector)
                .filter(options.filter).each(function (index) {
                    if ($this.getUrl(this) === options.href) {
                        options.index = index;
                    }
                });
            if (!this.$links[options.index]) {
                options.index = 0;
            }
        },
        getUrl: function (element) {
            return element.href || $(element).data('href');
        },
        getDownloadUrl: function (element) {
            return $(element).data('download');
        },
        startSlideShow: function () {
            var $this = this;
            if (this.options.slideshow) {
                this._slideShow = window.setTimeout(
                    function () {
                        $this.next();
                    },
                    this.options.slideshow
                );
            }
        },
        stopSlideShow: function () {
            window.clearTimeout(this._slideShow);
        },
        toggleSlideShow: function () {
            var node = this.$element.find('.modal-slideshow');
            if (this.options.slideshow) {
                this.options.slideshow = 0;
                this.stopSlideShow();
            } else {
                this.options.slideshow = node.data('slideshow') || 5000;
                this.startSlideShow();
            }
            node.find('i').toggleClass('icon-play icon-pause');
        },
        preloadImages: function () {
            var options = this.options,
                range = options.index + options.preloadRange + 1,
                link,
                i;
            for (i = options.index - options.preloadRange; i < range; i += 1) {
                link = this.$links[i];
                if (link && i !== options.index) {
                    $('<img>').prop('src', this.getUrl(link));
                }
            }
        },
        loadImage: function () {
            var $this = this,
                modal = this.$element,
                index = this.options.index,
                url = this.getUrl(this.$links[index]),
                download = this.getDownloadUrl(this.$links[index]),
                oldImg;
            this.abortLoad();
            this.stopSlideShow();
            modal.trigger('beforeLoad');
            // The timeout prevents displaying a loading status,
            // if the image has already been loaded:
            this._loadingTimeout = window.setTimeout(function () {
                modal.addClass('modal-loading');
            }, 100);
            oldImg = modal.find('.modal-image').children().removeClass('in');
            // The timeout allows transition effects to finish:
            window.setTimeout(function () {
                oldImg.remove();
            }, 3000);
            modal.find('.modal-title').text(this.$links[index].title);
            modal.find('.modal-download').prop(
                'href',
                download || url
            );
            this._loadingImage = loadImage(
                url,
                function (img) {
                    $this.img = img;
                    window.clearTimeout($this._loadingTimeout);
                    modal.removeClass('modal-loading');
                    modal.trigger('load');
                    $this.showImage(img);
                    $this.startSlideShow();
                },
                this._loadImageOptions
            );
            this.preloadImages();
        },
        showImage: function (img) {
            var modal = this.$element,
                transition = $.support.transition && modal.hasClass('fade'),
                method = transition ? modal.animate : modal.css,
                modalImage = modal.find('.modal-image'),
                clone,
                forceReflow;
            modalImage.css({
                width: img.width,
                height: img.height
            });
            modal.find('.modal-title').css({ width: Math.max(img.width, 380) });
            if (transition) {
                clone = modal.clone().hide().appendTo(document.body);
            }
            if ($(window).width() > 767) {
                method.call(modal.stop(), {
                    'margin-top': -((clone || modal).outerHeight() / 2),
                    'margin-left': -((clone || modal).outerWidth() / 2)
                });
            } else {
                modal.css({
                    top: ($(window).height() - (clone || modal).outerHeight()) / 2
                });
            }
            if (clone) {
                clone.remove();
            }
            modalImage.append(img);
            forceReflow = img.offsetWidth;
            modal.trigger('display');
            if (transition) {
                if (modal.is(':visible')) {
                    $(img).on(
                        $.support.transition.end,
                        function (e) {
                            // Make sure we don't respond to other transitions events
                            // in the container element, e.g. from button elements:
                            if (e.target === img) {
                                $(img).off($.support.transition.end);
                                modal.trigger('displayed');
                            }
                        }
                    ).addClass('in');
                } else {
                    $(img).addClass('in');
                    modal.one('shown', function () {
                        modal.trigger('displayed');
                    });
                }
            } else {
                $(img).addClass('in');
         (      Modál¾vpidwer(#displaycf');( !  $      €}
        },
 `"  `  abortLoaD; fwnstioN (( {
            mf$(tji3_loadinfImAge)$
     a  `     $ thiS._hoa`ingImage.onnad = Thms._loadKneYiageonerrOr ½ nulL»
 $`    4    }
            winfog.cluarTI-uow4(this._loadingTimeouv);
 !     ¨}.
        prev: funcvioj *) {J   `  (  ( var Ottinns 5 tjis*/0tigjs;
  (! ($     ptionS.index`-}4;0     $  `  i& (o0tionsjindep < 0 
         !     !/ptaonr.index = thiw.$links/leng|h - ±:
 " "  ! $$"4}J !$         thmó.loa$	mege((
 ¤ 0    },
    `   next: f{fctioN ()"z
        8!  tar$options = thys.o0tions;
  0     `   op4i+ncninfex ª= 1;!       0   if 8options.i~dex >`thir.$links>lengüh -01) {
                o0t)Ons.indåx = 0;            }
 $$       ( t(isnlo ¦Image(+;
  0  ($ },
     0! keyXanDder:"fuj#tion! e	 {
     "  $$  {Uitch (e.vhich) {
 !         #C!se 37: // left
  `        cas% 38; / up
`!              e.preventDefault);
   0 a    0    `thiq*prev*+;
  "           " creak;
    (      0case 39: / réght
    "   $   case$40: /¯ down
" (     "   $! d.prgtmhtDe&ault();
!    (  `       fxis.next();
$ $        "`  0rre`k;
      d     ]
   !    },
    (  0wjeelHandler: fwnction e- {
   " "  !   E.0sevdntDefawlt8);
   (   0 ©  e =(u.originalEvent;Š$        `0 this._ÖxeelCotn|lr - this._whmelCOtnôer$||(0;
      `    "tiis_whe%lKoUnter /50(e.wheelDamte || e.$mtail ||(0);
  (h0   ! $ if ((%,wheelDelta && thIsn_wieelcouftur >= 128+ ||
 !     @ h ("   "   (!e.wheel elt` &f u(is.]wheedCountdr  0)) {
         " (   0t(is/prev(	;
         !     $thi{._wheelounper = 0;
       $    } else if ((e/wheehDelt! && this.wheelC}unter <= -120) |t
    `       $     !     (!e.whee.Ddlpi §. this.ßvheelGount%r ¾ 0+) z
 0  $           this.next();*             ! thiS._wheelCouîter"? 0»
   ( 000    }*   !    },
  `   2 ifmtGaìleryEvents: fu(ctIon ()"s
     "    ` var $thms = thi3.
   0`      " `! modah = this.$element;
     !($  ) modal.dmfdh'/moäal-i}awe'	&on('clkók>mofAn-galmEry', function (%) {
0 ¡             var"modaL	magl = $(t(is);(     0 `       if *$this.¤lhnks,lelOth <==`1) {
   ! $         !  0  thIs.h	te(!;             0" }0ulsg {
       !0       `   if ((e.pageX`-(mod!lImage.gffsgt().left) ' modalImqwe.uidti(9 <
      !              `     ,this®gxtiofs.meageClyckDivmsion) y
         $ (   !    0    thhs.prev(m)+
   "    4           } else z
            $  $    !   %thas.next(e);
  $  !    ` `       }
   "        $$! }
(  `      $ });
  $!   $   (lo`an.fynd8'mglal-prdt#).on('click.,od¡l-galldry', funcvion (d! {
0  !$    0       thió.p2gv(e);
        (   });
   (    $   molal.finh('.mo$al-next%).on¨'cligk*m?daì-galtery'. function *e) {* $    "        $$tha{.nex4(e)
    !` (    ý);
  `   !  ! "hodal.fè~d('.modam-slidashow'9.on,&clicû.model/fallerY', fuOction *di"s
                dvliu®toggleQlideShow(ei;*(      ! (  );
 0$       ( $(documalt)
     0     `  0 .oo('keidow..moda,íg llery', functimf (e) {
0  $     "      0   $ujiq>keyHanäler(e);
  "             ])   ! 0          *on*      2 $    `%     'mogsewhEul.kodal-ga,lery, DOMMmuseScrohl&iolal-g#l|eryF,
  `    0$          fuoction`(e)${J!!         (          !$thhs.ghmelHandler(e);
         ` 0%       }
      0!" (    ");
 `      }<
 $( 2   dgstryGalddryUVmnts: funcdaon 8) {
$     $   ( va2 m/da| } ô`Isj$elegånt;
 0        " this&qbgòtoad();
           "vhis.stopWdideShow));
     $  0   modal.fifl(e.oodaL%imam%, .modal-ptev, .mOdal-neyt, .modaL-slidecèow')
     !"    `    .ovf(%cligk,}ïäal-galleR9%)3         "  ,(document)
         & "   ".off('kmidownnmodal/galhery#)
$¨       ! 0"   .gff gmousewhem|mofal-galldry,!DO]MouseSbroll.moden-ealmeòy');0       }< !    4 qhow: functio*"*-`[
    $   !   if((¡tliS*isSHown &. this.$eiummnt.jasCdass(modal-galhery'))0{
 a!         ""( ÿar0mo$al$= thic.$eLauent,
(   !  `     4     $oqtaons$ thIs.OptmOnS-
     "    0!     "  i.dowwidth = $(wkldow(&7idth¨),
!     `      !(  2  window@eiwhl1= $uintgu9.hDyght();       0   0    iv (mmdal.hasCLcss(5}Oeql­fulLscreen'	)!{!  (       `  `    !ThkqnWloadImágeOptionq 9 {J $ !  `         0       íaxWidTh> winDowW)dth,
" `    0             0  maxHeig(4* gindowgxcht,
        "   0         0 canvas: opt)Ons.canvas      `(            };
   "           0    hf (modilnhaqC,ass('mndal-fullócreen=ôretcho)) {Š    (     !        ( ` $thi{._loa$Ym!ogO`t)nns.einWidth = ÷)nDowWiduh;
          $   $     !   tèis._loqdImAgeJqtinr.minHeigh| = 7ijdowJd)ghd;
$  `   ` h#      !  ]
"      $! (    ``else {*$$          $` 0    uhis._lgadHgageGptionc ?({
 $                     ma8Width winfîwadth -0optiGnsnïffsetWidWh.
   $            !       maxHeiehp:(wyn`owHEight -`optigns.ovfsqt@eighTl
              #)     "  canvas:aordinl3.banvcs
  !                 };   (   `     !! }
          !   8$if (indogWadth(.$767© {
    `            `  moeal.css({
 0  2  `(        12     'ia2gIn9top%8 -(modal/ouôesI%igh4 ) / 2)t
 0                  ((! 'margin-lefu&: -(eoeál.o5t%rWie4h*) g2)
                  ! });
"   4#  b       u Eìse {
" 2 $  `            mo$al,crs({
 "            0  (     `tox: 8d(wifdow	.height() - Okdal/kterHeiG(t()) /a2 $    `             });
`(          $(  } 0    "        this.(niuGylleryEvents();
                thy{.iziuLioos");
   (  ($ 0  " ! iF lth)qlinks.lenwv() {
!    $  (    $   (  modaì.fand('m/dal-shideshkw,".mofAl-pref, .modal-Ng8t')
!(                 `    .õKWgl%(this.$lifcs,nejgth!!9= 1);       B           modal.togleClass(
   à        (    !     'Modam-siîgne',
     "   ,0  0  "   0   thir.$linkS/,emgtx059½ 1
                $   );
            ! $    (4his.loafI}age();
 $       ( b  " }
 0$  ! ` "  }
"  00       or)'inalShow.a`pNy(ô`is, arguments+;
        }¬
 0 !  ( xiDe: funb|ion`¨)"{
           0)d (this.isShown &% |his. q,ement.hasClass('lodal-gålleby/)) {
 $0  `          5hik>optionsnd%lgGaTe = documwnt;
          $  ` (phis.wptéOks&Hzev$=ˆnulh;
           (   thi3.desÔroyWa,leryAvejtw();J     ( *    }
     (($  ! nriginamHide.apply(this, asguments);
       !}    u); "   (funátion ()2{
        $Htocuoent.body-.nn(
   $(       'alùãk.mgdál-eallery.dátaapi',
        "   g[data-togglu¼"molal/gallåry"M',
            fanctiol (m) i
           @    va2$$fils!} $(this((   0            `   Opõions = $this.data(-,
"  `    $   $      "model = ,(n0tions.tirG t),
      !     ($ !  $ dAta = mmdal.data('oodah'-,
 !`"      `         lif+;
   0  $        "ig h!da|a) 
          $0        optéons =$$.Dxdeld(mod`l.dcta(	, op4ioNs);       !  !`  ` }J`!            !if *0opTions.sdmeator) {
  (!  "     (   0   optImns.ñegector"= 'a[detamga|lery=galleryM';
            #   }
      `         link = $(e.targe|),alo{est¨optkons>Semector)+       d  (  " $i&@(link.ìejgth0&. modal.length( {!  $     !   ` ¢   "e.preventDefault();
 ( !    "!       0  opTions.hred =hli.k.p2op('href') \l(lénkfdaTa('lrdn/);
 ` "$ "  "    `  0  ottkoNsnfelagate = ìink[ ] !=5 piac"?(|his(: aoculent;
              $    ¡if!tava) {
 `   !    ,     0    (  $.extend(tata*optionq, opthon3);
("     0           "}      0        $ à  oodal.Ikdal!oðtiïns);
a  0  (      !  m
   ` $ a "  yj    `   )¹
   })»*}	);