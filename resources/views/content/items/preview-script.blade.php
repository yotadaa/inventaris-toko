<script>
    function previewBarang(fileId, imgId) {
        var fileInput = document.getElementById(fileId);
        var previewImage = document.getElementById(imgId);

        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>
