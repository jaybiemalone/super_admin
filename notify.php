<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Maintenance Notifications</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
  <button id="notifyBtn" class="flex items-center gap-2 px-4 py-2 text-black bg-[#F5F5F5] hover:bg-[#E0E0E0] rounded-lg shadow-lg transition-transform transform hover:scale-105">
    <i class="fa-solid fa-bell"></i> Notifications
  </button>

  <!-- Modal Structure -->
  <div id="modal-notify" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
      <h2 class="text-xl font-bold mb-4">Maintenance Updates</h2>
      <button id="closeModal" class="absolute top-2 right-2 text-gray-500">&times;</button>
      <div id="updateContent" class="space-y-4">
        <!-- Updates will be injected here -->
      </div>
    </div>
  </div>

  <script>
    document.getElementById('notifyBtn').addEventListener('click', function() {
      fetch('fetch_updates.php')
        .then(response => response.json())
        .then(data => {
          const updateContent = document.getElementById('updateContent');
          updateContent.innerHTML = '';
          
          if (data.length === 0) {
            updateContent.innerHTML = '<p>No updates available.</p>';
          } else {
            data.forEach(item => {
              const box = document.createElement('div');
              box.classList.add('border', 'p-4', 'rounded-lg', 'bg-gray-100');
              box.innerHTML = `<strong>${item.name}</strong><p>${item.update}</p>`;
              updateContent.appendChild(box);
            });
          }

          document.getElementById('modal-notify').classList.remove('hidden');
        });
    });

    document.getElementById('closeModal').addEventListener('click', function() {
      document.getElementById('modal-notify').classList.add('hidden');
    });
  </script>
</body>
</html>
