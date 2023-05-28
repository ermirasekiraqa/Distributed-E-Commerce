let whereToBuyButton = document.getElementById("where-to-buy-button");
whereToBuyButton.onclick = whereToBuy;

let supportButton = document.getElementById("support-button");
supportButton.onclick = support;

let visitUsButton = document.getElementById("visit-us-button");
visitUsButton.onclick = visitUs;

function whereToBuy() {
    window.location = "shop.html";
}

function support() {
    window.location = "contact.php";
}

function visitUs() {
    window.location = "contact.php";
}