<?php if (isset($_SESSION['message'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: '<?php echo $_SESSION['message']['type']; ?>',
                title: '<?php echo $_SESSION['message']['text']; ?>'
            });
        });
    </script>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<script>
    function updateCharacterCount(textarea) {
        var maxLength = 180;
        var currentLength = textarea.value.length;
        var remaining = maxLength - currentLength;
        document.getElementById('charCount').innerText = remaining + ' characters remaining';
    }
</script>
</body>
</html>
