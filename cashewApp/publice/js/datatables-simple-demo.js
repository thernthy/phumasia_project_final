window.addEventListener('DOMContentLoaded', event => {
    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
});

window.addEventListener('DOMContentLoaded', event => {
    const packingTable = document.getElementById('packingTable');
    if (packingTable) {
        new simpleDatatables.DataTable(packingTable);
    }
});