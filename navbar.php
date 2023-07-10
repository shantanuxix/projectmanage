
<div class='d-flex flex-column flex-shrink-0 px-4 bg-light vh-100 col-md-0' style='width: 280px;'>
    <ul class='nav navbar-nav nav-pills flex-column mb-auto'>
        <li>
            <a class='nav-link link-dark' href="user_page.php">
                <h2 class="text-center p-1"><img src="./images/person-video2.svg" class="px-1" alt="" srcset=""><i>Task</i> Do</h2>
            </a>
        </li>
        <li>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search Project" name="searchproject" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </li>
        <li class="my-2">
            <button class='nav-link link-dark border-0 w-100' href="#projectsDiv" data-target="#projectsDiv" data-bs-toggle='collapse' data-bs-target='#dashboard-collapse' aria-expanded='false'>
                <h4 class="p-1 m-0"><img src="./images/briefing.png" width='32' height='32' alt="" srcset="">
                    Projects
                </h4>
            </button>
        </li>
        <li class="my-2">
            <button class='nav-link link-dark border-0 w-100' href="#createProjectDiv" data-target="#projectsDiv" data-bs-toggle='collapse' data-bs-target='#dashboard-collapse' aria-expanded='false'>
                <h4 class="p-1 m-0"><img src="./images/icons8-project-management-50.png" width='32' height='32' alt="" srcset="">
                    New Project
                </h4>
            </button>
        </li>
        <li class="my-2">
            <button class='nav-link link-dark border-0 w-100' href="#tasksDiv" data-bs-toggle='collapse' data-bs-target='#dashboard-collapse' aria-expanded='false'>
                <h4 class="p-1 m-0"><img src="./images/icons8-task-50.png" width='32' height='32' alt="" srcset="">
                    Tasks
                </h4>
            </button>
        </li>
        <li>
            <button id="MssgActive" class='nav-link link-dark border-0 w-100' href="#chatDiv" data-bs-toggle='collapse' data-bs-target='#dashboard-collapse' aria-expanded='false'>
                <h4 class="p-1 m-0"><img src="./images/people.svg" width='32' height='32' alt="" srcset="">
                Message
                </h4>
            </button>
        </li>   
    </ul>
    <hr>
    <div class='dropdown pb-3'>
        <a class='d-flex align-items-center text-decoration-none dropdown-toggle text-secondary' id='dropdownUser2' data-bs-toggle='dropdown' aria-expanded='false'>
            <img src='<?php echo $user['profileImg']; ?>' alt='' width='42' height='42' class='rounded-circle me-2'>
            <h3 class="px-2 fs-1"><strong><?php echo $user['username']; ?></strong></h3>
        </a>
        <ul class='dropdown-menu text-small shadow' aria-labelledby='dropdownUser2'>
            <li><a class='dropdown-item' href='#'>Settings</a></li>
            <li><a class='dropdown-item' href='#'>Profile</a></li>
            <li><hr class='dropdown-divider'></li>
            <li><a class='dropdown-item' href='logout.php'>Logout</a></li>
        </ul>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
