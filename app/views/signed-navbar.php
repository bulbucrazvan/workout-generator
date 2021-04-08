<header>
    <nav class="navbar">
        <div class="navbar__left-side">
            <a href="/project/public/home/home"> <img class="navbar__img navbar__img--left" src="/project/public/images/logoleft.png"> </a>
            <a class="navbar__list-item navbar__list-anchor" href="/project/public/home/home"> Home </a> 
        </div>
        <ul class="navbar__list">
            <li class="navbar__list-item"> <a class="navbar__list-anchor" href="/project/public/home/userWorkouts"> My Workouts </a> </li>
            <li class="navbar__list-item"> <a class="navbar__list-anchor" href="/project/public/home/globalStatistics"> Global Statistics </a> </li>
            <li class="navbar__list-item navbar__dropdown navbar__dropdown--desktop">
                <button id="accountBtn" class="navbar__button navbar__button--desktop"> <img id="accIcon" src="/project/public/images/account-icon.svg"></button>
                <div id="accountButtonBlur" class="navbar__dropdown-blur navbar__dropdown-blur--top navbar__dropdown-blur--invisible"></div>    
                <div id="accountDropDown" class="navbar__dropdown-content navbar__dropdown-content--desktop">
                    <a href="/project/public/home/home"> Settings </a>
                    <a href="/project/public"> Logout </a>
                    <div id="accountBlur" class="navbar__dropdown-blur navbar__dropdown-blur--bottom navbar__dropdown-blur--invisible"></div>
                </div>
            </li>
        </ul>
        <div class="navbar__dropdown navbar__dropdown--phone">
            <button id="menuBtn" class="navbar__button navbar__button--phone"><img id="dropDownIcon" src="/project/public/images/hamburger-icon.svg"></button>
            <div id="dropDown" class="navbar__dropdown-content navbar__dropdown-content--phone">
                    <a href="/project/public/home/home"> Home </a>
                    <a href="/project/public/home/userWorkouts"> My Workouts </a>
                    <a href="/project/public/home/globalStatistics"> Global Statistics</a>
                    <a href="/project/public/home/home"> Profile </a>
                    <a href="/project/public"> Logout </a>
                    <div class="navbar__dropdown-blur navbar__dropdown-blur--bottom"></div>
            </div>
        </div>
    </nav>
</header>

<script src="/project/public/javascript/dropdownmenu.js"></script>
<script src="/project/public/javascript/accountmenu.js"></script>