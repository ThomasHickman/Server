function hideLoadingScreen() {
    document.getElementById("loadingElement").style.display = "none";
}

$(function () {
    return hideLoadingScreen();
});

var animations = [
    "spin",
    "zoom",
    "bg",
    "invert",
    "blur",
    "rainbow"
];

function displayLoadingScreen() {
    var animationToUse = animations[Math.floor(Math.random() * animations.length)];
    document.getElementById("loadingElement").style.display = "block";
    document.getElementById("loadingTrollFaceScreen").style.animationName = animationToUse;
}

function getImages(query, type) {
    displayLoadingScreen();
    $.post({
        url: "/lol",
        data: {
            text: query
            type: type
        }
    }).done(function (httpData) {
        var imageCont = document.createElement("div");
        imageCont.id = "downloadedImageInner"

        httpData["data"]["images"].forEach(function (id) {
            var newImage = document.createElement("img");
            newImage.src = "result/" + id + ".jpg";
            imageCont.appendChild(newImage);
        });

        document.getElementById("downloadedImageOuter").style.display = "block";
        document.getElementById("downloadedImageOuter").replaceChild(imageCont, document.getElementById("downloadedImageInner"))
        hideLoadingScreen();
    }).fail(function (error) {
        hideLoadingScreen();
        alert("YOU HAZ ERRORS");
    });
}

function postForm(type) {
    if (document.getElementById("inputBox").value != "") {
        getImages(document.getElementById("inputBox").value, type);
    } else {
        alert("Enter a value");
    }
}
