function home() {
    window.location = "/index.php";
}

function openDetails(dev) {
    console.log("Details for " + dev);
    window.location = "details.php?dev=" + dev;
}

function overview() {
    window.location = "index.html";
}