var croppicContaineroutputOptions = {
    uploadUrl: '../../scripts/img_save_to_file.php',
    cropUrl: '../../scripts/img_crop_to_file.php',
    outputUrlId: 'cropOutput',
    modal: false,
    rotateControls: false,
    doubleZoomControls: false,
    //enableMousescroll: true,
    loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
}

var cropContaineroutput = new Croppic('cropContaineroutput', croppicContaineroutputOptions);