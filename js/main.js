var modal = document.getElementById('simpleModal');
var updateModal = document.getElementById('updateModal');

var modalBtn = document.getElementById('modalBtn');
var modalUpdateBtn = document.getElementById('modalUpdateBtn');

var closeBtn = document.getElementById('closeBtn');
var closeUpdateBtn = document.getElementById('closeUpdateBtn');

var catId, catName;

modalBtn.addEventListener('click', openAddModal);
closeBtn.addEventListener('click', closeModal);

// modalUpdateBtn.addEventListener('click', openUpdateModal);
closeUpdateBtn.addEventListener('click', closeUpdateModal);

function openAddModal() {
  modal.style.display = 'block';
}
function openUpdateModal(catId, catName) {
  console.log(catId);
  
  document.getElementById('categoryUpdate').value  = catName;

  document.getElementById('categoryIdHidden').value  = catId;

  updateModal.style.display = 'block';
}

function closeModal() {
  modal.style.display = 'none';
}
function closeUpdateModal() {
  updateModal.style.display = 'none';
}
