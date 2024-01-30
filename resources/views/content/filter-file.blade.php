<script>
    function handleFileSelect(event) {
        const files = event.target.files;

        for (const file of files) {
            if (isPicture(file)) {} else {
                document.querySelector('#error-file-type').style.display = 'block'
                return true;
            }
        }
        return false;
    }

    function isPicture(file) {
        // Check if the file has a valid MIME type for images
        const validMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp'];
        if (validMimeTypes.includes(file.type)) {
            return true;
        } else return false;
        // const validExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.bmp'];
        // const extension = file.name.split('.').pop().toLowerCase();
        // return validExtensions.includes(`.${extension}`);
    }
</script>
