const date = new Date();

let year = date.getFullYear();
const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
let monthNum = date.getMonth();
let month = months[monthNum];

document.getElementById("year").innerHTML = year.toString();
document.getElementById("month").innerHTML = month;

function getDaysInCurrentMonth(monthNum) {
    const date = new Date();

    return new Date(
        date.getFullYear(),
        monthNum + 1,
        0
    ).getDate();
}

let result = getDaysInCurrentMonth(monthNum);
setDays(result);

function setDays(result) {
    if (result === 30) {
        document.getElementById("31").innerHTML = "";
    } else if (result === 29) {
        document.getElementById("31").innerHTML = "";
        document.getElementById("30").innerHTML = "";
    } else if (result === 28) {
        document.getElementById("29").innerHTML = "";
        document.getElementById("31").innerHTML = "";
        document.getElementById("30").innerHTML = "";
    } else {
        document.getElementById("29").innerHTML = "29";
        document.getElementById("31").innerHTML = "31";
        document.getElementById("30").innerHTML = "30";
    }
}

const spans = document.getElementsByClassName("day");

const deleteEvent = function() {
    if(confirm("Would you like to delete this event?")) {
        let header = this.getElementsByClassName("eventHeader")[0].innerHTML;
        header = header.split(" ");
        const subject = header[0];
        const type = header[1].replace(':', '');
        const title = this.getElementsByClassName("eventTitle")[0].innerHTML;
        const day = document.getElementsByClassName("active")[0].innerHTML;
        const month = monthNum + 1;
        const date = `${month}/${day}/${year}`;

        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                for(let i=0;i<document.getElementsByClassName("day").length;i++){
                    if(spans[i].innerHTML === day) {
                        dayActive(i);
                    }
                }
            }
        };
        xmlhttp.open("GET", `deleteEvent.php?date=${date}&s=${subject}&type=${type}&title=${title}`, true);
        xmlhttp.send();
    }
}

const dayActive = function(e) {
    const days = document.getElementsByClassName("day");
    const elem = days[e];

    const cntrs = document.getElementsByClassName("eventCntr");
    if(cntrs.length > 0){
        while(cntrs.length > 0){
            cntrs[0].parentNode.removeChild(cntrs[0]);
        }
    }
    if (elem.classList.contains("active")) {
        elem.classList.remove("active");
    } else {
        const active = document.getElementsByClassName("active");
        if(active.length >= 1) {
            for (let i = 0; i < active.length; i++) {
                active[i].classList.remove("active");
            }
        }
        elem.classList.add("active");

        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                let body = document.createElement('div');
                body.innerHTML = this.responseText.trim();
                const divs = Array.from(body.getElementsByClassName("event"));

                if(divs.length > 0) {
                    for (let i = 0; i < divs.length; i+=3) {
                        const chunk = divs.slice(i, i + 3);
                        let cntr = document.createElement('div');
                        cntr.classList.add("eventCntr");
                        for (let i = 0; i < chunk.length; i++) {
                            divs[i].addEventListener('click', deleteEvent);
                            cntr.appendChild(divs[i]);
                        }
                        document.body.appendChild(cntr);
                    }
                }
            }
        };
        xmlhttp.open("GET", `calendar.php?d=${elem.innerHTML}&m=${monthNum+1}&y=${year}`, true);
        xmlhttp.send();
    }
};


for(let i=0;i<spans.length;i++){
    spans[i].addEventListener('click',function(){ dayActive(i); });
    if(spans[i].innerHTML === date.getDate().toString()) {
        dayActive(i);
    }
}

function changeMonth(name, num, y) {
    let month = num
    let year = y;

    if(name === "next") {
        month = num + 1;
        if(month > 11) {
            month = month - 12;
            year = year + 1;
        }
    } else if (name === "prev") {
        if(num !== 0) {
            month = num - 1;
        } else {
            month = month + 11;
            year = year - 1;
        }
    }

    return [month, year];
}

document.getElementsByClassName("next")[0].addEventListener('click', function () {
    const returnArr = changeMonth("next", monthNum, year);
    monthNum = returnArr[0];
    year = returnArr[1];
    result = getDaysInCurrentMonth(monthNum);
    setDays(result);
    document.getElementById("month").innerHTML = months[monthNum];
    document.getElementById("year").innerHTML = year.toString();
    dayActive(0);
}, false);
document.getElementsByClassName("prev")[0].addEventListener('click', function () {
    const returnArr = changeMonth("prev", monthNum, year);
    monthNum = returnArr[0];
    year = returnArr[1];
    result = getDaysInCurrentMonth(monthNum);
    setDays(result);
    document.getElementById("month").innerHTML = months[monthNum];
    document.getElementById("year").innerHTML = year.toString();
    dayActive(result-1);
}, false)
