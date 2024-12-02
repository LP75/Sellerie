// document.addEventListener('DOMContentLoaded', function () {
//     document.querySelectorAll('.delete-button').forEach(function (button) {
//         button.addEventListener('click', function (event) {
//             event.preventDefault();
//             const form = button.closest('.delete-form');
//             const itemId = form.getAttribute('data-id');
//             const csrfToken = form.querySelector('input[name="_token"]').value;

//             fetch(`{{ path('app_equipment_item_delete', {'id': 'ITEM_ID'}) }}`.replace('ITEM_ID', itemId), {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/x-www-form-urlencoded',
//                 },
//                 body: `_token=${csrfToken}`
//             })
//             .then(response => {
//                 if (response.ok) {
//                     form.closest('tr').remove();
//                 } else {
//                     alert('Erreur lors de la suppression de l\'élément.');
//                 }
//             })
//             .catch(error => {
//                 console.error('Erreur:', error);
//                 alert('Erreur lors de la suppression de l\'élément.');
//             });
//         });
//     });
// });