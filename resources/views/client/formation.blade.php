@extends('layouts.app')

@section('content')




    <!-- Formations Grid -->
    <section class="formations-grid formations-section parallax-container">
      <div class="container">
        <div class="grid fade-in" id="formationsGrid">
          <!-- Les formations seront générées par JavaScript -->
        </div>
      </div>
    </section>

    <!-- Formation Detail Modal -->
    <div class="modal" id="formationModal">
      <div class="modal-content formation-detail">
        <button class="close-btn" id="closeFormationBtn">
          <i class="fas fa-times"></i>
        </button>
        <div class="formation-detail-content" id="formationDetailContent">
          <!-- Le contenu sera généré par JavaScript -->
        </div>
      </div>
    </div>
@endsection

