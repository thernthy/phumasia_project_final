document.getElementById('egg_record').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    const broken_file = document.getElementById('broken_egg').value;
    const good_file = document.getElementById('good_egg').value;
    const g_chicken_egg = document.getElementById('g_chicken_egg').value
    const m_chicken_egg = document.getElementById('m_chicken_egg').value
    const not_fit_egg = document.getElementById("not_fit_egg").value
    if (good_file === '' || good_file < 0 || broken_file < 0 || broken_file === '' || m_chicken_egg<=0 || g_chicken_egg<=0 || not_fit_egg<0) {
        alert("សូមពិនិត្យមើលទិន្ន័យដែលបានបញ្ចូលមិនត្រូវមានលេខអវិជ្ជមាននោះតេ!")
        return;
    }
    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://phumasia.com/green_farmer_community/user/routing/get_record_req.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = xhr.responseText;
            alert(response); // Display success message
            location.reload(); // Refresh the page
        }
    };
    xhr.send(formData);
});
