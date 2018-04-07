var snap,
    s,h,w,
    banner;


window.onload = function() {
    draw();
};

snap = Snap('#introBgSvg');
s = 10;
h = s * 2;
w = Math.sqrt(3) * s;
banner = snap.rect(0,0,'100%','100%').attr({fill: '#cadfe6'});

function draw() {
    function drawElement(x, y) {
        snap.polyline([
            [w * 0.5, 0],
            [0, h * 0.25],
            [0, h * 0.75],
            [w * 0.5, h],
            [w, h * 0.75],
            [w, h * 0.25]
        ]).attr({
            transform: 'translate(' + x * w + ',' + y * h + ')',
            fill: "#cadfe6",
            opacity: Math.random() * (0.6 - 0.3) + 0.3
        })
            .mouseover(function(e) {
                Snap(e.srcElement).animate({
                    fill: '#fff',
                    opacity: 0.9
                }, 500);
            })
            .mouseout(function(e) {
                setTimeout(function() {
                    Snap(e.srcElement).animate({
                        fill: '#d5edf9',
                        opacity: Math.random() * (0.6 - 0.3)
                    }, 500);
                }, 500);
            });
    }

    for (var i = -1; i < window.innerWidth / w; i += 1) {
        for (var j = -1; j < window.innerHeight / 30; j += 1.5) {
            drawElement(i, j);
            drawElement(i + 0.5, j + 0.75);
        }
    }
}

// var user_home = document.getElementById('user_home');
//
// user_home.style.cursor = 'pointer';
// user_home.onclick = function() {
//     window.location.replace("/profile");
// };

