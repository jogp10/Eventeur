function toggleDescription(id) {
    var z = document.querySelector('div.container:nth-child(' + id + ') > div:nth-child(1) > svg:nth-child(3)');
    var y = document.querySelector('div.container:nth-child(' + id + ') > div:nth-child(1) > svg:nth-child(2)');
    var x = document.querySelector('div.container:nth-child(' + id + ') > div:nth-child(2)');
    if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
        z.style.display = "block";
    }
    else {
        x.style.display = "none";
        z.style.display = "none";
        y.style.display = "block";
    }
}

function upVote(id, type) {
    console.log(id);
    console.log(type);
}
