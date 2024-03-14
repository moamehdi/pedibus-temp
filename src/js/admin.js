const editButtons = document.querySelectorAll('.edit-user-btn');
const deleteButtons = document.querySelectorAll('.delete-user-btn');

// Ajouter un écouteur d'événement pour chaque bouton "Modifier"

editButtons.forEach(button => {
    button.addEventListener('click', () => {
        const row = button.closest('tr');
        const cells = row.querySelectorAll('.data-column');

        cells.forEach(cell => {
            const currentValue = cell.textContent;
            const input = document.createElement('input');
            input.type = 'text';
            input.value = currentValue;
            cell.innerHTML = '';
            cell.appendChild(input);
        });

        const saveButton = document.createElement('button');
        saveButton.textContent = 'Enregistrer';
        row.appendChild(saveButton);

        saveButton.addEventListener('click', async () => {
            const newData = {};
            cells.forEach((cell, index) => {
                if (index === 0) {
                    newData['last_name'] = cell.querySelector('input').value;
                } else if (index === 1) {
                    newData['first_name'] = cell.querySelector('input').value;
                } else if (index === 2) {
                    newData['mail'] = cell.querySelector('input').value;
                }
            });
            console.log(newData);

            // Envoyer les données modifiées à votre API
            const userId = button.getAttribute('data-id');
            const response = await fetch('http://localhost:80/api/users.php', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: userId, ...newData })
            });
            
            const data = await response.json();
            console.log(data.message);

            // Réinitialiser la ligne pour afficher les valeurs mises à jour
            cells.forEach(cell => {
                cell.innerHTML = newData[cell.cellIndex];
            });

            row.removeChild(saveButton);
            location.reload();
        });
    });
});



// Ajouter un écouteur d'événement pour chaque bouton "Supprimer"
deleteButtons.forEach(button => {
    button.addEventListener('click', async () => {
        const userId = button.getAttribute('data-id');
        // Envoyer une requête DELETE à votre API pour supprimer l'utilisateur avec cet ID
        const response = await fetch('http://localhost:80/api/users.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: userId })
        });
        const data = await response.json();
        location.reload();
        // Afficher le message de réussite ou d'échec
        console.log(data.message);
    });
});
