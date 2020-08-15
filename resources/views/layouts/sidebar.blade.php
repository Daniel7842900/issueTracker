<div class="py-4 container-fluid">
    <div id="sidebar" class="sidebar float-left">
        <div class="items-container">
            <a href="/home">
                <h6 class="menu-item"><i class="fas fa-chart-line"></i>Dashboard</h6>
            </a>
            @if(auth()->user() && auth()->user()->role_id == 1)
                <a href="/user">
                    <h6 class="menu-item"><i class="fas fa-users"></i>Manage Member</h6>
                </a>
            @else

            @endif
            <a href="/project">
                <h6 class="menu-item"><i class="fas fa-tasks"></i>Projects</h6>
            </a>
            <a href="/ticket">
                <h6 class="menu-item"><i class="fas fa-ticket-alt"></i>Tickets</h6>
            </a>
            <a href="#">
                <h6 class="menu-item"><i class="fas fa-cogs"></i>Settings</h6>
            </a>
        </div>
    </div>        
</div>
