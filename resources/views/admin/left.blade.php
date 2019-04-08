@php($MenuList = \App\Model\Menu::menuList(['state'=>0]))
@php($user = \Auth::user())
@php($MenuEach = \App\Model\Menu::menuEach($MenuList,$user))


<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            {!!$MenuEach!!}
        </ul>
    </div>
</div>