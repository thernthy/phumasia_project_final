const dateInput = document.getElementById('date');
const selectedDateElement = document.getElementById('selectedDate');
  // Set the current date as the default value for the "Date" field
const currentDate = new Date();
dateInput.valueAsDate = currentDate;
const placeSelect = document.getElementById('place');
const nameSelect = document.getElementById('name');
function handleName() {
  console.log('changes')
    const selectedPlace = placeSelect.value;
    // Fetch names based on the selected place
    fetch(`fetch_name.php?place=${selectedPlace}`)
        .then(response => response.json())
        .then(data => {
            // Clear existing options
            nameSelect.innerHTML = '';
            // Append new options based on the fetched data
            data.forEach(name => {
                const option = document.createElement('option');
                option.value = name;
                option.textContent = name;
                nameSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
//select task 
const selectTask = document.getElementById('select_task')
const labelgood = document.getElementById('l-good')
const brokenAndBrown = document.querySelectorAll('.controler')
var changContenet = ''
function handleTask() {
  selectedTask = selectTask.value
  const broken = document.getElementById('broken').value = 0;
  const brownn = document.getElementById('brown').value = 0;
  if(selectedTask === "Steaming"){
    for(i=0; i < brokenAndBrown.length; i++){
      brokenAndBrown[i].style.display = "none"
    }
    changContenet = "Total amont: "
    labelgood.innerHTML =  changContenet
  }else{
    for(i=0; i < brokenAndBrown.length; i++){
      brokenAndBrown[i].style.display = "block"
    }
    changContenet = "Good: "
    labelgood.innerHTML = changContenet
  }
}

// Show the Add Place modal
function showAddPlaceForm() {
    const addPlaceModal = document.getElementById('addPlaceModal');
    addPlaceModal.style.display = 'block';
  }
  function closeAddPlaceModal() {
    addPlaceModal.style.display = 'none';
  }
// Handle the submit event of the Add Place form
document.getElementById('addPlaceForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    // Get the entered place value
    const newPlaceInput = document.getElementById('newPlace');
    const newPlace = newPlaceInput.value;
    
    if (newPlace === '') {
      alert('Please enter a lot number!');
      return; // Stop further execution
    }
    const formData = new FormData();
    formData.append('place', newPlace);
    
    fetch('including/add_new_place.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      // Display response message in an alert
      alert(data.message);
  
      // If the request was successful, update the dropdown
      if (data.success) {
        const placeSelect = document.getElementById('place');
        const option = document.createElement('option');
        option.value = newPlace;
        option.textContent = newPlace;
        placeSelect.appendChild(option);
        const addPlaceModal = document.getElementById('addPlaceModal');
        addPlaceModal.style.display = 'none';
        newPlaceInput.value = '';
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  });
  
  
//handle lot input form 
  function showAddLotNoModal() {
    const addLotNoModal = document.getElementById('addLotNoModal');
    addLotNoModal.style.display = 'block';
  }
  function closeAddLotnumberModal() {
    addLotNoModal.style.display = 'none';
  }
  document.getElementById('addLotNumForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    // Get the entered lot number value
    const lotNumberInput = document.getElementById('lot_number');
    const lotNumber = lotNumberInput.value;
    if (lotNumber === '') {
        alert('Please enter a lot number!');
        return; // Stop further execution
    }
    const formData = new FormData();
    formData.append('lot_number', lotNumber);
    fetch('including/add_lot_type.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Display response message in an alert
        if (data.success) {
            // If the request was successful, you can perform additional actions here
            // For example, update a table or display the added lot number somewhere
        }
        lotNumberInput.value = ''; // Reset the input field value
        closeAddLotNumberModal(); // Close the modal (assuming you have a function for that)
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

// Function to handle form submission confirm or edit
document.getElementById('recordForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent form submission
  // Get the entered data values
  const place = document.getElementById('place').value;
  const name = document.getElementById('name').value;
  const lotType = document.getElementById('lotType').value;
  const selectTask = document.getElementById('select_task').value;
  const date = document.getElementById('date').value;
  const good = document.getElementById('good').value;
  const broken = document.getElementById('broken').value;
  const brown = document.getElementById('brown').value;
  // Check if any of the required fields are empty
  if (place === '' || name === '' || lotType === '' || selectTask === '' || date === '' || good === '' || broken === '' || brown === '') {
      alert('Please fill in all required fields.');
      return;
  }else if (good < 0 || broken < 0 || brown < 0) {
    alert("You can't add negative values!");
    return;
  }
  // Build the confirmation message
  if(selectTask !== "Steaming"){
    var confirmMessage = `
   <table>
     <tbody>
         <tr>
           <td><strong>Place:</strong></td>
           <td>${place}</td>
         </tr>
         <tr>
           <td><strong>Name:</strong></td>
           <td>${name}</td>
         </tr>
         <tr>
           <td><strong>Lot Type:</strong></td>
           <td>${lotType}</td>
         </tr>
         <tr>
           <td><strong>Select Task:</strong></td>
           <td>${selectTask}</td>
         </tr>
         <tr>
           <td><strong>Date:</strong></td>
           <td>${date}</td>
         </tr>
         <tr>
           <td><strong>${changContenet}</strong></td>
           <td>${good} g</td>
         </tr>
         <tr>
           <td><strong>Broken:</strong></td>
           <td>${broken} g</td>
         </tr>
         <tr>
           <td><strong>Brown:</strong></td>
           <td>${brown} g</td>
         </tr>
       </tbody>
     </table>
   `;
   }else{
   var confirmMessage = `
   <table>
     <tbody>
         <tr>
           <td><strong>Place:</strong></td>
           <td>${place}</td>
         </tr>
         <tr>
           <td><strong>Name:</strong></td>
           <td>${name}</td>
         </tr>
         <tr>
           <td><strong>Lot Type:</strong></td>
           <td>${lotType}</td>
         </tr>
         <tr>
           <td><strong>Select Task:</strong></td>
           <td>${selectTask}</td>
         </tr>
         <tr>
           <td><strong>Date:</strong></td>
           <td>${date}</td>
         </tr>
         <tr>
           <td><strong>${changContenet}</strong></td>
           <td>${good} g</td>
         </tr>
   `;
   }
  document.getElementById('confirmData').innerHTML = confirmMessage;
  const confirmModal = document.getElementById('confirmModal');
  confirmModal.style.display = 'block';

  // Function to handle data insertion
  function insertData() {
      // Create a new FormData object
      const formData = new FormData();
      formData.append('place', place);
      formData.append('name', name);
      formData.append('lotType', lotType);
      formData.append('selectTask', selectTask);
      formData.append('date', date);
      formData.append('good', good);
      formData.append('broken', broken);
      formData.append('brown', brown);
      
      // Send the data to the PHP script using AJAX or fetch
      fetch('including/record_cw_form.php', {
          method: 'POST',
          body: formData
      })
      .then(response => response.json()) // Parse the response as JSON
      .then(data => {
          if (data.success) {
            alert(data.message); // Display success message
            document.getElementById('recordForm').reset(); // Reset the form
            closeConfirmModal(); // Close the confirmation modal
            location.reload();
          } else {
            alert(data.message); // Display error message
          }
      })
      .catch(error => {
          console.error('Error:', error);
      });
  }
  
  // Call the insertData function when the Confirm button is clicked
  document.getElementById('confirmButton').addEventListener('click', insertData);
});

// Function to close the confirmation modal
function closeConfirmModal() {
  const confirmModal = document.getElementById('confirmModal');
  confirmModal.style.display = 'none';
}