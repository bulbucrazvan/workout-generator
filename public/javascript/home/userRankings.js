let rankingCriterion = document.getElementById('comboBox').value;

async function getRankings(rankingCriterion) {
    var uri = "http://92.115.143.213:3000/project/api/users/ranking?rankBy=" + rankingCriterion;
    const response = await fetch(uri, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    const responseBody = await response.json();
    return responseBody;
}

async function updatePage() {
    let rankingCriterion = document.getElementById('comboBox').value;
    var receivedRankings = await getRankings(rankingCriterion);
    await showRankings(rankingCriterion, receivedRankings);
    setListBackgroundColour("list-area__list", "");
}

function showRankings(rankingCriterion, receivedRankings) {
    let rankingList = document.getElementById('rankingsList');
    var stringToAppend = '';
    if (rankingCriterion == 'longestStreak' || rankingCriterion == 'currentStreak') {
        stringToAppend = ' days';
    };

    rankingList.innerHTML = '';
    for (ranking of receivedRankings) {
        newListItem = `<li> <p class="list-area__paragraph list-area__paragraph--left">`
         + ranking["username"] 
         + `</p> <p class="list-area__paragraph">`
         + ranking[rankingCriterion] + stringToAppend;
         + `</li>`;
        rankingList.innerHTML += newListItem;
    }
}

async function criterionSelectorHandler() {
    await updatePage();
}

updatePage();
comboBox.addEventListener('change', criterionSelectorHandler);
