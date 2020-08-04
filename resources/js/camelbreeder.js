var herds_selected = {};

$(document).ready(function(){
    $('.modal').modal();
    $('.collapsible').collapsible({
        onOpenEnd:function(){
            document.getElementById("farmer_password").focus();
        }
    });
    //request herds
    $.ajax({
        url: config.routes.send_herds,
        type: "get",
        success: function(response, textStatus, xhr){
            herds = {};
            herd_autocomplete = {};
            //restructure data
            response.forEach(element => {
                herds[element.name] = element.camel_count;
                herd_autocomplete[element.name] = null;
            });
            //initialize autocompletes
            $('input.herd_autocomplete').autocomplete({
                data: herd_autocomplete
            });
        },
    })
    //request shepherds
    $.ajax({
        url: config.routes.send_shepherds,
        type: "get",
        success: function(response, textStatus, xhr){
            shepherd_n_id = {};
            id_n_shepherd = {};
            shepherd_autocomplete = {};
            //restructure data
            response.forEach(element => {
                shepherd_n_id[element.name] = element.id;
                id_n_shepherd[element.id] = {name: element.name, camels: element.camels, min_camels: element.min_camels};
                shepherd_autocomplete[element.name] = null;
                shepherd_autocomplete[element.id] = null;
            });
            //initialize autocompletes
            $('input.shepherd_autocomplete').autocomplete({
                data: shepherd_autocomplete
            });
            $('input.shepherd2_autocomplete').autocomplete({
                data: shepherd_autocomplete
            });
        },
    })
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
    $('#shepherd').focusout(function(){shepherdInfo(this.value, 'shepherd');});
    $('#shepherd').change(function(){shepherdInfo(this.value, 'shepherd');});
    $('#shepherd2').change(function(){shepherdInfo(this.value, 'shepherd2');});
    $('#shepherd_name').on("input", function(){isInvalidName(this.value);});
    $('#shepherd_id').on("input", function(){isInvalidId(this.value);});
    $('#advanced_button').click(function(){
        settings = document.getElementById('advanced_settings');
        button = document.getElementById('advanced_button');
        settings.style.display = 'block';
        settings.classList.add("scale-in");
        button.classList.add('scale-out');
    });
})

$(document).ajaxError(function(){
    alert("Hiba történt!");
});
//preloader
$(document).ajaxStart(function() {
    M.toast({html: config.preloader , classes:"loader white z-depth-0"})
    toastElement = document.querySelector('.loader');
    window.ajaxLoadingToast = M.Toast.getInstance(toastElement);
});
//dismiss preloader
$(document).ajaxComplete(function() {
    ajaxLoadingToast.dismiss();
});

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
    if (!(id in id_n_shepherd) || (id==0 && elementId=="shepherd2")){ //invalid id
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


function submit_shepherding(){
    form = document.getElementById('shepherding_form');
    var error = false;
    if(!(form.id.value in id_n_shepherd)){
        error = true;
        error_message="Nincs ilyen pásztor!";
    }
    if(Object.keys(herds_selected).length<1){
        error = true;
        error_message="Nincs kiválasztva csorda!";
    }
    if(error){
        M.toast({html: `<i class='material-icons' style='margin-right:5px'>error</i>`+ error_message});
        return;
    }
    url = config.routes.shepherding;
    for(var name in herds_selected){
        var i;
        for(i = 0; i < herds_selected[name]["quantity"]; i++){
            var input = document.createElement("input");
            input.type="hidden";
            input.value=name;
            input.name="herds[]";
            form.appendChild(input);
        }
    }
    form.submit();
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