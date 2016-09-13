// common variables
var iMaxFilesize = 1048576; // 1MB
//var isRightImg = false;	//确保是图片文件 在函数fileSelected() 里面来判断
var isUploaded = ''; //是否上传图片 如果上传则赋值图片名字
var uploadedFileName = '';

function cleanall()
{
	document.getElementById('preshowimg').style.display = 'none';
	document.getElementById('preshowimg').src = '';
	document.getElementById('selectimg').style.display = 'block';
	document.getElementById('image_file').value = '';
	document.getElementById('deleteImgId').value = '';
	uploadedFileName = '';
	isUploaded = '';
}
function deleteImg()
{
	var imgName = document.getElementById('image_file').value;
	if(imgName == '')
	{
		showMessage('warning', '还没有选择图片 怎么删除');
		return;
	}
	var preshowimg = document.getElementById('preshowimg').src;
	if(preshowimg != '')
	{
		//是否已经上传
		if(isUploaded != '')
		{
			var vFD = new FormData(document.getElementById('delete_form'));
			var oXHR = getXmlHttpRequest();
			oXHR.overrideMimeType('application/json');
			oXHR.onreadystatechange = function () {
				if (oXHR.readyState === 4 && oXHR.status === 200) {
					var jsonResonse = eval('(' + oXHR.responseText + ')')
					if (jsonResonse.success) {
						//isUploaded = jsonResonse.pic;
						showMessage('success', '删除图片成功');
						cleanall();
					}
					else {
						showMessage('error', '删除图片失败');
					}
				}
			};
			oXHR.open('POST', 'additemdelete', true);
			oXHR.send(vFD);
		}
		else//只是选择了图片 没有真正上传
		{
			cleanall();
			showMessage('success', '删除图片成功');
		}
	}

}

function fileSelected() {
	if(isUploaded != '')
	{
		showMessage('error','已经上传图片, 请先删除原有图片');
		return;
	}
	else
	{
		//isRightImg = false;
		document.getElementById('selectimg').style.display = 'block';
		document.getElementById('preshowimg').style.display = 'none';
		// get selected file element
		var oFile = document.getElementById('image_file').files[0];

		// filter for image files
		var rFilter = /^(image\/bmp|image\/gif|image\/jpeg|image\/png|image\/tiff)$/i;
		if (! rFilter.test(oFile.type)) {
			//document.getElementById('error').style.display = 'block';
			//$().toastmessage('showErrorToast','请选择图片文件');
			showMessage('error','请选择图片文件');
			document.getElementById('image_file').value = '';
			return;
		}

		// little test for filesize
		if (oFile.size > iMaxFilesize) {
			//document.getElementById('warnsize').style.display = 'block';
			showMessage('warning','图片过大');
			return;
		}
		//isRightImg = true;

		// prepare HTML5 FileReader
		if (typeof (FileReader) != "undefined") {
			var oReader = new FileReader();
			oReader.onload = function(e){
				// we are going to display some custom image information here
				document.getElementById('selectimg').style.display = 'none';
				document.getElementById('preshowimg').style.display = 'block';
				document.getElementById('preshowimg').src = e.target.result;
			};
		}
		else
		{
			alert("你的浏览器不支持FileReader接口。无法看到图片预览");
		}
		// read selected file as DataURL
		oReader.readAsDataURL(oFile);
	}

}

function startUploading() {
	//uploadedFileName = '';alert(uploadedFileName);
	if(isUploaded != '')
	{
		showMessage('error','已经上传图片, 请先删除原有图片');
		return;
	}
	var imgName = document.getElementById('image_file').value;
	if (imgName == '')
	{
		showMessage('warning','你还没有选择一个图片');
		return;
	}
	/*if(!isRightImg)
	{
		showMessage('error','请选择一个正确的图片');
		return;
	}*/
	//alert(imgName+"---"+uploadedFileName);
	if(uploadedFileName == imgName)
	{
		showMessage('warning','这张图片已经上传,请选择别的图片');
		return;
	}

	// get form data for POSTing
	//var vFD = document.getElementById('upload_form').getFormData(); // for FF3
	var vFD = new FormData(document.getElementById('upload_form'));
	var oXHR = getXmlHttpRequest();
	oXHR.overrideMimeType('application/json');
	oXHR.onreadystatechange = function()
	{
		if(oXHR.readyState === 4 && oXHR.status === 200)
		{
			var jsonResonse = eval('(' + oXHR.responseText + ')')
			if(jsonResonse.success)
			{
				isUploaded = jsonResonse.pic;
				//为删除图片的隐藏表单赋值
				document.getElementById('deleteImgId').value = isUploaded;
				showMessage('success','上传成功');
				uploadedFileName = document.getElementById('image_file').value;
			}
			else
			{
				showMessage('error','上传失败');
			}
		}
	};
	oXHR.open('POST', 'additemupload', true);
	oXHR.send(vFD);
}

function getXmlHttpRequest()
{
	if(window.XMLHttpRequest)
	{
		return new XMLHttpRequest();
	}
	else if(window.ActiveXObject)
	{
		return new ActiveXObject('Microsofe.XMLHTTP');
	}
}
//call toastmessage 
function showMessage(typeMessage, infoMessage)
{
	upcase = typeMessage.replace(/(\w)/,function(v){return v.toUpperCase()});
	$().toastmessage('show'+upcase+'Toast', infoMessage);
}
