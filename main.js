/* Set the width of the side navigation to 250px */
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

const d = new Date();
const h = d.getHours();
let t;

if (h >= 5 && h <= 11) {
    t = "Good morning";
} else if (h >= 12 && h <= 16) {
    t = "Good afternoon";
} else if (h >= 17 && h <= 20) {
    t = "Good evening";
} else {
    t = "Hey there";
}

try {
    document.getElementById("header").innerHTML = `${t}!`;
} catch (e) {
    console.log("Error code: 664");
}