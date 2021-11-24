let P = JSON.parse(sessionStorage.getItem('P'));
sessionStorage.setItem('P', JSON.stringify(P));
if(sessionStorage.getItem('P') === 'null') {
    console.log("NULL in sessionzeug");
    P = [];
}
console.log(sessionStorage.getItem('P'));

window.onload = updatePizzaList;

let roundCounter = 0;
let rectCounter = 0;

function calc() {

    if (document.getElementById("round").checked) {
        if (!document.getElementById("round").value ||
            !document.getElementById("price").value) {
            alert("HEEEELP");

        } else {
            let radius = document.getElementById("diameter").value / 2;
            let area = radius * radius * Math.PI;

            let price = document.getElementById("price").value;
            let areaPerEuro = area / price;
            console.log(areaPerEuro + " cm^2 €");
            //document.getElementById("areaPerEuroResult").innerHTML = areaPerEuro + "cm² pro €";

            roundCounter++;
            let name = roundCounter + ". Round";
            sortIn(new RoundPizza(radius*2, 1*price, area, areaPerEuro, name));
        }
    } else {
        if (!document.getElementById("width").value ||
            !document.getElementById("length").value ||
            !document.getElementById("price").value) {
            alert("NOCH MEHR HEEEEEELP");
        } else {
            let length = document.getElementById("length").value;
            let width = document.getElementById("width").value;
            let area = length * width;

            let price = document.getElementById("price").value;
            let areaPerEuro = area / price;
            console.log(areaPerEuro + " cm^2 €");
            //document.getElementById("areaPerEuroResult").innerHTML = areaPerEuro + "cm² pro €";

            rectCounter++;
            let name = rectCounter + ". Rectangular";
            sortIn(new RectPizza(1*width, 1*length, 1*price, area, areaPerEuro, name));
        }
    }
}

function checkRadio(shape) {
    if (shape === "round") {
        document.getElementById("length").hidden = true;
        document.getElementById("width").hidden = true;
        document.getElementById("roundP").hidden = false;
        document.getElementById("diameter").hidden = false;
        document.getElementById("rectP1").hidden = true;
        document.getElementById("rectP2").hidden = true;
        console.log("ROUND MOFO");
    } else {
        console.log("RECTANGLE MOFO");
        document.getElementById("length").hidden = false;
        document.getElementById("width").hidden = false;
        document.getElementById("roundP").hidden = true;
        document.getElementById("diameter").hidden = true;
        document.getElementById("rectP1").hidden = false;
        document.getElementById("rectP2").hidden = false;
    }
}

function updatePizzaList() {
    if(sessionStorage.getItem('P') !== 'null') {
        let PList = JSON.parse(sessionStorage.getItem('P'));
        document.getElementById("pizzaList").innerHTML = "<tr>" +
            "<th class='text'>Name:</th><th class='text'>Area per Euro:</th>" +
            "<th class='text'>Price:</th><th class='delete'>&nbsp;</th></tr>";
        PList.forEach((element) => {
            let innerHTML = `<tr><td class="text">${element.name}</td>
                <td class="text">${element.areaPerEuro.toFixed(2)}cm²/€</td>
                <td class="text">${element.price.toFixed(2)}€</td>
                <td class="delete"><img src="delete.png" width="20px" height="20px" onclick="deletePizza('${element.name}');"></td></tr>`;
            document.getElementById("pizzaList").innerHTML += innerHTML;
        });
    }
}

function RoundPizza(diameter, price, area, areaPerEuro, name) {
    this.diameter = diameter;
    this.price = price;
    this.area = area;
    this.areaPerEuro = areaPerEuro;
    this.name = name;
}

function RectPizza(width, length, price, area, areaPerEuro, name) {
    this.width = width;
    this.height = length;
    this.price = price;
    this.area = area;
    this.areaPerEuro = areaPerEuro;
    this.name = name;
}

function deletePizza(name) {
    let pizzas = JSON.parse(sessionStorage.getItem('P'));
    let deletedPizza = false;
    for(let i = 0; i < pizzas.length; i++) {
        if(pizzas[i].name === name) {
            pizzas.splice(i, 1);
            deletedPizza = true;
        }
    }
    if(!deletedPizza) {
        console.error("Something went wwrong deleting Item...");
    } else {
        sessionStorage.setItem('P', JSON.stringify(pizzas));
        updatePizzaList();
    }
}

function sortIn(newPizza) {

    let pizzas = JSON.parse(sessionStorage.getItem('P'));
    let PCurrent = [];

    if(pizzas === null) {
        console.log("SORTER: Pizza list was empty, new Pizza added.");
        PCurrent.push(newPizza);
        sessionStorage.setItem('P', JSON.stringify(PCurrent));
        updatePizzaList();
    } else if(!pizzas[0]) {
        console.log("SORTER: Pizza list was empty, new Pizza added.");
        PCurrent.push(newPizza);
        sessionStorage.setItem('P', JSON.stringify(PCurrent));
        updatePizzaList();
    } else if(pizzas) {
        let newPizzaSortedIn = false;


        if(newPizza.areaPerEuro > pizzas[0].areaPerEuro) {              // Checks if newPizza is smallest current
            PCurrent.push(newPizza);
            console.log("SORTER: New Pizza was sorted in.");
            for(let k = 0; k < pizzas.length; k++) {
                PCurrent.push(pizzas[k]);
                console.log("SORTER: Pizza from list was sorted in.");
            }
        } else {
            for(let i = 0; i < pizzas.length; i++) {

                if(!newPizzaSortedIn) {

                    if(pizzas[i].areaPerEuro >= newPizza.areaPerEuro) {              //Pizzas[i] bigger than newPizza
                        PCurrent.push(pizzas[i]);
                        console.log("SORTER: Pizza from list was sorted in.");
                    } else if(pizzas[i].areaPerEuro < newPizza.areaPerEuro) {
                        PCurrent.push(newPizza);
                        console.log("SORTER: New Pizza was sorted in.");
                        newPizzaSortedIn = true;
                        PCurrent.push(pizzas[i]);
                        console.log("SORTER: Pizza from list was sorted in.");
                    }

                } else {
                    PCurrent.push(pizzas[i]);
                    console.log("SORTER: Pizza from list was sorted in.");
                }
            }

            if(!newPizzaSortedIn) {
                PCurrent.push(newPizza);
            }

        }

        sessionStorage.setItem('P', JSON.stringify(PCurrent));
        updatePizzaList();
    }
    //console.log(PCurrent);
    P = PCurrent;

}

function home() {
    window.location = "/index.html";
}