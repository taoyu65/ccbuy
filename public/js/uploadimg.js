// common variables
var iBytesUploaded = 0;
var iBytesTotal = 0;
var iPreviousBytesLoaded = 0;
var iMaxFilesize = 1048576; // 1MB
var oTimer = 0;
var sResultFileSize = '';
var isRightImg = 0;	//确保是图片文件 在函数fileSelected() 里面来判断
function secondsToTime(secs) { // we will use this function to convert seconds in normal time format
    var hr = Math.floor(secs / 3600);
    var min = Math.floor((secs - (hr * 3600))/60);
    var sec = Math.floor(secs - (hr * 3600) -  (min * 60));

    if (hr < 10) {hr = "0" + hr; }
    if (min < 10) {min = "0" + min;}
    if (sec < 10) {sec = "0" + sec;}
    if (hr) {hr = "00";}
    return hr + ':' + min + ':' + sec;
};

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
};

function deleteImg()
{
	var imgName = document.getElementById('image_file').value;
	if(imgName == ''  || isRightImg == 0)
	{
		showMessage('warning', '还没有选择图片 怎么删除');
		return;
	}
	var preshowimg = document.getElementById('preshowimg').src;
	if(preshowimg != '')
	{
		document.getElementById('preshowimg').style.display = 'none';
		document.getElementById('preshowimg').src = '';
		document.getElementById('selectimg').style.display = 'block';
		document.getElementById('image_file').value = '';
		showMessage('success', '删除图片成功');
	}
}

function fileSelected() {
	isRightImg = 0;
    // hide different warnings
   // document.getElementById('upload_response').style.display = 'none';
    //document.getElementById('error').style.display = 'none';
    //document.getElementById('error2').style.display = 'none';
    //document.getElementById('abort').style.display = 'none';
   // document.getElementById('warnsize').style.display = 'none';

    // get selected file element
    var oFile = document.getElementById('image_file').files[0];

    // filter for image files
    var rFilter = /^(image\/bmp|image\/gif|image\/jpeg|image\/png|image\/tiff)$/i;
    if (! rFilter.test(oFile.type)) {
        //document.getElementById('error').style.display = 'block';
		//$().toastmessage('showErrorToast','请选择图片文件');
		showMessage('error','请选择图片文件');
        return;
    }

    // little test for filesize
    if (oFile.size > iMaxFilesize) {
		//document.getElementById('warnsize').style.display = 'block';
		showMessage('warning','图片过大');
        return;
    }
	isRightImg = 1;
    // get preview element
    //var oImage = document.getElementById('preview');

    // prepare HTML5 FileReader
	if (typeof (FileReader) != "undefined") {
    var oReader = new FileReader();
        oReader.onload = function(e){

        // e.target.result contains the DataURL which we will use as a source of the image
        //oImage.src = e.target.result;

        //oImage.onload = function () { // binding onload event

            // we are going to display some custom image information here
			document.getElementById('selectimg').style.display = 'none';
			document.getElementById('preshowimg').style.display = 'block';
			document.getElementById('preshowimg').src = e.target.result;
			
			
            //sResultFileSize = bytesToSize(oFile.size);
            //document.getElementById('fileinfo').style.display = 'block';
            //document.getElementById('filename').innerHTML = 'Name: ' + oFile.name;
            //document.getElementById('filesize').innerHTML = 'Size: ' + sResultFileSize;
            //document.getElementById('filetype').innerHTML = 'Type: ' + oFile.type;
            //document.getElementById('filedim').innerHTML = 'Dimension: ' + oImage.naturalWidth + ' x ' + oImage.naturalHeight;
        //};
    };
	}
	else
	{
		alert("你的浏览器不支持FileReader接口。无法看到图片预览");
		}
    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
}

function startUploading() {
	var imgName = document.getElementById('image_file').value;
	if (imgName == '')
	{
		showMessage('warning','你还没有选择一个图片');
		return;
	}
	if(isRightImg != 1)
	{
		showMessage('error','请选择一个正确的图片');
		return;
	}
    // cleanup all temp states
    iPreviousBytesLoaded = 0;
    //document.getElementById('upload_response').style.display = 'none';
    //document.getElementById('error').style.display = 'none';
    //document.getElementById('error2').style.display = 'none';
    //document.getElementById('abort').style.display = 'none';
    //document.getElementById('warnsize').style.display = 'none';
    //document.getElementById('progress_percent').innerHTML = '';
    //var oProgress = document.getElementById('progress');
    //oProgress.style.display = 'block';
    //oProgress.style.width = '0px';

    // get form data for POSTing
    //var vFD = document.getElementById('upload_form').getFormData(); // for FF3
    var vFD = new FormData(document.getElementById('upload_form')); 

    // create XMLHttpRequest object, adding few event listeners, and POSTing our data
    var oXHR = new XMLHttpRequest();
    oXHR.upload.addEventListener('progress', uploadProgress, false);
    oXHR.addEventListener('load', uploadFinish, false);
    oXHR.addEventListener('error', uploadError, false);
    oXHR.addEventListener('abort', uploadAbort, false);
    oXHR.open('POST', 'upload');
    oXHR.send(vFD);

    // set inner timer
    oTimer = setInterval(doInnerUpdates, 300);
}

function doInnerUpdates() { // we will use this function to display upload speed
    var iCB = iBytesUploaded;
    var iDiff = iCB - iPreviousBytesLoaded;

    // if nothing new loaded - exit
    if (iDiff == 0)
        return;

    iPreviousBytesLoaded = iCB;
    iDiff = iDiff * 2;
    var iBytesRem = iBytesTotal - iPreviousBytesLoaded;
    var secondsRemaining = iBytesRem / iDiff;

    // update speed info
    var iSpeed = iDiff.toString() + 'B/s';
    if (iDiff > 1024 * 1024) {
        iSpeed = (Math.round(iDiff * 100/(1024*1024))/100).toString() + 'MB/s';
    } else if (iDiff > 1024) {
        iSpeed =  (Math.round(iDiff * 100/1024)/100).toString() + 'KB/s';
    }

    //document.getElementById('speed').innerHTML = iSpeed;
    //document.getElementById('remaining').innerHTML = '| ' + secondsToTime(secondsRemaining);        
}

/* function uploadProgress(e) { // upload process in progress
    if (e.lengthComputable) {
        iBytesUploaded = e.loaded;
        iBytesTotal = e.total;
        var iPercentComplete = Math.round(e.loaded * 100 / e.total);
        var iBytesTransfered = bytesToSize(iBytesUploaded);

        document.getElementById('progress_percent').innerHTML = iPercentComplete.toString() + '%';
        document.getElementById('progress').style.width = (iPercentComplete * 4).toString() + 'px';
        document.getElementById('b_transfered').innerHTML = iBytesTransfered;
        if (iPercentComplete == 100) {
            var oUploadResponse = document.getElementById('upload_response');
            oUploadResponse.innerHTML = '<h1>Please wait...processing</h1>';
            oUploadResponse.style.display = 'block';
        }
    } else {
        document.getElementById('progress').innerHTML = 'unable to compute';
    }
} */

function uploadFinish(e) { // upload successfully finished
    //var oUploadResponse = document.getElementById('upload_response');
    //oUploadResponse.innerHTML = e.target.responseText;
    //oUploadResponse.style.display = 'block';
	showMessage('success','上传成功');
    //document.getElementById('progress_percent').innerHTML = '100%';
    //document.getElementById('progress').style.width = '400px';
    //document.getElementById('filesize').innerHTML = sResultFileSize;
    //document.getElementById('remaining').innerHTML = '| 00:00:00';

    clearInterval(oTimer);
}

function uploadError(e) { // upload error
	showMessage('Error','请选择一个正确的图片');
    //document.getElementById('error2').style.display = 'block';
    clearInterval(oTimer);
}  

function uploadAbort(e) { // upload abort //cancel upload
    showMessage('Error','请选择一个正确的图片2');
	//document.getElementById('abort').style.display = 'block';
    clearInterval(oTimer);
}
//call toastmessage 
function showMessage(typeMessage, infoMessage)
{
	upcase = typeMessage.replace(/(\w)/,function(v){return v.toUpperCase()});
	$().toastmessage('show'+upcase+'Toast', infoMessage);
}
