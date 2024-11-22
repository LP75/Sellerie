function filterTable() {
    let input = document.getElementById('simple-search');
    if (!input) return;
    let filter = input.value.toLowerCase();
    let table = document.getElementById('myTable');
    if (!table) return;
    let tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        let th = tr[i].getElementsByTagName('th');
        if (th[0] && th[0].textContent.toLowerCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}

document.addEventListener('DOMContentLoaded', (event) => {
    let searchInput = document.getElementById('simple-search');
    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }
});

console.log('This log comes from assets/js/equipmentIndex.js');