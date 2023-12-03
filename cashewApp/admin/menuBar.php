<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Phumasia cashew </a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <form method="post" class="nav-link">
                      <div class="input-group">
                      <button type="submit" class="btn btn-primary" name="but_logout">Logout</button>
                      </div>
                   </form>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading"></div>
                            <a class="nav-link" href="?Admin=summery">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Summery
                            </a>
                            <a class="nav-link" href="?Admin=expend">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-flatbed"></i></div>
                                Export
                            </a>
                            <div class="sb-sidenav-menu-heading"></div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                  Working task 
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                 <?php
                                   $task_working = "SELECT task, COUNT(*) as count FROM cashew_record WHERE task != '' GROUP BY task";
                                   $view_task_work = mysqli_query($conn, $task_working);
                                       while ($row = mysqli_fetch_assoc($view_task_work)) {
                                                $task_work = $row['task'];
                                                $count = $row['count'];
                                                echo "<a class='nav-link' href='?Admin=$task_work'>$task_work</a>";
                                        }
                                 ?>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                 Producer
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Phumasia
                                       <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                        <?php
                                        $task_working = "SELECT task, COUNT(*) as count FROM cashew_record WHERE task != '' GROUP BY task";
                                        $view_task_work = mysqli_query($conn, $task_working);
                                        while ($row = mysqli_fetch_assoc($view_task_work)) {
                                        $task_work = $row['task'];
                                        $count = $row['count'];
                                        //skip if the data has oven
                                       if ($task_work === 'Hardshell') {
                                          continue;
                                          }
                                        echo "<a class='nav-link' href='?Admin=phumasia/$task_work'>$task_work</a>";
                                        }
                                        ?>

                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                         SCY 
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <?php
                                                $task_working = "SELECT task, COUNT(*) as count FROM cashew_record WHERE task != '' GROUP BY task";
                                                $view_task_work = mysqli_query($conn, $task_working);
                                                    while ($row = mysqli_fetch_assoc($view_task_work)) {
                                                         $task_work = $row['task'];
                                                         $count = $row['count'];
                                                         if ($task_work === 'Packing' || $task_work === 'Hardshell' ) {
                                                             continue;
                                                            }
                                                        echo "<a class='nav-link' href='?Admin=scy/$task_work'>$task_work</a>";
                                                   }
                                            ?>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapsMoniHouse" aria-expanded="false" aria-controls="pagesCollapsMoniHouse">
                                         Moni's House
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapsMoniHouse" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <?php
                                                $task_working = "SELECT task, COUNT(*) as count FROM cashew_record WHERE task != '' GROUP BY task";
                                                $view_task_work = mysqli_query($conn, $task_working);
                                                    while ($row = mysqli_fetch_assoc($view_task_work)) {
                                                         $task_work = $row['task'];
                                                         $count = $row['count'];
                                                         if ($task_work === 'Hardshell' || $task_work === "Inner skin" || $task_work === "Cleaning") {
                                                            echo "<a class='nav-link' href='?Admin=moni_village/$task_work'>$task_work</a>";
                                                            }
                                                   }
                                            ?>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                     data-bs-target="#pagesCollapsspk" aria-expanded="false" aria-controls="pagesCollapsspk">
                                        SPK village
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapsspk" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <?php
                                                $task_working = "SELECT task, COUNT(*) as count FROM cashew_record WHERE task != '' GROUP BY task";
                                                $view_task_work = mysqli_query($conn, $task_working);
                                                    while ($row = mysqli_fetch_assoc($view_task_work)) {
                                                         $task_work = $row['task'];
                                                         $count = $row['count'];
                                                         if ($task_work === 'Hardshell' || $task_work === "Inner skin" || $task_work === "Cleaning") {
                                                            echo "<a class='nav-link' href='?Admin=spk_village/$task_work'>$task_work</a>";
                                                            }
                                                   }
                                            ?>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading"></div>
                            <a class="nav-link" href="?Admin=view-record">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-eye"></i></div>
                                View record
                            </a>
                            <a class="nav-link" href="?Admin=add-user">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-user-plus"></i></div>
                                Add Producer
                            </a>
                            <a class="nav-link" href="?Admin=view-user">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-eye"></i></div>
                                View Producer
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Phumasia</div>
                        Cashew Nut
                    </div>
                </nav>
            </div>
 