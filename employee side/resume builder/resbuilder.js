//alert("loading");

function addNewWField1() {
    //console.log("Adding New Field");

let newNode=document.createElement("textarea");
newNode.classList.add("form-control");
newNode.classList.add("weField");
newNode.classList.add("mt-2");
newNode.setAttribute("rows", 3);
newNode.setAttribute("placeholder", "Type Here")


let weOb = document.getElementById("we");
let weAddButtonOb = document.getElementById("weAddButton");
weOb.insertBefore(newNode, weAddButtonOb);

}

function addNewWField2() {
    //console.log("Adding New Field");

let newNode=document.createElement("textarea");
newNode.classList.add("form-control");
newNode.classList.add("aqField");
newNode.classList.add("mt-2");
newNode.setAttribute("rows", 3);
newNode.setAttribute("placeholder", "Type Here")

let aqOb = document.getElementById("aq");
let aqAddButtonOb = document.getElementById("aqAddButton");
aqOb.insertBefore(newNode, aqAddButtonOb);
}

//generating cv
function generateCV() {
    //console.log("generating CV...");
   window.location.href = "resdisplay.html"; 

   let nameField = document.getElementById("nameField").value;

    let nameT1 = document.getElementById('nameT1');

    nameT1.innerHTML = nameField;

    document.getElementById('nameT2').innerHTML = nameField;
}