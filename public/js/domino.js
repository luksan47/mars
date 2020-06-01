
var input = [
    "müssen",
    "essen",
    "laufen",
    "können",
    "lieben",
    "schlafen",
    "kranken</br>hauswagen",
    "spielen",
    "program</br>mieren",
    "können",
    "kochen"
]

var mapMinWidth = 0;
var mapMinHeight = 0;
var mapMaxWidth = 10;
var mapMaxHeight = 10;
var dominoCount = 0;

function prepareCell(cell, i, j) {
    cell.setAttribute("class", "map-element");
    cell.setAttribute("id", "map_cell_" + i + "_" + j);
    cell.setAttribute("ondrop", "drop(event)");
    cell.setAttribute("ondragover", "allowDrop(event)");
}

function init_map() {
    var table = document.getElementById("map");
    for (let i = 0; i < mapMaxHeight; i++) {
        var row = table.insertRow(i);
        row.setAttribute("id", "map_row_" + i);
        for (let j = 0; j < mapMaxWidth; j++) {
            var cell = row.insertCell(-1);
            prepareCell(cell, i, j);
        }
    }
}    

function run() {
    init_map()
    createDomino(generateWord(), generateWord())
    createDomino(generateWord(), generateWord())
    createDomino(generateWord(), generateWord())
    createDomino(generateWord(), generateWord())
    createDomino(generateWord(), generateWord())
    createDomino(generateWord(), generateWord())
    createDomino(generateWord(), generateWord())
}

function generateWord() {
    return input[Math.floor(Math.random() * input.length)];
}

$(document).ready(function() {
    run()
});

function allowDrop(e) {
    e.preventDefault();
}

function getData(domino) {
    var kind = domino.dataset.kind;
    if (kind == "vertical") {
        return {
            "field-1" : domino.rows[0].innerText,
            "field-2" : domino.rows[1].innerText,
        }
    } else {
        return {
            "field-1" : domino.rows[0].cells[0].innerText,
            "field-2" : domino.rows[0].cells[1].innerText
        }
    }
}

function drag(e) {
    var target = e.target;
    var kind = target.dataset.kind;
    e.dataTransfer.setData("id", target.id);
    e.dataTransfer.setData("kind", kind);
    var data = getData(target);
    e.dataTransfer.setData("field-1", data["field-1"]);
    e.dataTransfer.setData("field-2", data["field-2"]);
    if (kind == "vertical") {
        e.dataTransfer.setData("grabbed", e.offsetY < 50 ? 1 : 2);
    } else {
        e.dataTransfer.setData("grabbed", e.offsetX < 50 ? 1 : 2);
    }
}

/// Adding a column to the map.
/// If position is 0, it is inserted to the left, if 1, to the right.
function addColumn(position) {
    var col;
    if (position == 0) col = --mapMinWidth;
    if (position == -1) col = mapMaxWidth++;
    var table = document.getElementById("map");
    for (let i = 0; i < table.rows.length; i++) {
        var cell = table.rows[i].insertCell(position);
        prepareCell(cell, i - mapMinHeight, col);
    }
}

/// Adding a row to the map.
/// If position is 0, it is inserted to the top, if 1, to the right.
function addRow(position) {
    var row;
    if (position == 0) row = --mapMinHeight;
    if (position == -1) row = mapMaxHeight++;
    var table = document.getElementById("map");
    var new_row = table.insertRow(position);
    new_row.setAttribute("id", "map_row_" + row);
    for (let i = mapMinWidth; i < mapMaxWidth; i++) {
        var cell = new_row.insertCell(-1);
        prepareCell(cell, row, i);
    }
    
}

/// Returning the non-grabbed side of the domino.
/// If the neighbor would fall out of the map, a column/row is inserted.
function getNeighbor(id, kind, delta) {
    var parts = id.split("_");
    var col, row;
    if (kind == "vertical") {
        row = parseInt(parts[2]) + delta;
        if (row < 0) addRow(0);
        if (row >= mapMaxHeight) addRow(-1);
        col = parts[3];
    } else {
        row = parts[2];
        col = parseInt(parts[3]) + delta;
        if (col < 0) addColumn(0);
        if (col >= mapMaxWidth) addColumn(-1);
    }
    var targetId = "map_cell_" + row + "_" + col;
    return document.getElementById(targetId);
}

function drop(e) {
    e.preventDefault();
    // Transfered data.
    var cell = e.target;
    var sourceId =  e.dataTransfer.getData("id");
    var kind = e.dataTransfer.getData("kind");
    var field1 = e.dataTransfer.getData("field-1");
    var field2 = e.dataTransfer.getData("field-2");
    var grabbed = e.dataTransfer.getData("grabbed");
    var primary, secondary, delta;
    // Selecting primary and secondary fields based on which side of the domino we grabbed.
    // The primary field is the grabbed one, which will determine the domino's position in the table.
    if (grabbed == 1) {
        primary = field1;
        secondary = field2;
        delta = 1;
    } else {
        primary = field2;
        secondary = field1;
        delta = -1;
    }
    var secondaryCell = getNeighbor(cell.id, kind, delta);
    
    // The field is occupied, placing the domino is not allowed here.
    if (cell.innerText != "" || secondaryCell.innerText != "") return;

    cell.innerText = primary;
    cell.setAttribute("class", "domino-piece");
    secondaryCell.innerText = secondary;
    secondaryCell.setAttribute("class", "domino-piece");
    
    // cleanup
    var source = document.getElementById(sourceId);
    source.parentElement.remove();
}

function rotate(domino) {
    var data = getData(domino);
    if (domino.dataset.kind == "horizontal") {
        domino.innerHTML = `
            <tr>
                <td class="domino-piece">` + data["field-1"] + `</td>
            </tr>
            <tr>
                <td class="domino-piece">` + data["field-2"] + `</td>
            </tr>`;
        domino.dataset.kind = "vertical";
    } else {
        domino.innerHTML = `
            <tr>
                <td class="domino-piece">` + data["field-2"] + `</td>
                <td class="domino-piece">` + data["field-1"] + `</td>
            </tr>`;
        domino.dataset.kind = "horizontal";
    }
}

function formatPiece(id, text) {
    var piece = document.getElementById(id);
    if (text.length > 8) {
        piece.setAttribute("class", "domino-piece domino-piece-small")
    }
}

function createDomino(primary, secondary) {
    var blocks = document.getElementById("blocks");

    // Creating a basic horizontal button.
    var element = document.createElement("div");
    element.innerHTML = `
        <table class="domino" id="domino-` + dominoCount + `" data-kind="horizontal" draggable="true" ondragstart="drag(event)">
            <tr>
                <td class="domino-piece" id="domino-` + dominoCount + `-primary">` + primary + `</td>
                <td class="domino-piece" id="domino-` + dominoCount + `-secondary">` + secondary + `</td>
            </tr>
        </table>
        <svg id="rotate-` + dominoCount + `" data-domino="` + dominoCount + `" class="bi bi-arrow-clockwise" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M3.17 6.706a5 5 0 017.103-3.16.5.5 0 10.454-.892A6 6 0 1013.455 5.5a.5.5 0 00-.91.417 5 5 0 11-9.375.789z" clip-rule="evenodd"/>
            <path fill-rule="evenodd" d="M8.147.146a.5.5 0 01.707 0l2.5 2.5a.5.5 0 010 .708l-2.5 2.5a.5.5 0 11-.707-.708L10.293 3 8.147.854a.5.5 0 010-.708z" clip-rule="evenodd"/>
        </svg>
    `;
    element.setAttribute("class", "col-2");
    blocks.appendChild(element);
    formatPiece("domino-" + dominoCount + "-primary", primary);
    formatPiece("domino-" + dominoCount + "-secondary", secondary);
    var rotateButton = document.getElementById("rotate-" + dominoCount);
    // Incrementing the number of dominos.
    dominoCount++;

    // Preparing the rotate button.
    rotateButton.addEventListener("click", function (e) {
        var id = "domino-" + e.target.dataset.domino;
        rotate(document.getElementById(id));
    });
}