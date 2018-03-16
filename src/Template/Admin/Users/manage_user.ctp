<!--=============breadcrumbs==============-->      
      <div class="breadcrumbs">
        <div class="container">
          <h4>Manage Users</h4>
          <p><span>manage</span> <span>user</span></p>
        </div>
      </div>
<section class="content-wrapper content-filter">
        <!--===========filter================-->
      <div class="filters">
        <div class="container">
          <div class="filter-wrapper">
            <!--============search dropdown========-->
            <div class="search">
              <div class="form-group">
                <input type="text" class="search-box" placeholder="Search">
                <span class="clear-search hide"></span>
              </div>
            </div>
            <div class="filter-by ml-auto">
              <h4>Fillter by</h4>
              <!--============filter dropdown========-->
              <div class="filter-box">
                <div class="dropp-header js-dropp-action filter-sm">
                  <span class="dropp-header__title js-value ell">Gender </span>
                  <i class="icon icon-down-filter"></i>
                </div>
                <div class="dropp-body">
                  <div class="dropp-body-wrap">
                    <label for="optA" class="custom-label">
                      <input type="radio" id="optA" name="dropp" value="All"/>
                      <span class="ell">All</span>
                    </label>
                    <label for="optB" class="custom-label">
                      <input type="radio" id="optB" name="dropp" value="Male"/>
                      <span class="ell">Male</span>
                    </label>
                    <label for="optC" class="custom-label">
                      <input type="radio" id="optC" name="dropp" value="Female"/>
                      <span class="ell">Female</span>
                    </label>
                  </div>
                </div>
              </div>
              <!--============filter dropdown========-->
              <div class="filter-box">
                  <div class="dropp-header filter-sm">
                    <div id="datepicker2" class="input-group date">
                      <input class="from-date" type="text"  placeholder="From Date" />
                      <span class="input-group-addon datepicker-icon"></span>
                  </div>
                  </div>
  
                </div>
                <!--============filter dropdown========-->
              <div class="filter-box">
                  <div class="dropp-header filter-sm">
                    <div id="datepicker" class="input-group date">
                      <input class="from-date" type="text"  placeholder="To Date" />
                      <span class="input-group-addon datepicker-icon"></span>
                    </div>
                  </div>
                </div>
                <!--============filter dropdown========-->
                <div class="filter-box">
                  <div class="dropp-header js-dropp-action filter-sm">
                    <span class="dropp-header__title js-value ell ">Location</span>
                    <i class="icon icon-down-filter"></i>
                  </div>
                  <div class="dropp-body">
                    <div class="dropp-body-wrap">
                      <label for="locationA" class="custom-label">
                        <input type="radio" id="locationA" name="dropp" value="Location 1"/>
                        <span class="ell">Location 1</span>
                      </label>
                      <label for="locationB" class="custom-label">
                        <input type="radio" id="locationB" name="dropp" value="Location 2"/>
                        <span class="ell">Location 2</span>
                      </label>
                    </div>
                  </div>
                </div>
                <!--============filter reset========-->
                <button class="reset-filter">Reset</button>
            </div>
          </div>
        </div>
      </div>
      <!--============= table head ===================-->
      <div class="container">
        <div class="table-wrapper">
          <div class="table-head">
            <div class="head-text flex-basis15 text-left"><span class="table-filter">User Info</span></div>
            <div class="head-text flex-basis11"><span class="table-filter">Gender</span></div>
            <div class="head-text flex-basis11"><span class="table-filter">Date of Birth</span></div>
            <div class="head-text flex-basis15 text-left"><span>Location</span></div>
            <div class="head-text flex-basis9"><span>Spaycs Joined</span></div>
            <div class="head-text flex-basis9"><span>Spaycs Created</span></div>
            <div class="head-text flex-basis10"><span>Friends</span></div>
            <div class="head-text flex-basis14"><span>Advertisements</span></div>
            <div class="head-text flex-basis10"><span class="table-filter">Registration Date</span></div>
            <div class="head-text flex-basis6"><span class="blank"></span></div>
          </div>
          <!--==============table data====================-->
          <div class="table-row">
            <div class="table-data flex-basis15 text-left">
              <span class="user-name">Daniel Lloyd</span>
              <span class="ell">daniel@yahoo.com</span>
              <span class="user-contact">+1 329-245-2716</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Female</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Nov 10, 1991</span>
            </div>
            <div class="table-data flex-basis15 text-left">
              <span>7358 Schmeler Greens</span>
            </div>
            <div class="table-data flex-basis9">
              <span>10</span>
            </div>
            <div class="table-data flex-basis9">
              <span>15</span>
            </div>
            <div class="table-data flex-basis10">
              <span>105</span>
            </div>
            <div class="table-data flex-basis14">
              <span>10</span>
            </div>
            <div class="table-data flex-basis10">
              <span>Apr 12, 2017</span>
            </div>
            <!--table dropdown-->
            <div class="table-data flex-basis6">
              <div class="dropdown table-view-dropdown">
                <div class="table-dropdown"  id="table-data-dropdown" data-toggle="dropdown">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
                <div class="dropdown-menu" aria-labelledby="table-data-dropdown">
                  <button class="dropdown-item block"> <i class="icon-block"></i>Block</button>
                </div>
              </div>
            </div>
          </div>
          <!--==============table data====================-->
          <div class="table-row">
            <div class="table-data flex-basis15 text-left">
              <span class="user-name">Daniel Lloyd</span>
              <span class="ell">daniel@yahoo.com</span>
              <span class="user-contact">+1 329-245-2716</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Female</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Nov 10, 1991</span>
            </div>
            <div class="table-data flex-basis15 text-left">
              <span>7358 Schmeler Greens</span>
            </div>
            <div class="table-data flex-basis9">
              <span>10</span>
            </div>
            <div class="table-data flex-basis9">
              <span>15</span>
            </div>
            <div class="table-data flex-basis10">
              <span>105</span>
            </div>
            <div class="table-data flex-basis14">
              <span>10</span>
            </div>
            <div class="table-data flex-basis10">
              <span>Apr 12, 2017</span>
            </div>
            <!--table dropdown-->
            <div class="table-data flex-basis6">
              <div class="dropdown table-view-dropdown">
                <div class="table-dropdown"  id="table-data-dropdown" data-toggle="dropdown">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
                <div class="dropdown-menu" aria-labelledby="table-data-dropdown">
                  <button class="dropdown-item block"> <i class="icon-block"></i>Block</button>
                </div>
              </div>
            </div>
          </div>
          <!--==============table data====================-->
          <div class="table-row">
            <div class="table-data flex-basis15 text-left">
              <span class="user-name">Daniel Lloyd</span>
              <span class="ell">daniel@yahoo.com</span>
              <span class="user-contact">+1 329-245-2716</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Female</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Nov 10, 1991</span>
            </div>
            <div class="table-data flex-basis15 text-left">
              <span>7358 Schmeler Greens</span>
            </div>
            <div class="table-data flex-basis9">
              <span>10</span>
            </div>
            <div class="table-data flex-basis9">
              <span>15</span>
            </div>
            <div class="table-data flex-basis10">
              <span>105</span>
            </div>
            <div class="table-data flex-basis14">
              <span>10</span>
            </div>
            <div class="table-data flex-basis10">
              <span>Apr 12, 2017</span>
            </div>
            <!--table dropdown-->
            <div class="table-data flex-basis6">
              <div class="dropdown table-view-dropdown">
                <div class="table-dropdown"  id="table-data-dropdown" data-toggle="dropdown">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
                <div class="dropdown-menu" aria-labelledby="table-data-dropdown">
                  <button class="dropdown-item block"> <i class="icon-block"></i>Block</button>
                </div>
              </div>
            </div>
          </div>
          <!--==============table data====================-->
          <div class="table-row">
            <div class="table-data flex-basis15 text-left">
              <span class="user-name">Daniel Lloyd</span>
              <span class="ell">daniel@yahoo.com</span>
              <span class="user-contact">+1 329-245-2716</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Female</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Nov 10, 1991</span>
            </div>
            <div class="table-data flex-basis15 text-left">
              <span>7358 Schmeler Greens</span>
            </div>
            <div class="table-data flex-basis9">
              <span>10</span>
            </div>
            <div class="table-data flex-basis9">
              <span>15</span>
            </div>
            <div class="table-data flex-basis10">
              <span>105</span>
            </div>
            <div class="table-data flex-basis14">
              <span>10</span>
            </div>
            <div class="table-data flex-basis10">
              <span>Apr 12, 2017</span>
            </div>
            <!--table dropdown-->
            <div class="table-data flex-basis6">
              <div class="dropdown table-view-dropdown">
                <div class="table-dropdown"  id="table-data-dropdown" data-toggle="dropdown">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
                <div class="dropdown-menu" aria-labelledby="table-data-dropdown">
                  <button class="dropdown-item block"> <i class="icon-block"></i>Block</button>
                </div>
              </div>
            </div>
          </div>
          <!--==============table data====================-->
          <div class="table-row">
            <div class="table-data flex-basis15 text-left">
              <span class="user-name">Daniel Lloyd</span>
              <span class="ell">daniel@yahoo.com</span>
              <span class="user-contact">+1 329-245-2716</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Female</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Nov 10, 1991</span>
            </div>
            <div class="table-data flex-basis15 text-left">
              <span>7358 Schmeler Greens</span>
            </div>
            <div class="table-data flex-basis9">
              <span>10</span>
            </div>
            <div class="table-data flex-basis9">
              <span>15</span>
            </div>
            <div class="table-data flex-basis10">
              <span>105</span>
            </div>
            <div class="table-data flex-basis14">
              <span>10</span>
            </div>
            <div class="table-data flex-basis10">
              <span>Apr 12, 2017</span>
            </div>
            <!--table dropdown-->
            <div class="table-data flex-basis6">
              <div class="dropdown table-view-dropdown">
                <div class="table-dropdown"  id="table-data-dropdown" data-toggle="dropdown">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
                <div class="dropdown-menu" aria-labelledby="table-data-dropdown">
                  <button class="dropdown-item block"> <i class="icon-block"></i>Block</button>
                </div>
              </div>
            </div>
          </div>
          <!--==============table data====================-->
          <div class="table-row">
            <div class="table-data flex-basis15 text-left">
              <span class="user-name">Daniel Lloyd</span>
              <span class="ell">daniel@yahoo.com</span>
              <span class="user-contact">+1 329-245-2716</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Female</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Nov 10, 1991</span>
            </div>
            <div class="table-data flex-basis15 text-left">
              <span>7358 Schmeler Greens</span>
            </div>
            <div class="table-data flex-basis9">
              <span>10</span>
            </div>
            <div class="table-data flex-basis9">
              <span>15</span>
            </div>
            <div class="table-data flex-basis10">
              <span>105</span>
            </div>
            <div class="table-data flex-basis14">
              <span>10</span>
            </div>
            <div class="table-data flex-basis10">
              <span>Apr 12, 2017</span>
            </div>
            <!--table dropdown-->
            <div class="table-data flex-basis6">
              <div class="dropdown table-view-dropdown">
                <div class="table-dropdown"  id="table-data-dropdown" data-toggle="dropdown">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
                <div class="dropdown-menu" aria-labelledby="table-data-dropdown">
                  <button class="dropdown-item block"> <i class="icon-block"></i>Block</button>
                </div>
              </div>
            </div>
          </div>
          <!--==============table data====================-->
          <div class="table-row">
            <div class="table-data flex-basis15 text-left">
              <span class="user-name">Daniel Lloyd</span>
              <span class="ell">daniel@yahoo.com</span>
              <span class="user-contact">+1 329-245-2716</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Female</span>
            </div>
            <div class="table-data flex-basis11">
              <span>Nov 10, 1991</span>
            </div>
            <div class="table-data flex-basis15 text-left">
              <span>7358 Schmeler Greens</span>
            </div>
            <div class="table-data flex-basis9 curser">
              <span>10</span>
            </div>
            <div class="table-data flex-basis9">
              <span>15</span>
            </div>
            <div class="table-data flex-basis10">
              <span>105</span>
            </div>
            <div class="table-data flex-basis14">
              <span>10</span>
            </div>
            <div class="table-data flex-basis10">
              <span>Apr 12, 2017</span>
            </div>
            <!--table dropdown-->
            <div class="table-data flex-basis6">
              <div class="dropdown table-view-dropdown">
                <div class="table-dropdown"  id="table-data-dropdown" data-toggle="dropdown">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
                <div class="dropdown-menu" aria-labelledby="table-data-dropdown">
                  <button class="dropdown-item block"> <i class="icon-block"></i>Block</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--===========pagination========-->
        <ul class="pagination table-pagination">
          <li><a href="#" class="prev"></a></li>
          <li><a href="#" class="active">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#">5</a></li>
          <li><a class="next" href="#"></a></li>
        </ul>
      </div>
</section>