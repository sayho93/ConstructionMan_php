<img id="btnImageUpload<?= $imageIndex ?>" src="/admin/inc/imgUpload/bt_attach.gif" alt="Attach a file"/>
<!--<span id="divDescription<?= $imageIndex ?>"> <?= $width > 0 ? "width : " . $width : "" ?> </span>-->

<span id="divPreviewImage<?= $imageIndex ?>" style="display:none;">
    <input type="hidden" id="images<?= $imageIndex ?>" name="images<?= $imageIndex ?>" NOT_NULL="" title="Upload image"/>
    <input type="hidden" id="width<?= $imageIndex ?>" name="width<?= $imageIndex ?>" value="<?= $width ?>"/>
    <input type="hidden" id="height<?= $imageIndex ?>" name="height<?= $imageIndex ?>" value="<?= $height ?>"/>
    <img class="imgSample" src="" width="25" height="21" id="previewImage<?= $imageIndex ?>"/>      
    <img id="imgPreview<?= $imageIndex ?>" href="<?= $imageUrl ?>" src="/admin/inc/imgUpload/bt_preview.gif" style="cursor:hand;" alt="Preview" H="" W="<?= $width ?>"/>
    
    <img onclick="javascript:previewImageDelete('<?= $imageIndex ?>');" src="/admin/inc/imgUpload/btn_x.gif" style="cursor:hand;" id="previewDelete<?= $imageIndex ?>" />
    
</span>
<span id="divImageResult<?= $imageIndex ?>" class="validation4"></span>

<script type="text/javascript">

    $(document).ready(function() {
        var index = '<?= $imageIndex ?>';
        var imgURL = '<?= $imageUrl ?>';

        $('#images' + index).hide();

        if (imgURL == '')
            previewImageDelete(index);
        else {
            previewImageBind(index, imgURL);
        }
		
    });
    
</script>