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

function showPasswordPrompt() {
  document.getElementById('passwordModall').style.display = 'block';
}

function closeModal() {
  document.getElementById('passwordModall').style.display = 'none';
}

function checkPassword() {
  const password = document.getElementById('passwordInput').value;

  if (password === 'superadmin123') {
    window.location.href = 'file_password.php';
  } else {
    alert('Access denied.');
    closeModal();
  }
}


function openPasswordModal(fileId) {
  document.getElementById('passwordModal').style.display = 'block';
  document.getElementById('fileId').value = fileId;
}

function closePasswordModal() {
  document.getElementById('passwordModal').style.display = 'none';
}

function submitPassword() {
  const password = document.getElementById('filePassword').value;
  const fileId = document.getElementById('fileId').value;
  
  window.location.href = `validate_password.php?id=${fileId}&password=${encodeURIComponent(password)}`;
}


