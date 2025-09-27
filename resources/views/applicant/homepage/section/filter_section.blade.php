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
                  @foreach ($JobPostRetrieved as $job)
                      @if ($job->status_post === 'published')
                          <option value="{{ $job->department }}">{{ $job->department }}</option>
                      @endif
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

      <!-- Filter Chips -->
      <div class="filter-chips">
          <div class="filter-chip" data-filter="hiring" onclick="toggleChip(this, 'hiring')">
              <i class="bi bi-lightning"></i> Actively Hiring
          </div>
          <div class="filter-chip" data-filter="urgent" onclick="toggleChip(this, 'urgent')">
              <i class="bi bi-lightning"></i> Urgent Hiring
          </div>

          <!-- <div class="filter-chip" data-filter="remote" onclick="toggleChip(this, 'remote')">
                        <i class="bi bi-house"></i> Remote Work
                    </div>
                    <div class="filter-chip" data-filter="featured" onclick="toggleChip(this, 'featured')">
                        <i class="bi bi-star"></i> Featured
                    </div>
                    <div class="filter-chip" data-filter="startup" onclick="toggleChip(this, 'startup')">
                        <i class="bi bi-rocket"></i> Startup
                    </div> -->
      </div>
  </section>
