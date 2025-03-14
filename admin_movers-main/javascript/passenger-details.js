function showDetails(id) {
    // Fetch passenger details from the server using AJAX
    fetch(`getPassengerDetails.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            // Populate the modal with details
            const modalDetails = document.getElementById('modalDetails');
            modalDetails.innerHTML = `<br>
                <p><strong>User:</strong> ${data.user}</p><br>
                <p><strong>ID:</strong> ${data.id}</p><br>
                <p><strong>Email:</strong> <a href="#" style="color: blue;"><u>${data.email}</u></a></p><br>
                <p><strong>Ticket:</strong> ${data.ticket}</p><br>
                <p><strong>Status:</strong> <span style=" border: 1px solid black; border-radius: 15px; padding: 10px 20px;">${data.dstatus}</span></p><br>
                <p><strong>Details:</strong> ${data.dtext}</p><br>
                <p><strong>Date:</strong> ${data.ddate}</p>
            `;

            // Show the modal
            const modal = document.getElementById('detailsModal');
            modal.style.display = 'block';
        })
        .catch(error => console.error('Error fetching details:', error));
}

// Close modal function
function closeModal() {
    const modal = document.getElementById('detailsModal');
    modal.style.display = 'none';
}

// Close modal when clicking outside of the modal
window.onclick = function(event) {
    const modal = document.getElementById('detailsModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}