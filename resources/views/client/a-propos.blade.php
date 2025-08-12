@extends('layouts.app')

@section('content')
    <!-- About Section -->
    <section class="about-section" id="about">
      <div class="container">
        <h2 class="fade-in parallax-slow">À Propos de YEL'S FINANCES</h2>
        <div class="about-content fade-in parallax-medium">
          <div class="about-text">
            <p>YEL'S FINANCES est votre partenaire de confiance pour l'excellence professionnelle. Nous proposons des formations de qualité dans les domaines du développement web, du marketing digital, de la data science et du design.</p>
            <p>Notre mission est de vous accompagner dans votre développement professionnel avec des programmes adaptés et des formateurs expérimentés.</p>
            <p>Fondée en 2020, notre entreprise s'est donnée pour objectif de démocratiser l'accès à une formation de qualité dans les domaines technologiques et digitaux. Nous croyons que l'éducation est la clé du succès professionnel.</p>
          </div>
          <div class="about-stats">
            <div class="stat-item">
              <h3>500+</h3>
              <p>Étudiants formés</p>
            </div>
            <div class="stat-item">
              <h3>50+</h3>
              <p>Formations disponibles</p>
            </div>
            <div class="stat-item">
              <h3>95%</h3>
              <p>Taux de satisfaction</p>
            </div>
            <div class="stat-item">
              <h3>25+</h3>
              <p>Formateurs experts</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
      <div class="container">
        <h2 class="fade-in parallax-slow">Nos Valeurs</h2>
        <div class="values-grid fade-in parallax-medium">
          <div class="value-item">
            <i class="fas fa-star"></i>
            <h3>Excellence</h3>
            <p>Nous nous engageons à fournir des formations de la plus haute qualité avec des contenus à jour et pertinents.</p>
          </div>
          <div class="value-item">
            <i class="fas fa-users"></i>
            <h3>Communauté</h3>
            <p>Nous favorisons l'apprentissage collaboratif et le partage de connaissances entre nos apprenants.</p>
          </div>
          <div class="value-item">
            <i class="fas fa-lightbulb"></i>
            <h3>Innovation</h3>
            <p>Nous adoptons les dernières technologies et méthodes d'apprentissage pour optimiser votre expérience.</p>
          </div>
          <div class="value-item">
            <i class="fas fa-heart"></i>
            <h3>Engagement</h3>
            <p>Nous nous engageons à vous accompagner jusqu'à la réussite de vos objectifs professionnels.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
      <div class="container">
        <h2 class="fade-in parallax-slow">Notre Équipe</h2>
        <div class="team-grid fade-in parallax-medium">
          <div class="team-member">
            <div class="member-avatar">
              <i class="fas fa-user"></i>
            </div>
            <h3>Jean Dupont</h3>
            <p class="member-role">Directeur Général</p>
            <p class="member-description">Expert en formation professionnelle avec plus de 15 ans d'expérience dans le secteur de l'éducation.</p>
          </div>
          <div class="team-member">
            <div class="member-avatar">
              <i class="fas fa-user"></i>
            </div>
            <h3>Marie Martin</h3>
            <p class="member-role">Responsable Pédagogique</p>
            <p class="member-description">Spécialiste en ingénierie pédagogique et en développement de programmes de formation innovants.</p>
          </div>
          <div class="team-member">
            <div class="member-avatar">
              <i class="fas fa-user"></i>
            </div>
            <h3>Pierre Durand</h3>
            <p class="member-role">Expert Technique</p>
            <p class="member-description">Développeur senior et formateur spécialisé dans les technologies web et mobiles.</p>
          </div>
        </div>
      </div>
    </section>
@endsection



