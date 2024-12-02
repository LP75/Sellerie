document.addEventListener('DOMContentLoaded', (event) => {
    const rowsPerPage = 20;
    const table = document.getElementById('myTable');
    const rows = table.getElementsByTagName('tr');
    const paginationButtons = document.getElementById('pagination-buttons');
    const paginationInfo = document.getElementById('pagination-info');
    let currentPage = 1;

    function updatePagination(filteredRows) {
        currentPage = 1;
        showPage(currentPage, filteredRows);
    }

    function showPage(page, rows) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        for (let i = 1; i < table.rows.length; i++) {
            table.rows[i].style.display = 'none';
        }
        for (let i = start; i < end && i < rows.length; i++) {
            rows[i].style.display = '';
        }
        paginationInfo.textContent = `${start + 1}-${Math.min(end, rows.length)} de ${rows.length}`;
        currentPage = page;
        createPaginationButtons(rows);
    }

    function createPaginationButtons(rows) {
        const pageCount = Math.ceil(rows.length / rowsPerPage);
        paginationButtons.innerHTML = '';

        function createButton(page, text = page) {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = '#';
            a.textContent = text;
            a.className = 'flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white';
            if (page === currentPage) {
                a.classList.add('active');
            }
            a.addEventListener('click', (e) => {
                e.preventDefault();
                showPage(page, rows);
            });
            li.appendChild(a);
            return li;
        }

        paginationButtons.appendChild(createButton(1, 'Première'));

        if (currentPage > 2) {
            paginationButtons.appendChild(createButton(currentPage - 1));
        }

        paginationButtons.appendChild(createButton(currentPage));

        if (currentPage < pageCount - 1) {
            paginationButtons.appendChild(createButton(currentPage + 1));
        }

        paginationButtons.appendChild(createButton(pageCount, 'Dernière'));
    }

    function filterTable() {
        let input = document.getElementById('simple-search');
        let filter = input ? input.value.toLowerCase() : '';
        let table = document.getElementById('myTable');
        if (!table) return;
        let tr = table.getElementsByTagName('tr');
        let selectedBrands = Array.from(document.querySelectorAll('.brand-checkbox:checked')).map(cb => cb.getAttribute('data-brand').toLowerCase());
        let selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(cb => cb.getAttribute('data-category').toLowerCase());

        let filteredRows = [];
        for (let i = 1; i < tr.length; i++) {
            let th = tr[i].getElementsByTagName('th');
            let td = tr[i].getElementsByTagName('td');
            let brandMatch = selectedBrands.length === 0 || (td[1] && selectedBrands.includes(td[1].textContent.toLowerCase()));
            let categoryMatch = selectedCategories.length === 0 || (td[0] && selectedCategories.includes(td[0].textContent.toLowerCase()));
            let textMatch = th[0] && th[0].textContent.toLowerCase().indexOf(filter) > -1;

            if (brandMatch && categoryMatch && textMatch) {
                filteredRows.push(tr[i]);
            }
        }

        updatePagination(filteredRows);
    }

    filterTable();

    let searchInput = document.getElementById('simple-search');
    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }

    let brandCheckboxes = document.querySelectorAll('.brand-checkbox');
    brandCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterTable);
    });

    let categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterTable);
    });
});
