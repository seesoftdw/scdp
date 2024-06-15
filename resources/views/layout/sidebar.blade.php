
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ URL::to('/') }}/dashboard" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-bold">SCDP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
              
                <li class="nav-item  {{ (request()->is('dashboard')) ? 'menu-is-opening menu-open' : '' }}" >
                    <a href="{{ URL::to('/') }}/dashboard" class="nav-link">
                        <p>Dashboard</p>
                    </a>
                </li>
                @if (auth()->user())
                    @if (auth()->user()->role_id == '1')
                        <li class="nav-item {{ (request()->is('user','create-user','edit-user')) ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <p>User<i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ URL::to('/') }}/user" class="nav-link {{ (request()->is('user','create-user','edit-user')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>User List</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

                
                <li class="nav-item {{ (request()->is('finyear', 'district', 'create-district','district/*', 'district-percentage','create-percentage', 'district-percentage/*', 'department','create-department','edit-department','department/*', 'majorhead','create-majorhead','edit-majorhead','majorhead/*', 'scheme-master','create-scheme-master','edit-scheme-master','scheme-master/*', 'soe-master','create-soe-master','edit-soe-master','soe-master/*', 'service','create-service','service/*/edit','service/*', 'sector','create-sector','edit-sector','sector/*', 'sub-sector','create-sub-sector','edit-sub-sector','sub-sector/*', 'plan','create-plan','plan/*/edit','plan/*')) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <p>Master<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (auth()->user()->role_id == '1')
                        {{-- <li class="nav-item">
                            <a href="{{ URL::to('/') }}/component" class="nav-link {{ (request()->is('component')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Components</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/finyear" class="nav-link {{ (request()->is('finyear')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fin-Year</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/district" class="nav-link {{ (request()->is('district','create-district','district/*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>District</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/district-percentage" class="nav-link {{ (request()->is('district-percentage','create-percentage', 'district-percentage/*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>District Percentage</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/department" class="nav-link {{ (request()->is('department','create-department','edit-department','department/*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Department</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/majorhead" class="nav-link {{ (request()->is('majorhead','create-majorhead','edit-majorhead','majorhead/*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Major head</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/scheme-master" class="nav-link {{ (request()->is('scheme-master','create-scheme-master','edit-scheme-master','scheme-master/*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Scheme</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/soe-master" class="nav-link {{ (request()->is('soe-master','create-soe-master','edit-soe-master','soe-master/*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Soe</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ URL::to('/') }}/constituency" class="nav-link {{ (request()->is('constituency')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Constituency</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/service" class="nav-link {{ (request()->is('service','create-service','service/*/edit','service/*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Service</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/sector" class="nav-link {{ (request()->is('sector','create-sector','edit-sector','sector/*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sector</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/sub-sector" class="nav-link {{ (request()->is('sub-sector','create-sub-sector','edit-sub-sector','sub-sector/*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sub-Sector</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/plan" class="nav-link {{ (request()->is('plan','create-plan','plan/*/edit','plan/*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Plan</p>
                            </a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/scheme-master" class="nav-link {{ (request()->is('scheme-master','create-scheme-master','edit-scheme-master','scheme-master/*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Scheme</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/soe-master" class="nav-link {{ (request()->is('soe-master','create-soe-master','edit-soe-master','soe-master/*')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Soe</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item {{ (request()->is('soe-budget-allocation','create-soe-budget-allocation','edit-soe-budget-allocation','soe-budget-allocation/*', 'soe-budget-distribution','create-soe-budget-distribution','edit-soe-budget-distribution','edit-logs-soe-budget-distribution/*','show-edit-logs-soe-budget-distribution/*','revised-soe-budget-distribution','soe-budget-distribution/*', 'revenue-scheme', 'capital-scheme')) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <p>Outlay<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (auth()->user()->role_id == '1')
                            <li class="nav-item">
                                <a href="{{ URL::to('/') }}/soe-budget-allocation" class="nav-link {{ (request()->is('soe-budget-allocation','create-soe-budget-allocation','edit-soe-budget-allocation','soe-budget-allocation/*')) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Soe Budget allocation</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ URL::to('/') }}/soe-budget-distribution" class="nav-link {{ (request()->is('soe-budget-distribution','create-soe-budget-distribution','edit-soe-budget-distribution','edit-logs-soe-budget-distribution/*','show-edit-logs-soe-budget-distribution/*','revised-soe-budget-distribution','soe-budget-distribution/*')) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Budget distribution</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="{{ URL::to('/') }}/revenue-scheme" class="nav-link {{ (request()->is('revenue-scheme')) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Revenue scheme</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ URL::to('/') }}/capital-scheme" class="nav-link {{ (request()->is('capital-scheme')) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Capital scheme</p>
                                <a href="#"  {{-- href="{{ URL::to('/') }}/capital-record-on-revenue"  --}} class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Capital record on revenue</p>
                                </a>
                            </li> -->
                        @else
                            <li class="nav-item">
                                <a href="{{ URL::to('/') }}/soe-budget-distribution" class="nav-link {{ (request()->is('soe-budget-distribution')) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Budget distribution</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="#" {{-- href="{{ URL::to('/') }}/revenue-scheme"  --}} class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Revenue scheme</p>
                                </a>
                            </li> 
                            <li class="nav-item">
                                <a href="#" {{-- href="{{ URL::to('/') }}/capital-scheme"  --}} class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Capital report</p>
                                </a>
                                <a href="#" {{-- href="{{ URL::to('/') }}/capital-record-on-revenue"  --}} class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Capital record on revenue</p>
                                </a>
                            </li> -->
                        @endif
                        
                        
                    </ul>
                </li>

                <li class="nav-item {{ (request()->is('show-department-wise-state-db', 'show-scheme-wise-state-db', 'show-department-wise-central-db', 'show-scheme-wise-central-db', 'show-department-wise-non-db', 'show-scheme-wise-non-db', )) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <p>Reports<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/show-department-wise-state-db" class="nav-link {{ (request()->is('show-department-wise-state-db')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Department wise SDB</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/show-scheme-wise-state-db" class="nav-link {{ (request()->is('show-scheme-wise-state-db')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Scheme wise SDB</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/show-department-wise-central-db" class="nav-link {{ (request()->is('show-department-wise-central-db')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Department wise CDB</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/show-scheme-wise-central-db" class="nav-link {{ (request()->is('show-scheme-wise-central-db')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Scheme wise CDB</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/show-department-wise-non-db" class="nav-link {{ (request()->is('show-department-wise-non-db')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Department wise NDB</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/') }}/show-scheme-wise-non-db" class="nav-link {{ (request()->is('show-scheme-wise-non-db')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Scheme wise NDB</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>


                @if (auth()->user()->role_id == '1')
                <li class="nav-item {{ (request()->is('show-bulk-import')) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="{{ URL::to('/') }}/show-bulk-import" class="nav-link">
                        <p>Budget Bulk Import</p>
                    </a>
                </li>
                @endif

            </ul>
            
        </nav>
    </div>
</aside>