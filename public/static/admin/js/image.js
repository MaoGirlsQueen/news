$(function () {
    $("#file_upload").uploadify({
        uploader:image_upload_url,
        swf:swf,
        buttonText: '图片上传',
        fileTypeDesc: "Image files",
        fileObjName: 'file',
        fileTypeExts: '*.gif;*.jpg;*.png',
        onUploadSuccess:function (file,data,response) {
            if(response){
                var obj = JSON.parse(data);
                $('#upload_org_code_img').attr("src",obj.data);
                $('#file_upload_image').attr("value",obj.data);
                $('#upload_org_code_img').show();
            }
        }

    })
})