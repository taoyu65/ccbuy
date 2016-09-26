// common variables
var iMaxFilesize = 1048576; // 1MB
//var isRightImg = false;	//确保是图片文件 在函数fileSelected() 里面来判断
var isUploaded = ''; //是否上传图片 如果上传则赋值图片名字
var uploadedFileName = '';
var marked = true;//确保在激活状态不能再点击

function cleanall()
{
	document.getElementById('preshowimg').style.display = 'none';
	document.getElementById('preshowimg_x').style.display = 'none';
	document.getElementById('preshowimg').src = '';
	document.getElementById('selectimg').style.display = 'block';
	document.getElementById('image_file').value = '';
	document.getElementById('deleteImgId').value = '';
	uploadedFileName = '';
	isUploaded = '';
}

//delete pic
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
			jQuery('#delete_form').submit();
		}
		else//只是选择了图片 没有真正上传
		{
			cleanall();
			showMessage('success', '删除图片成功');
		}
	}
}
//when click select file
function fileSelected()
{
	if(isUploaded != '')
	{
		showMessage('error','已经上传图片, 请先删除原有图片');
		return;
	}
	else
	{
		//isRightImg = false;
		document.getElementById('preshowimg').style.display = 'none';
		document.getElementById('preshowimg_x').style.display = 'none';
		document.getElementById('selectimg').style.display = 'block';
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
				// we are going to display some custom image information here\
				//document.getElementById('selectimg').src = e.target.result;
				document.getElementById('preshowimg').src = e.target.result;
				document.getElementById('preshowimg_x').src = e.target.result;
				jQuery('#preshowimg_x').show();
				jQuery('#selectimg').hide();
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

//call toastmessage 
function showMessage(typeMessage, infoMessage)
{
	upcase = typeMessage.replace(/(\w)/,function(v){return v.toUpperCase()});
	$().toastmessage('show'+upcase+'Toast', infoMessage);
}

function selectPic()
{
	document.getElementById('image_file').click();
}

function startUploading()
{
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
	jQuery('#upload_form').submit();
}

//显示预览已经上传的图片   //layer插件
function showerrorinfo()
{

	if(marked) {
		marked = false;
		layer.open({
			type: 1,
			shade: [0.8, '#393D49'],
			//shadeClose: true,
			title: false, //不显示标题
			//width: '444px',
			//height: '444px',
			//time: 5000,
			scrollbar: false,
			content: $('#preshowimg'), //捕获的元素
			beforeSubmit: function () {

			},
			success: function(layero, index){
				//console.log(layero, index);
				jQuery('#preshowimg').show();
				jQuery('#preshowimg_x').hide();
				showMessage('warning', '更新图片请先删除此图片');
			},
			cancel: function (index) {

				layer.close(index);
				this.content.show();
				marked = true;
				jQuery('#preshowimg').hide();
				jQuery('#preshowimg_x').show();
				//layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', {time: 5000, icon:6});
			}
		});
	}
}

