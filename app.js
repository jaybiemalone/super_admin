const toggleButton = document.getElementById('toggle-btn');
const sidebar = document.getElementById('sidebar');

function toggleSidebar() {
  sidebar.classList.toggle('close');
  toggleButton.classList.toggle('rotate');
  closeAllSubMenus();
}

function toggleSubMenu(button) {
  const subMenu = button.nextElementSibling;

  if (!subMenu.classList.contains('show')) {
    closeAllSubMenus();
  }

  subMenu.classList.toggle('show');
  button.classList.toggle('rotate');

  if (sidebar.classList.contains('close')) {
    sidebar.classList.remove('close');
    toggleButton.classList.add('rotate');
  }
}

function closeAllSubMenus() {
  Array.from(sidebar.getElementsByClassName('show')).forEach(ul => {
    ul.classList.remove('show');
    ul.previousElementSibling.classList.remove('rotate');
  });
}


function closethisModal() {
  const modal = document.querySelector('.modal');
  if (modal) {
    modal.style.display = 'none';
  }
}

function showPasswordPrompt() {
  document.getElementById('passwordModall').style.display = 'block';
}

function checkPassword() {
  const password = document.getElementById('passwordInput').value;

  if (password === '123456789') {
    window.location.href = 'file.php';
  } else {
    alert('Access denied.');
    closeModal();
  }
}


function closeModal(event) {
  event.preventDefault(); // Prevents navigation
  document.getElementById('passwordModall').style.display = 'none';
}



// logout modal

function openLogout() {
  document.getElementById('modal-logout').classList.remove('hidden');
}

function logoutClose() {
  document.getElementById('modal-logout').classList.add('hidden');
}

function confirmLogout() {
  window.location.href = 'logout.php';
}


// System update Function

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
    