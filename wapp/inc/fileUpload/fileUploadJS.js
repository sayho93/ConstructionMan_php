function previewFileDelete(index) {
    $('#divPreviewFile' + index).hide();
	$('#previewFile' + index).attr('src', '');

	if ($.browser.msie) {
		// ie 일때 input[type=file] init.
		$('#files' + index).replaceWith( $('#files' + index).clone(true) );
		$('#uploaded_files' + index).val("");
	} else {
		// other browser 일때 input[type=file] init.
		$('#files' + index).val("");
		$('#uploaded_files' + index).val("");
	}
}

function initFileUpload(index)
{

	$("#btnFileUpload" + index).css("cursor", "pointer").click(function(){
		$("#files" + index).trigger("click");
	});

	$("#files" + index).change(function(){
		if (this.files && this.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				// previewFileBind(index, "object", e.target.result, "");

			}

			reader.readAsDataURL(this.files[0]);
		}
	});
}

function destoryFileUpload(index)
{
	$("#btnFileUpload" + index).unbind("click");
	$("#files" + index).unbind("change");
	$("#jFileUploadArea" + index).remove();
	
}

function previewFileBind(index, dataType, data, prefixPath) {

	var url = data;

	if(dataType == "filePath")
	{
		var ext = data.substring(data.length -3, data.length).toLowerCase();
		if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)) {
			$('#previewFile' + index).attr('src', prefixPath + url);
			$('#priviewFileScale' + index).css('background-image', "url(" + prefixPath + url + ")");
			$('#uploaded_files' + index).val(data);
			$('#divPreviewFile' + index).show();
			setScaleViewEvent(index);
		}
	}
	else
	{
		if (data.indexOf("image/") > -1) {
			$('#priviewFileScale' + index).css('background-image', "url(" + url + ")");
			$('#previewFile' + index).attr('src', data);	    
			$('#divPreviewFile' + index).show();
			setScaleViewEvent(index);
		}
	}
}


function setScaleViewEvent(index)
{
	$('#previewFile' + index).unbind("hover");
	$('#previewFile' + index).hover(
		function()
		{
			var top = $(this).offset().top;
			$('#priviewFileScale' + index).css("top", top - $('#priviewFileScale' + index).height()).css("z-index", "99999").show();
		},
		function()
		{
			$('#priviewFileScale' + index).hide();
		}
	);

}
