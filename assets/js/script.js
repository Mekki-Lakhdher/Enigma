window.fbAsyncInit = function() {
    FB.init({
        appId            : '235879671103788',
        autoLogAppEvents : true,
        xfbml            : true,
        version          : 'v7.0'
    });
//                    FB.ui({
//                        method: 'share',
//                        href: 'https://developers.facebook.com/docs/'
//                    }, function(response){});
//                    FB.login(function(response) {
//                        if (response.authResponse) {
//                            console.log('Welcome!  Fetching your information.... ');
//                            FB.api('/me', function(response) {
//                                console.log('Good to see you, ' + response.name + '.');
//                            });
//                        } else {
//                            console.log('User cancelled login or did not fully authorize.');
//                        }
//                    });
}

getFacebookProfile = function (id) {
    FB.login(function(response) {
        if (response.authResponse) {
            FB.api('/me', function(response) {
                document.getElementById(id).value=response.name;
            });
        } else {
            document.getElementById(id).value="No name !";
        }
    });
}

startTime = function(user_id,url) {
    var enigma_section = document.getElementById("enigma_section");
    enigma_section.removeAttribute("style");
    var start_button = document.getElementById("start_button");
    start_button.setAttribute("disabled","true");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            var now = new Date;
            var utc_offset = now.getTimezoneOffset();
            now.setMinutes(now.getMinutes()+utc_offset);

            countUpFromTime(now,"time_button");
            var time_button = document.getElementById("time_button");
            time_button.style.display = "block";

        }
    };
    xhttp.open("GET", url, true);
    xhttp.send();
}

getEnigmaStartTime = function(user_id,url) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", url, true);
    xhttp.send();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var date=JSON.parse(this.responseText)['date'];
            if (date) {
                var time_button = document.getElementById("time_button");
                time_button.style.display = "block";
                var start_button = document.getElementById("start_button");
                start_button.setAttribute("disabled","true");
                var enigma_section = document.getElementById("enigma_section");
                enigma_section.removeAttribute("style");
            }
            else {
                var start_button = document.getElementById("start_button");
                start_button.removeAttribute("disabled");
            }
            countUpFromTime(date,"time_button");
        }
    };
}

leftPad = function (number, targetLength) {
    var output = number + '';
    while (output.length < targetLength) {
        output = '0' + output;
    }
    return output;
}

countUpFromTime=function(countFrom, id) {
    countFrom = new Date(countFrom).getTime();

    var now = new Date;
    var utc_offset = now.getTimezoneOffset();
    now.setMinutes(now.getMinutes()+utc_offset);

    var    countFrom = new Date(countFrom);
    var    timeDifference = (now - countFrom);

    var secondsInADay = 60 * 60 * 1000 * 24,
        secondsInAHour = 60 * 60 * 1000;

    days = Math.floor(timeDifference / (secondsInADay) * 1);
    hours = Math.floor((timeDifference % (secondsInADay)) / (secondsInAHour) * 1);
    mins = Math.floor(((timeDifference % (secondsInADay)) % (secondsInAHour)) / (60 * 1000) * 1);
    secs = Math.floor((((timeDifference % (secondsInADay)) % (secondsInAHour)) % (60 * 1000)) / 1000 * 1);

    document.getElementById('days').innerHTML = leftPad(days, 2);
    document.getElementById('hours').innerHTML = leftPad(hours, 2);
    document.getElementById('minutes').innerHTML = leftPad(mins, 2);
    document.getElementById('seconds').innerHTML = leftPad(secs, 2);

    clearTimeout(countUpFromTime.interval);
    countUpFromTime.interval = setTimeout(function(){ countUpFromTime(countFrom, id); }, 1000);
}