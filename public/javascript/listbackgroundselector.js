var sheet = window.document.styleSheets[1];
let listItems = document.getElementsByClassName("list-area__form");

if (listItems.length % 2 == 0){
    sheet.insertRule(".list-area__list li:nth-child(even){ background-color: rgba(0, 0, 0, 0.5); }", sheet.cssRules.length);
}
else {
    sheet.insertRule(".list-area__list li:nth-child(odd){ background-color: rgba(0, 0, 0, 0.5); }", sheet.cssRules.length);
}