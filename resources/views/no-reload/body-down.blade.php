<script>
    function submitForm() {
        $.ajax({
            url: '/submitForm',
            type: 'POST',
            data: $('#myForm').serialize(),
            success: function(response) {
                console.log(response);
                document.querySelector('#text').textContent = response.value
                // Handle the response here
            },
            error: function(error) {
                console.error(error);
                // Handle errors here
            }
        });
    }
</script>
