const dateInput = document.getElementById('date');
const selectedDateElement = document.getElementById('selectedDate');

  // Set the current date as the default value for the "Date" field
const currentDate = new Date();
dateInput.valueAsDate = currentDate;
///make sure the good broken brown are not - data
const good = document.getElementById('good')
const broken = document.getElementById('broken')
const brown = document.getElementById('brown')
const noteControl = document.getElementById('note_control')

function handleNote(){
  const expendType = document.getElementById('expendType').value;
  if(expendType == "Disposal"){
    noteControl.style.display = "block";
  }else{
    noteControl.style.display = "none";
  }
}
///handle post 
document.getElementById('addBtn').addEventListener('click', function() {
  // Get form values
  const date = document.getElementById('date').value;
  const lotNumber = document.getElementById('lotNumber').value;
  const expendType = document.getElementById('expendType').value;
  const good = document.getElementById('good').value;
  const broken = document.getElementById('broken').value;
  const brown = document.getElementById('brown').value;
  const note = document.getElementById('note').value;
  
  if (good < 0 || broken < 0 || brown < 0) {
    alert("You can't add negative values!");
    return;
  } else if (good === '' || broken === '' || brown === '') {
    alert("Please enter values for Good, Broken, and Brown!");
    return;
  }
  // Update confirm block with the form values
  document.getElementById('confirmDate').textContent = date;
  document.getElementById('confirmLotNumber').textContent = lotNumber;
  document.getElementById('confirmExpendType').textContent = expendType;
  document.getElementById('confirmGood').textContent = good;
  document.getElementById('confirmBroken').textContent = broken;
  document.getElementById('confirmBrown').textContent = brown;
  document.getElementById('confirmnote').textContent = note;

  // Hide the form and show the confirm block
  document.getElementById('expendingForm').style.display = 'none';
  document.getElementById('confirmBlock').style.display = 'block';
});

document.getElementById('editBtn').addEventListener('click', function() {
  // Hide the confirm block and show the form
  document.getElementById('confirmBlock').style.display = 'none';
  document.getElementById('expendingForm').style.display = 'block';
});

document.getElementById('confirmBtn').addEventListener('click', function() {
  const date = document.getElementById('confirmDate').textContent;
  const lotNumber = document.getElementById('confirmLotNumber').textContent;
  const expendType = document.getElementById('confirmExpendType').textContent;
  const good = document.getElementById('confirmGood').textContent;
  const broken = document.getElementById('confirmBroken').textContent;
  const brown = document.getElementById('confirmBrown').textContent;
  const Note = document.getElementById('confirmnote').textContent;
  const formData = new FormData();
  formData.append('date', date);
  formData.append('lotNumber', lotNumber);
  formData.append('expendType', expendType);
  formData.append('good', good);
  formData.append('broken', broken);
  formData.append('brown', brown);
  formData.append('note', Note);

  fetch('including/expend_record.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.text())
    .then(data => {
      alert(data); // Display the server response
      document.getElementById('expendingForm').reset(); // Reset the form
      document.getElementById('confirmBlock').style.display = 'none'; // Hide the confirm block
      document.getElementById('expendingForm').style.display = 'block'; // Show the form
      location.reload(); // Refresh the page
    })
    .catch(error => {
      console.error('Error:', error);
    });
});


