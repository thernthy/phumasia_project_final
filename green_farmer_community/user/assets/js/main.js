//get data 
const currentDate = new Date();
const formattedDate = currentDate.toISOString().split('T')[0];

//showing real time data in the record egg on select date fill
const eggRecordDate = document.getElementById('egg_data_record');
eggRecordDate.value = formattedDate;

//generate barcode 
function generateRandomBarcode() {
        const now = new Date();
        const dayOfWeek = now.getDay();
        let month = now.getMonth() + 1;
        month = month < 10 ? "0" + month : month;
        let randomNumber = Math.floor(Math.random() * 10000);
        let randomCharacter = String.fromCharCode(65 + Math.floor(Math.random() * 26)); // Generate a random uppercase character (A-Z)
        return "Bc" + dayOfWeek + randomNumber + month + randomCharacter;
}
const barcodeID =document.getElementById('bar_code_id').value = generateRandomBarcode();