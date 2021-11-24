function calc() {
    let dateInput = new Date(document.getElementById("date").value);
    let dateToday = new Date();
    let timeInput = dateInput.getTime();
    let timeToday = dateToday.getTime();
    //console.log(timeInput + ", " + timeToday);
    let difference = timeInput - timeToday;
    let differenceDays = Math.ceil(difference / (1000 * 60 * 60 * 24));
    console.log(differenceDays);
    let tense;
    let outputHTML;
    let dd = String(dateInput.getDate()).padStart(2, '0');
    let mm = String(dateInput.getMonth() + 1).padStart(2, '0');
    let yyyy = dateInput.getFullYear();
    let dateString = mm + "/" + dd + "/" + yyyy;
    if (differenceDays > 0) {
        tense = "future.";
        outputHTML = dateString + " is " + differenceDays + " days in the " + tense;
    } else if (differenceDays < 0) {
        tense = "past.";
        outputHTML = dateString + " is " + -1 * differenceDays + " days in the " + tense;
    } else {
        outputHTML = "This date is today."
    }

    console.log(outputHTML);
    document.getElementById("output").innerHTML = outputHTML;
    document.getElementById("fsOut").hidden = false;
}

function home() {
    window.location = "index.php";
}