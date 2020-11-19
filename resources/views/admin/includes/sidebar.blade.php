<ul class="navigation">
    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='home')) class="navigation__active" @endif>
        <a href="home">
            <i class="zwicon-home"></i>
            Dashboard
        </a>
    </li>
    
    <?php if(auth()->user()->role_id=="3") {?>
        <li  @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='manage_teams')) class="navigation__active" @endif >
        <a href="{{ url('/manage-teams') }}">
            <i class="zwicon-edit-square-feather"></i>
            Manage Teams
        </a>
    </li>
    <?php }?>
    
    <li  @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='datasources')) class="navigation__active" @endif >
        <a href="{{ url('/data-sources') }}">
            <i class="zwicon-edit-square-feather"></i>
            Data Sources
        </a>
    </li>

    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='connection')) class="navigation__active" @endif>
        <a href="{{ url('/my-connections') }}">
            <i class="zwicon-note"></i>
            My Connections
        </a>
    </li>

    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='data_ware_houses')) class="navigation__active" @endif>
        <a href="#">
            <i class="zwicon-cursor-square"></i>
            Data ware Houses
        </a>
    </li>

  <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='visualization_tools')) class="navigation__active" @endif>

        <a href="#">
            <i class="zwicon-layout-4"></i>
            Visualization Tools
        </a>
    </li>

    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='my_team')) class="navigation__active" @endif>
        <a href="{{ url('/my-team') }}">
            <i class="zwicon-repository"></i>
            My Team
        </a>
    </li>                       

</ul>