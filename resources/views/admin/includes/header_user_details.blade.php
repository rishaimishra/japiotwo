        <div class="user__info" data-toggle="dropdown">
                        
                            <img class="user__img" src="{{ asset('super_admin2.0/demo/img/profile-pics/8.jpg') }}" alt="">
                            <div>
                                <div class="user__name">{{ Auth::user()->name }}</div>
                                <div class="user__email">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <div class="dropdown-menu dropdown-menu--invert">
                            <a class="dropdown-item" href="#">View Profile</a>
                            <a class="dropdown-item" href="#">Settings</a>
                            
                            
                            
                            <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>

                                                      <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                     

<input id="csft_pass" type="hidden" name="_token" value="{{ csrf_token() }}">
                                                     </form>
                        </div>
                