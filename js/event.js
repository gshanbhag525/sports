var modal = document.getElementById('addEventModal');
var modalBtn = document.getElementById('modalEventBtn');
var closeBtn = document.getElementById('closeEventBtn');
var eventdateerror = document.getElementById('eventdateerror');
var dateInput  = document.getElementById('eventdate');

dateInput.addEventListener('click', checkDate);

modalBtn.addEventListener('click', openAddModal);
closeBtn.addEventListener('click', closeModal);


function openAddModal() {
  modal.style.display = 'block';
  var body = document.getElementByTagName('body');
  body.style.overflowY  = 'hidden';

  modal.style.overflowY  = 'initial';
  modalContent.style.overflowY = 'auto';
}
function closeModal() {
  modal.style.display = 'none';
}

function checkDate() {
  var eventDate = document.getElementById("eventdate").value;
  var ToDate = new Date();

    if (new Date(eventDate).getTime() <= ToDate.getTime()) {

        alert("The Date must be Bigger or Equal to today date");
          return false;
    }
    return true;

};
