function checkCookie() {
    var cookies = ('; ' + document.cookie).split('; fonts-loaded=');

    if (cookies.length !== 2) {
        return false;
    }

    return cookies.pop().split(';').shift() === 'true';
}

if (checkCookie()) {
    document.documentElement.className += ' fonts-loaded';
    document.write('<link href="http://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">');
}
