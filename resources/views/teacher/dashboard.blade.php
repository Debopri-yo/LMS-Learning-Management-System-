<!-- Enhanced Teacher Dashboard -->
<div class="dashboard-container">
  <!-- Header Section -->
  <div class="dashboard-header">
    <div class="welcome-section">
      <h1 class="welcome-title">Welcome back, {{ $teacher->name }}! 👋</h1>
      <p class="welcome-subtitle">Ready to inspire minds today?</p>
    </div>
    <div class="quick-stats">
      <div class="stat-card">
        <div class="stat-number">{{ $courses->count() }}</div>
        <div class="stat-label">Active Courses</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $totalStudents ?? 0 }}</div>
        <div class="stat-label">Total Students</div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="dashboard-content">
    @if($courses->count())
      <div class="section-header">
        <h2 class="section-title">Your Courses</h2>
        <button class="btn btn-create">
          <i class="icon-plus"></i>
          Create New Course
        </button>
      </div>

      <div class="courses-grid">
        @foreach($courses as $course)
          <div class="course-card">
            <div class="course-header">
              <div class="course-avatar">
                {{ substr($course->name, 0, 2) }}
              </div>
              <div class="course-info">
                <h3 class="course-title">{{ $course->name }}</h3>
                <p class="course-meta">
                   <span class="separator">•</span>
                  <span class="last-updated">Updated {{ $course->updated_at->diffForHumans() ?? 'recently' }}</span>
                </p>
              </div>
            </div>

            <div class="course-actions">
              <a href="{{ route('teacher.courses.contents.create', $course->id) }}" 
                 class="btn btn-primary">
                <i class="icon-edit"></i>
                Manage Content
              </a>
              
              <button class="btn btn-icon" title="More options">
                <i class="icon-more"></i>
              </button>
            </div>

            <div class="course-progress">
              <div class="progress-bar">
                <div class="progress-fill" style="width: {{ rand(40, 95) }}%"></div>
              </div>
              <span class="progress-text">Course Progress</span>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="empty-state">
        <div class="empty-icon">📚</div>
        <h3 class="empty-title">No courses yet</h3>
        <p class="empty-description">Start your teaching journey by creating your first course</p>
        <button class="btn btn-primary btn-large">
          <i class="icon-plus"></i>
          Create Your First Course
        </button>
      </div>
    @endif
  </div>
</div>

<style>
:root {
  --gunmetal: #292936;
  --robin-egg-blue: #4ECDC4;
  --gunmetal-light: #3a3b4a;
  --gunmetal-dark: #1f202a;
  --robin-egg-blue-light: #6fd6cc;
  --robin-egg-blue-dark: #3bb8ad;
  --white: #ffffff;
  --gray-50: #f9fafb;
  --gray-100: #f3f4f6;
  --gray-200: #e5e7eb;
  --gray-300: #d1d5db;
  --gray-600: #4b5563;
  --gray-700: #374151;
  --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.dashboard-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
  background: var(--gray-50);
  min-height: 100vh;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 2.5rem;
  padding: 2rem;
  background: linear-gradient(135deg, var(--gunmetal) 0%, var(--gunmetal-light) 100%);
  border-radius: 1rem;
  color: var(--white);
  box-shadow: var(--shadow-lg);
}

.welcome-section {
  flex: 1;
}

.welcome-title {
  font-size: 2rem;
  font-weight: 700;
  margin: 0 0 0.5rem 0;
  color: var(--white);
}

.welcome-subtitle {
  font-size: 1.1rem;
  opacity: 0.9;
  margin: 0;
}

.quick-stats {
  display: flex;
  gap: 1.5rem;
}

.stat-card {
  background: rgba(255, 255, 255, 0.1);
  padding: 1.5rem;
  border-radius: 0.75rem;
  text-align: center;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-number {
  font-size: 2rem;
  font-weight: 700;
  color: var(--robin-egg-blue);
  line-height: 1;
}

.stat-label {
  font-size: 0.875rem;
  opacity: 0.9;
  margin-top: 0.25rem;
}

.dashboard-content {
  background: var(--white);
  border-radius: 1rem;
  padding: 2rem;
  box-shadow: var(--shadow-md);
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.section-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--gunmetal);
  margin: 0;
}

.courses-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 1.5rem;
}

.course-card {
  background: var(--white);
  border: 1px solid var(--gray-200);
  border-radius: 0.75rem;
  padding: 1.5rem;
  transition: all 0.2s ease;
  box-shadow: var(--shadow-sm);
}

.course-card:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-lg);
  border-color: var(--robin-egg-blue);
}

.course-header {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.course-avatar {
  width: 3rem;
  height: 3rem;
  background: linear-gradient(135deg, var(--robin-egg-blue), var(--robin-egg-blue-light));
  border-radius: 0.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  color: var(--white);
  font-size: 0.875rem;
  text-transform: uppercase;
}

.course-info {
  flex: 1;
}

.course-title {
  font-size: 1.125rem;
  font-weight: 600;
  color: var(--gunmetal);
  margin: 0 0 0.5rem 0;
}

.course-meta {
  font-size: 0.875rem;
  color: var(--gray-600);
  margin: 0;
}

.separator {
  margin: 0 0.5rem;
}

.course-actions {
  display: flex;
  gap: 0.75rem;
  margin-bottom: 1rem;
}

.course-progress {
  margin-top: 1rem;
}

.progress-bar {
  height: 0.5rem;
  background: var(--gray-200);
  border-radius: 0.25rem;
  overflow: hidden;
  margin-bottom: 0.5rem;
}

.progress-fill {
  height: 100%;
  background: linear-gradient(90deg, var(--robin-egg-blue), var(--robin-egg-blue-light));
  transition: width 0.3s ease;
}

.progress-text {
  font-size: 0.75rem;
  color: var(--gray-600);
}

.btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 500;
  text-decoration: none;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-primary {
  background: var(--robin-egg-blue);
  color: var(--white);
}

.btn-primary:hover {
  background: var(--robin-egg-blue-dark);
  transform: translateY(-1px);
}

.btn-secondary {
  background: var(--gray-100);
  color: var(--gray-700);
}

.btn-secondary:hover {
  background: var(--gray-200);
}

.btn-create {
  background: var(--gunmetal);
  color: var(--white);
}

.btn-create:hover {
  background: var(--gunmetal-light);
}

.btn-icon {
  padding: 0.5rem;
  background: transparent;
  color: var(--gray-600);
}

.btn-icon:hover {
  background: var(--gray-100);
}

.btn-large {
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
}

.empty-state {
  text-align: center;
  padding: 4rem 2rem;
}

.empty-icon {
  font-size: 4rem;
  margin-bottom: 1rem;
}

.empty-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--gunmetal);
  margin: 0 0 0.5rem 0;
}

.empty-description {
  font-size: 1rem;
  color: var(--gray-600);
  margin: 0 0 2rem 0;
}

/* Icons (using text symbols for simplicity) */
.icon-plus::before { content: "+"; }
.icon-edit::before { content: "✏️"; }
.icon-users::before { content: "👥"; }
.icon-more::before { content: "⋯"; }

/* Responsive */
@media (max-width: 768px) {
  .dashboard-container {
    padding: 1rem;
  }
  
  .dashboard-header {
    flex-direction: column;
    gap: 1.5rem;
  }
  
  .quick-stats {
    width: 100%;
    justify-content: center;
  }
  
  .courses-grid {
    grid-template-columns: 1fr;
  }
  
  .section-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }
  
  .course-actions {
    flex-wrap: wrap;
  }
}
</style>