var angle;
var c;

var radio;

var axiom = "F";
var sentence = axiom;


var len;

var lenSlider;
var lenNumber;
var lenSpan;

var fpsSlider;
var fpsNumber;
var fpsSpan;

var itSlider;
var itNumber;
var itSpan;

var opSlider;
var opNumber;
var opSpan;

var looping = false;

var gif;

var button;
var saveButton;
var loopButton;


var myRules = [];

myRules[0] = {
    a: "F",
    b: "FF+[+F-B-F]-[-F+B+F]"
}
myRules[1] = {
    a: "B",
    b: "[+F-F][++O][--O][-F+F]"
}
myRules[2] = {
    a: "O",
    b: "[F+B-F][F-B+F]"
}

var lRules = [];

lRules[0] = {
    a: "F",
    b: "FF+[+F-F-F]-[-F+F+F]"
}

var otherRules = [];
otherRules[0] = {
    a: "F",
    b: "FFF[+F+F][-F-F][F+F-FF]"
}
otherRules[1] = {
    a: "D",
    b: "[--f][++f]"
}

var moreRules = [];
moreRules[0] = {
    a: "F",
    b: "ff[F][-fF][+fF]"
}

var allRules = [];
allRules[0] = myRules;
allRules[1] = lRules;
allRules[2] = otherRules;
allRules[3] = moreRules;


function generate() {
    var rules;
    //console.log(radio.value());
    if (radio.value() != undefined) {
        rules = allRules[radio.value() - 1];
    }
    if (rules === undefined) {
        rules = lRules;
    }
    //console.log(rules);

    len *= 0.5;
    var nextSentence = "";
    for (var i = 0; i < sentence.length; i++) {
        var current = sentence.charAt(i);
        var found = false;
        for (var j = 0; j < rules.length; j++) {
            if (current == rules[j].a) {
                found = true;
                nextSentence += rules[j].b;
                break;
            }
        }
        if (!found) {
            nextSentence += current;
        }
    }
    sentence = nextSentence;
    turtle();
}

function turtle() {
    background(51);
    resetMatrix();
    translate(width / 2, height);
    stroke(255, opSlider.value());
    for (var i = 0; i < sentence.length; i++) {
        var current = sentence.charAt(i);

        if (current == "F") {
            var rand = -random(0, len / 4);
            line(0, 0, 0, -len + rand);
            translate(0, -len + rand);
        } else if (current == "f") {
            var rand = -random(0, len);
            line(0, 0, 0, -len + rand);
            translate(0, -len + rand);
        } else if (current == "+") {
            rotate(angle + random(0, angle / 12));
        } else if (current == "-") {
            rotate(-angle - random(0, angle / 12));
        } else if (current == "[") {
            push();
        } else if (current == "]") {
            pop();
        }
    }
}

function generateAll() {
    len = lenSlider.value();
    for (var i = 0; i < itSlider.value(); i++) {
        generate();
    }
    sentence = axiom;
}

function saveImg() {
    saveCanvas(c, "LTree_" + day() + "_" + month() + "_" + year() + "-" + hour() + "-" + minute() + "-" + second(), "png");
}

function loopInv() {
    console.log("loopInv");
    looping = !looping;
    var loopButtonElement = document.getElementById("loopButton");
    loopButtonElement.classList.toggle("activated");
}

function setup() {


    document.bgColor = "#ffffff";
    angle = radians(25);

    let canvasSize;
    if (window.innerWidth > 1000) {
        canvasSize = window.innerWidth * 0.4;
        canvasSize = canvasSize < (window.innerHeight * 0.7) ? canvasSize : window.innerHeight * 0.7;
        c = createCanvas(canvasSize, canvasSize);
    } else {
        canvasSize = window.innerWidth - 100;
        c = createCanvas(canvasSize, canvasSize);
    }

    background(51);

    // Length
    lenSpan = createSpan("Length: ");
    let perfectLen = canvasSize * 0.25
    lenNumber = createSpan(perfectLen);
    lenSlider = createSlider(10, 300, perfectLen);

    // Max FPS
    fpsSpan = createSpan("Max fps: ");
    fpsNumber = createSpan(10);
    fpsSlider = createSlider(1, 30, 10);


    // Iterations 
    itSpan = createSpan('Iterations (best 4-5): ');
    itNumber = createSpan(5);
    itSlider = createSlider(1, 7, 5);


    // Opacity
    opSpan = createSpan('Opacity: ');
    opNumber = createSpan(50);
    opSlider = createSlider(1, 255, 50);



    // Buttons
    button = createButton("Generate");
    saveButton = createButton("Save");
    loopButton = createButton("Loop");
    // IDs
    loopButton.id("loopButton");
    //var gifButton = createButton("gif");
    button.mousePressed(generateAll);
    saveButton.mousePressed(saveImg);
    loopButton.mousePressed(loopInv);
    //gifButton.mousePressed(createGif);



    // Radio Buttons
    radio = createRadio();
    radio.option("My Rules", 1);
    radio.option("L Rules", 2);
    radio.option("Other Rules", 3);
    radio.selected("L Rules");


    positionElements();


    frameRate(10);
    generateAll();
}

function positionElements() {
    if (window.innerWidth > 1000) {
        let rows = [150, 180, 210, 240, 270, 300, 330, 360, 390];
        let labelSpace = window.innerWidth * 0.45;
        let numberSpace = window.innerWidth * 0.65;
        let sliderSpace = window.innerWidth * 0.75;
        // Positioning
        c.position(25, rows[0]);

        lenSpan.position(labelSpace, rows[0]);
        lenNumber.position(numberSpace, rows[0]);
        lenSlider.position(sliderSpace, rows[0]);

        fpsSpan.position(labelSpace, rows[1]);
        fpsNumber.position(numberSpace, rows[1]);
        fpsSlider.position(sliderSpace, rows[1]);

        itSpan.position(labelSpace, rows[2]);
        itNumber.position(numberSpace, rows[2]);
        itSlider.position(sliderSpace, rows[2]);

        opSpan.position(labelSpace, rows[3]);
        opNumber.position(numberSpace, rows[3]);
        opSlider.position(sliderSpace, rows[3]);

        button.position(labelSpace, rows[4]);
        saveButton.position(labelSpace, rows[5]);
        loopButton.position(labelSpace, rows[6]);

        radio.position(labelSpace, rows[7]);
    } else {
        let rows = [150, 180, 210, 240, 270, 300, 330, 360];
        let labelSpace = 50;
        let numberSpace = 50 + window.innerWidth * 0.28;
        let sliderSpace = 50 + window.innerWidth * 0.56;

        // Positioning
        c.position(25, rows[0]);

        lenSpan.position(labelSpace, rows[0] + width + 50);
        lenNumber.position(numberSpace, rows[0] + width + 50);
        lenSlider.position(sliderSpace, rows[0] + width + 50);

        fpsSpan.position(labelSpace, rows[1] + width + 50);
        fpsNumber.position(numberSpace, rows[1] + width + 50);
        fpsSlider.position(sliderSpace, rows[1] + width + 50);

        itSpan.position(labelSpace, rows[2] + width + 50);
        itNumber.position(numberSpace, rows[2] + width + 50);
        itSlider.position(sliderSpace, rows[2] + width + 50);

        opSpan.position(labelSpace, rows[3] + width + 50);
        opNumber.position(numberSpace, rows[3] + width + 50);
        opSlider.position(sliderSpace, rows[3] + width + 50);

        button.position(labelSpace, rows[4] + width + 50);
        saveButton.position(labelSpace, rows[5] + width + 50);
        loopButton.position(labelSpace, rows[6] + width + 50);

        radio.position(labelSpace, rows[7] + width + 50);
    }
}

function draw() {
    if (itSlider.value() != itNumber.value()) {
        itNumber.html(itSlider.value());
    }
    if (fpsSlider.value() != fpsNumber.value()) {
        fpsNumber.html(fpsSlider.value());
        frameRate(fpsSlider.value());
    }
    if (opSlider.value() != opNumber.value()) {
        opNumber.html(opSlider.value());
    }
    if (lenSlider.value() != lenNumber.value()) {
        lenNumber.html(lenSlider.value());
    }
    if (looping) {
        generateAll();
    }
    //console.log(looping);
}

function windowResized() {
    console.log("Window was resized.");
    let canvasSize;
    if (window.innerWidth > 1000) {
        canvasSize = window.innerWidth * 0.4;
        canvasSize = canvasSize < (window.innerHeight * 0.7) ? canvasSize : window.innerHeight * 0.7;
        resizeCanvas(canvasSize, canvasSize);
    } else {
        canvasSize = window.innerWidth - 100;
        resizeCanvas(canvasSize, canvasSize);
    }

    positionElements();

    let perfectLen = canvasSize * 0.25;
    lenNumber.html(perfectLen);
    lenSlider.value(perfectLen);
    generateAll();
}