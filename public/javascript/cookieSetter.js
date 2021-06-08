function setCookie(name, value) {
    var date = new Date();
    date.setTime(date.getTime() + 10*1000);
    expires = "; expires=" + date.toUTCString();
    document.cookie = name + "=" + value + expires + "; path=/";
}