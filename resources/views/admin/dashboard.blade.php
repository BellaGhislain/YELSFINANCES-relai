<base href="/">
<x-layouts>

       <div class="content container-fluid">
      <!-- Page Header -->
      <div class="page-header">
        <div class="row align-items-center mb-3">
          <div class="col-sm mb-2 mb-sm-0">
            <h1 class="page-header-title">Bonjour ! <span class="badge bg-soft-dark text-dark ms-2">Ghislain</span></h1>

            <div class="mt-2">
              <p class="page-header-text">Voici un aperçu de votre centre de formation aujourd'hui.</p>
            </div>
          </div>
          <!-- End Col -->

          <div class="col-sm-auto">
            <a class="btn btn-primary" href="formations-add.html">
              <i class="bi-plus me-1"></i>
              Ajouter une session
            </a>
          </div>
          <!-- End Col -->
        </div>
        <!-- End Row -->

        <!-- Filtres de recherche - Version collapsible -->
        <div class="mb-3">
          <!-- Bouton pour ouvrir/fermer les filtres -->
          <div class="d-flex justify-content-end mb-2">
            <button type="button" class="btn btn-outline-primary btn-sm" id="toggleFiltersBtn">
              <i class="bi-funnel me-1"></i>
              <span id="toggleFiltersText">Filtres</span>
            </button>
          </div>

          <!-- Panneau des filtres (caché par défaut) -->
          <div class="card" id="filtersPanel" style="display: none;">
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label for="formationFilter" class="form-label">Formation</label>
                  <select class="form-select form-select-sm" id="formationFilter">
                    <option value="">Toutes les formations</option>
                    <option value="web-dev">Développement Web Full-Stack</option>
                    <option value="data-science">Data Science</option>
                    <option value="design">Design UX/UI</option>
                    <option value="mobile">Développement Mobile</option>
                    <option value="marketing">Marketing Digital</option>
                  </select>
                </div>
                
                <div class="col-md-3 mb-3">
                  <label for="startDateFilter" class="form-label">Date de début</label>
                  <input type="date" class="form-control form-control-sm" id="startDateFilter">
                </div>
                
                <div class="col-md-3 mb-3">
                  <label for="endDateFilter" class="form-label">Date de fin</label>
                  <input type="date" class="form-control form-control-sm" id="endDateFilter">
                </div>
                
                <div class="col-md-3 mb-3">
                  <label for="sessionFilter" class="form-label">Session</label>
                  <select class="form-select form-select-sm" id="sessionFilter" style="display: none;">
                    <option value="">Toutes les sessions</option>
                  </select>
                  <div id="sessionFilterContainer" style="display: none;"></div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-12">
                  <button type="button" class="btn btn-primary btn-sm" id="applyFiltersBtn">
                    <i class="bi-search me-1"></i>
                    Appliquer les filtres
                  </button>
                  <button type="button" class="btn btn-outline-secondary btn-sm ms-2" id="clearFiltersBtn">
                    <i class="bi-x-circle me-1"></i>
                    Effacer les filtres
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
  <!-- KPIs -->
        <div class="row flex-nowrap">
            <div class="col-4 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card card-hover-shadow h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle">Effectifs total des apprenants</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="card-title h2 mb-0" id="learnersCount">0</span>
                            <div class="avatar avatar-sm avatar-soft-primary avatar-circle">
                                <span class="avatar-initials">
                                    <i class="bi-people"></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-soft-success text-success me-2" id="learnersGrowth">
                                <i class="bi-graph-up"></i> 0%
                            </span>
                            <span class="badge bg-soft-primary text-primary" id="learnersThisMonth">+0 ce mois</span>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Col -->

            <div class="col-4 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card card-hover-shadow h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle">Montant total des ventes</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="card-title h2 mb-0" id="totalPayments">0</span>
                            <div class="avatar avatar-sm avatar-soft-success avatar-circle">
                                <span class="avatar-initials">
                                    <i class="bi-currency-exchange"></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-soft-success text-success me-2" id="paymentsGrowth">
                                <i class="bi-graph-up"></i> 0%
                            </span>
                            <span class="badge bg-soft-primary text-primary" id="paymentsThisMonth">+0 ce mois</span>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Col -->

            <div class="col-4 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card card-hover-shadow h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle">Nombres de sessions en cours</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="card-title h2 mb-0" id="ongoingSessions">0</span>
                            <div class="avatar avatar-sm avatar-soft-warning avatar-circle">
                                <span class="avatar-initials">
                                    <i class="bi-calendar-event"></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-soft-success text-success me-2" id="sessionsGrowth">
                                <i class="bi-graph-up"></i> 0%
                            </span>
                            <span class="badge bg-soft-primary text-primary" id="sessionsThisMonth">+0 ce mois</span>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Col -->
        </div>
        <!-- End KPIs -->

    </div>
                                      <div class="d-flex align-items-center">
                  <span class="badge bg-soft-success text-success me-2">
                    <i class="bi-graph-up"></i> 2.1%
        </span>
                  <span class="badge bg-soft-primary text-primary">+1.8% ce mois</span>
          </div>
        </div>
          </div>
            <!-- End Card -->
        </div>
        <!-- End Col -->
          </div>
        <!-- End KPIs -->

        <!-- Graphiques -->
                                  <div class="row">
          <!-- Inscriptions par mois -->
          <div class="col-lg-8 mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card card-hover-shadow h-100">
                        <!-- Header -->
                        <div class="card-header">
                <h4 class="card-header-title">Evolution par formation</h4>
                <div class="card-header-actions">
                  <select class="form-select form-select-sm" id="chartFormationFilter">
                    <option value="all">Toutes les formations</option>
                    <option value="web-dev">Développement Web Full-Stack</option>
                    <option value="data-science">Data Science</option>
                    <option value="design">Design UX/UI</option>
                    <option value="mobile">Développement Mobile</option>
                    <option value="marketing">Marketing Digital</option>
                  </select>
                            </div>
                        </div>
                        <!-- End Header -->

                        <!-- Body -->
              <div class="card-body">
                <div class="chart-container" style="position: relative; height:300px;">
                  <canvas id="inscriptionsChart"></canvas>
                                        </div>
                                      </div>
                        <!-- End Body -->
                                    </div>
            <!-- End Card -->
                                    </div>
                                    <!-- End Col -->

          <!-- Répartition par catégorie -->
          <div class="col-lg-4 mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card card-hover-shadow h-100">
                        <!-- Header -->
                        <div class="card-header">
                <h4 class="card-header-title">Repartition du chiffre d'affaires par formation</h4>
                        </div>
                        <!-- End Header -->

                        <!-- Body -->
              <div class="card-body">
                <div class="chart-container" style="position: relative; height:300px;">
                  <canvas id="categoriesChart"></canvas>
                              </div>
                        </div>
                        <!-- End Body -->
                      </div>
            <!-- End Card -->
                                      </div>
                                      <!-- End Col -->
                                      </div>
        <!-- End Graphiques -->

        <!-- Tableaux de données -->
                                    <div class="row">
          <!-- Formations populaires -->
          <div class="col-12 mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card card-hover-shadow h-100">
                          <!-- Header -->
                          <div class="card-header">
                <h4 class="card-header-title">Formations les Plus Populaires</h4>
                          </div>
                          <!-- End Header -->

                          <!-- Body -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle">
                    <thead class="thead-light">
                      <tr>
                        <th>Formation</th>
                        <th>Inscriptions</th>
                        <th>Revenus</th>
                        <th>Note</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                              <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm avatar-circle me-3">
                              <img class="avatar-img" src="assets/img/400x400/img1.jpg" alt="Image Description">
                                </div>
                            <div>
                              <h6 class="mb-0">Développement Web Full-Stack</h6>
                              <small class="text-body">React & Node.js</small>
                                </div>
                              </div>
                        </td>
                        <td><span class="badge bg-soft-primary text-primary">2,450</span></td>
                        <td>2.2M €</td>
                        <td><span class="badge bg-soft-success text-success">4.8/5</span></td>
                      </tr>
                      <tr>
                        <td>
                              <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm avatar-circle me-3">
                              <img class="avatar-img" src="assets/img/400x400/img2.jpg" alt="Image Description">
                                </div>
                            <div>
                              <h6 class="mb-0">Data Science</h6>
                              <small class="text-body">Python & ML</small>
                                </div>
                              </div>
                        </td>
                        <td><span class="badge bg-soft-primary text-primary">1,890</span></td>
                        <td>1.8M €</td>
                        <td><span class="badge bg-soft-success text-success">4.7/5</span></td>
                      </tr>
                      <tr>
                        <td>
                              <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm avatar-circle me-3">
                              <img class="avatar-img" src="assets/img/400x400/img3.jpg" alt="Image Description">
                                </div>
                            <div>
                              <h6 class="mb-0">Design UX/UI</h6>
                              <small class="text-body">Figma & Adobe</small>
                                </div>
                              </div>
                        </td>
                        <td><span class="badge bg-soft-primary text-primary">1,234</span></td>
                        <td>1.1M €</td>
                        <td><span class="badge bg-soft-success text-success">4.6/5</span></td>
                      </tr>
                    </tbody>
                  </table>
                                </div>
                          </div>
                          <!-- End Body -->
                        </div>
            <!-- End Card -->
                      </div>
          <!-- End Col -->


                      </div>
        <!-- End Tableaux -->
                    </div>
      <!-- End Content -->
    </div>

    <!-- JS Implementing Plugins -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/vendor.min.js"></script>

    <!-- JS Front -->
    <script src="assets/js/theme.min.js"></script>

      <!-- Chart.js Scripts -->
  <script>


    // Fonction pour mettre à jour les données
    function updateDashboardData(formation, session = null) {
      let data;

      if (formation === 'all') {
        data = formationData.all;
      } else if (session && session !== 'all-sessions') {
        // Trouver la session spécifique
        const formationSessions = formationData[formation].sessions;
        const selectedSession = formationSessions.find(s => s.id === session);
        if (selectedSession) {
          data = selectedSession;
        } else {
          data = formationData[formation].total;
        }
      } else {
        data = formationData[formation].total;
      }

      // Mise à jour des effectifs
      const effectifsElement = document.querySelector('.card-title.h2');
      if (effectifsElement) effectifsElement.textContent = data.effectifs;

      // Mise à jour des ventes
      const ventesElement = document.querySelectorAll('.card-title.h2')[1];
      if (ventesElement) ventesElement.textContent = data.ventes;

      // Mise à jour des sessions
      const sessionsElement = document.querySelectorAll('.card-title.h2')[2];
      if (sessionsElement) sessionsElement.textContent = data.sessions;

      // Mise à jour des inscriptions
      const inscriptionsBadge = document.querySelector('.badge.bg-soft-primary.text-primary');
      if (inscriptionsBadge) inscriptionsBadge.textContent = `+${data.inscriptions} ce mois`;
    }

    // Données pour le graphique par formation
    const chartData = {
      all: {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
        data: [284, 312, 298, 345, 378, 412, 389, 423, 456, 478, 512, 534]
      },
      'web-dev': {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
        data: [45, 52, 38, 67, 52, 78, 41, 89, 95, 102, 115, 128]
      },
      'data-science': {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
        data: [28, 35, 42, 32, 48, 25, 38, 45, 52, 58, 65, 72]
      },
      'design': {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
        data: [18, 22, 18, 25, 22, 28, 32, 35, 38, 42, 45, 48]
      },
      'mobile': {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
        data: [12, 15, 18, 22, 25, 28, 32, 35, 38, 42, 45, 48]
      },
      'marketing': {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
        data: [8, 10, 12, 15, 18, 20, 22, 25, 28, 30, 32, 35]
      }
    };

    // Variable globale pour le graphique
    let inscriptionsChart;

    // Fonction pour mettre à jour le graphique
    function updateChart(formation) {
      const chartCanvas = document.getElementById('inscriptionsChart');
      if (!chartCanvas) return;

      const chartDataForFormation = chartData[formation] || chartData.all;

      if (inscriptionsChart) {
        inscriptionsChart.destroy();
      }

      inscriptionsChart = new Chart(chartCanvas, {
        type: 'line',
        data: {
          labels: chartDataForFormation.labels,
          datasets: [{
            label: formation === 'all' ? 'Inscriptions totales' : `Inscriptions - ${formationData[formation]?.formation || 'Formation'}`,
            data: chartDataForFormation.data,
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                color: 'rgba(0, 0, 0, 0.1)'
              }
            },
            x: {
              grid: {
                display: false
              }
            }
          }
        }
      });
    }

    // Écouteurs d'événements
    document.addEventListener('DOMContentLoaded', function() {
      const formationFilter = document.getElementById('formationFilter');
      const sessionFilter = document.getElementById('sessionFilter');
      const chartFormationFilter = document.getElementById('chartFormationFilter');
      const applyFiltersBtn = document.getElementById('applyFiltersBtn');
      const clearFiltersBtn = document.getElementById('clearFiltersBtn');

      // Gestion du panneau collapsible
      const toggleFiltersBtn = document.getElementById('toggleFiltersBtn');
      const filtersPanel = document.getElementById('filtersPanel');
      const toggleFiltersText = document.getElementById('toggleFiltersText');

      if (toggleFiltersBtn && filtersPanel) {
        toggleFiltersBtn.addEventListener('click', function() {
          if (filtersPanel.style.display === 'none') {
            filtersPanel.style.display = 'block';
            toggleFiltersText.textContent = 'Masquer les filtres';
            toggleFiltersBtn.classList.remove('btn-outline-primary');
            toggleFiltersBtn.classList.add('btn-primary');
          } else {
            filtersPanel.style.display = 'none';
            toggleFiltersText.textContent = 'Afficher les filtres';
            toggleFiltersBtn.classList.remove('btn-primary');
            toggleFiltersBtn.classList.add('btn-outline-primary');
          }
        });
      }

      // Initialiser le graphique avec les données globales
      updateChart('all');

      if (formationFilter) {
        formationFilter.addEventListener('change', function() {
          const selectedFormation = this.value;

          if (selectedFormation === 'all') {
            document.getElementById('sessionFilterContainer').style.display = 'none';
            updateDashboardData('all');
          } else {
            document.getElementById('sessionFilterContainer').style.display = 'none';
          }
        });
      }

      if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', function() {
          const selectedFormation = document.getElementById('formationFilter').value;
          const startDate = document.getElementById('startDateFilter').value;
          const endDate = document.getElementById('endDateFilter').value;

          if (selectedFormation !== 'all' && startDate && endDate) {
            // Afficher le filtre des sessions après la recherche
            document.getElementById('sessionFilterContainer').style.display = 'block';
          }

          // Appliquer les filtres
          applyFilters();
        });
      }

      if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function() {
          // Réinitialiser tous les filtres
          if (formationFilter) formationFilter.value = '';
          if (document.getElementById('startDateFilter')) document.getElementById('startDateFilter').value = '';
          if (document.getElementById('endDateFilter')) document.getElementById('endDateFilter').value = '';
          if (sessionFilter) sessionFilter.value = '';
          
          // Masquer le conteneur des sessions
          document.getElementById('sessionFilterContainer').style.display = 'none';
          
          // Mettre à jour le dashboard avec les données non filtrées
          updateDashboardData('all');
        });
      }

      if (sessionFilter) {
        sessionFilter.addEventListener('change', function() {
          const selectedFormation = document.getElementById('formationFilter').value;
          applyFilters();
        });
      }

      if (chartFormationFilter) {
        chartFormationFilter.addEventListener('change', function() {
          updateChart(this.value);
        });
      }
    });

    // Fonction pour appliquer les filtres
    function applyFilters() {
      const selectedFormation = document.getElementById('formationFilter')?.value || '';
      const startDate = document.getElementById('startDateFilter')?.value || '';
      const endDate = document.getElementById('endDateFilter')?.value || '';
      const selectedSession = document.getElementById('sessionFilter')?.value || '';

      console.log('Filtres appliqués:', {
        formation: selectedFormation,
        startDate: startDate,
        endDate: endDate,
        session: selectedSession
      });

      // Ici vous pouvez ajouter la logique pour filtrer les données
      // Par exemple, faire un appel AJAX pour récupérer les données filtrées
      
      // Pour l'instant, on met à jour le dashboard avec les données actuelles
      updateDashboardData(selectedFormation || 'all');
    }


    // Graphique du chiffre d'affaires par formation
    const categoriesCtx = document.getElementById('categoriesChart');
    if (categoriesCtx) {
      new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
          labels: ['Web Full-Stack', 'Data Science', 'Design UX/UI', 'Mobile', 'Marketing'],
          datasets: [{
            data: [35, 25, 20, 15, 5],
            backgroundColor: [
              '#377dff',
              '#00c9a7',
              '#ffc107',
              '#dc3545',
              '#6c757d'
            ],
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                usePointStyle: true,
                padding: 15,
                font: {
                  size: 12
                },
                generateLabels: function(chart) {
                  const data = chart.data;
                  if (data.labels.length && data.datasets.length) {
                    return data.labels.map(function(label, i) {
                      const dataset = data.datasets[0];
                      const backgroundColor = dataset.backgroundColor[i];

                      return {
                        text: label,
                        fillStyle: backgroundColor,
                        strokeStyle: backgroundColor,
                        lineWidth: 0,
                        pointStyle: 'circle',
                        hidden: false,
                        index: i
                      };
                    });
                  }
                  return [];
                }
              }
            }
          }
        }
      });
    }
    </script>

    <script>
        $(document).ready(function () {
            console.log('jQuery version:', $.fn.jquery);
            console.log('Document ready, initiating AJAX request for session stats to {{ route('admin.session-stats') }}');

            // Fonction pour charger les statistiques
            function loadSessionStats() {
                $.ajax({
                    url: "{{ route('admin.session-stats') }}",
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log('AJAX success, response:', data);
                        if (data.error) {
                            console.error('Erreur dans la réponse:', data.message);
                            return;
                        }
                        $('#learnersCount').text(data.learners_count || 0);
                        $('#learnersGrowth').html(`<i class="bi-graph-up"></i> ${data.learners_growth || 0}%`);
                        $('#learnersThisMonth').text(`+${data.learners_this_month || 0} ce mois`);

                        $('#totalPayments').text(data.total_payments || '0');
                        $('#paymentsGrowth').html(`<i class="bi-graph-up"></i> ${data.payments_growth || 0}%`);
                        $('#paymentsThisMonth').text(`+${data.payments_this_month || '0'} ce mois`);

                        $('#ongoingSessions').text(data.ongoing_sessions || 0);
                        $('#sessionsGrowth').html(`<i class="bi-graph-up"></i> ${data.sessions_growth || 0}%`);
                        $('#sessionsThisMonth').text(`+${data.sessions_this_month || 0} ce mois`);
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error:', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText,
                            statusCode: xhr.status
                        });
                        console.error('Erreur lors du chargement des statistiques. Vérifiez la route /admin/session-stats.');
                    }
                });
            }

            loadSessionStats();

            setInterval(function () {
                console.log('Refreshing session stats...');
                loadSessionStats();
            }, 60000);

            new HSSideNav('.js-navbar-vertical-aside').init();
            new HSFormSearch('.js-form-search');
            HSBsDropdown.init();
            new HsNavScroller('.js-nav-scroller');
        });
    </script>

</x-layouts>
