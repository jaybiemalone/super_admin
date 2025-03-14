// Get the button and content elements
const toggleBtn = document.getElementById('toggleBtn');
const content = document.getElementById('logout');

// Add click event listener to the button
toggleBtn.addEventListener('click', function() {
  // Toggle the 'hidden' class on the content
  content.classList.toggle('hidden');
});
