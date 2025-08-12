@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-content fade-in parallax-slow">
        <h1 class="hero-title">Boostez votre carrière avec des formations certifiantes et pratiques</h1>
        <p class="hero-subtitle">Accédez à des formations 100% en ligne, conçues par des experts, et reconnues dans les domaines du digital, du business et de la tech.</p>
        <div class="hero-actions">
            <a href="{{ route('client.formation') }}" class="btn btn-primary">Découvrir les formations</a>
            <a href="{{ route('client.contact') }}" class="btn btn-secondary">Nous contacter</a>
        </div>
      </div>
    </section>

    <!-- Formations Section -->
    <section class="formations-section">
      <div class="container">
        <h2 class="section-title fade-in parallax-slow">
          @if(count($formations) > 0)
            Nos Formations
          @else
            Aucune Formation Disponible
          @endif
        </h2>
        
        @if(count($formations) > 0)
          <div class="formations-grid fade-in parallax-medium">
            @foreach($formations as $formation)
              <div class="formation-card">
                <div class="formation-image" style="background-image: url('{{ $formation['image'] }}')">
                  <span class="formation-badge">{{ $formation['badge'] }}</span>
                </div>
                <div class="formation-content">
                  <h3 class="formation-title">{{ $formation['title'] }}</h3>
                  <div class="formation-meta">
                    <span><i class="fas fa-clock"></i> {{ $formation['duration'] }}</span>
                    <span><i class="fas fa-signal"></i> {{ $formation['level'] }}</span>
                    <span><i class="fas fa-users"></i> {{ $formation['students'] }}</span>
                    <span><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($formation['start_date'])->format('d/m/Y') }}</span>
                    <span><i class="fas fa-map-marker-alt"></i> {{ $formation['location'] }}</span>
                    <span><i class="fas fa-laptop"></i> {{ $formation['type'] }}</span>
                  </div>
                  <div class="formation-footer">
                    <div class="formation-price">
                      <x-price :amount="$formation['price']" currency="F CFA" />
                    </div>
                    <button class="view-more-btn" onclick="openFormationDetail({{ $formation['id'] }})">
                      <i class="fas fa-eye"></i>
                      Voir plus
                    </button>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          
          <div class="text-center mt-4">
            <a href="{{ route('client.formation') }}" class="btn btn-primary btn-lg">
              <i class="fas fa-graduation-cap me-2"></i>
              Voir Toutes les Formations
            </a>
          </div>
        @else
          <div class="text-center py-5">
            <div class="empty-state">
              <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
              <h4 class="text-muted">Aucune formation disponible pour le moment</h4>
              <p class="text-muted">Nous travaillons actuellement sur de nouvelles formations. Revenez bientôt !</p>
              <a href="{{ route('client.contact') }}" class="btn btn-outline-primary">
                <i class="fas fa-envelope me-2"></i>
                Nous Contacter
              </a>
            </div>
          </div>
        @endif
      </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
      <div class="container">
        <h2 class="section-title fade-in parallax-slow">Pourquoi nous choisir ?</h2>
        <div class="about-content fade-in parallax-medium">
          <div class="about-text">
            <p>YEL'S FINANCES est votre partenaire de confiance pour l'excellence professionnelle. Nous proposons des formations de qualité dans les domaines du développement web, du marketing digital, de la data science et du design.</p>
            <p>Notre mission est de vous accompagner dans votre développement professionnel avec des programmes adaptés et des formateurs expérimentés.</p>
            <p>Fondée en 2020, notre entreprise s'est donnée pour objectif de démocratiser l'accès à une formation de qualité dans les domaines technologiques et digitaux. Nous croyons que l'éducation est la clé du succès professionnel.</p>
          </div>
        </div>
      </div>
    </section>

    <style>
    .empty-state {
        padding: 3rem 1rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 1rem;
        border: 2px dashed #dee2e6;
    }
    
    .empty-state i {
        color: #6c757d;
        margin-bottom: 1rem;
    }
    
    .empty-state h4 {
        color: #495057;
        margin-bottom: 1rem;
    }
    
    .empty-state p {
        color: #6c757d;
        margin-bottom: 1.5rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .formations-section .btn-lg {
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .formations-section .btn-lg:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .formation-card {
        transition: all 0.3s ease;
    }
    
    .formation-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .formation-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
    }
    
    .formation-badge:empty::before {
        content: "Nouveau";
    }
    </style>
@endsection
