  <section class="filter-section">
      <div class="filter-row">
          <div class="filter-group">
              <label class="filter-label">Search Companies</label>
              <input type="text" id="searchFilter" class="filter-input" placeholder="Type company name or keyword...">
          </div>

          <div class="filter-group">
              <label class="filter-label">Industry</label>
              <select id="industryFilter" class="filter-select">
                  <option value="">All TESDA Industries</option>
                  @php
                      $departments = $JobPostRetrieved
                          ->where('status_post', 'published')
                          ->pluck('department')
                          ->unique();
                  @endphp

                  @foreach ($departments as $department)
                      <option value="{{ $department }}">{{ $department }}</option>
                  @endforeach

              </select>
          </div>

          <div class="filter-group">
              <label class="filter-label">Location</label>
              <select id="locationFilter" class="filter-select">
                  <option value="">All Locations</option>
                  @foreach ($JobPostRetrieved->where('status_post', 'published')->unique('location') as $location)
                      <option value="{{ $location->location }}">{{ $location->location }}</option>
                  @endforeach

              </select>
          </div>
          <button class="clear-filters" onclick="clearAllFilters()">Clear All</button>
      </div>

  </section>
