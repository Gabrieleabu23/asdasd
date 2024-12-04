<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cercasi Locali</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

</head>

<body>
    <h3>Locali</h3>
    @foreach ($locali as $i => $singleLocale)
        <div class="card{{ $i }}" style="width: 80wv;height:200px">
            <div class="card-body">
                {{-- <a href="https://www.google.it/maps/place/@ {{ $singleLocale - > latitudine }},{{ $singleLocale->longitudine }}"
                    target="_blank">
                    Visualizza su Google Maps
                </a> --}}

                <?php
                $url = 'https://www.google.com/maps/search/' . urlencode($singleLocale->indirizzo) . '@';
                ?>
                <a href="{{ $url }},18z" target="_blank">
                    <h5 class="card-title">{{ $singleLocale->name }}</h5>
                </a>


                <h6 class="card-subtitle mb-2 text-muted">{{ $singleLocale->localita }}</h6>
                <p class="card-text"><strong>Indirizzo : </strong>{{ $singleLocale->indirizzo }}</p>
                <a onclick="receiveTripId({{ $singleLocale->id }})" data-bs-toggle="modal" data-bs-target="#deleteModal"
                    style="cursor: pointer;">
                    <div class="btn btn-white-custom btn-lg rounded-pill px-4 shadow" style="width: fit-content;">
                        Escludi
                    </div>
                </a>
                sd
            </div>
        </div>
        <form action="{{ route('locali.destroy') }}" method="POST" id="DestroyForm{{ $singleLocale->id }}"
            style="display:none;">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" value="{{ $singleLocale->id }}">
        </form>
    @endforeach
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white text-center flex-column">
                    <img src="https://banner2.cleanpng.com/20180528/kkq/avpgai5ax.webp" alt="Delete Icon"
                        class="img-fluid mb-2 rounded-circle border border-white" style="width: 60px;">
                    <h5 class="modal-title" id="deleteModalLabel">Conferma Eliminazione</h5>
                </div>
                <div class="modal-body text-center">
                    <p class="lead">Sei sicuro di voler eliminare questo locale?</p>
                    <p class="text-muted">Questa azione è irreversibile.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-white-custom btn-lg rounded-pill px-4 shadow"
                        data-bs-dismiss="modal">Annulla</button>
                    <button type="button" class="btn btn-danger btn-lg rounded-pill px-4" onclick="submitDestroyForm()"
                        id="confirmDeleteButton">Elimina</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function receiveTripId(id) {
        event.preventDefault();
        trip_id = id;
    }

    function submitDestroyForm() {

        event.preventDefault(); // Prevent default form submission

        document.getElementById(`DestroyForm${trip_id}`)
            .submit(); //Al submit prendo il form del destroy con l'id e submitto

    }
</script>

</html>
