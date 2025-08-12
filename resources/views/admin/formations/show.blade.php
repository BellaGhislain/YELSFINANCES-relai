<base href="/">
<x-layouts>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">Détails de la formation</h1>
                </div>
                <div class="col-auto">
                    <a class="btn btn-outline-primary" href="{{ route('admin.formations') }}">
                        <i class="bi-arrow-left me-1"></i> Retour
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="row justify-content-center">
            <div class="col-lg-10 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">{{ $formation->name }}</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Nom -->
                        <div class="mb-4">
                            <label class="form-label"><strong>Nom (titre) de la formation</strong></label>
                            <p class="form-control-plaintext">{{ $formation->name }}</p>
                        </div>

                        <!-- Niveau -->
                        <div class="mb-4">
                            <label class="form-label"><strong>Niveau</strong></label>
                            <p class="form-control-plaintext">{{ ucfirst($formation->level) }}</p>
                        </div>



                        <!-- Compétences -->
                        <div class="mb-4">
                            <label class="form-label"><strong>Compétences acquises</strong></label>
                            @if($formation->skills->isNotEmpty())
                                <ul class="list-group">
                                    @foreach($formation->skills as $skill)
                                        <li class="list-group-item">{{ $skill->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="form-control-plaintext text-muted">Aucune compétence associée.</p>
                            @endif
                        </div>

                        <!-- Présentation -->
                        <div class="mb-4">
                            <label class="form-label"><strong>Présentation de la formation</strong></label>
                            <p class="form-control-plaintext">{!! nl2br(e($formation->presentation)) !!}</p>
                        </div>

                        <!-- Card: Médias -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h4 class="card-header-title">Médias</h4>
                            </div>
                            <div class="card-body">
                                <!-- YouTube Link -->
                                <div class="mb-4">
                                    <label class="form-label"><strong>Lien de la vidéo YouTube</strong></label>
                                    <p class="form-control-plaintext">
                                        <a href="{{ $formation->youtube_link }}" target="_blank">{{ $formation->youtube_link }}</a>
                                    </p>
                                </div>

                                <!-- Photo -->
                                <div class="mb-4">
                                    <label class="form-label"><strong>Photo de la formation</strong></label>
                                    @if($formation->photo)
                                        <div>
                                            <img src="{{ Storage::url($formation->photo) }}" alt="Photo de la formation" class="img-fluid" style="max-width: 300px;">
                                        </div>
                                    @else
                                        <p class="form-control-plaintext text-muted">Aucune photo disponible.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- End Card -->

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.formations') }}" class="btn btn-white">Retour</a>
                        </div>
                        <!-- End Buttons -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>
</x-layouts>
