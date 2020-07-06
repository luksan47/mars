var herds_selected = {};
function shepherdInfo(val, elementId) { //show info abut selected shepherd
    input = document.getElementById(elementId);
    info = document.getElementById(elementId+'_text'); 
    input.classList.remove("invalid");
    if(val==""){ //default value is 0 - visitor
        id=0;
        input.value=id;
    }
    else if(!isNaN(val)){ //id entered
        id=val;
    }
    else { //name entered
        id=shepherd_n_id[val];
        input.value=id;
    }
    if (!(id in id_n_shepherd)){ //invalid id
        input.classList.add("invalid");
        info.innerHTML = "Nincs ilyen pásztor!";
        input.value=':(';
    }
    else{
        if (id == 0) {
            text = "<i>Vendég kiválasztva...</i>"
        } else {
            text = "<i>" + id_n_shepherd[id].name + "</i> tevéinek száma: " + id_n_shepherd[id].camels;
        }
        info.innerHTML = text;
    }
}

function addHerd(name) {
    info = document.getElementById('herd_text');
    input = document.getElementById('herd');
    output = document.getElementById('herd_list');
    input.classList.remove("invalid");
    if (!(name in herds)){
        input.classList.add("invalid");
        info.innerHTML = "Nincs ilyen csorda!";
    }else{
        if(name in herds_selected){
            herds_selected[name]["quantity"] ++;
            herds_selected[name]["amount"] += herds[name];
        }else{
            herds_selected[name] = {};
            herds_selected[name]["quantity"] = 1;
            herds_selected[name]["amount"] = herds[name];
        }
        input.value = "";
        updateHerdsInfo();
    }
}

function removeHerd(name) {
    if(name in herds_selected){
        herds_selected[name]["quantity"] --;
        herds_selected[name]["amount"] -= herds[name];
        if(herds_selected[name]["quantity"] == 0){
            delete herds_selected[name];
        }
    }
    updateHerdsInfo();
}


$(document).ready(function(){
    row_count = 0;
    $("#herd").keyup(function(){
        //add or remove herds in list by pressing arrows while in herd autocomplete
        herds_length = Object.keys(herds_selected).length;
        if(herds_length>0){    
            if(row_count>herds_length-1){ //overflow
                row_count = herds_length-1;
            }
            name = Object.keys(herds_selected)[row_count];
            if(event.key === "ArrowLeft"){
                removeHerd(name);
            }
            if(event.key === "ArrowRight"){
                addHerd(name);
            }
            if(event.key === "ArrowDown"){
                if(row_count<herds_length-1){ //overflow
                    row_count++;
                }
            }
            if(event.key === "ArrowUp"){
                if(row_count>0){ //underflow
                    row_count--;
                }
            }
        }
        //add herd or submit form
        if(event.keyCode == 13){ //enter
            herd = document.getElementById("herd").value;
            if(herd==""){
                submit_shepherding();
            }else{
                if(!(herd in herds_selected) &&  herds_length>0){
                    row_count = Object.keys(herds_selected).length;
                }
                addHerd(herd);
            }
        }
    });
    $('#shepherding_form').submit(function(e) {
        e.preventDefault();
        if(document.getElementById('shepherd') === document.activeElement || document.getElementById("herd").value!=""){
            return false;
        }
        submit_shepherding();
    });
})

function submit_shepherding(){
    form = document.getElementById('shepherding_form');
    var error = false;
    console.log(form.id.value, id_n_shepherd);
    if(!(form.id.value in id_n_shepherd)){
        error = true;
        error_message="Nincs ilyen pásztor!";
    }
    if(Object.keys(herds_selected).length<1){
        error = true;
        error_message="Nincs kiválasztva csorda!";
    }
    if(error){
        var toastHTML=`
            <i class='material-icons' style='margin-right:5px'>error</i>`
            + error_message +
            `<button 
                class='btn-flat toast-action' 
                onclick="dismissToast()">
                <i class='material-icons white-text'>clear</i>
            </button>
            `;
        M.toast({
            html: toastHTML,
            displayLength: 10000,
        });
        return false;
    }
    url = config.routes.shepherding;
    herds = [];
    for(var name in herds_selected){
        var i;
        for(i = 0; i < herds_selected[name]["quantity"]; i++){
            herds.push(name);
        }
    }
    form.herds.value = herds;
    form.submit();
    return false;
    data = {
        '_token': form._token.value,
        'id' : form.shepherd.value,
        'herds' : herds
    };
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response){
            M.toast({html: response, classes:"white black-text" });
        },
        error: function(xhr, textStatus, error){
            alert(xhr.responseText);
        }
    });

}

function updateHerdsInfo(){
    info = document.getElementById('herd_text');
    list = document.getElementById('herd_list');
    list_html = ""
    total_amount = 0;
    for(var name in herds_selected){
        list_html += "<p style='position:relative' class='noselect'>" //paragraph
            + "<a onclick='removeHerd(`"+name+"`)' id='remove_"+name+"' style='cursor:pointer'>" //add button
                + "<i class='material-icons coli-text text-orange'>remove</i></a>"
            + "<span style='position:absolute;bottom:20%;left:10%'>" //text with herds info
                + herds_selected[name]["quantity"] +" " + name + " - " + herds_selected[name]["amount"] + "</span>" 
            + "<a onclick='addHerd(`"+name+"`)' id='add_"+name+"' style='cursor:pointer'>" //remove button
                + "<i class='material-icons coli-text text-orange right'>add</i></a></p>";
        total_amount += herds_selected[name]["amount"];
    }
    list.innerHTML = list_html;
    info.innerHTML = "Összesen " + total_amount + " tevéből állnak a csordák.";
}

function isInvalidName(name) {
    info = document.getElementById('name_text');
    input = document.getElementById('shepherd_name');
    input.classList.remove("invalid");
    info.innerHTML = "";
    if (Object.keys(shepherd_n_id).indexOf(name) >= 0){
        input.classList.add("invalid");
        info.innerHTML = "Ez a név már foglalt!";
    }
}

function isInvalidId(id) {
    info = document.getElementById('id_text');
    input = document.getElementById('shepherd_id');
    input.classList.remove("invalid");
    info.innerHTML = "";
    if (Object.keys(id_n_shepherd).indexOf(id) >= 0){
        input.classList.add("invalid");
        info.innerHTML = "Ez a szám már foglalt!";
    }
}