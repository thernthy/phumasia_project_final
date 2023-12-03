document.getElementById('egg_record').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost/Green_famer_project/user/routing/get_record_req.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = xhr.responseText;
            alert(response); // Display success message
            location.reload(); // Refresh the page
        }
    };
    xhr.send(formData);
});


