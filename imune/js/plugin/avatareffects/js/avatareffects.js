var SELF; 
function AvatarEffectsClass(){
	//main
	this.instalationDir = "js/plugin/avatareffects/";
	this.langName = "pt-br";
	this.lang;
	this.initializedApp = false;
	this.initializedEvents = false;
	this.hasImage = false;
	this.senderInstance=null;
	this.$container;
	this.unmodifiedImage = document.createElement('canvas');
    this.orig_src = new Image();
    this.image_target;
    this.event_state = {};
    this.constrain = false;
    this.min_width = 0;
    this.min_height = 0;
    this.max_width = 0;
    this.max_height = 0;
    this.resize_canvas=document.createElement('canvas');
    this.predefinedWidth;
    this.predefinedHeight;
    this.defaultWidth=0;
    this.defaultHeight=0;
    this.destination = null;
    this.forceSize=false;
    this.avatarsizeShow = false;
    this.haveChanges = false;
    this.cropOn = false;
    this.overlayDrag = false;
    this.localStream;
    this.keepProportional = true;
    this.manualResizeFactorWidth = 1;
    this.manualResizeFactorHeight = 1;
    
    //mouse
    this.mouse = {};
    this.width;
    this.height;
    this.left;
    this.top;
    this.offset;
    this.touches;
    
    //modals
    this.modalMainApp;
    this.modalImportUrlImage;
    this.modalAlert;
    this.modalLoading;
    
    //reference
    SELF=this;
    
    //events
    $('.avatarselector').on('click', SELF.selectAvatar);
}
AvatarEffectsClass.prototype.startEvents = function() {
	//modals
	SELF.modalMainApp = $('#avatareffectsapp').modal({
		show : false
	});
    SELF.modalImportUrlImage = $('#modalUrlInport').modal({
		show : false
	});
    SELF.modalAlert = $('#modalAlert').modal({
		show : false
	});
	SELF.modalLoading = $('#modalLoading').modal({
		show : false
	});
	SELF.modalRepository = $('#modalRepository').modal({
		show : false
	});
	
	//events
	$('#avt-import-webcam').on('click', SELF.importFromWebCam);
	$('#avt-import-upload input[type="file"]').on('change', SELF.importUploadImage);
	$('#btn-import-url').on('click', SELF.importUrlImage);
	$('.avt-btnfinish').on('click', SELF.finishEdit);
	$('.dropdown-menu').on({
		"click" : function(e) {
			e.stopPropagation();
		}
	});
	$('#avt-btn-import-image').on('click', function() {
		SELF.modalImportUrlImage.modal('show');
	});
	$('#avt-import-repository').on('click', function() {
		$('#modalRepository').find('.modal-body').css('height',$( window ).height()*0.6);
		SELF.modalRepository.modal('show');
		if (!$('.avt-repositorylist').find('.avt-repositorylist-item').length)
		{
			SELF.loadRepository();
			$('.avt-repositorylist-item').find('.thumbnail').on('click', SELF.repositorySelectItem);
		}
	});
	$('.avt-lang-dropdownmenu').off("click");//remove stopPropagation
	$('.avt-btnclose').on('click', SELF.closeApp);
	$("[data-toggle='tooltip']").tooltip();// enable tooltips
	$('.takepicture').on('click', SELF.takePicture);
	$('.takepicture').hide();
	$('.avt-lang-menu li').on('click', SELF.changeLanguage);
	
	SELF.initializedEvents=true;
};	

AvatarEffectsClass.prototype.selectAvatar = function() {
	//set app caller
	SELF.senderInstance = this;
	//set start parameters
	SELF.destination = $(SELF.senderInstance).attr('data-destination');
	if(!SELF.destination)
	{
		SELF.showModalDialog(SELF.lang.error, SELF.lang.nodestination);
		return;
	}	
	SELF.predefinedWidth = $(SELF.senderInstance).attr('data-pre-w');
	SELF.predefinedWidth = !SELF.predefinedWidth ? 470 : SELF.predefinedWidth;
	if($(SELF.senderInstance).attr('data-pre-w'))
		SELF.defaultWidth = $(SELF.senderInstance).attr('data-pre-w');
	if($(SELF.senderInstance).attr('data-pre-h'))
		SELF.defaultHeight = $(SELF.senderInstance).attr('data-pre-h');
	SELF.predefinedHeight = $(SELF.senderInstance).attr('data-pre-h');
	SELF.predefinedHeight = !SELF.predefinedHeight ? 320 : SELF.predefinedHeight;
	SELF.forceSize = $(SELF.senderInstance).attr('data-force-size');	
	SELF.forceSize = !SELF.forceSize ? false : SELF.forceSize;
	SELF.min_width = $(SELF.senderInstance).attr('data-minwidth');
	SELF.min_width = !SELF.min_width ? 0 : SELF.min_width;
	SELF.min_height = $(SELF.senderInstance).attr('data-minheight');
    SELF.min_height = !SELF.min_height ? 0 : SELF.min_height;
    SELF.max_width = $(SELF.senderInstance).attr('data-maxwidth');
    SELF.max_width = !SELF.max_width ? 0 : SELF.max_width;
    SELF.max_height = $(SELF.senderInstance).attr('data-maxheight');
    SELF.max_height = !SELF.max_height ? 0 : SELF.max_height;
	SELF.keepProportional = $(SELF.senderInstance).attr('data-keepproportional');
	SELF.keepProportional = !SELF.keepProportional ? true : SELF.keepProportional;
	//validation
	if(SELF.min_width > SELF.max_width && SELF.max_width !== 0)
	   SELF.max_width = parseInt(SELF.min_width,10)+1;
	if(SELF.min_height > SELF.max_height && SELF.max_height !== 0)
	   SELF.max_height = parseInt(SELF.min_height,10)+1;
	//load app html if not loaded
	SELF.avatarEffectsInit(this);
	
	//Drag And Drop
	SELF.turnOnDragAndDrop();
	
	//translate app
	SELF.tradutor();
	
	//remove last avatar
	if (SELF.image_target !== undefined && SELF.image_target !== null)
	{
		SELF.image_target.getContext("2d").clearRect(0, 0, SELF.image_target.width, SELF.image_target.height);
		SELF.setChangesStateOn(true);
		SELF.applySettingsToImage();
		SELF.setHasImage(false);
	}
	
	//show the app
	SELF.modalMainApp.modal('show');
};
AvatarEffectsClass.prototype.setHasImage = function(value) {
	SELF.hasImage=value;
	if(SELF.hasImage)
	{
		if($('.resize-container').length)
		$('.resize-container').css("visibility","visible");
	}
	else
	{
		if($('.resize-container').length)
		$('.resize-container').css("visibility","hidden");
	}
};
AvatarEffectsClass.prototype.closeApp = function() {
	//close the app
	SELF.modalMainApp.modal('hide');
};
AvatarEffectsClass.prototype.avatarEffectsInit = function(e) {
	var content = '<div class="modal fade" id="avatareffectsapp"> <div class="avt-backgroundapp" id="selectavatar"> <div class="col-xs-12 mainrow"> <div class="col-xs-12 navbar-fixed-top avt-transparent avt-top-nav"><span class="glyphicon glyphicon-remove avt-btnclose" aria-hidden="true"></span>  </div> <div class="overlay-content"> <div class="overlay"> <div class="overlay-inner"></div> </div> <div class="btn-crop"> <span class="glyphicon glyphicon-scissors" aria-hidden="true"></span> </div> <span style="position:absolute;top: -47px;left:-15px;text-shadow: rgb(255, 255, 255) 0px 0px 5px;">X:</span> <span style="position:absolute;top: -27px;left:-15px;text-shadow: rgb(255, 255, 255) 0px 0px 5px;">Y:</span> <input type="range" class="avt-input avt-slider avatarcropwidth crop-sliderX" min=20 max=600 step=1 value=200> <input type="range" class="avt-input avt-slider avatarcropheight crop-sliderY" min=20 max=600 step=1 value=200> </div> <div class="col-xs-12" id="avatareffectscontent"> </div> <button class="avt-button takepicture"><span class="glyphicon glyphicon-camera" aria-hidden="true"></span></button> <div class="col-xs-12 navbar-fixed-bottom avt-transparent"> <div class="text-center"> <div class="avt-main-btns btn-group avt-main-btn" role="group"> <div class="avt-btn-left dropup avt-main-tooltip avt-main-tooltip-import" role="group" data-toggle="tooltip" data-placement="top" data-original-title="IMPORT IMAGE"> <button type="button" class="avt-button btn btn-circle btn-xl avt-dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button> <ul class="dropdown-menu" role="menu"> <li> <div id="avt-import-repository" class="avt-menu-item"> <span class="glyphicon glyphicon-th" aria-hidden="true"></span><span class="avt-lang-gallery avt-leftspace">Gallery</span> </div> </li> <li> <div id="avt-import-webcam" class="avt-menu-item"> <span class="glyphicon glyphicon-camera" aria-hidden="true"></span><span class="avt-lang-webcam avt-leftspace">Webcam</span> </div> </li> <li> <div id="avt-import-upload" class="avt-menu-item"> <input type="file" class="avt-input" /><span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span><span class="avt-lang-upload avt-leftspace">Upload</span> </div> </li> <li> <div class="avt-menu-item" id="avt-btn-import-image"> <span class="glyphicon glyphicon-link" aria-hidden="true"></span><span class="avt-lang-urlimport avt-leftspace">URL Import</span> </div> </li> </ul> </div> <div class="avt-btn-left dropup avt-main-tooltip avt-main-tooltip-settings" role="group" data-toggle="tooltip" data-placement="top" data-original-title="SETTINGS"> <button type="button" class="avt-button btn btn-circle btn-xl avt-dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> </button> <ul class="dropdown-menu" role="menu"> <li> <p class="text-info text-center applychangesinfo avt-lang-nochanges">No Changes</p> </li> <li role="presentation" class="divider"></li> <li> <ul class="menu menu-top-dropdown"> <li> <p class="text-muted text-center avt-lang-retrieve">Retrieve original</p> <span class="glyphicon glyphicon-refresh avt-btn-small-config btnretrieve" aria-hidden="true"></span> </li> <li role="presentation" class="divider"></li> <li> <p class="text-muted text-center avt-lang-crop">Crop</p> <div class="glyphicon avt-btn-crop"> <div class="avt-btn-crop-id"></div> <div class="cropstate avt-lang-off">Off</div> </div> </li> <li><li role="presentation" class="divider"></li> <li> <p class="text-muted text-center avt-lang-align">Align</p> <span class="glyphicon glyphicon-align-left avt-btn-small-config avataralignleft" aria-hidden="true"></span> <span class="glyphicon glyphicon-align-center avt-btn-small-config avataraligncenter" aria-hidden="true"></span> <span class="glyphicon glyphicon-align-right avt-btn-small-config avataralignright" aria-hidden="true"></span> </li> <li role="presentation" class="divider"></li> <li> <p class="text-muted text-center avt-lang-flip">Flip Avatar</p> <span class="glyphicon glyphicon-resize-vertical avt-btn-small-config btnflipY" aria-hidden="true"></span> <span class="glyphicon glyphicon-resize-horizontal avt-btn-small-config btnflipX" aria-hidden="true"></span> </li> <li role="presentation" class="divider"></li> <li> <p class="text-muted text-center avt-lang-invertdimensions">Invert dimensions</p> <span class="glyphicon glyphicon-retweet avt-btn-small-config btninvertdimensions" aria-hidden="true"></span> </li> <li role="presentation" class="divider"></li> <li> <p class="text-muted text-center avt-lang-resize">Resize</p> <input type="range" class="avt-input avt-slider avt-rangeres-width" min=10 max=200 step=1 value=100> <br> <input type="range" class="avt-input avt-slider avt-rangeres-height" min=10 max=200 step=1 value=100> </li> <li role="presentation" class="divider"></li> </ul> </li> <li role="presentation" class="divider"></li> </ul> </div> <div class="avt-btn-left dropup avt-main-btn avt-main-tooltip avt-main-tooltip-effects" role="group" data-toggle="tooltip" data-placement="top" data-original-title="EFFECTS"> <button type="button" class="avt-button btn btn-circle btn-xl avt-dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="glyphicon glyphicon-tint" aria-hidden="true"></span> </button> <ul class="dropdown-menu effects-menu" role="menu"> <li> <p class="text-info text-center applychangesinfo avt-lang-nochanges">No Changes</p> </li> <li role="presentation" class="divider"></li> <li><div><ul class="menu effects-menu-left"> <li> <p class="text-muted text-center avt-lang-rgbadjust">RGB Adjust</p> <input type="range" class="avt-input avt-slider btncolorR" min=1 value=100 max=200> <br> <input type="range" class="avt-input avt-slider btncolorG" min=1 value=100 max=200> <br> <input type="range" class="avt-input avt-slider btncolorB" min=1 value=100 max=200> </li> <li role="presentation" class="divider"></li> <li> <p class="text-muted text-center avt-lang-brightness">Brightness</p> <input type="range" class="avt-input avt-slider btnbrightness" min=-200 value=0 max=200> </li> <li role="presentation" class="divider"></li> <li> <p class="text-muted text-center avt-lang-contrast">Contrast</p> <input type="range" class="avt-input avt-slider btncontrast" min=100 value=100 max=200> </li> <li role="presentation" class="divider"></li> <li> <p class="text-muted text-center avt-lang-hue">Hue</p> <input type="range" class="avt-input avt-slider btnhue" min=0 value=0 max=359> </li> <li role="presentation" class="divider"></li> <li> <p class="text-muted text-center avt-lang-pixelate">Pixelate</p> <input type="range" class="avt-input avt-slider rangepixelate" min=1 value=15 max=100> </li> <li role="presentation" class="divider"></li> <li> <p class="text-muted text-center avt-lang-threshold">Threshold</p> <input type="range" class="avt-input avt-slider rangethreshold" min=0 value=128 max=255> </li> <li role="presentation" class="divider"></li> <li> <p class="text-muted text-center avt-lang-blur">Blur</p> <input type="range" class="avt-input avt-slider rangeblur" min=0 value=1 max=20> </li> <li role="presentation" class="divider"></li> <li> <p class="text-muted text-center avt-lang-sharpen">Sharpen</p> <input type="range" class="avt-input avt-slider rangesharpen" min=0 value=50 max=80> </li> </ul></div> <div class="menu avt-menu-effect"> <div class="col-xs-12"> <div class="col-xs-6 btnautoeffect avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/auto.jpg"> <span class="avt-lang-auto">Auto</span> </div> <div class="col-xs-6 btnvivid avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/vivid.jpg"> <span class="avt-lang-vivid">Vivid</span> </div> </div> <div class="col-xs-12"> <div class="col-xs-6 btnsepia avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/sepia.jpg"> <span class="avt-lang-sepia">Sepia</span> </div> <div class="col-xs-6 btngrayscale avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/grayscale.jpg"> <span class="avt-lang-grayscale">Grayscale</span> </div> </div> <div class="col-xs-12"> <div class="col-xs-6 btninvertcolors avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/invertcolors.jpg"> <span class="avt-lang-invert">Invert</span> </div> <div class="col-xs-6 btnsharpen avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/sharpen.jpg"> <span class="avt-lang-sharpen">Sharpen</span> </div> </div> <div class="col-xs-12"> <div class="col-xs-6 btnoilpaint avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/oilpaint.jpg"> <span class="avt-lang-oilpaint">Oil Paint</span> </div> <div class="col-xs-6 btnthreshold avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/threshold.jpg"> <span class="avt-lang-threshold">Threshold</span> </div> </div> <div class="col-xs-12"> <div class="col-xs-6 btnarchaic avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/archaic.jpg"> <span class="avt-lang-archaic">Archaic</span> </div> <div class="col-xs-6 btnblur avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/blur.jpg"> <span class="avt-lang-blur">Blur</span> </div> </div> <div class="col-xs-12"> <div class="col-xs-6 btnpixelate avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/pixelate.jpg"> <span class="avt-lang-pixelate">Pixelate</span> </div> <div class="col-xs-6 btndraw avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/draw.jpg"> <span class="avt-lang-draw">Draw</span> </div> </div> <div class="col-xs-12"> <div class="col-xs-6 btnvestige avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/vestige.jpg"> <span class="avt-lang-vestige">Vestige</span> </div> <div class="col-xs-6 btnsolar avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/solar.jpg"> <span class="avt-lang-solar">Solar</span> </div> </div> <div class="col-xs-12"> <div class="col-xs-6 btnfabric avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/fabric.jpg"> <span class="avt-lang-fabric">Fabric</span> </div> <div class="col-xs-6 btndark avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/dark.jpg"> <span class="avt-lang-dark">Dark</span> </div> </div> <div class="col-xs-12"> <div class="col-xs-6 btnlight avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/light.jpg"> <span class="avt-lang-light">Light</span> </div> <div class="col-xs-6 btnarchaic2 avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/archaic2.jpg"> <span class="avt-lang-archaic2">Archaic 2</span> </div> </div> <div class="col-xs-12"> <div class="col-xs-6 btnground avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/ground.jpg"> <span class="avt-lang-ground">Ground</span> </div> <div class="col-xs-6 btnpure avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/pure.jpg"> <span class="avt-lang-pure">Pure</span> </div> </div> <div class="col-xs-12"> <div class="col-xs-6 btndraw2 avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/draw2.jpg"> <span class="avt-lang-draw2">Draw 2</span> </div> <div class="col-xs-6 btndraw3 avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/draw3.jpg"> <span class="avt-lang-draw3">Draw 3</span> </div> </div> <div class="col-xs-12"> <div class="col-xs-6 btndraw4 avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/draw4.jpg"> <span class="avt-lang-draw4">Draw 4</span> </div> <div class="col-xs-6 btnspirit avt-effect-menu-item"> <img src="'+SELF.instalationDir+'img/effects/spirit.jpg"> <span class="avt-lang-spirit">Spirit</span> </div> </div> </div> </li> <li role="presentation" class="divider"></li> <li> <div class="text-center"> <span class="glyphicon glyphicon-floppy-saved avt-btn-apply btnapply" title="" data-placement="bottom" data-toggle="tooltip" data-original-title="No changes to apply"></span><span class="glyphicon glyphicon-trash avt-btn-delete avt-lang-delete" title="" data-placement="bottom" data-toggle="tooltip" data-original-title="Delete unsaved changes"></span></div> </li> </ul> </div> <div class="avt-btn-left dropup avt-main-tooltip avt-main-tooltip-finish" role="group" data-toggle="tooltip" data-placement="top" data-original-title="FINISH"> <button type="button" class="avt-button btn btn-circle btn-xl avt-dropdown-toggle avt-btnfinish" data-toggle="dropdown" aria-expanded="false"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> </button> </div> </div> </div> </div> </div> </div></div><div class="modal fade" id="modalUrlInport" tabindex="-1" role="dialog" aria-hidden="true"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="avt-lang-enterurl">Please enter the image url</h4> </div> <div class="modal-body"> <label for="recipient-name" class="control-label avt-lang-linktoimage">Link to image file:</label> <input type="text" class="form-control" id="modalurlinport-url"> </div> <div class="modal-footer"> <button type="button" class="btn btn-default avt-lang-cancel" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-danger avt-lang-ok" data-dismiss="modal" id="btn-import-url">Ok</button> </div> </div> </div></div><div class="modal fade" id="modalAlert" tabindex="-1" role="dialog" aria-hidden="true"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 id="modalalert-title"></h4> </div> <div class="modal-body"> <h4 id="modalalert-msg"></h4> </div> <div class="modal-footer"> <button type="button" class="btn btn-danger avt-lang-ok" data-dismiss="modal" id="btn-import-url">Ok</button> </div> </div> </div></div><div class="modal fade" id="modalLoading" tabindex="-1" role="dialog" aria-hidden="true"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="avt-lang-wait">Please wait</h4> </div> <div class="modal-body"> <div class="row avt-center-obj"> <img src="'+SELF.instalationDir+'img/uploadingavatar.gif" /> <p class="avt-lang-loading">Loading...</p> </div> </div> </div> </div></div><div class="modal fade" id="modalRepository" tabindex="-1" role="dialog" aria-hidden="true"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="avt-lang-gallery">Gallery</h4> </div> <div class="modal-body"> <div class="row avt-repositorylist"> <div class="col-lg-12 col-sm-12 col-xs-12 text-center"> <a href="http://www.freepik.com">Images Designed by Freepik</a> </div> </div> </div> <div class="modal-footer"> </div> </div> </div></div>';
	if (!$('#avatareffectsapp').length) {
		$('body').append(content);
	}
	//set app events
	if(!SELF.initializedEvents)
		SELF.startEvents();
	
	//load source image
	if ($(e).attr('data-source') !== undefined && $(e).attr('data-source') !== null)
	if ($(e).attr('data-source').length)// auto load image
	{
		var exp = "#"+$(e).attr('data-source');
		try {
			if($(exp).length)//if source is an image obj
			{
				SELF.importUrlImage($(exp).get(0).src);
			}
			else//no source obj found so load a default image
				{
					SELF.importUrlImage(SELF.instalationDir+"/img/repository/1.jpg");
				}
		}
		catch(err) {
			//error when finding img obj so source is an url
			SELF.importUrlImage($(e).attr('data-source'));
		}
	}
};
AvatarEffectsClass.prototype.init = function () {
	SELF.orig_src.src = SELF.image_target.toDataURL("image/png");
	$(SELF.image_target).wrap('<div class="resize-container"></div>').before(
			'<span class="resize-handle resize-handle-nw"></span>').before(
			'<span class="resize-handle resize-handle-ne"></span>').after(
			'<span class="resize-handle resize-handle-se"></span>').after(
			'<span class="resize-handle resize-handle-sw"></span>');
	SELF.$container = $(SELF.image_target).parent('.resize-container');
	SELF.$container.on('mousedown touchstart', '.resize-handle', SELF.startResize);
	SELF.$container.on('mousedown touchstart', 'canvas', SELF.startMoving);
	$('.btn-crop').on('click', SELF.crop);
	$('.btnhue').on('change', SELF.hue);
	$('.btnapply').on('click', SELF.applySettingsToImage);
	$('.btnbrightness').on('change', SELF.setBrightness);
	$('.btncontrast').on('change', SELF.setContrast);
	$('.btnautoeffect').on('click', SELF.setAuto);
	$('.btnvivid').on('click', SELF.setVivid);
	$('.btncolorR').on('change', SELF.setColorRed);
	$('.btncolorG').on('change', SELF.setColorGreen);
	$('.btncolorB').on('change', SELF.setColorBlue);
	$('.btnflipX').on('click', SELF.flipX);
	$('.btnflipY').on('click', SELF.flipY);
	$('.btnsepia').on('click', SELF.setSepia);
	$('.btngrayscale').on('click', SELF.setGrayscale);
	$('.btnredeffect').on('click', SELF.setRed);
	$('.btninvertcolors').on('click', SELF.setInvertColors);
	$('.btnvestige').on('click', SELF.setVestige);
	$('.btnsolar').on('click', SELF.setSolar);
	$('.btnfabric').on('click', SELF.setFabric);
	$('.btndark').on('click', SELF.setDark);
	$('.btnlight').on('click', SELF.setLight);
	$('.btnarchaic2').on('click', SELF.setArchaic2);
	$('.btnground').on('click', SELF.setGround);
	$('.btnpure').on('click', SELF.setPure);
	$('.btndraw2').on('click', SELF.setDraw2);
	$('.btndraw3').on('click', SELF.setDraw3);
	$('.btndraw4').on('click', SELF.setDraw4);
	$('.btnspirit').on('click', SELF.setSpirit);
	$('.btnthreshold').on('click', function() {
		SELF.setDefaultEffectValue('Threshold');
		SELF.setThreshold();
	});
	$('.rangethreshold').on('change', SELF.setThreshold);
	$('.btnblur').on('click', function() {
		SELF.setDefaultEffectValue('Blur');
		SELF.setBlur();
	});
	$('.rangeblur').on('change', SELF.setBlur);
	$('.btnoilpaint').on('click', SELF.setOilPaint);
	$('.btnpixelate').on('click', function() {
		SELF.setDefaultEffectValue('Pixelate');
		SELF.setPixelate();
	});
	$('.rangepixelate').on('change', SELF.setPixelate);
	$('.btnsharpen').on('click', function() {
		SELF.setDefaultEffectValue('Sharpen');
		SELF.setSharpen();
	});
	$('.rangesharpen').on('change', SELF.setSharpen);
	$('.btndraw').on('click', SELF.setDraw);
	$('.btnarchaic').on('click', SELF.setArchaic);
	$('.btnavatarsizeclose').on('click', SELF.animeMenu);
	$('.avatarcropwidth').on('change', SELF.avatarcropWidth);
	$('.avatarcropheight').on('change', SELF.avatarcropHeight);
	$('.avataralignleft').on('click', SELF.leftAvatar);
	$('.avataraligncenter').on('click', SELF.centerAvatar);
	$('.avataralignright').on('click', SELF.rightAvatar);
	$('.avt-rangeres-width, .avt-rangeres-height').on('change', SELF.setRangeResize);
	$('.btnpredefined').on('click', SELF.setPredefined);
	$('.btnretrieve').on('click', SELF.recoverUnmodifiedImage);
	$('.btninvertdimensions').on('click', SELF.invertDimensions);
	$('.avt-btn-crop').on('click', SELF.cropOnOff);
	$('.avt-btn-delete').on('click', SELF.deleteUnsavedChanges);
	
	SELF.initializedApp = true;
};
AvatarEffectsClass.prototype.changeLanguage = function() {
	SELF.langName = $(this).attr('data-lang');
	SELF.langName = !SELF.langName ? "us" : SELF.langName;
	docCookies.setItem("avtlang", SELF.langName, Infinity);
	SELF.tradutor();
};
AvatarEffectsClass.prototype.tradutor = function() {
	if(docCookies.getItem("avtlang") !== null)
		SELF.langName = docCookies.getItem("avtlang");
	SELF.lang = new Language(SELF.langName);
	$('.avt-langselected').attr("src", SELF.instalationDir+"img/langs/"+SELF.langName+".png");//the image file name must be the same defined in SELF.langName
	
	$('.avt-lang-nochanges').text(SELF.lang.nochanges);
	$('.avt-lang-presize').text(SELF.lang.predefsize);
	$('.avt-lang-align').text(SELF.lang.align);
	$('.avt-lang-flip').text(SELF.lang.flipavt);
	$('.avt-lang-crop').text(SELF.lang.crop);
	$('.avt-lang-apply').text(SELF.lang.apply);
	$('.avt-lang-webcam').text(SELF.lang.webcam);
	$('.avt-lang-upload').text(SELF.lang.upload);
	$('.avt-lang-urlimport').text(SELF.lang.urlimport);
	$('.avt-lang-rgbadjust').text(SELF.lang.rgbadjust);
	$('.avt-lang-brightness').text(SELF.lang.brightness);
	$('.avt-lang-contrast').text(SELF.lang.contrast);
	$('.avt-lang-hue').text(SELF.lang.hue);
	$('.avt-lang-pixelate').text(SELF.lang.pixelate);
	$('.avt-lang-threshold').text(SELF.lang.threshold);
	$('.avt-lang-blur').text(SELF.lang.blur);
	$('.avt-lang-sharpen').text(SELF.lang.sharpen);
	$('.avt-lang-sepia').text(SELF.lang.sepia);
	$('.avt-lang-grayscale').text(SELF.lang.grayscale);
	$('.avt-lang-invert').text(SELF.lang.invert);
	$('.avt-lang-oilpaint').text(SELF.lang.oilpaint);
	$('.avt-lang-archaic').text(SELF.lang.archaic);
	$('.avt-lang-draw').text(SELF.lang.draw);
	$('.avt-lang-question').text(SELF.lang.question);
	$('.avt-lang-no').text(SELF.lang.no);
	$('.avt-lang-yes').text(SELF.lang.yes);
	$('.avt-lang-enterurl').text(SELF.lang.enterurl);
	$('.avt-lang-linktoimage').text(SELF.lang.linktoimage);
	$('.avt-lang-cancel').text(SELF.lang.cancel);
	$('.avt-lang-ok').text(SELF.lang.ok);
	$('.avt-lang-off').text(SELF.lang.off);
	$(".avt-lang-delete").attr('data-original-title', SELF.lang.deleteunsavedchanges);
	$(".avt-lang-auto").text(SELF.lang.auto);
	$(".avt-lang-vivid").text(SELF.lang.vivid);
	$(".avt-lang-vestige").text(SELF.lang.vestige);
	$(".avt-lang-solar").text(SELF.lang.solar);
	$(".avt-lang-fabric").text(SELF.lang.fabric);
	$(".avt-lang-dark").text(SELF.lang.dark);
	$(".avt-lang-light").text(SELF.lang.light);
	$(".avt-lang-archaic2").text(SELF.lang.archaic2);
	$(".avt-lang-ground").text(SELF.lang.ground);
	$(".avt-lang-pure").text(SELF.lang.pure);
	$(".avt-lang-draw2").text(SELF.lang.draw2);
	$(".avt-lang-draw3").text(SELF.lang.draw3);
	$(".avt-lang-draw4").text(SELF.lang.draw4);
	$(".avt-lang-spirit").text(SELF.lang.spirit);
	$(".avt-lang-wait").text(SELF.lang.wait);
	$(".avt-lang-loading").text(SELF.lang.loading);
	$(".avt-lang-retrieve").text(SELF.lang.retrieve);
	$(".avt-lang-gallery").text(SELF.lang.gallery);
	$(".avt-lang-resize").text(SELF.lang.resize);
	$(".avt-lang-invertdimensions").text(SELF.lang.invertdimensions);
	$(".avt-main-tooltip-import").attr('data-original-title', SELF.lang.importimage);
	$(".avt-main-tooltip-settings").attr('data-original-title', SELF.lang.settings);
	$(".avt-main-tooltip-effects").attr('data-original-title', SELF.lang.effects);
	$(".avt-main-tooltip-finish").attr('data-original-title', SELF.lang.finish);
};
//IMPORT
AvatarEffectsClass.prototype.importUrlImage = function(url) {
	if (SELF.localStream !== undefined && SELF.localStream !== null)
		SELF.localStream.stop();
	if ($('#webcam').length) {// remove video and button
		$('#webcam').remove();
		$('.takepicture').hide();
	}
	try {
	var img = new Image();
	img.onload = function() {
		SELF.modalLoading.modal('hide');
		if ($('#avatareffectscontent').length) {
			if (!$('#canvas').length) {
				var htmlcode = '<canvas class="resize-image" id="canvas"></canvas>';
				$('#avatareffectscontent').append(htmlcode);
			}
			var canvas = $('#canvas').get(0);
			
				if (SELF.keepProportional == true) {
						var dim = SELF.getProportionalDimensions(img.width,img.height);
						canvas.width = dim['w'];
						canvas.height = dim['h'];
					} else {
						canvas.width = img.width;
						canvas.height = img.height;
					}
				canvas.getContext("2d").drawImage(img, 0, 0, canvas.width,canvas.height);
				
				SELF.image_target=canvas;
				if(!SELF.initializedApp)
					SELF.init();
				SELF.setChangesStateOn(true);
				SELF.applySettingsToImage();
				SELF.saveUnmodifiedImage(img);
				SELF.updateSizeInfo();
				SELF.setHasImage(true);
				// enable crop button
				$('#slideThree').removeAttr("disabled");
		}
	};
	if (img.addEventListener) {
		img.addEventListener('error', function(e) {
			e.preventDefault();
			SELF.modalLoading.modal('hide');
			SELF.showModalDialog(SELF.lang.crossorigin,
					SELF.lang.sorryload+' '
							+ SELF.getLocation(img.src).hostname);
		});
	} else {
		// Old IE uses .attachEvent instead
		img.attachEvent('onerror', function(e) {
			SELF.modalLoading.modal('hide');
			SELF.showModalDialog(SELF.lang.crossorigin,
					SELF.lang.sorryload+' '
							+ SELF.getLocation(img.src).hostname);
			return false;
		});
	}
	img.setAttribute('crossOrigin', 'anonymous');
	//if no url passed load from modal input
	if (typeof url === 'object' || typeof url === 'undefined')
		img.src = $('#modalurlinport-url').val();
	else
		img.src = url;
	SELF.modalLoading.modal('show');
	$('#modalurlinport-url').val('');
	}
	catch(err) {
		SELF.modalLoading.modal('hide');
		SELF.showModalDialog(SELF.lang.error, err.message);
	}
}
AvatarEffectsClass.prototype.importFromWebCam = function() {
	if (SELF.localStream !== undefined && SELF.localStream !== null)
		SELF.localStream.stop();
	if (SELF.cropOn)
		SELF.cropOnOff();
	if ($('#avatareffectscontent').length) {
		if (!$('#avatareffectscontent').find('#webcam').length) {
			var htmlcode = '<video id="webcam" autoplay></video>';
			$('#avatareffectscontent').append(htmlcode);
		}
		var video = $('#webcam').get(0);
		var videoObj = {
			video : {
				mandatory : {
					minAspectRatio : 1.77,
					maxWidth : 640,
					maxHeight : 480
				}
			}
		};
		var errBack = function(error) {
			$('.takepicture').hide();
			if (error.code == undefined || error.code == null)
				SELF.showModalDialog(SELF.lang.error, SELF.lang.nocamera);
			else
				SELF.showModalDialog(SELF.lang.error, SELF.lang.captureerror+' ' + error.code);
			if ($('#webcam').length) {// remove video and button
				$('#webcam').remove();
				$('.takepicture').hide();
			}
		};
		// Put video listeners into place
		if (navigator.getUserMedia) { // Standard
			navigator.getUserMedia(videoObj, function(stream) {
				video.src = stream;
				SELF.localStream = stream;
				video.play();
				$('.takepicture').show();
			}, errBack);
		} else if (navigator.webkitGetUserMedia) { // webkitGetUserMedia
			navigator.webkitGetUserMedia(videoObj, function(stream) {
				video.src = window.webkitURL.createObjectURL(stream);
				SELF.localStream = stream;
				video.play();
				$('.takepicture').show();
			}, errBack);
		} else if (navigator.mozGetUserMedia) { // mozGetUserMedia
			navigator.mozGetUserMedia(videoObj, function(stream) {
				video.src = window.URL.createObjectURL(stream);
				SELF.localStream = stream;
				video.play();
				$('.takepicture').show();
			}, errBack);
		} else if (navigator.msGetUserMedia) { // msGetUserMedia
			navigator.msGetUserMedia(videoObj, function(stream) {
				video.src = window.URL.createObjectURL(stream);
				SELF.localStream = stream;
				video.play();
				$('.takepicture').show();
			}, errBack);
		} else
		{
			SELF.showModalDialog(SELF.lang.error, SELF.lang.nowebcamsuport);
			if ($('#webcam').length) {// remove video and button
				$('#webcam').remove();
				$('.takepicture').hide();
			}
		}
	}
};
AvatarEffectsClass.prototype.takePicture = function() {
	var video = $('#webcam').get(0);
	video.pause();
	if ($('#avatareffectscontent').length) {
		if (!$('#canvas').length) {
			var htmlcode = '<canvas class="resize-image" id="canvas"></canvas>';
			$('#avatareffectscontent').append(htmlcode);
		}

		var canvas = $('#canvas').get(0);
		
		if (SELF.keepProportional == true) {
			var dim = SELF.getProportionalDimensions(video.videoWidth,video.videoHeight);
			canvas.width = dim['w'];
			canvas.height = dim['h'];
		} else {
			canvas.width = video.videoWidth;
			canvas.height = video.videoHeight;
		}
		canvas.getContext("2d").drawImage(video, 0, 0, canvas.width,canvas.height);
		SELF.image_target=canvas;
		if(!SELF.initializedApp)
			SELF.init();
		SELF.setChangesStateOn(true);
		SELF.applySettingsToImage();
		SELF.saveUnmodifiedImage(video);
		SELF.setHasImage(true);
	}
	SELF.localStream.stop();
	SELF.updateSizeInfo();
	if ($('#webcam').length) {// remove video and button
		$('#webcam').remove();
	}
	$('.takepicture').hide();
	// enable crop button
	$('#slideThree').removeAttr("disabled");
};
AvatarEffectsClass.prototype.getProportionalDimensions = function(w,h) {
	var dimensions = new Array();
	var factor = 0.8;
	if(w > $(window).width() || h > $(window).height())
	{
		if(w > $(window).width())
		{
			dimensions['w'] = $(window).width()*factor;
			dimensions['h'] = (($(window).width()*factor)/w)*h;
		}
		if(h > $(window).height())
		{
			dimensions['w'] = (($(window).height()*factor)/h)*w;	
			dimensions['h'] = $(window).height()*factor;
		}
	}
	else
	{
		dimensions['w'] = w;	
		dimensions['h'] = h;
	}
	return dimensions;
};
AvatarEffectsClass.prototype.importUploadImage = function() {
	if (SELF.localStream !== undefined && SELF.localStream !== null)
		SELF.localStream.stop();
	if ($('#webcam').length) {// remove video and button
		$('#webcam').remove();
		$('.takepicture').hide();
	}
	var obj = this;
	if (obj.files && obj.files[0]) {
		if(!SELF.validExtension(obj.files[0]))
		{
			SELF.showModalDialog(SELF.lang.error, SELF.lang.invalidfile);
			return;
		}
		var FR = new FileReader();
		FR.onload = function(e) {
			var img = new Image();
			img.onload = function() {
				if ($('#avatareffectscontent').length) {
					if (!$('#canvas').length) {
						var htmlcode = '<canvas class="resize-image" id="canvas"></canvas>';
						$('#avatareffectscontent').append(htmlcode);
					}
					var canvas = $('#canvas').get(0);
					if (SELF.keepProportional == true) {
						var dim = SELF.getProportionalDimensions(img.width,img.height);
						canvas.width = dim['w'];
						canvas.height = dim['h'];
					} else {
						canvas.width = img.width;
						canvas.height = img.height;
					}
					canvas.getContext("2d").drawImage(img, 0, 0, canvas.width,canvas.height);
					SELF.updateSizeInfo();
					SELF.image_target=canvas;
					if(!SELF.initializedApp)
						SELF.init();
					SELF.setChangesStateOn(true);
					SELF.applySettingsToImage();
					SELF.saveUnmodifiedImage(img);
					SELF.setHasImage(true);
					// enable crop button
					$('#slideThree').removeAttr("disabled");
				}
			};
			img.src = e.target.result;
		};
		FR.readAsDataURL(obj.files[0]);
	}
};
AvatarEffectsClass.prototype.turnOnDragAndDrop = function() {
// DRAG & DROP
var dnd = 'draggable' in document.createElement('span');
var dndfilereader = typeof FileReader != 'undefined';
var dragAcceptedTypes = {
      'image/png': true,
      'image/jpeg': true,
      'image/jpg': true,
      'image/bmp': true,
      'image/gif': true
    };
if (dnd)
{
	$('#avatareffectsapp').on('dragover', function(event) {
				event.stopPropagation();
                event.preventDefault();
                if(SELF.overlayDrag == false)
                {
					console.log(event);
					SELF.overlayDrag = true;
					$('.avt-backgroundapp .mainrow').prepend( "<div class='avt-overlay-drag text-center'><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span></div>" );
					$('.avt-overlay-drag').on('click', function() {
						SELF.overlayDrag = false;
						$('.avt-overlay-drag').remove();
					});	
				}
	});
	$('#avatareffectsapp').on('drop', function(e) {
		e.preventDefault();
		var files = e.originalEvent.target.files || e.originalEvent.dataTransfer.files;
		if(files.length>0)
		{
			if (dndfilereader === true && dragAcceptedTypes[files[0].type] === true) {
				var reader = new FileReader();
				reader.onload = function (e) {
					var img = new Image();
					img.onload = function() {
					if ($('#avatareffectscontent').length) {
					if (!$('#canvas').length) {
						var htmlcode = '<canvas class="resize-image" id="canvas"></canvas>';
						$('#avatareffectscontent').append(htmlcode);
					}
					var canvas = $('#canvas').get(0);
					if (SELF.keepProportional == true) {
						var dim = SELF.getProportionalDimensions(img.width,img.height);
						canvas.width = dim['w'];
						canvas.height = dim['h'];
					} else {
						canvas.width = img.width;
						canvas.height = img.height;
					}
					canvas.getContext("2d").drawImage(img, 0, 0, canvas.width,canvas.height);
					SELF.updateSizeInfo();
					SELF.image_target=canvas;
					if(!SELF.initializedApp)
						SELF.init();
					SELF.setChangesStateOn(true);
					SELF.applySettingsToImage();
					SELF.saveUnmodifiedImage(img);
					SELF.setHasImage(true);
					// enable crop button
					$('#slideThree').removeAttr("disabled");
					}
					};
					img.src = e.target.result;
				};
				reader.readAsDataURL(files[0]);
			}
		}
		SELF.overlayDrag = false;
		$('.avt-overlay-drag').remove();
    });
}
};
AvatarEffectsClass.prototype.loadRepository = function() {
	var repositoryImages = {};
	var dir = SELF.instalationDir+"img/repository/";
	for (i = 1; i <=81; i++)
	{
		$('.avt-repositorylist').prepend( '<div class="col-lg-3 col-sm-4 col-xs-6 avt-repositorylist-item"><div class="thumbnail"><img src="'+dir+i+'.jpg" class="img-responsive"></div></div>');
	}
};
AvatarEffectsClass.prototype.repositorySelectItem = function() {
	$('#modalurlinport-url').val($(this).find('img').get(0).src);
	SELF.modalRepository.modal('hide');
	SELF.importUrlImage();
};
AvatarEffectsClass.prototype.validExtension = function(file) {
        switch(file.type)
        {
			case "image/jpg": return true;
			case "image/jpeg": return true;
			case "image/png": return true;
			case "image/bmp": return true;
			case "image/gif": return true;
			default :return false;
		}
};
AvatarEffectsClass.prototype.getLocation = function(href) {
	var l = document.createElement("a");
	l.href = href;
	return l;
};
AvatarEffectsClass.prototype.cropOnOff = function () {
	var canvas = document.getElementById("canvas");
	if(SELF.hasImage == false)
		return;// no image to crop
	SELF.cropOn = !SELF.cropOn;
	if (SELF.cropOn == true) {
		//hide dropdown menu
		$('#avatareffectscontent').trigger("click");
		
		$('.avt-btn-crop').find('.cropstate').text(SELF.lang.on);
		$('.avt-btn-crop').find('.avt-btn-crop-id').css("background-color",
				"#7FFF00");
		$('.avt-btn-crop').css("background-color", "rgb(222, 60, 80)");
		$(".overlay,.overlay-content").css({
			"visibility" : "visible"
		});
	} else {
		$('.avt-btn-crop').find('.cropstate').text(SELF.lang.off);
		$('.avt-btn-crop').find('.avt-btn-crop-id').css("background-color",
				"#5F9EA0");
		$('.avt-btn-crop').css("background-color", "grey");
		$(".overlay,.overlay-content").css({
			"visibility" : "hidden"
		});
	}
};
AvatarEffectsClass.prototype.setPredefined = function() {
	if (SELF.predefinedWidth != 0 && SELF.predefinedHeight != 0) {
		SELF.resizeImage(SELF.predefinedWidth, SELF.predefinedHeight);
		SELF.setChangesStateOn(true);
		SELF.centerAvatar();
		SELF.applySettingsToImage();
		if (!SELF.haveChanges)
			return;
		SELF.setChangesStateOn(false);
	}
};
AvatarEffectsClass.prototype.setRangeResize = function() {
	SELF.resizeImage(SELF.manualResizeFactorWidth*($('.avt-rangeres-width').val()/100), SELF.manualResizeFactorHeight*($('.avt-rangeres-height').val()/100));
	SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.startResize = function(e) {
	e.preventDefault();
	e.stopPropagation();
	SELF.saveEventState(e);
	$(document).on('mousemove touchmove', SELF.resizing);
	$(document).on('mouseup touchend', SELF.endResize);
};
AvatarEffectsClass.prototype.endResize = function(e) {
	e.preventDefault();
	$(document).off('mouseup touchend', SELF.endResize);
	$(document).off('mousemove touchmove', SELF.resizing);
	if (SELF.haveChanges)
		return;
	SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.resizing = function(e) {
	SELF.offset = SELF.$container.offset();
	SELF.mouse.x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX)
			+ $(window).scrollLeft();
	SELF.mouse.y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY)
			+ $(window).scrollTop();
	if ($(SELF.event_state.evnt.target).hasClass('resize-handle-se')) {
		SELF.width = SELF.mouse.x - SELF.event_state.container_left;
		SELF.height = SELF.mouse.y - SELF.event_state.container_top;
		SELF.left = SELF.event_state.container_left;
		SELF.top = SELF.event_state.container_top;
	} else if ($(SELF.event_state.evnt.target).hasClass('resize-handle-sw')) {
		SELF.width = SELF.event_state.container_width
				- (SELF.mouse.x - SELF.event_state.container_left);
		SELF.height = SELF.mouse.y - SELF.event_state.container_top;
		SELF.left = SELF.mouse.x;
		SELF.top = SELF.event_state.container_top;

	} else if ($(SELF.event_state.evnt.target).hasClass('resize-handle-nw')) {
		SELF.width = SELF.event_state.container_width
				- (SELF.mouse.x - SELF.event_state.container_left);
		SELF.height = SELF.event_state.container_height
				- (SELF.mouse.y - SELF.event_state.container_top);
		SELF.left = SELF.mouse.x;
		SELF.top = SELF.mouse.y;
		if (SELF.constrain || e.shiftKey) {
			SELF.top = SELF.mouse.y
					- ((SELF.width / SELF.orig_src.width * SELF.orig_src.height) - SELF.height);
		}
	} else if ($(SELF.event_state.evnt.target).hasClass('resize-handle-ne')) {
		SELF.width = SELF.mouse.x - SELF.event_state.container_left;
		SELF.height = SELF.event_state.container_height
				- (SELF.mouse.y - SELF.event_state.container_top);
		SELF.left = SELF.event_state.container_left;
		SELF.top = SELF.mouse.y;
		if (SELF.constrain || e.shiftKey) {
			SELF.top = SELF.mouse.y
					- ((SELF.width / SELF.orig_src.width * SELF.orig_src.height) - SELF.height);
		}
	}
	if (SELF.constrain || e.shiftKey) {
		SELF.height = SELF.width / SELF.orig_src.width * SELF.orig_src.height;
	}
	if (SELF.width > 0 && SELF.height > 0) {
		SELF.resizeImage(SELF.width, SELF.height);
		SELF.$container.offset({
			'left' : SELF.left,
			'top' : SELF.top
		});
	}
};
AvatarEffectsClass.prototype.resizeImage = function(width, height) {
	width = Math.ceil(width);
	height = Math.ceil(height);
	SELF.resize_canvas.width = width;
	SELF.resize_canvas.height = height;
	SELF.resize_canvas.getContext('2d').drawImage(SELF.orig_src, 0, 0, width, height);
	SELF.image_target.width = width;
	SELF.image_target.height = height;
	SELF.image_target.getContext('2d').drawImage(SELF.resize_canvas, 0, 0);
	if (!SELF.avatarsizeShow)
		$('.avatarsize').show(100);
	SELF.updateSizeInfo();
};
AvatarEffectsClass.prototype.saveEventState = function(e) {
	SELF.event_state.container_width = SELF.$container.width();
	SELF.event_state.container_height = SELF.$container.height();
	SELF.event_state.container_left = SELF.$container.offset().left;
	SELF.event_state.container_top = SELF.$container.offset().top;
	SELF.event_state.mouse_x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX)
			+ $(window).scrollLeft();
	SELF.event_state.mouse_y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY)
			+ $(window).scrollTop();
	if (typeof e.originalEvent.touches !== 'undefined') {
		SELF.event_state.touches = [];
		$.each(e.originalEvent.touches, function(i, ob) {
			SELF.event_state.touches[i] = {};
			SELF.event_state.touches[i].clientX = 0 + ob.clientX;
			SELF.event_state.touches[i].clientY = 0 + ob.clientY;
		});
	}
	SELF.event_state.evnt = e;
};
AvatarEffectsClass.prototype.startMoving = function(e) {
	e.preventDefault();
	e.stopPropagation();
	SELF.saveEventState(e);
	$(document).on('mousemove touchmove', SELF.moving);
	$(document).on('mouseup touchend', SELF.endMoving);
};
AvatarEffectsClass.prototype.endMoving = function(e) {
	e.preventDefault();
	$(document).off('mouseup touchend', SELF.endMoving);
	$(document).off('mousemove touchmove', SELF.moving);
};
AvatarEffectsClass.prototype.moving = function(e) {
	e.preventDefault();
	e.stopPropagation();
	SELF.touches = e.originalEvent.touches;
	SELF.mouse.x = (e.clientX || e.pageX || SELF.touches[0].clientX)
			+ $(window).scrollLeft();
	SELF.mouse.y = (e.clientY || e.pageY || SELF.touches[0].clientY)
			+ $(window).scrollTop();
	SELF.$container.offset({
		'left' : SELF.mouse.x
				- (SELF.event_state.mouse_x - SELF.event_state.container_left),
		'top' : SELF.mouse.y - (SELF.event_state.mouse_y - SELF.event_state.container_top)
	});
	if (SELF.event_state.touches && SELF.event_state.touches.length > 1
			&& SELF.touches.length > 1) {
		var width = SELF.event_state.container_width, height = SELF.event_state.container_height;
		var a = SELF.event_state.touches[0].clientX
				- SELF.event_state.touches[1].clientX;
		a = a * a;
		var b = SELF.event_state.touches[0].clientY
				- SELF.event_state.touches[1].clientY;
		b = b * b;
		var dist1 = Math.sqrt(a + b);
		a = e.originalEvent.touches[0].clientX - SELF.touches[1].clientX;
		a = a * a;
		b = e.originalEvent.touches[0].clientY - SELF.touches[1].clientY;
		b = b * b;
		var dist2 = Math.sqrt(a + b);
		var ratio = dist2 / dist1;
		width = width * ratio;
		height = height * ratio;
		SELF.resizeImage(width, height);
		SELF.setChangesStateOn(true);
	}
};
AvatarEffectsClass.prototype.crop = function() {
	// Find the part of the image that is inside the crop box
	var crop_canvas, left = $('.overlay').offset().left
			- SELF.$container.offset().left, top = $('.overlay').offset().top
			- SELF.$container.offset().top, width = $('.overlay').width(), height = $(
			'.overlay').height();

	crop_canvas = document.createElement('canvas');
	crop_canvas.width = width;
	crop_canvas.height = height;

	crop_canvas.getContext('2d').drawImage(SELF.image_target, left, top, width,
			height, 0, 0, width, height);

	SELF.orig_src.src = crop_canvas.toDataURL("image/png");// change the
	// original image
	SELF.image_target.width = width;
	SELF.image_target.height = height;
	SELF.image_target.getContext('2d').drawImage(crop_canvas, 0, 0);
	SELF.cropOnOff();
	if (SELF.haveChanges)
		return;
	SELF.setChangesStateOn(true);
	SELF.updateSizeInfo();
	SELF.applySettingsToImage();
};
AvatarEffectsClass.prototype.applySettingsToImage = function() {
	if (!SELF.haveChanges)
		return;
	SELF.orig_src.src = SELF.image_target.toDataURL("image/png");
	SELF.manualResizeFactorWidth = SELF.orig_src.width;
	SELF.manualResizeFactorHeight = SELF.orig_src.height;
	$('.avt-rangeres-width, .avt-rangeres-height').val(100);
	SELF.setChangesStateOn(false);
};
AvatarEffectsClass.prototype.saveUnmodifiedImage = function(img) {
	SELF.unmodifiedImage.width = img.width;
	SELF.unmodifiedImage.height = img.height;
	SELF.unmodifiedImage.getContext("2d").drawImage(img, 0, 0, img.width,img.height);
};
AvatarEffectsClass.prototype.recoverUnmodifiedImage = function() {
	SELF.orig_src.src = SELF.unmodifiedImage.toDataURL("image/png");
	if (SELF.keepProportional == true) {
			var dim = SELF.getProportionalDimensions(SELF.orig_src.width,SELF.orig_src.height);
			SELF.image_target.width = dim['w'];
			SELF.image_target.height = dim['h'];
		} else {
			SELF.image_target.width	= SELF.orig_src.width;
			SELF.image_target.height = SELF.orig_src.height;
		}
	SELF.image_target.getContext('2d').drawImage(SELF.unmodifiedImage, 0, 0, SELF.image_target.width, SELF.image_target.height);
	SELF.setChangesStateOn(false);
	SELF.updateSizeInfo();
	SELF.centerAvatar();
	SELF.manualResizeFactorWidth = SELF.image_target.width;
	SELF.manualResizeFactorHeight = SELF.image_target.height;
	$('.avt-rangeres-width, .avt-rangeres-height').val(100);
};
AvatarEffectsClass.prototype.deleteUnsavedChanges = function() {
	SELF.image_target.width	= SELF.orig_src.width;
	SELF.image_target.height = SELF.orig_src.height;
	
	SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0, SELF.image_target.width, SELF.image_target.height);
	SELF.setChangesStateOn(false);
	SELF.updateSizeInfo();
	SELF.centerAvatar();
};
AvatarEffectsClass.prototype.setChangesStateOn = function(value) {
	SELF.haveChanges = value;
	if (!SELF.haveChanges) {
		$(".applychangesid").css('background', '#909090');
		$(".applychangesinfo").each(function() {
			$(this).text(SELF.lang.nochanges);
		});
		$(".avt-btn-apply").css('background', '#009900');
		$(".avt-btn-apply").removeClass("glyphicon-warning-sign");
		$(".avt-btn-apply").addClass("glyphicon-floppy-saved");
		$(".avt-btn-apply").attr('data-original-title', SELF.lang.nochangesapply);
	} else {
		$(".applychangesid").css('background', '#00FF00');
		$(".applychangesinfo").each(function() {
			$(this).text(SELF.lang.applychanges);
		});
		$(".avt-btn-apply").css('background', 'rgba(222,60,80,.9)');
		$(".avt-btn-apply").removeClass("glyphicon-floppy-saved");
		$(".avt-btn-apply").addClass("glyphicon-warning-sign");
		$(".avt-btn-apply").attr('data-original-title', SELF.lang.unsavedchanges);
	}
};
AvatarEffectsClass.prototype.centerAvatar = function() {
	SELF.$container.offset({
		'left' : (($('#avatareffectscontent').width() / 2 - SELF.$container.width() / 2)+$(window).scrollLeft()),
		'top' : (($(window).scrollTop()+$(window).height()/2)-SELF.$container.width() / 2)
	});
}
AvatarEffectsClass.prototype.leftAvatar = function() {
	SELF.$container.offset({
		'left' : 10+$(window).scrollLeft(),
		'top' : (($(window).scrollTop()+$(window).height()/2)-SELF.$container.width() / 2)
	});
}
AvatarEffectsClass.prototype.rightAvatar = function() {
	SELF.$container.offset({
		'left' : ($('#avatareffectscontent').width()+$(window).scrollLeft() - SELF.$container.width()) - 10,
		'top' : (($(window).scrollTop()+$(window).height()/2)-SELF.$container.width() / 2)
	});
}
AvatarEffectsClass.prototype.avatarcropWidth = function() {
	$('.overlay, .overlay-content').css("margin-left",
			($('.avatarcropwidth').val() / 2) * -1);
	$('.overlay, .overlay-content').css("width",
			$('.avatarcropwidth').val());
};
AvatarEffectsClass.prototype.avatarcropHeight = function() {
	$('.overlay, .overlay-content').css("margin-top",
			($('.avatarcropheight').val() / 2) * -1);
	$('.overlay, .overlay-content').css("height",
			$('.avatarcropheight').val());
};
AvatarEffectsClass.prototype.updateSizeInfo = function() {
	if($('#canvas').length)
		$('#avatarsizecontent').text($('#canvas').get(0).width + 'px x ' + $('#canvas').get(0).height + 'px');
	else
		$('#avatarsizecontent').text('000px x 000px');
};
AvatarEffectsClass.prototype.setDefaultEffectValue = function(opt) {
		switch (opt) {
		case 'Sharpen':
			$('.rangesharpen').val(6);
			break;
		case 'Pixelate':
			$('.rangepixelate').val(15);
			break;
		case 'Threshold':
			$('.rangethreshold').val(128);
			break;
		case 'Blur':
			$('.rangeblur').val(1);
			break;
		}
};
AvatarEffectsClass.prototype.showModalDialog = function(title, content) {
		$('#modalAlert').find('#modalalert-title').text(title);
		$('#modalAlert').find('#modalalert-msg').text(content);
		SELF.modalAlert.modal('show');
};
// EFFECTS
AvatarEffectsClass.prototype.hue = function(keep,amount) {
		if (SELF.image_target === undefined || SELF.image_target === null)
			return;// no image
		if (typeof amount === 'object' || typeof amount === 'undefined')
		amount = $('.btnhue').val();
		if (typeof keep === 'object' || typeof keep === 'undefined' || keep == false)
			SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,$('.resize-image').width(), $('.resize-image').height());		
		var angle = parseInt(amount, 10), idata = SELF.image_target.getContext('2d')
				.getImageData(0, 0, $('.resize-image').width(), $(
						'.resize-image').height()), data = idata.data, len = data.length, i = 0;
		for (; i < len; i += 4) {
			var lum = data[i] / 255;
			col = SELF.hslToRgbConverter(angle, 1, lum);
			data[i] = col.r;
			data[i + 1] = col.g;
			data[i + 2] = col.b;
		}
		SELF.image_target.getContext('2d').putImageData(idata, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.hslToRgbConverter = function(h, s, l) {
		var r, g, b, q, p;
		h /= 360;
		if (s == 0) {
			r = g = b = l;
		} else {
			function hue2rgb(p, q, t) {
				if (t < 0)
					t++;
				if (t > 1)
					t--;
				if (t < 1 / 6)
					return p + (q - p) * 6 * t;
				if (t < 1 / 2)
					return q;
				if (t < 2 / 3)
					return p + (q - p) * (2 / 3 - t) * 6;
				return p;
			}
			q = l < 0.5 ? l * (1 + s) : l + s - l * s;
			p = 2 * l - q;
			r = hue2rgb(p, q, h + 1 / 3);
			g = hue2rgb(p, q, h);
			b = hue2rgb(p, q, h - 1 / 3);
		}
		return {
			r : r * 255,
			g : g * 255,
			b : b * 255
		};
};
AvatarEffectsClass.prototype.setBrightness = function(keep,amount) {
	if (typeof keep === 'object' || typeof keep === 'undefined' || keep == false)
		SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
				$('.resize-image').width(), $('.resize-image').height());
		if (typeof amount === 'object' || typeof amount === 'undefined')
			amount = parseInt($('.btnbrightness').val(), 10);
		var ctx = SELF.image_target.getContext("2d");

		// no change, just exit
		if (amount === 0)
			return;
			
		

		var imgData = ctx.getImageData(0, 0, SELF.image_target.width,
				SELF.image_target.height);
		var data = imgData.data;

		for (var i = 0; i < data.length; i += 4) {
			data[i] += amount;
			data[i + 1] += amount;
			data[i + 2] += amount
		}

		imgData.data = data;
		ctx.putImageData(imgData, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setContrast = function(keep,amount) {
	if (typeof keep === 'object' || typeof keep === 'undefined' || keep == false)
		SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
				$('.resize-image').width(), $('.resize-image').height());
		if (typeof amount === 'object' || typeof amount === 'undefined')
			amount = $('.btncontrast').val() / 100;
		var ctx = SELF.image_target.getContext("2d");

		// no change, just exit
		if (amount === 0)
			return;

		var imgData = ctx.getImageData(0, 0, SELF.image_target.width,
				SELF.image_target.height);
		var d = imgData.data;

		for (var i = 0; i < d.length; i += 4) {
			d[i] = ((((d[i] / 255) - 0.5) * amount) + 0.5) * 255;
			d[i + 1] = ((((d[i + 1] / 255) - 0.5) * amount) + 0.5) * 255;
			d[i + 2] = ((((d[i + 2] / 255) - 0.5) * amount) + 0.5) * 255;
		}
		imgData.data = d;
		ctx.putImageData(imgData, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setAuto = function() {
		SELF.setContrast(false,1.15);
		SELF.setBrightness(true,20);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setVivid = function() {
		SELF.setColorRed(false,2);
		SELF.setColorGreen(true,2);
		SELF.setColorBlue(true,2);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setVestige = function() {
		SELF.setGrayscale();
		SELF.setBlur(2);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setSolar = function() {
		SELF.hue(false,25);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setFabric = function() {
		SELF.setContrast(false,2);
		SELF.setSharpen(true,6);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setDark = function() {
		SELF.setBrightness(false,-200);
		SELF.hue(true,179);
		SELF.setColorRed(true,2);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setLight = function() {
		SELF.setSepia();
		SELF.setColorRed(true,2);
		SELF.setColorGreen(true,2);
		SELF.setColorBlue(true,2);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setArchaic2 = function() {
		SELF.setSharpen(false,40);
		SELF.setBlur(2);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setGround = function() {
		SELF.setSepia();
		SELF.setColorRed(true,1.5);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setPure = function() {
		SELF.setSharpen(false,40);
		SELF.setBrightness(true,200);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setDraw2 = function() {
		SELF.setSharpen(false,40);
		SELF.setThreshold(true,128);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setDraw3 = function() {
		SELF.setSharpen(false,40);
		SELF.setGrayscale(true);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setDraw4 = function() {
		SELF.setGrayscale();
		SELF.setSharpen(true,4);
		SELF.setColorRed(true,2);
		SELF.setColorGreen(true,2);
		SELF.setColorBlue(true,2);
		SELF.setBrightness(true,160);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setSpirit = function() {
		SELF.setGrayscale();
		SELF.setColorRed(true,2);
		SELF.setColorGreen(true,2);
		SELF.setColorBlue(true,2);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setGrayscale = function(keep) {
		if (typeof keep === 'object' || typeof keep === 'undefined')
			SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
					$('.resize-image').width(), $('.resize-image').height());
		var ctx = SELF.image_target.getContext("2d");


		var imgData = ctx.getImageData(0, 0, SELF.image_target.width,
				SELF.image_target.height);
		var data = imgData.data;

		for (var i = 0; i < data.length; i += 4) {
			var r = data[i];
			var g = data[i + 1];
			var b = data[i + 2];
			data[i] = data[i + 1] = data[i + 2] = (r + g + b) / 3;
		}
		imgData.data = data;
		ctx.putImageData(imgData, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setSepia = function() {
		SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
				$('.resize-image').width(), $('.resize-image').height());
		var ctx = SELF.image_target.getContext("2d");
		var imgData = ctx.getImageData(0, 0, SELF.image_target.width,
				SELF.image_target.height);
		var d = imgData.data;

		for (var i = 0; i < d.length; i += 4) {
			var r = d[i];
			var g = d[i + 1];
			var b = d[i + 2];
			d[i] = (r * 0.393) + (g * 0.769) + (b * 0.189); // red
			d[i + 1] = (r * 0.349) + (g * 0.686) + (b * 0.168); // green
			d[i + 2] = (r * 0.272) + (g * 0.534) + (b * 0.131); // blue
		}
		imgData.data = d;
		ctx.putImageData(imgData, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setRed = function() {
		SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
				$('.resize-image').width(), $('.resize-image').height());
		var ctx = SELF.image_target.getContext("2d");
		var imgData = ctx.getImageData(0, 0, SELF.image_target.width,
				SELF.image_target.height);
		var d = imgData.data;

		for (var i = 0; i < d.length; i += 4) {
			var r = d[i];
			var g = d[i + 1];
			var b = d[i + 2];
			d[i] = (r + g + b) / 3; // apply average to red channel
			d[i + 1] = d[i + 2] = 0; // zero out green and blue channel
		}
		imgData.data = d;
		ctx.putImageData(imgData, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setInvertColors = function() {
		SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
				$('.resize-image').width(), $('.resize-image').height());
		var ctx = SELF.image_target.getContext("2d");
		var imgData = ctx.getImageData(0, 0, SELF.image_target.width,
				SELF.image_target.height);
		var d = imgData.data;

		for (var i = 0; i < d.length; i += 4) {
			d[i] = 255 - d[i];
			d[i + 1] = 255 - d[i + 1];
			d[i + 2] = 255 - d[i + 2];
		}
		imgData.data = d;
		ctx.putImageData(imgData, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setColorRed = function(keep,amount) {
	if (typeof keep === 'object' || typeof keep === 'undefined' || keep == false)
		SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
				$('.resize-image').width(), $('.resize-image').height());
		if (typeof amount === 'object' || typeof amount === 'undefined')
			amount = $('.btncolorR').val() / 100;
		var ctx = SELF.image_target.getContext("2d");
		// no change, just exit
		if (amount === 0)
			return;

		var imgData = ctx.getImageData(0, 0, SELF.image_target.width,
				SELF.image_target.height);
		var d = imgData.data;

		for (var i = 0; i < d.length; i += 4) {
			d[i] *= amount;
		}

		imgData.data = d;
		ctx.putImageData(imgData, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setColorGreen = function(keep,amount) {
	if (typeof keep === 'object' || typeof keep === 'undefined' || keep == false)
		SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
				$('.resize-image').width(), $('.resize-image').height());
		if (typeof amount === 'object' || typeof amount === 'undefined')
		  amount = $('.btncolorG').val() / 100;
		var ctx = SELF.image_target.getContext("2d");
		// no change, just exit
		if (amount === 0)
			return;

		var imgData = ctx.getImageData(0, 0, SELF.image_target.width,
				SELF.image_target.height);
		var d = imgData.data;

		for (var i = 0; i < d.length; i += 4) {
			d[i + 1] *= amount;
		}

		imgData.data = d;
		ctx.putImageData(imgData, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setColorBlue = function(keep,amount) {
	if (typeof keep === 'object' || typeof keep === 'undefined' || keep == false)
		SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
				$('.resize-image').width(), $('.resize-image').height());
		if (typeof amount === 'object' || typeof amount === 'undefined')   
		   amount = $('.btncolorB').val() / 100;
		var ctx = SELF.image_target.getContext("2d");
		// no change, just exit
		if (amount === 0)
			return;

		var imgData = ctx.getImageData(0, 0, SELF.image_target.width,
				SELF.image_target.height);
		var d = imgData.data;

		for (var i = 0; i < d.length; i += 4) {
			d[i + 2] *= amount;
		}

		imgData.data = d;
		ctx.putImageData(imgData, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setThreshold = function(keep,amount) {
	if (typeof keep === 'object' || typeof keep === 'undefined' || keep == false)
		SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
				$('.resize-image').width(), $('.resize-image').height());
		var ctx = SELF.image_target.getContext("2d");
		var imgData = ctx.getImageData(0, 0, SELF.image_target.width,
				SELF.image_target.height);
		var d = imgData.data;
		if (typeof amount === 'object' || typeof amount === 'undefined')   
			amount = $('.rangethreshold').val();
		for (var i = 0; i < d.length; i += 4) {
			var r = d[i];
			var g = d[i + 1];
			var b = d[i + 2];
			var v = (0.2126 * r + 0.7152 * g + 0.0722 * b >= amount) ? 255 : 0;
			d[i] = d[i + 1] = d[i + 2] = v;
		}
		imgData.data = d;
		ctx.putImageData(imgData, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setBlur = function(keep, amount) {
		if (typeof keep === 'object' || typeof keep === 'undefined')
			SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
					$('.resize-image').width(), $('.resize-image').height());
		var ctx = SELF.image_target.getContext("2d"), w = SELF.image_target.width, h = SELF.image_target.height;
        
        if (typeof amount === 'object' || typeof amount === 'undefined')   
		amount = $('.rangeblur').val();

		imgd = ctx.getImageData(0, 0, w, h);
		imgd = SELF.blur(imgd, amount);
		ctx.putImageData(imgd, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.blur = function(img, passes) {
		var i, j, k, n, w = img.width, h = img.height, im = img.data, rounds = passes || 0, pos = step = jump = inner = outer = arr = 0;
		for (n = 0; n < rounds; n++) {
			for (var m = 0; m < 2; m++) {
				if (m) {
					outer = w;
					inner = h;
					step = w * 4;
				} else {
					outer = h;
					inner = w;
					step = 4;
				}
				for (i = 0; i < outer; i++) {
					jump = m === 0 ? i * w * 4 : 4 * i;
					for (k = 0; k < 3; k++) {
						pos = jump + k;
						arr = 0;
						arr = im[pos] + im[pos + step] + im[pos + step * 2];
						im[pos] = Math.floor(arr / 3);
						arr += im[pos + step * 3];
						im[pos + step] = Math.floor(arr / 4);
						arr += im[pos + step * 4];
						im[pos + step * 2] = Math.floor(arr / 5);
						for (j = 3; j < inner - 2; j++) {
							arr = Math.max(0, arr - im[pos + (j - 2) * step]
									+ im[pos + (j + 2) * step]);
							im[pos + j * step] = Math.floor(arr / 5);
						}
						arr -= im[pos + (j - 2) * step];
						im[pos + j * step] = Math.floor(arr / 4);
						arr -= im[pos + (j - 1) * step];
						im[pos + (j + 1) * step] = Math.floor(arr / 3);
					}
				}
			}
		}
		return img;
};
AvatarEffectsClass.prototype.flipX = function() {
		var ctx = SELF.image_target.getContext('2d');
		var w = SELF.image_target.width;
		var h = SELF.image_target.height;
		ctx.save();
		ctx.scale(-1, 1);
		ctx.drawImage(SELF.image_target, w * -1, 0, w, h);
		ctx.restore();
		SELF.setChangesStateOn(true);
		SELF.applySettingsToImage();
};
AvatarEffectsClass.prototype.flipY = function() {
		var ctx = SELF.image_target.getContext('2d');
		var w = SELF.image_target.width;
		var h = SELF.image_target.height;
		ctx.save();
		ctx.scale(1, -1);
		ctx.drawImage(SELF.image_target, 0, h * -1, w, h);
		ctx.restore();
		SELF.setChangesStateOn(true);
		SELF.applySettingsToImage();
};
AvatarEffectsClass.prototype.invertDimensions = function() {
		//invert image dimensions
		SELF.resizeImage(SELF.image_target.height,SELF.image_target.width);
		SELF.setChangesStateOn(true);
		SELF.applySettingsToImage();
};
AvatarEffectsClass.prototype.setOilPaint = function() {
		SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
				$('.resize-image').width(), $('.resize-image').height());
		var canvas = SELF.image_target, width = canvas.width, height = canvas.height, imgData = canvas
				.getContext("2d").getImageData(0, 0, width, height), pixData = imgData.data, destCanvas = SELF.image_target, dCtx = destCanvas
				.getContext("2d"), pixelIntensityCount = [], radius = 4, intensity = 55;
		destCanvas.width = width;
		destCanvas.height = height;
		var destImageData = dCtx.createImageData(width, height), destPixData = destImageData.data, intensityLUT = [], rgbLUT = [];
		for (var y = 0; y < height; y++) {
			intensityLUT[y] = [];
			rgbLUT[y] = [];
			for (var x = 0; x < width; x++) {
				var idx = (y * width + x) * 4, r = pixData[idx], g = pixData[idx + 1], b = pixData[idx + 2], avg = (r
						+ g + b) / 3;
				intensityLUT[y][x] = Math.round((avg * intensity) / 255);
				rgbLUT[y][x] = {
					r : r,
					g : g,
					b : b
				};
			}
		}
		for (y = 0; y < height; y++) {
			for (x = 0; x < width; x++) {
				pixelIntensityCount = [];
				for (var yy = -radius; yy <= radius; yy++) {
					for (var xx = -radius; xx <= radius; xx++) {
						if (y + yy > 0 && y + yy < height && x + xx > 0
								&& x + xx < width) {
							var intensityVal = intensityLUT[y + yy][x + xx];

							if (!pixelIntensityCount[intensityVal]) {
								pixelIntensityCount[intensityVal] = {
									val : 1,
									r : rgbLUT[y + yy][x + xx].r,
									g : rgbLUT[y + yy][x + xx].g,
									b : rgbLUT[y + yy][x + xx].b
								}
							} else {
								pixelIntensityCount[intensityVal].val++;
								pixelIntensityCount[intensityVal].r += rgbLUT[y
										+ yy][x + xx].r;
								pixelIntensityCount[intensityVal].g += rgbLUT[y
										+ yy][x + xx].g;
								pixelIntensityCount[intensityVal].b += rgbLUT[y
										+ yy][x + xx].b;
							}
						}
					}
				}
				pixelIntensityCount.sort(function(a, b) {
					return b.val - a.val;
				});
				var curMax = pixelIntensityCount[0].val, dIdx = (y * width + x) * 4;
				destPixData[dIdx] = ~~(pixelIntensityCount[0].r / curMax);
				destPixData[dIdx + 1] = ~~(pixelIntensityCount[0].g / curMax);
				destPixData[dIdx + 2] = ~~(pixelIntensityCount[0].b / curMax);
				destPixData[dIdx + 3] = 255;
			}
		}
		dCtx.putImageData(destImageData, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setPixelate = function() {
		SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
				$('.resize-image').width(), $('.resize-image').height());
		var ctx = SELF.image_target.getContext('2d'), size = $('.rangepixelate')
				.val() * 0.01, w = SELF.image_target.width * size, h = SELF.image_target.height
				* size;
		ctx.mozImageSmoothingEnabled = false;
		ctx.webkitImageSmoothingEnabled = false;
		ctx.imageSmoothingEnabled = false;
		ctx.drawImage(canvas, 0, 0, w, h);
		ctx.drawImage(canvas, 0, 0, w, h, 0, 0, $('.resize-image').width(), $('.resize-image').height());
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setDraw = function() {
		SELF.setGrayscale();
		SELF.setSharpen(true,4);
		SELF.setColorRed(true,2);
		SELF.setColorGreen(true,2);
		SELF.setColorBlue(true,2);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setArchaic = function() {
		SELF.setSharpen();
		SELF.setGrayscale(true);
		SELF.setBlur(true);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.setSharpen = function(keep,amount) {
		if (typeof keep === 'object' || typeof keep === 'undefined' || keep == false)
			SELF.image_target.getContext('2d').drawImage(SELF.orig_src, 0, 0,
					$('.resize-image').width(), $('.resize-image').height());
		if (typeof amount === 'object' || typeof amount === 'undefined')
			amount = $('.rangesharpen').val();
		var ctx = SELF.image_target.getContext('2d'), w = $('.resize-image').width(), h = $('.resize-image').height(), mix = amount, weights = [ 0, -1, 0, -1, 5, -1, 0, -1,
				0 ], katet = Math.round(Math.sqrt(weights.length)), half = (katet * 0.5) | 0, dstData = ctx
				.createImageData(w, h), dstBuff = dstData.data, srcBuff = ctx
				.getImageData(0, 0, w, h).data, y = h;
		while (y--) {
			x = w;
			while (x--) {
				var sy = y, sx = x, dstOff = (y * w + x) * 4, r = 0, g = 0, b = 0, a = 0;
				for (var cy = 0; cy < katet; cy++) {
					for (var cx = 0; cx < katet; cx++) {
						var scy = sy + cy - half;
						var scx = sx + cx - half;
						if (scy >= 0 && scy < h && scx >= 0 && scx < w) {
							var srcOff = (scy * w + scx) * 4;
							var wt = weights[cy * katet + cx];
							r += srcBuff[srcOff] * wt;
							g += srcBuff[srcOff + 1] * wt;
							b += srcBuff[srcOff + 2] * wt;
							a += srcBuff[srcOff + 3] * wt;
						}
					}
				}
				dstBuff[dstOff] = r * mix + srcBuff[dstOff] * (1 - mix);
				dstBuff[dstOff + 1] = g * mix + srcBuff[dstOff + 1] * (1 - mix);
				dstBuff[dstOff + 2] = b * mix + srcBuff[dstOff + 2] * (1 - mix)
				dstBuff[dstOff + 3] = srcBuff[dstOff + 3];
			}
		}
		ctx.putImageData(dstData, 0, 0);
		if (SELF.haveChanges)
			return;
		SELF.setChangesStateOn(true);
};
AvatarEffectsClass.prototype.saveValidations = function() {
		if(SELF.hasImage == false)
		{
			SELF.showModalDialog(SELF.lang.error, SELF.lang.noimage);
			return false;
		}
		if (SELF.forceSize == 'true') {
			if (SELF.orig_src.width != SELF.predefinedWidth
					|| SELF.orig_src.height != SELF.predefinedHeight) {
				SELF.showModalDialog(
						SELF.lang.error,
						SELF.lang.avatardimensions+ " "
								+ SELF.predefinedWidth
								+ "px x "
								+ SELF.predefinedHeight
								+ "px. "+SELF.lang.hint);
				return false;
			}
		}
		if(SELF.min_width > SELF.orig_src.width || SELF.min_height > SELF.orig_src.height)
		{
			var limitMinMsg = "";
			if(SELF.min_width > SELF.orig_src.width)
				limitMinMsg+= " "+SELF.lang.width+" "+SELF.min_width+"px";
			if(SELF.min_height > SELF.orig_src.height)
				limitMinMsg+= " "+SELF.lang.height+" "+SELF.min_height+"px";
			SELF.showModalDialog(SELF.lang.error,SELF.lang.limitMinWarning+limitMinMsg+".");
			return false;
		}
		if((SELF.max_width > 0 && SELF.max_width < SELF.orig_src.width) || (SELF.max_height > 0 && SELF.max_height < SELF.orig_src.height))
		{
			var limitMaxMsg = "";
			if(SELF.max_width < SELF.orig_src.width)
				limitMaxMsg+= " "+SELF.lang.width+" "+SELF.max_width+"px";
			if(SELF.max_height < SELF.orig_src.height)
				limitMaxMsg+= " "+SELF.lang.height+" "+SELF.max_height+"px";
			SELF.showModalDialog(SELF.lang.error,SELF.lang.limitMaxWarning+limitMaxMsg+".");
			return false;
		}
		return true;
}
AvatarEffectsClass.prototype.finishEdit = function() {
	if (SELF.cropOn == true)
		SELF.cropOnOff();
	if (SELF.destination !== null)
	{
		if(SELF.saveValidations() == false)
			return;
		if(SELF.haveChanges)
	  {
		  SELF.applySettingsToImage();
	  }
		$('.'+SELF.destination).each(function() {//change all destinations
			$(this).attr("src", SELF.orig_src.src);
		});
		SELF.modalMainApp.modal('hide');
		return;
	}
};
//COOKIES
var docCookies = {
  getItem: function (sKey) {
    if (!sKey) { return null; }
    return decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null;
  },
  setItem: function (sKey, sValue, vEnd, sPath, sDomain, bSecure) {
    if (!sKey || /^(?:expires|max\-age|path|domain|secure)$/i.test(sKey)) { return false; }
    var sExpires = "";
    if (vEnd) {
      switch (vEnd.constructor) {
        case Number:
          sExpires = vEnd === Infinity ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT" : "; max-age=" + vEnd;
          break;
        case String:
          sExpires = "; expires=" + vEnd;
          break;
        case Date:
          sExpires = "; expires=" + vEnd.toUTCString();
          break;
      }
    }
    document.cookie = encodeURIComponent(sKey) + "=" + encodeURIComponent(sValue) + sExpires + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "") + (bSecure ? "; secure" : "");
    return true;
  },
  removeItem: function (sKey, sPath, sDomain) {
    if (!this.hasItem(sKey)) { return false; }
    document.cookie = encodeURIComponent(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "");
    return true;
  },
  hasItem: function (sKey) {
    if (!sKey) { return false; }
    return (new RegExp("(?:^|;\\s*)" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
  },
  keys: function () {
    var aKeys = document.cookie.replace(/((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g, "").split(/\s*(?:\=[^;]*)?;\s*/);
    for (var nLen = aKeys.length, nIdx = 0; nIdx < nLen; nIdx++) { aKeys[nIdx] = decodeURIComponent(aKeys[nIdx]); }
    return aKeys;
  }
};

$(document).ready(function() {
    //create the APP
	var avatarApp = new AvatarEffectsClass();
});
