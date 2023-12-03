// add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");
function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}
list.forEach((item) => item.addEventListener("mouseover", activeLink));
// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");
toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};
function updateAbaribleCheckend(avaribleCheckend) {
  const circle = document.getElementById('circle');
  const textcolor = document.getElementById('avarible_checken')
  circle.classList.remove('red', 'yellow', 'green');
  if (avaribleCheckend < 150) {
    circle.classList.add('red');
    textcolor.style.color = "red"
    circle.style.boxShadow ="0 3px 25px rgba(255, 0, 0, 0.130)"
  } else if (avaribleCheckend <= 250) {
    circle.style.boxShadow =" 0 3px 25px rgba(255, 222, 37, 0.230)"
    circle.classList.add('yellow');
    textcolor.style.color = "yellow"
  } else if (avaribleCheckend <= 450) {
    circle.classList.add('green');
    circle.style.boxShadow ="0 3px 25px rgba(164, 255, 79, 0.396)"
    textcolor.style.color = "green"
  }
}
const avaribleCheckend = (document.getElementById('avarible_checken').innerText!=0)?document.getElementById('avarible_checken').innerText:0
updateAbaribleCheckend(avaribleCheckend);
// dai checken check
let color_track_dia = document.getElementById('dai_checken')
function updateDiaCheckend(daiCheckend) {
  const circle = document.getElementById('dia');
  circle.classList.remove('red', 'yellow', 'green');
  if (daiCheckend <= 39) {
    circle.classList.add('green');
    color_track_dia.style.color = 'green'
    circle.style.boxShadow = "0 3px 25px rgba(164, 255, 79, 0.396)";
  } else if (daiCheckend >= 40 && daiCheckend <= 59) {
    circle.classList.add('yellow');
    circle.style.boxShadow = "0 3px 25px rgba(255, 222, 37, 0.230)";
    color_track_dia.style.color = "yellow"
  } else if (daiCheckend >= 60) {
    circle.classList.add('red');
    circle.style.boxShadow = "0 3px 25px rgba(255, 0, 0, 0.130)";
    color_track_dia.style.color = "red";
  }
}
let daiCheckendData = document.getElementById('dai_checken').innerText;
  let daiCheckend = ((daiCheckendData!=0)?Number(daiCheckendData)/Number(avaribleCheckend)*100:0);
  updateDiaCheckend(daiCheckend);
//dia checken
function updateSoldCheckend(soldCheckend) {
  const circle = document.getElementById('sold');
  const color_trick_sold = document.getElementById('sold_checken')
  circle.classList.remove('red', 'yellow', 'green');
  if (soldCheckend <= 39) {
    circle.classList.add('red');
    circle.style.boxShadow ="0 3px 25px rgba(255, 0, 0, 0.130)"
    color_trick_sold.style.color = "red"
  } else if (soldCheckend >= 40 && soldCheckend <= 60) {
    color_trick_sold.style.color = "yellow"
    circle.classList.add('yellow');
    circle.style.boxShadow ="0 3px 25px rgba(255, 222, 37, 0.230)"
  } else if (soldCheckend > 60) {
    color_trick_sold.style.color = "green"
    circle.classList.add('green');
    circle.style.boxShadow ="0 3px 25px rgba(164, 255, 79, 0.396)"
  }
}
const Soldchicken = document.getElementById('sold_checken').innerText
let soldCheckend =((Soldchicken!=0)?(Soldchicken / avaribleCheckend) * 100:0); // You can change this value
updateSoldCheckend(soldCheckend);
//sold b_chiken 
function updatebsoldChikendata(bsoldChikendata) {
  const circle = document.getElementById('b_ch_sold_block');
  const color_trick_sold = document.getElementById('b_ch_sold')
  circle.classList.remove('red', 'yellow', 'green');
  if (bsoldChikendata <= 39) {
    circle.classList.add('red');
    circle.style.boxShadow ="0 3px 25px rgba(255, 0, 0, 0.130)"
    color_trick_sold.style.color = "red"
  } else if (bsoldChikendata >= 40 && bsoldChikendata <= 60) {
    color_trick_sold.style.color = "yellow"
    circle.classList.add('yellow');
    circle.style.boxShadow ="0 3px 25px rgba(255, 222, 37, 0.230)"
  } else if (bsoldChikendata > 60) {
    color_trick_sold.style.color = "green"
    circle.classList.add('green');
    circle.style.boxShadow ="0 3px 25px rgba(164, 255, 79, 0.396)"
  }
}
const getbsoldChikendata = document.getElementById('b_ch_sold').innerText
let bsoldChikendata = (getbsoldChikendata!=0)?(getbsoldChikendata/avaribleCheckend) * 100:0; // You can change this value
updatebsoldChikendata(bsoldChikendata);


//view all bady chiken function display
function viewAllBadyChiken() {
  const viewBchcontainer = document.getElementById('viewAll_bch_container')
  const viewBchcontainerSold = document.getElementById('viewAll_bch_container_sold')
  if(viewBchcontainer.style.display = "none"){
    viewBchcontainer.style.display = "flex"
    viewBchcontainerSold.style.display = "none"
  }else{
    viewBchcontainer.style.display = "none"
  }
}
//view all bady chiken function close
function viewAllBadyChikenClose() {
  const viewBchcontainer = document.getElementById('viewAll_bch_container')
  if(viewBchcontainer.style.display = "flex"){
    viewBchcontainer.style.display = "none"
  }else{
    viewBchcontainer.style.display = "flex"
  }
}
//view all bady chiken sold function
function viewAllBadyChikenSold() {
  const viewBchcontainer = document.getElementById('viewAll_bch_container')
  const viewBchcontainerSold = document.getElementById('viewAll_bch_container_sold')
  console.log(viewBchcontainerSold.style.display)
  if(viewBchcontainerSold.style.display = "none"){
    viewBchcontainerSold.style.display = "flex"
    viewBchcontainer.style.display ="none"
  }else{
    viewAllBadyChikenSold.style.display = "none"
  }
}
//view all bady chiken sold function close
function viewAllBadyChikenCloseSold() {
  const viewBchcontainerSold = document.getElementById('viewAll_bch_container_sold')
  if(viewBchcontainerSold.style.display = "flex"){
    viewBchcontainerSold.style.display = "none"
  }else{
    viewAllBadyChikenSold.style.display = "none"
  }
}

// showing sold data 
function view_sold_ch_data() {
  const buttonConfig = document.getElementById('merl_btn');
  const chikenSoldCotent = document.getElementById('ch_sold_content');
  if (chikenSoldCotent.classList.contains('view_sell')) {
    chikenSoldCotent.classList.toggle('active');
  }
  if(chikenSoldCotent.classList.contains("active")){
    buttonConfig.innerText = "បិទការមើល"
    buttonConfig.style.color = "red"
  }else{
    buttonConfig.innerText = "មើលការលក់"
    buttonConfig.style.color = "white"
  }
}


//showing egg data content 
function view_egg_content(){
  const get_view_in_box_block = document.getElementById('in_box_chicken')
  const button_color_config_burn = document.getElementById('merl_burn')
  const button_color_config = document.getElementById('merl_egg')
  const get_view_egg_content_block = document.getElementById('content_egg')
  const get_view_burn_content_block = document.getElementById('content_burn')
  if(get_view_egg_content_block.classList.contains('content_data')){
    get_view_egg_content_block.classList.toggle('egge_view_active');
  }
  if(get_view_burn_content_block.classList.contains("burn_view_active")){
    get_view_burn_content_block.classList.remove('burn_view_active')
  }
  if(get_view_egg_content_block.classList.contains('egge_view_active')){
    button_color_config.style.backgroundColor = "red"
    button_color_config.innerText = "-"
    get_view_in_box_block.classList.remove('view_in_box_content_active')
  }else{
    button_color_config.style.backgroundColor = "#2a2185"
    button_color_config.innerText = "ការកត់ត្រាពង់មាន"
    get_view_in_box_block.classList.add('view_in_box_content_active')
  }
  if(get_view_burn_content_block.classList.contains('burn_view_active')){
    button_color_config_burn.innerText = "-"
    button_color_config_burn.style.backgroundColor = "red"
  }else{
    button_color_config_burn.innerText = "ការញាស់"
    button_color_config_burn.style.backgroundColor = "#2a2185"
  }
}

//showing burn data conten 
function view_burn_content(){
  const get_view_in_box_block = document.getElementById('in_box_chicken')
  const button_color_config = document.getElementById('merl_egg')
  const button_color_config_burn = document.getElementById('merl_burn')
  const get_view_egg_content_block = document.getElementById('content_egg')
  const get_view_burn_content_block = document.getElementById('content_burn')
  if(get_view_burn_content_block.classList.contains('content_data')){
    get_view_burn_content_block.classList.toggle('burn_view_active');
  }
  if(get_view_egg_content_block.classList.contains('egge_view_active')){
    get_view_egg_content_block.classList.remove('egge_view_active')
  }
  if(get_view_egg_content_block.classList.contains('egge_view_active')){
    button_color_config.style.backgroundColor = "red"
    button_color_config.innerText = "-"
  }else{
    button_color_config.style.backgroundColor = "#2a2185"
    button_color_config.innerText = "ការកត់ត្រាពង់មាន"
  }
  if(get_view_burn_content_block.classList.contains('burn_view_active')){
    button_color_config_burn.innerText = "-"
    button_color_config_burn.style.backgroundColor = "red"
    get_view_in_box_block.classList.remove('view_in_box_content_active')
  }else{
    button_color_config_burn.innerText = "ការញាស់"
    button_color_config_burn.style.backgroundColor = "#2a2185"
    get_view_in_box_block.classList.add('view_in_box_content_active')
  }
}

