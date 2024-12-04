@extends('layouts.main')

@section('container')
    <section>
        <div class="container">
            <div class="row my-5">
                <div class="page-header text-center">
                    <div class="container">
                        <h2 class="mx-auto fw-bolder">Bengkulu University Facility</h2>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                @foreach ($facilities as $facility)
                    <div class="container">
                        <div class="row">
                            <div class="col text-center">
                                <div id="{{ $facility->slug }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        {{-- Process multiple images --}}
                                        @foreach (explode(', ', $facility->image) as $index => $image)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('Assets/' . $image) }}" class="d-block w-100 rounded"
                                                    alt="{{ $facility->name }}-{{ $index + 1 }}" width="300"
                                                    height="300">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#{{ $facility->slug }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#{{ $facility->slug }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col">
                                <div class="container">
                                    <h4>{{ $facility->name }}</h4>
                                    <div class="info">
                                        @auth
                                        @endauth
                                        <p>
                                            {{ $facility->description }}
                                        </p>
                                        {{-- <a class="btn btn-danger" onclick="openMoreInfoModal()">More Info</a> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="text-white py-1 pl-1 my-5" style="background-color: #03045e;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center">
                {!! $facilities->links() !!}
            </div>
        </div>
    </section>
    <script>
        // Loop through each element with the class "formatted-price"
        document.querySelectorAll('.formatted-price').forEach(function(element) {
            // Retrieve the raw price value from the data-raw-price attribute
            var rawPrice = element.getAttribute('data-raw-price');

            // Format the price using the formatCurrency function
            var formattedPrice = formatCurrency(rawPrice);

            // Replace the element text with the formatted price
            element.innerText = formattedPrice;
        });

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(amount);
        }
    </script>
@endsection
