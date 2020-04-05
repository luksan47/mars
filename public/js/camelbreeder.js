var camels_in_herds = 0;
function shepherdInfo(val, elementId) {
    input = document.getElementById(elementId);
    info = document.getElementById(elementId+'_text'); 
    input.classList.remove("invalid");
    if(!isNaN(val)){
        id=val;
    }
    else {
        id=shepherds[val];
        input.value=id;
    }
    if (!(id in camels)){
        input.classList.add("invalid");
        info.innerHTML = "Nincs ilyen pásztor!";
    }
    else{
        if (id == 0) {
            text = "<i>Válassz egy pásztort!</i>"
        } else {
            text = "<i>" + camels[id].name + "</i> tevéinek száma: " + camels[id].camels;
        }
        info.innerHTML = text;
    }
}
//nem kell:
/*
function showHerds(name) {
    info = document.getElementById('herd_text');
    input = document.getElementById('herd');
    input.classList.remove("invalid");
    if (!(name in herds)){
        input.classList.add("invalid");
        info.innerHTML = "Nincs ilyen csorda!";
    }else{
        text = "Ez a csorda " + herds[name] + " tevéből áll.";
        info.innerHTML = text;
    }
}
*/
function addHerd(name) {
    info = document.getElementById('herd_text');
    input = document.getElementById('herd');
    output = document.getElementById('herd_checkboxes');
    input.classList.remove("invalid");
    if (!(name in herds)){
        input.classList.add("invalid");
        info.innerHTML = "Nincs ilyen csorda!";
    }else{
        output.innerHTML += "<p><label><input type='checkbox' name='herds[]' checked value='" + name +"' onchange='changeHerd(this)'/><span>" + name + " - " + herds[name] + "</span></label></p>"

        input.value = "";
        camels_in_herds += herds[name];
        updateHerdsInfo();
    }
}
function changeHerd(checkbox) {
    if(checkbox.checked){
        camels_in_herds += herds[checkbox.value];
    }else{
        camels_in_herds -= herds[checkbox.value];
    }
    updateHerdsInfo();
}
function updateHerdsInfo(){
    info = document.getElementById('herd_text');
    info.innerHTML = "Összesen " + camels_in_herds + " tevéből állnak a csordák.";
}
/*
function toggleHistory() {
    var x = document.getElementById("history");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
*/
function isInvalidName(name) {
    info = document.getElementById('name_text');
    input = document.getElementById('shepherd_name');
    input.classList.remove("invalid");
    info.innerHTML = "";
    if (Object.keys(shepherds).indexOf(name) >= 0){
        input.classList.add("invalid");
        info.innerHTML = "Ez a név már foglalt!";
    }
}

function isInvalidId(id) {
    info = document.getElementById('id_text');
    input = document.getElementById('shepherd_id');
    input.classList.remove("invalid");
    info.innerHTML = "";
    //TODO not working
    if (Object.values(shepherds).indexOf(id) >= 0){
        input.classList.add("invalid");
        info.innerHTML = "Ez a szám már foglalt!";
    }
}